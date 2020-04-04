<div class="page-content-wrapper">
    <div class="page-content">
    	<div class="row">
    		<div class="col-md-12">
    			<div class="portlet box green">
    				<div class="portlet-title">
    					<div class="caption">{translate}tr_statistic_teaminfo_title{/translate}</div>
    				</div>
    				<div class="portlet-body">
    					<div class="row">
			            	<div class="col-md-3 col-xs-12">
			            		{if strlen($teaminfo.picture) > 1 }
									<img class="svg" style="fill: #{$teaminfo.color1}" src="content/img/team/{$teaminfo.picture}" width="150px"/>
								{else}
									<img src="content/img/car/team/{$teaminfo.id}.png" width="150px" style="display: block;margin: 0 auto;">
								{/if}
			            	</div>
			            	<div class="col-md-5 col-xs-12">
			                	<div class="row">
			                    	<div class="col-md-3 col-xs-4">{translate}tr_driver_setting_name{/translate}:</div>
			                    	<div class="col-md-9 col-xs-8"><span style="color:#{$teaminfo.color1};">{$teaminfo.name}</span></div>
			                    </div>
			                    <div class="row">
			                    	<div class="col-md-3 col-xs-4">{translate}team_headquarter{/translate}:</div>
			                    	<div class="col-md-9 col-xs-8">{$teaminfo.location}</div>
			                    </div>
			                    <div class="row">
			                        <div class="col-md-3 col-xs-4">{translate}tr_driver_setting_country{/translate}:</div>
			                        <div class="col-md-9 col-xs-8">{$teaminfo.country_name} <img src="content/img/flags/{$teaminfo.country_picture}.gif" width="50px"/></div>
			                    </div>
			                    <div class="row">
			                    	<div class="col-md-3 col-xs-4">{translate}tr_statistic_driver_manager_name{/translate}:</div>
			                    	<div class="col-md-9 col-xs-8">{$teaminfo.manager}</div>
			                    </div>
			                    <div class="row">
			                    	<div class="col-md-3 col-xs-4">{translate}tr_car_setting_driver{/translate}:</div>
			                    	<div class="col-md-9 col-xs-8">{$teaminfo.driver}</div>
			                    </div>
			                </div>
			                <div class="col-md-4 col-xs-12">
			                    <div class="row">
			                    	<div class="col-md-3 col-xs-4">{translate}tr_finance_setting_sponsor{/translate}:</div>
			                    	<div class="col-md-9 col-xs-8">{$teaminfo.sponsor}</div>
			                    </div>
			                    <div class="row">
			                    	<div class="col-md-3 col-xs-4">{translate}tr_finance_tire_sponsor{/translate}:</div>
			                    	<div class="col-md-9 col-xs-8">{$teaminfo.tires}</div>
			                    </div>
			                    {if $ownteam}
			                    <div class="row">
			                    	<div class="col-md-3 col-xs-4">{translate}tr_finance_setting_value{/translate}:</div>
			                    	<div class="col-md-9 col-xs-8">{$teaminfo.value} {translate}tr_global_currency_symbol{/translate}</div>
			                    </div>
			                    {/if}
			                    <div class="row">
			                    	<div class="col-md-3 col-xs-4">{translate}tr_statistic_driver_points{/translate}:</div>
			                    	<div class="col-md-9 col-xs-8">{$teaminfo.points}</div>
			                    </div>
			                    <div class="row">
			                    	<div class="col-md-3 col-xs-4">{translate}aim_of_the_season{/translate}:</div>
			                    	<div class="col-md-9 col-xs-8">
			                    		{if $teaminfo.goal == 0}{translate}world_champion{/translate}{/if}
										{if $teaminfo.goal == 1}{translate}win_some_races{/translate}{/if}
										{if $teaminfo.goal == 2}{translate}solid_midfield{/translate}{/if}
										{if $teaminfo.goal == 3}{translate}avoid_relegation{/translate}{/if}
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
					    			<div class="col-md-4 col-xs-4">{$teaminfo.f1_champion}</div>
					    		</div>
					    		<div class="row">
					    			<div class="col-md-8 col-xs-8">{translate}tr_race_grandprix_title{/translate}:</div>
					    			<div class="col-md-4 col-xs-4">{$teaminfo.f1_gps}</div>
					    		</div>
					    		<div class="row">
					    			<div class="col-md-8 col-xs-8">{translate}victories{/translate}:</div>
					    			<div class="col-md-4 col-xs-4">{$teaminfo.f1_wins}</div>
					    		</div>
					    		<div class="row">
					    			<div class="col-md-8 col-xs-8">{translate}podium{/translate}:</div>
					    			<div class="col-md-4 col-xs-4">{$teaminfo.f1_podium}</div>
					    		</div>
					    		<div class="row">
					    			<div class="col-md-8 col-xs-8">{translate}failures{/translate}:</div>
					    			<div class="col-md-4 col-xs-4">{$teaminfo.f1_out}</div>
					    		</div>
					    		<div class="row">
					    			<div class="col-md-8 col-xs-8">{translate}poles{/translate}:</div>
					    			<div class="col-md-4 col-xs-4">{$teaminfo.f1_pole}</div>
					    		</div>
					    	</div>
			                <div class="col-md-4 col-xs-6">
					    		<div class="row">
					    			<div class="col-md-12 col-xs-12"><h2>{translate}tr_league_title{/translate} 2</h2></div>
					    		</div>
					    		<div class="row">
					    			<div class="col-md-8 col-xs-8">{translate}world_champion{/translate}:</div>
					    			<div class="col-md-4 col-xs-4">{$teaminfo.f2_champion}</div>
					    		</div>
					    		<div class="row">
					    			<div class="col-md-8 col-xs-8">{translate}tr_race_grandprix_title{/translate}:</div>
					    			<div class="col-md-4 col-xs-4">{$teaminfo.f2_gps}</div>
					    		</div>
					    		<div class="row">
					    			<div class="col-md-8 col-xs-8">{translate}victories{/translate}:</div>
					    			<div class="col-md-4 col-xs-4">{$teaminfo.f2_wins}</div>
					    		</div>
					    		<div class="row">
					    			<div class="col-md-8 col-xs-8">{translate}podium{/translate}:</div>
					    			<div class="col-md-4 col-xs-4">{$teaminfo.f2_podium}</div>
					    		</div>
					    		<div class="row">
					    			<div class="col-md-8 col-xs-8">{translate}failures{/translate}:</div>
					    			<div class="col-md-4 col-xs-4">{$teaminfo.f2_out}</div>
					    		</div>
					    		<div class="row">
					    			<div class="col-md-8 col-xs-8">{translate}poles{/translate}:</div>
					    			<div class="col-md-4 col-xs-4">{$teaminfo.f2_pole}</div>
					    		</div>
					    	</div>
					    	<div class="col-md-4 col-xs-6">
					    		<div class="row">
					    			<div class="col-md-12 col-xs-12"><h2>{translate}tr_league_title{/translate} 3</h2></div>
					    		</div>
					    		<div class="row">
					    			<div class="col-md-8 col-xs-8">{translate}world_champion{/translate}:</div>
					    			<div class="col-md-4 col-xs-4">{$teaminfo.f3_champion}</div>
					    		</div>
					    		<div class="row">
					    			<div class="col-md-8 col-xs-8">{translate}tr_race_grandprix_title{/translate}:</div>
					    			<div class="col-md-4 col-xs-4">{$teaminfo.f3_gps}</div>
					    		</div>
					    		<div class="row">
					    			<div class="col-md-8 col-xs-8">{translate}victories{/translate}:</div>
					    			<div class="col-md-4 col-xs-4">{$teaminfo.f3_wins}</div>
					    		</div>
					    		<div class="row">
					    			<div class="col-md-8 col-xs-8">{translate}podium{/translate}:</div>
					    			<div class="col-md-4 col-xs-4">{$teaminfo.f3_podium}</div>
					    		</div>
					    		<div class="row">
					    			<div class="col-md-8 col-xs-8">{translate}failures{/translate}:</div>
					    			<div class="col-md-4 col-xs-4">{$teaminfo.f3_out}</div>
					    		</div>
					    		<div class="row">
					    			<div class="col-md-8 col-xs-8">{translate}poles{/translate}:</div>
					    			<div class="col-md-4 col-xs-4">{$teaminfo.f3_pole}</div>
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
					    	{if $ownteam}
					    	<div class="col-md-4 col-xs-12">
					    		<div class="row">
					    			<div class="col-md-12 col-xs-12"><h2>{translate}tr_finance_setting_value{/translate}</h2></div>
					    		</div>
					    		<div class="row">
									<div class="col-md-11 widget blue">
										<div id="budget-chart"  style="height:300px" ></div>
									</div>
								</div>
							</div>
							{/if}
					    </div>
					    
						<script>
							var points = {$statistic_points};
							var plot = $.plot($("#point-chart"),
							   [ { data: points, 
								   label: "{translate}tr_statistic_driver_points{/translate}", 
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
								 xaxis: {literal}{{/literal}ticks:{$statistic_points_count}, axisLabel: "{translate}tr_finance_detail_date{/translate}", axisLabelUseCanvas: true, tickDecimals: 0, color: "rgba(255,255,255,0.8)", mode: "time", timeformat: "%d.%m."  {literal}}{/literal},
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
						{if $ownteam}
						<script>
							var budget = {$statistic_budget};
							var plot = $.plot($("#budget-chart"),
							   [ { data: budget, 
								   label: "{translate}tr_finance_setting_value{/translate}", 
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
								 xaxis: {literal}{{/literal}ticks:{$statistic_budget_count}, axisLabel: "{translate}tr_finance_detail_date{/translate}", axisLabelUseCanvas: true, tickDecimals: 0, color: "rgba(255,255,255,0.8)", mode: "time", timeformat: "%d.%m." {literal}}{/literal},
								 yaxis: {literal}{{/literal}ticks:18, axisLabel: "{translate}tr_finance_setting_value{/translate}", axisLabelUseCanvas: true, tickDecimals: 0, color: "rgba(255,255,255,0.8)"{literal}}{/literal},
							});
						</script>
						{/if}
    				</div>
    			</div>
    		</div>
    	</div>
    </div>
</div>
