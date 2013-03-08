<div id="SignOutForm">
	{{ self.Render_PostBackForm()|raw }}
	{{ self.Render_Warnings()|raw }}
	<fieldset>
		<div class="Submit">
			<input type="submit" name="sign-out" value="{{ self.Context.GetDefinition('SignOut') }}" class="Button" />
		</div>
	</form>
	</fieldset>
</div>