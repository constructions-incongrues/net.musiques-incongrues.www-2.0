<?php
namespace ConstructionsIncongrues\Vanilla\Elastica;

class Client extends \Elastica\Client
{
	public function saveDiscussion(\Discussion $discussion, $index)
	{
		// Create Elastic Search document
		// TODO : fix E_NOTICE related to Whisper* fields
		$data = array(
			'Active' => $discussion->Active,
			'AuthUsername' => $discussion->AuthUsername,
			'AuthUserID' => $discussion->AuthUserID,
			'Bookmarked' => $discussion->Bookmarked,
			'Category' => $discussion->Category,
			'CategoryID' => $discussion->CategoryID,
			'Closed' => $discussion->Closed,
			'CountComments' => $discussion->CountComments,
			'CountWhispersFrom' => $discussion->CountWhispersFrom,
			'CountWhispersTo' => $discussion->CountWhispersTo,
			'DateCreated' => $discussion->DateCreated,
			'DateLastActive' => $discussion->DateLastActive,
			'DiscussionID' => $discussion->DiscussionID,
			'FirstCommentID' => $discussion->FirstCommentID,
			'LastUserID' => $discussion->LastUserID,
			'LastUsername' => $discussion->LastUsername,
			'LastViewCountComments' => $discussion->LastViewCountComments,
			'LastViewed' => $discussion->LastViewed,
			'Name' => $discussion->Name,
			'Sink' => $discussion->Sink,
			'Sticky' => $discussion->Sticky,
		);

		// Whisper
		if ($discussion->WhisperUserID > 0) {
			$data = array_merge($data, array(
				'WhisperFromDateLastActive' => $discussion->WhisperFromDateLastActive,
				'WhisperFromLastUserID' => $discussion->WhisperFromLastUserID,
				'WhisperFromLastUsername' => $discussion->WhisperFromLastUsername,
				'WhisperToLastUsername' => $discussion->WhisperToLastUsername,
				'WhisperToDateLastActive' => $discussion->WhisperToDateLastActive,
				'WhisperToLastUserID' => $discussion->WhisperToLastUserID,
				'WhisperUserID' => $discussion->WhisperUserID,
				'WhisperUsername' => $discussion->WhisperUsername,)
			);
		}

		// Save document to index
		$document = new \Elastica\Document($discussion->DiscussionID, $data, 'vanilla-discussion', $index);
		$index = $this->getIndex($index);
		$index->addDocuments(array($document));
		$index->refresh();
	}

	/**
	 * Changes a discussion property.
	 */
	public function switchDiscussionProperty($discussionId, $propertyName, $value, $index)
	{
		// Update document
		$this->updateDocument(
			$discussionId, 
			new \Elastica\Document($discussionId, array($propertyName => $value)), 
			$index, 
			'vanilla-discussion'
		);
		$index = $this->getIndex($index);
		$index->refresh();
	}
}