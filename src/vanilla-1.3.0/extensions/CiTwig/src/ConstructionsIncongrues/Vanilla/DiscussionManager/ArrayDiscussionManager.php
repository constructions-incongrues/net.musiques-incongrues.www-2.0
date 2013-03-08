<?php
namespace ConstructionsIncongrues\Vanilla\DiscussionManager;

class ArrayDiscussionManager extends \DiscussionManager
{
	/**
	 * @return array[\Discussion]
	 */
	public function GetDiscussionList($RowsPerPage, $CurrentPage, $CategoryID)
	{
		// Build discussions array from database results
		$dbResults = parent::GetDiscussionList($RowsPerPage, $CurrentPage, $CategoryID);
		$discussions = array();
		while ($Row = $this->Context->Database->GetRow($dbResults)) {
			$Discussion = $this->Context->ObjectFactory->NewContextObject($this->Context, 'Discussion');
			$Discussion->Clear();
			$Discussion->GetPropertiesFromDataSet($Row);
			$Discussion->FormatPropertiesForDisplay();
			$discussions[] = $Discussion;
		}

		return $discussions;
	}	
}