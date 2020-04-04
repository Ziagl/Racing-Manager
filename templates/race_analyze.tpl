<div class="page-content-wrapper">
    <div class="page-content">
    	<div class="row">
    		<div class="col-md-12">
    			<div class="portlet box red">
    				<div class="portlet-title">
    					<div class="caption">{translate}tr_race_analyze_title{/translate}</div>
    				</div>
    				<div class="portlet-body">
    					{if $daten}
    					<div id="race" style="height:500px"></div>
    					<br>
    					<div>
    						<table class="table table-striped">
    							<tr>
    								<th>
    									<div class="portlet-body desktop_slider">
    										{translate}Lap{/translate}
    									</div>
    									<div class="portlet-body mobile_slider">
    										{translate}Lap_short{/translate}
    									</div>
    								</th>
    								<th>
    									<div class="portlet-body desktop_slider">
											<form action="?site=race_analyze" method="post" id="driver1_d" name="driver1_d">
												<select name="selected_driver1" onchange="javascript:document.driver1_d.submit()">
												{section name=driver loop=$drivers}	
													<option {if $driver1_active == $drivers[driver].param_id}selected {/if}value='{$drivers[driver].param_id}'>{$drivers[driver].firstname} {$drivers[driver].lastname} ({$drivers[driver].team_name})</option>
												{/section}
												</select>
											</form>
										</div>
										<div class="portlet-body mobile_slider">
											<form action="?site=race_analyze" method="post" id="driver1_m" name="driver1_m">
												<select name="selected_driver1" onchange="javascript:document.driver1_m.submit()">
												{section name=driver loop=$drivers}	
													<option {if $driver1_active == $drivers[driver].param_id}selected {/if}value='{$drivers[driver].param_id}'>{$drivers[driver].lastname}</option>
												{/section}
												</select>
											</form>
										</div>
    								</th>
    								<th>
    									<div class="portlet-body desktop_slider">
											<form action="?site=race_analyze" method="post" id="driver2_d" name="driver2_d">
												<select name="selected_driver2" onchange="javascript:document.driver2_d.submit()">
												{section name=driver loop=$drivers}	
													<option {if $driver2_active == $drivers[driver].param_id}selected {/if}value='{$drivers[driver].param_id}'>{$drivers[driver].firstname} {$drivers[driver].lastname} ({$drivers[driver].team_name})</option>
												{/section}
												</select>
											</form>
										</div>
										<div class="portlet-body mobile_slider">
											<form action="?site=race_analyze" method="post" id="driver2_m" name="driver2_m">
												<select name="selected_driver2" onchange="javascript:document.driver2_m.submit()">
												{section name=driver loop=$drivers}	
													<option {if $driver2_active == $drivers[driver].param_id}selected {/if}value='{$drivers[driver].param_id}'>{$drivers[driver].lastname}</option>
												{/section}
												</select>
											</form>
										</div>
    								</th>
    								<th></th>
    							<tr>
    							{for $i = 1 to $laps}
    							<tr {if $car1_data[$i-1]['safetycar']} class="safetycar"{/if}>
    								<td>{$i}</td>
    								{if count($car1_data) > 0}
										<td{if $car1_data[$i-1]['box'] == 1} class="pit_stop_marker"{/if}>
											<div class="color-box" style="background-color: {if $car1_data[$i-1]['tire_type'] == 0}#ff0000{else}#00ff00{/if};"></div>
											{$car1_data[$i-1]['round_time_readable']}
										</td>
    								{else}
    									<td>{translate}Disqualification{/translate}</td>
    								{/if}
    								{if count($car2_data) > 0}
										<td{if $car2_data[$i-1]['box'] == 1} class="pit_stop_marker"{/if}>
											<div class="color-box" style="background-color: {if $car2_data[$i-1]['tire_type'] == 0}#ff0000{else}#00ff00{/if};"></div>
											{$car2_data[$i-1]['round_time_readable']}
										</td>
									{else}
										<td>{translate}Disqualification{/translate}</td>
    								{/if}
									<td>{$difference[$i-1]['time_readable']}</td>
    							</tr>
    							{/for}
    							<tr>
    								<td></td>
    								{if count($car1_data) > 0}
    									<td><strong>{$car1_data[count($car1_data)-1]['round_time_string']}</strong></td>
    								{else}
    									<td><strong>{translate}Disqualification{/translate}</strong></td>
    								{/if}
    								{if count($car2_data) > 0}
    									<td><strong>{$car2_data[count($car2_data)-1]['round_time_string']}</strong></td>
    								{else}
    									<td><strong>{translate}Disqualification{/translate}</strong></td>
    								{/if}
    								<td>{if $difference_sum > 0}{$difference_sum}{else}-{/if}</td>
    							</tr>
    						</table>
    						<div class="legende">
								<div class="color-box" style="background-color: #0000ff;"></div> {translate}tr_mechanic_setting_pitstop{/translate}<br>
								<div class="color-box" style="background-color: #ffff00;"></div> {translate}safety_car{/translate}<br>
								<div class="color-box" style="background-color: #ff0000;"></div> {translate}tr_finance_setting_tires{/translate}: {translate}tr_race_training_setup_hard{/translate}<br>
								<div class="color-box" style="background-color: #00ff00;"></div> {translate}tr_finance_setting_tires{/translate}: {translate}tr_race_training_setup_soft{/translate}
    						</div>
    					</div>
    					<script>
							var car1 = {$car1_chart};
							var car2 = {$car2_chart};
							var plot = $.plot($("#race"),
							   [ { data: car1, 
								   label: "{if count($car1_data) > 0}{$car1_data[0]['driver_name']}{else} {/if}", 
								   lines: { show: true, 
											fill: false,
											lineWidth: 2 
										  },
								   shadowSize: 0	
								 }, 
								 { data: car2,
								   label: "{if count($car2_data) > 0}{$car2_data[0]['driver_name']}{else} {/if}",
								   lines: { show: true,
											fill: false, 
											lineWidth: 2
										  },
								   shadowSize: 0
								 }
							   ], {
								 grid: { hoverable: false, 
										 clickable: false, 
										 tickColor: "rgba(255,255,255,0.05)",
										 borderWidth: 0
									   },
								 legend: {
											show: true
										 },	
								 colors: ["rgba(255,0,0,0.8)", "rgba(0,255,0,0.8)", "rgba(255,255,0,0.8)", "rgba(255,255,0,0.8)"],
								 xaxis: {literal}{{/literal}ticks:15, axisLabel: "{translate}Lap{/translate}", axisLabelUseCanvas: true, tickDecimals: 0, color: "rgba(255,255,255,0.8)" {literal}}{/literal},
								 yaxis: {literal}{{/literal}ticks:50, max: 1, axisLabel: "{translate}tr_race_training_lap_time{/translate}", axisLabelUseCanvas: true, tickDecimals: 0, color: "rgba(255,255,255,0.8)" {literal}}{/literal},
							});
						</script>
						{else}
							<p>{translate}tr_race_analyze_no_data{/translate}</p>
						{/if}
    				</div>
    			</div>
    		</div>
    	</div>
    </div>
</div>
