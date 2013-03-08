{% set FirstRow = 1 %}
{% set Alternate = 1 %}
{% set RowNumber = 1 %}
{% set ThemeFilePath = ThemeFilePath(self.Context.Configuration, 'discussion.php') %}
{% set CurrentUserJumpToLastCommentPref = self.Context.Session.User.Preference('JumpToLastReadComment') %}

<div class="ContentInfo Top">
	<h1>
		{{ self.Context.PageTitle }}
	</h1>
	{{ self.PageJump }}
	<div class="PageInfo">
		<p>{{ PageDetails == '' ? self.Context.GetDefinition('NoDiscussionsFound') : PageDetails }}</p>
		{{ PageList|raw }}
	</div>
</div>
<div id="ContentBody">
	<ol id="Discussions">
{% for discussion in self.DiscussionData %}
	{% set RowNumber = RowNumber + 1 %}
	{{ self.SetDelegateParameter('RowNumber', RowNumber) }}
	{{ self.SetDelegateParameter('Discussion', discussion) }}
	{{ self.CallDelegate('PreSingleDiscussionRender') }}
	{{ CiTwigRender(ThemeFilePath, self, {'Alternate': Alternate}) }}
	{% set FirstRow = 0 %}
	{% set Alternate = FlipBool(Alternate) %}
{% endfor %}
	</ol><!-- #Discussions -->
</div><!-- #ContentBody -->

{% if self.DiscussionDataCount > 0 %}
<div class="ContentInfo Bottom">
	<div class="PageInfo">
		<p>{{ pl.GetPageDetails(self.Context)|raw }}</p>
		{{ PageList|raw }}
	</div>
	<a id="TopOfPage" href="{{ GetRequestUri() }}#pgtop">{{ self.Context.GetDefinition('TopOfPage') }}</a>
</div>
{% endif %}