<?php
namespace ConstructionsIncongrues\Vanilla;

class CategoryManager extends \CategoryManager
{
	public function GetCategories($IncludeCount = '0', $OrderByPreference = '0', $ForceRoleBlock = '1')
	{
		// Create categories array from database results
		$dbResults = parent::GetCategories($IncludeCount, $OrderByPreference, $ForceRoleBlock);
		$categories = array();
		while ($Row = $this->Context->Database->GetRow($dbResults)) {
			$Category = $this->Context->ObjectFactory->NewObject($this->Context, 'Category');
			$Category->Clear();
			$Category->GetPropertiesFromDataSet($Row);
			$Category->FormatPropertiesForDisplay();
			$categories[] = $Category;
		}

		return $categories;
	}
}
