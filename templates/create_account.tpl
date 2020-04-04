<div class="logo">
	<img src="./content/assets/admin/layout/img/f1-logo.png" alt=""/>
</div>

<div class="menu-toggler sidebar-toggler">
</div>

<div class="content">
	<form class="login-form" action="?site=create_account" method="post">
		<h3 class="form-title">{translate}tr_create_account_title{/translate}</h3>
		{if isset($error)}
		<div class="alert alert-danger">
			<button class="close" data-close="alert"></button>
			<span>{$error}</span>
		</div>
        {/if}      
		<fieldset>
            <div class="input-prepend" title="Username">
                <span class="add-on"><i class="halflings-icon user"></i></span>
                <input class="input-large span10" name="username" id="username" maxlength="15" type="text" placeholder="{translate}tr_login_type_username_only{/translate}"
                        {if isset($username)}
                            value="{$username}"
                        {/if}
                        />
            </div>
            <div class="clearfix"></div>
            
            <div class="input-prepend" title="Email">
                <span class="add-on"><i class="halflings-icon user"></i></span>
                <input class="input-large span10" name="email" id="email" type="text" placeholder="{translate}tr_create_account_email{/translate}"
                        {if isset($email)}
                            value="{$email}"
                        {/if}
                        />
            </div>
            <div class="clearfix"></div>

            <div class="input-prepend" title="Password1">
                <span class="add-on"><i class="halflings-icon lock"></i></span>
                <input class="input-large span10" name="password" id="password" type="password" placeholder="{translate}tr_login_type_password{/translate}"/>
            </div>
            <div class="clearfix"></div>

            <div class="input-prepend" title="Password2">
                <span class="add-on"><i class="halflings-icon lock"></i></span>
                <input class="input-large span10" name="password2" id="password2" type="password" placeholder="{translate}tr_create_account_password2{/translate}"/>
            </div>
            <div class="clearfix"></div>

            <div class="input-prepend" title="Captcha">
                <img id="captcha" src="lib/securimage/securimage_show.php" alt="CAPTCHA Image" />
                <br>
                <input class="input-large span10" type="text" name="captcha_code" id="captcha_code" size="10" maxlength="6" />
                <!--<br>
                <a class="btn btn-primary" href="#" onclick="document.getElementById('captcha').src = 'lib/securimage/securimage_show.php?' + Math.random(); return false">[ Different Image ]</a>-->
            </div>
            <div class="clearfix"></div>

            <div class="button-login" style="float:right">
                <button type="submit" class="btn btn-primary">{translate}tr_create_account_create{/translate}</button>
            </div>
            <div class="clearfix"></div>
        </fieldset>
    </form>
</div>