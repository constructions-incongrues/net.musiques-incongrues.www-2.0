{% set discussion = self.DelegateParameters.Discussion %}
{% set CurrentUserJumpToLastCommentPref = self.Context.Session.User.Preference('JumpToLastReadComment') %}
{% set UnreadUrl = GetUnreadQuerystring(discussion, self.Context.Configuration, CurrentUserJumpToLastCommentPref) %}
{% set NewUrl = GetUnreadQuerystring(discussion, self.Context.Configuration, 1) %}
{% set LastUrl = GetLastCommentQuerystring(discussion, self.Context.Configuration, CurrentUserJumpToLastCommentPref) %}

{{ self.SetDelegateParameters('Discussion', discussion) }}
{{ self.SetDelegateParameters('DiscussionList', discussionList) }}

<li id="Discussion_{{ discussion.DiscussionID }}" class="Discussion{{ discussion.Status}} {{ discussion.CountComments ? 'NoReplies' }} {{ self.Context.Configuration.USE_CATEGORIES ? ' Category_' ~ discussion.CategoryID }} {{ Alternate ? ' Alternate' }}">
	{{ self.CallDelegate('PreDiscussionOptionsRender') }}
	<ul>
		<li class="DiscussionType">
			<span>{{ self.Context.GetDefinition('DiscussionType') }}</span>{{ DiscussionPrefix(self.Context, discussion) }}
		</li>
		<li class="DiscussionTopic">
			<span>{{ self.Context.GetDefinition('DiscussionTopic') }}</span><a href="{{ UnreadUrl|raw }}" class="DiscussionTopicName">{{ discussion.Name|raw }}</a>
		</li>
		<div class="DiscussionExtraInfo">
{% if self.Context.Configuration.USE_CATEGORIES %}
		<li class="DiscussionCategory">
			<span>{{ self.Context.GetDefinition('Category') }} </span>
			<a href="{{ GetUrl(self.Context.Configuration, 'index.php', '', 'CategoryID', discussion.CategoryID)|raw }}">
				{{ discussion.Category }}
			</a>
		</li>
{% endif %}
		<li class="DiscussionStarted">
			<span>
				<a href="{{ GetUrl(self.Context.Configuration, 'comments.php', '', 'DiscussionID', discussion.DiscussionID, '', '#Item_1', CleanupString(discussion.Name))|raw }}">
					{{ self.Context.GetDefinition('StartedBy') }}
				</a> 
			</span>
			<a href="{{ GetUrl(self.Context.Configuration, 'account.php', '', 'u', discussion.AuthUserID)|raw }}">{{ discussion.AuthUsername }}</a>
		</li>
		<li class="DiscussionComments">
			<span>{{ self.Context.GetDefinition('Comments') }} </span>{{ discussion.CountComments }}
		</li>
		<li class="DiscussionLastComment">
			<span>
				<a href="{{ LastUrl|raw }}">{{ self.Context.GetDefinition('LastCommentBy') }}</a> 
			</span>
			<a href="{{ GetUrl(self.Context.Configuration, 'account.php', '', 'u', discussion.LastUserID)|raw }}">{{ discussion.LastUsername }}</a>
		</li>
		<li class="DiscussionActive">
			<span>
				<a href="{{ LastUrl|raw }}">{{ self.Context.GetDefinition('LastActive') }}</a> 
			</span>
			{{ TimeDiff(self.Context, discussion.DateLastActive, 'now'|date('U')) }}
		</li>
{% if self.Context.Session.UserID > 0 %}
			<li class="DiscussionNew">
				<a href="{{ NewUrl|raw }}">
					<span>{{ self.Context.GetDefinition('NewCaps') }} </span>{{ discussion.NewComments }}
				</a>
			</li>
{% endif %}

{{ self.CallDelegate('PostDiscussionOptionsRender') }}

			</div>
		</ul>
	</li>

{{ self.CallDelegate('PostDiscussionRender') }}
