<div class="page-content-wrapper">
    <div class="page-content">
    	<div class="row">
    		<div class="col-md-12">
    			<div class="portlet box blue-hoki">
    				<div class="portlet-title">
    					<div class="caption">{translate}tr_statistic_track_title{/translate}</div>
    				</div>
    				<div class="portlet-body">
						<table class="table table-striped">
		                    <thead>
		                    <tr>
		                        <th class='mobile_invisible_high'>{translate}tr_statistic_driver_position{/translate}</th>
		                        <th class='mobile_invisible_high'>{translate}tr_statistic_driver_picture{/translate}</th>
		                        <th>{translate}tr_statistic_driver_name{/translate}</th>
		                        <th>{translate}tr_finance_detail_date{/translate}</th>
		                        <th class='mobile_invisible_high' colspan="2">{translate}tr_driver_setting_country{/translate}</th>
		                        {if $league == 1}
		                        	<th>{translate}tr_statistic_track_winner{/translate} {translate}tr_league_title{/translate} 1</th>
		                        {else}
		                        	<th class='mobile_invisible_high'>{translate}tr_statistic_track_winner{/translate} {translate}tr_league_title{/translate} 1</th>
		                        {/if}
		                        {if $league == 2}
		                        	<th>{translate}tr_statistic_track_winner{/translate} {translate}tr_league_title{/translate} 2</th>
		                        {else}
		                        	<th class='mobile_invisible_high'>{translate}tr_statistic_track_winner{/translate} {translate}tr_league_title{/translate} 2</th>
		                        {/if}
		                        {if $league == 3}
		                       		<th>{translate}tr_statistic_track_winner{/translate} {translate}tr_league_title{/translate} 3</th>
		                        {else}
		                        	<th class='mobile_invisible_high'>{translate}tr_statistic_track_winner{/translate} {translate}tr_league_title{/translate} 3</th>
		                        {/if}
		                    </tr>
		                    </thead>
		                    <tbody>
		                    {$i=1}
		                    {section name=track loop=$tracks}
		                        <tr>
		                            <td class='mobile_invisible_high'>{$i++}</td>
		                            <td class='mobile_invisible_high'><img src="content/img/tracks/{$tracks[track].picture}" width="50px"/></td>
		                            <td>{$tracks[track].name}</td>
		                            <td>
		                            {if $tracks[track].last_race == null}
		                            	{$tracks[track].date}
		                            {else}
		                            	<a href="?site=race_grandprix_ceremony&track={$tracks[track].id}">Ergebnis</a>
		                            {/if}
		                            </td>
		                            <td class='mobile_invisible_high'><img src="content/img/flags/{$tracks[track].country_picture}.gif" width="50px"/></td>
		                            <td class='mobile_invisible_high'>{$tracks[track].country}</td>
		                            {if $league == 1}
										<td>{$tracks[track].f1_last_winner_info}</td>
									{else}
										<td class='mobile_invisible_high'>{$tracks[track].f1_last_winner_info}</td>
									{/if}
									{if $league == 2}
										<td>{$tracks[track].f2_last_winner_info}</td>
									{else}
										<td class='mobile_invisible_high'>{$tracks[track].f2_last_winner_info}</td>
									{/if}
									{if $league == 3}
										<td>{$tracks[track].f3_last_winner_info}</td>
									{else}
										<td class='mobile_invisible_high'>{$tracks[track].f3_last_winner_info}</td>
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
