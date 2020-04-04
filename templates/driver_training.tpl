<!-- BEGIN CONTENT -->
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
							<ul class="nav nav-tabs" id="myTab">
								{$i = 0}
								{section name=driver loop=$drivers}
			                        <li {if $i == 0}class="active"{/if}><a data-toggle="tab" href="#{$drivers[driver].shortname}">{$drivers[driver].firstname} {$drivers[driver].lastname}</a></li>
			                        <!-- {$i++} -->
			                    {/section}
	    					</ul>
	    					<p>{translate}tr_driver_training_information{/translate}</p>
	    					
	    					<div class="tab-content">
								{$i = 0}
	    						{section name=driver loop=$drivers}
	    							<div id="{$drivers[driver].shortname}" class="tab-pane fade{if $i == 0} active in{/if}">
										<div class="desktop_slider">
											<form action="?site=driver_training" method="post" name="trainingsform{$i}" id="trainingsform{$i}">
												<table width="100%">
													<tr>
														<th>{translate}tr_driver_training_day{/translate}</th>
														<th>{translate}tr_driver_training_type{/translate}</th>
														<th>{translate}tr_driver_setting_speed{/translate}</th>
														<th>{translate}tr_driver_setting_persistence{/translate}</th>
														<!--<th>{translate}tr_driver_setting_experience{/translate}</th>-->
														<th>{translate}tr_driver_setting_stamina{/translate}</th>
														<th>{translate}tr_driver_setting_freshness{/translate}</th>
														<th>{translate}tr_driver_setting_morale{/translate}</th>
														<th>{translate}tr_driver_training_cost{/translate}</th>
													</tr>
													<tr>
														<td>{translate}tr_monday{/translate}</td>
														<td>
															<select name="monday" onchange="javascript:document.trainingsform{$i}.submit()">
																<option selected value=''>{translate}tr_driver_training_no_training{/translate}</option>
																{section name=training loop=$trainings}
																	{if $drivers[driver].monday == $trainings[training].id}
																		<option selected value='{$trainings[training].id}'>{translate}{$trainings[training].name}{/translate}</option>
																	{else}
																		<option value='{$trainings[training].id}'>{translate}{$trainings[training].name}{/translate}</option>
																	{/if}
																{/section}
															</select>
														</td>
														{$drivers[driver].monday_text}
													</tr>
													<tr>
														<td>{translate}tr_tuesday{/translate}:</td>
														<td>
															<select name="tuesday" onchange="javascript:document.trainingsform{$i}.submit()">
																<option selected value=''>{translate}tr_driver_training_no_training{/translate}</option>
																{section name=training loop=$trainings}
																	{if $drivers[driver].tuesday == $trainings[training].id}
																		<option selected value='{$trainings[training].id}'>{translate}{$trainings[training].name}{/translate}</option>
																	{else}
																		<option value='{$trainings[training].id}'>{translate}{$trainings[training].name}{/translate}</option>
																	{/if}
																{/section}
															</select>
														</td>
														{$drivers[driver].tuesday_text}
													</tr>
													<tr>
														<td>{translate}tr_wednesday{/translate}:</td>
														<td>
															<select name="wednesday" onchange="javascript:document.trainingsform{$i}.submit()">
																<option selected value=''>{translate}tr_driver_training_no_training{/translate}</option>
																{section name=training loop=$trainings}
																	{if $drivers[driver].wednesday == $trainings[training].id}
																		<option selected value='{$trainings[training].id}'>{translate}{$trainings[training].name}{/translate}</option>
																	{else}
																		<option value='{$trainings[training].id}'>{translate}{$trainings[training].name}{/translate}</option>
																	{/if}
																{/section}
															</select>
														</td>
														{$drivers[driver].wednesday_text}
													</tr>
													<tr>
														<td>{translate}tr_thursday{/translate}:</td>
														<td>
															<select name="thursday" onchange="javascript:document.trainingsform{$i}.submit()">
																<option selected value=''>{translate}tr_driver_training_no_training{/translate}</option>
																{section name=training loop=$trainings}
																	{if $drivers[driver].thursday == $trainings[training].id}
																		<option selected value='{$trainings[training].id}'>{translate}{$trainings[training].name}{/translate}</option>
																	{else}
																		<option value='{$trainings[training].id}'>{translate}{$trainings[training].name}{/translate}</option>
																	{/if}
																{/section}
															</select>
														</td>
														{$drivers[driver].thursday_text}
													</tr>
													<tr>
														<td>{translate}tr_friday{/translate}:</td>
														<td>
															<select name="friday" onchange="javascript:document.trainingsform{$i}.submit()">
																<option selected value=''>{translate}tr_driver_training_no_training{/translate}</option>
																{section name=training loop=$trainings}
																	{if $drivers[driver].friday == $trainings[training].id}
																		<option selected value='{$trainings[training].id}'>{translate}{$trainings[training].name}{/translate}</option>
																	{else}
																		<option value='{$trainings[training].id}'>{translate}{$trainings[training].name}{/translate}</option>
																	{/if}
																{/section}
															</select>
														</td>
														{$drivers[driver].friday_text}
													</tr>
													<tr>
														<td>{translate}tr_saturday{/translate}:</td>
														<td>
															<select name="saturday" onchange="javascript:document.trainingsform{$i}.submit()">
																<option selected value=''>{translate}tr_driver_training_no_training{/translate}</option>
																{section name=training loop=$trainings}
																	{if $drivers[driver].saturday == $trainings[training].id}
																		<option selected value='{$trainings[training].id}'>{translate}{$trainings[training].name}{/translate}</option>
																	{else}
																		<option value='{$trainings[training].id}'>{translate}{$trainings[training].name}{/translate}</option>
																	{/if}
																{/section}
															</select>
														</td>
														{$drivers[driver].saturday_text}
													</tr>
													<tr>
														<td>{translate}tr_sunday{/translate}:</td>
														<td>
															<select name="sunday" onchange="javascript:document.trainingsform{$i}.submit()">
																<option selected value=''>{translate}tr_driver_training_no_training{/translate}</option>
																{section name=training loop=$trainings}
																	{if $drivers[driver].sunday == $trainings[training].id}
																		<option selected value='{$trainings[training].id}'>{translate}{$trainings[training].name}{/translate}</option>
																	{else}
																		<option value='{$trainings[training].id}'>{translate}{$trainings[training].name}{/translate}</option>
																	{/if}
																{/section}
															</select>
														</td>
														{$drivers[driver].sunday_text}
													</tr>
												</table>
												<br/>
												<input type="hidden" value="{$drivers[driver].id}" name="driver">
											</form>
										</div>
										<div class="mobile_slider">
											<form action="?site=driver_training" method="post" name="trainingsform_m{$i}" id="trainingsform_m{$i}">
												<table width="100%">
													<tr>
														<th>{translate}tr_driver_training_day_short{/translate}</th>
														<th>{translate}tr_driver_setting_speed_short{/translate}</th>
														<th>{translate}tr_driver_setting_persistence_short{/translate}</th>
														<!--<th>{translate}tr_driver_setting_experience_short{/translate}</th>-->
														<th>{translate}tr_driver_setting_stamina_short{/translate}</th>
														<th>{translate}tr_driver_setting_freshness_short{/translate}</th>
														<th>{translate}tr_driver_setting_morale_short{/translate}</th>
														<th>{translate}tr_driver_training_cost{/translate}</th>
													</tr>
													<tr>
														<td rowspan="2">{translate}tr_monday_short{/translate}:</td>
														<td colspan="6">
															<select name="monday" onchange="javascript:document.trainingsform_m{$i}.submit()" style="width: 100%">
																<option selected value=''>{translate}tr_driver_training_no_training{/translate}</option>
																{section name=training loop=$trainings}
																	{if $drivers[driver].monday == $trainings[training].id}
																		<option selected value='{$trainings[training].id}'>{translate}{$trainings[training].name}{/translate}</option>
																	{else}
																		<option value='{$trainings[training].id}'>{translate}{$trainings[training].name}{/translate}</option>
																	{/if}
																{/section}
															</select>
														</td>
													</tr>
													<tr>
														{$drivers[driver].monday_text}
													</tr>
													<tr>
														<td rowspan="2">{translate}tr_tuesday_short{/translate}:</td>
														<td colspan="6">
															<select name="tuesday" onchange="javascript:document.trainingsform_m{$i}.submit()" style="width: 100%">
																<option selected value=''>{translate}tr_driver_training_no_training{/translate}</option>
																{section name=training loop=$trainings}
																	{if $drivers[driver].tuesday == $trainings[training].id}
																		<option selected value='{$trainings[training].id}'>{translate}{$trainings[training].name}{/translate}</option>
																	{else}
																		<option value='{$trainings[training].id}'>{translate}{$trainings[training].name}{/translate}</option>
																	{/if}
																{/section}
															</select>
														</td>
													</tr>
													<tr>
														{$drivers[driver].tuesday_text}
													</tr>
													<tr>
														<td rowspan="2">{translate}tr_wednesday_short{/translate}:</td>
														<td colspan="6">
															<select name="wednesday" onchange="javascript:document.trainingsform_m{$i}.submit()" style="width: 100%">
																<option selected value=''>{translate}tr_driver_training_no_training{/translate}</option>
																{section name=training loop=$trainings}
																	{if $drivers[driver].wednesday == $trainings[training].id}
																		<option selected value='{$trainings[training].id}'>{translate}{$trainings[training].name}{/translate}</option>
																	{else}
																		<option value='{$trainings[training].id}'>{translate}{$trainings[training].name}{/translate}</option>
																	{/if}
																{/section}
															</select>
														</td>
													</tr>
													<tr>
														{$drivers[driver].wednesday_text}
													</tr>
													<tr>
														<td rowspan="2">{translate}tr_thursday_short{/translate}:</td>
														<td colspan="6">
															<select name="thursday" onchange="javascript:document.trainingsform_m{$i}.submit()" style="width: 100%">
																<option selected value=''>{translate}tr_driver_training_no_training{/translate}</option>
																{section name=training loop=$trainings}
																	{if $drivers[driver].thursday == $trainings[training].id}
																		<option selected value='{$trainings[training].id}'>{translate}{$trainings[training].name}{/translate}</option>
																	{else}
																		<option value='{$trainings[training].id}'>{translate}{$trainings[training].name}{/translate}</option>
																	{/if}
																{/section}
															</select>
														</td>
													</tr>
													<tr>
														{$drivers[driver].thursday_text}
													</tr>
													<tr>
														<td rowspan="2">{translate}tr_friday_short{/translate}:</td>
														<td colspan="6">
															<select name="friday" onchange="javascript:document.trainingsform_m{$i}.submit()" style="width: 100%">
																<option selected value=''>{translate}tr_driver_training_no_training{/translate}</option>
																{section name=training loop=$trainings}
																	{if $drivers[driver].friday == $trainings[training].id}
																		<option selected value='{$trainings[training].id}'>{translate}{$trainings[training].name}{/translate}</option>
																	{else}
																		<option value='{$trainings[training].id}'>{translate}{$trainings[training].name}{/translate}</option>
																	{/if}
																{/section}
															</select>
														</td>
													</tr>
													<tr>
														{$drivers[driver].friday_text}
													</tr>
													<tr>
														<td rowspan="2">{translate}tr_saturday_short{/translate}:</td>
														<td colspan="6">
															<select name="saturday" onchange="javascript:document.trainingsform_m{$i}.submit()" style="width: 100%">
																<option selected value=''>{translate}tr_driver_training_no_training{/translate}</option>
																{section name=training loop=$trainings}
																	{if $drivers[driver].saturday == $trainings[training].id}
																		<option selected value='{$trainings[training].id}'>{translate}{$trainings[training].name}{/translate}</option>
																	{else}
																		<option value='{$trainings[training].id}'>{translate}{$trainings[training].name}{/translate}</option>
																	{/if}
																{/section}
															</select>
														</td>
													</tr>
													<tr>
														{$drivers[driver].saturday_text}
													</tr>
													<tr>
														<td rowspan="2">{translate}tr_sunday_short{/translate}:</td>
														<td colspan="6">
															<select name="sunday" onchange="javascript:document.trainingsform_m{$i}.submit()" style="width: 100%">
																<option selected value=''>{translate}tr_driver_training_no_training{/translate}</option>
																{section name=training loop=$trainings}
																	{if $drivers[driver].sunday == $trainings[training].id}
																		<option selected value='{$trainings[training].id}'>{translate}{$trainings[training].name}{/translate}</option>
																	{else}
																		<option value='{$trainings[training].id}'>{translate}{$trainings[training].name}{/translate}</option>
																	{/if}
																{/section}
															</select>
														</td>
													</tr>
													<tr>
														{$drivers[driver].sunday_text}
													</tr>
												</table>
												<br/>
												<input type="hidden" value="{$drivers[driver].id}" name="driver">
											</form>
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
{literal}
<script>
var last_car = {/literal} '{$drivers[$last_car].shortname}' {literal};

$(document).ready(function() {
	$('#myTab a[href="#'+last_car+'"]').tab('show');
});
</script>
{/literal}