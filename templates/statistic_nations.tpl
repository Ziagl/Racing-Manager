<div class="page-content-wrapper">
    <div class="page-content">
    	<div class="row">
    		<div class="col-md-12">
    			<div class="portlet box blue-hoki">
    				<div class="portlet-title">
    					<div class="caption">{translate}tr_statistic_nations{/translate}</div>
    				</div>
    				<div class="portlet-body">
    					<table class="table table-striped" id="statistic_nations_table">
							<thead>
							<tr>
								<th></th>
								<th>{translate}tr_statistic_driver_picture{/translate}</th>
								<th class="mobile_invisible_low">{translate}tr_driver_setting_country{/translate}</th>
								<th style="text-align:right">{translate}tr_statistic_driver_points{/translate}</th>
								<th style="text-align:right">{translate}victories{/translate}</th>
								<th style="text-align:right">{translate}podium{/translate}</th>
								<th style="text-align:right">{translate}poles{/translate}</th>
								<th style="text-align:right">{translate}failures{/translate}</th>
							</tr>
							</thead>
							<tbody>
							{$i=1}
							{section name=country loop=$countries}
								<tr>
									<td>{$i++}</td>
									<td><img src="content/img/flags/{$countries[country].picture}.gif" width="50px"/></td>
									<td class="mobile_invisible_low">{$countries[country].name}</td>
									<td align="right">{$countries[country].points}</td>
									<td align="right">{$countries[country].wins}</td>
									<td align="right">{$countries[country].podium}</td>
									<td align="right">{$countries[country].pole}</td>
									<td align="right">{$countries[country].out}</td>
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
<script>
$(document).ready(function(){
    $("#statistic_nations_table").tablesorter(); 
});
</script>
