<div class="About">
	{{ self.Context.GetDefinition('AboutMembership')|raw }}
	<p><a href="{{ GetUrl(self.Context.Configuration, self.Context.SelfUrl) }}">{{ self.Context.GetDefinition('BackToSignInForm') }}</a></p>
</div>
<div id="Form" class="ApplyForm">
	<fieldset>
		<legend>{{ self.Context.GetDefinition('MembershipApplicationForm') }}</legend>
			<p>{{ self.Context.GetDefinition('AllFieldsRequired') }}</p>

			{{ self.CallDelegate('PreWarningsRender') }}
			{{ self.Render_Warnings()|raw }}

			{{ self.Render_PostBackForm(self.FormName)|raw }}
			<ul>

				{{ self.CallDelegate('PreInputsRender') }}

				<li>
					<label for="txtEmail">{{ self.Context.GetDefinition('EmailAddress') }}</label>
					<input id="txtEmail" type="text" name="Email" value="{{ self.Applicant.Email }}" class="Input" maxlength="160" />
				</li>
				<li>
					<label for="txtUsername">{{ self.Context.GetDefinition('Username') }}</label>
					<input id="txtUsername" type="text" name="Name" value="{{ self.Applicant.Name }}" class="Input" maxlength="20" />
				</li>
				<li id="NameListItem">
					<label for="txtName">Name</label>
					<input id="txtName" type="text" name="Username" class="Input" maxlength="20" />
				</li>
				<li>
					<label for="txtNewPassword">{{ self.Context.GetDefinition('Password') }}</label>
					<input id="txtNewPassword" type="password" name="NewPassword" value="{{ self.Applicant.NewPassword }}" class="Input" />
				</li>
				<li>
					<label for="txtConfirmPassword">{{ self.Context.GetDefinition('PasswordAgain') }}</label>
					<input id="txtConfirmPassword" type="password" name="ConfirmPassword" value="{{ self.Applicant.ConfirmPassword }}" class="Input" />
				</li>

				{{ self.CallDelegate('PostInputsRender') }}
				{{ self.CallDelegate('PreTermsCheckRender') }}

				{% set TermsOfServiceUrl = self.Context.Configuration.WEB_ROOT ~ 'termsofservice.php' %}

				<li id="TermsOfServiceCheckBox">
					{{ GetBasicCheckBox('AgreeToTerms', 1, self.Applicant.AgreeToTerms,'id="AgreeToTerms"')|raw }} 
					<label for="AgreeToTerms" id="AgreeToTermsLabel">{{ self.Context.GetDefinition('IHaveReadAndAgreeTo')|replace({'//1':'<a href="' ~ TermsOfServiceUrl ~ '">' ~ self.Context.GetDefinition('TermsOfService') ~ '</a>'})|raw }}</label>
				</li>
			</ul>
			<div class="Submit">
				<input type="submit" name="btnApply" value="{{ self.Context.GetDefinition('Proceed') }}" class="Button" />
			</div>
		</form>
	</fieldset>
</div><!-- #Form -->
