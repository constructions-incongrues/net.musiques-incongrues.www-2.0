<?php
namespace ConstructionsIncongrues\Vanilla;

// Uses
use \Elastica\Client;
use \Elastica\Query;
use \Elastica\Query\QueryString;
use \Elastica\Query\Filtered;
use \Elastica\Filter\Term;
use \Elastica\Filter\BoolAnd;

class DiscussionManager extends \DiscussionManager
{
	/**
	 * @var \Elastica\Client
	 */
	private $esClient;

	public function __construct(\Context $context, \Elastica\Client $esClient)
	{
		// Execute parent class constructor logic
		parent::__construct($context);

		// Store ES client
		$this->esClient = $esClient;
	}

	/**
	 * Queries Elasticsearch server for a list of discussions.
	 *
	 * @return array[stdClass] Discussions list
	 */
	public function GetDiscussionList($RowsPerPage, $CurrentPage, $CategoryID)
	{
		// Process category
		$CategoryID = $this->processCategoryID($CategoryID);

		// ES index
		// TODO : configurable index name
		$indexDiscussions = $this->esClient->getIndex('mi-discussion');

		// Build query
		$query = new Query();

		// Call delegates
		$this->DelegateParameters["SqlBuilder"] = null;
		$this->DelegateParameters["ElasticsearchQuery"] = $query;
		$this->CallDelegate('PreGetDiscussionList');

		// Do not show hidden discussions to users who are not allowed to
		$esFilterAnd = new BoolAnd();
		if (!$this->Context->Session->User->Permission('PERMISSION_VIEW_HIDDEN_DISCUSSIONS')
			|| !$this->Context->Session->User->Preference('ShowDeletedDiscussions')) {
			// $filterActive = new Term(array('Active' => 1));
		}
		if (isset($filterActive)) {
			$esFilterAnd->addFilter($filterActive);
		}

		// Restrict to category
		if (count($CategoryID) === 1) {
			$filterCategory = new Term(array('CategoryID' => $CategoryID[0]));
		} elseif(count($CategoryID) > 1) {
			// TODO : convert to ES syntax
			// $s->AddWhere('t', 'CategoryID', '', '('. implode(',', $CategoryID) .')', 'IN');
		}
		if (isset($filterCategory)) {
			$esFilterAnd->addFilter($filterCategory);
		}

		// TODO : reproduce initial logic
		// TODO : then implement facets !
		$queryTerm = new \Elastica\Query\Term(array('name' => '*'));

		// Build final query object
		// $query->setFilter($esFilterAnd);
		$queryConstantScore = new \Elastica\Query\ConstantScore($filterCategory);
		$query->setQuery($queryConstantScore);

		// Sorting
		$sort = array('DateLastActive' => array('order' => 'desc'));
		$query->setSort($sort);

		// Pagination
		$query->setFrom(($CurrentPage - 1) * $RowsPerPage);
		$query->setLimit($RowsPerPage);

		print_r($query->toArray());

		// Perform search
		$results = $indexDiscussions->search($query);

		// Build discussions array
		$discussions = array();
		foreach ($results as $result) {
			$data = $result->getData();

			// Convert dates to something Vanilla understands
			$data['DateCreated'] = $this->fixDateTime($data['DateCreated']);
			$data['DateLastActive'] = $this->fixDateTime($data['DateLastActive']);

			// Fix encoding
			$data['Name'] = utf8_decode($data['Name']);

			$discussions[] = $data;
		}

		return $discussions;
	}

	/**
	 * Convert date to make it compatible with Vanilla.
	 *
	 * @param $datetime format : 2012-08-22T10:01:00.000Z
	 *
	 * @return Datetime format : 2012-08-22 10:01:00
	 */
	private function fixDateTime($datetime)
	{
		$matches = array();
		preg_match('/^(\d{4}-\d{2}-\d{2})T(\d{2}:\d{2}:\d{2}).+$/', $datetime, $matches);
		return sprintf('%s %s', $matches[1], $matches[2]);
	}
}