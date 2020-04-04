<div class="page-header navbar navbar-fixed-top">
    <div class="page-header-inner">
        <div class="page-logo" style="padding-top:8px;">
        	<a href="?site=dashboard">
				<img src="content/assets/admin/layout/img/f1-logo.png" alt=""/>
			</a>
            
            <div class="menu-toggler sidebar-toggler hide">
            </div>
        </div>

        <a href="javascript:;" class="menu-toggler responsive-toggler" data-toggle="collapse" data-target=".navbar-collapse">
        </a>

        <div class="top-menu-left desktop_slider">
        	<span class="pull-left" style="margin-top:15px; margin-right:50px;">
        		{if strlen($team.picture) > 1 }
					<img class="svg" style="fill: #{$team.color1};float:left;margin-right:5px;max-height:20px;" src="content/img/team/{$team.picture}"/>
				{else}
					<img src="content/img/car/team/{$team.id}.png" width="50px" style="float:left;margin-right:5px;max-height:20px;">
				{/if}
        		{$team.name} ({translate}tr_league_title{/translate} {$team.league})
        	</span>
            <span class="pull-left" style="margin-top:15px; margin-right:50px;">{translate}tr_finance_setting_value{/translate}: {$current_budget} {translate}tr_global_currency_symbol{/translate}</span>
            <span class="pull-left" style="margin-top:15px;">{translate}tr_race_grandprix_title{/translate}: {$race_name} {$instance.current_race} / {$number_races}</span>
        </div>
        
        <div class="top-menu-left mobile_slider" style="margin-left: 140px;position: absolute;">
        	<div class="pull-left header_first"><i class="fa fa-money"></i> {$current_budget} {translate}tr_global_currency_symbol{/translate}</div>
        	<div class="pull-left header_second"><i class="fa fa-road"></i> {$race_name} {$instance.current_race} / {$number_races}</div>
        </div>

		<div class="top-menu">
            <ul class="nav navbar-nav pull-right">
		        <li class="dropdown dropdown-user">
		            <a class="btn dropdown-toggle" data-toggle="dropdown" href="#">		                
		                <span class="username">
						{$user_name} </span>
                    	<i class="fa fa-angle-down"></i>
		            </a>
		            <ul class="dropdown-menu">
		                <li class="dropdown-menu-title"><span>{translate}tr_header_account_settings{/translate}</span></li>
		                <li><a href="?site=profile"><i class="icon-user"></i> {translate}tr_header_profile{/translate}</a></li>
		                <li><a href="?site=logout"><i class="icon-power"></i> {translate}tr_header_logout{/translate}</a></li>
		            </ul>
		        </li>
            </ul>
        </div>
    </div>
</div>