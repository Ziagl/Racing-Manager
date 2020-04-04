<div class="logo">
	<img src="./content/assets/admin/layout/img/f1-logo.png" alt=""/>
</div>

<div class="menu-toggler sidebar-toggler">
</div>

<div class="content">
	<form class="login-form" action="?site=reset_password" method="post">
		<h3 class="form-title">{translate}tr_reset_password_title{/translate}</h3>
		{if isset($error)}
		<div class="alert alert-danger">
			<button class="close" data-close="alert"></button>
			<span>{$error}</span>
		</div>
		{/if}
		<fieldset>
            <div class="input-prepend" title="Email">
                <span class="add-on"><i class="halflings-icon user"></i></span>
                <input class="input-large span10" name="email" id="email" type="text" placeholder="{translate}tr_create_account_email{/translate}"
                        {if isset($email)}
                            value="{$email}"
                        {/if}
                        />
            </div>
            <div class="clearfix"></div>

            <div class="input-prepend" title="Captcha">
                <img id="captcha" src="lib/securimage/securimage_show.php" alt="CAPTCHA Image" />
                <br>
                <input class="input-large span10" type="text" name="captcha_code" id="captcha_code" size="10" maxlength="6" />
                <!--<br>
                <a href="#" onclick="document.getElementById('captcha').src = 'lib/securimage/securimage_show.php?' + Math.random(); return false">[ Different Image ]</a>-->
            </div>
            <div class="clearfix"></div>

            <div class="button-login">
                <button type="submit" class="btn btn-primary">{translate}tr_reset_password_button{/translate}</button>
            </div>
            <div class="clearfix"></div>
		</fieldset>
    </form>
</div>