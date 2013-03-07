{# TODO : CommentList based delegates do not work anymore #}

{% if self.Context.WarningCollector.Count() > 0 %}
<div class="ErrorContainer">
	<div class="ErrorTitle">{{ self.Context.GetDefinition('ErrorTitle') }}</div>
	{{ self.Context.WarningCollector.GetMessages() }}
</div>
{% else %}

	{% set PageDetails = self.pl.GetPageDetails(self.Context) %}
	{% set PageList = self.pl.GetNumericList() %}
	{% set SessionPostBackKey = self.Context.Session.GetCsrfValidationKey() %}

<div class="ContentInfo Top">
	<h1>
	{% if self.Context.Configuration.USE_CATEGORIES %}
		<a href="{{ GetUrl(self.Context.Configuration, 'index.php', '', 'CategoryID', self.Discussion.CategoryID) }}">{{ self.Discussion.Category }}</a>: 
	{% endif %}
		{{ DiscussionPrefix(self.Context, self.Discussion) }} 
	{% if self.Discussion.WhisperUserID > 0 %}
		{{ self.Discussion.WhisperUsername }}: 
	{% endif %}
		{{ self.Discussion.Name }}
	</h1>
		<a href="#pgbottom">{{ self.Context.GetDefinition('BottomOfPage') }}</a>
		<div class="PageInfo">
			<p>{{ PageDetails }}</p>
			{{ PageList|raw }}
		</div>
	</div>
	<div id="ContentBody">
		<ol id="Comments">

	{% set RowNumber = 0 %}
	{% set CommentID = 0 %}
	{% set Alternate = 0 %}
	{% set FirstComment = 1 %}
	{% if self.CurrentPage > 1 %}
		{% set FirstComment = 0 %}
	{% endif %}

	{# Define the current user's permissions and preferences #}
	{# (small optimization so they don't have to be checked every loop):#}
	{% set PERMISSION_EDIT_COMMENTS = self.Context.Session.User.Permission('PERMISSION_EDIT_COMMENTS') %}
	{% set PERMISSION_HIDE_COMMENTS = self.Context.Session.User.Permission('PERMISSION_HIDE_COMMENTS') %}
	{% set PERMISSION_HIDE_DISCUSSIONS = self.Context.Session.User.Permission('PERMISSION_HIDE_DISCUSSIONS') %}
	{% set PERMISSION_EDIT_DISCUSSIONS = self.Context.Session.User.Permission('PERMISSION_EDIT_DISCUSSIONS') %}

	{% for comment in self.CommentData %}

		{# TODO : way too much logic here, move to controller #}
		{% if RowNumber > 0 %}
			{% set PERMISSION_EDIT_DISCUSSIONS = 0 %}
		{% endif %}
		{% set RowNumber = RowNumber + 1 %}
		{% set ShowHtml = comment.FormatPropertiesForDisplay() %}
		{% set ShowIcon = comment.AuthIcon != '' ? 1 : 0 %}
		
		{{ self.SetDelegateParameter('ShowHtml', ShowHtml) }}
		{{ self.SetDelegateParameter('ShowIcon', ShowIcon) }}
		{{ self.SetDelegateParameter('RowNumber', RowNumber) }}

		{% if comment.WhisperUserID > 0 %}
			{% if (comment.WhisperUserID == self.Context.Session.UserID and comment.AuthUserID == self.Context.Session.UserID) or comment.WhisperUserID == self.Context.Session.UserID %}
				{% set CommentClass = 'WhisperTo' %}
			{% else %}
				{% set CommentClass = 'WhisperFrom' %}
			{% endif %}
		{% elseif self.Discussion.WhisperUserID > 0 %}
			{% set CommentClass = (comment.AuthUserID == self.Context.Session.UserID) ? 'WhisperFrom' : 'WhisperTo' %}
		{% endif %}


		<li id="Comment_{{ comment.CommentID }}" class="{{ CommentClass }}{% if comment.Deleted %}Hidden{% endif %} {% if Alternate %}Alternate{% endif %}">
			<a name="Item_{{ RowNumber }}"></a>
			<div class="CommentHeader">
				<ul>
					<li>
		{% if ShowIcon %}
						<div class="CommentIcon" style="background-image:url('{{ comment.AuthIcon }}');">&nbsp;</div>
		{% endif %}
						<span>{{ self.Context.GetDefinition('CommentAuthor') }}</span>
						<a href="{{ GetUrl(self.Context.Configuration, 'account.php', '', 'u', comment.AuthUserID) }}">{{ comment.AuthUsername }}</a>

		{# Point out who it was whispered to if necessary #}
		{% if comment.WhisperUserID > 0 %}
			{% if comment.WhisperUserID == self.Context.Session.UserID and comment.AuthUserID == self.Context.Session.UserID %}
						{{ self.Context.GetDefinition('ToYourself') }}
			{% elseif comment.WhisperUserID == self.Context.Session.UserID %}
						{{ self.Context.GetDefinition('ToYou') }}
			{% else %}
						{{ self.Context.GetDefinition('ToX')|replace( {'//1': comment.WhisperUsername} ) }}
			{% endif %}
		{% endif %}
					</li>
					<li>
						<span>{{ self.Context.GetDefinition('CommentTime') }}</span>{{ TimeDiff(self.Context, comment.DateCreated) }}
		{% if comment.DateEdited %}
						<em>{{ self.Context.GetDefinition('Edited') }}</em>
		{% endif %}
		{% if comment.Deleted %}
						<i>{{ self.Context.GetDefinition('CommentHiddenOnXByY')|replace( {'//1': TimeDiff(self.Context, comment.DateDeleted), '//2': comment.DeleteUsername} ) }}</i>
		{% endif %}
		{# "Whisper back" button #}
		{% if not self.Discussion.Closed and comment.WhisperUserID > 0 and comment.WhisperUserID == self.Context.Session.UserID %}
						<a class="WhisperBack" onclick="WhisperBack('{{ comment.DiscussionID }}', '{{ comment.AuthUsername }}', '{{ self.Context.Configuration.BASE_URL }}');">
							{{ self.Context.GetDefinition('WhisperBack') }}
						</a>
		{% endif %}
					</li>
				</ul>
				<span>
					&nbsp;
					
					{# Set up comment options #}
					{{ self.SetDelegateParameter('Comment', comment) }}
					{{ self.SetDelegateParameter('CommentList', CommentList) }}
					{{ self.SetDelegateParameter('RowNumber', RowNumber) }}
					{{ self.CallDelegate('PreCommentOptionsRender') }}

		{% if self.Context.Session.UserID > 0 %}
			{% if comment.AuthUserID == self.Context.Session.UserID or PERMISSION_EDIT_COMMENTS or PERMISSION_EDIT_DISCUSSIONS %}
				{% if not (self.Discussion.Closed and self.Discussion.Active) or PERMISSION_EDIT_COMMENTS or PERMISSION_EDIT_DISCUSSIONS %}
					<a href="{{ GetUrl(self.Context.Configuration, 'post.php', '', 'CommentID', comment.CommentID) }}">{{ self.Context.GetDefinition('edit') }}</a>
				{% endif %}
			{% endif %}
			{% if PERMISSION_HIDE_COMMENTS and not FirstComment %}
					<a id="HideComment{{ comment.CommentID }}" href="./" onclick="HideComment('{{ self.Context.Configuration.WEB_ROOT }}ajax/switch.php', '{{ comment.Deleted ? "0" : "1" }}', '{{ self.Discussion.DiscussionID }}', '{{ comment.CommentID }}', '{{ self.Context.GetDefinition("ShowConfirm") }}', '{{ self.Context.GetDefinition("HideConfirm") }}', 'HideComment{{ comment.CommentID }}', '{{ SessionPostBackKey }}'); return false;">{{ self.Context.GetDefinition(comment.Deleted ? 'Show' : 'Hide') }}</a>
			{% endif %}
			{% if PERMISSION_HIDE_DISCUSSIONS and FirstComment %}
					<a id="HideDiscussion{{ self.Discussion.DiscussionID }}" href="./" onclick="if (confirm('{{ self.Context.GetDefinition(self.Discussion.Active ? "ConfirmHideDiscussion" : "ConfirmUnhideDiscussion") }}')) DiscussionSwitch('{{ self.Context.Configuration.WEB_ROOT}}ajax/switch.php', 'Active', '{{ self.Discussion.DiscussionID }}', '{{ FlipBool(self.Discussion.Active) }}', 'HideDiscussion', '{{ SessionPostBackKey }}'); return false;">
						{{ self.Context.GetDefinition(self.Discussion.Active ? "Hide" : "Unhide") }}</a>
				{%set FirstComment = 0 %}
			{% endif %}
		{% endif %}
		
		{{ self.SetDelegateParameter('CommentList', CommentList) }}
		{{ self.CallDelegate('PostCommentOptionsRender') }}
				</span>
			</div>

		{% if comment.AuthRoleDesc != '' %}
			<div class="CommentNotice">{{ comment.AuthRoleDesc }}</div>
		{% endif %}
			<div class="CommentBody" id="CommentBody_{{ comment.CommentID }}">
				{{ comment.Body|raw }}
			</div>
		</li>
		{% set Alternate = FlipBool(Alternate) %}
	{% endfor %}
	</ol>
	</div>

	{% if PageList and PageDetails %}
	<div class="ContentInfo Middle">
		<div class="PageInfo">
			<p>{{ PageDetails }}</p>{{ PageList|raw }}
		</div>
	</div>
	{% endif %}
{% endif %}
