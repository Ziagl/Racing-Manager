<div class="page-content-wrapper">
    <div class="page-content">
    	<div class="row">
    		<div class="col-md-12">
    			<div class="portlet box blue-hoki">
    				<div class="portlet-title">
    					<div class="caption">{translate}tr_statistic_user_title{/translate}</div>
    				</div>
    				<div class="portlet-body">
    					<table class="table table-striped">
		                    <thead>
		                    <tr>
		                        <th>{translate}tr_statistic_driver_position{/translate}</th>
		                        <th>{translate}tr_statistic_driver_picture{/translate}</th>
		                        <th>{translate}tr_statistic_driver_name{/translate}</th>
		                        <th>{translate}tr_statistic_driver_team_name{/translate}</th>
		                        <th>{translate}tr_statistic_driver_points{/translate}</th>
		                    </tr>
		                    </thead>
		                    <tbody>
		                    {$i=1}
		                    {section name=user loop=$users}
		                        <tr {if $users[user].id == $user_id}class="line_highlight"{/if}>
		                            <td {if $users[user].id == $user_id}class="line_highlight"{/if}>{$i++} {$users[user].change}</td>
		                            <td><img src="content/img/{$users[user].picture}" width="50px"/></td>
		                            <td><a href="?site=userinfo&id={$users[user].id}">{$users[user].name}</a></td>
		                            <td style="font-weight:bold"><a style="color:#{$users[user].color1}" href="?site=teaminfo&id={$users[user].tea_id}">{$users[user].team}</a></td>
		                            <td align="right">{$users[user].points}</td>
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