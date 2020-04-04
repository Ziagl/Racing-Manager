<div class="page-content-wrapper">
    <div class="page-content">
    	<div class="row">
    		<div class="col-md-12">
    			{if $show_result == false}
    			<div class="portlet box red">
    				<div class="portlet-title">
    					<div class="caption">{translate}tr_race_training_title{/translate}</div>
    				</div>
    				<div class="portlet-body">
    					{if $error != null}
	                        {$error}
	                    {else}
    					<ul class="nav nav-tabs" id="myTab">
							<li{if $last_car == 1} class="active"{/if}><a data-toggle="tab" href="#race_car1">{translate}race_car{/translate} 1</a></li>
	                        {if isset($driver2['firstname'])}
	                        <li{if $last_car == 2} class="active"{/if}><a data-toggle="tab" href="#race_car2">{translate}race_car{/translate} 2</a></li>
	                        {/if}
	                        {if isset($driver3['firstname'])}
	                        <li{if $last_car == 3} class="active"{/if}><a data-toggle="tab" href="#training_car">{translate}training_car{/translate}</a></li>
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
                                    <div class="col-md-12">
                                    	{if $team_league == $league}
                                        <div style="text-align: center; color: red; margin-bottom: 10px;">{translate}tr_driver_training_laps_to_drive_pre{/translate}{$laps_to_go_driver1} {translate}tr_driver_training_laps_to_drive_post{/translate}</div>
                                        {/if}
                                        <form action="?site=race_training" method="post">
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
														{for $i = 1 to 30}
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
													<div id="tire_value_desktop" class="desktop_slider">
														{section name=tire loop=$car1_tires}
															<label class="col-md-4 col-xs-4">
																<input onchange="mobileChangeValue('tire_id_value', this)" type="radio" name="tire_id" id="tire_id_{$car1_tires[tire].id}" value="{$car1_tires[tire].id}" {if $setting_tire_id_1 == $car1_tires[tire].id}checked{/if}>
																<img src="content/img/tires/{$car1_tires[tire].tire_picture}" width="40px"/>{$car1_tires[tire].tire_name}
															</label>
														{/section}
													</div>
													<div id="tire_value_mobile" class="mobile_slider">
														<select onchange="mobileChangeValue('tire_id_value', this)" style="width:100%">
															{$j = 0}
															{section name=tire loop=$car1_tires}
																<option value="{$car1_tires[tire].id}" {if $setting_tire_id_1 == $car1_tires[tire].id}selected{else}{if $j == 0}selected{/if}{/if}>{$car1_tires[tire].tire_name}</option>
															<!--{$j++}-->
															{/section}
														</select>
													</div>
													<input type="hidden" id="tire_id_value" name="tire_id" value="{$setting_tire_id_1}">
												</div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-2 col-xs-4">
                                                    <label class="control-label">{translate}tr_race_training_setup_front_wing{/translate}: </label>
                                                </div>
                                                <div class="col-md-10 col-xs-8">
                                                	<div id="front_wing_value_slider_desktop" class="desktop_slider">
														<div id="front_wing_value_slider" class="slider_darkgreen"></div>
														<div id="front_wing_value_amount" style="color:#777;font-size:12px;text-align:center;"></div>
													</div>
	                                            	<div id="front_wing_value_slider_mobile" class="mobile_slider">
														<select onchange="mobileChangeValue('front_wing_value', this);" style="width:100%">
														{for $i = 0 to 90}
															<option value="{$i}" {if $i == $settings.front_wing}selected{/if}>{$i} {translate}tr_driver_setting_degree{/translate}</option>
														{/for}
														</select>
	                                            	</div>
													<input id="front_wing_value" type="hidden" value="{$settings.front_wing}" name="front_wing_value">
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-2 col-xs-4">
                                                    <label class="control-label">{translate}tr_race_training_setup_rear_wing{/translate}: </label>
                                                </div>
                                                <div class="col-md-10 col-xs-8">
                                                	<div id="rear_wing_value_slider_desktop" class="desktop_slider">
														<div id="rear_wing_value_slider" class="slider_lightgreen"></div>
														<div id="rear_wing_value_amount" style="color:#777;font-size:12px;text-align:center;"></div>
													</div>
	                                            	<div id="rear_wing_value_slider_mobile" class="mobile_slider">
														<select onchange="mobileChangeValue('rear_wing_value', this);" style="width:100%">
														{for $i = 0 to 90}
															<option value="{$i}" {if $i == $settings.rear_wing}selected{/if}>{$i} {translate}tr_driver_setting_degree{/translate}</option>
														{/for}
														</select>
	                                            	</div>
													<input id="rear_wing_value" type="hidden" value="{$settings.rear_wing}" name="rear_wing_value">
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-2 col-xs-4">
                                                    <label class="control-label">{translate}tr_race_training_setup_front_suspension{/translate}: </label>
                                                </div>
                                                <div class="col-md-1 col-xs-2" style="text-align:center">
                                                    {translate}tr_race_training_setup_soft{/translate}
                                                </div>
                                                <div class="col-md-8 col-xs-4">
                                                	<div id="front_suspension_value_slider_desktop" class="desktop_slider">
														<div id="front_suspension_value_slider" class="slider_darkblue"></div>
														<div id="front_suspension_value_amount" style="color:#777;font-size:12px;text-align:center;"></div>
													</div>
	                                            	<div id="front_suspension_value_slider_mobile" class="mobile_slider">
														<select onchange="mobileChangeValue('front_suspension_value', this);" style="width:100%">
														{for $i = 0 to 100}
															<option value="{$i}" {if $i == $settings.front_suspension}selected{/if}>{$i} %</option>
														{/for}
														</select>
	                                            	</div>
													<input id="front_suspension_value" type="hidden" value="{$settings.front_suspension}" name="front_suspension_value">
                                                </div>
                                                <div class="col-md-1 col-xs-2" style="text-align:center">
                                                    {translate}tr_race_training_setup_hard{/translate}
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-2 col-xs-4">
                                                    <label class="control-label">{translate}tr_race_training_setup_rear_suspension{/translate}: </label>
                                                </div>
                                                <div class="col-md-1 col-xs-2" style="text-align:center">
                                                    {translate}tr_race_training_setup_soft{/translate}
                                                </div>
                                                <div class="col-md-8 col-xs-4">
													<div id="rear_suspension_value_slider_desktop" class="desktop_slider">
														<div id="rear_suspension_value_slider" class="slider_lightblue"></div>
														<div id="rear_suspension_value_amount" style="color:#777;font-size:12px;text-align:center;"></div>
													</div>
	                                            	<div id="rear_suspension_value_slider_mobile" class="mobile_slider">
														<select onchange="mobileChangeValue('rear_suspension_value', this);" style="width:100%">
														{for $i = 0 to 100}
															<option value="{$i}" {if $i == $settings.rear_suspension}selected{/if}>{$i} %</option>
														{/for}
														</select>
	                                            	</div>
													<input id="rear_suspension_value" type="hidden" value="{$settings.rear_suspension}" name="rear_suspension_value">
                                                </div>
                                                <div class="col-md-1 col-xs-2" style="text-align:center">
                                                    {translate}tr_race_training_setup_hard{/translate}
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-2 col-xs-4">
                                                    <label class="control-label">{translate}tr_race_training_setup_tire_pressure{/translate}: </label>
                                                </div>
                                                <div class="col-md-1 col-xs-2" style="text-align:center">
                                                    {translate}low{/translate}
                                                </div>
                                                <div class="col-md-8 col-xs-4">
                                                	<div id="tire_pressure_value_slider_desktop" class="desktop_slider">
														<div id="tire_pressure_value_slider" class="slider_orange"></div>
														<div id="tire_pressure_value_amount" style="color:#777;font-size:12px;text-align:center;"></div>
													</div>
	                                            	<div id="tire_pressure_value_slider_mobile" class="mobile_slider">
														<select onchange="mobileChangeValue('tire_pressure_value', this);" style="width:100%">
														{for $i = 0 to 100}
															<option value="{$i}" {if $i == $settings.tire_pressure}selected{/if}>{$i} %</option>
														{/for}
														</select>
	                                            	</div>
													<input id="tire_pressure_value" type="hidden" value="{$settings.tire_pressure}" name="tire_pressure_value">
                                                </div>
                                                <div class="col-md-1 col-xs-2" style="text-align:center">
                                                    {translate}high{/translate}
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-2 col-xs-4">
                                                    <label class="control-label">{translate}tr_race_training_setup_brake_balance{/translate}: </label>
                                                </div>
                                                <div class="col-md-1 col-xs-2" style="text-align:center">
                                                    {translate}front{/translate}
                                                </div>
                                                <div class="col-md-8 col-xs-4">
                                                	<div id="brake_balance_value_slider_desktop" class="desktop_slider">
														<div id="brake_balance_value_slider" class="slider_yellow"></div>
														<div id="brake_balance_value_amount" style="color:#777;font-size:12px;text-align:center;"></div>
													</div>
	                                            	<div id="brake_balance_value_slider_mobile" class="mobile_slider">
														<select onchange="mobileChangeValue('brake_balance_value', this);" style="width:100%">
														{for $i = 0 to 100}
															<option value="{$i}" {if $i == $settings.brake_balance}selected{/if}>{$i} %</option>
														{/for}
														</select>
	                                            	</div>
													<input id="brake_balance_value" type="hidden" value="{$settings.brake_balance}" name="brake_balance_value">
                                                </div>
                                                <div class="col-md-1 col-xs-2" style="text-align:center">
                                                    {translate}rear{/translate}
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-2 col-xs-4">
                                                    <label class="control-label">{translate}tr_race_training_setup_gear_ratio{/translate}: </label>
                                                </div>
                                                <div class="col-md-1 col-xs-2" style="text-align:center">
                                                    {translate}short{/translate}
                                                </div>
                                                <div class="col-md-8 col-xs-4">
                                                	<div id="gear_ratio_value_slider_desktop" class="desktop_slider">
                                                		<div id="gear_ratio_value_slider" class="slider_red"></div>
                                                		<div id="gear_ratio_value_amount" style="color:#777;font-size:12px;text-align:center;"></div>
													</div>
	                                            	<div id="gear_ratio_value_slider_mobile" class="mobile_slider">
														<select onchange="mobileChangeValue('gear_ratio_value', this);" style="width:100%">
														{for $i = 0 to 100}
															<option value="{$i}" {if $i == $settings.gear_ratio}selected{/if}>{$i} %</option>
														{/for}
														</select>
	                                            	</div>
                                                	<input id="gear_ratio_value" type="hidden" value="{$settings.gear_ratio}" name="gear_ratio_value">
                                                </div>
                                                <div class="col-md-1 col-xs-2" style="text-align:center">
                                                    {translate}long{/translate}
                                                </div>
                                            </div>
                                            <input type="hidden" name="car" value="1">
                                            {if $laps_to_go_driver1 > 0}
                                                <button type="submit" class="btn btn-primary">{translate}tr_button_drive{/translate}</button>
                                            {/if}
                                            <a class="btn default" href="#responsive" data-toggle="modal">{translate}tr_driver_training_comment{/translate}</a>
                                        </form>
                                        <div id="responsive" class="modal fade" aria-hidden="true" tabindex="-1" style="display: none;">
											<div class="modal-dialog">
												<div class="modal-content">
													<div class="modal-header">
														<button class="close" aria-hidden="true" data-dismiss="modal" type="button"></button>
														<h4 class="modal-title">{translate}tr_driver_training_comment{/translate}</h4>
													</div>
													<div class="modal-body">
														<div class="row">
															<div class="col-md-12 col-xs-12">
																<div class="col-md-4 col-xs-5"><img src="content/img/driver/{$driver1['picture']}" width="100px"/></div>
																<div class="col-md-8 col-xs-7">
																	{section name=comment loop=$car1_comments}
																		{$car1_comments[comment]}<br/>
																	{/section}
																</div>
															</div>
														</div>
													</div>
													<div class="modal-footer">
														<button class="btn red" data-dismiss="modal" type="button">{translate}tr_button_good_job{/translate}</button>
													</div>
												</div>
											</div>
										</div>
                                    </div>
                                </div>

                                <div class="row">
                                	<div class="portlet box red">
					    				<div class="portlet-title">
					    					<div class="caption">{translate}tr_race_training_result_detail{/translate}</div>
					    				</div>
					    				<div class="portlet-body">
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
													<tr>
														<td>{translate}tr_race_training_setup_last_lap{/translate}:</td>
														<td>{$car1_last_lap.round_time_string}</td>
														<td>{$car1_last_lap.front_wing}</td>
														<td>{$car1_last_lap.rear_wing}</td>
														<td>{$car1_last_lap.front_suspension}</td>
														<td>{$car1_last_lap.rear_suspension}</td>
														<td>{$car1_last_lap.tire_pressure}</td>
														<td>{$car1_last_lap.brake_balance}</td>
														<td>{$car1_last_lap.gear_ratio}</td>
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
													<tr>
														<td>{translate}tr_race_training_setup_last_lap_short{/translate}:</td>
														<td>{$car1_last_lap.round_time_string}</td>
														<td>{$car1_last_lap.front_wing}</td>
														<td>{$car1_last_lap.rear_wing}</td>
														<td>{$car1_last_lap.front_suspension}</td>
														<td>{$car1_last_lap.rear_suspension}</td>
														<td>{$car1_last_lap.tire_pressure}</td>
														<td>{$car1_last_lap.brake_balance}</td>
														<td>{$car1_last_lap.gear_ratio}</td>
													</tr>
													</tbody>
												</table>
                                            </div>
                                        </div>
                                    </div><!--/span-->
                                </div>
                                
                                <div class="row">
                                	<div class="portlet box red">
					    				<div class="portlet-title">
					    					<div class="caption">{translate}tr_finance_detail_text{/translate}</div>
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
														{$i=count($car1_laps)}
														{section name=lap loop=$car1_laps}
															<tr>
																<td>{$i--}</td>
																<td>{$car1_laps[lap].round_time_string}</td>
																<td>{if $car1_laps[lap].tire_type == 0}{translate}tr_race_training_setup_hard{/translate}{else}{translate}tr_race_training_setup_soft{/translate}{/if}</td>
																<td>{$car1_laps[lap].front_wing}</td>
																<td>{$car1_laps[lap].rear_wing}</td>
																<td>{$car1_laps[lap].front_suspension}</td>
																<td>{$car1_laps[lap].rear_suspension}</td>
																<td>{$car1_laps[lap].tire_pressure}</td>
																<td>{$car1_laps[lap].brake_balance}</td>
																<td>{$car1_laps[lap].gear_ratio}</td>
															</tr>
														{/section}
													</tbody>
												</table>
											</div>
											<div class="mobile_slider">
												<table class="table table-striped">
													<thead>
													<tr>
														<th></th>
														<th>{translate}tr_race_training_setup_round_time_short{/translate}</th>
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
														{$i=count($car1_laps)}
														{section name=lap loop=$car1_laps}
															<tr>
																<td>{$i--}</td>
																<td>{$car1_laps[lap].round_time_string}</td>
																<td>{if $car1_laps[lap].tire_type == 0}{translate}tr_race_training_setup_hard{/translate}{else}{translate}tr_race_training_setup_soft{/translate}{/if}</td>
																<td>{$car1_laps[lap].front_wing}</td>
																<td>{$car1_laps[lap].rear_wing}</td>
																<td>{$car1_laps[lap].front_suspension}</td>
																<td>{$car1_laps[lap].rear_suspension}</td>
																<td>{$car1_laps[lap].tire_pressure}</td>
																<td>{$car1_laps[lap].brake_balance}</td>
																<td>{$car1_laps[lap].gear_ratio}</td>
															</tr>
														{/section}
													</tbody>
												</table>
											</div>
                                        </div>
                                    </div><!--/span-->
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
                                    	{if $team_league == $league}
                                        <div style="text-align: center; color: red; margin-bottom: 10px;">{translate}tr_driver_training_laps_to_drive_pre{/translate}{$laps_to_go_driver2} {translate}tr_driver_training_laps_to_drive_post{/translate}</div>
                                        {/if}
                                        <form action="?site=race_training" method="post">
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
														{for $i = 1 to 30}
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
																	<input onchange="mobileChangeValue('tire_id_value2', this)" type="radio" name="tire_id" id="tire_id_{$car2_tires[tire].id}" value="{$car2_tires[tire].id}" {if $setting_tire_id_2 == $car2_tires[tire].id}checked{/if}>
																	<img src="content/img/tires/{$car2_tires[tire].tire_picture}" width="40px"/>{$car2_tires[tire].tire_name}
																</label>
															{/section}
														</div>
														<div id="tire_value_mobile" class="mobile_slider">
															<select onchange="mobileChangeValue('tire_id_value2', this)" style="width:100%">
																{$j = 0}
																{section name=tire loop=$car2_tires}
																	<option value="{$car2_tires[tire].id}" {if $setting_tire_id_2 == $car2_tires[tire].id}selected{else}{if $j == 0}selected{/if}{/if}>{$car2_tires[tire].tire_name}</option>
																<!--{$j++}-->
																{/section}
															</select>
														</div>
														<input type="hidden" id="tire_id_value2" name="tire_id" value="{$setting_tire_id_2}">
													</div>
												</div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-2 col-xs-4">
                                                    <label class="control-label">{translate}tr_race_training_setup_front_wing{/translate}: </label>
                                                </div>
                                                <div class="col-md-10 col-xs-8">
                                                	<div id="front_wing_value_slider_desktop2" class="desktop_slider">
														<div id="front_wing_value_slider2" class="slider_darkgreen"></div>
														<div id="front_wing_value_amount2" style="color:#777;font-size:12px;text-align:center;"></div>
													</div>
	                                            	<div id="front_wing_value_slider_mobile2" class="mobile_slider">
														<select onchange="mobileChangeValue('front_wing_value2', this);" style="width:100%">
														{for $i = 0 to 90}
															<option value="{$i}" {if $i == $settings.front_wing}selected{/if}>{$i} {translate}tr_driver_setting_degree{/translate}</option>
														{/for}
														</select>
	                                            	</div>
													<input id="front_wing_value2" type="hidden" value="{$settings.front_wing}" name="front_wing_value">
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-2 col-xs-4">
                                                    <label class="control-label">{translate}tr_race_training_setup_rear_wing{/translate}: </label>
                                                </div>
                                                <div class="col-md-10 col-xs-8">
                                                	<div id="rear_wing_value_slider_desktop2" class="desktop_slider">
														<div id="rear_wing_value_slider2" class="slider_lightgreen"></div>
														<div id="rear_wing_value_amount2" style="color:#777;font-size:12px;text-align:center;"></div>
													</div>
	                                            	<div id="rear_wing_value_slider_mobile2" class="mobile_slider">
														<select onchange="mobileChangeValue('rear_wing_value2', this);" style="width:100%">
														{for $i = 0 to 90}
															<option value="{$i}" {if $i == $settings.rear_wing}selected{/if}>{$i} {translate}tr_driver_setting_degree{/translate}</option>
														{/for}
														</select>
	                                            	</div>
													<input id="rear_wing_value2" type="hidden" value="{$settings.rear_wing}" name="rear_wing_value">
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-2 col-xs-4">
                                                    <label class="control-label">{translate}tr_race_training_setup_front_suspension{/translate}: </label>
                                                </div>
                                                <div class="col-md-1 col-xs-2" style="text-align:center">
                                                    {translate}tr_race_training_setup_soft{/translate}
                                                </div>
                                                <div class="col-md-8 col-xs-4">
                                                	<div id="front_suspension_value_slider_desktop2" class="desktop_slider">
														<div id="front_suspension_value_slider2" class="slider_darkblue"></div>
														<div id="front_suspension_value_amount2" style="color:#777;font-size:12px;text-align:center;"></div>
													</div>
	                                            	<div id="front_suspension_value_slider_mobile2" class="mobile_slider">
														<select onchange="mobileChangeValue('front_suspension_value2', this);" style="width:100%">
														{for $i = 0 to 100}
															<option value="{$i}" {if $i == $settings.front_suspension}selected{/if}>{$i} %</option>
														{/for}
														</select>
	                                            	</div>
													<input id="front_suspension_value2" type="hidden" value="{$settings.front_suspension}" name="front_suspension_value">
                                                </div>
                                                <div class="col-md-1 col-xs-2" style="text-align:center">
                                                    {translate}tr_race_training_setup_hard{/translate}
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-2 col-xs-4">
                                                    <label class="control-label">{translate}tr_race_training_setup_rear_suspension{/translate}: </label>
                                                </div>
                                                <div class="col-md-1 col-xs-2" style="text-align:center">
                                                    {translate}tr_race_training_setup_soft{/translate}
                                                </div>
                                                <div class="col-md-8 col-xs-4">
                                                	<div id="rear_suspension_value_slider_desktop2" class="desktop_slider">
														<div id="rear_suspension_value_slider2" class="slider_lightblue"></div>
														<div id="rear_suspension_value_amount2" style="color:#777;font-size:12px;text-align:center;"></div>
													</div>
	                                            	<div id="rear_suspension_value_slider_mobile2" class="mobile_slider">
														<select onchange="mobileChangeValue('rear_suspension_value2', this);" style="width:100%">
														{for $i = 0 to 100}
															<option value="{$i}" {if $i == $settings.rear_suspension}selected{/if}>{$i} %</option>
														{/for}
														</select>
	                                            	</div>
													<input id="rear_suspension_value2" type="hidden" value="{$settings.rear_suspension}" name="rear_suspension_value">
                                                </div>
                                                <div class="col-md-1 col-xs-2" style="text-align:center">
                                                    {translate}tr_race_training_setup_hard{/translate}
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-2 col-xs-4">
                                                    <label class="control-label">{translate}tr_race_training_setup_tire_pressure{/translate}: </label>
                                                </div>
                                                <div class="col-md-1 col-xs-2" style="text-align:center">
                                                    {translate}low{/translate}
                                                </div>
                                                <div class="col-md-8 col-xs-4">
                                                	<div id="tire_pressure_value_slider_desktop2" class="desktop_slider">
														<div id="tire_pressure_value_slider2" class="slider_orange"></div>
														<div id="tire_pressure_value_amount2" style="color:#777;font-size:12px;text-align:center;"></div>
													</div>
	                                            	<div id="tire_pressure_value_slider_mobile2" class="mobile_slider">
														<select onchange="mobileChangeValue('tire_pressure_value2', this);" style="width:100%">
														{for $i = 0 to 100}
															<option value="{$i}" {if $i == $settings.tire_pressure}selected{/if}>{$i} %</option>
														{/for}
														</select>
	                                            	</div>
													<input id="tire_pressure_value2" type="hidden" value="{$settings.tire_pressure}" name="tire_pressure_value">
                                                </div>
                                                <div class="col-md-1 col-xs-2" style="text-align:center">
                                                    {translate}high{/translate}
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-2 col-xs-4">
                                                    <label class="control-label">{translate}tr_race_training_setup_brake_balance{/translate}: </label>
                                                </div>
                                                <div class="col-md-1 col-xs-2" style="text-align:center">
                                                    {translate}front{/translate}
                                                </div>
                                                <div class="col-md-8 col-xs-4">
                                                	<div id="brake_balance_value_slider_desktop2" class="desktop_slider">
                                                		<div id="brake_balance_value_slider2" class="slider_yellow"></div>
                                                		<div id="brake_balance_value_amount2" style="color:#777;font-size:12px;text-align:center;"></div>
													</div>
	                                            	<div id="brake_balance_value_slider_mobile2" class="mobile_slider">
														<select onchange="mobileChangeValue('brake_balance_value2', this);" style="width:100%">
														{for $i = 0 to 100}
															<option value="{$i}" {if $i == $settings.brake_balance}selected{/if}>{$i} %</option>
														{/for}
														</select>
	                                            	</div>
	                                            	<input id="brake_balance_value2" type="hidden" value="{$settings.brake_balance}" name="brake_balance_value">
                                                </div>
                                                <div class="col-md-1 col-xs-2" style="text-align:center">
                                                    {translate}rear{/translate}
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-2 col-xs-4">
                                                    <label class="control-label">{translate}tr_race_training_setup_gear_ratio{/translate}: </label>
                                                </div>
                                                <div class="col-md-1 col-xs-2" style="text-align:center">
                                                    {translate}short{/translate}
                                                </div>
                                                <div class="col-md-8 col-xs-4">
                                                	<div id="gear_ratio_value_slider_desktop2" class="desktop_slider">
														<div id="gear_ratio_value_slider2" class="slider_red"></div>
														<div id="gear_ratio_value_amount2" style="color:#777;font-size:12px;text-align:center;"></div>
													</div>
	                                            	<div id="gear_ratio_value_slider_mobile2" class="mobile_slider">
														<select onchange="mobileChangeValue('gear_ratio_value2', this);" style="width:100%">
														{for $i = 0 to 100}
															<option value="{$i}" {if $i == $settings.gear_ratio}selected{/if}>{$i} %</option>
														{/for}
														</select>
	                                            	</div>
	                                            	<input id="gear_ratio_value2" type="hidden" value="{$settings.gear_ratio}" name="gear_ratio_value">
                                                </div>
                                                <div class="col-md-1 col-xs-2" style="text-align:center">
                                                    {translate}long{/translate}
                                                </div>
                                            </div>
                                            <input type="hidden" name="car" value="2">
                                            {if $laps_to_go_driver2 > 0}
                                                <button type="submit" class="btn btn-primary">{translate}tr_button_drive{/translate}</button>
                                            {/if}
                                            <a class="btn default" href="#responsive1" data-toggle="modal">{translate}tr_driver_training_comment{/translate}</a>
                                        </form>
                                        <div id="responsive1" class="modal fade" aria-hidden="true" tabindex="-1" style="display: none;">
											<div class="modal-dialog">
												<div class="modal-content">
													<div class="modal-header">
														<button class="close" aria-hidden="true" data-dismiss="modal" type="button"></button>
														<h4 class="modal-title">{translate}tr_driver_training_comment{/translate}</h4>
													</div>
													<div class="modal-body">
														<div class="row">
															<div class="col-md-12 col-xs-12">
																<div class="col-md-4 col-xs-5"><img src="content/img/driver/{$driver2['picture']}" width="100px"/></div>
																<div class="col-md-8 col-xs-7">
																	{section name=comment loop=$car2_comments}
																		{$car2_comments[comment]}<br/>
																	{/section}
																</div>
															</div>
														</div>
													</div>
													<div class="modal-footer">
														<button class="btn red" data-dismiss="modal" type="button">{translate}tr_button_good_job{/translate}</button>
													</div>
												</div>
											</div>
										</div>
                                    </div>
                                </div>

                                <div class="row">
                                	<div class="portlet box red">
					    				<div class="portlet-title">
					    					<div class="caption">{translate}tr_race_training_result_detail{/translate}</div>
					    				</div>
					    				<div class="portlet-body">
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
													<tr>
														<td>{translate}tr_race_training_setup_last_lap{/translate}:</td>
														<td>{$car2_last_lap.round_time_string}</td>
														<td>{$car2_last_lap.front_wing}</td>
														<td>{$car2_last_lap.rear_wing}</td>
														<td>{$car2_last_lap.front_suspension}</td>
														<td>{$car2_last_lap.rear_suspension}</td>
														<td>{$car2_last_lap.tire_pressure}</td>
														<td>{$car2_last_lap.brake_balance}</td>
														<td>{$car2_last_lap.gear_ratio}</td>
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
													<tr>
														<td>{translate}tr_race_training_setup_last_lap_short{/translate}:</td>
														<td>{$car2_last_lap.round_time_string}</td>
														<td>{$car2_last_lap.front_wing}</td>
														<td>{$car2_last_lap.rear_wing}</td>
														<td>{$car2_last_lap.front_suspension}</td>
														<td>{$car2_last_lap.rear_suspension}</td>
														<td>{$car2_last_lap.tire_pressure}</td>
														<td>{$car2_last_lap.brake_balance}</td>
														<td>{$car2_last_lap.gear_ratio}</td>
													</tr>
													</tbody>
												</table>
                                            </div>
                                        </div>
                                    </div><!--/span-->
                                </div>
                            
	                            <div class="row">
	                            	<div class="portlet box red">
					    				<div class="portlet-title">
					    					<div class="caption">{translate}tr_finance_detail_text{/translate}</div>
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
														{$i=count($car2_laps)}
														{section name=lap loop=$car2_laps}
															<tr>
																<td>{$i--}</td>
																<td>{$car2_laps[lap].round_time_string}</td>
																<td>{if $car2_laps[lap].tire_type == 0}{translate}tr_race_training_setup_hard{/translate}{else}{translate}tr_race_training_setup_soft{/translate}{/if}</td>
																<td>{$car2_laps[lap].front_wing}</td>
																<td>{$car2_laps[lap].rear_wing}</td>
																<td>{$car2_laps[lap].front_suspension}</td>
																<td>{$car2_laps[lap].rear_suspension}</td>
																<td>{$car2_laps[lap].tire_pressure}</td>
																<td>{$car2_laps[lap].brake_balance}</td>
																<td>{$car2_laps[lap].gear_ratio}</td>
															</tr>
														{/section}
													</tbody>
												</table>
	                                        </div>
	                                        <div class="mobile_slider">
	                                        	<table class="table table-striped">
													<thead>
													<tr>
														<th></th>
														<th>{translate}tr_race_training_setup_round_time_short{/translate}</th>
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
														{$i=count($car2_laps)}
														{section name=lap loop=$car2_laps}
															<tr>
																<td>{$i--}</td>
																<td>{$car2_laps[lap].round_time_string}</td>
																<td>{if $car2_laps[lap].tire_type == 0}{translate}tr_race_training_setup_hard{/translate}{else}{translate}tr_race_training_setup_soft{/translate}{/if}</td>
																<td>{$car2_laps[lap].front_wing}</td>
																<td>{$car2_laps[lap].rear_wing}</td>
																<td>{$car2_laps[lap].front_suspension}</td>
																<td>{$car2_laps[lap].rear_suspension}</td>
																<td>{$car2_laps[lap].tire_pressure}</td>
																<td>{$car2_laps[lap].brake_balance}</td>
																<td>{$car2_laps[lap].gear_ratio}</td>
															</tr>
														{/section}
													</tbody>
												</table>
	                                        </div>
	                                    </div>
	                                </div><!--/span-->
		                        </div>
		                        {/if}
							</div>
							
							
							<div id="training_car" class="tab-pane fade{if $last_car == 3} active in{/if}">
	                        	{if $car3_error != null}
									{$car3_error}
								{else}
								<div class="row">
                                    <div class="col-md-12 col-xs-12">
										<div class="col-md-2 col-xs-4"><img src="content/img/driver/{$driver3['picture']}" width="100px"/></div>
			                            <div class="col-md-4 col-xs-6">
			                                {translate}tr_car_setting_driver{/translate}: <a href="?site=driverinfo&id={$driver3['id']}">{$driver3['firstname']} {$driver3['lastname']}</a><br>
			                                {translate}tr_finance_setting_mechanic{/translate}:<br>
											{translate}tr_mechanic_setting_setup{/translate}: {$setup} % {translate}better{/translate}<br>
											{translate}tr_finance_setting_tires{/translate}: {$tires} % {translate}better{/translate}<br>
			                            </div>
			                            <div class="col-md-3 col-xs-4">
			                                {translate}driver_value{/translate}:<br>
			                                <div class="driver_value">{$driver3.driver_value} %</div>
			                            </div>
			                            <div class="col-md-3 col-xs-4">
			                            	{translate}car_value{/translate}:<br>
			                                <div class="car_value">{$car3.car_value} %</div>
			                            </div>
			                        </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                    	{if $team_league == $league}
                                        <div style="text-align: center; color: red; margin-bottom: 10px;">{translate}tr_driver_training_laps_to_drive_pre{/translate}{$laps_to_go_driver3} {translate}tr_driver_training_laps_to_drive_post{/translate}</div>
                                        {/if}
                                        <form action="?site=race_training" method="post">
                                            <div class="row">
                                            	<div class="col-md-2 col-xs-4">
	                                                <label class="control-label">{translate}tr_race_training_setup_rounds{/translate}: </label>
	                                            </div>
	                                            <div class="col-md-10 col-xs-8">
	                                            	<div id="rounds_value_slider_desktop3" class="desktop_slider">
														<div id="rounds_value_slider3" class="slider_black"></div>
														<div id="rounds_value_amount3" style="color:#777;font-size:12px;text-align:center;"></div>
													</div>
	                                            	<div id="rounds_value_slider_mobile3" class="mobile_slider">
														<select onchange="mobileChangeValue('rounds_value3', this);" style="width:100%">
														{for $i = 1 to 30}
															<option value="{$i}" {if $i == $rounds}selected{/if}>{$i} {translate}tr_race_training_setup_rounds{/translate}</option>
														{/for}
														</select>
	                                            	</div>
	                                            	<input id="rounds_value3" type="hidden" value="{$rounds}" name="rounds_value">
	                                            </div>
                                            </div>
                                            <div class="row control-group">
                                                <div class="col-md-2 col-xs-4">
													<label class="control-label">{translate}tr_race_training_setup_tires{/translate}</label>
												</div>
	                                            <div class="col-md-10 col-xs-8">
													<div class="controls">
														<div id="tire_value_desktop" class="desktop_slider">
															{section name=tire loop=$car3_tires}
																<label class="col-md-4 col-xs-4">
																	<input onchange="mobileChangeValue('tire_id_value3', this)" type="radio" name="tire_id" id="tire_id_{$car3_tires[tire].id}" value="{$car3_tires[tire].id}" {if $setting_tire_id_3 == $car3_tires[tire].id}checked{/if}>
																	<img src="content/img/tires/{$car3_tires[tire].tire_picture}" width="40px"/>{$car3_tires[tire].tire_name}
																</label>
															{/section}
														</div>
														<div id="tire_value_mobile" class="mobile_slider">
															<select onchange="mobileChangeValue('tire_id_value3', this)" style="width:100%">
																{$j = 0}
																{section name=tire loop=$car3_tires}
																	<option value="{$car3_tires[tire].id}" {if $setting_tire_id_3 == $car3_tires[tire].id}selected{else}{if $j == 0}selected{/if}{/if}>{$car3_tires[tire].tire_name}</option>
																<!--{$j++}-->
																{/section}
															</select>
														</div>
														<input type="hidden" id="tire_id_value3" name="tire_id" value="{$setting_tire_id_3}">
													</div>
												</div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-2 col-xs-4">
                                                    <label class="control-label">{translate}tr_race_training_setup_front_wing{/translate}: </label>
                                                </div>
                                                <div class="col-md-10 col-xs-8">
                                                	<div id="front_wing_value_slider_desktop3" class="desktop_slider">
														<div id="front_wing_value_slider3" class="slider_darkgreen"></div>
														<div id="front_wing_value_amount3" style="color:#777;font-size:12px;text-align:center;"></div>
													</div>
	                                            	<div id="front_wing_value_slider_mobile3" class="mobile_slider">
														<select onchange="mobileChangeValue('front_wing_value3', this);" style="width:100%">
														{for $i = 0 to 90}
															<option value="{$i}" {if $i == $settings.front_wing}selected{/if}>{$i} {translate}tr_driver_setting_degree{/translate}</option>
														{/for}
														</select>
	                                            	</div>
													<input id="front_wing_value3" type="hidden" value="{$settings.front_wing}" name="front_wing_value">
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-2 col-xs-4">
                                                    <label class="control-label">{translate}tr_race_training_setup_rear_wing{/translate}: </label>
                                                </div>
                                                <div class="col-md-10 col-xs-8">
                                                	<div id="rear_wing_value_slider_desktop3" class="desktop_slider">
														<div id="rear_wing_value_slider3" class="slider_lightgreen"></div>
														<div id="rear_wing_value_amount3" style="color:#777;font-size:12px;text-align:center;"></div>
													</div>
	                                            	<div id="rear_wing_value_slider_mobile3" class="mobile_slider">
														<select onchange="mobileChangeValue('rear_wing_value3', this);" style="width:100%">
														{for $i = 0 to 90}
															<option value="{$i}" {if $i == $settings.rear_wing}selected{/if}>{$i} {translate}tr_driver_setting_degree{/translate}</option>
														{/for}
														</select>
	                                            	</div>
													<input id="rear_wing_value3" type="hidden" value="{$settings.rear_wing}" name="rear_wing_value">
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-2 col-xs-4">
                                                    <label class="control-label">{translate}tr_race_training_setup_front_suspension{/translate}: </label>
                                                </div>
                                                <div class="col-md-1 col-xs-2" style="text-align:center">
                                                    {translate}tr_race_training_setup_soft{/translate}
                                                </div>
                                                <div class="col-md-8 col-xs-4">
                                                	<div id="front_suspension_value_slider_desktop3" class="desktop_slider">
														<div id="front_suspension_value_slider3" class="slider_darkblue"></div>
														<div id="front_suspension_value_amount3" style="color:#777;font-size:12px;text-align:center;"></div>
													</div>
	                                            	<div id="front_suspension_value_slider_mobile3" class="mobile_slider">
														<select onchange="mobileChangeValue('front_suspension_value3', this);" style="width:100%">
														{for $i = 0 to 100}
															<option value="{$i}" {if $i == $settings.front_suspension}selected{/if}>{$i} %</option>
														{/for}
														</select>
	                                            	</div>
													<input id="front_suspension_value3" type="hidden" value="{$settings.front_suspension}" name="front_suspension_value">
                                                </div>
                                                <div class="col-md-1 col-xs-2" style="text-align:center">
                                                    {translate}tr_race_training_setup_hard{/translate}
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-2 col-xs-4">
                                                    <label class="control-label">{translate}tr_race_training_setup_rear_suspension{/translate}: </label>
                                                </div>
                                                <div class="col-md-1 col-xs-2" style="text-align:center">
                                                    {translate}tr_race_training_setup_soft{/translate}
                                                </div>
                                                <div class="col-md-8 col-xs-4">
                                                	<div id="rear_suspension_value_slider_desktop3" class="desktop_slider">
														<div id="rear_suspension_value_slider3" class="slider_lightblue"></div>
														<div id="rear_suspension_value_amount3" style="color:#777;font-size:12px;text-align:center;"></div>
													</div>
	                                            	<div id="rear_suspension_value_slider_mobile3" class="mobile_slider">
														<select onchange="mobileChangeValue('rear_suspension_value3', this);" style="width:100%">
														{for $i = 0 to 100}
															<option value="{$i}" {if $i == $settings.rear_suspension}selected{/if}>{$i} %</option>
														{/for}
														</select>
	                                            	</div>
													<input id="rear_suspension_value3" type="hidden" value="{$settings.rear_suspension}" name="rear_suspension_value">
                                                </div>
                                                <div class="col-md-1 col-xs-2" style="text-align:center">
                                                    {translate}tr_race_training_setup_hard{/translate}
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-2 col-xs-4">
                                                    <label class="control-label">{translate}tr_race_training_setup_tire_pressure{/translate}: </label>
                                                </div>
                                                <div class="col-md-1 col-xs-2" style="text-align:center">
                                                    {translate}low{/translate}
                                                </div>
                                                <div class="col-md-8 col-xs-4">
                                                	<div id="tire_pressure_value_slider_desktop3" class="desktop_slider">
														<div id="tire_pressure_value_slider3" class="slider_orange"></div>
														<div id="tire_pressure_value_amount3" style="color:#777;font-size:12px;text-align:center;"></div>
													</div>
	                                            	<div id="tire_pressure_value_slider_mobile3" class="mobile_slider">
														<select onchange="mobileChangeValue('tire_pressure_value3', this);" style="width:100%">
														{for $i = 0 to 100}
															<option value="{$i}" {if $i == $settings.tire_pressure}selected{/if}>{$i} %</option>
														{/for}
														</select>
	                                            	</div>
													<input id="tire_pressure_value3" type="hidden" value="{$settings.tire_pressure}" name="tire_pressure_value">
                                                </div>
                                                <div class="col-md-1 col-xs-3" style="text-align:center">
                                                    {translate}high{/translate}
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-2 col-xs-4">
                                                    <label class="control-label">{translate}tr_race_training_setup_brake_balance{/translate}: </label>
                                                </div>
                                                <div class="col-md-1 col-xs-2" style="text-align:center">
                                                    {translate}front{/translate}
                                                </div>
                                                <div class="col-md-8 col-xs-4">
                                                	<div id="brake_balance_value_slider_desktop3" class="desktop_slider">
                                                		<div id="brake_balance_value_slider3" class="slider_yellow"></div>
                                                		<div id="brake_balance_value_amount3" style="color:#777;font-size:12px;text-align:center;"></div>
													</div>
	                                            	<div id="brake_balance_value_slider_mobile3" class="mobile_slider">
														<select onchange="mobileChangeValue('brake_balance_value3', this);" style="width:100%">
														{for $i = 0 to 100}
															<option value="{$i}" {if $i == $settings.brake_balance}selected{/if}>{$i} %</option>
														{/for}
														</select>
	                                            	</div>
	                                            	<input id="brake_balance_value3" type="hidden" value="{$settings.brake_balance}" name="brake_balance_value">
                                                </div>
                                                <div class="col-md-1 col-xs-3" style="text-align:center">
                                                    {translate}rear{/translate}
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-2 col-xs-4">
                                                    <label class="control-label">{translate}tr_race_training_setup_gear_ratio{/translate}: </label>
                                                </div>
                                                <div class="col-md-1 col-xs-2" style="text-align:center">
                                                    {translate}short{/translate}
                                                </div>
                                                <div class="col-md-8 col-xs-4">
                                                	<div id="gear_ratio_value_slider_desktop3" class="desktop_slider">
														<div id="gear_ratio_value_slider3" class="slider_red"></div>
														<div id="gear_ratio_value_amount3" style="color:#777;font-size:12px;text-align:center;"></div>
													</div>
	                                            	<div id="gear_ratio_value_slider_mobile3" class="mobile_slider">
														<select onchange="mobileChangeValue('gear_ratio_value3', this);" style="width:100%">
														{for $i = 0 to 100}
															<option value="{$i}" {if $i == $settings.gear_ratio}selected{/if}>{$i} %</option>
														{/for}
														</select>
	                                            	</div>
	                                            	<input id="gear_ratio_value3" type="hidden" value="{$settings.gear_ratio}" name="gear_ratio_value">
                                                </div>
                                                <div class="col-md-1 col-xs-3" style="text-align:center">
                                                    {translate}long{/translate}
                                                </div>
                                            </div>
                                            <input type="hidden" name="car" value="3">
                                            {if $laps_to_go_driver3 > 0}
                                                <button type="submit" class="btn btn-primary">{translate}tr_button_drive{/translate}</button>
                                            {/if}
                                            <a class="btn default" href="#responsive2" data-toggle="modal">{translate}tr_driver_training_comment{/translate}</a>
                                        </form>
                                        <div id="responsive2" class="modal fade" aria-hidden="true" tabindex="-1" style="display: none;">
											<div class="modal-dialog">
												<div class="modal-content">
													<div class="modal-header">
														<button class="close" aria-hidden="true" data-dismiss="modal" type="button"></button>
														<h4 class="modal-title">{translate}tr_driver_training_comment{/translate}</h4>
													</div>
													<div class="modal-body">
														<div class="row">
															<div class="col-md-12 col-xs-12">
																<div class="col-md-4 col-xs-5"><img src="content/img/driver/{$driver3['picture']}" width="100px"/></div>
																<div class="col-md-8 col-xs-7">
																	{section name=comment loop=$car3_comments}
																		{$car3_comments[comment]}<br/>
																	{/section}
																</div>
															</div>
														</div>
													</div>
													<div class="modal-footer">
														<button class="btn red" data-dismiss="modal" type="button">{translate}tr_button_good_job{/translate}</button>
													</div>
												</div>
											</div>
										</div>
                                    </div>
                                </div>

                                <div class="row">
                                	<div class="portlet box red">
					    				<div class="portlet-title">
					    					<div class="caption">{translate}tr_race_training_result_detail{/translate}</div>
					    				</div>
					    				<div class="portlet-body">
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
														<td>{$car3_best_lap_soft.round_time_string}</td>
														<td>{$car3_best_lap_soft.front_wing}</td>
														<td>{$car3_best_lap_soft.rear_wing}</td>
														<td>{$car3_best_lap_soft.front_suspension}</td>
														<td>{$car3_best_lap_soft.rear_suspension}</td>
														<td>{$car3_best_lap_soft.tire_pressure}</td>
														<td>{$car3_best_lap_soft.brake_balance}</td>
														<td>{$car3_best_lap_soft.gear_ratio}</td>
													</tr>
													<tr>
														<td>{translate}tr_race_training_setup_best_lap{/translate} {translate}tr_race_training_setup_hard{/translate}:</td>
														<td>{$car3_best_lap_hard.round_time_string}</td>
														<td>{$car3_best_lap_hard.front_wing}</td>
														<td>{$car3_best_lap_hard.rear_wing}</td>
														<td>{$car3_best_lap_hard.front_suspension}</td>
														<td>{$car3_best_lap_hard.rear_suspension}</td>
														<td>{$car3_best_lap_hard.tire_pressure}</td>
														<td>{$car3_best_lap_hard.brake_balance}</td>
														<td>{$car3_best_lap_hard.gear_ratio}</td>
													</tr>
													<tr>
														<td>{translate}tr_race_training_setup_last_lap{/translate}:</td>
														<td>{$car3_last_lap.round_time_string}</td>
														<td>{$car3_last_lap.front_wing}</td>
														<td>{$car3_last_lap.rear_wing}</td>
														<td>{$car3_last_lap.front_suspension}</td>
														<td>{$car3_last_lap.rear_suspension}</td>
														<td>{$car3_last_lap.tire_pressure}</td>
														<td>{$car3_last_lap.brake_balance}</td>
														<td>{$car3_last_lap.gear_ratio}</td>
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
														<td>{$car3_best_lap_soft.round_time_string}</td>
														<td>{$car3_best_lap_soft.front_wing}</td>
														<td>{$car3_best_lap_soft.rear_wing}</td>
														<td>{$car3_best_lap_soft.front_suspension}</td>
														<td>{$car3_best_lap_soft.rear_suspension}</td>
														<td>{$car3_best_lap_soft.tire_pressure}</td>
														<td>{$car3_best_lap_soft.brake_balance}</td>
														<td>{$car3_best_lap_soft.gear_ratio}</td>
													</tr>
													<tr>
														<td>{translate}tr_race_training_setup_hard{/translate}:</td>
														<td>{$car3_best_lap_hard.round_time_string}</td>
														<td>{$car3_best_lap_hard.front_wing}</td>
														<td>{$car3_best_lap_hard.rear_wing}</td>
														<td>{$car3_best_lap_hard.front_suspension}</td>
														<td>{$car3_best_lap_hard.rear_suspension}</td>
														<td>{$car3_best_lap_hard.tire_pressure}</td>
														<td>{$car3_best_lap_hard.brake_balance}</td>
														<td>{$car3_best_lap_hard.gear_ratio}</td>
													</tr>
													<tr>
														<td>{translate}tr_race_training_setup_last_lap_short{/translate}:</td>
														<td>{$car3_last_lap.round_time_string}</td>
														<td>{$car3_last_lap.front_wing}</td>
														<td>{$car3_last_lap.rear_wing}</td>
														<td>{$car3_last_lap.front_suspension}</td>
														<td>{$car3_last_lap.rear_suspension}</td>
														<td>{$car3_last_lap.tire_pressure}</td>
														<td>{$car3_last_lap.brake_balance}</td>
														<td>{$car3_last_lap.gear_ratio}</td>
													</tr>
													</tbody>
												</table>
                                            </div>
                                        </div>
                                    </div><!--/span-->
                                </div>
                            
	                            <div class="row">
	                            	<div class="portlet box red">
					    				<div class="portlet-title">
					    					<div class="caption">{translate}tr_finance_detail_text{/translate}</div>
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
														{$i=count($car3_laps)}
														{section name=lap loop=$car3_laps}
															<tr>
																<td>{$i--}</td>
																<td>{$car3_laps[lap].round_time_string}</td>
																<td>{if $car3_laps[lap].tire_type == 0}{translate}tr_race_training_setup_hard{/translate}{else}{translate}tr_race_training_setup_soft{/translate}{/if}</td>
																<td>{$car3_laps[lap].front_wing}</td>
																<td>{$car3_laps[lap].rear_wing}</td>
																<td>{$car3_laps[lap].front_suspension}</td>
																<td>{$car3_laps[lap].rear_suspension}</td>
																<td>{$car3_laps[lap].tire_pressure}</td>
																<td>{$car3_laps[lap].brake_balance}</td>
																<td>{$car3_laps[lap].gear_ratio}</td>
															</tr>
														{/section}
													</tbody>
												</table>
	                                        </div>
	                                        <div class="mobile_slider">
	                                        	<table class="table table-striped">
													<thead>
													<tr>
														<th></th>
														<th>{translate}tr_race_training_setup_round_time_short{/translate}</th>
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
														{$i=count($car3_laps)}
														{section name=lap loop=$car3_laps}
															<tr>
																<td>{$i--}</td>
																<td>{$car3_laps[lap].round_time_string}</td>
																<td>{if $car3_laps[lap].tire_type == 0}{translate}tr_race_training_setup_hard{/translate}{else}{translate}tr_race_training_setup_soft{/translate}{/if}</td>
																<td>{$car3_laps[lap].front_wing}</td>
																<td>{$car3_laps[lap].rear_wing}</td>
																<td>{$car3_laps[lap].front_suspension}</td>
																<td>{$car3_laps[lap].rear_suspension}</td>
																<td>{$car3_laps[lap].tire_pressure}</td>
																<td>{$car3_laps[lap].brake_balance}</td>
																<td>{$car3_laps[lap].gear_ratio}</td>
															</tr>
														{/section}
													</tbody>
												</table>
	                                        </div>
	                                    </div>
	                                </div><!--/span-->
		                        </div>
		                        {/if}
							</div>
							
							
	                    </div>
		                {/if}
    				</div>
    			</div>
    			{/if}
    			<div class="portlet box red">
    				<div class="portlet-title">
    					<div class="caption">{translate}tr_race_training_result{/translate}</div>
    					<div class="tools">
    						{if $league < 4}
	    					<div style="float:left; margin-right: 10px">
								<form action="?site=race_training" method="post" style="margin-top: 0px; color:#000">
									<select id="tire_type" name="tire_type" onchange="this.form.submit()">
										<option value="2" selected>hart/weich</option>
										<option value="0" {if $tire_type==0}selected{/if}>hart</option>
										<option value="1" {if $tire_type==1}selected{/if}>weich</option>
									</select>
								</form>
	            			</div>
	            			{/if}
	            			<div style="float:left">
								<form action="?site=race_training" method="post" style="margin-top: 0px; color:#000">
									<select id="league" name="league" onchange="this.form.submit()">
										<option value="1" {if $league==1}selected{/if}>{translate}tr_league_title{/translate} 1</option>
										<option value="2" {if $league==2}selected{/if}>{translate}tr_league_title{/translate} 2</option>
										<option value="3" {if $league==3}selected{/if}>{translate}tr_league_title{/translate} 3</option>
										<option value="4" {if $league==4}selected{/if}>{translate}tr_league_youth_title{/translate}</option>
									</select>
								</form>
	            			</div>
    					</div>
    				</div>
    				<div class="portlet-body">
    					<table class="table table-striped">
		                    <thead>
		                    <tr>
		                        <th>{translate}tr_statistic_driver_position{/translate}</th>
		                        <th>{translate}tr_statistic_driver_name{/translate}</th>
		                        <th class="mobile_invisible_low">{translate}tr_statistic_driver_team_name{/translate}</th>
		                        <th class="mobile_invisible_low">{translate}tr_statistic_driver_manager_name{/translate}</th>
		                        <th>{translate}tr_race_training_lap_time{/translate}</th>
		                        <th class="mobile_invisible_high">{translate}tr_race_grandprix_difference{/translate}</th>
		                        <th>{translate}tr_race_training_rounds{/translate}</th>
		                    </tr>
		                    </thead>
		                    <tbody>
		                        {$i=1}
		                        {section name=lap loop=$laps_all}
		                            <tr {if $laps_all[lap].team_id == $team_id}class="line_highlight"{/if} style="color:#{$laps_all[lap].color};font-weight:bold">
		                                <td>{$i++}</td>
		                                <td>{$laps_all[lap].driver_firstname} {$laps_all[lap].driver_lastname}</td>
		                                <td class="mobile_invisible_low">{$laps_all[lap].team_name}</td>
		                                <td class="mobile_invisible_low">{$laps_all[lap].manager_name}</td>
		                                <td>{$laps_all[lap].round_time_string}</td>
		                                <td class="mobile_invisible_high">{$laps_all[lap].diff}</td>
		                                <td>{$laps_all[lap].rounds} / {$max_rounds}</td>
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
{literal}
<script>
var def_var = 0;
var rounds = {/literal}{if $rounds==null} 1 {else} {$rounds} {/if}{literal};
var front_wing = {/literal}{if $settings.front_wing == null} def_var {else} {$settings.front_wing} {/if}{literal};
var rear_wing = {/literal}{if $settings.rear_wing == null} def_var {else} {$settings.rear_wing} {/if}{literal};
var front_suspension = {/literal}{if $settings.front_suspension == null} def_var {else} {$settings.front_suspension} {/if}{literal};
var rear_suspension = {/literal}{if $settings.rear_suspension == null} def_var {else} {$settings.rear_suspension} {/if}{literal};
var tire_pressure = {/literal}{if $settings.tire_pressure == null} def_var {else} {$settings.tire_pressure} {/if}{literal};
var brake_balance = {/literal}{if $settings.brake_balance == null} def_var {else} {$settings.brake_balance} {/if}{literal};
var gear_ratio = {/literal}{if $settings.gear_ratio == null} def_var {else} {$settings.gear_ratio} {/if}{literal};
var last_car = {/literal}{if $last_car != 2 && $last_car != 3} '{translate}race_car{/translate}1' {/if}{if $last_car == 2} '{translate}race_car{/translate}2' {/if}{if $last_car == 3} '{translate}training_car{/translate}' {/if}{literal};

function mobileChangeValue(value_id, obj)
{
	$( "#"+value_id ).val( obj.value );
}

$(document).ready(function() {
	$('#myTab a[href="#'+last_car+'"]').tab('show');
	
	//rounds_value
	$( "#rounds_value_slider" ).slider({
      range: "min",
      value: rounds,
      min: 1,
      max: 30,
      slide: function( event, ui ) {
        $( "#rounds_value_amount" ).html( ui.value+" {/literal}{translate}tr_race_training_setup_rounds{/translate}{literal}" );
        $( "#rounds_value" ).val( ui.value );
      }
    });
    var value = $( "#rounds_value_slider" ).slider( "value" );
    $( "#rounds_value_amount" ).html( value+" {/literal}{translate}tr_race_training_setup_rounds{/translate}{literal}" );
    //front_wing_value
    $( "#front_wing_value_slider" ).slider({
      range: "min",
      value: front_wing,
      min: 0,
      max: 90,
      slide: function( event, ui ) {
        $( "#front_wing_value_amount" ).html( ui.value+" {/literal}{translate}tr_driver_setting_degree{/translate}{literal}" );
        $( "#front_wing_value" ).val( ui.value );
      }
    });
    var value = $( "#front_wing_value_slider" ).slider( "value" );
    $( "#front_wing_value_amount" ).html( value+" {/literal}{translate}tr_driver_setting_degree{/translate}{literal}" );
    //rear_wing_value
    $( "#rear_wing_value_slider" ).slider({
      range: "min",
      value: rear_wing,
      min: 0,
      max: 90,
      slide: function( event, ui ) {
        $( "#rear_wing_value_amount" ).html( ui.value+" {/literal}{translate}tr_driver_setting_degree{/translate}{literal}" );
        $( "#rear_wing_value" ).val( ui.value );
      }
    });
    var value = $( "#rear_wing_value_slider" ).slider( "value" );
    $( "#rear_wing_value_amount" ).html( value+" {/literal}{translate}tr_driver_setting_degree{/translate}{literal}" );
    //front_suspension_value
    $( "#front_suspension_value_slider" ).slider({
      range: "min",
      value: front_suspension,
      min: 0,
      max: 100,
      slide: function( event, ui ) {
        $( "#front_suspension_value_amount" ).html( ui.value+" %" );
        $( "#front_suspension_value" ).val( ui.value );
      }
    });
    var value = $( "#front_suspension_value_slider" ).slider( "value" );
    $( "#front_suspension_value_amount" ).html( value+" %" );
    //rear_suspension_value
    $( "#rear_suspension_value_slider" ).slider({
      range: "min",
      value: rear_suspension,
      min: 0,
      max: 100,
      slide: function( event, ui ) {
        $( "#rear_suspension_value_amount" ).html( ui.value+" %" );
        $( "#rear_suspension_value" ).val( ui.value );
      }
    });
    var value = $( "#rear_suspension_value_slider" ).slider( "value" );
    $( "#rear_suspension_value_amount" ).html( value+" %" );
    //tire_pressure_value
    $( "#tire_pressure_value_slider" ).slider({
      range: "min",
      value: tire_pressure,
      min: 0,
      max: 100,
      slide: function( event, ui ) {
        $( "#tire_pressure_value_amount" ).html( ui.value+" %" );
        $( "#tire_pressure_value" ).val( ui.value );
      }
    });
    var value = $( "#tire_pressure_value_slider" ).slider( "value" );
    $( "#tire_pressure_value_amount" ).html( value+" %" );
    //brake_balance_value
    $( "#brake_balance_value_slider" ).slider({
      range: "min",
      value: brake_balance,
      min: 0,
      max: 100,
      slide: function( event, ui ) {
        $( "#brake_balance_value_amount" ).html( ui.value+" %" );
        $( "#brake_balance_value" ).val( ui.value );
      }
    });
    var value = $( "#brake_balance_value_slider" ).slider( "value" );
    $( "#brake_balance_value_amount" ).html( value+" %" );
    //gear_ratio_value
    $( "#gear_ratio_value_slider" ).slider({
      range: "min",
      value: gear_ratio,
      min: 0,
      max: 100,
      slide: function( event, ui ) {
        $( "#gear_ratio_value_amount" ).html( ui.value+" %" );
        $( "#gear_ratio_value" ).val( ui.value );
      }
    });
    var value = $( "#gear_ratio_value_slider" ).slider( "value" );
    $( "#gear_ratio_value_amount" ).html( value+" %" );
    
    
    
    
    
    //rounds_value
	$( "#rounds_value_slider2" ).slider({
      range: "min",
      value: rounds,
      min: 1,
      max: 30,
      slide: function( event, ui ) {
        $( "#rounds_value_amount2" ).html( ui.value+" {/literal}{translate}tr_race_training_setup_rounds{/translate}{literal}" );
        $( "#rounds_value2" ).val( ui.value );
      }
    });
    var value = $( "#rounds_value_slider2" ).slider( "value" );
    $( "#rounds_value_amount2" ).html( value+" {/literal}{translate}tr_race_training_setup_rounds{/translate}{literal}" );
    //front_wing_value
    $( "#front_wing_value_slider2" ).slider({
      range: "min",
      value: front_wing,
      min: 0,
      max: 90,
      slide: function( event, ui ) {
        $( "#front_wing_value_amount2" ).html( ui.value+" {/literal}{translate}tr_driver_setting_degree{/translate}{literal}" );
        $( "#front_wing_value2" ).val( ui.value );
      }
    });
    var value = $( "#front_wing_value_slider2" ).slider( "value" );
    $( "#front_wing_value_amount2" ).html( value+" {/literal}{translate}tr_driver_setting_degree{/translate}{literal}" );
    //rear_wing_value
    $( "#rear_wing_value_slider2" ).slider({
      range: "min",
      value: rear_wing,
      min: 0,
      max: 90,
      slide: function( event, ui ) {
        $( "#rear_wing_value_amount2" ).html( ui.value+" {/literal}{translate}tr_driver_setting_degree{/translate}{literal}" );
        $( "#rear_wing_value2" ).val( ui.value );
      }
    });
    var value = $( "#rear_wing_value_slider2" ).slider( "value" );
    $( "#rear_wing_value_amount2" ).html( value+" {/literal}{translate}tr_driver_setting_degree{/translate}{literal}" );
    //front_suspension_value
    $( "#front_suspension_value_slider2" ).slider({
      range: "min",
      value: front_suspension,
      min: 0,
      max: 100,
      slide: function( event, ui ) {
        $( "#front_suspension_value_amount2" ).html( ui.value+" %" );
        $( "#front_suspension_value2" ).val( ui.value );
      }
    });
    var value = $( "#front_suspension_value_slider2" ).slider( "value" );
    $( "#front_suspension_value_amount2" ).html( value+" %" );
    //rear_suspension_value
    $( "#rear_suspension_value_slider2" ).slider({
      range: "min",
      value: rear_suspension,
      min: 0,
      max: 100,
      slide: function( event, ui ) {
        $( "#rear_suspension_value_amount2" ).html( ui.value+" %" );
        $( "#rear_suspension_value2" ).val( ui.value );
      }
    });
    var value = $( "#rear_suspension_value_slider2" ).slider( "value" );
    $( "#rear_suspension_value_amount2" ).html( value+" %" );
    //tire_pressure_value
    $( "#tire_pressure_value_slider2" ).slider({
      range: "min",
      value: tire_pressure,
      min: 0,
      max: 100,
      slide: function( event, ui ) {
        $( "#tire_pressure_value_amount2" ).html( ui.value+" %" );
        $( "#tire_pressure_value2" ).val( ui.value );
      }
    });
    var value = $( "#tire_pressure_value_slider2" ).slider( "value" );
    $( "#tire_pressure_value_amount2" ).html( value+" %" );
    //brake_balance_value
    $( "#brake_balance_value_slider2" ).slider({
      range: "min",
      value: brake_balance,
      min: 0,
      max: 100,
      slide: function( event, ui ) {
        $( "#brake_balance_value_amount2" ).html( ui.value+" %" );
        $( "#brake_balance_value2" ).val( ui.value );
      }
    });
    var value = $( "#brake_balance_value_slider2" ).slider( "value" );
    $( "#brake_balance_value_amount2" ).html( value+" %" );
    //gear_ratio_value
    $( "#gear_ratio_value_slider2" ).slider({
      range: "min",
      value: gear_ratio,
      min: 0,
      max: 100,
      slide: function( event, ui ) {
        $( "#gear_ratio_value_amount2" ).html( ui.value+" %" );
        $( "#gear_ratio_value2" ).val( ui.value );
      }
    });
    var value = $( "#gear_ratio_value_slider2" ).slider( "value" );
    $( "#gear_ratio_value_amount2" ).html( value+" %" );
    
    
    
    //rounds_value
	$( "#rounds_value_slider3" ).slider({
      range: "min",
      value: rounds,
      min: 1,
      max: 30,
      slide: function( event, ui ) {
        $( "#rounds_value_amount3" ).html( ui.value+" {/literal}{translate}tr_race_training_setup_rounds{/translate}{literal}" );
        $( "#rounds_value3" ).val( ui.value );
      }
    });
    var value = $( "#rounds_value_slider3" ).slider( "value" );
    $( "#rounds_value_amount3" ).html( value+" {/literal}{translate}tr_race_training_setup_rounds{/translate}{literal}" );
    //front_wing_value
    $( "#front_wing_value_slider3" ).slider({
      range: "min",
      value: front_wing,
      min: 0,
      max: 90,
      slide: function( event, ui ) {
        $( "#front_wing_value_amount3" ).html( ui.value+" {/literal}{translate}tr_driver_setting_degree{/translate}{literal}" );
        $( "#front_wing_value3" ).val( ui.value );
      }
    });
    var value = $( "#front_wing_value_slider3" ).slider( "value" );
    $( "#front_wing_value_amount3" ).html( value+" {/literal}{translate}tr_driver_setting_degree{/translate}{literal}" );
    //rear_wing_value
    $( "#rear_wing_value_slider3" ).slider({
      range: "min",
      value: rear_wing,
      min: 0,
      max: 90,
      slide: function( event, ui ) {
        $( "#rear_wing_value_amount3" ).html( ui.value+" {/literal}{translate}tr_driver_setting_degree{/translate}{literal}" );
        $( "#rear_wing_value3" ).val( ui.value );
      }
    });
    var value = $( "#rear_wing_value_slider3" ).slider( "value" );
    $( "#rear_wing_value_amount3" ).html( value+" {/literal}{translate}tr_driver_setting_degree{/translate}{literal}" );
    //front_suspension_value
    $( "#front_suspension_value_slider3" ).slider({
      range: "min",
      value: front_suspension,
      min: 0,
      max: 100,
      slide: function( event, ui ) {
        $( "#front_suspension_value_amount3" ).html( ui.value+" %" );
        $( "#front_suspension_value3" ).val( ui.value );
      }
    });
    var value = $( "#front_suspension_value_slider3" ).slider( "value" );
    $( "#front_suspension_value_amount3" ).html( value+" %" );
    //rear_suspension_value
    $( "#rear_suspension_value_slider3" ).slider({
      range: "min",
      value: rear_suspension,
      min: 0,
      max: 100,
      slide: function( event, ui ) {
        $( "#rear_suspension_value_amount3" ).html( ui.value+" %" );
        $( "#rear_suspension_value3" ).val( ui.value );
      }
    });
    var value = $( "#rear_suspension_value_slider3" ).slider( "value" );
    $( "#rear_suspension_value_amount3" ).html( value+" %" );
    //tire_pressure_value
    $( "#tire_pressure_value_slider3" ).slider({
      range: "min",
      value: tire_pressure,
      min: 0,
      max: 100,
      slide: function( event, ui ) {
        $( "#tire_pressure_value_amount3" ).html( ui.value+" %" );
        $( "#tire_pressure_value3" ).val( ui.value );
      }
    });
    var value = $( "#tire_pressure_value_slider3" ).slider( "value" );
    $( "#tire_pressure_value_amount3" ).html( value+" %" );
    //brake_balance_value
    $( "#brake_balance_value_slider3" ).slider({
      range: "min",
      value: brake_balance,
      min: 0,
      max: 100,
      slide: function( event, ui ) {
        $( "#brake_balance_value_amount3" ).html( ui.value+" %" );
        $( "#brake_balance_value3" ).val( ui.value );
      }
    });
    var value = $( "#brake_balance_value_slider3" ).slider( "value" );
    $( "#brake_balance_value_amount3" ).html( value+" %" );
    //gear_ratio_value
    $( "#gear_ratio_value_slider3" ).slider({
      range: "min",
      value: gear_ratio,
      min: 0,
      max: 100,
      slide: function( event, ui ) {
        $( "#gear_ratio_value_amount3" ).html( ui.value+" %" );
        $( "#gear_ratio_value3" ).val( ui.value );
      }
    });
    var value = $( "#gear_ratio_value_slider3" ).slider( "value" );
    $( "#gear_ratio_value_amount3" ).html( value+" %" );
});
</script>
{/literal}