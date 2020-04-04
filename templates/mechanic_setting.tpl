<div class="page-content-wrapper">
    <div class="page-content">
    	<div class="row">
    		<div class="col-md-12">
				<div class="portlet box green-meadow">
    				<div class="portlet-title">
    					<div class="caption">{translate}tr_mechanic_setting_overview{/translate}</div>
    				</div>
    				<div class="portlet-body">
						{translate}tr_mechanic_pitstop_time{/translate}: <span class="value_{if $pitstop < 30.0}green{else}red{/if}">{$pitstop}</span> {translate}tr_profile_seconds{/translate}<br>
		                {translate}tr_mechanic_setting_setup{/translate}: <span class="value_{if $setup > 0.0}green{else}red{/if}">{$setup}</span> % {translate}better{/translate}<br>
		                {translate}tr_finance_setting_tires{/translate}: <span class="value_{if $tires > 0.0}green{else}red{/if}">{$tires}</span> % {translate}better{/translate}<br>
		                {translate}tr_mechanic_repair{/translate}: <span class="value_{if $repair > 0.0}green{else}red{/if}">+{$repair}</span> % {translate}tr_mechanic_more_for_each_item{/translate}
    				</div>
				</div>
    		</div>
    	</div>
    	<div class="row">
    		<div class="col-md-12">
				<div class="portlet box green-meadow">
    				<div class="portlet-title">
    					<div class="caption">{translate}tr_mechanic_setting_title{/translate}</div>
    				</div>
    				<div class="portlet-body desktop_slider">
						<table class="table table-striped">
		                    <thead>
		                    <tr>
		                        <th>{translate}tr_statistic_driver_name{/translate}</th>
		                        <th>{translate}tr_mechanic_setting_pitstop{/translate}</th>
		                        <!--<th>{translate}tr_mechanic_setting_development{/translate}</th>-->
		                        <th>{translate}tr_mechanic_setting_setup{/translate}</th>
		                        <th>{translate}tr_mechanic_setting_tires{/translate}</th>
		                        <th>{translate}tr_mechanic_setting_repair{/translate}</th>
		                        <!--<th>{translate}tr_driver_setting_morale{/translate}</th>-->
		                        <th>{translate}tr_driver_setting_wage{/translate}</th>
		                        <th>{translate}tr_driver_setting_bonus{/translate}</th>
		                        <th>{translate}tr_driver_setting_job{/translate}</th>
		                        <th>{translate}tr_driver_setting_action{/translate}</th>
		                    </tr>
		                    </thead>
		                    <tbody>
		                    {section name=mechanic loop=$mechanics}
		                        <tr>
		                            <td>{$mechanics[mechanic].firstname} {$mechanics[mechanic].lastname}</td>
		                            <td><span class="{$mechanics[mechanic].pit_stop_current_css}">{$mechanics[mechanic].pit_stop_current}</span><!-- (<span class="{$mechanics[mechanic].pit_stop_css}">{$mechanics[mechanic].pit_stop}</span>)--></td>
		                            <!--<td><span class="{$mechanics[mechanic].development_current_css}">{$mechanics[mechanic].development_current}</span> (<span class="{$mechanics[mechanic].development_css}">{$mechanics[mechanic].development}</span>)</td>-->
		                            <td><span class="{$mechanics[mechanic].setup_current_css}">{$mechanics[mechanic].setup_current}</span><!-- (<span class="{$mechanics[mechanic].setup_css}">{$mechanics[mechanic].setup}</span>)--></td>
		                            <td><span class="{$mechanics[mechanic].tires_current_css}">{$mechanics[mechanic].tires_current}</span><!-- (<span class="{$mechanics[mechanic].tires_css}">{$mechanics[mechanic].tires}</span>)--></td>
		                            <td><span class="{$mechanics[mechanic].repair_current_css}">{$mechanics[mechanic].repair_current}</span><!-- (<span class="{$mechanics[mechanic].repair_css}">{$mechanics[mechanic].repair}</span>)--></td>
		                            <!--<td class="{$mechanics[mechanic].morale_css}">{$mechanics[mechanic].morale}</td>-->
		                            <td align="right">{$mechanics[mechanic].wage} {translate}tr_global_currency_symbol{/translate}</td>
		                            <td align="right">{$mechanics[mechanic].bonus} {translate}tr_global_currency_symbol{/translate}</td>
		                            <td>
		                                <form name="job{$mechanics[mechanic].id}" action="?site=mechanic_setting" method="post">
		                                    <input type="hidden" name="mechanic_id" value="{$mechanics[mechanic].id}">
		                                    <select name="job" style="width:110px" onchange="javascript:document.job{$mechanics[mechanic].id}.submit()" {if $not_editable}disabled{/if}>
		                                        {if $mechanics[mechanic].job == 0}
		                                            <option selected value="0">-</option>
		                                        {else}
		                                            <option value="0">-</option>
		                                        {/if}
		                                        {if $mechanics[mechanic].job == 1}
		                                            <option selected value="1">{translate}tr_mechanic_setting_pitstop{/translate}</option>
		                                        {else}
		                                            <option value="1">{translate}tr_mechanic_setting_pitstop{/translate}</option>
		                                        {/if}
		                                        {if $mechanics[mechanic].job == 2}
		                                            <option selected value="2">{translate}tr_mechanic_setting_setup{/translate}</option>
		                                        {else}
		                                            <option value="2">{translate}tr_mechanic_setting_setup{/translate}</option>
		                                        {/if}
		                                        {if $mechanics[mechanic].job == 3}
		                                            <option selected value="3">{translate}tr_mechanic_setting_tires{/translate}</option>
		                                        {else}
		                                            <option value="3">{translate}tr_mechanic_setting_tires{/translate}</option>
		                                        {/if}
		                                        {if $mechanics[mechanic].job == 4}
		                                            <option selected value="4">{translate}tr_mechanic_setting_repair{/translate}</option>
		                                        {else}
		                                            <option value="4">{translate}tr_mechanic_setting_repair{/translate}</option>
		                                        {/if}
		                                    </select>
		                                </form>
		                            </td>
		                            <td>
		                            	<form action="?site=mechanic_setting" method="post">
											<input type="hidden" name="sell_mechanic_id" id="sell_mechanic_id" value="{$mechanics[mechanic].id}">
											<input type="button" class="btn btn-small btn-danger confirm" data-text="{translate}tr_mechanic_setting_sell_mechanic_question{/translate}" data-confirm-button="{translate}yes{/translate}" data-cancel-button="{translate}no{/translate}" value="{translate}tr_driver_setting_sell_driver_pre{/translate}{$mechanics[mechanic].sell_price} {translate}tr_global_currency_symbol{/translate}{translate}tr_driver_setting_sell_driver_post{/translate}">
										</form>
		                            </td>
		                        </tr>
		                    {/section}
		                    </tbody>
		                </table>
		                <!--<p>{translate}tr_mechanic_information{/translate}</p>-->
    				</div>
    				<div class="portlet-body mobile_slider">
						<table class="table">
		                    <thead>
		                    <tr>
		                        <th>{translate}tr_statistic_driver_name{/translate}</th>
		                        <th>{translate}tr_mechanic_setting_pitstop_short{/translate}</th>
		                        <!--<th>{translate}tr_mechanic_setting_development_short{/translate}</th>-->
		                        <th>{translate}tr_mechanic_setting_setup_short{/translate}</th>
		                        <th>{translate}tr_mechanic_setting_tires_short{/translate}</th>
		                        <th>{translate}tr_mechanic_setting_repair_short{/translate}</th>
		                        <!--<th>{translate}tr_driver_setting_morale_short{/translate}</th>-->
		                    </tr>
		                    </thead>         
		                    <tbody name="{$i = 0}">
		                    {section name=mechanic loop=$mechanics}
		                        <tr{if $i % 2 == 0} class="table_striped_two_lines"{/if}>
		                            <td rowspan="2">{$mechanics[mechanic].firstname} {$mechanics[mechanic].lastname}</td>
		                            <td><span class="{$mechanics[mechanic].pit_stop_current_css}">{$mechanics[mechanic].pit_stop_current}</span><!-- (<span class="{$mechanics[mechanic].pit_stop_css}">{$mechanics[mechanic].pit_stop}</span>)--></td>
		                            <!--<td><span class="{$mechanics[mechanic].development_current_css}">{$mechanics[mechanic].development_current}</span> (<span class="{$mechanics[mechanic].development_css}">{$mechanics[mechanic].development}</span>)</td>-->
		                            <td><span class="{$mechanics[mechanic].setup_current_css}">{$mechanics[mechanic].setup_current}</span><!-- (<span class="{$mechanics[mechanic].setup_css}">{$mechanics[mechanic].setup}</span>)--></td>
		                            <td><span class="{$mechanics[mechanic].tires_current_css}">{$mechanics[mechanic].tires_current}</span><!-- (<span class="{$mechanics[mechanic].tires_css}">{$mechanics[mechanic].tires}</span>)--></td>
		                            <td><span class="{$mechanics[mechanic].repair_current_css}">{$mechanics[mechanic].repair_current}</span><!-- (<span class="{$mechanics[mechanic].repair_css}">{$mechanics[mechanic].repair}</span>)--></td>
		                            <!--<td class="{$mechanics[mechanic].morale_css}">{$mechanics[mechanic].morale}</td>-->
		                        </tr>
		                        <tr{if $i % 2 == 0} class="table_striped_two_lines"{/if} name="{$i++}">
		                        	<td colspan="5" width="100%">
		                        		<table width="100%" style="line-height: 1.42857;">
	                            			<tr>
	                            				<td>
	                            					{translate}tr_driver_setting_wage{/translate}: {$mechanics[mechanic].wage} {translate}tr_global_currency_symbol{/translate}
	                            				</td>
	                            				<td rowspan="3" align="right">
													<form action="?site=mechanic_setting" method="post">
														<input type="hidden" name="sell_mechanic_id" id="sell_mechanic_id" value="{$mechanics[mechanic].id}">
														<input type="button" class="btn btn-small btn-danger confirm" data-text="{translate}tr_mechanic_setting_sell_mechanic_question{/translate}" data-confirm-button="{translate}yes{/translate}" data-cancel-button="{translate}no{/translate}" value="{translate}tr_driver_setting_sell_driver_pre{/translate}{$mechanics[mechanic].sell_price} {translate}tr_global_currency_symbol{/translate}{translate}tr_driver_setting_sell_driver_post{/translate}">
													</form>
	                                    		</td>
	                            			</tr>
	                            			<tr>
	                            				<td>
	                            					{translate}tr_driver_setting_bonus{/translate}: {$mechanics[mechanic].bonus} {translate}tr_global_currency_symbol{/translate}
	                            				</td>
	                                    	</tr>
	                                    	<tr>
	                            				<td>
	                            					<form name="job_m{$mechanics[mechanic].id}" action="?site=mechanic_setting" method="post">
														<input type="hidden" name="mechanic_id" value="{$mechanics[mechanic].id}">
														<select name="job" style="width:110px" onchange="javascript:document.job_m{$mechanics[mechanic].id}.submit()" {if $not_editable}disabled{/if}>
															{if $mechanics[mechanic].job == 0}
																<option selected value="0">-</option>
															{else}
																<option value="0">-</option>
															{/if}
															{if $mechanics[mechanic].job == 1}
																<option selected value="1">{translate}tr_mechanic_setting_pitstop{/translate}</option>
															{else}
																<option value="1">{translate}tr_mechanic_setting_pitstop{/translate}</option>
															{/if}
															{if $mechanics[mechanic].job == 2}
																<option selected value="2">{translate}tr_mechanic_setting_setup{/translate}</option>
															{else}
																<option value="2">{translate}tr_mechanic_setting_setup{/translate}</option>
															{/if}
															{if $mechanics[mechanic].job == 3}
																<option selected value="3">{translate}tr_mechanic_setting_tires{/translate}</option>
															{else}
																<option value="3">{translate}tr_mechanic_setting_tires{/translate}</option>
															{/if}
															{if $mechanics[mechanic].job == 4}
																<option selected value="4">{translate}tr_mechanic_setting_repair{/translate}</option>
															{else}
																<option value="4">{translate}tr_mechanic_setting_repair{/translate}</option>
															{/if}
														</select>
													</form>
	                            				</td>
	                                    	</tr>
	                                    </table>
		                        	</td>
		                        </tr>
		                    {/section}
		                    </tbody>
		                </table>
		                <!--<p>{translate}tr_mechanic_information{/translate}</p>-->
    				</div>
				</div>
    		</div>
    	</div>
    </div>
</div>