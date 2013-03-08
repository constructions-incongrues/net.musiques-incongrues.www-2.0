{{ self.Render_Warnings()|raw }}
<div id="Form" class="SignInForm">
	<fieldset>
		{{ self.Render_PostBackForm(self.FormName) }}
		<ul>
			<li>
				<label for="txtUsername">{{ self.Context.GetDefinition('Username') }}</label>
				<input id="txtUsername" type="text" name="Username" value="{{ self.Username }}" class="Input" maxlength="20" />
			</li>
			<li>
				<label for="txtPassword">{{ self.Context.GetDefinition('Password') }}</label>
				<input id="txtPassword" type="password" name="Password" value="" class="Input" />
			</li>
			<li id="RememberMe">
				{{ GetDynamicCheckBox('RememberMe', 1, ForceIncomingBool('RememberMe', 0), '', self.Context.GetDefinition('RememberMe'))|raw }}
			</li>
		</ul>
		<div class="Submit"><input type="submit" name="btnSignIn" value="{{ self.Context.GetDefinition('Proceed') }}" class="Button" /></div>
	</form>
	</fieldset>
	<ul class="MembershipOptionLinks">
		<li class="ForgotPasswordLink"><a href="{{ GetUrl(self.Context.Configuration, self.Context.SelfUrl, '', '', '', '', 'PostBackAction=PasswordRequestForm') }}">{{ self.Context.GetDefinition('ForgotYourPassword') }}</a></li>
		<li class="ApplyForMembershipLink"><a href="{{ GetUrl(self.Context.Configuration, self.Context.SelfUrl, '', '', '', '', 'PostBackAction=ApplyForm') }}">{{ self.Context.GetDefinition('ApplyForMembership') }}</a></li>
	</ul>
</div><!-- #Form -->