<script>
	function countdown(time,id,done){
	  t = time;
	  d = Math.floor(t/(60*60*24)); 
	  h = Math.floor(t/(60*60)) % 24;
	 
	  m = Math.floor(t/60) %60;
	  s = t %60;
	  d = (d >  0) ? d+"d ":"";
	  h = (h < 10) ? "0"+h : h;
	  m = (m < 10) ? "0"+m : m;
	  s = (s < 10) ? "0"+s : s;
	  strZeit =d + h + ":" + m + ":" + s;

	  if(time > 0)
	  {
		window.setTimeout('countdown('+ --time+',\''+id+'\')',1000,done);
	  }
	  else
	  {
		strZeit = done;
	  }
	  if(typeof strZeit == 'undefined')
      	strZeit = "00:00:00";
	  document.getElementById(id).innerHTML = strZeit;
	}
</script>
<div class="page-content-wrapper">
    <div class="page-content">
    	<div class="row">
    		<div class="col-md-12">
    			{if $message!=null}
					{$message}
				{else}
					{if $driver_bid_type == 1 and count($bids) > 0}
	    			<div class="portlet box green">
	    				<div class="portlet-title">
	    					<div class="caption">{translate}tr_driver_market_bids{/translate}</div>
	    				</div>
	    				<div class="portlet-body desktop_slider">
	    					<table class="table table-striped">
			                    <thead>
			                    <tr>
			                    	<th>{translate}tr_statistic_driver_picture{/translate}</th>
			                        <th>{translate}tr_statistic_driver_name{/translate}</th>
			                        <th>{translate}tr_driver_setting_country{/translate}</th>
			                        <th>{translate}tr_driver_market_other_bids{/translate}</th>
			                        <th>{translate}tr_driver_market_chance{/translate}</th>
			                        <th>{translate}tr_driver_market_time_till_decision{/translate}</th>
			                        <th>{translate}tr_driver_setting_wage{/translate}</th>
			                        <th>{translate}tr_driver_setting_bonus{/translate}</th>
			                        <th>{translate}tr_driver_setting_action{/translate}</th>
			                    </tr>
			                    </thead>
			                    <tbody>
			                    {section name=bid loop=$bids}
			                    	<tr>
			                    		<td><img src="content/img/driver/{$bids[bid].picture}" width="40px"/></td>
										<td><a href="?site=driverinfo&id={$bids[bid].dri_id}">{$bids[bid].firstname} {$bids[bid].lastname}</a></td>
										<td><img title="{$bids[bid].country_name}" src="content/img/flags/{$bids[bid].country_picture}.gif" width="35px"/></td>
										<td>{$bids[bid].other_bids}</td>
										<td>{$bids[bid].chance} %</td>
										<td><div id="bid{$bids[bid].id}"><script>countdown({$bids[bid].time_to_bid},'bid{$bids[bid].id}','{translate}Done{/translate}');</script></div></td>
										<td><input type="text" id="bid_wage_{$bids[bid].id}" name="bid_wage_{$bids[bid].id}" value="{$bids[bid].wage}" size="8"/> {translate}tr_global_currency_symbol{/translate}</td>
										<td><input type="text" id="bid_bonus_{$bids[bid].id}" name="bid_bonus_{$bids[bid].id}" value="{$bids[bid].bonus}" size="8"/> {translate}tr_global_currency_symbol{/translate}</td>
										<td>
											<form action="?site=driver_market" method="post">
												<input type="hidden" id="bid_id" name="bid_id" value="{$bids[bid].id}"/>
												<input type="hidden" id="bid_wage_new_{$bids[bid].id}" name="bid_wage_new_{$bids[bid].id}" value=""/>
												<input type="hidden" id="bid_bonus_new_{$bids[bid].id}" name="bid_bonus_new_{$bids[bid].id}" value=""/>
												<input type="submit" class="btn btn-small btn-success"  onclick="setWageBonus({$bids[bid].id})" value="{translate}tr_button_bid_change{/translate}"/>
											</form>
											<form action="?site=driver_market" method="post">
												<input type="hidden" id="delete_bid_id" name="delete_bid_id" value="{$bids[bid].id}"/>
												<input type="submit" class="btn btn-small btn-danger" value="{translate}tr_button_bid_delete{/translate}"/>
											</form>
										</td>
			                    	</tr>
			                    {/section}
			                    </tbody>
							</table>
	    				</div>
	    				<div class="portlet-body mobile_slider">
	    					<table class="table">
			                    <thead>
			                    <tr>
			                    	<th>{translate}tr_statistic_driver_picture{/translate}</th>
			                        <th>{translate}tr_driver_setting_country{/translate}</th>
			                        <th></th>
			                    </tr>
			                    </thead>
			                    <tbody name="{$i = 0}">
			                    {section name=bid loop=$bids}
			                    	<tr{if $i % 2 == 0} class="table_striped_two_lines"{/if} name="{$i++}">
			                    		<td><img src="content/img/driver/{$bids[bid].picture}" width="40px"/></td>
										<td><img title="{$bids[bid].country_name}" src="content/img/flags/{$bids[bid].country_picture}.gif" width="35px"/></td>
										<td>
											<table width="100%" style="line-height: 1.42857;">
												<tr>
													<td>{translate}tr_statistic_driver_name{/translate}</td>
													<td><a href="?site=driverinfo&id={$bids[bid].dri_id}">{$bids[bid].firstname} {$bids[bid].lastname}</a></td>
												</tr>
												<tr>
													<td>{translate}tr_driver_setting_wage{/translate}</td>
													<td><input type="text" id="bid_wage_mobile_{$bids[bid].id}" name="bid_wage_{$bids[bid].id}" value="{$bids[bid].wage}" size="8"/> {translate}tr_global_currency_symbol{/translate}</td>
												</tr>
												<tr>
													<td>{translate}tr_driver_setting_bonus{/translate}</td>
													<td><input type="text" id="bid_bonus_mobile_{$bids[bid].id}" name="bid_bonus_{$bids[bid].id}" value="{$bids[bid].bonus}" size="8"/> {translate}tr_global_currency_symbol{/translate}</td>
												</tr>
												<tr>
													<td>{translate}tr_driver_market_other_bids{/translate}</td>
													<td>{$bids[bid].other_bids}</td>
												</tr>
												<tr>
													<td>{translate}tr_driver_market_chance{/translate}</td>
													<td>{$bids[bid].chance} %</td>
												</tr>
												<tr>
													<td>{translate}tr_driver_market_time_till_decision{/translate}</td>
													<td><div id="mobile_bid{$bids[bid].id}"><script>countdown({$bids[bid].time_to_bid},'mobile_bid{$bids[bid].id}','{translate}Done{/translate}');</script></div></td>
												</tr>
												<tr>
													<td>
														<form action="?site=driver_market" method="post">
															<input type="hidden" id="bid_id" name="bid_id" value="{$bids[bid].id}"/>
															<input type="hidden" id="bid_wage_mobile_new_{$bids[bid].id}" name="bid_wage_new_{$bids[bid].id}" value=""/>
															<input type="hidden" id="bid_bonus_mobile_new_{$bids[bid].id}" name="bid_bonus_new_{$bids[bid].id}" value=""/>
															<input type="submit" class="btn btn-small btn-success"  onclick="setWageBonus({$bids[bid].id})" value="{translate}tr_button_bid_change{/translate}"/>
														</form>
													</td>
													<td>
														<form action="?site=driver_market" method="post">
															<input type="hidden" id="delete_bid_id" name="delete_bid_id" value="{$bids[bid].id}"/>
															<input type="submit" class="btn btn-small btn-danger" value="{translate}tr_button_bid_delete{/translate}"/>
														</form>
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
	    			{/if}
	    			<div class="portlet box green">
	    				<div class="portlet-title">
	    					<div class="caption">{translate}tr_driver_market_title{/translate}</div>
	    				</div>
	    				<div class="portlet-body desktop_slider">
	    					<table class="table table-striped" id="driver_market_table">
			                    <thead>
			                    <tr>
			                        <th>{translate}tr_statistic_driver_picture{/translate}</th>
			                        <th>{translate}tr_statistic_driver_name{/translate}</th>
			                        <th>{translate}tr_driver_setting_country{/translate}</th>
			                        <th>{translate}tr_driver_setting_age{/translate}</th>
			                        <th>{translate}tr_driver_setting_speed{/translate}</th>
			                        <th>{translate}tr_driver_setting_persistence{/translate}</th>
			                        <th>{translate}tr_driver_setting_experience{/translate}</th>
			                        <th>{translate}tr_driver_setting_stamina{/translate}</th>
			                        <th>{translate}tr_driver_setting_freshness{/translate}</th>
			                        <th>{translate}tr_driver_setting_morale{/translate}</th>
			                        <th>{translate}tr_driver_setting_wage{/translate}</th>
			                        <th>{translate}tr_driver_setting_bonus{/translate}</th>
			                        <th>{translate}tr_driver_setting_action{/translate}</th>
			                    </tr>
			                    </thead>
			                    <tbody>
			                    {if $team.youthdriver < $max_youth_driver}
			                    	<tr>
			                    		<td><img src="content/img/driver/default.jpg" width="50px"/></td>
			                            <td>{translate}tr_driver_youth_driver{/translate}</td>
			                            <td>?</td>
			                            <td>?</td>
			                            <td>?</td>
			                            <td>?</td>
			                            <td>?</td>
			                            <td>?</td>
			                            <td>?</td>
			                            <td>?</td>
			                            <td align="right">0 {translate}tr_global_currency_symbol{/translate}</td>
			                            <td align="right">0 {translate}tr_global_currency_symbol{/translate}</td>
			                            <td>
			                                {if $count_driver < 3}
			                                    <form action="?site=driver_market" method="post">
			                                        <input type="hidden" id="youth_driver" name="youth_driver" value="0"/>
			                                        <input type="submit" class="btn btn-small btn-success" value="{translate}tr_button_buy{/translate}"/>
			                                    </form>
			                                {/if}
			                            </td>
			                    	</tr>
			                    {/if}
			                    {section name=driver loop=$drivers}
			                        <tr>
			                            <td><img src="content/img/driver/{$drivers[driver].picture}" width="50px"/></td>
			                            <td><a href="?site=driverinfo&id={$drivers[driver].id}">{$drivers[driver].firstname} {$drivers[driver].lastname}</a></td>
			                            <td><img title="{$drivers[driver].country_name}" src="content/img/flags/{$drivers[driver].country_picture}.gif" width="40px"/></td>
			                            <td>{$drivers[driver].age}</td>
			                            <td class="{$drivers[driver].speed_css}">{$drivers[driver].speed}</td>
			                            <td class="{$drivers[driver].persistence_css}">{$drivers[driver].persistence}</td>
			                            <td class="{$drivers[driver].experience_css}">{$drivers[driver].experience}</td>
			                            <td class="{$drivers[driver].stamina_css}">{$drivers[driver].stamina}</td>
			                            <td class="{$drivers[driver].freshness_css}">{$drivers[driver].freshness}</td>
			                            <td class="{$drivers[driver].morale_css}">{$drivers[driver].morale}</td>
			                            <td align="right"><span class="nowrapping">{$drivers[driver].wage} {translate}tr_global_currency_symbol{/translate}</span></td>
			                            <td align="right"><span class="nowrapping">{$drivers[driver].bonus} {translate}tr_global_currency_symbol{/translate}</span></td>
			                            {if $driver_bid_type == 0}
				                            <td>
				                                {if $count_driver < 3}
				                                    <form action="?site=driver_market" method="post">
				                                        <input type="hidden" id="driver_id" name="driver_id" value="{$drivers[driver].id}"/>
				                                        <input type="submit" {if $drivers[driver].not_buyable}disabled=""{/if} class="btn btn-small btn-success" value="{translate}tr_button_buy{/translate}"/>
				                                    </form>
				                                {/if}
				                            </td>
			                            {else}
			                            	<td>
			                            		{if $count_driver < 3}
													{if $count_bids < 5}
														<form action="?site=driver_market" method="post">
															<input type="hidden" id="driver_bid_id" name="driver_bid_id" value="{$drivers[driver].id}"/>
															<input type="submit" {if $drivers[driver].not_buyable}disabled=""{/if} class="btn btn-small btn-success" value="{translate}tr_button_bid{/translate}"/>
														</form>
													{/if}
				                                {/if}
				                            </td>
			
			                            {/if}
			                        </tr>
			                    {/section}
			                    </tbody>
			                </table>
	    				</div>
	    				<div class="portlet-body mobile_slider">
	    					<table class="table" id="driver_market_table">
			                    <thead>
			                    <tr>
			                        <th>{translate}tr_statistic_driver_picture{/translate}</th>
			                        <th>{translate}tr_driver_setting_country{/translate}</th>
			                        <th>{translate}tr_driver_setting_speed_short{/translate}</th>
			                        <th>{translate}tr_driver_setting_persistence_short{/translate}</th>
			                        <th>{translate}tr_driver_setting_experience_short{/translate}</th>
			                        <th>{translate}tr_driver_setting_stamina_short{/translate}</th>
			                        <th>{translate}tr_driver_setting_freshness_short{/translate}</th>
			                        <th>{translate}tr_driver_setting_morale_short{/translate}</th>
			                    </tr>
			                    </thead>
			                    <tbody name="{$i = 0}">
			                    {if $team.youthdriver < $max_youth_driver}
			                    	<tr{if $i % 2 == 0} class="table_striped_two_lines"{/if}>
			                    		<td rowspan="2"><img src="content/img/driver/default.jpg" width="50px"/></td>
			                            <td rowspan="2">{translate}tr_driver_youth_driver{/translate}</td>
			                            <td>?</td>
			                            <td>?</td>
			                            <td>?</td>
			                            <td>?</td>
			                            <td>?</td>
			                            <td>?</td>
			                        </tr>
			                        <tr{if $i % 2 == 0} class="table_striped_two_lines"{/if}>
			                        	<td colspan="6" width="100%">
			                        		<table width="100%">
			                        			<tr>
			                        				<td>
			                        					{translate}tr_driver_setting_wage{/translate}:
			                        				</td>
			                        				<td align="right">
			                        					0 {translate}tr_global_currency_symbol{/translate}
			                        				</td>
			                        			</tr>
			                        			<tr>
			                        				<td>
			                        					{translate}tr_driver_setting_bonus{/translate}:
			                        				</td>
			                        				<td align="right">
			                        					0 {translate}tr_global_currency_symbol{/translate}
			                        				</td>
			                        			</tr>
			                        			<tr>
			                        				<td colspan="2" align="right">
			                        					{if $count_driver < 3}
															<form action="?site=driver_market" method="post">
																<input type="hidden" id="youth_driver" name="youth_driver" value="0"/>
																<input type="submit" class="btn btn-small btn-success" value="{translate}tr_button_buy{/translate}"/>
															</form>
														{/if}
			                        				</td>
			                        			</tr>
			                        		</table>
			                        	</td>
			                    	</tr>
			                    {/if}
			                    {section name=driver loop=$drivers}
			                        <tr{if $i % 2 == 0} class="table_striped_two_lines"{/if}>
			                            <td rowspan="2"><img src="content/img/driver/{$drivers[driver].picture}" width="50px"/></td>
			                            <td rowspan="2"><img title="{$drivers[driver].country_name}" src="content/img/flags/{$drivers[driver].country_picture}.gif" width="50px"/></td>
			                            <td class="{$drivers[driver].speed_css}">{$drivers[driver].speed}</td>
			                            <td class="{$drivers[driver].persistence_css}">{$drivers[driver].persistence}</td>
			                            <td class="{$drivers[driver].experience_css}">{$drivers[driver].experience}</td>
			                            <td class="{$drivers[driver].stamina_css}">{$drivers[driver].stamina}</td>
			                            <td class="{$drivers[driver].freshness_css}">{$drivers[driver].freshness}</td>
			                            <td class="{$drivers[driver].morale_css}">{$drivers[driver].morale}</td>
			                        </tr>
			                        <tr{if $i % 2 == 0} class="table_striped_two_lines"{/if} name="{$i++}">
			                        	<td colspan="6" width="100%">
			                        		<table width="100%" style="line-height: 1.42857;">
			                        			<tr>
			                        				<td>
			                        					{translate}tr_statistic_driver_name{/translate}:
			                        				</td>
			                        				<td align="right">
			                        					<a href="?site=driverinfo&id={$drivers[driver].id}">{$drivers[driver].firstname} {$drivers[driver].lastname}</a>
			                        				</td>
			                        			</tr>
			                        			<tr>
			                        				<td>
			                        					{translate}tr_driver_setting_age{/translate}:
			                        				</td>
			                        				<td align="right">
			                        					{$drivers[driver].age}
			                        				</td>
			                        			</tr>
			                        			<tr>
			                        				<td>
			                        					{translate}tr_driver_setting_wage{/translate}:
			                        				</td>
			                        				<td align="right">
			                        					{$drivers[driver].wage} {translate}tr_global_currency_symbol{/translate}
			                        				</td>
			                        			</tr>
			                        			<tr>
			                        				<td>
			                        					{translate}tr_driver_setting_bonus{/translate}:
			                        				</td>
			                        				<td align="right">
			                        					{$drivers[driver].bonus} {translate}tr_global_currency_symbol{/translate}
			                        				</td>
			                        			</tr>
			                        			<tr>
			                        				<td colspan="2"	align="right">
			                        					{if $driver_bid_type == 0}
															{if $count_driver < 3}
																<form action="?site=driver_market" method="post">
																	<input type="hidden" id="driver_id" name="driver_id" value="{$drivers[driver].id}"/>
																	<input type="submit" {if $drivers[driver].not_buyable}disabled=""{/if} class="btn btn-small btn-success" value="{translate}tr_button_buy{/translate}"/>
																</form>
															{/if}
														{else}
															{if $count_driver < 3}
																{if $count_bids < 5}
																	<form action="?site=driver_market" method="post">
																		<input type="hidden" id="driver_bid_id" name="driver_bid_id" value="{$drivers[driver].id}"/>
																		<input type="submit" {if $drivers[driver].not_buyable}disabled=""{/if} class="btn btn-small btn-success" value="{translate}tr_button_bid{/translate}"/>
																	</form>
																{/if}
															{/if}
														{/if}
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
    			{/if}
    		</div>
    	</div>
    </div>
</div>
<script>
$(document).ready(function(){
    $("#driver_market_table").tablesorter(); 
});
</script>
<script>
	function setWageBonus(bid_id)
	{
		$('#bid_wage_new_'+bid_id).val($('#bid_wage_'+bid_id).val());
		$('#bid_bonus_new_'+bid_id).val($('#bid_bonus_'+bid_id).val());
		$('#bid_wage_mobile_new_'+bid_id).val($('#bid_wage_mobile_'+bid_id).val());
		$('#bid_bonus_mobile_new_'+bid_id).val($('#bid_bonus_mobile_'+bid_id).val());
	}
</script>