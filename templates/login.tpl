<div class="logo">
	<img src="./content/assets/admin/layout/img/f1-logo.png" alt=""/>
</div>

<div class="menu-toggler sidebar-toggler">
</div>

<div class="content">
	<form name='login_form' class="login-form" action="index.php" method="post">
		<h3 class="form-title">{translate}tr_login_title{/translate}</h3>
        {if isset($error)}
		<div class="alert alert-danger">
			<button class="close" data-close="alert"></button>
			<span>{$error}</span>
		</div>
		{/if}
		<div class="form-group">
			<!--ie8, ie9 does not support html5 placeholder, so we just show field title for that-->
			<label class="control-label visible-ie8 visible-ie9">Username</label>
			<div class="input-icon">
				<i class="fa fa-user"></i>
				<input class="form-control placeholder-no-fix" type="text" autocomplete="off" placeholder="{translate}tr_login_type_username{/translate}"
                            {if isset($username)}
                                value="{$username}"
                            {/if}
                            name="username" onkeypress="submitForm(event)"/>
			</div>
		</div>
		<div class="form-group">
			<label class="control-label visible-ie8 visible-ie9">Password</label>
			<div class="input-icon">
				<i class="fa fa-lock"></i>
				<input class="form-control placeholder-no-fix" type="password" autocomplete="off" placeholder="{translate}tr_login_type_password{/translate}" 
							{if isset($password)}
                                value="{$password}"
                            {/if}
                            name="password" onkeypress="submitForm(event)"/>
			</div>
		</div>
	</form>
	<div style="width:75%;">
	<form name='select_language' class="login-form" action="index.php" method="post">
		<div class="form-group">
			<label class="control-label visible-ie8 visible-ie9">{translate}tr_profile_language{/translate}</label>
			<div class="input-icon">
				<select id="user_language" name="user_language" onchange="javascript:document.select_language.submit()">
					{section name=value loop=$language_values}
						{if $language_values[value].id == $language_id}
							<option selected value='{$language_values[value].id}'>{$language_values[value].name}</option>
						{else}
							<option value='{$language_values[value].id}'>{$language_values[value].name}</option>
						{/if}
					{/section}
				</select>
				<img src="content/img/flags/{$language_values[$language_id].flag}.gif" width="50px"/>
			</div>                                    
		</div>
	</form></div>
	
		<div class="form-actions">
			<button type="submit" class="btn green pull-right" onclick="javascript:document.login_form.submit()">
			{translate}tr_login_login{/translate} <i class="m-icon-swapright m-icon-white"></i>
			</button>
		</div>
		<div class="forget-password">
			<div style="float:left">
            	<a href="?site=reset_password">{translate}tr_login_forgot_password{/translate}?</a>
			</div>
			<div style="float:right">
				<a href="?site=create_account">{translate}tr_login_create_account{/translate}</a>
			</div>
		</div>
		<div class="create-account">
			
		</div>
</div>

<div class="copyright">
	Version: <strong>{$version}</strong>
</div>
<div class="socialmedia">
	<a class="socicon-btn socicon-btn-circle socicon-sm socicon-solid bg-blue bg-hover-grey-salsa font-white bg-hover-white socicon-facebook tooltips" data-original-title="Facebook" href="{translate}email_link_to_facebook{/translate}"></a>
	<a class="socicon-btn socicon-btn-circle socicon-sm socicon-solid bg-red bg-hover-grey-salsa font-white bg-hover-white socicon-twitter tooltips" data-original-title="Twitter" href="{translate}email_link_to_twitter{/translate}"></a>
</div>
<div class="playstorelogo">
	<a href="https://play.google.com/store/apps/details?id=at.ziegelwanger_edv.racingmanager"><img src="./content/assets/admin/layout/img/5sterne.png" alt=""/></a>	
</div>
<div class="playstoretext">
	{translate}login_link_pre{/translate}<a href="https://play.google.com/store/apps/details?id=at.ziegelwanger_edv.racingmanager">Play Store</a>{translate}login_link_post{/translate}
	<br/>
	{translate}login_thanks{/translate}
</div>

<!--<div id="cookienotice-container" class="cookienotice-container cookienotice-bar cookienotice-bar-bottom" onclick="$('#cookienotice-container').remove();">
	<div class="cookienotice-content">
		<div class="cookienotice-message">
			{translate}tr_cookie_text{/translate}
		</div>
		<div class="cookienotice-button-container">
			<a id="cookienotice-close-button" class="cookienotice-button" title="Schließen" style="color: #5a5d67;text-decoration: none;">
				<strong>X</strong>
			</a>
		</div>
	</div>
</div>-->

<script>
function submitForm(e){
  if (e.keyCode == 13) {
	document.forms[0].submit();
	return false;
  }
}
</script>