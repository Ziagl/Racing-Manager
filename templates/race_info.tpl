<!-- BEGIN CONTENT -->
<div class="page-content-wrapper">
    <div class="page-content">
    	<div class="row">
    		<div class="col-md-12">
    			<div class="portlet box red">
    				<div class="portlet-title">
    					<div class="caption">{translate}tr_race_info_title{/translate}</div>
    				</div>
    				<div class="portlet-body">
    					<div class="row">
	    					<div class="col-md-3">
				                {translate}distance{/translate}: {$track['distance']} {translate}meter{/translate}<br/>
				                {translate}tr_race_training_setup_rounds{/translate}: {$track['rounds']}<br/>
				                {translate}curves_straights{/translate}: {$track['curves']}<br/>
				                {translate}weather{/translate}: {translate}{$weather}{/translate}<br/><img src="content/img/weather/{$weather}.png" width="50px"/><br/>
				                {translate}tr_driver_setting_country{/translate}: {$country.name} <br/><img src="content/img/flags/{$country.picture}.gif" width="50px"/><br/>
							</div>
	    					
							<div class="col-md-9" onTablet="col-md-6" onDesktop="col-md-9">
								<img src="content/img/tracks/{$track['picture']}"/><br/>
							</div>
						</div>
    				</p>
    				</div>
    			</div>
    		</div>
    	</div>
    </div>
</div>