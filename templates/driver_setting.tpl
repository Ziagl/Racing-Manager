<div class="page-content-wrapper">
    <div class="page-content">
    	<div class="row">
    		<div class="col-md-12">
    			<div class="portlet box green">
    				<div class="portlet-title">
    					<div class="caption">{translate}tr_driver_setting_title{/translate}</div>
    				</div>
    				<div class="portlet-body">
						{if count($drivers) <= 0}
		            		<p>{translate}tr_driver_setting_no_driver{/translate}</p>
						{else}
							<ul class="nav nav-tabs">
								{$i = 0}
								{section name=driver loop=$drivers}
			                        <li {if $i == 0}class="active"{/if}><a data-toggle="tab" href="#{$drivers[driver].shortname}">{$drivers[driver].firstname} {$drivers[driver].lastname}</a></li>
			                        <!-- {$i++} -->
			                    {/section}
	    					</ul>
	    					<div class="tab-content">
	    						{$i = 0}
	    						{section name=driver loop=$drivers}
	    							<div id="{$drivers[driver].shortname}" class="tab-pane fade{if $i == 0} active in{/if}">
			                            <div class="row">
			                                <div class="col-md-2 col-xs-4">
			                                	<img src="content/img/driver/{$drivers[driver].picture}" width="90%"/>
			                                </div>
			                                <div class="col-md-10 col-xs-8">
												<div class="desktop_slider">
													<div class="row">
														<table width="100%">
															<tr>
																<th></th>
																<th>{translate}tr_driver_setting_speed{/translate}</th>
																<th>{translate}tr_driver_setting_persistence{/translate}</th>
																<th>{translate}tr_driver_setting_experience{/translate}</th>
																<th>{translate}tr_driver_setting_stamina{/translate}</th>
																<th>{translate}tr_driver_setting_freshness{/translate}</th>
																<th>{translate}tr_driver_setting_morale{/translate}</th>
															</tr>
															<tr>
																<td>{translate}current_values{/translate}</td>
																<td class="{$drivers[driver].speed_css}">{$drivers[driver].speed}</td>
																<td class="{$drivers[driver].persistence_css}">{$drivers[driver].persistence}</td>
																<td class="{$drivers[driver].experience_css}">{$drivers[driver].experience}</td>
																<td class="{$drivers[driver].stamina_css}">{$drivers[driver].stamina}</td>
																<td class="{$drivers[driver].freshness_css}">{$drivers[driver].freshness}</td>
																<td class="{$drivers[driver].morale_css}">{$drivers[driver].morale}</td>
															</tr>
															{$j = 1}
															{section name=history loop=$drivers[driver].history}
																<tr>
																	<td>{translate}tr_driver_setting_training_week_pre{/translate}{$j} {translate}tr_driver_setting_training_week{/translate}{if $j > 1}{translate}tr_driver_setting_training_week_add{/translate}{/if}{translate}tr_driver_setting_training_week_post{/translate}</td>
																	<td class="{$drivers[driver].history[$j-1].speed_css}">
																		{$drivers[driver].history[$j-1].speed}
																	</td>
																	<td class="{$drivers[driver].history[$j-1].persistence_css}">
																		{$drivers[driver].history[$j-1].persistence}
																	</td>
																	<td class="{$drivers[driver].history[$j-1].experience_css}">
																		{$drivers[driver].history[$j-1].experience}
																	</td>
																	<td class="{$drivers[driver].history[$j-1].stamina_css}">
																		{$drivers[driver].history[$j-1].stamina}
																	</td>
																	<td class="{$drivers[driver].history[$j-1].freshness_css}">
																		{$drivers[driver].history[$j-1].freshness}
																	</td>
																	<td class="{$drivers[driver].history[$j-1].morale_css}">
																		{$drivers[driver].history[$j-1].morale}
																	</td>
																<tr>
																<!-- {$j++} -->
															{/section}
															<tr>
																<td>{translate}oldest_values{/translate}</td>
																<td class="{$drivers[driver].history_first.speed_css}">
																	{$drivers[driver].history_first.speed}
																</td>
																<td class="{$drivers[driver].history_first.persistence_css}">
																	{$drivers[driver].history_first.persistence}
																</td>
																<td class="{$drivers[driver].history_first.experience_css}">
																	{$drivers[driver].history_first.experience}
																</td>
																<td class="{$drivers[driver].history_first.stamina_css}">
																	{$drivers[driver].history_first.stamina}
																</td>
																<td class="{$drivers[driver].history_first.freshness_css}">
																	{$drivers[driver].history_first.freshness}
																</td>
																<td class="{$drivers[driver].history_first.morale_css}">
																	{$drivers[driver].history_first.morale}
																</td>
															<tr>
														</table>
													</div>
												</div>
												<div class="mobile_slider">
													<div class="row">
														<table width="100%">
															<tr>
																<th></th>
																<th>{translate}tr_driver_setting_speed_short{/translate}</th>
																<th>{translate}tr_driver_setting_persistence_short{/translate}</th>
																<th>{translate}tr_driver_setting_experience_short{/translate}</th>
																<th>{translate}tr_driver_setting_stamina_short{/translate}</th>
																<th>{translate}tr_driver_setting_freshness_short{/translate}</th>
																<th>{translate}tr_driver_setting_morale_short{/translate}</th>
															</tr>
															<tr>
																<td>{translate}current_values{/translate}</td>
																<td class="{$drivers[driver].speed_css}">{$drivers[driver].speed}</td>
																<td class="{$drivers[driver].persistence_css}">{$drivers[driver].persistence}</td>
																<td class="{$drivers[driver].experience_css}">{$drivers[driver].experience}</td>
																<td class="{$drivers[driver].stamina_css}">{$drivers[driver].stamina}</td>
																<td class="{$drivers[driver].freshness_css}">{$drivers[driver].freshness}</td>
																<td class="{$drivers[driver].morale_css}">{$drivers[driver].morale}</td>
															</tr>
															{$j = 1}
															{section name=history loop=$drivers[driver].history}
																<tr>
																	<td>{translate}tr_driver_setting_training_week_pre{/translate}{$j} {translate}tr_driver_setting_training_week{/translate}{if $j > 1}{translate}tr_driver_setting_training_week_add{/translate}{/if}{translate}tr_driver_setting_training_week_post{/translate}</td>
																	<td class="{$drivers[driver].history[$j-1].speed_css}">
																		{$drivers[driver].history[$j-1].speed}
																	</td>
																	<td class="{$drivers[driver].history[$j-1].persistence_css}">
																		{$drivers[driver].history[$j-1].persistence}
																	</td>
																	<td class="{$drivers[driver].history[$j-1].experience_css}">
																		{$drivers[driver].history[$j-1].experience}
																	</td>
																	<td class="{$drivers[driver].history[$j-1].stamina_css}">
																		{$drivers[driver].history[$j-1].stamina}
																	</td>
																	<td class="{$drivers[driver].history[$j-1].freshness_css}">
																		{$drivers[driver].history[$j-1].freshness}
																	</td>
																	<td class="{$drivers[driver].history[$j-1].morale_css}">
																		{$drivers[driver].history[$j-1].morale}
																	</td>
																<tr>
																<!-- {$j++} -->
															{/section}
														</table>
													</div>
												</div>
											</div>
			                            </div>
			                            <br>
			                            <div class="row">
											<div class="col-md-7 col-xs-7">
												<div class="row">
													<div class="col-md-3 col-xs-5">{translate}tr_driver_setting_name{/translate}:</div>
													<div class="col-md-9 col-xs-7"><a href="?site=driverinfo&id={$drivers[driver].id}">{$drivers[driver].firstname} {$drivers[driver].lastname} ({$drivers[driver].shortname})</a></div>
												</div>
												<div class="row">
													<div class="col-md-3 col-xs-5">{translate}tr_driver_setting_country{/translate}:</div>
													<div class="col-md-9 col-xs-7">{$drivers[driver].country_name} <img src="content/img/flags/{$drivers[driver].country_picture}.gif" width="50px"/></div>
												</div>
											</div>
											
											<div class="col-md-5 col-xs-5">
												<div class="row">
													<div class="row">
														<div class="col-md-3 col-xs-5">{translate}tr_driver_setting_wage{/translate}:</div>
														<div class="col-md-9 col-xs-7" align="right">{$drivers[driver].wage} {translate}tr_global_currency_symbol{/translate}</div>
													</div>
													<div class="row">
														<div class="col-md-3 col-xs-5">{translate}tr_driver_setting_bonus{/translate}:</div>
														<div class="col-md-9 col-xs-7" align="right">{$drivers[driver].bonus} {translate}tr_global_currency_symbol{/translate}</div> 
													</div>
													<div class="row">
														<div class="col-md-12 col-xs-12" align="right">
															<form action="?site=driver_setting" method="post">
																<input type="hidden" name="sell_driver_id" id="sell_driver_id" value="{$drivers[driver].id}">
																{if $drivers[driver].sell_price > 0}
																<input type="button" class="btn btn-small btn-danger confirm" data-text="{translate}tr_driver_setting_sell_driver_question{/translate}" data-confirm-button="{translate}yes{/translate}" data-cancel-button="{translate}no{/translate}" value="{translate}tr_driver_setting_sell_driver_pre{/translate}{$drivers[driver].sell_price} {translate}tr_global_currency_symbol{/translate}{translate}tr_driver_setting_sell_driver_post{/translate}">
																{else}
																<input type="button" class="btn btn-small btn-danger confirm" data-text="{translate}tr_driver_setting_sell_youth_driver_question{/translate}" data-confirm-button="{translate}yes{/translate}" data-cancel-button="{translate}no{/translate}" value="{translate}tr_driver_setting_sell_youth_driver{/translate}">
																{/if}
															</form>
															{if $drivers[driver].sell_price > 0}
															{translate}tr_driver_setting_sell_driver{/translate}
															{/if}
														</div>
													</div>
												</div>
											</div>
			                            </div>
			                        </div>
			                        <!-- {$i++} -->
			                    {/section}
			                </div>
			            {/if}
    				</div>
    			</div>
    		</div>
    	</div>
    </div>
</div>