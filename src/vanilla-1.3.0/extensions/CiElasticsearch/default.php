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
require(__DIR__.'/src/ConstructionsIncongrues/Vanilla/Elastica/Client.php');

// TODO : move delegate functions to dedicated file

/**
 * Injects an Elasticsearch powered discussion manager.
 */
function CiElasticsearch_DiscussionGrid_PreDataLoad(\DiscussionGrid $discussionGrid)
{
	// Instanciate and configure ES client
	// TODO : configuration via parameters (http://elastica.io/en/installation)
	$esClient = new \ConstructionsIncongrues\Vanilla\Elastica\Client();

	// Subscribe to DiscussionGrid.PreDataLoad delegate
	$discussionGrid->DelegateParameters['DiscussionManager'] = $discussionGrid->Context->ObjectFactory->NewContextObject(
		$discussionGrid->Context, 
		"\ConstructionsIncongrues\Vanilla\DiscussionManager",
		$esClient
	);
}

/**
 * Saves discussion to Elastic Search index.
 */
function CiElasticsearch_DiscussionManager_PostSaveDiscussion(\DiscussionManager $discussionManager)
{
	// Save discussion to Elastic Search index
	$discussion = $discussionManager->DelegateParameters['Discussion'];
	// TODO : configuration via parameters
	$esClient = new \ConstructionsIncongrues\Vanilla\Elastica\Client();
	// TODO : configurable index name
	// TODO : ES client should be injected in manager class
	$esClient->saveDiscussion($discussion, 'mi-discussion');
}

/**
 * Switches a discussion property.
 */
function CiElasticsearch_DiscussionManager_PostDiscussionSwitch(\DiscussionManager $discussionManager)
{
	// Save discussion to Elastic Search index
	$discussionId = $discussionManager->DelegateParameters['DiscussionID'];
	// TODO : configuration via parameters
	$esClient = new \ConstructionsIncongrues\Vanilla\Elastica\Client();
	// TODO : configurable index name
	// TODO : ES client should be injected in manager class
	$esClient->switchDiscussionProperty(
		$discussionId, 
		$discussionManager->DelegateParameters['PropertyName'], 
		$discussionManager->DelegateParameters['Switch'], 
		'mi-discussion'
	);
}

// Register delegates
$Context->AddToDelegate('DiscussionGrid', 'PreDataLoad', 'CiElasticsearch_DiscussionGrid_PreDataLoad');
$Context->AddToDelegate('DiscussionManager', 'PostSaveDiscussion', 'CiElasticsearch_DiscussionManager_PostSaveDiscussion');
$Context->AddToDelegate('DiscussionManager', 'PostDiscussionSwitch', 'CiElasticsearch_DiscussionManager_PostDiscussionSwitch');
