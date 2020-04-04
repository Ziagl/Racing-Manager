<div class="page-content-wrapper">
    <div class="page-content">
    	<div class="row">
    		<div class="col-md-12">
    			<div class="portlet box green-meadow">
    				<div class="portlet-title">
    					<div class="caption">{translate}tr_mechanic_market_title{/translate}</div>
    				</div>
    				<div class="portlet-body desktop_slider">
						<table class="table table-striped" id="mechanic_market_table">
	                        <thead>
	                        <tr>
	                            <th>{translate}tr_statistic_driver_name{/translate}</th>
	                            <th>{translate}tr_mechanic_setting_pitstop{/translate}</th>
	                            <!--<th>{translate}tr_mechanic_setting_development{/translate}</th>-->
	                            <th>{translate}tr_mechanic_setting_tires{/translate}</th>
	                            <th>{translate}tr_mechanic_setting_setup{/translate}</th>
	                            <th>{translate}tr_mechanic_setting_repair{/translate}</th>
	                            <!--<th>{translate}tr_driver_setting_morale{/translate}</th>-->
	                            <th>{translate}tr_driver_setting_wage{/translate}</th>
	                            <th>{translate}tr_driver_setting_bonus{/translate}</th>
	                            <th>{translate}tr_driver_setting_action{/translate}</th>
	                        </tr>
	                        </thead>
	                        <tbody>
	                        {section name=mechanic loop=$mechanics}
	                            <tr>
	                                <td>{$mechanics[mechanic].firstname} {$mechanics[mechanic].lastname}</td>
	                                <td class="{$mechanics[mechanic].pit_stop_css}">{$mechanics[mechanic].pit_stop}</td>
	                                <!--<td class="{$mechanics[mechanic].development_css}">{$mechanics[mechanic].development}</td>-->
	                                <td class="{$mechanics[mechanic].tires_css}">{$mechanics[mechanic].tires}</td>
	                                <td class="{$mechanics[mechanic].setup_css}">{$mechanics[mechanic].setup}</td>
	                                <td class="{$mechanics[mechanic].repair_css}">{$mechanics[mechanic].repair}</td>
	                                <!--<td class="{$mechanics[mechanic].morale_css}">{$mechanics[mechanic].morale}</td>-->
	                                <td align="right">{$mechanics[mechanic].wage} {translate}tr_global_currency_symbol{/translate}</td>
	                                <td align="right">{$mechanics[mechanic].bonus} {translate}tr_global_currency_symbol{/translate}</td>
	                                <td>
	                                    {if $count_mechanics < 10}
	                                        <form action="?site=mechanic_market" method="post">
	                                            <input type="hidden" id="mechanic_id" name="mechanic_id" value="{$mechanics[mechanic].id}"/>
	                                            <input type="submit" class="btn btn-small btn-success" value="{translate}tr_button_buy{/translate}"/>
	                                        </form>
	                                    {/if}
	                                </td>
	                            </tr>
	                        {/section}
	                        </tbody>
	                    </table>
    				</div>
    				<div class="portlet-body mobile_slider">
						<table class="table" id="mechanic_market_table">
	                        <thead>
	                        <tr>
	                            <th>{translate}tr_statistic_driver_name{/translate}</th>
	                            <th>{translate}tr_mechanic_setting_pitstop_short{/translate}</th>
	                            <!--<th>{translate}tr_mechanic_setting_development_short{/translate}</th>-->
	                            <th>{translate}tr_mechanic_setting_tires_short{/translate}</th>
	                            <th>{translate}tr_mechanic_setting_setup_short{/translate}</th>
	                            <th>{translate}tr_mechanic_setting_repair_short{/translate}</th>
	                            <!--<th>{translate}tr_driver_setting_morale_short{/translate}</th>-->
	                        </tr>
	                        </thead>
	                        <tbody name="{$i = 0}">
	                        {section name=mechanic loop=$mechanics}
	                            <tr{if $i % 2 == 0} class="table_striped_two_lines"{/if}>
	                                <td rowspan="2">{$mechanics[mechanic].firstname} {$mechanics[mechanic].lastname}</td>
	                                <td class="{$mechanics[mechanic].pit_stop_css}">{$mechanics[mechanic].pit_stop}</td>
	                                <!--<td class="{$mechanics[mechanic].development_css}">{$mechanics[mechanic].development}</td>-->
	                                <td class="{$mechanics[mechanic].tires_css}">{$mechanics[mechanic].tires}</td>
	                                <td class="{$mechanics[mechanic].setup_css}">{$mechanics[mechanic].setup}</td>
	                                <td class="{$mechanics[mechanic].repair_css}">{$mechanics[mechanic].repair}</td>
	                                <!--<td class="{$mechanics[mechanic].morale_css}">{$mechanics[mechanic].morale}</td>-->
	                            </tr>
	                            <tr{if $i % 2 == 0} class="table_striped_two_lines"{/if} name="{$i++}">
	                            	<td colspan="5" width="100%">
	                            		<table width="100%" style="line-height: 1.42857;">
	                            			<tr>
	                            				<td>
	                            					{translate}tr_driver_setting_wage{/translate}: {$mechanics[mechanic].wage} {translate}tr_global_currency_symbol{/translate}
	                            				</td>
	                            				<td rowspan="2" align="right">
													{if $count_mechanics < 10}
														<form action="?site=mechanic_market" method="post">
															<input type="hidden" id="mechanic_id" name="mechanic_id" value="{$mechanics[mechanic].id}"/>
															<input type="submit" class="btn btn-small btn-success" value="{translate}tr_button_buy{/translate}"/>
														</form>
													{/if}
	                                    		</td>
	                            			</tr>
	                            			<tr>
	                            				<td>
	                            					{translate}tr_driver_setting_bonus{/translate}: {$mechanics[mechanic].bonus} {translate}tr_global_currency_symbol{/translate}
	                            				</td>
	                                    
	                                    	</tr>
	                                    </table>
	                                </td>
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
    $("#mechanic_market_table").tablesorter(); 
});
</script>