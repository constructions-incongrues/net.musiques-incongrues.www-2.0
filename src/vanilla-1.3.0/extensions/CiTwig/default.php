<?php
// Composer autoload
require($Context->Configuration['APPLICATION_PATH'].'/../../vendor/autoload.php');

// TODO : PSR-0
require($Context->Configuration['LIBRARY_PATH'].'Vanilla/Vanilla.Class.CategoryManager.php');
require(__DIR__.'/src/ConstructionsIncongrues/Vanilla/CategoryManager.php');
require($Context->Configuration['LIBRARY_PATH'].'Vanilla/Vanilla.Class.CommentManager.php');
require(__DIR__.'/src/ConstructionsIncongrues/Vanilla/CommentManager.php');
require($Context->Configuration['LIBRARY_PATH'].'Vanilla/Vanilla.Class.DiscussionManager.php');
require(__DIR__.'/src/ConstructionsIncongrues/Vanilla/DiscussionManager/ArrayDiscussionManager.php');

/**
 * Helper function to be used in templates.
 * eg. in menu.php : CiTwigRender(__FILE__, $this);
 */
function CiTwigRender($path, $control, $additionalContext = array())
{
	echo $control->Context->Twig->render(basename($path), array_merge(array('self' => $control), $additionalContext)); 
}

// Instanciate and configure Twig loader
// TODO : handle debug mode
// TODO : inject common context values (request, etc)
// TODO : rename "views" folder to "templates/twig" or similar
// TODO : allow extensions to declare more twig paths for cascading
$twig = new \Twig_Environment(new \Twig_Loader_Filesystem(__DIR__.'/themes/vanilla/views'));

// Add functions
// TODO : make list configurable
// TODO : alpha sort
$twigImportFunctions = array(
	'AppendUrlParameters',
	'CiTwigRender',
	'CleanupString',
	'DiscussionPrefix',
	'FlipBool',
	'ForceBool',
	'ForceIncomingBool',
	'ForceIncomingInt',
	'ForceIncomingString', 
	'FormatHyperlink',
	'FormatStringForDisplay',
	'GetBasicCheckBox',
	'GetDynamicCheckBox',
	'GetLastCommentQuerystring',
	'GetPostFormatting',
	'GetUnreadQuerystring',
	'GetEmail',
	'GetRequestUri', 
	'GetUrl', 
	'ReturnNonEmpty', 
	'ThemeFilePath',
	'TimeDiff',
);
foreach ($twigImportFunctions as $functionName) {
	$twig->addFunction(new Twig_SimpleFunction($functionName, function () use ($functionName) {
		return call_user_func_array($functionName, func_get_args());
	}));
}

// Add Twig instance to context object
$Context->Twig = $twig;

// Delegate functions
// TODO : move those to dedicated file

/**
 * Injects custom CategoryManager.
 */
function CiTwig_CategoryList_PreDataLoad(\CategoryList $categoryList)
{
	// Inject our own CategoryManager
	$categoryList->DelegateParameters['CategoryManager'] = $categoryList->Context->ObjectFactory->NewContextObject(
		$categoryList->Context, 
		"\ConstructionsIncongrues\Vanilla\CategoryManager"
	);
}

/**
 * Injects custom CommentManager.
 */
function CiTwig_CommentGrid_PreDataLoad(\CommentGrid $commentGrid)
{
	// Inject our own CommentManager
	$commentGrid->DelegateParameters['CommentManager'] = $commentGrid->Context->ObjectFactory->NewContextObject(
		$commentGrid->Context, 
		"\ConstructionsIncongrues\Vanilla\CommentManager"
	);
}

/**
 * Injects custom DiscussionManager.
 */
function CiTwig_DiscussionGrid_PreDataLoad(\DiscussionGrid $discussionGrid)
{
	// Inject our own DiscussionManager
	$discussionGrid->DelegateParameters['DiscussionManager'] = $discussionGrid->Context->ObjectFactory->NewContextObject(
		$discussionGrid->Context, 
		"\ConstructionsIncongrues\Vanilla\DiscussionManager\ArrayDiscussionManager"
	);
}

// Register delegates
$Context->AddToDelegate('CategoryList', 'PreDataLoad', 'CiTwig_CategoryList_PreDataLoad');
$Context->AddToDelegate('CommentGrid', 'PreDataLoad', 'CiTwig_CommentGrid_PreDataLoad');
$Context->AddToDelegate('DiscussionGrid', 'PreDataLoad', 'CiTwig_DiscussionGrid_PreDataLoad');
