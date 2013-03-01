<?php
// Database Configuration Settings
$Configuration['DATABASE_HOST'] = 'localhost';
$Configuration['DATABASE_NAME'] = 'main';
$Configuration['DATABASE_USER'] = 'root';
$Configuration['DATABASE_PASSWORD'] = '';
// Saved Searches Table Structure
$DatabaseTables['Notify'] = 'Notify';
$DatabaseColumns['Notify']['NotifyID'] = 'NotifyID';
$DatabaseColumns['Notify']['UserID'] = 'UserID';
$DatabaseColumns['Notify']['Method'] = 'Method';
$DatabaseColumns['Notify']['SelectID'] = 'SelectID';
$DatabaseColumns['Notify']['SelectID'] = 'SelectID';
// Attachments Table Structure
$DatabaseTables['Attachment'] = 'Attachment';
$DatabaseColumns['Attachment']['AttachmentID'] = 'AttachmentID';
$DatabaseColumns['Attachment']['UserID'] = 'UserID';
$DatabaseColumns['Attachment']['DiscussionID'] = 'DiscussionID';
$DatabaseColumns['Attachment']['CommentID'] = 'CommentID';
$DatabaseColumns['Attachment']['Title'] = 'Title';
$DatabaseColumns['Attachment']['Description'] = 'Description';
$DatabaseColumns['Attachment']['Name'] = 'Name';
$DatabaseColumns['Attachment']['Path'] = 'Path';
$DatabaseColumns['Attachment']['Size'] = 'Size';
$DatabaseColumns['Attachment']['MimeType'] = 'MimeType';
$DatabaseColumns['Attachment']['DateCreated'] = 'DateCreated';
$DatabaseColumns['Attachment']['DateModified'] = 'DateModified';
// DiscussionTags Table Structure
$DatabaseTables['DiscussionTags'] = 'DiscussionTags';
$DatabaseColumns['DiscussionTags']['TagID'] = 'TagID';
$DatabaseColumns['DiscussionTags']['Tag'] = 'Tag';
$DatabaseTables['DiscussionHasTags'] = 'DiscussionHasTags';
$DatabaseColumns['DiscussionHasTags']['TagID'] = 'TagID';
$DatabaseColumns['DiscussionHasTags']['DiscussionID'] = 'DiscussionID';

// Event Table Structure
$DatabaseTables['Event'] = 'Event';
$DatabaseColumns['Event']['DiscussionID'] = 'DiscussionID';
$DatabaseColumns['Event']['Date'] = 'Date';
$DatabaseColumns['Event']['City'] = 'City';
$DatabaseColumns['Event']['Country'] = 'Country';
// Releases Table Structure
$DatabaseTables['Releases'] = 'Releases';
$DatabaseColumns['Releases']['DiscussionID'] = 'DiscussionID';
$DatabaseColumns['Releases']['LabelName'] = 'LabelName';
$DatabaseColumns['Releases']['DownloadLink'] = 'DownloadLink';
$DatabaseColumns['Releases']['IsMix'] = 'IsMix';
// Shop Table Structure
$DatabaseTables['CatalogItems'] = 'CatalogItems';
$DatabaseColumns['CatalogItems']['DiscussionID'] = 'DiscussionID';
$DatabaseColumns['CatalogItems']['ImageUrl'] = 'ImageUrl';
$DatabaseColumns['CatalogItems']['Price'] = 'Price';

// Project Table Structure (@see MiProjects extension)
$DatabaseTables['Project'] = 'Project';
$DatabaseColumns['Project']['CategoryID'] = 'CategoryID';
$DatabaseColumns['Project']['CategoryParentID'] = 'CategoryParentID';
$DatabaseColumns['Project']['ProjectType'] = 'ProjectType';
$DatabaseColumns['Project']['WebsiteUrl'] = 'WebsiteUrl';
$DatabaseColumns['Project']['ImageUrl'] = 'ImageUrl';
$DatabaseColumns['Project']['CategoryUri'] = 'CategoryUri';
$DatabaseColumns['Project']['SidebarHtml'] = 'SidebarHtml';