<div class="page-content-wrapper">
    <div class="page-content">
    	<div class="row">
    		<div class="col-md-12">
    			<div class="portlet box blue-hoki">
    				<div class="portlet-title">
    					<div class="caption">{translate}tr_statistic_wins_title{/translate}</div>
    					<div class="tools">
    						<div style="float:left">
								<form action="?site=statistic_wins" method="post" style="margin-top: 0px; color:#000">
									<select id="league" name="league" onchange="this.form.submit()">
										<option value="0" {if $league==0}selected{/if}>{translate}all{/translate}</option>
										<option value="1" {if $league==1}selected{/if}>{translate}tr_league_title{/translate} 1</option>
										<option value="2" {if $league==2}selected{/if}>{translate}tr_league_title{/translate} 2</option>
										<option value="3" {if $league==3}selected{/if}>{translate}tr_league_title{/translate} 3</option>
										
									</select>
								</form>
	            			</div>
    					</div>
    				</div>
    				<div class="portlet-body">
    					<ul class="nav nav-tabs">
							<li class="active"><a data-toggle="tab" href="#driver">{translate}tr_statistic_driver_title{/translate}</a></li>
							<li><a data-toggle="tab" href="#team">{translate}tr_statistic_team_title{/translate}</a></li>
						</ul>
					</div>
				</div>
				<div class="tab-content">
					<div id="driver" class="tab-pane fade active in">
						<table class="table table-striped">
							<thead>
							<tr>
								<th>{translate}tr_statistic_driver_position{/translate}</th>
								<th>{translate}tr_statistic_driver_picture{/translate}</th>
								<th>{translate}tr_statistic_driver_name{/translate}</th>
								<th class="mobile_invisible_low">{translate}tr_statistic_driver_team_name{/translate}</th>
								<th class="mobile_invisible_high">{translate}tr_statistic_driver_manager_name{/translate}</th>
								{if $league < 2}
								<th nowrap style="text-align:right">{translate}tr_league_title{/translate} 1</th>
								{/if}
								{if $league == 0 || $league == 2}
								<th nowrap style="text-align:right">{translate}tr_league_title{/translate} 2</th>
								{/if}
								{if $league == 0 || $league == 3}
								<th nowrap style="text-align:right">{translate}tr_league_title{/translate} 3</th>
								{/if}
							</tr>
							</thead>
							<tbody>
							{$i=1}
							{section name=driver loop=$drivers}
								<tr {if $drivers[driver].ok > 0}class="line_highlight"{/if}>
									<td>{$i++}</td>
									<td><img src="content/img/driver/{$drivers[driver].picture}" width="50px"/></td>
									<td><a href="?site=driverinfo&id={$drivers[driver].id}">{$drivers[driver].firstname} {$drivers[driver].lastname}</a></td>
									<td style="font-weight:bold" class="mobile_invisible_low"><a style="color:#{$drivers[driver].color1}" href="?site=teaminfo&id={$drivers[driver].team_id}">{$drivers[driver].team}</td>
									{if $drivers[driver].manager_human}
									<td class="mobile_invisible_high"><a href="?site=userinfo&id={$drivers[driver].manager_userid}">{$drivers[driver].manager}</a></td>
									{else}
									<td class="mobile_invisible_high">{$drivers[driver].manager}</td>
									{/if}
									{if $league < 2}
									<td align="right">{$drivers[driver].f1_wins}</td>
									{/if}
									{if $league == 0 || $league == 2}
									<td align="right">{$drivers[driver].f2_wins}</td>
									{/if}
									{if $league == 0 || $league == 3}
									<td align="right">{$drivers[driver].f3_wins}</td>
									{/if}
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
								<th class="mobile_invisible_high">{translate}tr_statistic_driver_manager_name{/translate}</th>
								{if $league < 2}
								<th nowrap style="text-align:right">{translate}tr_league_title{/translate} 1</th>
								{/if}
									{if $league == 0 || $league == 2}
								<th nowrap style="text-align:right">{translate}tr_league_title{/translate} 2</th>
								{/if}
									{if $league == 0 || $league == 3}
								<th nowrap style="text-align:right">{translate}tr_league_title{/translate} 3</th>
								{/if}
							</tr>
							</thead>
							<tbody>
							{$i=1}
							{section name=team loop=$teams}
								<tr {if $teams[team].id == $team_id}class="line_highlight"{/if}>
									<td>{$i++}</td>
									{if strlen($teams[team].picture) > 1 }
										<td><img class="svg" style="fill: #{$teams[team].color1};" src="content/img/team/{$teams[team].picture}" width="50px"/></td>
									{else}
										<td class="desktop_slider"><img src="content/img/car/team/{$teams[team].id}.png" width="100px"></td>
		                            	<td class="mobile_slider"><img src="content/img/car/team/{$teams[team].id}.png" width="80px"></td>
									{/if}
									<td style="font-weight:bold"><a style="color:#{$teams[team].color1}" href="?site=teaminfo&id={$teams[team].id}">{$teams[team].name}</a></td>
									{if $teams[team].manager_human}
									<td class="mobile_invisible_high"><a href="?site=userinfo&id={$teams[team].manager_userid}">{$teams[team].manager}</a></td>
									{else}
									<td class="mobile_invisible_high">{$teams[team].manager}</td>
									{/if}
									{if $league < 2}
									<td align="right">{$teams[team].f1_wins}</td>
									{/if}
									{if $league == 0 || $league == 2}
									<td align="right">{$teams[team].f2_wins}</td>
									{/if}
									{if $league == 0 || $league == 3}
									<td align="right">{$teams[team].f3_wins}</td>
									{/if}
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
