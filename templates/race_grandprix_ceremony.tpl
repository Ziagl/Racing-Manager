<div class="page-content-wrapper">
    <div class="page-content">
    	<div class="row">
    		<div class="col-md-12">
    			<div class="portlet box red">
    				<div class="portlet-title">
    					<div class="caption">{translate}tr_race_grandprix_ceremony_title{/translate}</div>
    					<div class="tools">
    						<form action="?site=race_grandprix_ceremony{$trackinfo}" method="post" style="margin-top: 0px; color:#000">
								<select id="league" name="league" onchange="this.form.submit()">
									<option value="1" {if $league==1}selected{/if}>{translate}tr_league_title{/translate} 1</option>
									<option value="2" {if $league==2}selected{/if}>{translate}tr_league_title{/translate} 2</option>
									<option value="3" {if $league==3}selected{/if}>{translate}tr_league_title{/translate} 3</option>
								</select>
							</form>
    					</div>
    				</div>
    				<div class="portlet-body">
    					<div class="row">
	    					<div class="winner_second col-md-4 col-xs-4">
			                	<div class="row">
				                	2.
			                	</div>
			                	<div class="row">
				                	<img src="content/img/driver/{$winner[1].driver_picture}" width="50px"/>
			                	</div>
			                	<div class="row">
				                	{$winner[1].driver_name}
			                	</div>
			                	<div class="row">
				                	<img src="content/img/flags/{$winner[1].driver_flag}.gif" width="50px"/>
			                	</div>
			                	<div class="row">
			                	{if strlen($winner[1].team_picture) > 1 }
				                	<img class="svg" style="fill: #{$winner[1].color1}" src="content/img/team/{$winner[1].team_picture}" width="50px"/>
				                {else}
							<img src="content/img/car/team/{$winner[1].team_id}.png" width="100px"/>
				                {/if}
			                	</div>
			                	<div class="row">
				                	{$winner[1].team_name}
			                	</div>
			                	<div class="row">
				                	<img src="content/img/flags/{$winner[1].team_flag}.gif" width="50px"/>
			                	</div>
			                </div>
			                
			                <div class="winner_first col-md-4 col-xs-4">
			                	<div class="row">
				                	1.
				                </div>
				                <div class="row">
				                	<img src="content/img/driver/{$winner[0].driver_picture}" width="50px"/>
			                	</div>
			                	<div class="row">
				                	{$winner[0].driver_name}
			                	</div>
			                	<div class="row">
				                	<img src="content/img/flags/{$winner[0].driver_flag}.gif" width="50px"/>
			                	</div>
				                <div class="row">
				                {if strlen($winner[0].team_picture) > 1 }
				                	<img class="svg" style="fill: #{$winner[0].color1}" src="content/img/team/{$winner[0].team_picture}" width="50px"/>
				                {else}
							<img src="content/img/car/team/{$winner[0].team_id}.png" width="100px"/>
				                {/if}
				                </div>
				                <div class="row">
				                	{$winner[0].team_name}
				                </div>
				                <div class="row">
				                	<img src="content/img/flags/{$winner[0].team_flag}.gif" width="50px"/>
				                </div>
			                </div>
			                
			                <div class="winner_third col-md-4 col-xs-4">
			                	<div class="row">
				                	3.
				                </div>
				                <div class="row">
				                	<img src="content/img/driver/{$winner[2].driver_picture}" width="50px"/>
			                	</div>
				                <div class="row">
				                	{$winner[2].driver_name}
				                </div>
				                <div class="row">
				                	<img src="content/img/flags/{$winner[2].driver_flag}.gif" width="50px"/>
				                </div>
				                <div class="row">
				                {if strlen($winner[2].team_picture) > 1 }
				                	<img class="svg" style="fill: #{$winner[2].color1}" src="content/img/team/{$winner[2].team_picture}" width="50px"/>
				                {else}
							<img src="content/img/car/team/{$winner[2].team_id}.png" width="100px"/>
				                {/if}
				                </div>
				                <div class="row">
				                	{$winner[2].team_name}
				                </div>
				                <div class="row">
				                	<img src="content/img/flags/{$winner[2].team_flag}.gif" width="50px"/>
				                </div>
			                </div>
    					</div>
    				</div>
    			</div>
    		</div>
    	</div>
    	<div class="row">
    		<div class="col-md-12">
    			<div class="portlet box red">
    				<div class="portlet-title">
    					<div class="caption">{translate}tr_race_grandprix_ceremony_result{/translate}</div>
    				</div>
    				<div class="portlet-body">
    					<table class="table table-striped">
		                    <thead>
		                    <tr>
		                        <th>{translate}tr_statistic_driver_position{/translate}</th>
		                        <th>{translate}tr_statistic_driver_position_start{/translate}</th>
		                        <th></th>
		                        <th>{translate}tr_statistic_driver_name{/translate}</th>
		                        <th class="mobile_invisible_low">{translate}tr_statistic_driver_team_name{/translate}</th>
		                        <th class="mobile_invisible_low">{translate}tr_statistic_driver_manager_name{/translate}</th>
		                        <th class="mobile_invisible_high">{translate}tr_race_training_setup_tires{/translate}</th>
		                        <th>{translate}tr_race_grandprix_time{/translate}</th>
		                        <th class="mobile_invisible_low">{translate}tr_race_qualification_fastest_time{/translate}</th>
		                        <!--<th class="mobile_invisible_low">{translate}tr_race_grandprix_last_lap{/translate}</th>
		                        <th class="mobile_invisible_high">{translate}tr_race_grandprix_difference_ahead{/translate}</th>
		                        -->
		                        <th class="mobile_invisible_low">{translate}tr_race_grandprix_difference_first{/translate}</th>
		                        <th>{translate}tr_race_grandprix_pitstop{/translate}</th>
		                        <th>{translate}tr_statistic_driver_points{/translate}</th>
		                    </tr>
		                    </thead>
		                    <tbody id="dynamic_list">
		                    {$result}
		                    </tbody>
		                </table>
    				</div>
    			</div>
    		</div>
    	</div>
    </div>
</div>
<!-- START SOUND CODE V4.1 HTML5 -->
<script language="JavaScript" type="text/javascript">
<!--

// PLAYER VARIABLES

var mp3snd = "content/sound/{$winner[0].ins_id}/anthems/{$winner[0].driver_anthem}.mp3";
var oggsnd = "content/sound/{$winner[0].ins_id}/anthems/{$winner[0].driver_anthem}.ogg";

document.write('<audio autoplay="autoplay">');
document.write('<source src="'+mp3snd+'" type="audio/mpeg">');
document.write('<source src="'+oggsnd+'" type="audio/ogg">');
document.write('<!--[if lt IE 9]>');
document.write('<bgsound src="'+mp3snd+'" loop="1">');
document.write('<![endif]-->');
document.write('</audio>');

//-->
</script>
<br>
<!-- END SOUND CODE V4.1 -->