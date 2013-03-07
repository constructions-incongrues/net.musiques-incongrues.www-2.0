{% set discussion = self.DelegateParameters['Discussion'] %}
<div id="Form" class="StartDiscussion">
	<fieldset>
		<legend>{{ self.Title }}</legend>
		{{ self.Get_Warnings()|raw }}
		{{ self.Get_PostBackForm('frmPostDiscussion', 'post', 'post.php')|raw }}

		<ul>
{% if self.Context.Configuration.USE_CATEGORIES %}
	{{ self.SetDelegateParameter('CategorySelect', cs) }}
	{{ self.CallDelegate('DiscussionForm_PreCategoryRender') }}
	{# TODO : broken #}
	{#{% set cs.Attributes = cs.Attributes ~ ' id="ddCategories"' %}#}
			<li>
				<label for="ddCategories">{{ self.Context.GetDefinition('SelectDiscussionCategory') }}</label>
				{{ cs.Get()|raw }}
			</li>
{% else %}
			<input type="hidden" name="CategoryID" value="{{ cs.aOptions[0].IdValue }}" />
{% endif %}
			{{ self.CallDelegate('DiscussionForm_PreTopicRender') }}
			<li>
				<label for="txtTopic">{{ self.Context.GetDefinition(discussion.DiscussionID == 0 ? 'EnterYourDiscussionTopic' : 'EditYourDiscussionTopic') }}</label>
				<input id="txtTopic" type="text" name="Name" class="DiscussionBox" maxlength="100" value="{{ discussion.Name }}" />
			</li>

{% if self.Context.Configuration.ENABLE_WHISPERS and discussion.DiscussionID == 0 %}
			<li>
				<label for="WhisperUsername">{{ self.Context.GetDefinition('WhisperYourCommentsTo')|raw }}</label>
				<input id="WhisperUsername" name="WhisperUsername" type="text" value="{{ FormatStringForDisplay(discussion.WhisperUsername, 0) }}" class="Whisper AutoCompleteInput" maxlength="20" />
				<script type="text/javascript">
					var WhisperAutoComplete = new AutoComplete("WhisperUsername", false);
					WhisperAutoComplete.TableID = "WhisperAutoCompleteResults";
					WhisperAutoComplete.KeywordSourceUrl = "{{ self.Context.Configuration.WEB_ROOT }}ajax/getusers.php?Search=";
				</script>
			</li>
{% endif %}

			{{ self.CallDelegate('DiscussionForm_PreCommentRender') }}
			<li>
				<label for="CommentBox">
					<a href="./" id="CommentBoxController" onclick="ToggleCommentBox('{{ self.Context.Configuration.WEB_ROOT }}ajax/switch.php', '{{ self.Context.GetDefinition('SmallInput') }}', '{{ self.Context.GetDefinition('BigInput') }}', '{{ self.Context.Session.GetCsrfValidationKey() }}'); return false;">
						{{ self.Context.GetDefinition(self.Context.Session.User.Preference('ShowLargeCommentBox') ? 'SmallInput' : 'BigInput') }}
					</a>

					{{ self.CallDelegate('DiscussionForm_PostCommentToggle') }}

					{{ self.Context.GetDefinition('EnterYourComments') }}
				</label>
				<textarea name="Body" class="{{ self.Context.Session.User.Preference('ShowLargeCommentBox') ? 'LargeCommentBox' : 'SmallCommentBox' }}" id="CommentBox" rows="10" cols="85"{{ self.DiscussionFormAttributes }}>{{ discussion.Comment.Body|raw }}</textarea>
			</li>
			{{ self.GetPostFormatting(discussion.Comment.FormatType)|raw }}
		</ul>

	{{ self.CallDelegate('DiscussionForm_PreButtonsRender') }}

	<div class="Submit">
		<input type="submit" name="btnSave" value="{{ self.Context.GetDefinition((discussion.DiscussionID > 0) ? 'SaveYourChanges' : 'StartYourDiscussion') }}" class="Button SubmitButton StartDiscussionButton" onclick="Wait(this, '{{ self.Context.GetDefinition('Wait') }}');" />
		{{ self.CallDelegate('DiscussionForm_PostSubmitRender') }}
		<a href="{{ self.IsPostBack ? '/' : 'javascript:history.back();'}} " class="CancelButton">{{ self.Context.GetDefinition('Cancel') }}</a>
	</div>

	{{ self.CallDelegate('DiscussionForm_PostButtonsRender') }}

	</form>
	</fieldset>
</div>
