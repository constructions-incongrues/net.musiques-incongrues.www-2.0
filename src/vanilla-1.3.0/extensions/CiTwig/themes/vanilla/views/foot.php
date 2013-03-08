</div>
	<a id="pgbottom" name="pgbottom">&nbsp;</a>
	</div>
</div>

{% if self.Context.Session.User.Permission('PERMISSION_ALLOW_DEBUG_INFO') and  self.Context.Mode %}
<div class="DebugBar" id="DebugBar">
	<b>Debug Options</b> | Resize: <a href="javascript:window.resizeTo(800,600);">800x600</a>, <a href="javascript:window.resizeTo(1024, 768);">1024x768</a> | <a href="javascript:HideElement('DebugBar');">Hide This</a>
	{{ self.Context.SqlCollector.GetMessages() }}
</div>
{% endif %}
