<?php
namespace ConstructionsIncongrues\Vanilla;

class CommentManager extends \CommentManager
{
	/**
	 * @return array[\Comment]
	 */
	public function GetCommentList($RowsPerPage, $CurrentPage, $DiscussionID, $FirstRecord = "0")
	{
		// Build comments array from database results
		$dbResults = parent::GetCommentList($RowsPerPage, $CurrentPage, $DiscussionID, $FirstRecord);
		$comments = array();
		while ($row = $this->Context->Database->GetRow($dbResults)) {
			$comment = $this->Context->ObjectFactory->NewContextObject($this->Context, 'Comment');
			$comment->Clear();
			$comment->GetPropertiesFromDataSet($row, $this->Context->Session->UserID);
			$comments[] = $comment;
		}

		return $comments;
	}
}