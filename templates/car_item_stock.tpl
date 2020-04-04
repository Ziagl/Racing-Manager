<div class="page-content-wrapper">
    <div class="page-content">
    	<div class="row">
    		<div class="col-md-12">
				<div class="portlet box grey-silver">
    				<div class="portlet-title">
    					<div class="caption">{translate}tr_car_item_stock_title{/translate}</div>
    					<div class="tools">
	    					<div style="float:left; margin-right: 10px">
	    						<form name="car_select" action="?site=car_item_stock" method="post" style="margin-top: 0px; color:#000">
									<select name="car" onchange="javascript:document.car_select.submit()">
										<option{if $car < 0} selected{/if} value="-1">{translate}tr_all{/translate}</option>
										<option{if $car == 1} selected{/if} value="1">{translate}race_car{/translate} 1</option>
										<option{if $car == 2} selected{/if} value="2">{translate}race_car{/translate} 2</option>
										<option{if $car == 3} selected{/if} value="3">{translate}training_car{/translate}</option>
									</select>
								</form>
							</div>
							<div style="float:left">
	    						<form name="type_select" action="?site=car_item_stock" method="post" style="margin-top: 0px; color:#000">
									<select name="type" onchange="javascript:document.type_select.submit()">
										<option selected value="-1">{translate}tr_all{/translate}</option>
										{for $i = 0 to count($item_list) - 1 }
											{if $type == $i}
												<option selected value="{$i}">{translate}tr_{$item_list[$i]}{/translate}</option>
											{else}
												<option value="{$i}">{translate}tr_{$item_list[$i]}{/translate}</option>
											{/if}
										{/for}
									</select>
								</form>
	    					</div>
	    				</div>
    				</div>
    				<div class="portlet-body desktop_slider">
		                <table class="table table-striped">
		                    <thead>
		                    <tr>
		                    	<th></th>
		                        <th>{translate}tr_statistic_driver_name{/translate}</th>
		                        <th>{translate}tr_car_item_shop_skill{/translate}</th>
		                        <th>{translate}tr_car_item_stock_condition{/translate}</th>
		                        <th>{translate}tr_car_setting_title{/translate}</th>
		                        <th>{translate}tr_driver_setting_action{/translate}</th>
		                    </tr>
		                    </thead>
		                    <tbody>
		                    {if count($items) > 0}
		                    	<tr>
		                    		<td></td>
		                    		<td></td>
		                    		<td></td>
		                    		<td></td>
		                    		<td></td>
		                    		<td>
		                    			<form action="?site=car_item_stock" method="post">
											<input type="hidden" id="item_repair_all" name="item_repair_all" value="1"/>
											<input type="submit" class="btn btn-small btn-danger confirm" data-text="{translate}tr_car_item_stock_repair_question{/translate}" data-confirm-button="{translate}yes{/translate}" data-cancel-button="{translate}no{/translate}" value="{translate}tr_button_repair_all{/translate} ({$repair_all} {translate}tr_global_currency_symbol{/translate})" {if $repair_all_notavailable}disabled{/if}/>
										</form>
		                    		</td>
		                    	</tr>
		                    {/if}
		                    {section name=item loop=$items}
		                        <tr>
		                        	<td><img src="content/img/item/{$items[item].type}.png" width="50px"/></td>
		                            <td>{$items[item].name}</td>
		                            <td>{$items[item].skill}-{$items[item].skill_max}</td>
		                            <td class="center">
										{if $items[item].condition < 33}
											<progress class="progress-red" value="{$items[item].condition}" max="100"></progress> {$items[item].condition}%
										{/if}
										{if $items[item].condition > 32 && $items[item].condition < 66}
											<progress class="progress-orange" value="{$items[item].condition}" max="100"></progress> {$items[item].condition}%
										{/if}
										{if $items[item].condition > 65}
											<progress class="progress-green" value="{$items[item].condition}" max="100"></progress> {$items[item].condition}%
										{/if}
									</td>
		                            <td>
		                                {if $items[item].car_number != null}
		                                	{if $items[item].car_number < 3}
		                                    	{translate}race_car{/translate} {$items[item].car_number}
		                                    {else}
		                                    	{translate}training_car{/translate}
		                                    {/if}
		                                {else}
		                                	{if $items[item].car1 == false}
												<form action="?site=car_item_stock" method="post">
													<input type="hidden" name="car_number" value="1"/>
													<input type="hidden" name="item_id" value="{$items[item].id}"/>
													<input type="submit" class="btn btn-small btn-success" value="{translate}race_car{/translate} 1" {if $not_editable}disabled{/if}/>
												</form>
		                                    {/if}
		                                    {if $items[item].car2 == false}
												<form action="?site=car_item_stock" method="post">
													<input type="hidden" name="car_number" value="2"/>
													<input type="hidden" name="item_id" value="{$items[item].id}"/>
													<input type="submit" class="btn btn-small btn-success" value="{translate}race_car{/translate} 2" {if $not_editable}disabled{/if}/>
												</form>
		                                    {/if}
		                                    {if $items[item].car3 == false}
												{if $items[item].class == 0}
													<form action="?site=car_item_stock" method="post">
														<input type="hidden" name="car_number" value="3"/>
														<input type="hidden" name="item_id" value="{$items[item].id}"/>
														<input type="submit" class="btn btn-small btn-success" value="{translate}training_car{/translate}" {if $not_editable}disabled{/if}/>
													</form>
												{/if}
		                                    {/if}
		                                {/if}
		                            </td>
		                            <td class="center">
		                            	{if $items[item].car_number != null}
		                                    <form action="?site=car_item_stock" method="post">
		                                        <input type="hidden" name="car_number" value="0"/>
		                                        <input type="hidden" name="item_id" value="{$items[item].id}"/>
		                                        <input type="submit" class="btn btn-small btn-warning" value="{translate}tr_button_remove{/translate}" {if $not_editable}disabled{/if}/>
		                                    </form>
		                                {else}
											<form action="?site=car_item_stock" method="post">
												<input type="hidden" id="item_id" name="item_id" value="{$items[item].id}"/>
												<input type="hidden" id="item_sell" name="item_sell" value="1"/>
												<input type="button" class="btn btn-small btn-danger confirm" data-text="{translate}tr_car_item_stock_sell_question{/translate}" data-confirm-button="{translate}yes{/translate}" data-cancel-button="{translate}no{/translate}" value="{translate}tr_button_sell{/translate} ({$items[item].sell_value} {translate}tr_global_currency_symbol{/translate})"/>
											</form>
		                                {/if}
		                                {if $items[item].repair_value > 0}
											<form action="?site=car_item_stock" method="post">
												<input type="hidden" id="item_id" name="item_id" value="{$items[item].id}"/>
												<input type="hidden" id="item_repair" name="item_repair" value="1"/>
												<input type="submit" class="btn btn-small btn-danger" value="{translate}tr_button_repair{/translate} ({$items[item].repair_value} {translate}tr_global_currency_symbol{/translate})" {if $items[item].notrepairable}disabled{/if}/>
											</form>
										{/if}
		                            </td>
		                        </tr>
		                    {/section}
		                    </tbody>
		                </table>
    				</div>
    				<div class="portlet-body mobile_slider">
		                <table class="table table-striped">
		                    <thead>
		                    <tr>
		                        <th>{translate}tr_statistic_driver_name{/translate}</th>
		                        <th>{translate}tr_car_item_shop_skill{/translate}</th>
		                        <th>{translate}tr_car_item_stock_condition{/translate}</th>
		                    </tr>
		                    </thead>
		                    <tbody name="{$i = 0}">
		                    {if count($items) > 0}
		                    	<tr>
		                    		<td></td>
		                    		<td colspan="2">
		                    			<form action="?site=car_item_stock" method="post">
											<input type="hidden" id="item_repair_all" name="item_repair_all" value="1"/>
											<input type="submit" class="btn btn-small btn-danger confirm" data-text="{translate}tr_car_item_stock_repair_question{/translate}" data-confirm-button="{translate}yes{/translate}" data-cancel-button="{translate}no{/translate}" value="{translate}tr_button_repair_all{/translate} ({$repair_all} {translate}tr_global_currency_symbol{/translate})" {if $repair_all_notavailable}disabled{/if}/>
										</form>
		                    		</td>
		                    	</tr>
		                    {/if}
		                    {section name=item loop=$items}
		                        <tr{if $i % 2 == 0} class="table_striped_two_lines"{/if}>
		                            <td rowspan="2">{$items[item].name}</td>
		                            <td>{$items[item].skill}-{$items[item].skill_max}</td>
		                            <td>
		                            	{if $items[item].condition < 33}
											<progress class="progress-red" value="{$items[item].condition}" max="100"></progress> {$items[item].condition}%
										{/if}
										{if $items[item].condition > 32 && $items[item].condition < 66}
											<progress class="progress-orange" value="{$items[item].condition}" max="100"></progress> {$items[item].condition}%
										{/if}
										{if $items[item].condition > 65}
											<progress class="progress-green" value="{$items[item].condition}" max="100"></progress> {$items[item].condition}%
										{/if}
		                            </td>
		                        </tr>
		                        <tr{if $i % 2 == 0} class="table_striped_two_lines"{/if} name="{$i++}">
		                            <td colspan="2">
		                            	{if $items[item].car_number != null}
		                                    {if $items[item].car_number < 3}
		                                    	{translate}race_car{/translate} {$items[item].car_number}
		                                    {else}
		                                    	{translate}training_car{/translate}
		                                    {/if}
		                                {else}
		                                	{if $items[item].car1 == false}
												<form action="?site=car_item_stock" method="post" style="float:left">
													<input type="hidden" name="car_number" value="1"/>
													<input type="hidden" name="item_id" value="{$items[item].id}"/>
													<input type="submit" class="btn btn-small btn-success" value="{translate}race_car{/translate} 1" {if $not_editable}disabled{/if}/>
												</form>
											{/if}
											{if $items[item].car2 == false}
												<form action="?site=car_item_stock" method="post" style="float:left">
													<input type="hidden" name="car_number" value="2"/>
													<input type="hidden" name="item_id" value="{$items[item].id}"/>
													<input type="submit" class="btn btn-small btn-success" value="{translate}race_car{/translate} 2" {if $not_editable}disabled{/if}/>
												</form>
		                                    {/if}
		                                    {if $items[item].car3 == false}
												{if $items[item].class == 0}
													<form action="?site=car_item_stock" method="post" style="float:left">
														<input type="hidden" name="car_number" value="3"/>
														<input type="hidden" name="item_id" value="{$items[item].id}"/>
														<input type="submit" class="btn btn-small btn-success" value="{translate}training_car{/translate}" {if $not_editable}disabled{/if}/>
													</form>
												{/if}
		                                    {/if}
		                                {/if}
		                            	{if $items[item].car_number != null}
		                            		<form action="?site=car_item_stock" method="post">
		                                        <input type="hidden" name="car_number" value="0"/>
		                                        <input type="hidden" name="item_id" value="{$items[item].id}"/>
		                                        <input type="submit" class="btn btn-small btn-warning" value="{translate}tr_button_remove{/translate}" {if $not_editable}disabled{/if}/>
		                                    </form>
		                            	{else}
		                                    <form action="?site=car_item_stock" method="post">
		                                        <input type="hidden" id="item_id" name="item_id" value="{$items[item].id}"/>
		                                        <input type="hidden" id="item_sell" name="item_sell" value="1"/>
		                                        <input type="button" class="btn btn-small btn-danger confirm" data-text="{translate}tr_car_item_stock_sell_question{/translate}" data-confirm-button="{translate}yes{/translate}" data-cancel-button="{translate}no{/translate}" value="{translate}tr_button_sell{/translate} ({$items[item].sell_value} {translate}tr_global_currency_symbol{/translate})"/>
		                                    </form>
		                                {/if}
		                                {if $items[item].repair_value > 0}
											<form action="?site=car_item_stock" method="post">
												<input type="hidden" id="item_id" name="item_id" value="{$items[item].id}"/>
												<input type="hidden" id="item_repair" name="item_repair" value="1"/>
												<input type="submit" class="btn btn-small btn-danger" value="{translate}tr_button_repair{/translate} ({$items[item].repair_value} {translate}tr_global_currency_symbol{/translate})" {if $items[item].notrepairable}disabled{/if}/>
											</form>
										{/if}
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