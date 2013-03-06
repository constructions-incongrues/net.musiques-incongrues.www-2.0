<?php
// Composer autoload
require($Context->Configuration['APPLICATION_PATH'].'/../../vendor/autoload.php');

/**
 * Helper function to be used in templates.
 * eg. in menu.php : CiTwigRender(__FILE__, $this);
 */
function CiTwigRender($path, $control)
{
	echo $control->Context->Twig->render(basename($path), array('self' => $control)); 
}

// Instanciate and configure Twig loader
// TODO : handle debug mode
// TODO : inject common context values (request, etc)
// TODO : rename "views" folder to "templates/twig" or similar
// TODO : allow extensions to declare more twig paths for cascading
$twig = new \Twig_Environment(new \Twig_Loader_Filesystem(__DIR__.'/themes/vanilla/views'));

// Add functions
// TODO : make list configurable
$twigImportFunctions = array('AppendUrlParameters', 'GetRequestUri', 'GetDynamicCheckBox','ForceIncomingString', 'GetUrl');
foreach ($twigImportFunctions as $functionName) {
	$twig->addFunction(new Twig_SimpleFunction($functionName, function () use ($functionName) {
		return call_user_func_array($functionName, func_get_args());
	}));
}

// Add Twig instance to context object
$Context->Twig = $twig;
