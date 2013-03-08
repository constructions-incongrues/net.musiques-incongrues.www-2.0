<div class="FormComplete">
	<h2>{{ self.Context.GetDefinition('SignOutSuccessful') }}</h2>
	<ul>
		<li><a href="{{ GetUrl(self.Context.Configuration, self.Context.SelfUrl) }}">{{ self.Context.GetDefinition('SignInAgain') }}</a></li>
	</ul>
</div>