<div class="page-content-wrapper">
    <div class="page-content">
    	<div class="row">
    		<div class="col-md-12">
				<div class="portlet box yellow-saffron">
    				<div class="portlet-title">
    					<div class="caption">{translate}tr_finance_setting_all{/translate}</div>
    				</div>
    				<div class="portlet-body">
    					<div class="row">
    						<div class="col-md-6">
    							<table class="table table-striped">
		                            <thead>
		                                <tr>
		                                    <th colspan="2" style="text-align:center;">{translate}tr_finance_setting_in{/translate}</th>
		                                </tr>
		                            </thead>
		                            <tbody>
		                                <tr>
		                                    <td>{translate}tr_finance_setting_fix{/translate}</td>
		                                    <td align="right">{$in_fix} {translate}tr_global_currency_symbol{/translate}</td>
		                                </tr>
		                                <tr>
		                                    <td>{translate}tr_finance_setting_var{/translate}</td>
		                                    <td align="right">{$in_var} {translate}tr_global_currency_symbol{/translate}</td>
		                                </tr>
		                                <tr>
		                                    <td>{translate}tr_finance_setting_all{/translate}</td>
		                                    <td align="right">{$sum_in} {translate}tr_global_currency_symbol{/translate}</td>
		                                </tr>
		                            </tbody>
		                        </table>
    						</div>
    						<div class="col-md-6">
    							<table class="table table-striped">
		                            <thead>
		                                <tr>
		                                    <th colspan="2" style="text-align:center;">{translate}tr_finance_setting_out{/translate}</th>
		                                </tr>
		                            </thead>
		                            <tbody>
		                                <tr>
		                                    <td>{translate}tr_finance_setting_fix{/translate}</td>
		                                    <td align="right">{$out_fix} {translate}tr_global_currency_symbol{/translate}</td>
		                                </tr>
		                                <tr>
		                                    <td>{translate}tr_finance_setting_var{/translate}</td>
		                                    <td align="right">{$out_var} {translate}tr_global_currency_symbol{/translate}</td>
		                                </tr>
		                                <tr>
		                                    <td>{translate}tr_finance_setting_all{/translate}</td>
		                                    <td align="right">{$sum_out} {translate}tr_global_currency_symbol{/translate}</td>
		                                </tr>
		                            </tbody>
		                        </table>
    						</div>
    					</div>
    					<div class="row">
    						<div class="col-md-12" style="text-align: center">
		                        {translate}tr_finance_setting_current_value{/translate}:
		                        {if $current_budget >= 0}
		                            <span class="green">{$current_budget}</span>
		                        {else}
		                            <span class="red">{$current_budget}</span>
		                        {/if}
		                        {translate}tr_global_currency_symbol{/translate}
		                    </div>
    					</div>
    				</div>
				</div>
    		</div>
    	</div>
    	
		<div class="row">
    		<div class="col-md-12">
				<div class="portlet box yellow-saffron">
    				<div class="portlet-title">
    					<div class="caption">{translate}tr_finance_setting_fix{/translate}</div>
    				</div>
    				<div class="portlet-body">
						<div class="row">
							<div class="col-md-6">
								<table class="table table-striped">
			                        <thead>
			                            <tr>
			                                <th colspan="2" style="text-align:center;">{translate}tr_finance_setting_in{/translate}</th>
			                            </tr>
			                        </thead>
			                        <tbody>
			                            <tr>
			                                <td>{translate}tr_finance_setting_driver{/translate}</td>
			                                <td align="right">{$in_driver_fix} {translate}tr_global_currency_symbol{/translate}</td>
			                            </tr>
			                            <tr>
			                                <td>{translate}tr_finance_setting_mechanic{/translate}</td>
			                                <td align="right">{$in_mechanic_fix} {translate}tr_global_currency_symbol{/translate}</td>
			                            </tr>
			                            <tr>
			                                <td>{translate}tr_finance_setting_items{/translate}</td>
			                                <td align="right">{$in_items_fix} {translate}tr_global_currency_symbol{/translate}</td>
			                            </tr>
			                            <tr>
			                                <td>{translate}tr_finance_setting_sponsor{/translate}</td>
			                                <td align="right">{$in_sponsor_fix} {translate}tr_global_currency_symbol{/translate}</td>
			                            </tr>
			                            <tr>
			                                <td>{translate}tr_finance_setting_price{/translate}</td>
			                                <td align="right">{$in_price_fix} {translate}tr_global_currency_symbol{/translate}</td>
			                            </tr>
			                            <tr>
			                                <td>{translate}tr_finance_setting_various{/translate}</td>
			                                <td align="right">{$in_other_fix} {translate}tr_global_currency_symbol{/translate}</td>
			                            </tr>
			                        </tbody>
			                    </table>
							</div>
							
							<div class="col-md-6">
								<table class="table table-striped">
			                        <thead>
			                            <tr>
			                                <th colspan="2" style="text-align:center;">{translate}tr_finance_setting_out{/translate}</th>
			                            </tr>
			                        </thead>
			                        <tbody>
			                            <tr>
			                                <td>{translate}tr_finance_setting_driver{/translate}</td>
			                                <td align="right">{$out_driver_fix} {translate}tr_global_currency_symbol{/translate}</td>
			                            </tr>
			                            <tr>
			                                <td>{translate}tr_finance_setting_mechanic{/translate}</td>
			                                <td align="right">{$out_mechanic_fix} {translate}tr_global_currency_symbol{/translate}</td>
			                            </tr>
			                            <tr>
			                                <td>{translate}tr_finance_setting_items{/translate}</td>
			                                <td align="right">{$out_items_fix} {translate}tr_global_currency_symbol{/translate}</td>
			                            </tr>
			                            <tr>
			                                <td>{translate}tr_finance_setting_various{/translate}</td>
			                                <td align="right">{$out_other_fix} {translate}tr_global_currency_symbol{/translate}</td>
			                            </tr>
			                        </tbody>
			                    </table>
							</div>
						</div>
    				</div>
				</div>
    		</div>
		</div>
    				
		<div class="row">
    		<div class="col-md-12">
				<div class="portlet box yellow-saffron">
    				<div class="portlet-title">
    					<div class="caption">{translate}tr_finance_setting_var{/translate}</div>
    				</div>
    				<div class="portlet-body">
						<div class="row">
							<div class="col-md-6">
								<table class="table table-striped">
			                        <thead>
			                        <tr>
			                            <th colspan="2" style="text-align:center;">{translate}tr_finance_setting_in{/translate}</th>
			                        </tr>
			                        </thead>
			                        <tbody>
			                        <tr>
			                            <td>{translate}tr_finance_setting_sponsor{/translate}</td>
			                            <td align="right">{$in_sponsor_var} {translate}tr_global_currency_symbol{/translate}</td>
			                        </tr>
			                        <tr>
			                            <td>{translate}tr_finance_setting_price{/translate}</td>
			                            <td align="right">{$in_price_var} {translate}tr_global_currency_symbol{/translate}</td>
			                        </tr>
			                        <tr>
			                            <td>{translate}tr_finance_setting_various{/translate}</td>
			                            <td align="right">{$in_other_var} {translate}tr_global_currency_symbol{/translate}</td>
			                        </tr>
			                        </tbody>
			                    </table>
							</div>
							
							<div class="col-md-6">
								<table class="table table-striped">
			                        <thead>
			                        <tr>
			                            <th colspan="2" style="text-align:center;">{translate}tr_finance_setting_out{/translate}</th>
			                        </tr>
			                        </thead>
			                        <tbody>
			                        <tr>
			                            <td>{translate}tr_finance_setting_driver{/translate}</td>
			                            <td align="right">{$out_driver_var} {translate}tr_global_currency_symbol{/translate}</td>
			                        </tr>
			                        <tr>
			                            <td>{translate}tr_finance_setting_mechanic{/translate}</td>
			                            <td align="right">{$out_mechanic_var} {translate}tr_global_currency_symbol{/translate}</td>
			                        </tr>
			                        <tr>
			                            <td>{translate}tr_finance_setting_various{/translate}</td>
			                            <td align="right">{$out_other_var} {translate}tr_global_currency_symbol{/translate}</td>
			                        </tr>
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