<?php
// Note: This file is included from the library/Vanilla/Vanilla.Control.DiscussionGrid.php class.

$ThemeFilePath = ThemeFilePath($this->Context->Configuration, 'discussion.php');
$Discussion = $this->Context->ObjectFactory->NewContextObject($this->Context, 'Discussion');
$CurrentUserJumpToLastCommentPref = $this->Context->Session->User->Preference('JumpToLastReadComment');
$FirstRow = 1;
$Alternate = 0;
$RowNumber = 0;
$DiscussionList = '';
?>
<div class="ContentInfo Top">
	<h1>
		<?php echo $this->Context->PageTitle ?>
	</h1>
	<?php echo $this->PageJump ?>
	<div class="PageInfo">
		<p><?php echo ($PageDetails == '' ? $this->Context->GetDefinition('NoDiscussionsFound') : $PageDetails) ?></p>
		<?php echo $PageList ?>
	</div>
</div>
<div id="ContentBody">
	<ol id="Discussions">
<?php foreach ($this->DiscussionData as $Discussion): ?>
	<?php 
		$RowNumber++;
		$Discussion->FormatPropertiesForDisplay();
		$this->DelegateParameters['RowNumber'] = &$RowNumber; 
		if ($Discussion->WhisperUserID > 0) {
			$Discussion->Name = $Discussion->WhisperUsername.': '.$Discussion->Name;	
		}
		$this->DelegateParameters['Discussion'] = &$Discussion;
		$this->CallDelegate( 'PreSingleDiscussionRender' );
		
		// Discussion search results are identical to regular discussion listings, so include the discussion search results template here.
		include($ThemeFilePath);

		$FirstRow = 0;
		$Alternate = FlipBool($Alternate);
	?>
<?php endforeach ?>
<?php echo $DiscussionList ?>
	</ol>
</div>

<?php if ($this->DiscussionDataCount > 0): ?>
<div class="ContentInfo Bottom">
	<div class="PageInfo">
		<p><?php echo $pl->GetPageDetails($this->Context) ?></p>
		<?php echo $PageList ?>
	</div>
	<a id="TopOfPage" href="<?php GetRequestUri() ?>#pgtop"><?php echo $this->Context->GetDefinition('TopOfPage') ?></a>
</div>
<?php endif; ?>