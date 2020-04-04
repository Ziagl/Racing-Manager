<div class="page-content-wrapper">
    <div class="page-content">
    	<div class="row">
    		<div class="col-md-12">
    			<div class="portlet box blue-hoki">
    				<div class="portlet-title">
    					<div class="caption">{translate}tr_statistic_driver_title{/translate}</div>
    					<div class="tools">
    						<form action="?site=statistic_driver" method="post" style="margin-top: 0px; color:#000">
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
		                        <th>{translate}tr_statistic_driver_position{/translate}</th>
		                        <th>{translate}tr_statistic_driver_picture{/translate}</th>
		                        <th>{translate}tr_statistic_driver_name{/translate}</th>
		                        <th>{translate}tr_statistic_driver_team_name{/translate}</th>
		                        <th class="mobile_invisible_high">{translate}tr_statistic_driver_manager_name{/translate}</th>
		                        <th>{translate}tr_statistic_driver_points{/translate}</th>
		                    </tr>
		                    </thead>
		                    <tbody>
		                    {$i=1}
		                    {section name=driver loop=$drivers}
		                        <tr {if $drivers[driver].ok > 0}class="line_highlight"{/if}>
		                            <td>{$i++} {$drivers[driver].change}</td>
		                            <td><img src="content/img/driver/{$drivers[driver].picture}" width="50px"/></td>
		                            <td><a href="?site=driverinfo&id={$drivers[driver].id}">{$drivers[driver].firstname} {$drivers[driver].lastname}</a></td>
		                            <td style="font-weight:bold"><a style="color:#{$drivers[driver].color1}" href="?site=teaminfo&id={$drivers[driver].team_id}">{$drivers[driver].team}</td>
		                            {if $drivers[driver].manager_human}
									<td class="mobile_invisible_high"><a href="?site=userinfo&id={$drivers[driver].manager_userid}">{$drivers[driver].manager}</a></td>
									{else}
									<td class="mobile_invisible_high">{$drivers[driver].manager}</td>
									{/if}
		                            <td align="right">{$drivers[driver].points}</td>
		                        </tr>
		                    {/section}
		                    </tbody>
		                </table>
    				</div>
    			</div>
    		</div>
    	</div>
    </div>
</div>