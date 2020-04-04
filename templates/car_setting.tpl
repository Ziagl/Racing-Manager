<div class="page-content-wrapper">
    <div class="page-content">
    	<div class="row">
    		<div class="col-md-12">
				<div class="portlet box grey-silver">
    				<div class="portlet-title">
    					<div class="caption">{translate}tr_car_setting_title{/translate}</div>
    				</div>
    				<div class="portlet-body">
						<ul class="nav nav-tabs">
							<li class="active"><a data-toggle="tab" href="#race_car1">{translate}race_car{/translate} 1</a></li>
							<li><a data-toggle="tab" href="#race_car2">{translate}race_car{/translate} 2</a></li>
							<li><a data-toggle="tab" href="#training_car">{translate}training_car{/translate}</a></li>
    					</ul>
    					<div class="tab-content">
    						<div id="race_car1" class="tab-pane fade active in">
	                            <div class="row">
									<form action="?site=car_setting" method="post" id="car_driver1" name="car_driver1">
										{translate}tr_car_setting_driver{/translate}: <select name="driver1" onchange="javascript:document.car_driver1.submit()" {if $not_editable}disabled{/if}>
											<option selected value=""></option>
											{section name=driver loop=$drivers}	
												{if $driver1 == $drivers[driver].id}
													<option selected value='{$drivers[driver].id}'>{$drivers[driver].firstname} {$drivers[driver].lastname}</option>
												{else}
													<option value='{$drivers[driver].id}'>{$drivers[driver].firstname} {$drivers[driver].lastname}</option>
												{/if}
											{/section}
										</select>
									</form>
								</div>
	                            <div class="row">
	                             	<div class="desktop_slider">
	                             		<div class="col-md-12">
	                             			<div class="col-md-1"></div>
	                             			<div class="col-md-10">
	                             				<div style="position: relative;">
	                             					<div style="position:absolute; width:100%; z-index:1"><a href="?site=car_construct"><img src="content/img/car/team/{$tea_id}.png?{$rand}" width="100%"></a></div>
	                             					{if $driver_cou1 != "" }
	                             						<div style="z-index:99;"><img src="content/img/driver/helmet/{$driver_cou1}.png" width="100%"></div>
	                             					{else}
	                             						<div style="z-index:99;"><img src="content/img/driver/helmet/0.png" width="100%"></div>
	                             					{/if}
	                             				</div>
	                             			</div>
	                             		</div>
	                             	</div>
	                             	<div class="mobile_slider">
	                             		<div style="position: relative;">
											<div style="position:absolute; width:100%; z-index:1"><a href="?site=car_construct"><img src="content/img/car/team/{$tea_id}.png?{$rand}" width="100%"></a></div>
											{if $driver_cou1 != "" }
												<div style="z-index:99;"><img src="content/img/driver/helmet/{$driver_cou1}.png" width="100%"></div>
											{else}
												<div style="z-index:99;"><img src="content/img/driver/helmet/0.png" width="100%"></div>
											{/if}
										</div>
	                             	</div>
	                            </div>
	                            <div class="desktop_slider">
									<table class="table table-striped">
										<thead>
											<tr>
												<th></th>
												<th>{translate}tr_car_setting_type{/translate}</th>
												<th>{translate}tr_car_item_shop_skill{/translate}</th>
												<th>{translate}tr_car_item_stock_tuneup{/translate}</th>
												<th>{translate}tr_car_item_stock_condition{/translate}</th>
											</tr>
										</thead>
										<tbody>
										{section name=item loop=$car1}
											<tr>
												<td class="center"><img src="content/img/item/{$car1[item].type}.png" width="50px"/></td>
												<td class="center">{$car1[item].type_name}</td>
												{if $car1[item].part}
													<td class="center">{$car1[item].skill}/{$car1[item].skill_max}</td>
													<td class="center">
													<select name="item_tune" style="width:100px" id="risk{$car1[item].id}" name="risk{$car1[item].id}" {if $not_editable}disabled{/if}>
														{if $car1[item].tuneup == 0}
															<option selected value="0">{translate}tr_car_item_stock_norisk{/translate}</option>
														{else}
															<option value="0">{translate}tr_car_item_stock_norisk{/translate}</option>
														{/if}
														{if $car1[item].tuneup == 25}
															<option selected value="25">{translate}tr_car_item_stock_somerisk{/translate}</option>
														{else}
															<option value="25">{translate}tr_car_item_stock_somerisk{/translate}</option>
														{/if}
														{if $car1[item].tuneup == 50}
															<option selected value="50">{translate}tr_car_item_stock_middlerisk{/translate}</option>
														{else}
															<option value="50">{translate}tr_car_item_stock_middlerisk{/translate}</option>
														{/if}
														{if $car1[item].tuneup == 75}
															<option selected value="75">{translate}tr_car_item_stock_muchrisk{/translate}</option>
														{else}
															<option value="75">{translate}tr_car_item_stock_muchrisk{/translate}</option>
														{/if}
														{if $car1[item].tuneup == 100}
															<option selected value="100">{translate}tr_car_item_stock_verymuchrisk{/translate}</option>
														{else}
															<option value="100">{translate}tr_car_item_stock_verymuchrisk{/translate}</option>
														{/if}
													</select>
													<script type="text/javascript">
														$('#risk{$car1[item].id}').change(function() {
															var value = $('#risk{$car1[item].id}').val();
															$.ajax({
																type: 'post',
																url: '?site=car_setting',
																data: {literal}{{/literal} item_id: {$car1[item].id}, item_tune:value{literal}}{/literal} ,
																success: function(response) {
																	
																}
															});
														});
													</script>
													</td>
													<td class="center">
														{if $car1[item].condition < 33}
															<progress class="progress-red" value="{$car1[item].condition}" max="100"></progress> {$car1[item].condition}%
														{/if}
														{if $car1[item].condition > 32 && $car1[item].condition < 66}
															<progress class="progress-orange" value="{$car1[item].condition}" max="100"></progress> {$car1[item].condition}%
														{/if}
														{if $car1[item].condition > 65}
															<progress class="progress-green" value="{$car1[item].condition}" max="100"></progress> {$car1[item].condition}%
														{/if}
													</td>
												{else}
													<td></td>
													<td></td>
													<td></td>
												{/if}
											</tr>
										{/section}
										</tbody>
									</table>
								</div>
								<div class="mobile_slider">
									<table class="table">
										<thead>
											<tr>
												<th></th>
												<th>{translate}tr_car_setting_type{/translate}</th>
												<th>{translate}tr_car_item_shop_skill{/translate}</th>
												<th>{translate}tr_car_item_stock_tuneup{/translate}</th>
											</tr>
										</thead>
										<tbody name="{$i = 0}">
										{section name=item loop=$car1}
											<tr{if $i % 2 == 0} class="table_striped_two_lines"{/if}>
												<td class="center" rowspan="2"><img src="content/img/item/{$car1[item].type}.png" width="50px"/></td>
												<td rowspan="2">{$car1[item].type_name}</td>
												{if $car1[item].part}
													<td class="center">{$car1[item].skill}/{$car1[item].skill_max}</td>
													<td class="center">
													<select name="item_tune" style="width:100px" id="mobile_risk{$car1[item].id}" name="risk{$car1[item].id}" {if $not_editable}disabled{/if}>
														{if $car1[item].tuneup == 0}
															<option selected value="0">{translate}tr_car_item_stock_norisk{/translate}</option>
														{else}
															<option value="0">{translate}tr_car_item_stock_norisk{/translate}</option>
														{/if}
														{if $car1[item].tuneup == 25}
															<option selected value="25">{translate}tr_car_item_stock_somerisk{/translate}</option>
														{else}
															<option value="25">{translate}tr_car_item_stock_somerisk{/translate}</option>
														{/if}
														{if $car1[item].tuneup == 50}
															<option selected value="50">{translate}tr_car_item_stock_middlerisk{/translate}</option>
														{else}
															<option value="50">{translate}tr_car_item_stock_middlerisk{/translate}</option>
														{/if}
														{if $car1[item].tuneup == 75}
															<option selected value="75">{translate}tr_car_item_stock_muchrisk{/translate}</option>
														{else}
															<option value="75">{translate}tr_car_item_stock_muchrisk{/translate}</option>
														{/if}
														{if $car1[item].tuneup == 100}
															<option selected value="100">{translate}tr_car_item_stock_verymuchrisk{/translate}</option>
														{else}
															<option value="100">{translate}tr_car_item_stock_verymuchrisk{/translate}</option>
														{/if}
													</select>
													<script type="text/javascript">
														$('#mobile_risk{$car1[item].id}').change(function() {
															var value = $('#mobile_risk{$car1[item].id}').val();
															$.ajax({
																type: 'post',
																url: '?site=car_setting',
																data: {literal}{{/literal} item_id: {$car1[item].id}, item_tune:value{literal}}{/literal} ,
																success: function(response) {
																	
																}
															});
														});
													</script>
													</td>
												{else}
													<td></td>
													<td></td>
												{/if}
											</tr>
											<tr{if $i % 2 == 0} class="table_striped_two_lines"{/if} name="{$i++}">
												{if $car1[item].part}
													<td colspan="2">
														{if $car1[item].condition < 33}
															<progress class="progress-red" value="{$car1[item].condition}" max="100"></progress> {$car1[item].condition}%
														{/if}
														{if $car1[item].condition > 32 && $car1[item].condition < 66}
															<progress class="progress-orange" value="{$car1[item].condition}" max="100"></progress> {$car1[item].condition}%
														{/if}
														{if $car1[item].condition > 65}
															<progress class="progress-green" value="{$car1[item].condition}" max="100"></progress> {$car1[item].condition}%
														{/if}
													</td>
												{else}
													<td colspan="2"></td>
												{/if}
											</tr>
										{/section}
										</tbody>
									</table>
								</div>
    						</div>

    						<div id="race_car2" class="tab-pane fade">
	                            <div class="row">
									<form action="?site=car_setting" method="post" id="car_driver2" name="car_driver2">
										{translate}tr_car_setting_driver{/translate}: <select name="driver2" onchange="javascript:document.car_driver2.submit()" {if $not_editable}disabled{/if}>
											<option selected value=""></option>
											{section name=driver loop=$drivers}	
												{if $driver2 == $drivers[driver].id}
													<option selected value='{$drivers[driver].id}'>{$drivers[driver].firstname} {$drivers[driver].lastname}</option>
												{else}
													<option value='{$drivers[driver].id}'>{$drivers[driver].firstname} {$drivers[driver].lastname}</option>
												{/if}
											{/section}
										</select>
									</form>
	                            </div>
	                           	<div class="row">
	                             	<div class="desktop_slider">
	                             		<div class="col-md-12">
	                             			<div class="col-md-1"></div>
	                             			<div class="col-md-10">
	                             				<div style="position: relative;">
	                             					<div style="position:absolute; width:100%; z-index:1"><a href="?site=car_construct"><img src="content/img/car/team/{$tea_id}.png?{$rand}" width="100%"></a></div>
	                             					{if $driver_cou2 != "" }
	                             						<div style="z-index:99;"><img src="content/img/driver/helmet/{$driver_cou2}.png" width="100%"></div>
	                             					{else}
	                             						<div style="z-index:99;"><img src="content/img/driver/helmet/0.png" width="100%"></div>
	                             					{/if}
	                             				</div>
	                             			</div>
	                             		</div>
	                             	</div>
	                             	<div class="mobile_slider">
	                             		<div style="position: relative;">
											<div style="position:absolute; width:100%; z-index:1"><a href="?site=car_construct"><img src="content/img/car/team/{$tea_id}.png?{$rand}" width="100%"></a></div>
											{if $driver_cou2 != "" }
												<div style="z-index:99;"><img src="content/img/driver/helmet/{$driver_cou2}.png" width="100%"></div>
											{else}
												<div style="z-index:99;"><img src="content/img/driver/helmet/0.png" width="100%"></div>
											{/if}
										</div>
	                             	</div>
	                            </div>
	                            <div class="desktop_slider">
									<table class="table table-striped">
										<thead>
											<tr>
												<th></th>
												<th>{translate}tr_car_setting_type{/translate}</th>
												<th>{translate}tr_car_item_shop_skill{/translate}</th>
												<th>{translate}tr_car_item_stock_tuneup{/translate}</th>
												<th>{translate}tr_car_item_stock_condition{/translate}</th>
											</tr>
										</thead>
										<tbody>
										{section name=item loop=$car2}
											<tr>
												<td class="center"><img src="content/img/item/{$car1[item].type}.png" width="50px"/></td>
												<td class="center">{$car2[item].type_name}</td>
												{if $car2[item].part}
													<td class="center">{$car2[item].skill}/{$car2[item].skill_max}</td>
													<td class="center">
													<select name="item_tune" style="width:100px" id="risk{$car2[item].id}" name="risk{$car2[item].id}" {if $not_editable}disabled{/if}>
														{if $car2[item].tuneup == 0}
															<option selected value="0">{translate}tr_car_item_stock_norisk{/translate}</option>
														{else}
															<option value="0">{translate}tr_car_item_stock_norisk{/translate}</option>
														{/if}
														{if $car2[item].tuneup == 25}
															<option selected value="25">{translate}tr_car_item_stock_somerisk{/translate}</option>
														{else}
															<option value="25">{translate}tr_car_item_stock_somerisk{/translate}</option>
														{/if}
														{if $car2[item].tuneup == 50}
															<option selected value="50">{translate}tr_car_item_stock_middlerisk{/translate}</option>
														{else}
															<option value="50">{translate}tr_car_item_stock_middlerisk{/translate}</option>
														{/if}
														{if $car2[item].tuneup == 75}
															<option selected value="75">{translate}tr_car_item_stock_muchrisk{/translate}</option>
														{else}
															<option value="75">{translate}tr_car_item_stock_muchrisk{/translate}</option>
														{/if}
														{if $car2[item].tuneup == 100}
															<option selected value="100">{translate}tr_car_item_stock_verymuchrisk{/translate}</option>
														{else}
															<option value="100">{translate}tr_car_item_stock_verymuchrisk{/translate}</option>
														{/if}
													</select>
													<script type="text/javascript">
														$('#risk{$car2[item].id}').change(function() {
															var value = $('#risk{$car2[item].id}').val();
															$.ajax({
																type: 'post',
																url: '?site=car_setting',
																data: {literal}{{/literal} item_id: {$car2[item].id}, item_tune:value{literal}}{/literal} ,
																success: function(response) {
																	
																}
															});
														});
													</script>
													</td>
													<td class="center">
														{if $car2[item].condition < 33}
															<progress class="progress-red" value="{$car2[item].condition}" max="100"></progress> {$car2[item].condition}%
														{/if}
														{if $car2[item].condition > 32 && $car2[item].condition < 66}
															<progress class="progress-orange" value="{$car2[item].condition}" max="100"></progress> {$car2[item].condition}%
														{/if}
														{if $car2[item].condition > 65}
															<progress class="progress-green" value="{$car2[item].condition}" max="100"></progress> {$car2[item].condition}%
														{/if}
													</td>
												{else}
													<td></td>
													<td></td>
													<td></td>
												{/if}
											</tr>
										{/section}
										</tbody>
									</table>
	                            </div>
	                            <div class="mobile_slider">
									<table class="table">
										<thead>
											<tr>
												<th></th>
												<th>{translate}tr_car_setting_type{/translate}</th>
												<th>{translate}tr_car_item_shop_skill{/translate}</th>
												<th>{translate}tr_car_item_stock_tuneup{/translate}</th>
											</tr>
										</thead>
										<tbody name="{$i = 0}">
										{section name=item loop=$car2}
											<tr{if $i % 2 == 0} class="table_striped_two_lines"{/if}>
												<td class="center" rowspan="2"><img src="content/img/item/{$car2[item].type}.png" width="50px"/></td>
												<td rowspan="2">{$car2[item].type_name}</td>
												{if $car2[item].part}
													<td class="center">{$car2[item].skill}/{$car2[item].skill_max}</td>
													<td class="center">
													<select name="item_tune" style="width:100px" id="mobile_risk{$car2[item].id}" name="risk{$car2[item].id}" {if $not_editable}disabled{/if}>
														{if $car2[item].tuneup == 0}
															<option selected value="0">{translate}tr_car_item_stock_norisk{/translate}</option>
														{else}
															<option value="0">{translate}tr_car_item_stock_norisk{/translate}</option>
														{/if}
														{if $car2[item].tuneup == 25}
															<option selected value="25">{translate}tr_car_item_stock_somerisk{/translate}</option>
														{else}
															<option value="25">{translate}tr_car_item_stock_somerisk{/translate}</option>
														{/if}
														{if $car2[item].tuneup == 50}
															<option selected value="50">{translate}tr_car_item_stock_middlerisk{/translate}</option>
														{else}
															<option value="50">{translate}tr_car_item_stock_middlerisk{/translate}</option>
														{/if}
														{if $car2[item].tuneup == 75}
															<option selected value="75">{translate}tr_car_item_stock_muchrisk{/translate}</option>
														{else}
															<option value="75">{translate}tr_car_item_stock_muchrisk{/translate}</option>
														{/if}
														{if $car2[item].tuneup == 100}
															<option selected value="100">{translate}tr_car_item_stock_verymuchrisk{/translate}</option>
														{else}
															<option value="100">{translate}tr_car_item_stock_verymuchrisk{/translate}</option>
														{/if}
													</select>
													<script type="text/javascript">
														$('#mobile_risk{$car2[item].id}').change(function() {
															var value = $('#mobile_risk{$car2[item].id}').val();
															$.ajax({
																type: 'post',
																url: '?site=car_setting',
																data: {literal}{{/literal} item_id: {$car2[item].id}, item_tune:value{literal}}{/literal} ,
																success: function(response) {
																	
																}
															});
														});
													</script>
													</td>
												{else}
													<td></td>
													<td></td>
												{/if}
											</tr>
											<tr{if $i % 2 == 0} class="table_striped_two_lines"{/if} name="{$i++}">
												{if $car2[item].part}
													<td colspan="2">
														{if $car2[item].condition < 33}
															<progress class="progress-red" value="{$car2[item].condition}" max="100"></progress> {$car2[item].condition}%
														{/if}
														{if $car2[item].condition > 32 && $car2[item].condition < 66}
															<progress class="progress-orange" value="{$car2[item].condition}" max="100"></progress> {$car2[item].condition}%
														{/if}
														{if $car2[item].condition > 65}
															<progress class="progress-green" value="{$car2[item].condition}" max="100"></progress> {$car2[item].condition}%
														{/if}
													</td>
												{else}
													<td colspan="2"></td>
												{/if}
											</tr>
										{/section}
										</tbody>
									</table>
	                            </div>
    						</div>
    						
    						<div id="training_car" class="tab-pane fade">
	                            <div class="row">
									<form action="?site=car_setting" method="post" id="car_driver3" name="car_driver3">
										{translate}tr_car_setting_driver{/translate}: <select name="driver3" onchange="javascript:document.car_driver3.submit()" {if $not_editable}disabled{/if}>
											<option selected value=""></option>
											{section name=driver loop=$drivers}	
												{if $driver3 == $drivers[driver].id}
													<option selected value='{$drivers[driver].id}'>{$drivers[driver].firstname} {$drivers[driver].lastname}</option>
												{else}
													<option value='{$drivers[driver].id}'>{$drivers[driver].firstname} {$drivers[driver].lastname}</option>
												{/if}
											{/section}
										</select>
									</form>
	                            </div>
	                            <div class="row">
	                             	<div class="desktop_slider">
	                             		<div class="col-md-12">
	                             			<div class="col-md-1"></div>
	                             			<div class="col-md-10">
	                             				<div style="position: relative;">
	                             					<div style="position:absolute; width:100%; z-index:1"><a href="?site=car_construct"><img src="content/img/car/team/{$tea_id}.png?{$rand}" width="100%"></a></div>
	                             					{if $driver_cou3 != "" }
	                             						<div style="z-index:99;"><img src="content/img/driver/helmet/{$driver_cou3}.png" width="100%"></div>
	                             					{else}
	                             						<div style="z-index:99;"><img src="content/img/driver/helmet/0.png" width="100%"></div>
	                             					{/if}
	                             				</div>
	                             			</div>
	                             		</div>
	                             	</div>
	                             	<div class="mobile_slider">
	                             		<div style="position: relative;">
											<div style="position:absolute; width:100%; z-index:1"><a href="?site=car_construct"><img src="content/img/car/team/{$tea_id}.png?{$rand}" width="100%"></a></div>
											{if $driver_cou3 != "" }
												<div style="z-index:99;"><img src="content/img/driver/helmet/{$driver_cou3}.png" width="100%"></div>
											{else}
												<div style="z-index:99;"><img src="content/img/driver/helmet/0.png" width="100%"></div>
											{/if}
										</div>
	                             	</div>
	                            </div>
	                            <div class="desktop_slider">
	                            	<div style="text-align: center; color: red; margin-top: 5px">{translate}training_car_message{/translate}</div>
									<table class="table table-striped">
										<thead>
											<tr>
												<th></th>
												<th>{translate}tr_car_setting_type{/translate}</th>
												<th>{translate}tr_car_item_shop_skill{/translate}</th>
												<th>{translate}tr_car_item_stock_condition{/translate}</th>
											</tr>
										</thead>
										<tbody>
										{section name=item loop=$car3}
											<tr>
												<td class="center"><img src="content/img/item/{$car3[item].type}.png" width="50px"/></td>
												<td class="center">{$car3[item].type_name}</td>
												{if $car3[item].part}
													<td class="center">{$car3[item].skill}/{$car3[item].skill_max}</td>
													<td class="center">
														{if $car3[item].condition < 33}
															<progress class="progress-red" value="{$car3[item].condition}" max="100"></progress> {$car3[item].condition}%
														{/if}
														{if $car3[item].condition > 32 && $car3[item].condition < 66}
															<progress class="progress-orange" value="{$car3[item].condition}" max="100"></progress> {$car3[item].condition}%
														{/if}
														{if $car3[item].condition > 65}
															<progress class="progress-green" value="{$car3[item].condition}" max="100"></progress> {$car3[item].condition}%
														{/if}
													</td>
												{else}
													<td></td>
													<td></td>
												{/if}
											</tr>
										{/section}
										</tbody>
									</table>
								</div>
								<div class="mobile_slider">
									<div style="text-align: center; color: red; margin-top: 5px">{translate}training_car_message{/translate}</div>
									<table class="table">
										<thead>
											<tr>
												<th></th>
												<th>{translate}tr_car_setting_type{/translate}</th>
												<th>{translate}tr_car_item_shop_skill{/translate}</th>
											</tr>
										</thead>
										<tbody name="{$i = 0}">
										{section name=item loop=$car3}
											<tr{if $i % 2 == 0} class="table_striped_two_lines"{/if}>
												<td class="center" rowspan="2"><img src="content/img/item/{$car3[item].type}.png" width="50px"/></td>
												<td rowspan="2">{$car3[item].type_name}</td>
												{if $car3[item].part}
													<td class="center">{$car3[item].skill}/{$car3[item].skill_max}</td>
												{else}
													<td></td>
												{/if}
											</tr>
											<tr{if $i % 2 == 0} class="table_striped_two_lines"{/if} name="{$i++}">
												{if $car3[item].part}
													<td colspan="2">
														{if $car3[item].condition < 33}
															<progress class="progress-red" value="{$car3[item].condition}" max="100"></progress> {$car3[item].condition}%
														{/if}
														{if $car3[item].condition > 32 && $car3[item].condition < 66}
															<progress class="progress-orange" value="{$car3[item].condition}" max="100"></progress> {$car3[item].condition}%
														{/if}
														{if $car3[item].condition > 65}
															<progress class="progress-green" value="{$car3[item].condition}" max="100"></progress> {$car3[item].condition}%
														{/if}
													</td>
												{else}
													<td colspan="2"></td>
												{/if}
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
    	</div>
    </div>
</div>