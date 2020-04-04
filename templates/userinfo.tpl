<div class="page-content-wrapper">
    <div class="page-content">
    	<div class="row">
    		<div class="col-md-12">
    			<div class="portlet box green">
    				<div class="portlet-title">
    					<div class="caption">{translate}tr_statistic_userinfo_title{/translate}</div>
    				</div>
    				<div class="portlet-body">
    					<div class="row">
			            	<div class="col-md-2 col-xs-6"><img src="content/img/{$userinfo.picture}" width="150px"/></div>
			            	<div class="col-md-4 col-xs-6">
			                	<div class="row">
			                    	<div class="col-md-2 col-xs-4">{translate}tr_driver_setting_name{/translate}:</div>
			                    	<div class="col-md-10 col-xs-8">{$userinfo.name}</div>
			                    </div>
			                    <div class="row">
			                    	{if $teaminfo != null}
									<div class="col-md-2 col-xs-4">{translate}tr_statistic_driver_team_name{/translate}:</div>
									<div class="col-md-10 col-xs-8"><img src="content/img/team/{$teaminfo.picture}" width="50px"/> <a style="color:#{$teaminfo.color1}" href="?site=teaminfo&id={$teaminfo.id}">{$teaminfo.name}</a></div>
									{else}
									<div class="col-md-2 col-xs-4">{translate}tr_statistic_driver_team_name{/translate}:</div>
									<div class="col-md-10 col-xs-8"><a href="?site=driver_market">{translate}tr_statistic_driver_no_team{/translate}</a></div>
									{/if}
			                    </div>
			                    <div class="row">
			                    	<div class="col-md-2 col-xs-4">{translate}tr_statistic_driver_points{/translate}:</div>
			                    	<div class="col-md-10 col-xs-8">{$userinfo.points}</div>
			                    </div>
			                </div>
			            </div>
			            <br><br>
					    <div class="row">
					    	<div class="col-md-6 col-xs-12">
					    		<div class="row">
					    			<div class="col-md-12 col-xs-12"><h2>{translate}tr_statistic_driver_points{/translate}</h2></div>
					    		</div>
					    		<div class="row">
					    			<div class="col-md-12 widget blue">
										<div id="point-chart"  style="height:300px" ></div>
									</div>
					    		</div>
					    	</div>
					    	
					    	<div class="col-md-6 col-xs-12">
					    		<div class="row">
					    			<div class="col-md-12 col-xs-12"><h2>{translate}ranking{/translate}</h2></div>
					    		</div>
					    		<div class="row">
					    			<div class="col-md-12 widget blue">
										<div id="ranking-chart"  style="height:300px" ></div>
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
								 xaxis: {literal}{{/literal}ticks:{$statistic_points_count}, axisLabel: "{translate}tr_finance_detail_date{/translate}", axisLabelUseCanvas: true, tickDecimals: 0, color: "rgba(255,255,255,0.8)", mode: "time", timeformat: "%d.%m.%Y"  {literal}}{/literal},
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
								 xaxis: {literal}{{/literal}ticks:{$statistic_ranking_count}, axisLabel: "{translate}tr_finance_detail_date{/translate}", axisLabelUseCanvas: true, tickDecimals: 0, color: "rgba(255,255,255,0.8)", mode: "time", timeformat: "%d.%m.%Y" {literal}}{/literal},
								 yaxis: {literal}{{/literal}ticks:18, axisLabel: "{translate}ranking{/translate}", axisLabelUseCanvas: true, tickDecimals: 0, color: "rgba(255,255,255,0.8)", transform: function (v) {literal}{{/literal} return -v; {literal}}{/literal}, inverseTransform: function (v) {literal}{{/literal} return -v; {literal}}{/literal}, min: 1{literal}}{/literal},
							});
						</script>
    				</div>
    			</div>
    		</div>
    	</div>
    </div>
</div>
