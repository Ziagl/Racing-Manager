<div class="page-content-wrapper">
    <div class="page-content">
    	<div class="row">
    		<div class="col-md-12">
    			<div class="portlet box blue-hoki">
    				<div class="portlet-title">
    					<div class="caption">{translate}tr_statistic_teaminfo_title{/translate}</div>
    					<div class="tools">
							<form action="?site=statistic_teaminfo" method="post" style="margin-top: 0px; color:#000">
								<select id="league" name="league" onchange="this.form.submit()">
									<option value="1" {if $league==1}selected{/if}>{translate}tr_league_title{/translate} 1</option>
									<option value="2" {if $league==2}selected{/if}>{translate}tr_league_title{/translate} 2</option>
									<option value="3" {if $league==3}selected{/if}>{translate}tr_league_title{/translate} 3</option>
								</select>
							</form>
    					</div>
    				</div>
    				<div class="portlet-body">
						<table class="table table-striped">
		                    <thead>
		                    <tr>
		                        <th>{translate}tr_statistic_driver_picture{/translate}</th>
		                        <th>{translate}tr_statistic_driver_name{/translate}</th>
		                        <th>{translate}tr_statistic_driver_manager_name{/translate}</th>
		                        <th>{translate}tr_car_setting_driver{/translate}</th>
		                        <th class='mobile_invisible_high'>{translate}tr_finance_setting_sponsor{/translate}</th>
		                        <th class='mobile_invisible_high'>{translate}tr_finance_tire_sponsor{/translate}</th>
		                    </tr>
		                    </thead>
		                    <tbody>
		                    {$i=1}
		                    {section name=team loop=$teams}
		                    	{if $teams[team].league == $league}
		                        <tr class="{if $teams[team].id == $team_id}line_highlight{/if}">
		                        	{if strlen($teams[team].picture) > 1 }
		                            	<td><img class="svg" style="fill: #{$teams[team].color1};" src="content/img/team/{$teams[team].picture}" width="50px"/></td>
		                            {else}
		                            	<td class="desktop_slider"><img src="content/img/car/team/{$teams[team].id}.png" width="100px"></td>
		                            	<td class="mobile_slider"><img src="content/img/car/team/{$teams[team].id}.png" width="80px"></td>
		                            {/if}
		                            <td style="font-weight:bold"><a style="color:#{$teams[team].color1};" href="?site=teaminfo&id={$teams[team].id}">{$teams[team].name}</a></td>
		                            {if $teams[team].manager_human}
		                            <td><a href="?site=userinfo&id={$teams[team].manager_userid}">{$teams[team].manager}</a></td>
		                            {else}
		                            <td>{$teams[team].manager}</td>
		                            {/if}
		                            <td>{$teams[team].driver}</td>
		                            <td class="mobile_invisible_high">{$teams[team].sponsor}</td>
		                            <td class="mobile_invisible_high">{$teams[team].tires}</td>
		                        </tr>
		                        {/if}
		                    {/section}
		                    </tbody>
		                </table>
    				</div>
    			</div>
    		</div>
    	</div>
    </div>
</div>