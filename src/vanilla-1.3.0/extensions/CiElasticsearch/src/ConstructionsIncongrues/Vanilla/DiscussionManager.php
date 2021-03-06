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
		// TODO : Does not work
		$esFilterAnd = new BoolAnd();
		if (!$this->Context->Session->User->Permission('PERMISSION_VIEW_HIDDEN_DISCUSSIONS')
			|| !$this->Context->Session->User->Preference('ShowDeletedDiscussions')) {
			$filterActive = new Term(array('Active' => 1));
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
		} elseif ($this->Context->Session->UserID > 0) {
			// TODO : convert to ES syntax
			// $s->AddJoin('CategoryBlock', 'cb', 'CategoryID', 't', 'CategoryID', 'left join', ' and cb.'.$this->Context->DatabaseColumns['CategoryBlock']['UserID'].' = '.$this->Context->Session->UserID);
			// // This coalesce seems to be slowing things down
			// // $s->AddWhere('coalesce(cb.Blocked,0)', 1, '<>');
			// $s->AddWhere('cb', 'Blocked', '', '0', '=', 'and', '', 1, 1);
			// $s->AddWhere('cb', 'Blocked', '', '0', '=', 'or', '', 0, 0);
			// $s->AddWhere('cb', 'Blocked', '', 'null', 'is', 'or', '', 0, 0);
			// $s->EndWhereGroup();
		}
		if (isset($filterCategory)) {
			$esFilterAnd->addFilter($filterCategory);
		}

		// TODO : GetDiscussionWhisperFilter

		// TODO : reproduce initial logic
		// TODO : then implement facets !
		$queryString = new \Elastica\Query\QueryString('*');

		// Build final query object
		// $query->setFilter($esFilterAnd);
		$query->setFilter($esFilterAnd);
		$query->setQuery($queryString);

		// Sorting
		$sort = array('DateLastActive' => array('order' => 'desc'));
		$query->setSort($sort);

		// Pagination
		$query->setFrom(($CurrentPage - 1) * $RowsPerPage);
		$query->setLimit($RowsPerPage);

		// Perform search
		$results = $indexDiscussions->search($query);

		// Build discussions array
		$discussions = array();
		foreach ($results as $result) {
			$data = $result->getData();

			// Fetch discussion from database, in order to fix session related data
			$discussion = parent::GetDiscussionById($data['DiscussionID']);
			$discussions[] = $discussion;
		}

		return $discussions;
	}
}
