<?php
/*
Extension Name: CiElasticsearch
Extension Url: http://www.github.com/constructions-incongrues/TODO
Description: Makes it possible to use Elasticsearch to display discussions and search forum.
Version: 0.1
Author: Constructions Incongrues
Author Url: http://www.constructions-incongrues.net
*/

// Composer autoload
require($Context->Configuration['APPLICATION_PATH'].'/../../vendor/autoload.php');

// TODO : PSR-0
require($Context->Configuration['LIBRARY_PATH'].'/Vanilla/Vanilla.Class.DiscussionManager.php');
require(__DIR__.'/src/ConstructionsIncongrues/Vanilla/DiscussionManager.php');

/**
 * Injects an Elasticsearch powered discussion manager.
 */
function CiElasticsearch_DiscussionGrid_PreDataLoad(\DiscussionGrid $discussionGrid)
{
	// Instanciate and configure ES client
	// TODO : configuration via parameters (http://elastica.io/en/installation)
	$esClient = new \Elastica\Client();

	// Subscribe to DiscussionGrid.PreDataLoad delegate
	$discussionGrid->DelegateParameters['DiscussionManager'] = $discussionGrid->Context->ObjectFactory->NewContextObject(
		$discussionGrid->Context, 
		"\ConstructionsIncongrues\Vanilla\DiscussionManager",
		$esClient
	);
}

// Register delegates
$Context->AddToDelegate('DiscussionGrid', 'PreDataLoad', 'CiElasticsearch_DiscussionGrid_PreDataLoad');
