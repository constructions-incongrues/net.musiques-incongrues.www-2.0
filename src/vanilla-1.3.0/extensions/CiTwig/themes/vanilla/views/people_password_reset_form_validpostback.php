<div class="FormComplete">
	<h2>{{ self.Context.GetDefinition('PasswordReset') }}</h2>
	<ul>
		<li><a href="{{ GetUrl(self.Context.Configuration, self.Context.SelfUrl) }}">{{ self.Context.GetDefinition('SignInNow') }}</a>.</li>
	</ul>
</div>
