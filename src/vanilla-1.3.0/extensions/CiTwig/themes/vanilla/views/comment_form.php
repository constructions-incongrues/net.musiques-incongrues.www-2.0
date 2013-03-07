{% set comment = self.DelegateParameters.Comment %}

<div id="Form" class="AddComments">
	<fieldset>
		<legend>{{ self.Title }}</legend>'
		{{ self.Get_Warnings()|raw }}
		{{ self.Get_PostBackForm('frmPostComment', 'post', 'post.php')|raw }}

		<ul>
		{{ self.CallDelegate('CommentForm_PreWhisperInputRender') }}

{% if self.Context.Configuration.ENABLE_WHISPERS %}
	{% if self.Discussion.WhisperUserID > 0 %}
			<li>{{ self.Context.GetDefinition('YourCommentsWillBeWhisperedToX')|replace({ '//1': self.Discussion.WhisperUserID == self.Context.Session.UserID ? self.Discussion.AuthUsername : self.Discussion.WhisperUsername }) }}</li>
	{% else %}
			<li>
				<label for="WhisperUsername">{{ self.Context.GetDefinition('WhisperYourCommentsTo')|raw }}</label>
				<input id="WhisperUsername" name="WhisperUsername" type="text" value="{{ comment.WhisperUsername }}" class="Whisper AutoCompleteInput" maxlength="20" />
				<script type="text/javascript">
					var WhisperAutoComplete = new AutoComplete("WhisperUsername", false);
					WhisperAutoComplete.TableID = "WhisperAutoCompleteResults";
					WhisperAutoComplete.KeywordSourceUrl = "{{ self.Context.Configuration.WEB_ROOT }}ajax/getusers.php?Search=";
				</script>
			</li>
	{% endif %}
{% endif %}

{{ self.CallDelegate('CommentForm_PreCommentsInputRender') }}

			<li>
				<label for="CommentBox">
					<a href="./" id="CommentBoxController" onclick="ToggleCommentBox('{{ self.Context.Configuration.WEB_ROOT }}ajax/switch.php', '{{ self.Context.GetDefinition('SmallInput') }}', '{{ self.Context.GetDefinition('BigInput') }}', '{{ self.Context.Session.GetCsrfValidationKey() }}'); return false;">{{ self.Context.GetDefinition(self.Context.Session.User.Preference('ShowLargeCommentBox') ? 'SmallInput' : 'BigInput') }}</a>

					{{ self.CallDelegate('CommentForm_PostCommentToggle') }}

					{{ self.Context.GetDefinition('EnterYourComments') }}
				</label>
			<textarea name="Body" class=" {{ self.Context.Session.User.Preference('ShowLargeCommentBox') ? 'LargeCommentBox' : 'SmallCommentBox' }}" id="CommentBox" rows="10" cols="85"{{ self.CommentFormAttributes }}>{{ comment.Body }}</textarea>
		</li>
		{{ self.GetPostFormatting(comment.FormatType)|raw }}
	</ul>

	{{ self.CallDelegate('CommentForm_PreButtonsRender') }}

	<div class="Submit">
		<input type="submit" name="btnSave" value="{{ comment.CommentID > 0 ? self.Context.GetDefinition('SaveYourChanges') : self.Context.GetDefinition('AddYourComments') }}" class="Button SubmitButton AddCommentsButton" onclick="Wait(this, '{{ self.Context.GetDefinition('Wait') }}');" />

		{{ self.CallDelegate('CommentForm_PostSubmitRender') }}

		&nbsp;

{% if self.PostBackAction == 'SaveComment' or (self.PostBackAction == '' and comment.CommentID > 0) %}
	{% if self.Comment.DiscussionID > 0 %}
		<a href="{{ GetUrl(self.Context.Configuration, 'comments.php', '', 'DiscussionID', self.Comment.DiscussionID) }}" class="CancelButton">{{ self.Context.GetDefinition('Cancel') }}</a>
	{% else %}
		<a href="{{ GetUrl(self.Context.Configuration, 'index.php') }}" class="CancelButton">{{ self.Context.GetDefinition('Cancel') }}</a>
	{% endif %}
{% endif %}
	</div>

{{ self.CallDelegate('CommentForm_PostButtonsRender') }}

	</form>
	</fieldset>
</div><!-- #Form -->

