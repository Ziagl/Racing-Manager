<!-- BEGIN CONTENT -->
<div class="page-content-wrapper">
    <div class="page-content">
    	<div class="row">
    		<div class="col-md-12">
    			<div class="portlet box red">
    				<div class="portlet-title">
    					<div class="caption">{translate}tr_race_qualification_grid_title{/translate}</div>
    					<div class="tools">
    						<form action="?site=race_qualification_grid" method="post" style="margin-top: 0px; color:#000">
								<select id="league" name="league" onchange="this.form.submit()">
									<option value="1" {if $league==1}selected{/if}>{translate}tr_league_title{/translate} 1</option>
									<option value="2" {if $league==2}selected{/if}>{translate}tr_league_title{/translate} 2</option>
									<option value="3" {if $league==3}selected{/if}>{translate}tr_league_title{/translate} 3</option>
								</select>
							</form>
    					</div>
    				</div>
    				<div class="portlet-body">
						{section name=grid loop=$grid}
		                	<div class="row">
								{if $grid[grid].position % 2 != 0}                    		
									<div class="col-md-12 col-xs-12">
										<table style="max-width:500px">
											<tr style="width:100%" {if $grid[grid].highlight == 1}class='line_highlight'{/if}>
												<td style="width:100px">
													<img src="content/img/driver/{$grid[grid].picture}" width="100px"/>
												</td>
												<td style="width:100%; padding-left: 10px;">
													{$grid[grid].position}.<br>
													{translate}tr_car_setting_driver{/translate}: {$grid[grid].name}<br>
													{translate}tr_statistic_driver_team_name{/translate}: {if $grid[grid].highlight == 0}<span style='color:#{$grid[grid].color};font-weight:bold'>{/if}{$grid[grid].team}{if $grid[grid].highlight == 0}</span>{/if}<br>
													{translate}tr_race_training_setup_round_time_short{/translate}: {$grid[grid].laptime}<br>
													{if $grid[grid].diff != ''}
														{translate}tr_race_grandprix_difference_ahead{/translate}: {$grid[grid].diff}
													{/if}
												</td>
											</tr>
										</table>
									</div>
		                    	{else}
		                    		<div class="col-md-12 col-xs-12">
		                    			<table style="max-width:500px">
											<tr style="width:100%" {if $grid[grid].highlight == 1}class='line_highlight'{/if}>
												<td style="width:100%; text-align:right; padding-right: 10px;">
													{$grid[grid].position}.<br>
													{translate}tr_car_setting_driver{/translate}: {$grid[grid].name}<br>
													{translate}tr_statistic_driver_team_name{/translate}: {if $grid[grid].highlight == 0}<span style='color:#{$grid[grid].color};font-weight:bold'>{/if}{$grid[grid].team}{if $grid[grid].highlight == 0}</span>{/if}<br>
													{translate}tr_race_training_setup_round_time_short{/translate}: {$grid[grid].laptime}<br>
													{translate}tr_race_grandprix_difference_ahead{/translate}: {$grid[grid].diff}
												</td>
												<td style="width:100px">
													<img src="content/img/driver/{$grid[grid].picture}" width="100px"/>
												</td>
											</tr>
										</table>
									</div>
		                    	{/if}
		                	</div>
		                {/section}
    				 </div>
    			</div>
    		</div>
    	</div>
    </div>
</div>