<div class="FormComplete">
	<h2>{{ self.Context.GetDefinition('YouAreSignedIn') }}</h2>
	<ul>
		<li><a href="{{ GetUrl(self.Context.Configuration, 'index.php') }}">{{ self.Context.GetDefinition('ClickHereToContinueToDiscussions') }}</a></li>
		<li><a href="{{ GetUrl(self.Context.Configuration, 'categories.php') }}">{{ self.Context.GetDefinition('ClickHereToContinueToCategories') }}</a></li>
{% if self.ApplicantCount %}
		<li>
			<a href="{{ GetUrl(self.Context.Configuration, 'settings.php', '', '', '', '','PostBackAction=Applicants') }}">
				{{ self.Context.GetDefinition('ReviewNewApplicants') }}
			</a> (<strong>{{ self.ApplicantCount }} {{ self.Context.GetDefinition('New') }}</strong>)
		</li>
{% endif %}
	</ul>
</div>