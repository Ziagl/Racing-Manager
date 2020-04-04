{if $show_result == true}
<script type="text/javascript">
    var result = new Array( {$result_js} );
    var race_translate = '{$race_translate}';
    
    var round = 0;
    
    function race_update()
    {
    	$('#dynamic_list').html(result[round]);
    	$('#race_header').html('<div style="text-align:center"><h2>'+race_translate+' '+(round)+'/'+(result.length - 1)+'</h2></div>');
    	if((round + 1) == result.length)
    	{
    		$('#grandprix_ceremony').css("display", "block");
    	}
    	
    	if(round < result.length - 1)
    	{
    		round++;
    		setTimeout(race_update, {$refreshtime} * 1000);
    	}
    }
    
    $( document ).ready(function() {
	    race_update();
	});
</script>
{/if}
<div class="page-content-wrapper">
    <div class="page-content">
    	<div class="row">
    		<div class="col-md-12">
    			<div class="portlet box red">
    				<div class="portlet-title">
    					<div class="caption">{translate}tr_race_grandprix_title{/translate}</div>
    					{if $show_result == true}
    					<div class="tools">
	    					<form action="?site=race_grandprix" method="post" style="margin-top: 0px; color:#000">
			            		<select id="league" name="league" onchange="this.form.submit()">
				        			<option value="1" {if $league==1}selected{/if}>{translate}tr_league_title{/translate} 1</option>
				        			<option value="2" {if $league==2}selected{/if}>{translate}tr_league_title{/translate} 2</option>
				        			<option value="3" {if $league==3}selected{/if}>{translate}tr_league_title{/translate} 3</option>
			            		</select>
	            			</form>
    					</div>
    					{/if}
    				</div>
    				<div class="portlet-body">
					{if $show_result == true}
						<div id="race_header" class="detail_header"></div>
						<div style="text-align:center; display:none" id="grandprix_ceremony"><h2><a href="?site=race_grandprix_ceremony">{translate}tr_race_grandprix_ceremony_title{/translate}</a></h2></div>
						<table class="table table-striped">
		                    <thead>
		                    <tr>
		                        <th style="width:65px">{translate}tr_statistic_driver_position{/translate}</th>
		                        <th class="mobile_invisible_low">{translate}tr_statistic_driver_position_start{/translate}</th>
		                        <th></th>
		                        <th>{translate}tr_statistic_driver_name{/translate}</th>
		                        <th class="mobile_invisible_low">{translate}tr_statistic_driver_team_name{/translate}</th>
		                        <th class="mobile_invisible_low manager_race">{translate}tr_statistic_driver_manager_name{/translate}</th>
		                        <th class="mobile_invisible_high">{translate}tr_race_training_setup_tires{/translate}</th>
		                        <th class="mobile_invisible_high" style="text-align:right">{translate}tr_race_grandprix_time{/translate}</th>
		                        <th class="mobile_invisible_high" style="text-align:right">{translate}tr_race_qualification_fastest_time{/translate}</th>
		                        <th class="mobile_invisible_low" style="text-align:right">{translate}tr_race_grandprix_last_lap{/translate}</th>
		                        <th style="text-align:right">{translate}tr_race_grandprix_difference_ahead{/translate}</th>
		                        <th class="mobile_invisible_low" style="text-align:right">{translate}tr_race_grandprix_difference_first{/translate}</th>
		                        <th style="text-align:right">{translate}tr_race_grandprix_pitstop{/translate}</th>
		                    </tr>
		                    </thead>
		                    <tbody id="dynamic_list">
		                    {$result[0]}
		                    </tbody>
		                </table>
					{else}
						{if $error != null}
	                        {$error}
	                    {else}
						<ul class="nav nav-tabs" id="myTab">
							<li{if $last_car == 1} class="active"{/if}><a data-toggle="tab" href="#race_car1">{translate}race_car{/translate} 1</a></li>
	                        {if isset($driver2['firstname'])}
	                        <li{if $last_car == 2} class="active"{/if}><a data-toggle="tab" href="#race_car2">{translate}race_car{/translate} 2</a></li>
	                        {/if}
						</ul>
						<div class="tab-content">
	                    	<div id="race_car1" class="tab-pane fade{if $last_car == 1} active in{/if}">
	                    		{if $car1_error != null}
									{$car1_error}
								{else}
	                    		<div class="row">
	                                <div class="col-md-12 col-xs-12">
										<div class="col-md-2 col-xs-4"><img src="content/img/driver/{$driver1['picture']}" width="100px"/></div>
			                            <div class="col-md-4 col-xs-6">
			                                {translate}tr_car_setting_driver{/translate}: <a href="?site=driverinfo&id={$driver1['id']}">{$driver1['firstname']} {$driver1['lastname']}</a><br>
			                                {translate}tr_finance_setting_mechanic{/translate}:<br>
											{translate}tr_mechanic_setting_setup{/translate}: {$setup} % {translate}better{/translate}<br>
											{translate}tr_finance_setting_tires{/translate}: {$tires} % {translate}better{/translate}<br>
			                            </div>
			                            <div class="col-md-3 col-xs-4">
			                                {translate}driver_value{/translate}:<br>
			                                <div class="driver_value">{$driver1.driver_value} %</div>
			                            </div>
			                            <div class="col-md-3 col-xs-4">
			                            	{translate}car_value{/translate}:<br>
			                                <div class="car_value">{$car1.car_value} %</div>
			                            </div>
			                        </div>
			                    </div>
			                    <div class="row">
	                                <div class="col-md-12 col-xs-12">
	                                    {translate}tr_race_qualification_setting_detail{/translate}<br>
	                                    <form action="?site=race_grandprix" method="post">
	                                        <div class="row">
	                                        	<div class="col-md-2 col-xs-4">
	                                                <label class="control-label">{translate}tr_race_training_setup_rounds{/translate}: </label>
	                                            </div>
	                                            <div class="col-md-10 col-xs-8">
	                                            	<div id="rounds_value_slider_desktop" class="desktop_slider">
														<div id="rounds_value_slider" class="slider_black"></div>
														<div id="rounds_value_amount" style="color:#777;font-size:12px;text-align:center;"></div>
													</div>
	                                            	<div id="rounds_value_slider_mobile" class="mobile_slider">
														<select onchange="mobileChangeValue('rounds_value', this);" style="width:100%">
														{for $i = 1 to 40}
															<option value="{$i}" {if $i == $rounds}selected{/if}>{$i} {translate}tr_race_training_setup_rounds{/translate}</option>
														{/for}
														</select>
	                                            	</div>
	                                            	<input id="rounds_value" type="hidden" value="{$rounds}" name="rounds_value">
	                                            </div>
	                                        </div>
	                                        <div class="row control-group">
	                                        	<div class="col-md-2 col-xs-4">
													<label class="control-label">{translate}tr_race_training_setup_tires{/translate}</label>
												</div>
	                                            <div class="col-md-10 col-xs-8">
													<div class="controls">
														<div id="tire_value_desktop" class="desktop_slider">
															{section name=tire loop=$car1_tires}
																<label class="col-md-4 col-xs-4">
																	<input onchange="mobileChangeValue('tire_id', this)" type="radio" name="tire_id" id="tire_id__{$car1_tires[tire].id}" value="{$car1_tires[tire].id}" {if $setting_tire_id_1 == $car1_tires[tire].id}checked{/if}>
																	<img src="content/img/tires/{$car1_tires[tire].tire_picture}" width="40px"/>{$car1_tires[tire].tire_name}
																</label>
															{/section}
														</div>
														<div id="tire_value_mobile" class="mobile_slider">
															<select onchange="mobileChangeValue('tire_id', this)" style="width:100%">
																{section name=tire loop=$car1_tires}
																	<option value="{$car1_tires[tire].id}" {if $setting_tire_id_1 == $car1_tires[tire].id}selected{/if}>{$car1_tires[tire].tire_name}</option>
																{/section}
															</select>
														</div>
														<input type="hidden" id="tire_id" name="tire_id" value="{$setting_tire_id_1}">
													</div>
												</div>
	                                        </div>
	                                        <div id="power_slider_desktop" class="desktop_slider">
												<div class="row">
													<div class="col-md-2 col-xs-2">
														<label class="control-label">{translate}tr_race_training_setup_power{/translate}: </label>
													</div>
													<div class="col-md-10 col-xs-10">
														<div class="col-md-12 col-xs-12">
															<div class="col-md-2 col-xs-2">
																<span>{$steps[0]}</span>
																<div id="power1_slider" class="slider bg-green ui-slider ui-slider-vertical ui-widget ui-widget-content ui-corner-all" style="height: 200px;"></div>
																<!--<span id="power1_amount" class="ui-slider-handle ui-corner-all" tabindex="0"></span>-->
																<input id="power1_value" type="hidden" value="{$settings.power1}" name="power1_value">
															</div>
															<div class="col-md-2 col-xs-2">
																<span>{$steps[1]}</span>
																<div id="power2_slider" class="slider bg-green ui-slider ui-slider-vertical ui-widget ui-widget-content ui-corner-all" style="height: 200px;"></div>
																<!--<span id="power2_amount" class="ui-slider-handle ui-corner-all" tabindex="0"></span>-->
																<input id="power2_value" type="hidden" value="{$settings.power2}" name="power2_value">
															</div>
															<div class="col-md-2 col-xs-2">
																<span>{$steps[2]}</span>
																<div id="power3_slider" class="slider bg-green ui-slider ui-slider-vertical ui-widget ui-widget-content ui-corner-all" style="height: 200px;"></div>
																<!--<span id="power3_amount" class="ui-slider-handle ui-corner-all" tabindex="0"></span>-->
																<input id="power3_value" type="hidden" value="{$settings.power3}" name="power3_value">
															</div>
															<div class="col-md-2 col-xs-2">
																<span>{$steps[3]}</span>
																<div id="power4_slider" class="slider bg-green ui-slider ui-slider-vertical ui-widget ui-widget-content ui-corner-all" style="height: 200px;"></div>
																<!--<span id="power4_amount" class="ui-slider-handle ui-corner-all" tabindex="0"></span>-->
																<input id="power4_value" type="hidden" value="{$settings.power4}" name="power4_value">
															</div>
															<div class="col-md-2 col-xs-2">
																<span>{$steps[4]}</span>
																<div id="power5_slider" class="slider bg-green ui-slider ui-slider-vertical ui-widget ui-widget-content ui-corner-all" style="height: 200px;"></div>
																<!--<span id="power5_amount" class="ui-slider-handle ui-corner-all" tabindex="0"></span>-->
																<input id="power5_value" type="hidden" value="{$settings.power5}" name="power5_value">
															</div>
															<div class="col-md-2 col-xs-2">
																<span>{$steps[5]}</span>
																<div id="power6_slider" class="slider bg-green ui-slider ui-slider-vertical ui-widget ui-widget-content ui-corner-all" style="height: 200px;"></div>
																<!--<span id="power6_amount" class="ui-slider-handle ui-corner-all" tabindex="0"></span>-->
																<input id="power6_value" type="hidden" value="{$settings.power6}" name="power6_value">
															</div>
														</div>
													</div>
												</div>
	                                        </div>
	                                        <div id="power_slider_mobile" class="mobile_slider">
	                                        	<div class="row">
													<div class="col-md-2 col-xs-4">
														<label class="control-label">{translate}tr_race_training_setup_power_short{/translate} {$steps[0]}: </label>
													</div>
													<div class="col-md-5 col-xs-2">
														<!--<span id="power1_amount_mobile" class="ui-slider-handle ui-corner-all" tabindex="0"></span>-->
													</div>
													<div class="col-md-5 col-xs-6">
														<select onchange="mobileChangeValue('power1_value', this); computePowerValues();" style="width:100%">
														{for $i = 0 to 100}
															<option value="{$i}" {if $i == $settings.power1}selected{/if}>{$i} %</option>
														{/for}
														</select>
													</div>
												</div>
												<div class="row">
													<div class="col-md-2 col-xs-4">
														<label class="control-label">{translate}tr_race_training_setup_power_short{/translate} {$steps[1]}: </label>
													</div>
													<div class="col-md-5 col-xs-2">
														<!--<span id="power2_amount_mobile" class="ui-slider-handle ui-corner-all" tabindex="0"></span>-->
													</div>
													<div class="col-md-5 col-xs-6">
														<select onchange="mobileChangeValue('power2_value', this); computePowerValues();" style="width:100%">
														{for $i = 0 to 100}
															<option value="{$i}" {if $i == $settings.power2}selected{/if}>{$i} %</option>
														{/for}
														</select>
													</div>
												</div>
												<div class="row">
													<div class="col-md-2 col-xs-4">
														<label class="control-label">{translate}tr_race_training_setup_power_short{/translate} {$steps[2]}: </label>
													</div>
													<div class="col-md-5 col-xs-2">
														<!--<span id="power3_amount_mobile" class="ui-slider-handle ui-corner-all" tabindex="0"></span>-->
													</div>
													<div class="col-md-5 col-xs-6">
														<select onchange="mobileChangeValue('power3_value', this); computePowerValues();" style="width:100%">
														{for $i = 0 to 100}
															<option value="{$i}" {if $i == $settings.power3}selected{/if}>{$i} %</option>
														{/for}
														</select>
													</div>
												</div>
												<div class="row">
													<div class="col-md-2 col-xs-4">
														<label class="control-label">{translate}tr_race_training_setup_power_short{/translate} {$steps[3]}: </label>
													</div>
													<div class="col-md-5 col-xs-2">
														<!--<span id="power4_amount_mobile" class="ui-slider-handle ui-corner-all" tabindex="0"></span>-->
													</div>
													<div class="col-md-5 col-xs-6">
														<select onchange="mobileChangeValue('power4_value', this); computePowerValues();" style="width:100%">
														{for $i = 0 to 100}
															<option value="{$i}" {if $i == $settings.power4}selected{/if}>{$i} %</option>
														{/for}
														</select>
													</div>
												</div>
												<div class="row">
													<div class="col-md-2 col-xs-4">
														<label class="control-label">{translate}tr_race_training_setup_power_short{/translate} {$steps[4]}: </label>
													</div>
													<div class="col-md-5 col-xs-2">
														<!--<span id="power5_amount_mobile" class="ui-slider-handle ui-corner-all" tabindex="0"></span>-->
													</div>
													<div class="col-md-5 col-xs-6">
														<select onchange="mobileChangeValue('power5_value', this); computePowerValues();" style="width:100%">
														{for $i = 0 to 100}
															<option value="{$i}" {if $i == $settings.power5}selected{/if}>{$i} %</option>
														{/for}
														</select>
													</div>
												</div>
												<div class="row">
													<div class="col-md-2 col-xs-4">
														<label class="control-label">{translate}tr_race_training_setup_power_short{/translate} {$steps[5]}: </label>
													</div>
													<div class="col-md-5 col-xs-2">
														<!--<span id="power6_amount_mobile" class="ui-slider-handle ui-corner-all" tabindex="0"></span>-->
													</div>
													<div class="col-md-5 col-xs-6">
														<select onchange="mobileChangeValue('power6_value', this); computePowerValues();" style="width:100%">
														{for $i = 0 to 100}
															<option value="{$i}" {if $i == $settings.power6}selected{/if}>{$i} %</option>
														{/for}
														</select>
													</div>
												</div>
	                                        </div>
	                                        
	                                        <input type="hidden" name="car" value="1">
						                    <select name="type">
						                        <option selected value="0">1. {translate}tr_race_qualification_setting_detail{/translate}</option>
						                        {if $r1_1 != null}<option selected value="1">2. {translate}tr_race_qualification_setting_detail{/translate}</option>{/if}
						                        {if $r2_1 != null}<option selected value="2">3. {translate}tr_race_qualification_setting_detail{/translate}</option>{/if}
						                        {if $r3_1 != null}<option selected value="3">4. {translate}tr_race_qualification_setting_detail{/translate}</option>{/if}
						                        {if $r4_1 != null}<option selected value="4">5. {translate}tr_race_qualification_setting_detail{/translate}</option>{/if}
						                        {if $r5_1 != null}<option selected value="5">6. {translate}tr_race_qualification_setting_detail{/translate}</option>{/if}
						                        {if $r6_1 != null}<option selected value="6">7. {translate}tr_race_qualification_setting_detail{/translate}</option>{/if}
						                        {if $r7_1 != null}<option selected value="7">8. {translate}tr_race_qualification_setting_detail{/translate}</option>{/if}
						                        {if $r8_1 != null}<option selected value="8">9. {translate}tr_race_qualification_setting_detail{/translate}</option>{/if}
						                        {if $r9_1 != null}<option selected value="9">10. {translate}tr_race_qualification_setting_detail{/translate}</option>{/if}
						                    </select>
						                    <button type="submit" {if !$quali3_1}disabled=""{/if} class="btn btn-primary">{translate}tr_button_save{/translate}</button>
						                    <a class="btn default" href="#responsive" data-toggle="modal">{translate}tr_statistic_track_info_title{/translate}</a>
										</form>
										<div id="responsive" class="modal fade" aria-hidden="true" tabindex="-1" style="display: none;">
											<div class="modal-dialog">
												<div class="modal-content">
													<div class="modal-header">
														<button class="close" aria-hidden="true" data-dismiss="modal" type="button"></button>
														<h4 class="modal-title">{translate}tr_statistic_track_info_title{/translate}</h4>
													</div>
													<div class="modal-body">
														<div class="row">
															<div class="col-md-12 col-xs-12">
																<div class="col-md-3 col-xs-6">
																	{translate}distance{/translate}: {$track['distance']} {translate}meter{/translate}<br/>
																	{translate}curves_straights{/translate}: {$track['curves']}<br/>
																	{translate}weather{/translate}: {translate}{$weather}{/translate}<br/><img src="content/img/weather/{$weather}.png" width="50px"/><br/>
																</div>
																<div class="col-md-3 col-xs-6">
																{translate}tr_race_training_setup_rounds{/translate}: {$track['rounds']}<br/>
																	{translate}tr_driver_setting_country{/translate}: {$country.name} <br/><img src="content/img/flags/{$country.picture}.gif" width="50px"/><br/>
																</div>
																<div class="col-md-6 col-xs-12"><img src="content/img/tracks/{$track['picture']}" width="250px"/></div>
															</div>
														</div>
													</div>
													<div class="modal-footer">
														<button class="btn red" data-dismiss="modal" type="button">{translate}tr_button_ok{/translate}</button>
													</div>
												</div>
											</div>
										</div>
	                                    
										{if !$quali3_1}
										<div style="text-align: center; color: red">{translate}tr_race_grandprix_q3_error{/translate}</div>
										{/if}
	                                    {if $tire_error1 != null}
	                                    <div style="text-align: center; color: red">{$tire_error1}</div>
	                                    {/if}
	                                    {if $setup_error1 != null}
	                                    <div style="text-align: center; color: red">{$setup_error1}</div>
	                                    {/if}
	                                </div>
	                            </div>
	                            
	                            {if $show_result == false}
	                            <div class="row">
                                	<div class="portlet box red">
					    				<div class="portlet-title">
					    					<div class="caption">{translate}training_setup{/translate}</div>
					    					<div class="tools">
												<a class="expand" href="javascript:;"> </a>
											</div>
					    				</div>
					    				<div class="portlet-body" style="display:none">
					    					<div class="desktop_slider">
												<table class="table table-striped">
													<thead>
													<tr>
														<th></th>
														<th>{translate}tr_race_training_setup_round_time{/translate}</th>
														<th>{translate}tr_race_training_setup_front_wing{/translate}</th>
														<th>{translate}tr_race_training_setup_rear_wing{/translate}</th>
														<th>{translate}tr_race_training_setup_front_suspension{/translate}</th>
														<th>{translate}tr_race_training_setup_rear_suspension{/translate}</th>
														<th>{translate}tr_race_training_setup_tire_pressure{/translate}</th>
														<th>{translate}tr_race_training_setup_brake_balance{/translate}</th>
														<th>{translate}tr_race_training_setup_gear_ratio{/translate}</th>
													</tr>
													</thead>
													<tbody>
													<tr>
														<td>{translate}tr_race_training_setup_best_lap{/translate} {translate}tr_race_training_setup_soft{/translate}:</td>
														<td>{$car1_best_lap_soft.round_time_string}</td>
														<td>{$car1_best_lap_soft.front_wing}</td>
														<td>{$car1_best_lap_soft.rear_wing}</td>
														<td>{$car1_best_lap_soft.front_suspension}</td>
														<td>{$car1_best_lap_soft.rear_suspension}</td>
														<td>{$car1_best_lap_soft.tire_pressure}</td>
														<td>{$car1_best_lap_soft.brake_balance}</td>
														<td>{$car1_best_lap_soft.gear_ratio}</td>
													</tr>
													<tr>
														<td>{translate}tr_race_training_setup_best_lap{/translate} {translate}tr_race_training_setup_hard{/translate}:</td>
														<td>{$car1_best_lap_hard.round_time_string}</td>
														<td>{$car1_best_lap_hard.front_wing}</td>
														<td>{$car1_best_lap_hard.rear_wing}</td>
														<td>{$car1_best_lap_hard.front_suspension}</td>
														<td>{$car1_best_lap_hard.rear_suspension}</td>
														<td>{$car1_best_lap_hard.tire_pressure}</td>
														<td>{$car1_best_lap_hard.brake_balance}</td>
														<td>{$car1_best_lap_hard.gear_ratio}</td>
													</tr>
													</tbody>
												</table>
                                            </div>
                                            <div class="mobile_slider">
                                            	<table class="table table-striped">
													<thead>
													<tr>
														<th></th>
														<th>{translate}tr_race_training_setup_round_time_short{/translate}</th>
														<th>{translate}tr_race_training_setup_front_wing_short{/translate}</th>
														<th>{translate}tr_race_training_setup_rear_wing_short{/translate}</th>
														<th>{translate}tr_race_training_setup_front_suspension_short{/translate}</th>
														<th>{translate}tr_race_training_setup_rear_suspension_short{/translate}</th>
														<th>{translate}tr_race_training_setup_tire_pressure_short{/translate}</th>
														<th>{translate}tr_race_training_setup_brake_balance_short{/translate}</th>
														<th>{translate}tr_race_training_setup_gear_ratio_short{/translate}</th>
													</tr>
													</thead>
													<tbody>
													<tr>
														<td>{translate}tr_race_training_setup_soft{/translate}:</td>
														<td>{$car1_best_lap_soft.round_time_string}</td>
														<td>{$car1_best_lap_soft.front_wing}</td>
														<td>{$car1_best_lap_soft.rear_wing}</td>
														<td>{$car1_best_lap_soft.front_suspension}</td>
														<td>{$car1_best_lap_soft.rear_suspension}</td>
														<td>{$car1_best_lap_soft.tire_pressure}</td>
														<td>{$car1_best_lap_soft.brake_balance}</td>
														<td>{$car1_best_lap_soft.gear_ratio}</td>
													</tr>
													<tr>
														<td>{translate}tr_race_training_setup_hard{/translate}:</td>
														<td>{$car1_best_lap_hard.round_time_string}</td>
														<td>{$car1_best_lap_hard.front_wing}</td>
														<td>{$car1_best_lap_hard.rear_wing}</td>
														<td>{$car1_best_lap_hard.front_suspension}</td>
														<td>{$car1_best_lap_hard.rear_suspension}</td>
														<td>{$car1_best_lap_hard.tire_pressure}</td>
														<td>{$car1_best_lap_hard.brake_balance}</td>
														<td>{$car1_best_lap_hard.gear_ratio}</td>
													</tr>
													</tbody>
												</table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                {if $quali_over}
                                <div class="row">
                                	<div class="portlet box red">
					    				<div class="portlet-title">
					    					<div class="caption">{translate}qualification_setup{/translate}</div>
					    					<div class="tools">
												<a class="expand" href="javascript:;"> </a>
											</div>
					    				</div>
					    				<div class="portlet-body" style="display:none">
					    					<div class="desktop_slider">
												<table class="table table-striped">
													<thead>
													<tr>
														<th></th>
														<th>{translate}tr_race_training_setup_tires{/translate}</th>
														<th>{translate}tr_race_training_setup_front_wing{/translate}</th>
														<th>{translate}tr_race_training_setup_rear_wing{/translate}</th>
														<th>{translate}tr_race_training_setup_front_suspension{/translate}</th>
														<th>{translate}tr_race_training_setup_rear_suspension{/translate}</th>
														<th>{translate}tr_race_training_setup_tire_pressure{/translate}</th>
														<th>{translate}tr_race_training_setup_brake_balance{/translate}</th>
														<th>{translate}tr_race_training_setup_gear_ratio{/translate}</th>
													</tr>
													</thead>
													<tbody>
													<tr>
														<td>Q1</td>
														<td>{if $q1_1 != null} {if $q1_1['tire_type'] == 0}{translate}tr_race_training_setup_hard{/translate}{else}{translate}tr_race_training_setup_soft{/translate}{/if} ({$q1_1['tire_number']}){else} - {/if}</td>
														<td>{if $q1_1 != null} {$q1_1['front_wing']} {else} - {/if}</td>
														<td>{if $q1_1 != null} {$q1_1['rear_wing']} {else} - {/if}</td>
														<td>{if $q1_1 != null} {$q1_1['front_suspension']} {else} - {/if}</td>
														<td>{if $q1_1 != null} {$q1_1['rear_suspension']} {else} - {/if}</td>
														<td>{if $q1_1 != null} {$q1_1['tire_pressure']} {else} - {/if}</td>
														<td>{if $q1_1 != null} {$q1_1['brake_balance']} {else} - {/if}</td>
														<td>{if $q1_1 != null} {$q1_1['gear_ratio']} {else} - {/if}</td>
													</tr>
													<tr>
														<td>Q2</td>
														<td>{if $q2_1 != null} {if $q2_1['tire_type'] == 0}{translate}tr_race_training_setup_hard{/translate}{else}{translate}tr_race_training_setup_soft{/translate}{/if} ({$q2_1['tire_number']}){else} - {/if}</td>
														<td>{if $q2_1 != null} {$q2_1['front_wing']} {else} - {/if}</td>
														<td>{if $q2_1 != null} {$q2_1['rear_wing']} {else} - {/if}</td>
														<td>{if $q2_1 != null} {$q2_1['front_suspension']} {else} - {/if}</td>
														<td>{if $q2_1 != null} {$q2_1['rear_suspension']} {else} - {/if}</td>
														<td>{if $q2_1 != null} {$q2_1['tire_pressure']} {else} - {/if}</td>
														<td>{if $q2_1 != null} {$q2_1['brake_balance']} {else} - {/if}</td>
														<td>{if $q2_1 != null} {$q2_1['gear_ratio']} {else} - {/if}</td>
													</tr>
													<tr>
														<td>Q3</td>
														<td>{if $q3_1 != null} {if $q3_1['tire_type'] == 0}{translate}tr_race_training_setup_hard{/translate}{else}{translate}tr_race_training_setup_soft{/translate}{/if} ({$q3_1['tire_number']}){else} - {/if}</td>
														<td>{if $q3_1 != null} {$q3_1['front_wing']} {else} - {/if}</td>
														<td>{if $q3_1 != null} {$q3_1['rear_wing']} {else} - {/if}</td>
														<td>{if $q3_1 != null} {$q3_1['front_suspension']} {else} - {/if}</td>
														<td>{if $q3_1 != null} {$q3_1['rear_suspension']} {else} - {/if}</td>
														<td>{if $q3_1 != null} {$q3_1['tire_pressure']} {else} - {/if}</td>
														<td>{if $q3_1 != null} {$q3_1['brake_balance']} {else} - {/if}</td>
														<td>{if $q3_1 != null} {$q3_1['gear_ratio']} {else} - {/if}</td>
													</tr>
													</tbody>
												</table>
											</div>
											<div class="mobile_slider">
												<table class="table table-striped">
													<thead>
													<tr>
														<th></th>
														<th>{translate}tr_race_training_setup_tires_short{/translate}</th>
														<th>{translate}tr_race_training_setup_front_wing_short{/translate}</th>
														<th>{translate}tr_race_training_setup_rear_wing_short{/translate}</th>
														<th>{translate}tr_race_training_setup_front_suspension_short{/translate}</th>
														<th>{translate}tr_race_training_setup_rear_suspension_short{/translate}</th>
														<th>{translate}tr_race_training_setup_tire_pressure_short{/translate}</th>
														<th>{translate}tr_race_training_setup_brake_balance_short{/translate}</th>
														<th>{translate}tr_race_training_setup_gear_ratio_short{/translate}</th>
													</tr>
													</thead>
													<tbody>
													<tr>
														<td>Q1</td>
														<td>{if $q1_1 != null} {if $q1_1['tire_type'] == 0}{translate}tr_race_training_setup_hard{/translate}{else}{translate}tr_race_training_setup_soft{/translate}{/if} ({$q1_1['tire_number']}){else} - {/if}</td>
														<td>{if $q1_1 != null} {$q1_1['front_wing']} {else} - {/if}</td>
														<td>{if $q1_1 != null} {$q1_1['rear_wing']} {else} - {/if}</td>
														<td>{if $q1_1 != null} {$q1_1['front_suspension']} {else} - {/if}</td>
														<td>{if $q1_1 != null} {$q1_1['rear_suspension']} {else} - {/if}</td>
														<td>{if $q1_1 != null} {$q1_1['tire_pressure']} {else} - {/if}</td>
														<td>{if $q1_1 != null} {$q1_1['brake_balance']} {else} - {/if}</td>
														<td>{if $q1_1 != null} {$q1_1['gear_ratio']} {else} - {/if}</td>
													</tr>
													<tr>
														<td>Q2</td>
														<td>{if $q2_1 != null} {if $q2_1['tire_type'] == 0}{translate}tr_race_training_setup_hard{/translate}{else}{translate}tr_race_training_setup_soft{/translate}{/if} ({$q2_1['tire_number']}){else} - {/if}</td>
														<td>{if $q2_1 != null} {$q2_1['front_wing']} {else} - {/if}</td>
														<td>{if $q2_1 != null} {$q2_1['rear_wing']} {else} - {/if}</td>
														<td>{if $q2_1 != null} {$q2_1['front_suspension']} {else} - {/if}</td>
														<td>{if $q2_1 != null} {$q2_1['rear_suspension']} {else} - {/if}</td>
														<td>{if $q2_1 != null} {$q2_1['tire_pressure']} {else} - {/if}</td>
														<td>{if $q2_1 != null} {$q2_1['brake_balance']} {else} - {/if}</td>
														<td>{if $q2_1 != null} {$q2_1['gear_ratio']} {else} - {/if}</td>
													</tr>
													<tr>
														<td>Q3</td>
														<td>{if $q3_1 != null} {if $q3_1['tire_type'] == 0}{translate}tr_race_training_setup_hard{/translate}{else}{translate}tr_race_training_setup_soft{/translate}{/if} ({$q3_1['tire_number']}){else} - {/if}</td>
														<td>{if $q3_1 != null} {$q3_1['front_wing']} {else} - {/if}</td>
														<td>{if $q3_1 != null} {$q3_1['rear_wing']} {else} - {/if}</td>
														<td>{if $q3_1 != null} {$q3_1['front_suspension']} {else} - {/if}</td>
														<td>{if $q3_1 != null} {$q3_1['rear_suspension']} {else} - {/if}</td>
														<td>{if $q3_1 != null} {$q3_1['tire_pressure']} {else} - {/if}</td>
														<td>{if $q3_1 != null} {$q3_1['brake_balance']} {else} - {/if}</td>
														<td>{if $q3_1 != null} {$q3_1['gear_ratio']} {else} - {/if}</td>
													</tr>
													</tbody>
												</table>
											</div>
                                		</div>
                                	</div>
                                </div>
                                {/if}
                                {/if}

			                    <div class="row">
                                	<div class="portlet box red">
					    				<div class="portlet-title">
					    					<div class="caption">{translate}tr_race_qualification_setting_detail{/translate}</div>
					    				</div>
					    				<div class="portlet-body">
					    					<div class="desktop_slider">
												<table class="table table-striped">
													<thead>
													<tr>
														<th></th>
														<th>{translate}tr_race_training_setup_rounds{/translate}</th>
														<th>{translate}tr_race_training_setup_tires{/translate}</th>
														<th>{translate}Lap{/translate} {$steps[0]}</th>
														<th>{translate}Lap{/translate} {$steps[1]}</th>
														<th>{translate}Lap{/translate} {$steps[2]}</th>
														<th>{translate}Lap{/translate} {$steps[3]}</th>
														<th>{translate}Lap{/translate} {$steps[4]}</th>
														<th>{translate}Lap{/translate} {$steps[5]}</th>
													</tr>
													</thead>
													<tbody>
													{if isset($r1_1['rounds'])}
														<tr>
															<td>{translate}Lap{/translate} 1 - {$r1_1['rounds']}</td>
															<td>{if $r1_1 != null} {$r1_1['rounds']} {/if}</td>
															<td>{if $r1_1 != null} <span style="color:red">{if $r1_1['tire_type'] == 0}{translate}tr_race_training_setup_hard{/translate}{else}{translate}tr_race_training_setup_soft{/translate}{/if} ({$r1_1['tire_number']})</span><br/><span style="font-size:8px">(Wert von Q3)</span> {else} - {/if}</td>
															<td>{if $r1_1 != null} <img src="content/img/battery/horizontal/battery{$r1_1['power1_img']}.png"> {else} - {/if}</td>
															<td>{if $r1_1 != null} <img src="content/img/battery/horizontal/battery{$r1_1['power2_img']}.png"> {else} - {/if}</td>
															<td>{if $r1_1 != null} <img src="content/img/battery/horizontal/battery{$r1_1['power3_img']}.png"> {else} - {/if}</td>
															<td>{if $r1_1 != null} <img src="content/img/battery/horizontal/battery{$r1_1['power4_img']}.png"> {else} - {/if}</td>
															<td>{if $r1_1 != null} <img src="content/img/battery/horizontal/battery{$r1_1['power5_img']}.png"> {else} - {/if}</td>
															<td>{if $r1_1 != null} <img src="content/img/battery/horizontal/battery{$r1_1['power6_img']}.png"> {else} - {/if}</td>
														</tr>
														
														{if ($r1_1['rounds']) <= $track['rounds']}
														<tr>
															<td>1. {translate}tr_mechanic_setting_pitstop{/translate}: </td>
															<td>{$r1_1['rounds']}. {translate}Lap{/translate}</td>
														</tr>
														{/if}
													{/if}
													{if isset($r2_1['rounds'])}
														{if ($r1_1['rounds']) <= $track['rounds']}
														<tr>
															<td>{translate}Lap{/translate} {$r1_1['rounds']} - {if ($r1_1['rounds'] + $r2_1['rounds']) > $track['rounds']} Ziel {else} {$r1_1['rounds'] + $r2_1['rounds']}{/if}</td>
															<td>{if $r2_1 != null} {$r2_1['rounds']} {/if}</td>
															<td>{if $r2_1 != null} {if $r2_1['tire_type'] == 0}{translate}tr_race_training_setup_hard{/translate}{else}{translate}tr_race_training_setup_soft{/translate}{/if} ({$r2_1['tire_number']}){else} - {/if}</td>
															<td>{if $r2_1 != null} <img src="content/img/battery/horizontal/battery{$r2_1['power1_img']}.png"> {else} - {/if}</td>
															<td>{if $r2_1 != null} <img src="content/img/battery/horizontal/battery{$r2_1['power2_img']}.png"> {else} - {/if}</td>
															<td>{if $r2_1 != null} <img src="content/img/battery/horizontal/battery{$r2_1['power3_img']}.png"> {else} - {/if}</td>
															<td>{if $r2_1 != null} <img src="content/img/battery/horizontal/battery{$r2_1['power4_img']}.png"> {else} - {/if}</td>
															<td>{if $r2_1 != null} <img src="content/img/battery/horizontal/battery{$r2_1['power5_img']}.png"> {else} - {/if}</td>
															<td>{if $r2_1 != null} <img src="content/img/battery/horizontal/battery{$r2_1['power6_img']}.png"> {else} - {/if}</td>
														</tr>
														{/if}
														{if ($r1_1['rounds'] + $r2_1['rounds']) <= $track['rounds']}
														<tr>
															<td>2. {translate}tr_mechanic_setting_pitstop{/translate}: </td>
															<td>{$r1_1['rounds'] + $r2_1['rounds']}. {translate}Lap{/translate}</td>
														</tr>
														{/if}
													{/if}
													{if isset($r3_1['rounds'])}
														{if ($r1_1['rounds'] + $r2_1['rounds']) <= $track['rounds']}
														<tr>
															<td>{translate}Lap{/translate} {$r1_1['rounds'] + $r2_1['rounds']} - {if ($r1_1['rounds'] + $r2_1['rounds'] + $r3_1['rounds']) > $track['rounds']} Ziel {else} {$r1_1['rounds'] + $r2_1['rounds'] + $r3_1['rounds']}{/if}</td>
															<td>{if $r3_1 != null} {$r3_1['rounds']} {/if}</td>
															<td>{if $r3_1 != null} {if $r3_1['tire_type'] == 0}{translate}tr_race_training_setup_hard{/translate}{else}{translate}tr_race_training_setup_soft{/translate}{/if} ({$r3_1['tire_number']}){else} - {/if}</td>
															<td>{if $r3_1 != null} <img src="content/img/battery/horizontal/battery{$r3_1['power1_img']}.png"> {else} - {/if}</td>
															<td>{if $r3_1 != null} <img src="content/img/battery/horizontal/battery{$r3_1['power2_img']}.png"> {else} - {/if}</td>
															<td>{if $r3_1 != null} <img src="content/img/battery/horizontal/battery{$r3_1['power3_img']}.png"> {else} - {/if}</td>
															<td>{if $r3_1 != null} <img src="content/img/battery/horizontal/battery{$r3_1['power4_img']}.png"> {else} - {/if}</td>
															<td>{if $r3_1 != null} <img src="content/img/battery/horizontal/battery{$r3_1['power5_img']}.png"> {else} - {/if}</td>
															<td>{if $r3_1 != null} <img src="content/img/battery/horizontal/battery{$r3_1['power6_img']}.png"> {else} - {/if}</td>
														</tr>
														{/if}
														{if ($r1_1['rounds'] + $r2_1['rounds'] + $r3_1['rounds']) <= $track['rounds']}
														<tr>
															<td>3. {translate}tr_mechanic_setting_pitstop{/translate}: </td>
															<td>{$r1_1['rounds'] + $r2_1['rounds'] + $r3_1['rounds']}. {translate}Lap{/translate}</td>
														</tr>
														{/if}
													{/if}
													{if isset($r4_1['rounds'])}
														{if ($r1_1['rounds'] + $r2_1['rounds'] + $r3_1['rounds']) <= $track['rounds']}
														<tr>
															<td>{translate}Lap{/translate} {$r1_1['rounds'] + $r2_1['rounds'] + $r3_1['rounds']} - {if ($r1_1['rounds'] + $r2_1['rounds'] + $r3_1['rounds'] + $r4_1['rounds']) > $track['rounds']} Ziel {else} {$r1_1['rounds'] + $r2_1['rounds'] + $r3_1['rounds'] + $r4_1['rounds']}{/if}</td>
															<td>{if $r4_1 != null} {$r4_1['rounds']} {/if}</td>
															<td>{if $r4_1 != null} {if $r4_1['tire_type'] == 0}{translate}tr_race_training_setup_hard{/translate}{else}{translate}tr_race_training_setup_soft{/translate}{/if} ({$r4_1['tire_number']}){else} - {/if}</td>
															<td>{if $r4_1 != null} <img src="content/img/battery/horizontal/battery{$r4_1['power1_img']}.png"> {else} - {/if}</td>
															<td>{if $r4_1 != null} <img src="content/img/battery/horizontal/battery{$r4_1['power2_img']}.png"> {else} - {/if}</td>
															<td>{if $r4_1 != null} <img src="content/img/battery/horizontal/battery{$r4_1['power3_img']}.png"> {else} - {/if}</td>
															<td>{if $r4_1 != null} <img src="content/img/battery/horizontal/battery{$r4_1['power4_img']}.png"> {else} - {/if}</td>
															<td>{if $r4_1 != null} <img src="content/img/battery/horizontal/battery{$r4_1['power5_img']}.png"> {else} - {/if}</td>
															<td>{if $r4_1 != null} <img src="content/img/battery/horizontal/battery{$r4_1['power6_img']}.png"> {else} - {/if}</td>
														</tr>
														{/if}
														{if ($r1_1['rounds'] + $r2_1['rounds'] + $r3_1['rounds'] + $r4_1['rounds']) <= $track['rounds']}
														<tr>
															<td>4. {translate}tr_mechanic_setting_pitstop{/translate}: </td>
															<td>{$r1_1['rounds'] + $r2_1['rounds'] + $r3_1['rounds'] + $r4_1['rounds']}. {translate}Lap{/translate}</td>
														</tr>
														{/if}
													{/if}
													{if isset($r5_1['rounds'])}
														{if ($r1_1['rounds'] + $r2_1['rounds'] + $r3_1['rounds'] + $r4_1['rounds']) <= $track['rounds']}
														<tr>
															<td>{translate}Lap{/translate} {$r1_1['rounds'] + $r2_1['rounds'] + $r3_1['rounds'] + $r4_1['rounds']} - {if ($r1_1['rounds'] + $r2_1['rounds'] + $r3_1['rounds'] + $r4_1['rounds'] + $r5_1['rounds']) > $track['rounds']} Ziel {else} {$r1_1['rounds'] + $r2_1['rounds'] + $r3_1['rounds'] + $r4_1['rounds'] + $r5_1['rounds']}{/if}</td>
															<td>{if $r5_1 != null} {$r5_1['rounds']} {/if}</td>
															<td>{if $r5_1 != null} {if $r5_1['tire_type'] == 0}{translate}tr_race_training_setup_hard{/translate}{else}{translate}tr_race_training_setup_soft{/translate}{/if} ({$r5_1['tire_number']}){else} - {/if}</td>
															<td>{if $r5_1 != null} <img src="content/img/battery/horizontal/battery{$r5_1['power1_img']}.png"> {else} - {/if}</td>
															<td>{if $r5_1 != null} <img src="content/img/battery/horizontal/battery{$r5_1['power2_img']}.png"> {else} - {/if}</td>
															<td>{if $r5_1 != null} <img src="content/img/battery/horizontal/battery{$r5_1['power3_img']}.png"> {else} - {/if}</td>
															<td>{if $r5_1 != null} <img src="content/img/battery/horizontal/battery{$r5_1['power4_img']}.png"> {else} - {/if}</td>
															<td>{if $r5_1 != null} <img src="content/img/battery/horizontal/battery{$r5_1['power5_img']}.png"> {else} - {/if}</td>
															<td>{if $r5_1 != null} <img src="content/img/battery/horizontal/battery{$r5_1['power6_img']}.png"> {else} - {/if}</td>
														</tr>
														{/if}
														{if ($r1_1['rounds'] + $r2_1['rounds'] + $r3_1['rounds'] + $r4_1['rounds'] + $r5_1['rounds']) <= $track['rounds']}
														<tr>
															<td>5. {translate}tr_mechanic_setting_pitstop{/translate}: </td>
															<td>{$r1_1['rounds'] + $r2_1['rounds'] + $r3_1['rounds'] + $r4_1['rounds'] + $r5_1['rounds']}. {translate}Lap{/translate}</td>
														</tr>
														{/if}
													{/if}
													{if isset($r6_1['rounds'])}
														{if ($r1_1['rounds'] + $r2_1['rounds'] + $r3_1['rounds'] + $r4_1['rounds'] + $r5_1['rounds']) <= $track['rounds']}
														<tr>
															<td>{translate}Lap{/translate} {$r1_1['rounds'] + $r2_1['rounds'] + $r3_1['rounds'] + $r4_1['rounds'] + $r5_1['rounds']} - {if ($r1_1['rounds'] + $r2_1['rounds'] + $r3_1['rounds'] + $r4_1['rounds'] + $r5_1['rounds'] + $r6_1['rounds']) > $track['rounds']} Ziel {else} {$r1_1['rounds'] + $r2_1['rounds'] + $r3_1['rounds'] + $r4_1['rounds'] + $r5_1['rounds'] + $r6_1['rounds']}{/if}</td>
															<td>{if $r6_1 != null} {$r6_1['rounds']} {/if}</td>
															<td>{if $r6_1 != null} {if $r6_1['tire_type'] == 0}{translate}tr_race_training_setup_hard{/translate}{else}{translate}tr_race_training_setup_soft{/translate}{/if} ({$r6_1['tire_number']}){else} - {/if}</td>
															<td>{if $r6_1 != null} <img src="content/img/battery/horizontal/battery{$r6_1['power1_img']}.png"> {else} - {/if}</td>
															<td>{if $r6_1 != null} <img src="content/img/battery/horizontal/battery{$r6_1['power2_img']}.png"> {else} - {/if}</td>
															<td>{if $r6_1 != null} <img src="content/img/battery/horizontal/battery{$r6_1['power3_img']}.png"> {else} - {/if}</td>
															<td>{if $r6_1 != null} <img src="content/img/battery/horizontal/battery{$r6_1['power4_img']}.png"> {else} - {/if}</td>
															<td>{if $r6_1 != null} <img src="content/img/battery/horizontal/battery{$r6_1['power5_img']}.png"> {else} - {/if}</td>
															<td>{if $r6_1 != null} <img src="content/img/battery/horizontal/battery{$r6_1['power6_img']}.png"> {else} - {/if}</td>
														</tr>
														{/if}
														{if ($r1_1['rounds'] + $r2_1['rounds'] + $r3_1['rounds'] + $r4_1['rounds'] + $r5_1['rounds'] + $r6_1['rounds']) <= $track['rounds']}
														<tr>
															<td>6. {translate}tr_mechanic_setting_pitstop{/translate}: </td>
															<td>{$r1_1['rounds'] + $r2_1['rounds'] + $r3_1['rounds'] + $r4_1['rounds'] + $r5_1['rounds'] + $r6_1['rounds']}. {translate}Lap{/translate}</td>
														</tr>
														{/if}
													{/if}
													{if isset($r7_1['rounds'])}
														{if ($r1_1['rounds'] + $r2_1['rounds'] + $r3_1['rounds'] + $r4_1['rounds'] + $r5_1['rounds'] + $r6_1['rounds']) <= $track['rounds']}
														<tr>
															<td>{translate}Lap{/translate} {$r1_1['rounds'] + $r2_1['rounds'] + $r3_1['rounds'] + $r4_1['rounds'] + $r5_1['rounds'] + $r6_1['rounds']} - {if ($r1_1['rounds'] + $r2_1['rounds'] + $r3_1['rounds'] + $r4_1['rounds'] + $r5_1['rounds'] + $r6_1['rounds'] + $r7_1['rounds']) > $track['rounds']} Ziel {else} {$r1_1['rounds'] + $r2_1['rounds'] + $r3_1['rounds'] + $r4_1['rounds'] + $r5_1['rounds'] + $r6_1['rounds'] + $r7_1['rounds']}{/if}</td>
															<td>{if $r7_1 != null} {$r7_1['rounds']} {/if}</td>
															<td>{if $r7_1 != null} {if $r7_1['tire_type'] == 0}{translate}tr_race_training_setup_hard{/translate}{else}{translate}tr_race_training_setup_soft{/translate}{/if} ({$r7_1['tire_number']}){else} - {/if}</td>
															<td>{if $r7_1 != null} <img src="content/img/battery/horizontal/battery{$r7_1['power1_img']}.png"> {else} - {/if}</td>
															<td>{if $r7_1 != null} <img src="content/img/battery/horizontal/battery{$r7_1['power2_img']}.png"> {else} - {/if}</td>
															<td>{if $r7_1 != null} <img src="content/img/battery/horizontal/battery{$r7_1['power3_img']}.png"> {else} - {/if}</td>
															<td>{if $r7_1 != null} <img src="content/img/battery/horizontal/battery{$r7_1['power4_img']}.png"> {else} - {/if}</td>
															<td>{if $r7_1 != null} <img src="content/img/battery/horizontal/battery{$r7_1['power5_img']}.png"> {else} - {/if}</td>
															<td>{if $r7_1 != null} <img src="content/img/battery/horizontal/battery{$r7_1['power6_img']}.png"> {else} - {/if}</td>
														</tr>
														{/if}
														{if ($r1_1['rounds'] + $r2_1['rounds'] + $r3_1['rounds'] + $r4_1['rounds'] + $r5_1['rounds'] + $r6_1['rounds'] + $r7_1['rounds']) <= $track['rounds']}
														<tr>
															<td>7. {translate}tr_mechanic_setting_pitstop{/translate}: </td>
															<td>{$r1_1['rounds'] + $r2_1['rounds'] + $r3_1['rounds'] + $r4_1['rounds'] + $r5_1['rounds'] + $r6_1['rounds'] + $r7_1['rounds']}. {translate}Lap{/translate}</td>
														</tr>
														{/if}
													{/if}
													{if isset($r8_1['rounds'])}
														{if ($r1_1['rounds'] + $r2_1['rounds'] + $r3_1['rounds'] + $r4_1['rounds'] + $r5_1['rounds'] + $r6_1['rounds'] + $r7_1['rounds']) <= $track['rounds']}
														<tr>
															<td>{translate}Lap{/translate} {$r1_1['rounds'] + $r2_1['rounds'] + $r3_1['rounds'] + $r4_1['rounds'] + $r5_1['rounds'] + $r6_1['rounds'] + $r7_1['rounds']} - {if ($r1_1['rounds'] + $r2_1['rounds'] + $r3_1['rounds'] + $r4_1['rounds'] + $r5_1['rounds'] + $r6_1['rounds'] + $r7_1['rounds'] + $r8_1['rounds']) > $track['rounds']} Ziel {else} {$r1_1['rounds'] + $r2_1['rounds'] + $r3_1['rounds'] + $r4_1['rounds'] + $r5_1['rounds'] + $r6_1['rounds'] + $r7_1['rounds'] + $r8_1['rounds']}{/if}</td>
															<td>{if $r8_1 != null} {$r8_1['rounds']} {/if}</td>
															<td>{if $r8_1 != null} {if $r8_1['tire_type'] == 0}{translate}tr_race_training_setup_hard{/translate}{else}{translate}tr_race_training_setup_soft{/translate}{/if} ({$r8_1['tire_number']}){else} - {/if}</td>
															<td>{if $r8_1 != null} <img src="content/img/battery/horizontal/battery{$r8_1['power1_img']}.png"> {else} - {/if}</td>
															<td>{if $r8_1 != null} <img src="content/img/battery/horizontal/battery{$r8_1['power2_img']}.png"> {else} - {/if}</td>
															<td>{if $r8_1 != null} <img src="content/img/battery/horizontal/battery{$r8_1['power3_img']}.png"> {else} - {/if}</td>
															<td>{if $r8_1 != null} <img src="content/img/battery/horizontal/battery{$r8_1['power4_img']}.png"> {else} - {/if}</td>
															<td>{if $r8_1 != null} <img src="content/img/battery/horizontal/battery{$r8_1['power5_img']}.png"> {else} - {/if}</td>
															<td>{if $r8_1 != null} <img src="content/img/battery/horizontal/battery{$r8_1['power6_img']}.png"> {else} - {/if}</td>
														</tr>
														{/if}
														{if ($r1_1['rounds'] + $r2_1['rounds'] + $r3_1['rounds'] + $r4_1['rounds'] + $r5_1['rounds'] + $r6_1['rounds'] + $r7_1['rounds'] + $r8_1['rounds']) <= $track['rounds']}
														<tr>
															<td>8. {translate}tr_mechanic_setting_pitstop{/translate}: </td>
															<td>{$r1_1['rounds'] + $r2_1['rounds'] + $r3_1['rounds'] + $r4_1['rounds'] + $r5_1['rounds'] + $r6_1['rounds'] + $r7_1['rounds'] + $r8_1['rounds']}. {translate}Lap{/translate}</td>
														</tr>
														{/if}
													{/if}
													{if isset($r9_1['rounds'])}
														{if ($r1_1['rounds'] + $r2_1['rounds'] + $r3_1['rounds'] + $r4_1['rounds'] + $r5_1['rounds'] + $r6_1['rounds'] + $r7_1['rounds'] + $r8_1['rounds']) <= $track['rounds']}
														<tr>
															<td>{translate}Lap{/translate} {$r1_1['rounds'] + $r2_1['rounds'] + $r3_1['rounds'] + $r4_1['rounds'] + $r5_1['rounds'] + $r6_1['rounds'] + $r7_1['rounds'] + $r8_1['rounds']} - {if ($r1_1['rounds'] + $r2_1['rounds'] + $r3_1['rounds'] + $r4_1['rounds'] + $r5_1['rounds'] + $r6_1['rounds'] + $r7_1['rounds'] + $r8_1['rounds'] + $r9_1['rounds']) > $track['rounds']} Ziel {else} {$r1_1['rounds'] + $r2_1['rounds'] + $r3_1['rounds'] + $r4_1['rounds'] + $r5_1['rounds'] + $r6_1['rounds'] + $r7_1['rounds'] + $r8_1['rounds'] + $r9_1['rounds']}{/if}</td>
															<td>{if $r9_1 != null} {$r9_1['rounds']} {/if}</td>
															<td>{if $r9_1 != null} {if $r9_1['tire_type'] == 0}{translate}tr_race_training_setup_hard{/translate}{else}{translate}tr_race_training_setup_soft{/translate}{/if} ({$r8_1['tire_number']}){else} - {/if}</td>
															<td>{if $r9_1 != null} <img src="content/img/battery/horizontal/battery{$r9_1['power1_img']}.png"> {else} - {/if}</td>
															<td>{if $r9_1 != null} <img src="content/img/battery/horizontal/battery{$r9_1['power2_img']}.png"> {else} - {/if}</td>
															<td>{if $r9_1 != null} <img src="content/img/battery/horizontal/battery{$r9_1['power3_img']}.png"> {else} - {/if}</td>
															<td>{if $r9_1 != null} <img src="content/img/battery/horizontal/battery{$r9_1['power4_img']}.png"> {else} - {/if}</td>
															<td>{if $r9_1 != null} <img src="content/img/battery/horizontal/battery{$r9_1['power5_img']}.png"> {else} - {/if}</td>
															<td>{if $r9_1 != null} <img src="content/img/battery/horizontal/battery{$r9_1['power6_img']}.png"> {else} - {/if}</td>
														</tr>
														{/if}
														{if ($r1_1['rounds'] + $r2_1['rounds'] + $r3_1['rounds'] + $r4_1['rounds'] + $r5_1['rounds'] + $r6_1['rounds'] + $r7_1['rounds'] + $r8_1['rounds'] + $r9_1['rounds']) <= $track['rounds']}
														<tr>
															<td>9. {translate}tr_mechanic_setting_pitstop{/translate}: </td>
															<td>{$r1_1['rounds'] + $r2_1['rounds'] + $r3_1['rounds'] + $r4_1['rounds'] + $r5_1['rounds'] + $r6_1['rounds'] + $r7_1['rounds'] + $r8_1['rounds'] + $r9_1['rounds']}. {translate}Lap{/translate}</td>
														</tr>
														{/if}
													{/if}
													{if isset($r10_1['rounds'])}
														{if ($r1_1['rounds'] + $r2_1['rounds'] + $r3_1['rounds'] + $r4_1['rounds'] + $r5_1['rounds'] + $r6_1['rounds'] + $r7_1['rounds'] + $r8_1['rounds'] + $r9_1['rounds']) <= $track['rounds']}
														<tr>
															<td>{translate}Lap{/translate} {$r1_1['rounds'] + $r2_1['rounds'] + $r3_1['rounds'] + $r4_1['rounds'] + $r5_1['rounds'] + $r6_1['rounds'] + $r7_1['rounds'] + $r8_1['rounds'] + $r9_1['rounds']} - {if ($r1_1['rounds'] + $r2_1['rounds'] + $r3_1['rounds'] + $r4_1['rounds'] + $r5_1['rounds'] + $r6_1['rounds'] + $r7_1['rounds'] + $r8_1['rounds'] + $r9_1['rounds'] + $r10_1['rounds']) > $track['rounds']} Ziel {else} {$r1_1['rounds'] + $r2_1['rounds'] + $r3_1['rounds'] + $r4_1['rounds'] + $r5_1['rounds'] + $r6_1['rounds'] + $r7_1['rounds'] + $r8_1['rounds'] + $r9_1['rounds'] + $r10_1['rounds']}{/if}</td>
															<td>{if $r10_1 != null} {$r10_1['rounds']} {/if}</td>
															<td>{if $r10_1 != null} {if $r10_1['tire_type'] == 0}{translate}tr_race_training_setup_hard{/translate}{else}{translate}tr_race_training_setup_soft{/translate}{/if} ({$r10_1['tire_number']}){else} - {/if}</td>
															<td>{if $r10_1 != null} <img src="content/img/battery/horizontal/battery{$r10_1['power1_img']}.png"> {else} - {/if}</td>
															<td>{if $r10_1 != null} <img src="content/img/battery/horizontal/battery{$r10_1['power2_img']}.png"> {else} - {/if}</td>
															<td>{if $r10_1 != null} <img src="content/img/battery/horizontal/battery{$r10_1['power3_img']}.png"> {else} - {/if}</td>
															<td>{if $r10_1 != null} <img src="content/img/battery/horizontal/battery{$r10_1['power4_img']}.png"> {else} - {/if}</td>
															<td>{if $r10_1 != null} <img src="content/img/battery/horizontal/battery{$r10_1['power5_img']}.png"> {else} - {/if}</td>
															<td>{if $r10_1 != null} <img src="content/img/battery/horizontal/battery{$r10_1['power6_img']}.png"> {else} - {/if}</td>
														</tr>
														{/if}
													{/if}
													</tbody>
												</table>
											</div>
											<div class="mobile_slider">
												{if isset($r1_1['rounds'])}
												<table class="table table-striped">
													<thead>
													<tr>
														<th>{$steps[0]}</th>
														<th>{$steps[1]}</th>
														<th>{$steps[2]}</th>
														<th>{$steps[3]}</th>
														<th>{$steps[4]}</th>
														<th>{$steps[5]}</th>
													</tr>
													</thead>
													<tbody>
														<tr>
															<td>{if $r1_1 != null} <img src="content/img/battery/vertical/battery{$r1_1['power1_img']}.png"> {else} - {/if}</td>
															<td>{if $r1_1 != null} <img src="content/img/battery/vertical/battery{$r1_1['power2_img']}.png"> {else} - {/if}</td>
															<td>{if $r1_1 != null} <img src="content/img/battery/vertical/battery{$r1_1['power3_img']}.png"> {else} - {/if}</td>
															<td>{if $r1_1 != null} <img src="content/img/battery/vertical/battery{$r1_1['power4_img']}.png"> {else} - {/if}</td>
															<td>{if $r1_1 != null} <img src="content/img/battery/vertical/battery{$r1_1['power5_img']}.png"> {else} - {/if}</td>
															<td>{if $r1_1 != null} <img src="content/img/battery/vertical/battery{$r1_1['power6_img']}.png"> {else} - {/if}</td>
														</tr>
													</tbody>
												</table>
												{/if}
												
												<table class="table table-striped">
													<thead>
													<tr>
														<th></th>
														<th>{translate}tr_race_training_setup_rounds{/translate}</th>
														<th>{translate}tr_race_training_setup_tires{/translate}</th>
													</tr>
													</thead>
													<tbody>
													{if isset($r1_1['rounds'])}
														<tr>
															<td>{translate}Lap{/translate} 1 - {$r1_1['rounds']}</td>
															<td>{if $r1_1 != null} {$r1_1['rounds']} {/if}</td>
															<td>{if $r1_1 != null} <span style="color:red">{if $r1_1['tire_type'] == 0}{translate}tr_race_training_setup_hard{/translate}{else}{translate}tr_race_training_setup_soft{/translate}{/if} ({$r1_1['tire_number']})</span><br/><span style="font-size:8px">(Wert von Q3)</span> {else} - {/if}</td>
														</tr>
														
														{if ($r1_1['rounds'] + $r2_1['rounds']) <= $track['rounds']}
														<tr>
															<td>1. {translate}tr_mechanic_setting_pitstop{/translate}: </td>
															<td>{$r1_1['rounds']}. {translate}Lap{/translate}</td>
														</tr>
														{/if}
													{/if}
													{if isset($r2_1['rounds'])}
														{if ($r1_1['rounds']) <= $track['rounds']}
														<tr>
															<td>{translate}Lap{/translate} {$r1_1['rounds']} - {if ($r1_1['rounds'] + $r2_1['rounds']) > $track['rounds']} Ziel {else} {$r1_1['rounds'] + $r2_1['rounds']}{/if}</td>
															<td>{if $r2_1 != null} {$r2_1['rounds']} {/if}</td>
															<td>{if $r2_1 != null} {if $r2_1['tire_type'] == 0}{translate}tr_race_training_setup_hard{/translate}{else}{translate}tr_race_training_setup_soft{/translate}{/if} ({$r2_1['tire_number']}){else} - {/if}</td>
														</tr>
														{/if}
														{if ($r1_1['rounds'] + $r2_1['rounds']) <= $track['rounds']}
														<tr>
															<td>2. {translate}tr_mechanic_setting_pitstop{/translate}: </td>
															<td>{$r1_1['rounds'] + $r2_1['rounds']}. {translate}Lap{/translate}</td>
														</tr>
														{/if}
													{/if}
													{if isset($r3_1['rounds'])}
														{if ($r1_1['rounds'] + $r2_1['rounds']) <= $track['rounds']}
														<tr>
															<td>{translate}Lap{/translate} {$r1_1['rounds'] + $r2_1['rounds']} - {if ($r1_1['rounds'] + $r2_1['rounds'] + $r3_1['rounds']) > $track['rounds']} Ziel {else} {$r1_1['rounds'] + $r2_1['rounds'] + $r3_1['rounds']}{/if}</td>
															<td>{if $r3_1 != null} {$r3_1['rounds']} {/if}</td>
															<td>{if $r3_1 != null} {if $r3_1['tire_type'] == 0}{translate}tr_race_training_setup_hard{/translate}{else}{translate}tr_race_training_setup_soft{/translate}{/if} ({$r3_1['tire_number']}){else} - {/if}</td>
														</tr>
														{/if}
														{if ($r1_1['rounds'] + $r2_1['rounds'] + $r3_1['rounds']) <= $track['rounds']}
														<tr>
															<td>3. {translate}tr_mechanic_setting_pitstop{/translate}: </td>
															<td>{$r1_1['rounds'] + $r2_1['rounds'] + $r3_1['rounds']}. {translate}Lap{/translate}</td>
														</tr>
														{/if}
													{/if}
													{if isset($r4_1['rounds'])}
														{if ($r1_1['rounds'] + $r2_1['rounds'] + $r3_1['rounds']) <= $track['rounds']}
														<tr>
															<td>{translate}Lap{/translate} {$r1_1['rounds'] + $r2_1['rounds'] + $r3_1['rounds']} - {if ($r1_1['rounds'] + $r2_1['rounds'] + $r3_1['rounds'] + $r4_1['rounds']) > $track['rounds']} Ziel {else} {$r1_1['rounds'] + $r2_1['rounds'] + $r3_1['rounds'] + $r4_1['rounds']}{/if}</td>
															<td>{if $r4_1 != null} {$r4_1['rounds']} {/if}</td>
															<td>{if $r4_1 != null} {if $r4_1['tire_type'] == 0}{translate}tr_race_training_setup_hard{/translate}{else}{translate}tr_race_training_setup_soft{/translate}{/if} ({$r4_1['tire_number']}){else} - {/if}</td>
														</tr>
														{/if}
														{if ($r1_1['rounds'] + $r2_1['rounds'] + $r3_1['rounds'] + $r4_1['rounds']) <= $track['rounds']}
														<tr>
															<td>4. {translate}tr_mechanic_setting_pitstop{/translate}: </td>
															<td>{$r1_1['rounds'] + $r2_1['rounds'] + $r3_1['rounds'] + $r4_1['rounds']}. {translate}Lap{/translate}</td>
														</tr>
														{/if}
													{/if}
													{if isset($r5_1['rounds'])}
														{if ($r1_1['rounds'] + $r2_1['rounds'] + $r3_1['rounds'] + $r4_1['rounds']) <= $track['rounds']}
														<tr>
															<td>{translate}Lap{/translate} {$r1_1['rounds'] + $r2_1['rounds'] + $r3_1['rounds'] + $r4_1['rounds']} - {if ($r1_1['rounds'] + $r2_1['rounds'] + $r3_1['rounds'] + $r4_1['rounds'] + $r5_1['rounds']) > $track['rounds']} Ziel {else} {$r1_1['rounds'] + $r2_1['rounds'] + $r3_1['rounds'] + $r4_1['rounds'] + $r5_1['rounds']}{/if}</td>
															<td>{if $r5_1 != null} {$r5_1['rounds']} {/if}</td>
															<td>{if $r5_1 != null} {if $r5_1['tire_type'] == 0}{translate}tr_race_training_setup_hard{/translate}{else}{translate}tr_race_training_setup_soft{/translate}{/if} ({$r5_1['tire_number']}){else} - {/if}</td>
														</tr>
														{/if}
														{if ($r1_1['rounds'] + $r2_1['rounds'] + $r3_1['rounds'] + $r4_1['rounds'] + $r5_1['rounds']) <= $track['rounds']}
														<tr>
															<td>5. {translate}tr_mechanic_setting_pitstop{/translate}: </td>
															<td>{$r1_1['rounds'] + $r2_1['rounds'] + $r3_1['rounds'] + $r4_1['rounds'] + $r5_1['rounds']}. {translate}Lap{/translate}</td>
														</tr>
														{/if}
													{/if}
													{if isset($r6_1['rounds'])}
														{if ($r1_1['rounds'] + $r2_1['rounds'] + $r3_1['rounds'] + $r4_1['rounds'] + $r5_1['rounds']) <= $track['rounds']}
														<tr>
															<td>{translate}Lap{/translate} {$r1_1['rounds'] + $r2_1['rounds'] + $r3_1['rounds'] + $r4_1['rounds'] + $r5_1['rounds']} - {if ($r1_1['rounds'] + $r2_1['rounds'] + $r3_1['rounds'] + $r4_1['rounds'] + $r5_1['rounds'] + $r6_1['rounds']) > $track['rounds']} Ziel {else} {$r1_1['rounds'] + $r2_1['rounds'] + $r3_1['rounds'] + $r4_1['rounds'] + $r5_1['rounds'] + $r6_1['rounds']}{/if}</td>
															<td>{if $r6_1 != null} {$r6_1['rounds']} {/if}</td>
															<td>{if $r6_1 != null} {if $r6_1['tire_type'] == 0}{translate}tr_race_training_setup_hard{/translate}{else}{translate}tr_race_training_setup_soft{/translate}{/if} ({$r6_1['tire_number']}){else} - {/if}</td>
														</tr>
														{/if}
														{if ($r1_1['rounds'] + $r2_1['rounds'] + $r3_1['rounds'] + $r4_1['rounds'] + $r5_1['rounds'] + $r6_1['rounds']) <= $track['rounds']}
														<tr>
															<td>6. {translate}tr_mechanic_setting_pitstop{/translate}: </td>
															<td>{$r1_1['rounds'] + $r2_1['rounds'] + $r3_1['rounds'] + $r4_1['rounds'] + $r5_1['rounds'] + $r6_1['rounds']}. {translate}Lap{/translate}</td>
														</tr>
														{/if}
													{/if}
													{if isset($r7_1['rounds'])}
														{if ($r1_1['rounds'] + $r2_1['rounds'] + $r3_1['rounds'] + $r4_1['rounds'] + $r5_1['rounds'] + $r6_1['rounds']) <= $track['rounds']}
														<tr>
															<td>{translate}Lap{/translate} {$r1_1['rounds'] + $r2_1['rounds'] + $r3_1['rounds'] + $r4_1['rounds'] + $r5_1['rounds'] + $r6_1['rounds']} - {if ($r1_1['rounds'] + $r2_1['rounds'] + $r3_1['rounds'] + $r4_1['rounds'] + $r5_1['rounds'] + $r6_1['rounds'] + $r7_1['rounds']) > $track['rounds']} Ziel {else} {$r1_1['rounds'] + $r2_1['rounds'] + $r3_1['rounds'] + $r4_1['rounds'] + $r5_1['rounds'] + $r6_1['rounds'] + $r7_1['rounds']}{/if}</td>
															<td>{if $r7_1 != null} {$r7_1['rounds']} {/if}</td>
															<td>{if $r7_1 != null} {if $r7_1['tire_type'] == 0}{translate}tr_race_training_setup_hard{/translate}{else}{translate}tr_race_training_setup_soft{/translate}{/if} ({$r7_1['tire_number']}){else} - {/if}</td>
														</tr>
														{/if}
														{if ($r1_1['rounds'] + $r2_1['rounds'] + $r3_1['rounds'] + $r4_1['rounds'] + $r5_1['rounds'] + $r6_1['rounds'] + $r7_1['rounds']) <= $track['rounds']}
														<tr>
															<td>7. {translate}tr_mechanic_setting_pitstop{/translate}: </td>
															<td>{$r1_1['rounds'] + $r2_1['rounds'] + $r3_1['rounds'] + $r4_1['rounds'] + $r5_1['rounds'] + $r6_1['rounds'] + $r7_1['rounds']}. {translate}Lap{/translate}</td>
														</tr>
														{/if}
													{/if}
													{if isset($r8_1['rounds'])}
														{if ($r1_1['rounds'] + $r2_1['rounds'] + $r3_1['rounds'] + $r4_1['rounds'] + $r5_1['rounds'] + $r6_1['rounds'] + $r7_1['rounds']) <= $track['rounds']}
														<tr>
															<td>{translate}Lap{/translate} {$r1_1['rounds'] + $r2_1['rounds'] + $r3_1['rounds'] + $r4_1['rounds'] + $r5_1['rounds'] + $r6_1['rounds'] + $r7_1['rounds']} - {if ($r1_1['rounds'] + $r2_1['rounds'] + $r3_1['rounds'] + $r4_1['rounds'] + $r5_1['rounds'] + $r6_1['rounds'] + $r7_1['rounds'] + $r8_1['rounds']) > $track['rounds']} Ziel {else} {$r1_1['rounds'] + $r2_1['rounds'] + $r3_1['rounds'] + $r4_1['rounds'] + $r5_1['rounds'] + $r6_1['rounds'] + $r7_1['rounds'] + $r8_1['rounds']}{/if}</td>
															<td>{if $r8_1 != null} {$r8_1['rounds']} {/if}</td>
															<td>{if $r8_1 != null} {if $r8_1['tire_type'] == 0}{translate}tr_race_training_setup_hard{/translate}{else}{translate}tr_race_training_setup_soft{/translate}{/if} ({$r8_1['tire_number']}){else} - {/if}</td>
														</tr>
														{/if}
														{if ($r1_1['rounds'] + $r2_1['rounds'] + $r3_1['rounds'] + $r4_1['rounds'] + $r5_1['rounds'] + $r6_1['rounds'] + $r7_1['rounds'] + $r8_1['rounds']) <= $track['rounds']}
														<tr>
															<td>8. {translate}tr_mechanic_setting_pitstop{/translate}: </td>
															<td>{$r1_1['rounds'] + $r2_1['rounds'] + $r3_1['rounds'] + $r4_1['rounds'] + $r5_1['rounds'] + $r6_1['rounds'] + $r7_1['rounds'] + $r8_1['rounds']}. {translate}Lap{/translate}</td>
														</tr>
														{/if}
													{/if}
													{if isset($r9_1['rounds'])}
														{if ($r1_1['rounds'] + $r2_1['rounds'] + $r3_1['rounds'] + $r4_1['rounds'] + $r5_1['rounds'] + $r6_1['rounds'] + $r7_1['rounds'] + $r8_1['rounds']) <= $track['rounds']}
														<tr>
															<td>{translate}Lap{/translate} {$r1_1['rounds'] + $r2_1['rounds'] + $r3_1['rounds'] + $r4_1['rounds'] + $r5_1['rounds'] + $r6_1['rounds'] + $r7_1['rounds'] + $r8_1['rounds']} - {if ($r1_1['rounds'] + $r2_1['rounds'] + $r3_1['rounds'] + $r4_1['rounds'] + $r5_1['rounds'] + $r6_1['rounds'] + $r7_1['rounds'] + $r8_1['rounds'] + $r9_1['rounds']) > $track['rounds']} Ziel {else} {$r1_1['rounds'] + $r2_1['rounds'] + $r3_1['rounds'] + $r4_1['rounds'] + $r5_1['rounds'] + $r6_1['rounds'] + $r7_1['rounds'] + $r8_1['rounds'] + $r9_1['rounds']}{/if}</td>
															<td>{if $r9_1 != null} {$r9_1['rounds']} {/if}</td>
															<td>{if $r9_1 != null} {if $r9_1['tire_type'] == 0}{translate}tr_race_training_setup_hard{/translate}{else}{translate}tr_race_training_setup_soft{/translate}{/if} ({$r9_1['tire_number']}){else} - {/if}</td>
														</tr>
														{/if}
														{if ($r1_1['rounds'] + $r2_1['rounds'] + $r3_1['rounds'] + $r4_1['rounds'] + $r5_1['rounds'] + $r6_1['rounds'] + $r7_1['rounds'] + $r8_1['rounds'] + $r9_1['rounds']) <= $track['rounds']}
														<tr>
															<td>9. {translate}tr_mechanic_setting_pitstop{/translate}: </td>
															<td>{$r1_1['rounds'] + $r2_1['rounds'] + $r3_1['rounds'] + $r4_1['rounds'] + $r5_1['rounds'] + $r6_1['rounds'] + $r7_1['rounds'] + $r8_1['rounds'] + $r9_1['rounds']}. {translate}Lap{/translate}</td>
														</tr>
														{/if}
													{/if}
													{if isset($r10_1['rounds'])}
														{if ($r1_1['rounds'] + $r2_1['rounds'] + $r3_1['rounds'] + $r4_1['rounds'] + $r5_1['rounds'] + $r6_1['rounds'] + $r7_1['rounds'] + $r8_1['rounds'] + $r9_1['rounds']) <= $track['rounds']}
														<tr>
															<td>{translate}Lap{/translate} {$r1_1['rounds'] + $r2_1['rounds'] + $r3_1['rounds'] + $r4_1['rounds'] + $r5_1['rounds'] + $r6_1['rounds'] + $r7_1['rounds'] + $r8_1['rounds'] + $r9_1['rounds']} - {if ($r1_1['rounds'] + $r2_1['rounds'] + $r3_1['rounds'] + $r4_1['rounds'] + $r5_1['rounds'] + $r6_1['rounds'] + $r7_1['rounds'] + $r8_1['rounds'] + $r9_1['rounds'] + $r10_1['rounds']) > $track['rounds']} Ziel {else} {$r1_1['rounds'] + $r2_1['rounds'] + $r3_1['rounds'] + $r4_1['rounds'] + $r5_1['rounds'] + $r6_1['rounds'] + $r7_1['rounds'] + $r8_1['rounds'] + $r9_1['rounds'] + $r10_1['rounds']}{/if}</td>
															<td>{if $r10_1 != null} {$r10_1['rounds']} {/if}</td>
															<td>{if $r10_1 != null} {if $r10_1['tire_type'] == 0}{translate}tr_race_training_setup_hard{/translate}{else}{translate}tr_race_training_setup_soft{/translate}{/if} ({$r10_1['tire_number']}){else} - {/if}</td>
														</tr>
														{/if}
													{/if}
													</tbody>
												</table>
											</div>
					    				</div>
                                	</div>
								</div>
								{/if}
							</div>
							<div id="race_car2" class="tab-pane fade{if $last_car == 2} active in{/if}">
								{if $car2_error != null}
									{$car2_error}
								{else}
	                    		<div class="row">
	                                <div class="col-md-12 col-xs-12">
										<div class="col-md-2 col-xs-4"><img src="content/img/driver/{$driver2['picture']}" width="100px"/></div>
			                            <div class="col-md-4 col-xs-6">
			                                {translate}tr_car_setting_driver{/translate}: <a href="?site=driverinfo&id={$driver2['id']}">{$driver2['firstname']} {$driver2['lastname']}</a><br>
			                                {translate}tr_finance_setting_mechanic{/translate}:<br>
											{translate}tr_mechanic_setting_setup{/translate}: {$setup} % {translate}better{/translate}<br>
											{translate}tr_finance_setting_tires{/translate}: {$tires} % {translate}better{/translate}<br>
			                            </div>
			                            <div class="col-md-3 col-xs-4">
			                                {translate}driver_value{/translate}:<br>
			                                <div class="driver_value">{$driver2.driver_value} %</div>
			                            </div>
			                            <div class="col-md-3 col-xs-4">
			                            	{translate}car_value{/translate}:<br>
			                                <div class="car_value">{$car2.car_value} %</div>
			                            </div>
			                        </div>
			                    </div>
			                    <div class="row">
	                                <div class="col-md-12">
	                                    {translate}tr_race_qualification_setting_detail{/translate}<br>
	                                    <form action="?site=race_grandprix" method="post">
	                                        <div class="row">
	                                            <div class="col-md-2 col-xs-4">
	                                                <label class="control-label">{translate}tr_race_training_setup_rounds{/translate}: </label>
	                                            </div>
	                                            <div class="col-md-10 col-xs-8">
	                                            	<div id="rounds_value_slider_desktop2" class="desktop_slider">
														<div id="rounds_value_slider2" class="slider_black"></div>
														<div id="rounds_value_amount2" style="color:#777;font-size:12px;text-align:center;"></div>
													</div>
	                                            	<div id="rounds_value_slider_mobile2" class="mobile_slider">
														<select onchange="mobileChangeValue('rounds_value2', this);" style="width:100%">
														{for $i = 1 to 40}
															<option value="{$i}" {if $i == $rounds}selected{/if}>{$i} {translate}tr_race_training_setup_rounds{/translate}</option>
														{/for}
														</select>
	                                            	</div>
	                                            	<input id="rounds_value2" type="hidden" value="{$rounds}" name="rounds_value">
	                                            </div>
	                                        </div>
	                                        <div class="row control-group">
	                                            <div class="col-md-2 col-xs-4">
													<label class="control-label">{translate}tr_race_training_setup_tires{/translate}</label>
												</div>
	                                            <div class="col-md-10 col-xs-8">
													<div class="controls">
														<div id="tire_value_desktop" class="desktop_slider">
															{section name=tire loop=$car2_tires}
																<label class="col-md-4 col-xs-4">
																	<input onchange="mobileChangeValue('tire_id_2', this)" type="radio" name="tire_id" id="tire_id__{$car2_tires[tire].id}" value="{$car2_tires[tire].id}" {if $setting_tire_id_2 == $car2_tires[tire].id}checked{/if}>
																	<img src="content/img/tires/{$car2_tires[tire].tire_picture}" width="40px"/>{$car2_tires[tire].tire_name}
																</label>
															{/section}
														</div>
														<div id="tire_value_mobile" class="mobile_slider">
															<select onchange="mobileChangeValue('tire_id_2', this)" style="width:100%">
																{section name=tire loop=$car2_tires}
																	<option value="{$car2_tires[tire].id}" {if $setting_tire_id_2 == $car2_tires[tire].id}selected{/if}>{$car2_tires[tire].tire_name}</option>
																{/section}
															</select>
														</div>
														<input type="hidden" id="tire_id_2" name="tire_id" value="{$setting_tire_id_2}">
													</div>
												</div>
	                                        </div>
	                                        <div id="power_slider_desktop" class="desktop_slider">
												<div class="row">
													<div class="col-md-2 col-xs-2">
														<label class="control-label">{translate}tr_race_training_setup_power{/translate}: </label>
													</div>
													<div class="col-md-10 col-xs-10">
														<div class="col-md-12 col-xs-12">
															<div class="col-md-2 col-xs-2">
																<span>{$steps[0]}</span>
																<div id="power1_slider2" class="slider bg-green ui-slider ui-slider-vertical ui-widget ui-widget-content ui-corner-all" style="height: 200px;"></div>
																<!--<span id="power1_amount2" class="ui-slider-handle ui-corner-all" tabindex="0"></span>-->
																<input id="power1_value2" type="hidden" value="{$settings.power1}" name="power1_value">
															</div>
															<div class="col-md-2 col-xs-2">
																<span>{$steps[1]}</span>
																<div id="power2_slider2" class="slider bg-green ui-slider ui-slider-vertical ui-widget ui-widget-content ui-corner-all" style="height: 200px;"></div>
																<!--<span id="power2_amount2" class="ui-slider-handle ui-corner-all" tabindex="0"></span>-->
																<input id="power2_value2" type="hidden" value="{$settings.power2}" name="power2_value">
															</div>
															<div class="col-md-2 col-xs-2">
																<span>{$steps[2]}</span>
																<div id="power3_slider2" class="slider bg-green ui-slider ui-slider-vertical ui-widget ui-widget-content ui-corner-all" style="height: 200px;"></div>
																<!--<span id="power3_amount2" class="ui-slider-handle ui-corner-all" tabindex="0"></span>-->
																<input id="power3_value2" type="hidden" value="{$settings.power3}" name="power3_value">
															</div>
															<div class="col-md-2 col-xs-2">
																<span>{$steps[3]}</span>
																<div id="power4_slider2" class="slider bg-green ui-slider ui-slider-vertical ui-widget ui-widget-content ui-corner-all" style="height: 200px;"></div>
																<!--<span id="power4_amount2" class="ui-slider-handle ui-corner-all" tabindex="0"></span>-->
																<input id="power4_value2" type="hidden" value="{$settings.power4}" name="power4_value">
															</div>
															<div class="col-md-2 col-xs-2">
																<span>{$steps[4]}</span>
																<div id="power5_slider2" class="slider bg-green ui-slider ui-slider-vertical ui-widget ui-widget-content ui-corner-all" style="height: 200px;"></div>
																<!--<span id="power5_amount2" class="ui-slider-handle ui-corner-all" tabindex="0"></span>-->
																<input id="power5_value2" type="hidden" value="{$settings.power5}" name="power5_value">
															</div>
															<div class="col-md-2 col-xs-2">
																<span>{$steps[5]}</span>
																<div id="power6_slider2" class="slider bg-green ui-slider ui-slider-vertical ui-widget ui-widget-content ui-corner-all" style="height: 200px;"></div>
																<!--<span id="power6_amount2" class="ui-slider-handle ui-corner-all" tabindex="0"></span>-->
																<input id="power6_value2" type="hidden" value="{$settings.power6}" name="power6_value">
															</div>
														</div>
													</div>
												</div>
	                                        </div>
	                                        <div id="power_slider_mobile" class="mobile_slider">
	                                        	<div class="row">
													<div class="col-md-2 col-xs-4">
														<label class="control-label">{translate}tr_race_training_setup_power_short{/translate} {$steps[0]}: </label>
													</div>
													<div class="col-md-5 col-xs-2">
														<!--<span id="power1_amount_mobile2" class="ui-slider-handle ui-corner-all" tabindex="0"></span>-->
													</div>
													<div class="col-md-5 col-xs-6">
														<select onchange="mobileChangeValue('power1_value2', this); computePowerValues2();" style="width:100%">
														{for $i = 0 to 100}
															<option value="{$i}" {if $i == $settings.power1}selected{/if}>{$i} %</option>
														{/for}
														</select>
													</div>
												</div>
												<div class="row">
													<div class="col-md-2 col-xs-4">
														<label class="control-label">{translate}tr_race_training_setup_power_short{/translate} {$steps[1]}: </label>
													</div>
													<div class="col-md-5 col-xs-2">
														<!--<span id="power2_amount_mobile2" class="ui-slider-handle ui-corner-all" tabindex="0"></span>-->
													</div>
													<div class="col-md-5 col-xs-6">
														<select onchange="mobileChangeValue('power2_value2', this); computePowerValues2();" style="width:100%">
														{for $i = 0 to 100}
															<option value="{$i}" {if $i == $settings.power2}selected{/if}>{$i} %</option>
														{/for}
														</select>
													</div>
												</div>
												<div class="row">
													<div class="col-md-2 col-xs-4">
														<label class="control-label">{translate}tr_race_training_setup_power_short{/translate} {$steps[2]}: </label>
													</div>
													<div class="col-md-5 col-xs-2">
														<!--<span id="power3_amount_mobile2" class="ui-slider-handle ui-corner-all" tabindex="0"></span>-->
													</div>
													<div class="col-md-5 col-xs-6">
														<select onchange="mobileChangeValue('power3_value2', this); computePowerValues2();" style="width:100%">
														{for $i = 0 to 100}
															<option value="{$i}" {if $i == $settings.power3}selected{/if}>{$i} %</option>
														{/for}
														</select>
													</div>
												</div>
												<div class="row">
													<div class="col-md-2 col-xs-4">
														<label class="control-label">{translate}tr_race_training_setup_power_short{/translate} {$steps[3]}: </label>
													</div>
													<div class="col-md-5 col-xs-2">
														<!--<span id="power4_amount_mobile2" class="ui-slider-handle ui-corner-all" tabindex="0"></span>-->
													</div>
													<div class="col-md-5 col-xs-6">
														<select onchange="mobileChangeValue('power4_value2', this); computePowerValues2();" style="width:100%">
														{for $i = 0 to 100}
															<option value="{$i}" {if $i == $settings.power4}selected{/if}>{$i} %</option>
														{/for}
														</select>
													</div>
												</div>
												<div class="row">
													<div class="col-md-2 col-xs-4">
														<label class="control-label">{translate}tr_race_training_setup_power_short{/translate} {$steps[4]}: </label>
													</div>
													<div class="col-md-5 col-xs-2">
														<!--<span id="power5_amount_mobile2" class="ui-slider-handle ui-corner-all" tabindex="0"></span>-->
													</div>
													<div class="col-md-5 col-xs-6">
														<select onchange="mobileChangeValue('power5_value2', this); computePowerValues2();" style="width:100%">
														{for $i = 0 to 100}
															<option value="{$i}" {if $i == $settings.power5}selected{/if}>{$i} %</option>
														{/for}
														</select>
													</div>
												</div>
												<div class="row">
													<div class="col-md-2 col-xs-4">
														<label class="control-label">{translate}tr_race_training_setup_power_short{/translate} {$steps[5]}: </label>
													</div>
													<div class="col-md-5 col-xs-2">
														<!--<span id="power6_amount_mobile2" class="ui-slider-handle ui-corner-all" tabindex="0"></span>-->
													</div>
													<div class="col-md-5 col-xs-6">
														<select onchange="mobileChangeValue('power6_value2', this); computePowerValues2();" style="width:100%">
														{for $i = 0 to 100}
															<option value="{$i}" {if $i == $settings.power6}selected{/if}>{$i} %</option>
														{/for}
														</select>
													</div>
												</div>
	                                        </div>
	                                        <input type="hidden" name="car" value="2">
						                    <select name="type">
						                        <option selected value="0">1. {translate}tr_race_qualification_setting_detail{/translate}</option>
						                        {if $r1_2 != null}<option selected value="1">2. {translate}tr_race_qualification_setting_detail{/translate}</option>{/if}
						                        {if $r2_2 != null}<option selected value="2">3. {translate}tr_race_qualification_setting_detail{/translate}</option>{/if}
						                        {if $r3_2 != null}<option selected value="3">4. {translate}tr_race_qualification_setting_detail{/translate}</option>{/if}
						                        {if $r4_2 != null}<option selected value="4">5. {translate}tr_race_qualification_setting_detail{/translate}</option>{/if}
						                        {if $r5_2 != null}<option selected value="5">6. {translate}tr_race_qualification_setting_detail{/translate}</option>{/if}
						                        {if $r6_2 != null}<option selected value="6">7. {translate}tr_race_qualification_setting_detail{/translate}</option>{/if}
						                        {if $r7_2 != null}<option selected value="7">8. {translate}tr_race_qualification_setting_detail{/translate}</option>{/if}
						                        {if $r8_2 != null}<option selected value="8">9. {translate}tr_race_qualification_setting_detail{/translate}</option>{/if}
						                        {if $r9_2 != null}<option selected value="9">10. {translate}tr_race_qualification_setting_detail{/translate}</option>{/if}
						                    </select>
						                    <button type="submit" {if !$quali3_2}disabled=""{/if} class="btn btn-primary">{translate}tr_button_save{/translate}</button>
						                    <a class="btn default" href="#responsive1" data-toggle="modal">{translate}tr_statistic_track_info_title{/translate}</a>
										</form>
										<div id="responsive1" class="modal fade" aria-hidden="true" tabindex="-1" style="display: none;">
											<div class="modal-dialog">
												<div class="modal-content">
													<div class="modal-header">
														<button class="close" aria-hidden="true" data-dismiss="modal" type="button"></button>
														<h4 class="modal-title">{translate}tr_statistic_track_info_title{/translate}</h4>
													</div>
													<div class="modal-body">
														<div class="row">
															<div class="col-md-12 col-xs-12">
																<div class="col-md-3 col-xs-6">
																	{translate}distance{/translate}: {$track['distance']} {translate}meter{/translate}<br/>
																	{translate}curves_straights{/translate}: {$track['curves']}<br/>
																	{translate}weather{/translate}: {translate}{$weather}{/translate}<br/><img src="content/img/weather/{$weather}.png" width="50px"/><br/>
																</div>
																<div class="col-md-3 col-xs-6">
																{translate}tr_race_training_setup_rounds{/translate}: {$track['rounds']}<br/>
																	{translate}tr_driver_setting_country{/translate}: {$country.name} <br/><img src="content/img/flags/{$country.picture}.gif" width="50px"/><br/>
																</div>
																<div class="col-md-6 col-xs-12"><img src="content/img/tracks/{$track['picture']}" width="250px"/></div>
															</div>
														</div>
													</div>
													<div class="modal-footer">
														<button class="btn red" data-dismiss="modal" type="button">{translate}tr_button_ok{/translate}</button>
													</div>
												</div>
											</div>
										</div>
	                                    
										{if !$quali3_2}
										<div style="text-align: center; color: red">{translate}tr_race_grandprix_q3_error{/translate}</div>
										{/if}
	                                    {if $tire_error2 != null}
	                                    <div style="text-align: center; color: red">{$tire_error2}</div>
	                                    {/if}
	                                    {if $setup_error2 != null}
	                                    <div style="text-align: center; color: red">{$setup_error2}</div>
	                                    {/if}
	                                </div>
	                            </div>
	                            
	                            {if $show_result == false}
	                            <div class="row">
                                	<div class="portlet box red">
					    				<div class="portlet-title">
					    					<div class="caption">{translate}training_setup{/translate}</div>
					    					<div class="tools">
												<a class="expand" href="javascript:;"> </a>
											</div>
					    				</div>
					    				<div class="portlet-body" style="display:none">
					    					<div class="desktop_slider">
												<table class="table table-striped">
													<thead>
													<tr>
														<th></th>
														<th>{translate}tr_race_training_setup_round_time{/translate}</th>
														<th>{translate}tr_race_training_setup_front_wing{/translate}</th>
														<th>{translate}tr_race_training_setup_rear_wing{/translate}</th>
														<th>{translate}tr_race_training_setup_front_suspension{/translate}</th>
														<th>{translate}tr_race_training_setup_rear_suspension{/translate}</th>
														<th>{translate}tr_race_training_setup_tire_pressure{/translate}</th>
														<th>{translate}tr_race_training_setup_brake_balance{/translate}</th>
														<th>{translate}tr_race_training_setup_gear_ratio{/translate}</th>
													</tr>
													</thead>
													<tbody>
													<tr>
														<td>{translate}tr_race_training_setup_best_lap{/translate} {translate}tr_race_training_setup_soft{/translate}:</td>
														<td>{$car2_best_lap_soft.round_time_string}</td>
														<td>{$car2_best_lap_soft.front_wing}</td>
														<td>{$car2_best_lap_soft.rear_wing}</td>
														<td>{$car2_best_lap_soft.front_suspension}</td>
														<td>{$car2_best_lap_soft.rear_suspension}</td>
														<td>{$car2_best_lap_soft.tire_pressure}</td>
														<td>{$car2_best_lap_soft.brake_balance}</td>
														<td>{$car2_best_lap_soft.gear_ratio}</td>
													</tr>
													<tr>
														<td>{translate}tr_race_training_setup_best_lap{/translate} {translate}tr_race_training_setup_hard{/translate}:</td>
														<td>{$car2_best_lap_hard.round_time_string}</td>
														<td>{$car2_best_lap_hard.front_wing}</td>
														<td>{$car2_best_lap_hard.rear_wing}</td>
														<td>{$car2_best_lap_hard.front_suspension}</td>
														<td>{$car2_best_lap_hard.rear_suspension}</td>
														<td>{$car2_best_lap_hard.tire_pressure}</td>
														<td>{$car2_best_lap_hard.brake_balance}</td>
														<td>{$car2_best_lap_hard.gear_ratio}</td>
													</tr>
													</tbody>
												</table>
											</div>
											<div class="mobile_slider">
												<table class="table table-striped">
													<thead>
													<tr>
														<th></th>
														<th>{translate}tr_race_training_setup_round_time_short{/translate}</th>
														<th>{translate}tr_race_training_setup_front_wing_short{/translate}</th>
														<th>{translate}tr_race_training_setup_rear_wing_short{/translate}</th>
														<th>{translate}tr_race_training_setup_front_suspension_short{/translate}</th>
														<th>{translate}tr_race_training_setup_rear_suspension_short{/translate}</th>
														<th>{translate}tr_race_training_setup_tire_pressure_short{/translate}</th>
														<th>{translate}tr_race_training_setup_brake_balance_short{/translate}</th>
														<th>{translate}tr_race_training_setup_gear_ratio_short{/translate}</th>
													</tr>
													</thead>
													<tbody>
													<tr>
														<td>{translate}tr_race_training_setup_soft{/translate}:</td>
														<td>{$car2_best_lap_soft.round_time_string}</td>
														<td>{$car2_best_lap_soft.front_wing}</td>
														<td>{$car2_best_lap_soft.rear_wing}</td>
														<td>{$car2_best_lap_soft.front_suspension}</td>
														<td>{$car2_best_lap_soft.rear_suspension}</td>
														<td>{$car2_best_lap_soft.tire_pressure}</td>
														<td>{$car2_best_lap_soft.brake_balance}</td>
														<td>{$car2_best_lap_soft.gear_ratio}</td>
													</tr>
													<tr>
														<td>{translate}tr_race_training_setup_hard{/translate}:</td>
														<td>{$car2_best_lap_hard.round_time_string}</td>
														<td>{$car2_best_lap_hard.front_wing}</td>
														<td>{$car2_best_lap_hard.rear_wing}</td>
														<td>{$car2_best_lap_hard.front_suspension}</td>
														<td>{$car2_best_lap_hard.rear_suspension}</td>
														<td>{$car2_best_lap_hard.tire_pressure}</td>
														<td>{$car2_best_lap_hard.brake_balance}</td>
														<td>{$car2_best_lap_hard.gear_ratio}</td>
													</tr>
													</tbody>
												</table>
											</div>
                                        </div>
                                    </div>
                                </div>
                                {if $quali_over}
                                <div class="row">
                                	<div class="portlet box red">
					    				<div class="portlet-title">
					    					<div class="caption">{translate}qualification_setup{/translate}</div>
					    					<div class="tools">
												<a class="expand" href="javascript:;"> </a>
											</div>
					    				</div>
					    				<div class="portlet-body" style="display:none">
					    					<div class="desktop_slider">
												<table class="table table-striped">
													<thead>
													<tr>
														<th></th>
														<th>{translate}tr_race_training_setup_tires{/translate}</th>
														<th>{translate}tr_race_training_setup_front_wing{/translate}</th>
														<th>{translate}tr_race_training_setup_rear_wing{/translate}</th>
														<th>{translate}tr_race_training_setup_front_suspension{/translate}</th>
														<th>{translate}tr_race_training_setup_rear_suspension{/translate}</th>
														<th>{translate}tr_race_training_setup_tire_pressure{/translate}</th>
														<th>{translate}tr_race_training_setup_brake_balance{/translate}</th>
														<th>{translate}tr_race_training_setup_gear_ratio{/translate}</th>
													</tr>
													</thead>
													<tbody>
													<tr>
														<td>Q1</td>
														<td>{if $q1_2 != null} {if $q1_2['tire_type'] == 0}{translate}tr_race_training_setup_hard{/translate}{else}{translate}tr_race_training_setup_soft{/translate}{/if} ({$q1_2['tire_number']}){else} - {/if}</td>
														<td>{if $q1_2 != null} {$q1_2['front_wing']} {else} - {/if}</td>
														<td>{if $q1_2 != null} {$q1_2['rear_wing']} {else} - {/if}</td>
														<td>{if $q1_2 != null} {$q1_2['front_suspension']} {else} - {/if}</td>
														<td>{if $q1_2 != null} {$q1_2['rear_suspension']} {else} - {/if}</td>
														<td>{if $q1_2 != null} {$q1_2['tire_pressure']} {else} - {/if}</td>
														<td>{if $q1_2 != null} {$q1_2['brake_balance']} {else} - {/if}</td>
														<td>{if $q1_2 != null} {$q1_2['gear_ratio']} {else} - {/if}</td>
													</tr>
													<tr>
														<td>Q2</td>
														<td>{if $q2_2 != null} {if $q2_2['tire_type'] == 0}{translate}tr_race_training_setup_hard{/translate}{else}{translate}tr_race_training_setup_soft{/translate}{/if} ({$q2_2['tire_number']}){else} - {/if}</td>
														<td>{if $q2_2 != null} {$q2_2['front_wing']} {else} - {/if}</td>
														<td>{if $q2_2 != null} {$q2_2['rear_wing']} {else} - {/if}</td>
														<td>{if $q2_2 != null} {$q2_2['front_suspension']} {else} - {/if}</td>
														<td>{if $q2_2 != null} {$q2_2['rear_suspension']} {else} - {/if}</td>
														<td>{if $q2_2 != null} {$q2_2['tire_pressure']} {else} - {/if}</td>
														<td>{if $q2_2 != null} {$q2_2['brake_balance']} {else} - {/if}</td>
														<td>{if $q2_2 != null} {$q2_2['gear_ratio']} {else} - {/if}</td>
													</tr>
													<tr>
														<td>Q3</td>
														<td>{if $q3_2 != null} {if $q3_2['tire_type'] == 0}{translate}tr_race_training_setup_hard{/translate}{else}{translate}tr_race_training_setup_soft{/translate}{/if} ({$q3_2['tire_number']}){else} - {/if}</td>
														<td>{if $q3_2 != null} {$q3_2['front_wing']} {else} - {/if}</td>
														<td>{if $q3_2 != null} {$q3_2['rear_wing']} {else} - {/if}</td>
														<td>{if $q3_2 != null} {$q3_2['front_suspension']} {else} - {/if}</td>
														<td>{if $q3_2 != null} {$q3_2['rear_suspension']} {else} - {/if}</td>
														<td>{if $q3_2 != null} {$q3_2['tire_pressure']} {else} - {/if}</td>
														<td>{if $q3_2 != null} {$q3_2['brake_balance']} {else} - {/if}</td>
														<td>{if $q3_2 != null} {$q3_2['gear_ratio']} {else} - {/if}</td>
													</tr>
													</tbody>
												</table>
											</div>
											<div class="mobile_slider">
												<table class="table table-striped">
													<thead>
													<tr>
														<th></th>
														<th>{translate}tr_race_training_setup_tires_short{/translate}</th>
														<th>{translate}tr_race_training_setup_front_wing_short{/translate}</th>
														<th>{translate}tr_race_training_setup_rear_wing_short{/translate}</th>
														<th>{translate}tr_race_training_setup_front_suspension_short{/translate}</th>
														<th>{translate}tr_race_training_setup_rear_suspension_short{/translate}</th>
														<th>{translate}tr_race_training_setup_tire_pressure_short{/translate}</th>
														<th>{translate}tr_race_training_setup_brake_balance_short{/translate}</th>
														<th>{translate}tr_race_training_setup_gear_ratio_short{/translate}</th>
													</tr>
													</thead>
													<tbody>
													<tr>
														<td>Q1</td>
														<td>{if $q1_2 != null} {if $q1_2['tire_type'] == 0}{translate}tr_race_training_setup_hard{/translate}{else}{translate}tr_race_training_setup_soft{/translate}{/if} ({$q1_2['tire_number']}){else} - {/if}</td>
														<td>{if $q1_2 != null} {$q1_2['front_wing']} {else} - {/if}</td>
														<td>{if $q1_2 != null} {$q1_2['rear_wing']} {else} - {/if}</td>
														<td>{if $q1_2 != null} {$q1_2['front_suspension']} {else} - {/if}</td>
														<td>{if $q1_2 != null} {$q1_2['rear_suspension']} {else} - {/if}</td>
														<td>{if $q1_2 != null} {$q1_2['tire_pressure']} {else} - {/if}</td>
														<td>{if $q1_2 != null} {$q1_2['brake_balance']} {else} - {/if}</td>
														<td>{if $q1_2 != null} {$q1_2['gear_ratio']} {else} - {/if}</td>
													</tr>
													<tr>
														<td>Q2</td>
														<td>{if $q2_2 != null} {if $q2_2['tire_type'] == 0}{translate}tr_race_training_setup_hard{/translate}{else}{translate}tr_race_training_setup_soft{/translate}{/if} ({$q2_2['tire_number']}){else} - {/if}</td>
														<td>{if $q2_2 != null} {$q2_2['front_wing']} {else} - {/if}</td>
														<td>{if $q2_2 != null} {$q2_2['rear_wing']} {else} - {/if}</td>
														<td>{if $q2_2 != null} {$q2_2['front_suspension']} {else} - {/if}</td>
														<td>{if $q2_2 != null} {$q2_2['rear_suspension']} {else} - {/if}</td>
														<td>{if $q2_2 != null} {$q2_2['tire_pressure']} {else} - {/if}</td>
														<td>{if $q2_2 != null} {$q2_2['brake_balance']} {else} - {/if}</td>
														<td>{if $q2_2 != null} {$q2_2['gear_ratio']} {else} - {/if}</td>
													</tr>
													<tr>
														<td>Q3</td>
														<td>{if $q3_2 != null} {if $q3_2['tire_type'] == 0}{translate}tr_race_training_setup_hard{/translate}{else}{translate}tr_race_training_setup_soft{/translate}{/if} ({$q3_2['tire_number']}){else} - {/if}</td>
														<td>{if $q3_2 != null} {$q3_2['front_wing']} {else} - {/if}</td>
														<td>{if $q3_2 != null} {$q3_2['rear_wing']} {else} - {/if}</td>
														<td>{if $q3_2 != null} {$q3_2['front_suspension']} {else} - {/if}</td>
														<td>{if $q3_2 != null} {$q3_2['rear_suspension']} {else} - {/if}</td>
														<td>{if $q3_2 != null} {$q3_2['tire_pressure']} {else} - {/if}</td>
														<td>{if $q3_2 != null} {$q3_2['brake_balance']} {else} - {/if}</td>
														<td>{if $q3_2 != null} {$q3_2['gear_ratio']} {else} - {/if}</td>
													</tr>
													</tbody>
												</table>
											</div>
                                		</div>
                                	</div>
                                </div>
                                {/if}
	                            {/if}
                                
	                            <div class="row">
                                	<div class="portlet box red">
					    				<div class="portlet-title">
					    					<div class="caption">{translate}tr_race_qualification_setting_detail{/translate}</div>
					    				</div>
					    				<div class="portlet-body">
					    					<div class="desktop_slider">
												<table class="table table-striped">
													<thead>
													<tr>
														<th></th>
														<th>{translate}tr_race_training_setup_rounds{/translate}</th>
														<th>{translate}tr_race_training_setup_tires{/translate}</th>
														<th>{translate}Lap{/translate} {$steps[0]}</th>
														<th>{translate}Lap{/translate} {$steps[1]}</th>
														<th>{translate}Lap{/translate} {$steps[2]}</th>
														<th>{translate}Lap{/translate} {$steps[3]}</th>
														<th>{translate}Lap{/translate} {$steps[4]}</th>
														<th>{translate}Lap{/translate} {$steps[5]}</th>
													</tr>
													</thead>
													<tbody>
													{if isset($r1_2['rounds'])}
														<tr>
															<td>{translate}Lap{/translate} 1 - {$r1_2['rounds']}</td>
															<td>{if $r1_2 != null} {$r1_2['rounds']} {/if}</td>
															<td>{if $r1_2 != null} <span style="color:red">{if $r1_2['tire_type'] == 0}{translate}tr_race_training_setup_hard{/translate}{else}{translate}tr_race_training_setup_soft{/translate}{/if} ({$r1_2['tire_number']})</span><br/><span style="font-size:8px">(Wert von Q3)</span> {else} - {/if}</td>
															<td>{if $r1_2 != null} <img src="content/img/battery/horizontal/battery{$r1_2['power1_img']}.png"> {else} - {/if}</td>
															<td>{if $r1_2 != null} <img src="content/img/battery/horizontal/battery{$r1_2['power2_img']}.png"> {else} - {/if}</td>
															<td>{if $r1_2 != null} <img src="content/img/battery/horizontal/battery{$r1_2['power3_img']}.png"> {else} - {/if}</td>
															<td>{if $r1_2 != null} <img src="content/img/battery/horizontal/battery{$r1_2['power4_img']}.png"> {else} - {/if}</td>
															<td>{if $r1_2 != null} <img src="content/img/battery/horizontal/battery{$r1_2['power5_img']}.png"> {else} - {/if}</td>
															<td>{if $r1_2 != null} <img src="content/img/battery/horizontal/battery{$r1_2['power6_img']}.png"> {else} - {/if}</td>
														</tr>
														{if ($r1_2['rounds']) <= $track['rounds']}
														<tr>
															<td>1. {translate}tr_mechanic_setting_pitstop{/translate}: </td>
															<td>{$r1_2['rounds']}. {translate}Lap{/translate}</td>
														</tr>
														{/if}
													{/if}
													{if isset($r2_2['rounds'])}
														{if ($r1_2['rounds']) <= $track['rounds']}
														<tr>
															<td>{translate}Lap{/translate} {$r1_2['rounds']} - {if ($r1_2['rounds'] + $r2_2['rounds']) > $track['rounds']} Ziel {else} {$r1_2['rounds'] + $r2_2['rounds']}{/if}</td>
															<td>{if $r2_2 != null} {$r2_2['rounds']} {/if}</td>
															<td>{if $r2_2 != null} {if $r2_2['tire_type'] == 0}{translate}tr_race_training_setup_hard{/translate}{else}{translate}tr_race_training_setup_soft{/translate}{/if} ({$r2_2['tire_number']}){else} - {/if}</td>
															<td>{if $r2_2 != null} <img src="content/img/battery/horizontal/battery{$r2_2['power1_img']}.png"> {else} - {/if}</td>
															<td>{if $r2_2 != null} <img src="content/img/battery/horizontal/battery{$r2_2['power2_img']}.png"> {else} - {/if}</td>
															<td>{if $r2_2 != null} <img src="content/img/battery/horizontal/battery{$r2_2['power3_img']}.png"> {else} - {/if}</td>
															<td>{if $r2_2 != null} <img src="content/img/battery/horizontal/battery{$r2_2['power4_img']}.png"> {else} - {/if}</td>
															<td>{if $r2_2 != null} <img src="content/img/battery/horizontal/battery{$r2_2['power5_img']}.png"> {else} - {/if}</td>
															<td>{if $r2_2 != null} <img src="content/img/battery/horizontal/battery{$r2_2['power6_img']}.png"> {else} - {/if}</td>
														</tr>
														{/if}
														{if ($r1_2['rounds'] + $r2_2['rounds']) <= $track['rounds']}
														<tr>
															<td>2. {translate}tr_mechanic_setting_pitstop{/translate}: </td>
															<td>{$r1_2['rounds'] + $r2_2['rounds']}. {translate}Lap{/translate}</td>
														</tr>
														{/if}
													{/if}
													{if isset($r3_2['rounds'])}
														{if ($r1_2['rounds'] + $r2_2['rounds']) <= $track['rounds']}
														<tr>
															<td>{translate}Lap{/translate} {$r1_2['rounds'] + $r2_2['rounds']} - {if ($r1_2['rounds'] + $r2_2['rounds'] + $r3_2['rounds']) > $track['rounds']} Ziel {else} {$r1_2['rounds'] + $r2_2['rounds'] + $r3_2['rounds']}{/if}</td>
															<td>{if $r3_2 != null} {$r3_2['rounds']} {/if}</td>
															<td>{if $r3_2 != null} {if $r3_2['tire_type'] == 0}{translate}tr_race_training_setup_hard{/translate}{else}{translate}tr_race_training_setup_soft{/translate}{/if} ({$r3_2['tire_number']}){else} - {/if}</td>
															<td>{if $r3_2 != null} <img src="content/img/battery/horizontal/battery{$r3_2['power1_img']}.png"> {else} - {/if}</td>
															<td>{if $r3_2 != null} <img src="content/img/battery/horizontal/battery{$r3_2['power2_img']}.png"> {else} - {/if}</td>
															<td>{if $r3_2 != null} <img src="content/img/battery/horizontal/battery{$r3_2['power3_img']}.png"> {else} - {/if}</td>
															<td>{if $r3_2 != null} <img src="content/img/battery/horizontal/battery{$r3_2['power4_img']}.png"> {else} - {/if}</td>
															<td>{if $r3_2 != null} <img src="content/img/battery/horizontal/battery{$r3_2['power5_img']}.png"> {else} - {/if}</td>
															<td>{if $r3_2 != null} <img src="content/img/battery/horizontal/battery{$r3_2['power6_img']}.png"> {else} - {/if}</td>
														</tr>
														{/if}
														{if ($r1_2['rounds'] + $r2_2['rounds'] + $r3_2['rounds']) <= $track['rounds']}
														<tr>
															<td>3. {translate}tr_mechanic_setting_pitstop{/translate}: </td>
															<td>{$r1_2['rounds'] + $r2_2['rounds'] + $r3_2['rounds']}. {translate}Lap{/translate}</td>
														</tr>
														{/if}
													{/if}
													{if isset($r4_2['rounds'])}
														{if ($r1_2['rounds'] + $r2_2['rounds'] + $r3_2['rounds']) <= $track['rounds']}
														<tr>
															<td>{translate}Lap{/translate} {$r1_2['rounds'] + $r2_2['rounds'] + $r3_2['rounds']} - {if ($r1_2['rounds'] + $r2_2['rounds'] + $r3_2['rounds'] + $r4_2['rounds']) > $track['rounds']} Ziel {else} {$r1_2['rounds'] + $r2_2['rounds'] + $r3_2['rounds'] + $r4_2['rounds']}{/if}</td>
															<td>{if $r4_2 != null} {$r4_2['rounds']} {/if}</td>
															<td>{if $r4_2 != null} {if $r4_2['tire_type'] == 0}{translate}tr_race_training_setup_hard{/translate}{else}{translate}tr_race_training_setup_soft{/translate}{/if} ({$r4_2['tire_number']}){else} - {/if}</td>
															<td>{if $r4_2 != null} <img src="content/img/battery/horizontal/battery{$r4_2['power1_img']}.png"> {else} - {/if}</td>
															<td>{if $r4_2 != null} <img src="content/img/battery/horizontal/battery{$r4_2['power2_img']}.png"> {else} - {/if}</td>
															<td>{if $r4_2 != null} <img src="content/img/battery/horizontal/battery{$r4_2['power3_img']}.png"> {else} - {/if}</td>
															<td>{if $r4_2 != null} <img src="content/img/battery/horizontal/battery{$r4_2['power4_img']}.png"> {else} - {/if}</td>
															<td>{if $r4_2 != null} <img src="content/img/battery/horizontal/battery{$r4_2['power5_img']}.png"> {else} - {/if}</td>
															<td>{if $r4_2 != null} <img src="content/img/battery/horizontal/battery{$r4_2['power6_img']}.png"> {else} - {/if}</td>
														</tr>
														{/if}
														{if ($r1_2['rounds'] + $r2_2['rounds'] + $r3_2['rounds'] + $r4_2['rounds']) <= $track['rounds']}
														<tr>
															<td>4. {translate}tr_mechanic_setting_pitstop{/translate}: </td>
															<td>{$r1_2['rounds'] + $r2_2['rounds'] + $r3_2['rounds'] + $r4_2['rounds']}. {translate}Lap{/translate}</td>
														</tr>
														{/if}
													{/if}
													{if isset($r5_2['rounds'])}
														{if ($r1_2['rounds'] + $r2_2['rounds'] + $r3_2['rounds'] + $r4_2['rounds']) <= $track['rounds']}
														<tr>
															<td>{translate}Lap{/translate} {$r1_2['rounds'] + $r2_2['rounds'] + $r3_2['rounds'] + $r4_2['rounds']} - {if ($r1_2['rounds'] + $r2_2['rounds'] + $r3_2['rounds'] + $r4_2['rounds'] + $r5_2['rounds']) > $track['rounds']} Ziel {else} {$r1_2['rounds'] + $r2_2['rounds'] + $r3_2['rounds'] + $r4_2['rounds'] + $r5_2['rounds']}{/if}</td>
															<td>{if $r5_2 != null} {$r5_2['rounds']} {/if}</td>
															<td>{if $r5_2 != null} {if $r5_2['tire_type'] == 0}{translate}tr_race_training_setup_hard{/translate}{else}{translate}tr_race_training_setup_soft{/translate}{/if} ({$r5_2['tire_number']}){else} - {/if}</td>
															<td>{if $r5_2 != null} <img src="content/img/battery/horizontal/battery{$r5_2['power1_img']}.png"> {else} - {/if}</td>
															<td>{if $r5_2 != null} <img src="content/img/battery/horizontal/battery{$r5_2['power2_img']}.png"> {else} - {/if}</td>
															<td>{if $r5_2 != null} <img src="content/img/battery/horizontal/battery{$r5_2['power3_img']}.png"> {else} - {/if}</td>
															<td>{if $r5_2 != null} <img src="content/img/battery/horizontal/battery{$r5_2['power4_img']}.png"> {else} - {/if}</td>
															<td>{if $r5_2 != null} <img src="content/img/battery/horizontal/battery{$r5_2['power5_img']}.png"> {else} - {/if}</td>
															<td>{if $r5_2 != null} <img src="content/img/battery/horizontal/battery{$r5_2['power6_img']}.png"> {else} - {/if}</td>
														</tr>
														{/if}
														{if ($r1_2['rounds'] + $r2_2['rounds'] + $r3_2['rounds'] + $r4_2['rounds'] + $r5_2['rounds']) <= $track['rounds']}
														<tr>
															<td>5. {translate}tr_mechanic_setting_pitstop{/translate}: </td>
															<td>{$r1_2['rounds'] + $r2_2['rounds'] + $r3_2['rounds'] + $r4_2['rounds'] + $r5_2['rounds']}. {translate}Lap{/translate}</td>
														</tr>
														{/if}
													{/if}
													{if isset($r6_2['rounds'])}
														{if ($r1_2['rounds'] + $r2_2['rounds'] + $r3_2['rounds'] + $r4_2['rounds'] + $r5_2['rounds']) <= $track['rounds']}
														<tr>
															<td>{translate}Lap{/translate} {$r1_2['rounds'] + $r2_2['rounds'] + $r3_2['rounds'] + $r4_2['rounds'] + $r5_2['rounds']} - {if ($r1_2['rounds'] + $r2_2['rounds'] + $r3_2['rounds'] + $r4_2['rounds'] + $r5_2['rounds'] + $r6_2['rounds']) > $track['rounds']} Ziel {else} {$r1_2['rounds'] + $r2_2['rounds'] + $r3_2['rounds'] + $r4_2['rounds'] + $r5_2['rounds'] + $r6_2['rounds']}{/if}</td>
															<td>{if $r6_2 != null} {$r6_2['rounds']} {/if}</td>
															<td>{if $r6_2 != null} {if $r6_2['tire_type'] == 0}{translate}tr_race_training_setup_hard{/translate}{else}{translate}tr_race_training_setup_soft{/translate}{/if} ({$r6_2['tire_number']}){else} - {/if}</td>
															<td>{if $r6_2 != null} <img src="content/img/battery/horizontal/battery{$r6_2['power1_img']}.png"> {else} - {/if}</td>
															<td>{if $r6_2 != null} <img src="content/img/battery/horizontal/battery{$r6_2['power2_img']}.png"> {else} - {/if}</td>
															<td>{if $r6_2 != null} <img src="content/img/battery/horizontal/battery{$r6_2['power3_img']}.png"> {else} - {/if}</td>
															<td>{if $r6_2 != null} <img src="content/img/battery/horizontal/battery{$r6_2['power4_img']}.png"> {else} - {/if}</td>
															<td>{if $r6_2 != null} <img src="content/img/battery/horizontal/battery{$r6_2['power5_img']}.png"> {else} - {/if}</td>
															<td>{if $r6_2 != null} <img src="content/img/battery/horizontal/battery{$r6_2['power6_img']}.png"> {else} - {/if}</td>
														</tr>
														{/if}
														{if ($r1_2['rounds'] + $r2_2['rounds'] + $r3_2['rounds'] + $r4_2['rounds'] + $r5_2['rounds'] + $r6_2['rounds']) <= $track['rounds']}
														<tr>
															<td>6. {translate}tr_mechanic_setting_pitstop{/translate}: </td>
															<td>{$r1_2['rounds'] + $r2_2['rounds'] + $r3_2['rounds'] + $r4_2['rounds'] + $r5_2['rounds'] + $r6_2['rounds']}. {translate}Lap{/translate}</td>
														</tr>
														{/if}
													{/if}
													{if isset($r7_2['rounds'])}
														{if ($r1_2['rounds'] + $r2_2['rounds'] + $r3_2['rounds'] + $r4_2['rounds'] + $r5_2['rounds'] + $r6_2['rounds']) <= $track['rounds']}
														<tr>
															<td>{translate}Lap{/translate} {$r1_2['rounds'] + $r2_2['rounds'] + $r3_2['rounds'] + $r4_2['rounds'] + $r5_2['rounds'] + $r6_2['rounds']} - {if ($r1_2['rounds'] + $r2_2['rounds'] + $r3_2['rounds'] + $r4_2['rounds'] + $r5_2['rounds'] + $r6_2['rounds'] + $r7_2['rounds']) > $track['rounds']} Ziel {else} {$r1_2['rounds'] + $r2_2['rounds'] + $r3_2['rounds'] + $r4_2['rounds'] + $r5_2['rounds'] + $r6_2['rounds'] + $r7_2['rounds']}{/if}</td>
															<td>{if $r7_2 != null} {$r7_2['rounds']} {/if}</td>
															<td>{if $r7_2 != null} {if $r7_2['tire_type'] == 0}{translate}tr_race_training_setup_hard{/translate}{else}{translate}tr_race_training_setup_soft{/translate}{/if} ({$r7_2['tire_number']}){else} - {/if}</td>
															<td>{if $r7_2 != null} <img src="content/img/battery/horizontal/battery{$r7_2['power1_img']}.png"> {else} - {/if}</td>
															<td>{if $r7_2 != null} <img src="content/img/battery/horizontal/battery{$r7_2['power2_img']}.png"> {else} - {/if}</td>
															<td>{if $r7_2 != null} <img src="content/img/battery/horizontal/battery{$r7_2['power3_img']}.png"> {else} - {/if}</td>
															<td>{if $r7_2 != null} <img src="content/img/battery/horizontal/battery{$r7_2['power4_img']}.png"> {else} - {/if}</td>
															<td>{if $r7_2 != null} <img src="content/img/battery/horizontal/battery{$r7_2['power5_img']}.png"> {else} - {/if}</td>
															<td>{if $r7_2 != null} <img src="content/img/battery/horizontal/battery{$r7_2['power6_img']}.png"> {else} - {/if}</td>
														</tr>
														{/if}
														{if ($r1_2['rounds'] + $r2_2['rounds'] + $r3_2['rounds'] + $r4_2['rounds'] + $r5_2['rounds'] + $r6_2['rounds'] + $r7_2['rounds']) <= $track['rounds']}
														<tr>
															<td>7. {translate}tr_mechanic_setting_pitstop{/translate}: </td>
															<td>{$r1_2['rounds'] + $r2_2['rounds'] + $r3_2['rounds'] + $r4_2['rounds'] + $r5_2['rounds'] + $r6_2['rounds'] + $r7_2['rounds']}. {translate}Lap{/translate}</td>
														</tr>
														{/if}
													{/if}
													{if isset($r8_2['rounds'])}
														{if ($r1_2['rounds'] + $r2_2['rounds'] + $r3_2['rounds'] + $r4_2['rounds'] + $r5_2['rounds'] + $r6_2['rounds'] + $r7_2['rounds']) <= $track['rounds']}
														<tr>
															<td>{translate}Lap{/translate} {$r1_2['rounds'] + $r2_2['rounds'] + $r3_2['rounds'] + $r4_2['rounds'] + $r5_2['rounds'] + $r6_2['rounds'] + $r7_2['rounds']} - {if ($r1_2['rounds'] + $r2_2['rounds'] + $r3_2['rounds'] + $r4_2['rounds'] + $r5_2['rounds'] + $r6_2['rounds'] + $r7_2['rounds'] + $r8_2['rounds']) > $track['rounds']} Ziel {else} {$r1_2['rounds'] + $r2_2['rounds'] + $r3_2['rounds'] + $r4_2['rounds'] + $r5_2['rounds'] + $r6_2['rounds'] + $r7_2['rounds'] + $r8_2['rounds']}{/if}</td>
															<td>{if $r8_2 != null} {$r8_2['rounds']} {/if}</td>
															<td>{if $r8_2 != null} {if $r8_2['tire_type'] == 0}{translate}tr_race_training_setup_hard{/translate}{else}{translate}tr_race_training_setup_soft{/translate}{/if} ({$r8_2['tire_number']}){else} - {/if}</td>
															<td>{if $r8_2 != null} <img src="content/img/battery/horizontal/battery{$r8_2['power1_img']}.png"> {else} - {/if}</td>
															<td>{if $r8_2 != null} <img src="content/img/battery/horizontal/battery{$r8_2['power2_img']}.png"> {else} - {/if}</td>
															<td>{if $r8_2 != null} <img src="content/img/battery/horizontal/battery{$r8_2['power3_img']}.png"> {else} - {/if}</td>
															<td>{if $r8_2 != null} <img src="content/img/battery/horizontal/battery{$r8_2['power4_img']}.png"> {else} - {/if}</td>
															<td>{if $r8_2 != null} <img src="content/img/battery/horizontal/battery{$r8_2['power5_img']}.png"> {else} - {/if}</td>
															<td>{if $r8_2 != null} <img src="content/img/battery/horizontal/battery{$r8_2['power6_img']}.png"> {else} - {/if}</td>
														</tr>
														{/if}
														{if ($r1_2['rounds'] + $r2_2['rounds'] + $r3_2['rounds'] + $r4_2['rounds'] + $r5_2['rounds'] + $r6_2['rounds'] + $r7_2['rounds'] + $r8_2['rounds']) <= $track['rounds']}
														<tr>
															<td>8. {translate}tr_mechanic_setting_pitstop{/translate}: </td>
															<td>{$r1_2['rounds'] + $r2_2['rounds'] + $r3_2['rounds'] + $r4_2['rounds'] + $r5_2['rounds'] + $r6_2['rounds'] + $r7_2['rounds'] + $r8_2['rounds']}. {translate}Lap{/translate}</td>
														</tr>
														{/if}
													{/if}
													{if isset($r9_2['rounds'])}
														{if ($r1_2['rounds'] + $r2_2['rounds'] + $r3_2['rounds'] + $r4_2['rounds'] + $r5_2['rounds'] + $r6_2['rounds'] + $r7_2['rounds'] + $r8_2['rounds']) <= $track['rounds']}
														<tr>
															<td>{translate}Lap{/translate} {$r1_2['rounds'] + $r2_2['rounds'] + $r3_2['rounds'] + $r4_2['rounds'] + $r5_2['rounds'] + $r6_2['rounds'] + $r7_2['rounds'] + $r8_2['rounds']} - {if ($r1_2['rounds'] + $r2_2['rounds'] + $r3_2['rounds'] + $r4_2['rounds'] + $r5_2['rounds'] + $r6_2['rounds'] + $r7_2['rounds'] + $r8_2['rounds'] + $r9_2['rounds']) > $track['rounds']} Ziel {else} {$r1_2['rounds'] + $r2_2['rounds'] + $r3_2['rounds'] + $r4_2['rounds'] + $r5_2['rounds'] + $r6_2['rounds'] + $r7_2['rounds'] + $r8_2['rounds'] + $r9_2['rounds']}{/if}</td>
															<td>{if $r9_2 != null} {$r9_2['rounds']} {/if}</td>
															<td>{if $r9_2 != null} {if $r9_2['tire_type'] == 0}{translate}tr_race_training_setup_hard{/translate}{else}{translate}tr_race_training_setup_soft{/translate}{/if} ({$r9_2['tire_number']}){else} - {/if}</td>
															<td>{if $r9_2 != null} <img src="content/img/battery/horizontal/battery{$r9_2['power1_img']}.png"> {else} - {/if}</td>
															<td>{if $r9_2 != null} <img src="content/img/battery/horizontal/battery{$r9_2['power2_img']}.png"> {else} - {/if}</td>
															<td>{if $r9_2 != null} <img src="content/img/battery/horizontal/battery{$r9_2['power3_img']}.png"> {else} - {/if}</td>
															<td>{if $r9_2 != null} <img src="content/img/battery/horizontal/battery{$r9_2['power4_img']}.png"> {else} - {/if}</td>
															<td>{if $r9_2 != null} <img src="content/img/battery/horizontal/battery{$r9_2['power5_img']}.png"> {else} - {/if}</td>
															<td>{if $r9_2 != null} <img src="content/img/battery/horizontal/battery{$r9_2['power6_img']}.png"> {else} - {/if}</td>
														</tr>
														{/if}
														{if ($r1_2['rounds'] + $r2_2['rounds'] + $r3_2['rounds'] + $r4_2['rounds'] + $r5_2['rounds'] + $r6_2['rounds'] + $r7_2['rounds'] + $r8_2['rounds'] + $r9_2['rounds']) <= $track['rounds']}
														<tr>
															<td>9. {translate}tr_mechanic_setting_pitstop{/translate}: </td>
															<td>{$r1_2['rounds'] + $r2_2['rounds'] + $r3_2['rounds'] + $r4_2['rounds'] + $r5_2['rounds'] + $r6_2['rounds'] + $r7_2['rounds'] + $r8_2['rounds'] + $r9_2['rounds']}. {translate}Lap{/translate}</td>
														</tr>
														{/if}
													{/if}
													{if isset($r10_2['rounds'])}
														{if ($r1_2['rounds'] + $r2_2['rounds'] + $r3_2['rounds'] + $r4_2['rounds'] + $r5_2['rounds'] + $r6_2['rounds'] + $r7_2['rounds'] + $r8_2['rounds'] + $r9_2['rounds']) <= $track['rounds']}
														<tr>
															<td>{translate}Lap{/translate} {$r1_2['rounds'] + $r2_2['rounds'] + $r3_2['rounds'] + $r4_2['rounds'] + $r5_2['rounds'] + $r6_2['rounds'] + $r7_2['rounds'] + $r8_2['rounds'] + $r9_2['rounds']} - {if ($r1_2['rounds'] + $r2_2['rounds'] + $r3_2['rounds'] + $r4_2['rounds'] + $r5_2['rounds'] + $r6_2['rounds'] + $r7_2['rounds'] + $r8_2['rounds'] + $r9_2['rounds'] + $r10_2['rounds']) > $track['rounds']} Ziel {else} {$r1_2['rounds'] + $r2_2['rounds'] + $r3_2['rounds'] + $r4_2['rounds'] + $r5_2['rounds'] + $r6_2['rounds'] + $r7_2['rounds'] + $r8_2['rounds'] + $r9_2['rounds'] + $r10_2['rounds']}{/if}</td>
															<td>{if $r10_2 != null} {$r10_2['rounds']} {/if}</td>
															<td>{if $r10_2 != null} {if $r10_2['tire_type'] == 0}{translate}tr_race_training_setup_hard{/translate}{else}{translate}tr_race_training_setup_soft{/translate}{/if} ({$r10_2['tire_number']}){else} - {/if}</td>
															<td>{if $r10_2 != null} <img src="content/img/battery/horizontal/battery{$r10_2['power1_img']}.png"> {else} - {/if}</td>
															<td>{if $r10_2 != null} <img src="content/img/battery/horizontal/battery{$r10_2['power2_img']}.png"> {else} - {/if}</td>
															<td>{if $r10_2 != null} <img src="content/img/battery/horizontal/battery{$r10_2['power3_img']}.png"> {else} - {/if}</td>
															<td>{if $r10_2 != null} <img src="content/img/battery/horizontal/battery{$r10_2['power4_img']}.png"> {else} - {/if}</td>
															<td>{if $r10_2 != null} <img src="content/img/battery/horizontal/battery{$r10_2['power5_img']}.png"> {else} - {/if}</td>
															<td>{if $r10_2 != null} <img src="content/img/battery/horizontal/battery{$r10_2['power6_img']}.png"> {else} - {/if}</td>
														</tr>
														{/if}
													{/if}
													</tbody>
												</table>
											</div>
											<div class="mobile_slider">
												{if isset($r1_2['rounds'])}
												<table class="table table-striped">
													<thead>
													<tr>
														<th>{translate}Lap_short{/translate} {$steps[0]}</th>
														<th>{translate}Lap_short{/translate} {$steps[1]}</th>
														<th>{translate}Lap_short{/translate} {$steps[2]}</th>
														<th>{translate}Lap_short{/translate} {$steps[3]}</th>
														<th>{translate}Lap_short{/translate} {$steps[4]}</th>
														<th>{translate}Lap_short{/translate} {$steps[5]}</th>
													</tr>
													</thead>
													<tbody>
													
														<tr>
															<td>{if $r1_2 != null} <img src="content/img/battery/vertical/battery{$r1_2['power1_img']}.png"> {else} - {/if}</td>
															<td>{if $r1_2 != null} <img src="content/img/battery/vertical/battery{$r1_2['power2_img']}.png"> {else} - {/if}</td>
															<td>{if $r1_2 != null} <img src="content/img/battery/vertical/battery{$r1_2['power3_img']}.png"> {else} - {/if}</td>
															<td>{if $r1_2 != null} <img src="content/img/battery/vertical/battery{$r1_2['power4_img']}.png"> {else} - {/if}</td>
															<td>{if $r1_2 != null} <img src="content/img/battery/vertical/battery{$r1_2['power5_img']}.png"> {else} - {/if}</td>
															<td>{if $r1_2 != null} <img src="content/img/battery/vertical/battery{$r1_2['power6_img']}.png"> {else} - {/if}</td>
														</tr>
													</tbody>
												</table>
												{/if}
												<table class="table table-striped">
													<thead>
													<tr>
														<th></th>
														<th>{translate}tr_race_training_setup_rounds{/translate}</th>
														<th>{translate}tr_race_training_setup_tires{/translate}</th>
													</tr>
													</thead>
													<tbody>
													{if isset($r1_2['rounds'])}
														<tr>
															<td>{translate}Lap{/translate} 1 - {$r1_2['rounds']}</td>
															<td>{if $r1_2 != null} {$r1_2['rounds']} {/if}</td>
															<td>{if $r1_2 != null} <span style="color:red">{if $r1_2['tire_type'] == 0}{translate}tr_race_training_setup_hard{/translate}{else}{translate}tr_race_training_setup_soft{/translate}{/if} ({$r1_2['tire_number']})</span><br/><span style="font-size:8px">(Wert von Q3)</span> {else} - {/if}</td>
														</tr>
														{if ($r1_2['rounds'] + $r2_2['rounds']) <= $track['rounds']}
														<tr>
															<td>1. {translate}tr_mechanic_setting_pitstop{/translate}: </td>
															<td>{$r1_2['rounds']}. {translate}Lap{/translate}</td>
														</tr>
														{/if}
													{/if}
													{if isset($r2_2['rounds'])}
														{if ($r1_2['rounds']) <= $track['rounds']}
														<tr>
															<td>{translate}Lap{/translate} {$r1_2['rounds']} - {if ($r1_2['rounds'] + $r2_2['rounds']) > $track['rounds']} Ziel {else} {$r1_2['rounds'] + $r2_2['rounds']}{/if}</td>
															<td>{if $r2_2 != null} {$r2_2['rounds']} {/if}</td>
															<td>{if $r2_2 != null} {if $r2_2['tire_type'] == 0}{translate}tr_race_training_setup_hard{/translate}{else}{translate}tr_race_training_setup_soft{/translate}{/if} ({$r2_2['tire_number']}){else} - {/if}</td>
														</tr>
														{/if}
														{if ($r1_2['rounds'] + $r2_2['rounds']) <= $track['rounds']}
														<tr>
															<td>2. {translate}tr_mechanic_setting_pitstop{/translate}: </td>
															<td>{$r1_2['rounds'] + $r2_2['rounds']}. {translate}Lap{/translate}</td>
														</tr>
														{/if}
													{/if}
													{if isset($r3_2['rounds'])}
														{if ($r1_2['rounds'] + $r2_2['rounds']) <= $track['rounds']}
														<tr>
															<td>{translate}Lap{/translate} {$r1_2['rounds'] + $r2_2['rounds']} - {if ($r1_2['rounds'] + $r2_2['rounds'] + $r3_2['rounds']) > $track['rounds']} Ziel {else} {$r1_2['rounds'] + $r2_2['rounds'] + $r3_2['rounds']}{/if}</td>
															<td>{if $r3_2 != null} {$r3_2['rounds']} {/if}</td>
															<td>{if $r3_2 != null} {if $r3_2['tire_type'] == 0}{translate}tr_race_training_setup_hard{/translate}{else}{translate}tr_race_training_setup_soft{/translate}{/if} ({$r3_2['tire_number']}){else} - {/if}</td>
														</tr>
														{/if}
														{if ($r1_2['rounds'] + $r2_2['rounds'] + $r3_2['rounds']) <= $track['rounds']}
														<tr>
															<td>3. {translate}tr_mechanic_setting_pitstop{/translate}: </td>
															<td>{$r1_2['rounds'] + $r2_2['rounds'] + $r3_2['rounds']}. {translate}Lap{/translate}</td>
														</tr>
														{/if}
													{/if}
													{if isset($r4_2['rounds'])}
														{if ($r1_2['rounds'] + $r2_2['rounds'] + $r3_2['rounds']) <= $track['rounds']}
														<tr>
															<td>{translate}Lap{/translate} {$r1_2['rounds'] + $r2_2['rounds'] + $r3_2['rounds']} - {if ($r1_2['rounds'] + $r2_2['rounds'] + $r3_2['rounds'] + $r4_2['rounds']) > $track['rounds']} Ziel {else} {$r1_2['rounds'] + $r2_2['rounds'] + $r3_2['rounds'] + $r4_2['rounds']}{/if}</td>
															<td>{if $r4_2 != null} {$r4_2['rounds']} {/if}</td>
															<td>{if $r4_2 != null} {if $r4_2['tire_type'] == 0}{translate}tr_race_training_setup_hard{/translate}{else}{translate}tr_race_training_setup_soft{/translate}{/if} ({$r4_2['tire_number']}){else} - {/if}</td>
														</tr>
														{/if}
														{if ($r1_2['rounds'] + $r2_2['rounds'] + $r3_2['rounds'] + $r4_2['rounds']) <= $track['rounds']}
														<tr>
															<td>4. {translate}tr_mechanic_setting_pitstop{/translate}: </td>
															<td>{$r1_2['rounds'] + $r2_2['rounds'] + $r3_2['rounds'] + $r4_2['rounds']}. {translate}Lap{/translate}</td>
														</tr>
														{/if}
													{/if}
													{if isset($r5_2['rounds'])}
														{if ($r1_2['rounds'] + $r2_2['rounds'] + $r3_2['rounds'] + $r4_2['rounds']) <= $track['rounds']}
														<tr>
															<td>{translate}Lap{/translate} {$r1_2['rounds'] + $r2_2['rounds'] + $r3_2['rounds'] + $r4_2['rounds']} - {if ($r1_2['rounds'] + $r2_2['rounds'] + $r3_2['rounds'] + $r4_2['rounds'] + $r5_2['rounds']) > $track['rounds']} Ziel {else} {$r1_2['rounds'] + $r2_2['rounds'] + $r3_2['rounds'] + $r4_2['rounds'] + $r5_2['rounds']}{/if}</td>
															<td>{if $r5_2 != null} {$r5_2['rounds']} {/if}</td>
															<td>{if $r5_2 != null} {if $r5_2['tire_type'] == 0}{translate}tr_race_training_setup_hard{/translate}{else}{translate}tr_race_training_setup_soft{/translate}{/if} ({$r5_2['tire_number']}){else} - {/if}</td>
														</tr>
														{/if}
														{if ($r1_2['rounds'] + $r2_2['rounds'] + $r3_2['rounds'] + $r4_2['rounds'] + $r5_2['rounds']) <= $track['rounds']}
														<tr>
															<td>5. {translate}tr_mechanic_setting_pitstop{/translate}: </td>
															<td>{$r1_2['rounds'] + $r2_2['rounds'] + $r3_2['rounds'] + $r4_2['rounds'] + $r5_2['rounds']}. {translate}Lap{/translate}</td>
														</tr>
														{/if}
													{/if}
													{if isset($r6_2['rounds'])}
														{if ($r1_2['rounds'] + $r2_2['rounds'] + $r3_2['rounds'] + $r4_2['rounds'] + $r5_2['rounds']) <= $track['rounds']}
														<tr>
															<td>{translate}Lap{/translate} {$r1_2['rounds'] + $r2_2['rounds'] + $r3_2['rounds'] + $r4_2['rounds'] + $r5_2['rounds']} - {if ($r1_2['rounds'] + $r2_2['rounds'] + $r3_2['rounds'] + $r4_2['rounds'] + $r5_2['rounds'] + $r6_2['rounds']) > $track['rounds']} Ziel {else} {$r1_2['rounds'] + $r2_2['rounds'] + $r3_2['rounds'] + $r4_2['rounds'] + $r5_2['rounds'] + $r6_2['rounds']}{/if}</td>
															<td>{if $r6_2 != null} {$r6_2['rounds']} {/if}</td>
															<td>{if $r6_2 != null} {if $r6_2['tire_type'] == 0}{translate}tr_race_training_setup_hard{/translate}{else}{translate}tr_race_training_setup_soft{/translate}{/if} ({$r6_2['tire_number']}){else} - {/if}</td>
														</tr>
														{/if}
														{if ($r1_2['rounds'] + $r2_2['rounds'] + $r3_2['rounds'] + $r4_2['rounds'] + $r5_2['rounds'] + $r6_2['rounds']) <= $track['rounds']}
														<tr>
															<td>6. {translate}tr_mechanic_setting_pitstop{/translate}: </td>
															<td>{$r1_2['rounds'] + $r2_2['rounds'] + $r3_2['rounds'] + $r4_2['rounds'] + $r5_2['rounds'] + $r6_2['rounds']}. {translate}Lap{/translate}</td>
														</tr>
														{/if}
													{/if}
													{if isset($r7_2['rounds'])}
														{if ($r1_2['rounds'] + $r2_2['rounds'] + $r3_2['rounds'] + $r4_2['rounds'] + $r5_2['rounds'] + $r6_2['rounds']) <= $track['rounds']}
														<tr>
															<td>{translate}Lap{/translate} {$r1_2['rounds'] + $r2_2['rounds'] + $r3_2['rounds'] + $r4_2['rounds'] + $r5_2['rounds'] + $r6_2['rounds']} - {if ($r1_2['rounds'] + $r2_2['rounds'] + $r3_2['rounds'] + $r4_2['rounds'] + $r5_2['rounds'] + $r6_2['rounds'] + $r7_2['rounds']) > $track['rounds']} Ziel {else} {$r1_2['rounds'] + $r2_2['rounds'] + $r3_2['rounds'] + $r4_2['rounds'] + $r5_2['rounds'] + $r6_2['rounds'] + $r7_2['rounds']}{/if}</td>
															<td>{if $r7_2 != null} {$r7_2['rounds']} {/if}</td>
															<td>{if $r7_2 != null} {$r7_2['power6']} {else} - {/if}</td>
														</tr>
														{/if}
														{if ($r1_2['rounds'] + $r2_2['rounds'] + $r3_2['rounds'] + $r4_2['rounds'] + $r5_2['rounds'] + $r6_2['rounds'] + $r7_2['rounds']) <= $track['rounds']}
														<tr>
															<td>7. {translate}tr_mechanic_setting_pitstop{/translate}: </td>
															<td>{$r1_2['rounds'] + $r2_2['rounds'] + $r3_2['rounds'] + $r4_2['rounds'] + $r5_2['rounds'] + $r6_2['rounds'] + $r7_2['rounds']}. {translate}Lap{/translate}</td>
														</tr>
														{/if}
													{/if}
													{if isset($r8_2['rounds'])}
														{if ($r1_2['rounds'] + $r2_2['rounds'] + $r3_2['rounds'] + $r4_2['rounds'] + $r5_2['rounds'] + $r6_2['rounds'] + $r7_2['rounds']) <= $track['rounds']}
														<tr>
															<td>{translate}Lap{/translate} {$r1_2['rounds'] + $r2_2['rounds'] + $r3_2['rounds'] + $r4_2['rounds'] + $r5_2['rounds'] + $r6_2['rounds'] + $r7_2['rounds']} - {if ($r1_2['rounds'] + $r2_2['rounds'] + $r3_2['rounds'] + $r4_2['rounds'] + $r5_2['rounds'] + $r6_2['rounds'] + $r7_2['rounds'] + $r8_2['rounds']) > $track['rounds']} Ziel {else} {$r1_2['rounds'] + $r2_2['rounds'] + $r3_2['rounds'] + $r4_2['rounds'] + $r5_2['rounds'] + $r6_2['rounds'] + $r7_2['rounds'] + $r8_2['rounds']}{/if}</td>
															<td>{if $r8_2 != null} {$r8_2['rounds']} {/if}</td>
															<td>{if $r8_2 != null} {if $r8_2['tire_type'] == 0}{translate}tr_race_training_setup_hard{/translate}{else}{translate}tr_race_training_setup_soft{/translate}{/if} ({$r8_2['tire_number']}){else} - {/if}</td>
														</tr>
														{/if}
														{if ($r1_2['rounds'] + $r2_2['rounds'] + $r3_2['rounds'] + $r4_2['rounds'] + $r5_2['rounds'] + $r6_2['rounds'] + $r7_2['rounds'] + $r8_2['rounds']) <= $track['rounds']}
														<tr>
															<td>8. {translate}tr_mechanic_setting_pitstop{/translate}: </td>
															<td>{$r1_2['rounds'] + $r2_2['rounds'] + $r3_2['rounds'] + $r4_2['rounds'] + $r5_2['rounds'] + $r6_2['rounds'] + $r7_2['rounds'] + $r8_2['rounds']}. {translate}Lap{/translate}</td>
														</tr>
														{/if}
													{/if}
													{if isset($r9_2['rounds'])}
														{if ($r1_2['rounds'] + $r2_2['rounds'] + $r3_2['rounds'] + $r4_2['rounds'] + $r5_2['rounds'] + $r6_2['rounds'] + $r7_2['rounds'] + $r8_2['rounds']) <= $track['rounds']}
														<tr>
															<td>{translate}Lap{/translate} {$r1_2['rounds'] + $r2_2['rounds'] + $r3_2['rounds'] + $r4_2['rounds'] + $r5_2['rounds'] + $r6_2['rounds'] + $r7_2['rounds'] + $r8_2['rounds']} - {if ($r1_2['rounds'] + $r2_2['rounds'] + $r3_2['rounds'] + $r4_2['rounds'] + $r5_2['rounds'] + $r6_2['rounds'] + $r7_2['rounds'] + $r8_2['rounds'] + $r9_2['rounds']) > $track['rounds']} Ziel {else} {$r1_2['rounds'] + $r2_2['rounds'] + $r3_2['rounds'] + $r4_2['rounds'] + $r5_2['rounds'] + $r6_2['rounds'] + $r7_2['rounds'] + $r8_2['rounds'] + $r9_2['rounds']}{/if}</td>
															<td>{if $r9_2 != null} {$r9_2['rounds']} {/if}</td>
															<td>{if $r9_2 != null} {if $r9_2['tire_type'] == 0}{translate}tr_race_training_setup_hard{/translate}{else}{translate}tr_race_training_setup_soft{/translate}{/if} ({$r9_2['tire_number']}){else} - {/if}</td>
														</tr>
														{/if}
														{if ($r1_2['rounds'] + $r2_2['rounds'] + $r3_2['rounds'] + $r4_2['rounds'] + $r5_2['rounds'] + $r6_2['rounds'] + $r7_2['rounds'] + $r8_2['rounds'] + $r9_2['rounds']) <= $track['rounds']}
														<tr>
															<td>9. {translate}tr_mechanic_setting_pitstop{/translate}: </td>
															<td>{$r1_2['rounds'] + $r2_2['rounds'] + $r3_2['rounds'] + $r4_2['rounds'] + $r5_2['rounds'] + $r6_2['rounds'] + $r7_2['rounds'] + $r8_2['rounds'] + $r9_2['rounds']}. {translate}Lap{/translate}</td>
														</tr>
														{/if}
													{/if}
													{if isset($r10_2['rounds'])}
														{if ($r1_2['rounds'] + $r2_2['rounds'] + $r3_2['rounds'] + $r4_2['rounds'] + $r5_2['rounds'] + $r6_2['rounds'] + $r7_2['rounds'] + $r8_2['rounds'] + $r9_2['rounds']) <= $track['rounds']}
														<tr>
															<td>{translate}Lap{/translate} {$r1_2['rounds'] + $r2_2['rounds'] + $r3_2['rounds'] + $r4_2['rounds'] + $r5_2['rounds'] + $r6_2['rounds'] + $r7_2['rounds'] + $r8_2['rounds'] + $r9_2['rounds']} - {if ($r1_2['rounds'] + $r2_2['rounds'] + $r3_2['rounds'] + $r4_2['rounds'] + $r5_2['rounds'] + $r6_2['rounds'] + $r7_2['rounds'] + $r8_2['rounds'] + $r9_2['rounds'] + $r10_2['rounds']) > $track['rounds']} Ziel {else} {$r1_2['rounds'] + $r2_2['rounds'] + $r3_2['rounds'] + $r4_2['rounds'] + $r5_2['rounds'] + $r6_2['rounds'] + $r7_2['rounds'] + $r8_2['rounds'] + $r9_2['rounds'] + $r10_2['rounds']}{/if}</td>
															<td>{if $r10_2 != null} {$r10_2['rounds']} {/if}</td>
															<td>{if $r10_2 != null} {if $r10_2['tire_type'] == 0}{translate}tr_race_training_setup_hard{/translate}{else}{translate}tr_race_training_setup_soft{/translate}{/if} ({$r10_2['tire_number']}){else} - {/if}</td>
														</tr>
														{/if}
													{/if}
													</tbody>
												</table>
											</div>
					    				</div>
                                	</div>
								</div>
								{/if}
	                        </div>
	                    </div>
						{/if}
						{/if}
	                </div>
                </div>
            </div>
        </div><!--/span-->
    </div>
</div>

{if $show_result != true}
{literal}
<script>
var def_var = 0;
var rounds = {/literal}{if $rounds==null} 1 {else} {$rounds} {/if}{literal};
var power1 = {/literal}{if $settings == null} def_var {else} {$settings.power1} {/if}{literal};
var power2 = {/literal}{if $settings == null} def_var {else} {$settings.power2} {/if}{literal};
var power3 = {/literal}{if $settings == null} def_var {else} {$settings.power3} {/if}{literal};
var power4 = {/literal}{if $settings == null} def_var {else} {$settings.power4} {/if}{literal};
var power5 = {/literal}{if $settings == null} def_var {else} {$settings.power5} {/if}{literal};
var power6 = {/literal}{if $settings == null} def_var {else} {$settings.power6} {/if}{literal};
var last_car = {/literal}{if $last_car != 2} '{translate}race_car{/translate}1' {else} '{translate}race_car{/translate}2' {/if}{literal};

function mobileChangeValue(value_id, obj)
{
	$( "#"+value_id ).val( obj.value );
}

function computePowerValues()
{
	var power1 = parseInt($( "#power1_value" ).val()) || 0;
	var power2 = parseInt($( "#power2_value" ).val()) || 0;
	var power3 = parseInt($( "#power3_value" ).val()) || 0;
	var power4 = parseInt($( "#power4_value" ).val()) || 0;
	var power5 = parseInt($( "#power5_value" ).val()) || 0;
	var power6 = parseInt($( "#power6_value" ).val()) || 0;
	var sum = power1 + power2 + power3 + power4 + power5 + power6;
	//console.log("Summe: "+sum);
	//console.log("Power1: "+power1+" Power2: "+power2+" Power3: "+power3+" Power4: "+power4+" Power5: "+power5+" Power6: "+power6);
	//console.log("Wert1: "+(sum / power1));
	var val1 = Math.round((power1 * 100) / sum);
	var val2 = Math.round((power2 * 100) / sum);
	var val3 = Math.round((power3 * 100) / sum);
	var val4 = Math.round((power4 * 100) / sum)
	var val5 = Math.round((power5 * 100) / sum)
	var val6 = 100 - val1 - val2 - val3 - val4 - val5;
	$( "#power1_amount" ).html( ""+val1 );
	$( "#power2_amount" ).html( ""+val2 );
	$( "#power3_amount" ).html( ""+val3 );
	$( "#power4_amount" ).html( ""+val4 );
	$( "#power5_amount" ).html( ""+val5 );
	$( "#power6_amount" ).html( ""+val6 );
	$( "#power1_amount_mobile" ).html( ""+val1 );
	$( "#power2_amount_mobile" ).html( ""+val2 );
	$( "#power3_amount_mobile" ).html( ""+val3 );
	$( "#power4_amount_mobile" ).html( ""+val4 );
	$( "#power5_amount_mobile" ).html( ""+val5 );
	$( "#power6_amount_mobile" ).html( ""+val6 );
}

function computePowerValues2()
{
	var power1 = parseInt($( "#power1_value2" ).val()) || 0;
	var power2 = parseInt($( "#power2_value2" ).val()) || 0;
	var power3 = parseInt($( "#power3_value2" ).val()) || 0;
	var power4 = parseInt($( "#power4_value2" ).val()) || 0;
	var power5 = parseInt($( "#power5_value2" ).val()) || 0;
	var power6 = parseInt($( "#power6_value2" ).val()) || 0;
	var sum = power1 + power2 + power3 + power4 + power5 + power6;
	//console.log("Summe: "+sum);
	//console.log("Power1: "+power1+" Power2: "+power2+" Power3: "+power3+" Power4: "+power4+" Power5: "+power5+" Power6: "+power6);
	//console.log("Wert1: "+(sum / power1));
	var val1 = Math.round((power1 * 100) / sum);
	var val2 = Math.round((power2 * 100) / sum);
	var val3 = Math.round((power3 * 100) / sum);
	var val4 = Math.round((power4 * 100) / sum)
	var val5 = Math.round((power5 * 100) / sum)
	var val6 = 100 - val1 - val2 - val3 - val4 - val5;
	$( "#power1_amount2" ).html( ""+val1 );
	$( "#power2_amount2" ).html( ""+val2 );
	$( "#power3_amount2" ).html( ""+val3 );
	$( "#power4_amount2" ).html( ""+val4 );
	$( "#power5_amount2" ).html( ""+val5 );
	$( "#power6_amount2" ).html( ""+val6 );
	$( "#power1_amount_mobile2" ).html( ""+val1 );
	$( "#power2_amount_mobile2" ).html( ""+val2 );
	$( "#power3_amount_mobile2" ).html( ""+val3 );
	$( "#power4_amount_mobile2" ).html( ""+val4 );
	$( "#power5_amount_mobile2" ).html( ""+val5 );
	$( "#power6_amount_mobile2" ).html( ""+val6 );
}

$(document).ready(function() {
	$('#myTab a[href="#'+last_car+'"]').tab('show');

	//rounds_value
	$( "#rounds_value_slider" ).slider({
      range: "min",
      value: rounds,
      min: 1,
      max: 40,
      slide: function( event, ui ) {
        $( "#rounds_value_amount" ).html( ui.value+" {/literal}{translate}tr_race_training_setup_rounds{/translate}{literal}" );
        $( "#rounds_value" ).val( ui.value );
      }
    });
    var value = $( "#rounds_value_slider" ).slider( "value" );
    $( "#rounds_value_amount" ).html( value+" {/literal}{translate}tr_race_training_setup_rounds{/translate}{literal}" );
    //power1_value
    $( "#power1_slider" ).slider({
      orientation: "vertical",
      range: "min",
      value: power1,
      min: 0,
      max: 100,
      slide: function( event, ui ) {
        //$( "#power1_amount" ).html( ui.value );
        $( "#power1_value" ).val( ui.value );
        computePowerValues();
      }
    });
    var value = $( "#power1_slider" ).slider( "value" );
    $( "#power1_amount" ).html( value );
    //power2_value
    $( "#power2_slider" ).slider({
      orientation: "vertical",
      range: "min",
      value: power2,
      min: 0,
      max: 100,
      slide: function( event, ui ) {
        //$( "#power2_amount" ).html( ui.value );
        $( "#power2_value" ).val( ui.value );
        computePowerValues();
      }
    });
    var value = $( "#power2_slider" ).slider( "value" );
    $( "#power2_amount" ).html( value );
    //power3_value
    $( "#power3_slider" ).slider({
      orientation: "vertical",
      range: "min",
      value: power3,
      min: 0,
      max: 100,
      slide: function( event, ui ) {
        //$( "#power3_amount" ).html( ui.value );
        $( "#power3_value" ).val( ui.value );
        computePowerValues();
      }
    });
    var value = $( "#power3_slider" ).slider( "value" );
    $( "#power3_amount" ).html( value );
    //power4_value
    $( "#power4_slider" ).slider({
      orientation: "vertical",
      range: "min",
      value: power4,
      min: 0,
      max: 100,
      slide: function( event, ui ) {
        //$( "#power4_amount" ).html( ui.value );
        $( "#power4_value" ).val( ui.value );
        computePowerValues();
      }
    });
    var value = $( "#power4_slider" ).slider( "value" );
    $( "#power4_amount" ).html( value );
    //power5_value
    $( "#power5_slider" ).slider({
      orientation: "vertical",
      range: "min",
      value: power5,
      min: 0,
      max: 100,
      slide: function( event, ui ) {
        //$( "#power5_amount" ).html( ui.value );
        $( "#power5_value" ).val( ui.value );
        computePowerValues();
      }
    });
    var value = $( "#power5_slider" ).slider( "value" );
    $( "#power5_amount" ).html( value );
    //power6_value
    $( "#power6_slider" ).slider({
      orientation: "vertical",
      range: "min",
      value: power6,
      min: 0,
      max: 100,
      slide: function( event, ui ) {
        //$( "#power6_amount" ).html( ui.value );
        $( "#power6_value" ).val( ui.value );
        computePowerValues();
      }
    });
    var value = $( "#power6_slider" ).slider( "value" );
    $( "#power6_amount" ).html( value );
    
    
    
    
    //rounds_value
	$( "#rounds_value_slider2" ).slider({
      range: "min",
      value: rounds,
      min: 1,
      max: 40,
      slide: function( event, ui ) {
        $( "#rounds_value_amount2" ).html( ui.value+" {/literal}{translate}tr_race_training_setup_rounds{/translate}{literal}" );
        $( "#rounds_value2" ).val( ui.value );
      }
    });
    var value = $( "#rounds_value_slider2" ).slider( "value" );
    $( "#rounds_value_amount2" ).html( value+" {/literal}{translate}tr_race_training_setup_rounds{/translate}{literal}" );
    //power1_value
    $( "#power1_slider2" ).slider({
      orientation: "vertical",
      range: "min",
      value: power1,
      min: 0,
      max: 100,
      slide: function( event, ui ) {
        //$( "#power1_amount" ).html( ui.value );
        $( "#power1_value2" ).val( ui.value );
        computePowerValues2();
      }
    });
    var value = $( "#power1_slider2" ).slider( "value" );
    $( "#power1_amount2" ).html( value );
    //power2_value
    $( "#power2_slider2" ).slider({
      orientation: "vertical",
      range: "min",
      value: power2,
      min: 0,
      max: 100,
      slide: function( event, ui ) {
        //$( "#power2_amount" ).html( ui.value );
        $( "#power2_value2" ).val( ui.value );
        computePowerValues2();
      }
    });
    var value = $( "#power2_slider2" ).slider( "value" );
    $( "#power2_amount2" ).html( value );
    //power3_value
    $( "#power3_slider2" ).slider({
      orientation: "vertical",
      range: "min",
      value: power3,
      min: 0,
      max: 100,
      slide: function( event, ui ) {
        //$( "#power3_amount" ).html( ui.value );
        $( "#power3_value2" ).val( ui.value );
        computePowerValues2();
      }
    });
    var value = $( "#power3_slider2" ).slider( "value" );
    $( "#power3_amount2" ).html( value );
    //power4_value
    $( "#power4_slider2" ).slider({
      orientation: "vertical",
      range: "min",
      value: power4,
      min: 0,
      max: 100,
      slide: function( event, ui ) {
        //$( "#power4_amount" ).html( ui.value );
        $( "#power4_value2" ).val( ui.value );
        computePowerValues2();
      }
    });
    var value = $( "#power4_slider2" ).slider( "value" );
    $( "#power4_amount2" ).html( value );
    //power5_value
    $( "#power5_slider2" ).slider({
      orientation: "vertical",
      range: "min",
      value: power5,
      min: 0,
      max: 100,
      slide: function( event, ui ) {
        //$( "#power5_amount" ).html( ui.value );
        $( "#power5_value2" ).val( ui.value );
        computePowerValues2();
      }
    });
    var value = $( "#power5_slider2" ).slider( "value" );
    $( "#power5_amount2" ).html( value );
    //power6_value
    $( "#power6_slider2" ).slider({
      orientation: "vertical",
      range: "min",
      value: power6,
      min: 0,
      max: 100,
      slide: function( event, ui ) {
        //$( "#power6_amount" ).html( ui.value );
        $( "#power6_value2" ).val( ui.value );
        computePowerValues2();
      }
    });
    var value = $( "#power6_slider2" ).slider( "value" );
    $( "#power6_amount2" ).html( value );
});
</script>
{/literal}
{/if}
