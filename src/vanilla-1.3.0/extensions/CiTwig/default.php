<?php
// Composer autoload
require($Context->Configuration['APPLICATION_PATH'].'/../../vendor/autoload.php');

// Instanciate and configure Twig loader
// TODO : handle debug mode
// TODO : inject common context values (request, etc)
$twig = new \Twig_Environment(new \Twig_Loader_Filesystem(__DIR__.'/themes/vanilla/views'));

// Add functions
// TODO : make list configurable
$twigImportFunctions = array('AppendUrlParameters', 'GetRequestUri');
foreach ($twigImportFunctions as $functionName) {
	$twig->addFunction(new Twig_SimpleFunction($functionName, function () use ($functionName) {
		return call_user_func_array($functionName, func_get_args());
	}));
}

// Add Twig instance to context object
$Context->Twig = $twig;
