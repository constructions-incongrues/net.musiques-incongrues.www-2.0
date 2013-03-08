<div id="Panel">

{# Add the start button to the panel #}
{% if self.Context.Session.UserID > 0 and self.Context.Session.User.Permission('PERMISSION_START_DISCUSSION') %}
	<h1>
		<a href="{{ GetUrl(self.Context.Configuration, 'post.php', 'category/', 'CategoryID', ForceIncomingInt('CategoryID', '')) }}">
			{{ self.Context.GetDefinition('StartANewDiscussion') }}
		</a>
	</h1>
{% endif %}

{{ self.CallDelegate('PostStartButtonRender') }}

{% for panel in self.PanelElements %}
	{% if panel.Type == 'List' and self.Lists[self.Key] %}
	<ul>
		<li>
			<h2>{{ panel.Key }}</h2>
			<ul>
		{% for links in self.Lists[self.Key] %}
				<li>
					<a href="{{ link.Link }}" {{ link.LinkAttributes }}>
						{{ link.Item|raw }}
			{% if link.Suffix %}
						<span>{{ self.Context.GetDefinition(link.Suffix)|raw }}</span>						
			{% endif %}
					</a>
				</li>
		{% endfor %}
			</ul>
		</li>
	</ul>
	{% elseif panel.Type == 'String' %}
	{{ self.Strings[panel.Key]|raw }}
	{% endif %}
{% endfor %}

{{ self.CallDelegate('PostElementsRender') }}

</div><!-- #Panel -->

<div id="Content">
