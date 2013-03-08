{% if self.Notices %}
<div id="NoticeCollector" class="{{ self.CssClass }}">
	{% for notice in self.Notices %}
	<div class="Notice">
		{{ notice }}
	</div>
	{% endfor %}
</div>
{% endif %}
