<div class="page-content-wrapper">
    <div class="page-content">
    	<div class="row">
    		<div class="col-md-12">
				<div class="portlet box grey-silver">
    				<div class="portlet-title">
    					<div class="caption">{translate}tr_car_market_title{/translate}</div>
    					<div class="tools">
	    					<div style="float:left; margin-right: 10px">
								<form name="type_select" action="?site=car_item_shop" method="post" style="margin-top: 0px; color:#000">
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
		                        <th>{translate}tr_car_item_shop_value{/translate}</th>
		                        <th>{translate}tr_car_item_shop_skill{/translate}</th>
		                        <th>{translate}tr_car_item_shop_skill_max{/translate}</th>
		                        <th>{translate}tr_car_item_shop_in_stock{/translate}</th>
		                        <th>{translate}tr_driver_setting_action{/translate}</th>
		                    </tr>
		                    </thead>
		                    <tbody>
		                    {section name=item loop=$items}
		                        <tr>
		                        	<td><img src="content/img/item/{$items[item].type}.png" width="50px"/></td>
		                            <td>{$items[item].name}</td>
		                            <td align="right"><span class="nowrapping">{$items[item].value} {translate}tr_global_currency_symbol{/translate}</span></td>
		                            <td align="center">{$items[item].skill}</td>
		                            <td align="center">{$items[item].skill_max}</td>
		                            <td align="center">{$items[item].in_stock}</td>
		                            <td>
		                            	{if $items[item].in_stock < 5}
											<form action="?site=car_item_shop" method="post">
												<input type="hidden" id="item_id" name="item_id" value="{$items[item].id}"/>
												<input type="button" class="btn btn-small btn-success confirm" {if $items[item].not_buyable}disabled=""{/if} data-text="{translate}tr_car_item_shop_buy_question{/translate}" data-confirm-button="{translate}yes{/translate}" data-cancel-button="{translate}no{/translate}" value="{translate}tr_button_buy{/translate}"/>
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
		                        <th>{translate}tr_car_item_shop_value{/translate}</th>
		                        <th>{translate}tr_car_item_shop_skill{/translate}</th>
		                        <th>{translate}tr_car_item_shop_in_stock{/translate}</th>
		                        <th>{translate}tr_driver_setting_action{/translate}</th>
		                    </tr>
		                    </thead>
		                    <tbody>
		                    {section name=item loop=$items}
		                        <tr>
		                            <td>{$items[item].name}</td>
		                            <td align="right"><span class="nowrapping">{$items[item].value} {translate}tr_global_currency_symbol{/translate}</span></td>
		                            <td align="center">{$items[item].skill}/{$items[item].skill_max}</td>
		                            <td align="center">{$items[item].in_stock}</td>
		                            <td>
		                            	{if $items[item].in_stock < 5}
											<form action="?site=car_item_shop" method="post">
												<input type="hidden" id="item_id" name="item_id" value="{$items[item].id}"/>
												<input type="button" class="btn btn-small btn-success confirm" {if $items[item].not_buyable}disabled=""{/if} data-text="{translate}tr_car_item_shop_buy_question{/translate}" data-confirm-button="{translate}yes{/translate}" data-cancel-button="{translate}no{/translate}" value="{translate}tr_button_buy{/translate}"/>
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