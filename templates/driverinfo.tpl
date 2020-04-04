<div class="page-content-wrapper">
    <div class="page-content">
    	<div class="row">
    		<div class="col-md-12">
    			<div class="portlet box green">
    				<div class="portlet-title">
    					<div class="caption">{translate}tr_statistic_driverinfo_title{/translate}</div>
    				</div>
    				<div class="portlet-body">
    					<div class="row">
			            	<div class="col-md-3 col-xs-6"><img src="content/img/driver/{$driver.picture}" width="150px"/></div>
			            	<div class="col-md-9 col-xs-6">
			                	<div class="row">
			                    	<div class="col-md-2 col-xs-4">{translate}tr_driver_setting_name{/translate}:</div>
			                    	<div class="col-md-10 col-xs-8">{$driver.firstname} {$driver.lastname} ({$driver.shortname})</div>
			                    </div>
			                    <div class="row">
			                    	<div class="col-md-2 col-xs-4">{translate}tr_driver_setting_age{/translate}:</div>
			                    	<div class="col-md-10 col-xs-8">{$driver.age} ({$driver.birthday_formated})</div>
			                    </div>
			                    <div class="row">
			                        <div class="col-md-2 col-xs-4">{translate}tr_driver_setting_country{/translate}:</div>
			                        <div class="col-md-10 col-xs-8">{$driver.country_name} <img src="content/img/flags/{$driver.country_picture}.gif" width="50px"/></div>
			                    </div>
			                    <div class="row">
									{if $teaminfo != null}
									<div class="col-md-2 col-xs-4">{translate}tr_statistic_driver_team_name{/translate}:</div>
									<div class="col-md-10 col-xs-8">
										<a style="color:#{$teaminfo.color1}" href="?site=teaminfo&id={$teaminfo.id}">{$teaminfo.name}</a>
										<br>
										{if strlen($teaminfo.picture) > 1}
											<img class="svg" style="fill: #{$teaminfo.color1};float:left;margin-right:5px" src="content/img/team/{$teaminfo.picture}" width="50px"/> 
										{else}
											<img src="content/img/car/team/{$teaminfo.id}.png" width="100px">
										{/if}
									</div>
									{else}
									<div class="col-md-2 col-xs-4">{translate}tr_statistic_driver_team_name{/translate}:</div>
									<div class="col-md-10 col-xs-8"><a href="?site=driver_market">{translate}tr_statistic_driver_no_team{/translate}</a></div>
									{/if}
								</div>
			               </div>
			               <div class="row">
							   <div class="col-md-4 col-xs-6">
									<div class="row">
										<div class="col-md-2 col-xs-4">{translate}tr_driver_setting_wage{/translate}:</div>
										<div class="col-md-10 col-xs-8" align="right">{$driver.wage} {translate}tr_global_currency_symbol{/translate}</div>
									</div>
									<div class="row">
										<div class="col-md-2 col-xs-4">{translate}tr_driver_setting_bonus{/translate}:</div>
										<div class="col-md-10 col-xs-8" align="right">{$driver.bonus} {translate}tr_global_currency_symbol{/translate}</div>
									</div>
									<div class="row">
										<div class="col-md-2 col-xs-4">{translate}tr_statistic_driver_points{/translate}:</div>
										<div class="col-md-10 col-xs-8" align="right">{$driver.points}</div>
									</div>
								</div>
							</div>
					    </div>
    					
					    <div class="row">
					    	<div class="col-md-4 col-xs-6">
					    		<div class="row">
					    			<div class="col-md-12 col-xs-12"><h2>{translate}tr_league_title{/translate} 1</h2></div>
					    		</div>
					    		<div class="row">
					    			<div class="col-md-8 col-xs-8">{translate}world_champion{/translate}:</div>
					    			<div class="col-md-4 col-xs-4">{$driver.f1_champion}</div>
					    		</div>
					    		<div class="row">
					    			<div class="col-md-8 col-xs-8">{translate}tr_race_grandprix_title{/translate}:</div>
					    			<div class="col-md-4 col-xs-4">{$driver.f1_gps}</div>
					    		</div>
					    		<div class="row">
					    			<div class="col-md-8 col-xs-8">{translate}victories{/translate}:</div>
					    			<div class="col-md-4 col-xs-4">{$driver.f1_wins}</div>
					    		</div>
					    		<div class="row">
					    			<div class="col-md-8 col-xs-8">{translate}podium{/translate}:</div>
					    			<div class="col-md-4 col-xs-4">{$driver.f1_podium}</div>
					    		</div>
					    		<div class="row">
					    			<div class="col-md-8 col-xs-8">{translate}failures{/translate}:</div>
					    			<div class="col-md-4 col-xs-4">{$driver.f1_out}</div>
					    		</div>
					    		<div class="row">
					    			<div class="col-md-8 col-xs-8">{translate}poles{/translate}:</div>
					    			<div class="col-md-4 col-xs-4">{$driver.f1_pole}</div>
					    		</div>
					    	</div>
					    	<div class="col-md-4 col-xs-6">
					    		<div class="row">
					    			<div class="col-md-12 col-xs-12"><h2>{translate}tr_league_title{/translate} 2</h2></div>
					    		</div>
					    		<div class="row">
					    			<div class="col-md-8 col-xs-8">{translate}world_champion{/translate}:</div>
					    			<div class="col-md-4 col-xs-4">{$driver.f2_champion}</div>
					    		</div>
					    		<div class="row">
					    			<div class="col-md-8 col-xs-8">{translate}tr_race_grandprix_title{/translate}:</div>
					    			<div class="col-md-4 col-xs-4">{$driver.f2_gps}</div>
					    		</div>
					    		<div class="row">
					    			<div class="col-md-8 col-xs-8">{translate}victories{/translate}:</div>
					    			<div class="col-md-4 col-xs-4">{$driver.f2_wins}</div>
					    		</div>
					    		<div class="row">
					    			<div class="col-md-8 col-xs-8">{translate}podium{/translate}:</div>
					    			<div class="col-md-4 col-xs-4">{$driver.f2_podium}</div>
					    		</div>
					    		<div class="row">
					    			<div class="col-md-8 col-xs-8">{translate}failures{/translate}:</div>
					    			<div class="col-md-4 col-xs-4">{$driver.f2_out}</div>
					    		</div>
					    		<div class="row">
					    			<div class="col-md-8 col-xs-8">{translate}poles{/translate}:</div>
					    			<div class="col-md-4 col-xs-4">{$driver.f2_pole}</div>
					    		</div>
					    	</div>
					    	<div class="col-md-4 col-xs-6">
					    		<div class="row">
					    			<div class="col-md-12 col-xs-12"><h2>{translate}tr_league_title{/translate} 3</h2></div>
					    		</div>
					    		<div class="row">
					    			<div class="col-md-8 col-xs-8">{translate}world_champion{/translate}:</div>
					    			<div class="col-md-4 col-xs-4">{$driver.f3_champion}</div>
					    		</div>
					    		<div class="row">
					    			<div class="col-md-8 col-xs-8">{translate}tr_race_grandprix_title{/translate}:</div>
					    			<div class="col-md-4 col-xs-4">{$driver.f3_gps}</div>
					    		</div>
					    		<div class="row">
					    			<div class="col-md-8 col-xs-8">{translate}victories{/translate}:</div>
					    			<div class="col-md-4 col-xs-4">{$driver.f3_wins}</div>
					    		</div>
					    		<div class="row">
					    			<div class="col-md-8 col-xs-8">{translate}podium{/translate}:</div>
					    			<div class="col-md-4 col-xs-4">{$driver.f3_podium}</div>
					    		</div>
					    		<div class="row">
					    			<div class="col-md-8 col-xs-8">{translate}failures{/translate}:</div>
					    			<div class="col-md-4 col-xs-4">{$driver.f3_out}</div>
					    		</div>
					    		<div class="row">
					    			<div class="col-md-8 col-xs-8">{translate}poles{/translate}:</div>
					    			<div class="col-md-4 col-xs-4">{$driver.f3_pole}</div>
					    		</div>
					    	</div>
					    </div>
					    <br><br>
    					<div class="row">
					    	<div class="col-md-4 col-xs-12">
					    		<div class="row">
					    			<div class="col-md-12 col-xs-12"><h2>{translate}tr_statistic_driver_points{/translate}</h2></div>
					    		</div>
					    		<div class="row">
					    			<div class="col-md-12 widget blue">
										<div id="point-chart"  style="height:300px" ></div>
									</div>
					    		</div>
					    	</div>
					    	
					    	<div class="col-md-4 col-xs-12">
					    		<div class="row">
					    			<div class="col-md-12 col-xs-12"><h2>{translate}ranking{/translate}</h2></div>
					    		</div>
					    		<div class="row">
					    			<div class="col-md-12 widget blue">
										<div id="ranking-chart"  style="height:300px" ></div>
									</div>
					    		</div>
					    	</div>
					    	
					    	<div class="col-md-4 col-xs-12">
					    		<div class="row">
					    			<div class="col-md-12 col-xs-12"><h2>{translate}drivervalues{/translate}</h2></div>
					    		</div>
					    		<div class="row">
									<div class="col-md-11 widget blue">
										<div id="driver-chart"  style="height:300px" ></div>
									</div>
								</div>
							</div>
					    </div>

						<script>
							var points = {$statistic_points};
							var plot = $.plot($("#point-chart"),
							   [ { data: points, 
								   label: "{translate}tr_statistic_driver_points{/translate}", 
								   lines: { show: true, 
											fill: true,
											lineWidth: 2 
										  },
								   shadowSize: 0	
								 },
							   ], {
								 grid: { hoverable: false, 
										 clickable: false, 
										 tickColor: "rgba(255,255,255,0.05)",
										 borderWidth: 0
									   },
								 legend: {
											show: false
										 },	
								 colors: ["rgba(255,0,0,0.8)", "rgba(0,255,0,0.8)", "rgba(255,255,0,0.8)", "rgba(255,255,0,0.8)"],
								 xaxis: {literal}{{/literal}ticks:{$statistic_points_count}, axisLabel: "{translate}tr_finance_detail_date{/translate}", axisLabelUseCanvas: true, tickDecimals: 0, color: "rgba(255,255,255,0.8)", mode: "time", timeformat: "%d.%m." {literal}}{/literal},
								 yaxis: {literal}{{/literal}ticks:5, axisLabel: "{translate}tr_statistic_driver_points{/translate}", axisLabelUseCanvas: true, tickDecimals: 0, color: "rgba(255,255,255,0.8)" {literal}}{/literal},
							});
						</script>

						<script>
							var ranking = {$statistic_ranking};
							var plot = $.plot($("#ranking-chart"),
							   [ { data: ranking, 
								   label: "{translate}ranking{/translate}", 
								   lines: { show: true, 
											fill: false,
											lineWidth: 2 
										  },
								   shadowSize: 0	
								 },
							   ], {
								 grid: { hoverable: false, 
										 clickable: false, 
										 tickColor: "rgba(255,255,255,0.05)",
										 borderWidth: 0
									   },
								 legend: {
											show: false
										 },	
								 colors: ["rgba(255,0,0,0.8)", "rgba(0,255,0,0.8)", "rgba(255,255,0,0.8)", "rgba(255,255,0,0.8)"],
								 xaxis: {literal}{{/literal}ticks:{$statistic_ranking_count}, axisLabel: "{translate}tr_finance_detail_date{/translate}", axisLabelUseCanvas: true, tickDecimals: 0, color: "rgba(255,255,255,0.8)", mode: "time", timeformat: "%d.%m." {literal}}{/literal},
								 yaxis: {literal}{{/literal}ticks:18, axisLabel: "{translate}ranking{/translate}", axisLabelUseCanvas: true, tickDecimals: 0, color: "rgba(255,255,255,0.8)", transform: function (v) {literal}{{/literal} return -v; {literal}}{/literal}, inverseTransform: function (v) {literal}{{/literal} return -v; {literal}}{/literal}, min: 1{literal}}{/literal},
							});
						</script>

						<script>
							var speed = {$statistic_speed};
							var persistence = {$statistic_persistence};
							var experience = {$statistic_experience};
							var stamina = {$statistic_stamina};
							var freshness = {$statistic_freshness};
							var morale = {$statistic_morale};
							var plot = $.plot($("#driver-chart"),
							   [ { data: speed, 
								   label: "{translate}tr_driver_setting_speed{/translate}", 
								   lines: { show: true, 
											fill: false,
											lineWidth: 2 
										  },
								   shadowSize: 0	
								 },
								 { data: persistence, 
								   label: "{translate}tr_driver_setting_persistence{/translate}", 
								   lines: { show: true, 
											fill: false,
											lineWidth: 2 
										  },
								   shadowSize: 0	
								 },
								 { data: experience, 
								   label: "{translate}tr_driver_setting_experience{/translate}", 
								   lines: { show: true, 
											fill: false,
											lineWidth: 2 
										  },
								   shadowSize: 0	
								 },
								 { data: stamina, 
								   label: "{translate}tr_driver_setting_stamina{/translate}", 
								   lines: { show: true, 
											fill: false,
											lineWidth: 2 
										  },
								   shadowSize: 0	
								 },
								 { data: freshness, 
								   label: "{translate}tr_driver_setting_freshness{/translate}", 
								   lines: { show: true, 
											fill: false,
											lineWidth: 2 
										  },
								   shadowSize: 0	
								 },
								 { data: morale, 
								   label: "{translate}tr_driver_setting_morale{/translate}", 
								   lines: { show: true, 
											fill: false,
											lineWidth: 2 
										  },
								   shadowSize: 0	
								 },
							   ],
							   {
								 grid: { hoverable: false, 
										 clickable: false, 
										 tickColor: "rgba(255,255,255,0.05)",
										 borderWidth: 0
									   },
								 legend: {
											show: true,
											position: 'se'
										 },	
								 colors: ["rgba(255,0,0,0.8)", "rgba(0,255,0,0.8)", "rgba(0,0,255,0.8)", "rgba(255,255,0,0.8)", "rgba(0,255,255,0.8)", "rgba(0,128,128,0.8)"],
								 xaxis: {literal}{{/literal}ticks:{$statistic_ranking_count}, axisLabel: "{translate}tr_finance_detail_date{/translate}", axisLabelUseCanvas: true, tickDecimals: 0, color: "rgba(255,255,255,0.8)", mode: "time", timeformat: "%d.%m." {literal}}{/literal},
								 yaxis: {literal}{{/literal}ticks:18, axisLabel: "{translate}drivervalues{/translate}", axisLabelUseCanvas: true, tickDecimals: 0, color: "rgba(255,255,255,0.8)", max: 100, min: 0{literal}}{/literal},
							});
						</script>
    				</div>
    			</div>
    		</div>
    	</div>
    </div>
</div>
