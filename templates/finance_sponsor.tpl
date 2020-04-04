<div class="page-content-wrapper">
    <div class="page-content">
    	<div class="row">
    		<div class="col-md-12">
    			<div class="portlet box yellow-saffron">
    				<div class="portlet-title">
    					<div class="caption">{translate}tr_finance_setting_sponsors{/translate}</div>
    				</div>
    				<div class="portlet-body">
						{if $sponsors != null}
						<div class="row">
							{section name=sponsor loop=$sponsors}
								<div class="box col-md-4 col-xs-12">
									<div class="box-header">
										<h2><i class="halflings-icon align-justify"></i><span class="break"></span>{$sponsors[sponsor].name}</h2>
									</div>
									<div class="box-content desktop_slider">
										<div class='row'>
											{if $sponsors[sponsor].picture != null}
											<div class="col-md-12">
												<img src="content/img/sponsor/{$sponsors[sponsor].picture}" width="150px"/>
											</div>
											{/if}
											<div class="col-md-12">
												<div class="col-md-6">{translate}tr_finance_setting_value{/translate}:</div>
												<div class="col-md-5" align="right">{$sponsors[sponsor].value} {translate}tr_global_currency_symbol{/translate}</div>
											</div>
											<div class="col-md-12">
												<div class="col-md-6">{translate}tr_finance_setting_bonus{/translate}:</div>
												<div class="col-md-5" align="right">{$sponsors[sponsor].bonus} {translate}tr_global_currency_symbol{/translate}</div>
											</div>
											<div class="col-md-11" align="right">
												<form action="?site=finance_sponsor" method="post">
													<input type="hidden" id="sponsor_id" name="sponsor_id" value="{$sponsors[sponsor].id}"/>
													<input type="submit" class="btn btn-small btn-success" value="{translate}tr_button_sign{/translate}"/>
												</form>
											</div>
										</div>
									</div>
									<div class="box-content mobile_slider">
										<div class='row'>
											{if $sponsors[sponsor].picture != null}
											<div class="col-xs-6">
												<img src="content/img/sponsor/{$sponsors[sponsor].picture}" width="150px"/>
											</div>
											<div class="col-xs-6">
											{else}
											<div class="col-xs-12">
											{/if}
												<div class="col-xs-12">
													<div class="col-xs-6">{translate}tr_finance_setting_value{/translate}:</div>
													<div class="col-xs-6" align="right">{$sponsors[sponsor].value} {translate}tr_global_currency_symbol{/translate}</div>
												</div>
												<div class="col-xs-12">
													<div class="col-xs-6">{translate}tr_finance_setting_bonus{/translate}:</div>
													<div class="col-xs-6" align="right">{$sponsors[sponsor].bonus} {translate}tr_global_currency_symbol{/translate}</div>
												</div>
												<div class="col-xs-12" align="right">
													<form action="?site=finance_sponsor" method="post">
														<input type="hidden" id="sponsor_id" name="sponsor_id" value="{$sponsors[sponsor].id}"/>
														<input type="submit" class="btn btn-small btn-success" value="{translate}tr_button_sign{/translate}"/>
													</form>
												</div>
											</div>
										</div>
									</div>
								</div>
							{/section}
						</div>
					</div>
				{else}
				<div class="box col-md-6 col-xs-12">
		            <div class="box-header">
		                <h2><i class="halflings-icon align-justify"></i><span class="break"></span>{translate}tr_finance_main_sponsor{/translate}: {$sponsor.name}</h2>
		            </div>
		            <div class="box-content desktop_slider">
		                <div class='row'>
			                {if $sponsor.picture != null}
		                    <div class="col-md-12">
		                        <img src="content/img/sponsor/{$sponsor.picture}" width="150px"/>
		                    </div>
		                    {/if}
		                    <div class='row'>
		                        <div class="col-md-6">{translate}tr_finance_setting_value{/translate}:</div>
		                        <div class="col-md-6">{$sponsor.value} {translate}tr_global_currency_symbol{/translate}</div>
		                    </div>
		                    <div class='row'>
		                        <div class="col-md-6">{translate}tr_finance_setting_bonus{/translate}:</div>
		                        <div class="col-md-6">{$sponsor.bonus} {translate}tr_global_currency_symbol{/translate}</div>
		                    </div>
		                </div>
		            </div>
		            <div class="box-content mobile_slider">
		                <div class='row'>
			                {if $sponsor.picture != null}
		                    <div class="col-xs-6">
		                        <img src="content/img/sponsor/{$sponsor.picture}" width="150px"/>
		                    </div>
		                    <div class="col-xs-6">
		                    {else}
		                    <div class="col-xs-12">
		                    {/if}
								<div class="col-xs-12">
									<div class="col-xs-6">{translate}tr_finance_setting_value{/translate}:</div>
									<div class="col-xs-6" align="right">{$sponsor.value} {translate}tr_global_currency_symbol{/translate}</div>
								</div>
								<div class="col-xs-12">
									<div class="col-xs-6">{translate}tr_finance_setting_bonus{/translate}:</div>
									<div class="col-xs-6" align="right">{$sponsor.bonus} {translate}tr_global_currency_symbol{/translate}</div>
								</div>
		                    </div>
		                </div>
		            </div>
		        </div>
				{/if}
				
				{if $tires != null}
				<div class="portlet box yellow-saffron">
    				<div class="portlet-title">
    					<div class="caption">{translate}tr_finance_setting_tires{/translate}</div>
    				</div>
    				<div class="portlet-body">
						<div class="row">
							{section name=tire loop=$tires}
					            <div class="box col-md-4">
					                <div class="box-header">
					                    <h2><i class="halflings-icon align-justify"></i><span class="break"></span>{$tires[tire].name}</h2>
					                </div>
					                <div class="box-content desktop_slider">
					                    <div class='row'>
						                    {if $tires[tire].picture != null}
					                    	<div class="col-md-12">
						                        <img src="content/img/tire/{$tires[tire].picture}" width="150px"/>
						                    </div>
						                    {/if}
					                        <div class="col-md-12">
					                            <div class="col-md-6">{translate}tr_finance_setting_value{/translate}:</div>
					                            <div class="col-md-5" align="right">{$tires[tire].value} {translate}tr_global_currency_symbol{/translate}</div>
					                        </div>
					                        <div class="col-md-12">
					                            <div class="col-md-6">{translate}tr_finance_setting_bonus{/translate}:</div>
					                            <div class="col-md-5" align="right">{$tires[tire].bonus} {translate}tr_global_currency_symbol{/translate}</div>
					                        </div>
					                        <div class="col-md-12" style="margin: 10px 0">
												<div class="col-md-3"><img src="content/img/tires/{$tires[tire].picture_dry_hard}" width="75px"></div>
												<div class="col-md-3"><img src="content/img/tires/{$tires[tire].picture_dry_soft}" width="75px"></div>
												<div class="col-md-3"><img src="content/img/tires/{$tires[tire].picture_wet_hard}" width="75px"></div>
												<div class="col-md-3"><img src="content/img/tires/{$tires[tire].picture_wet_soft}" width="75px"></div>
											</div>
					                        <div class="col-md-11 widget blue">
					                        	<div>{translate}tr_race_training_setup_dry_tires{/translate}:</div>
										        <div id="tire-chart-{$tires[tire].id}" style="height:150px"></div>
										        <div>{translate}tr_race_training_setup_wet_tires{/translate}:</div>
										        <div id="tire-chart-rain-{$tires[tire].id}" style="height:150px"></div>
										    </div>
										    
										    <div class="col-md-11" align="right">
												<form action="?site=finance_sponsor" method="post">
													<input type="hidden" id="tire_id" name="tire_id" value="{$tires[tire].id}"/>
													<input type="submit" class="btn btn-small btn-success" value="{translate}tr_button_sign{/translate}"/>
												</form>
					                        </div>
										    <script>
										    	var hart = {$tires[tire].hard};
										    	var soft = {$tires[tire].soft};
										    	var hart_regen = {$tires[tire].hard_rain};
										    	var soft_regen = {$tires[tire].soft_rain};
											    var plot = $.plot($("#tire-chart-{$tires[tire].id}"),
												   [ { data: hart, 
													   label: "{translate}tr_race_training_setup_hard{/translate}", 
													   lines: { show: true, 
																fill: false,
																lineWidth: 2 
															  },
													   shadowSize: 0	
													 }, 
													 { data: soft,
													   label: "{translate}tr_race_training_setup_soft{/translate}",
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
													 colors: ["rgba(255,78,0,1.0)", "rgba(248,210,57,1.0)"],
													 xaxis: {literal}{{/literal}ticks:15, axisLabel: "{translate}distance_km{/translate}", axisLabelUseCanvas: true, tickDecimals: 0, color: "rgba(255,255,255,0.8)" {literal}}{/literal},
													 yaxis: {literal}{{/literal}ticks:5, axisLabel: "{translate}attrition{/translate}", axisLabelUseCanvas: true, tickDecimals: 0, color: "rgba(255,255,255,0.8)" {literal}}{/literal},
												});
												var plot = $.plot($("#tire-chart-rain-{$tires[tire].id}"),
												   [ { data: hart_regen, 
													   label: "{translate}tr_race_training_setup_hard{/translate}", 
													   lines: { show: true, 
																fill: false,
																lineWidth: 2 
															  },
													   shadowSize: 0	
													 }, 
													 { data: soft_regen,
													   label: "{translate}tr_race_training_setup_soft{/translate}",
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
													 colors: ["rgba(0,175,224,1.0)", "rgba(13,136,0,1.0)"],
													 xaxis: {literal}{{/literal}ticks:15, axisLabel: "{translate}distance_km{/translate}", axisLabelUseCanvas: true, tickDecimals: 0, color: "rgba(255,255,255,0.8)" {literal}}{/literal},
													 yaxis: {literal}{{/literal}ticks:5, axisLabel: "{translate}attrition{/translate}", axisLabelUseCanvas: true, tickDecimals: 0, color: "rgba(255,255,255,0.8)" {literal}}{/literal},
												});
										    </script>
					                    </div>
					                </div>
					                <div class="box-content mobile_slider">
					                	<div class='row'>
						                	{if $tires[tire].picture != null}
											<div class="col-xs-6">
												<img src="content/img/tire/{$tires[tire].picture}" width="150px"/>
											</div>
											<div class="col-xs-6">
											{else}
											<div class="col-xs-12">
											{/if}
												<div class="col-xs-12" style="margin: 10px 0">
													<div class="col-xs-3"><img src="content/img/tires/{$tires[tire].picture_dry_hard}" width="75px"></div>
													<div class="col-xs-3"><img src="content/img/tires/{$tires[tire].picture_dry_soft}" width="75px"></div>
													<div class="col-xs-3"><img src="content/img/tires/{$tires[tire].picture_wet_hard}" width="75px"></div>
													<div class="col-xs-3"><img src="content/img/tires/{$tires[tire].picture_wet_soft}" width="75px"></div>
												</div>
												<div class="col-xs-12">
													<div class="col-xs-6">{translate}tr_finance_setting_value{/translate}:</div>
													<div class="col-xs-6" align="right">{$tires[tire].value} {translate}tr_global_currency_symbol{/translate}</div>
												</div>
												<div class="col-xs-12">
													<div class="col-xs-6">{translate}tr_finance_setting_bonus{/translate}:</div>
													<div class="col-xs-6" align="right">{$tires[tire].bonus} {translate}tr_global_currency_symbol{/translate}</div>
												</div>
												<div class="col-md-11 widget blue">
													<div>{translate}tr_race_training_setup_dry_tires{/translate}:</div>
													<div id="tire-chart-mobile-{$tires[tire].id}" style="height:150px"></div>
													<div>{translate}tr_race_training_setup_wet_tires{/translate}:</div>
													<div id="tire-chart-mobile-rain-{$tires[tire].id}" style="height:150px"></div>
												</div>
												<div class="col-xs-12" align="right">
													<form action="?site=finance_sponsor" method="post">
														<input type="hidden" id="tire_id" name="tire_id" value="{$tires[tire].id}"/>
														<input type="submit" class="btn btn-small btn-success" value="{translate}tr_button_sign{/translate}"/>
													</form>
												</div>
												<script>
													var hart = {$tires[tire].hard};
													var soft = {$tires[tire].soft};
													var hart_regen = {$tires[tire].hard_rain};
													var soft_regen = {$tires[tire].soft_rain};
													var plot = $.plot($("#tire-chart-mobile-{$tires[tire].id}"),
													   [ { data: hart, 
														   label: "{translate}tr_race_training_setup_hard{/translate}", 
														   lines: { show: true, 
																	fill: false,
																	lineWidth: 2 
																  },
														   shadowSize: 0	
														 }, 
														 { data: soft,
														   label: "{translate}tr_race_training_setup_soft{/translate}",
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
														 colors: ["rgba(255,78,0,1.0)", "rgba(248,210,57,1.0)"],
														 xaxis: {literal}{{/literal}ticks:15, axisLabel: "{translate}distance_km{/translate}", axisLabelUseCanvas: true, tickDecimals: 0, color: "rgba(255,255,255,0.8)" {literal}}{/literal},
														 yaxis: {literal}{{/literal}ticks:5, axisLabel: "{translate}attrition{/translate}", axisLabelUseCanvas: true, tickDecimals: 0, color: "rgba(255,255,255,0.8)" {literal}}{/literal},
													});
													var plot = $.plot($("#tire-chart-mobile-rain-{$tires[tire].id}"),
													   [ { data: hart_regen, 
														   label: "{translate}tr_race_training_setup_hard{/translate}", 
														   lines: { show: true, 
																	fill: false,
																	lineWidth: 2 
																  },
														   shadowSize: 0	
														 }, 
														 { data: soft_regen,
														   label: "{translate}tr_race_training_setup_soft{/translate}",
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
														 colors: ["rgba(0,175,224,1.0)", "rgba(13,136,0,1.0)"],
														 xaxis: {literal}{{/literal}ticks:15, axisLabel: "{translate}distance_km{/translate}", axisLabelUseCanvas: true, tickDecimals: 0, color: "rgba(255,255,255,0.8)" {literal}}{/literal},
														 yaxis: {literal}{{/literal}ticks:5, axisLabel: "{translate}attrition{/translate}", axisLabelUseCanvas: true, tickDecimals: 0, color: "rgba(255,255,255,0.8)" {literal}}{/literal},
													});
												</script>
											</div>
										</div>
					                </div>
					            </div>
					        {/section}
						</div>
    				</div>
				</div>
				{else}
				<div class="box col-md-6 col-xs-12">
		            <div class="box-header">
		                <h2><i class="halflings-icon align-justify"></i><span class="break"></span>{translate}tr_finance_tire_sponsor{/translate}: {$tire.name}</h2>
		            </div>
		            <div class="box-content desktop_slider">
		                <div class='row'>
			                {if $tire.picture != null}
		                	<div class="col-md-12">
		                        <img src="content/img/tire/{$tire.picture}" width="150px"/>
		                    </div>
		                    {/if}
		                    
		                    <div class='row'>
		                        <div class="col-md-6">{translate}tr_finance_setting_value{/translate}:</div>
		                        <div class="col-md-6" align="right">{$tire.value} {translate}tr_global_currency_symbol{/translate}</div>
		                    </div>
		                    <div class='row'>
		                        <div class="col-md-6">{translate}tr_finance_setting_bonus{/translate}:</div>
		                        <div class="col-md-6" align="right">{$tire.bonus} {translate}tr_global_currency_symbol{/translate}</div>
		                    </div>
		                    <div class='row' style="margin: 10px 0">
								<div class="col-md-3"><img src="content/img/tires/{$tire.picture_dry_hard}" width="75px"></div>
								<div class="col-md-3"><img src="content/img/tires/{$tire.picture_dry_soft}" width="75px"></div>
								<div class="col-md-3"><img src="content/img/tires/{$tire.picture_wet_hard}" width="75px"></div>
								<div class="col-md-3"><img src="content/img/tires/{$tire.picture_wet_soft}" width="75px"></div>
							</div>
		                    <div class="col-md-11 widget blue">
		                    	<div>{translate}tr_race_training_setup_dry_tires{/translate}:</div>
						        <div id="tire-chart-{$tire.id}"  style="height:150px" ></div>
						        <div>{translate}tr_race_training_setup_wet_tires{/translate}:</div>
						        <div id="tire-chart-rain-{$tire.id}"  style="height:150px" ></div>
						    </div>
						    <script>
						    	var hart = {$tire.hard};
						    	var soft = {$tire.soft};
						    	var hart_regen = {$tire.hard_rain};
						    	var soft_regen = {$tire.soft_rain};
							    var plot = $.plot($("#tire-chart-{$tire.id}"),
								   [ { data: hart, 
									   label: "{translate}tr_race_training_setup_hard{/translate}", 
									   lines: { show: true, 
												fill: false,
												lineWidth: 2 
											  },
									   shadowSize: 0	
									 }, 
									 { data: soft,
									   label: "{translate}tr_race_training_setup_soft{/translate}",
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
									 colors: ["rgba(255,78,0,1.0)", "rgba(248,210,57,1.0)"],
									 xaxis: {literal}{{/literal}ticks:15, axisLabel: "{translate}distance_km{/translate}", axisLabelUseCanvas: true, tickDecimals: 0, color: "rgba(255,255,255,0.8)" {literal}}{/literal},
									 yaxis: {literal}{{/literal}ticks:5, axisLabel: "{translate}attrition{/translate}", axisLabelUseCanvas: true, tickDecimals: 0, color: "rgba(255,255,255,0.8)" {literal}}{/literal},
								});
								var plot = $.plot($("#tire-chart-rain-{$tire.id}"),
								   [ { data: hart_regen, 
									   label: "{translate}tr_race_training_setup_hard{/translate}", 
									   lines: { show: true, 
												fill: false,
												lineWidth: 2 
											  },
									   shadowSize: 0	
									 }, 
									 { data: soft_regen,
									   label: "{translate}tr_race_training_setup_soft{/translate}",
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
									 colors: ["rgba(0,175,224,1.0)", "rgba(13,136,0,1.0)"],
									 xaxis: {literal}{{/literal}ticks:15, axisLabel: "{translate}distance_km{/translate}", axisLabelUseCanvas: true, tickDecimals: 0, color: "rgba(255,255,255,0.8)" {literal}}{/literal},
									 yaxis: {literal}{{/literal}ticks:5, axisLabel: "{translate}attrition{/translate}", axisLabelUseCanvas: true, tickDecimals: 0, color: "rgba(255,255,255,0.8)" {literal}}{/literal},
								});
						    </script>
		                </div>
		            </div>
		            <div class="box-content mobile_slider">
		                <div class='row'>
			                {if $tire.picture != null}
		                	<div class="col-xs-6">
		                        <img src="content/img/tire/{$tire.picture}" width="150px"/>
		                    </div>
		                    <div class="col-xs-6">
		                    {else}
		                    <div class="col-xs-12">
		                    {/if}
		                    	<div class="col-xs-12" style="margin: 10px 0">
									<div class="col-xs-3"><img src="content/img/tires/{$tire.picture_dry_hard}" width="75px"></div>
									<div class="col-xs-3"><img src="content/img/tires/{$tire.picture_dry_soft}" width="75px"></div>
									<div class="col-xs-3"><img src="content/img/tires/{$tire.picture_wet_hard}" width="75px"></div>
									<div class="col-xs-3"><img src="content/img/tires/{$tire.picture_wet_soft}" width="75px"></div>
								</div>
								<div class="col-xs-12">
									<div class="col-xs-6">{translate}tr_finance_setting_value{/translate}:</div>
									<div class="col-xs-6" align="right">{$tire.value} {translate}tr_global_currency_symbol{/translate}</div>
								</div>
								<div class="col-xs-12">
									<div class="col-xs-6">{translate}tr_finance_setting_bonus{/translate}:</div>
									<div class="col-xs-6" align="right">{$tire.bonus} {translate}tr_global_currency_symbol{/translate}</div>
								</div>
							</div>
							<div class="col-xs-12 widget blue">
								<div>{translate}tr_race_training_setup_dry_tires{/translate}:</div>
						        <div id="tire-chart-mobile-{$tire.id}"  style="height:150px" ></div>
						        <div>{translate}tr_race_training_setup_wet_tires{/translate}:</div>
						        <div id="tire-chart-mobile-rain-{$tire.id}"  style="height:150px" ></div>
							</div>
							<script>
						    	var hart = {$tire.hard};
						    	var soft = {$tire.soft};
						    	var hart_regen = {$tire.hard_rain};
						    	var soft_regen = {$tire.soft_rain};
							    var plot = $.plot($("#tire-chart-mobile-{$tire.id}"),
								   [ { data: hart, 
									   label: "{translate}tr_race_training_setup_hard{/translate}", 
									   lines: { show: true, 
												fill: false,
												lineWidth: 2 
											  },
									   shadowSize: 0	
									 }, 
									 { data: soft,
									   label: "{translate}tr_race_training_setup_soft{/translate}",
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
									 colors: ["rgba(255,78,0,1.0)", "rgba(248,210,57,1.0)"],
									 xaxis: {literal}{{/literal}ticks:15, axisLabel: "{translate}distance_km{/translate}", axisLabelUseCanvas: true, tickDecimals: 0, color: "rgba(255,255,255,0.8)" {literal}}{/literal},
									 yaxis: {literal}{{/literal}ticks:5, axisLabel: "{translate}attrition{/translate}", axisLabelUseCanvas: true, tickDecimals: 0, color: "rgba(255,255,255,0.8)" {literal}}{/literal},
								});
								var plot = $.plot($("#tire-chart-mobile-rain-{$tire.id}"),
								   [ { data: hart_regen, 
									   label: "{translate}tr_race_training_setup_hard{/translate}", 
									   lines: { show: true, 
												fill: false,
												lineWidth: 2 
											  },
									   shadowSize: 0	
									 }, 
									 { data: soft_regen,
									   label: "{translate}tr_race_training_setup_soft{/translate}",
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
									 colors: ["rgba(0,175,224,1.0)", "rgba(13,136,0,1.0)"],
									 xaxis: {literal}{{/literal}ticks:15, axisLabel: "{translate}distance_km{/translate}", axisLabelUseCanvas: true, tickDecimals: 0, color: "rgba(255,255,255,0.8)" {literal}}{/literal},
									 yaxis: {literal}{{/literal}ticks:5, axisLabel: "{translate}attrition{/translate}", axisLabelUseCanvas: true, tickDecimals: 0, color: "rgba(255,255,255,0.8)" {literal}}{/literal},
								});
						    </script>
						</div>
					</div>
		        </div>
				{/if}	
    		</div>
    	</div>
    </div>
</div>