<div class="logo">
	<img src="./content/assets/admin/layout/img/f1-logo.png" alt=""/>
</div>

<div class="menu-toggler sidebar-toggler">
</div>

<div class="content">
	<form class="form-horizontal" action="?site=select_instance_and_team" method="post">
		<h3>{translate}tr_select_instance_and_team_title{/translate}</h3>
		{if isset($error)}
		<div class="alert alert-danger">
			<button class="close" data-close="alert"></button>
			<span>{$error}</span>
		</div>
		{/if}
		<fieldset>
			<div class="input-prepend" title="Instance">
				<span class="add-on"><i class="icon-sitemap"></i></span>
				<select id="instance_change" name="instance_change" class="input-large span10" onchange="this.form.submit()"> 
					{section name=instance loop=$instances}
						<option value="{$instances[instance].id}" {if $instances[instance].id == $instance_id}selected{/if}>{$instances[instance].name} ({translate}players{/translate}: {$instances[instance].users})</option>
					{/section}
				</select>
			</div>
			<div class="clearfix"></div>
		</fieldset>
	</form>
	<form class="form-horizontal" action="?site=select_instance_and_team" method="post">
		<fieldset>
			<div class="input-prepend" title="Team">
				<span class="add-on"><i class="icon-group"></i></span>
				<select id="Team" name="Team" class="input-large span10">
					{section name=team loop=$teams}
						<option value="{$teams[team].id}">{$teams[team].name} ({translate}tr_league_title{/translate} {$teams[team].league})</option>
					{/section}
				</select>
			</div>
			<div class="clearfix"></div>

			<div class="button-login">
				<input type="hidden" name="instance" id="instance" value="{$instance_id}"/>
				<button type="submit" class="btn btn-primary" style="float: right; margin-top: 15px;">{translate}tr_select_instance_and_team_button{/translate}</button>
			</div>
			<div class="clearfix"></div>
		</fieldset>
	</form>
</div>