<?php
// Composer autoload
require($Context->Configuration['APPLICATION_PATH'].'/../../vendor/autoload.php');

// Instanciate and configure Twig loader
// TODO : handle debug mode
$Context->Twig = new \Twig_Environment(new \Twig_Loader_Filesystem(__DIR__.'/themes/vanilla/views'));
