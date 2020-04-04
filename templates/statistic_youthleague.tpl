<div class="page-content-wrapper">
    <div class="page-content">
    	<div class="row">
    		<div class="col-md-12">
    			<div class="portlet box blue-hoki">
    				<div class="portlet-title">
    					<div class="caption">{translate}tr_league_youth_title{/translate}</div>
    				</div>
    				<div class="portlet-body">
    					<ul class="nav nav-tabs">
							<li class="active"><a data-toggle="tab" href="#driver">{translate}tr_statistic_driver_title{/translate}</a></li>
							<li><a data-toggle="tab" href="#team">{translate}tr_statistic_team_title{/translate}</a></li>
						</ul>
						<div class="tab-content">
							<div id="driver" class="tab-pane fade active in">
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
											<td>{$i++}</td>
											<td><img src="content/img/driver/{$drivers[driver].picture}" width="50px"/></td>
											<td><a href="?site=driverinfo&id={$drivers[driver].id}">{$drivers[driver].firstname} {$drivers[driver].lastname}</a></td>
											<td style="font-weight:bold"><a style="color:#{$drivers[driver].color1}" href="?site=teaminfo&id={$drivers[driver].team_id}">{$drivers[driver].team}</td>
											{if $drivers[driver].manager_human}
											<td class="mobile_invisible_high"><a href="?site=userinfo&id={$drivers[driver].manager_userid}">{$drivers[driver].manager}</a></td>
											{else}
											<td class="mobile_invisible_high">{$drivers[driver].manager}</td>
											{/if}
											<td align="right">{$drivers[driver].youth_points}</td>
										</tr>
									{/section}
									</tbody>
								</table>
							</div>
							<div id="team" class="tab-pane fade">
								<table class="table table-striped">
									<thead>
									<tr>
										<th>{translate}tr_statistic_driver_position{/translate}</th>
										<th>{translate}tr_statistic_driver_picture{/translate}</th>
										<th>{translate}tr_statistic_driver_name{/translate}</th>
										<th>{translate}tr_statistic_driver_manager_name{/translate}</th>
										<th>{translate}tr_statistic_driver_points{/translate}</th>
									</tr>
									</thead>
									<tbody>
									{$i=1}
									{section name=team loop=$teams}
										<tr class="{if $teams[team].id == $team_id}line_highlight{/if}">
											<td>{$i++}</td>
											{if strlen($teams[team].picture) > 1 }
						                    	<td><img class="svg" style="fill: #{$teams[team].color1};" src="content/img/team/{$teams[team].picture}" width="50px"/></td>
						                    {else}
						                    	<td class="desktop_slider"><img src="content/img/car/team/{$teams[team].id}.png" width="100px"></td>
						                    	<td class="mobile_slider"><img src="content/img/car/team/{$teams[team].id}.png" width="80px"></td>
						                    {/if}
											<td style="font-weight:bold"><a style="color:#{$teams[team].color1}" href="?site=teaminfo&id={$teams[team].id}">{$teams[team].name}</a></td>
											{if $teams[team].manager_human}
											<td><a href="?site=userinfo&id={$teams[team].manager_userid}">{$teams[team].manager}</a></td>
											{else}
											<td>{$teams[team].manager}</td>
											{/if}
											<td align="right">{$teams[team].youth_points}</td>
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
    </div>
</div>
