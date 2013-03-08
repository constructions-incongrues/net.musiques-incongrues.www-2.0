<div class="About">
	<h2>{{ self.Context.GetDefinition('AboutYourPassword')|raw }}</h2>
	<p>{{ self.Context.GetDefinition('AboutYourPasswordNotes')|raw }}</p>
</div>
<div id="Form" class="PasswordResetForm">
	<fieldset>
		<legend>{{ self.Context.GetDefinition('PasswordResetForm') }}</legend>
		<p>{{ self.Context.GetDefinition('ChooseANewPassword') }}</p>
		{{ self.Render_Warnings()|raw }}
	    {{ self.Render_PostBackForm(self.FormName)|raw }}
		<ul>
			<li>
				<label for="txtNewPassword">{{ self.Context.GetDefinition('NewPassword') }}</label>
				<input id="txtNewPassword" type="password" name="NewPassword" value="" class="Input" maxlength="20" />
			</li>
			<li>
				<label for="txtConfirmPassword">{{ self.Context.GetDefinition('ConfirmPassword') }}</label>
				<input id="txtConfirmPassword" type="password" name="ConfirmPassword" value="" class="Input" maxlength="20" />
			</li>
		</ul>
		<div class="Submit"><input type="submit" name="btnPassword" value="{{ self.Context.GetDefinition('Proceed') }}" class="Button" /></div>
	</form>
	</fieldset>
</div>
