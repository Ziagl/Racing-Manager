<!-- BEGIN CONTENT -->
<div class="page-content-wrapper">
    <div class="page-content">
    	<div class="row">
    		<div class="col-md-12">
				<div class="portlet box yellow-saffron">
    				<div class="portlet-title">
    					<div class="caption">{translate}tr_finance_detail{/translate}</div>
    				</div>
    				<div class="portlet-body">
    					<table class="table table-striped">
		                    <thead>
		                    <tr>
		                        <th>{translate}tr_finance_detail_date{/translate}</th>
		                        <th>{translate}tr_finance_detail_text{/translate}</th>
		                        <th>{translate}tr_finance_setting_in{/translate}</th>
		                        <th>{translate}tr_finance_setting_out{/translate}</th>
		                    </tr>
		                    </thead>
		                    <tbody>
		                    {$i=1}
		                    {section name=row loop=$rows}
		                        <tr>
		                            <td>{$rows[row].date}</td>
		                            <td>{$rows[row].label}</td>
		                            <td align="right">
		                                {if isset($rows[row].in_value)}
		                                    {$rows[row].in_value} {translate}tr_global_currency_symbol{/translate}
		                                {/if}
		                            </td>
		                            <td align="right">
		                                {if isset($rows[row].out_value)}
		                                    {$rows[row].out_value} {translate}tr_global_currency_symbol{/translate}
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