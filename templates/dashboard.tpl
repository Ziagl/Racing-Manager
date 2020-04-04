<script>
	function countdown(time,id,done){
	  t = time;
	  d = Math.floor(t/(60*60*24)); 
	  h = Math.floor(t/(60*60)) % 24;
	 
	  m = Math.floor(t/60) %60;
	  s = t %60;
	  d = (d >  0) ? d+"d ":"";
	  h = (h < 10) ? "0"+h : h;
	  m = (m < 10) ? "0"+m : m;
	  s = (s < 10) ? "0"+s : s;
	  strZeit =d + h + ":" + m + ":" + s;

	  if(time > 0)
	  {
		window.setTimeout('countdown('+ --time+',\''+id+'\')',1000,done);
	  }
	  else
	  {
		strZeit = done;
	  }
	  if(typeof strZeit == 'undefined')
		strZeit = "00:00:00";
	  document.getElementById(id).innerHTML = strZeit;
	}
</script>
<div class="page-content-wrapper">
    <div class="page-content">
    	<div class="row">
    		<div class="col-md-12">
    			<div class="portlet box blue-steel">
    				<div class="portlet-title">
    					<div class="caption">{translate}dashboard_title{/translate}</div>
    				</div>
    				<div class="portlet-body">
    					{if $randomevent_message != null}
    					<div id="responsive" class="modal fade" aria-hidden="true" tabindex="-1">
							<div class="modal-dialog">
								<div class="modal-content">
									<div class="modal-header">
										<button class="close" aria-hidden="true" data-dismiss="modal" type="button"></button>
										<h4 class="modal-title">{translate}tr_random_event{/translate}</h4>
									</div>
									<div class="modal-body">
										{$randomevent_message}
									</div>
									<div class="modal-footer">
										<button class="btn red" data-dismiss="modal" type="button">{translate}tr_button_ok{/translate}</button>
									</div>
								</div>
							</div>
						</div>
						<script type="text/javascript">
							$(window).load(function(){
								$('#responsive').modal('show');
							});
						</script>
						{/if}
										
    					<h1 style="margin-top: 0px; text-align: center">{$race_name} {$instance.current_race} / {$number_races}</h1>
						<div class="row">
							<div class="col-md-4 col-xs-12 padding-side">
								<div class="dashboard-stat grey">
									<div class="visual">
										<i class="fa fa-road"></i>
									</div>
									<div class="details">
										<div class="number"> {if $date_qualification > 0}<div id="quali"><script>countdown({$date_qualification},'quali','{translate}Done{/translate}');</script></div>{else}<a href="?site=race_qualification">{translate}dashboard_view{/translate}</a>{/if} </div>
										<div class="desc"> {translate}tr_menu_qualification{/translate} </div>
									</div>
									<a class="more" href="?site=race_qualification">
										{translate}tr_menu_qualification{/translate}
										<i class="m-icon-swapright m-icon-white"></i>
									</a>
								</div>
							</div>
							<div class="col-md-4 col-xs-12 padding-side">
								<div class="dashboard-stat grey">
									<div class="visual">
										<i class="fa fa-trophy"></i>
									</div>
									<div class="details">
										<div class="number"> {if $date_race > 0}<div id="race"><script>countdown({$date_race},'race','{translate}Done{/translate}');</script></div>{else}<a href="?site=race_grandprix">{translate}dashboard_view{/translate}</a>{/if} </div>
										<div class="desc"> {translate}tr_menu_grandprix{/translate} </div>
									</div>
									<a class="more" href="?site=race_grandprix">
										{translate}tr_menu_grandprix{/translate}
										<i class="m-icon-swapright m-icon-white"></i>
									</a>
								</div>
							</div>
							<div class="col-md-4 col-xs-12 padding-side">
								<div class="dashboard-stat grey">
									<div class="visual">
										<i class="fa fa-clock-o"></i>
									</div>
									<div class="details">
										<div class="number"> {if $date_training_next > 0}<div id="training"><script>countdown({$date_training_next},'training','{translate}Done{/translate}');</script></div>{else}<div id="training"><script>countdown({$date_race} + ({$params['post_saison']} * 604800),'training','{translate}Done{/translate}');</script></div>{/if} </div>
										<div class="desc"> {if $date_training_next > 0}{translate}next_race{/translate}{else}{translate}next_season{/translate}{/if} </div>
									</div>
									<a class="more" href="?site=race_training">
										{translate}tr_menu_training{/translate}
										<i class="m-icon-swapright m-icon-white"></i>
									</a>
								</div>
							</div>
						</div>
						<br><br>
						<div class="row">
							{section name=driver loop=$driver_ranking}
								<div class="col-md-4 col-xs-12 padding-side">
									<div class="dashboard-stat green">
										<div class="visual">
											<img src="content/img/driver/{$driver_ranking[driver].picture}" class="fa" width="125px" style="margin-top: -10px; margin-left: -20px"/>
										</div>
										<div class="details">
											<div class="number"> {if $driver_ranking[driver]['rank'].ranking != -1}{$driver_ranking[driver]['rank'].ranking}{else}-{/if} ({if $driver_ranking[driver]['rank_last'].ranking != -1}{$driver_ranking[driver]['rank_last'].ranking}{else}-{/if}) </div>
											<div class="desc"> {$driver_ranking[driver].firstname} {$driver_ranking[driver].lastname} </div>
										</div>
										<a class="more" href="?site=statistic_driver">
											{translate}tr_statistic_driver_title{/translate}
											<i class="m-icon-swapright m-icon-white"></i>
										</a>
									</div>
								</div>
							{/section}
						</div>
						<br><br>
						<div class="row">
							<div class="col-md-4 col-xs-12 padding-side">
								<div class="dashboard-stat blue">
									<div class="visual">
										{if strlen($team.picture) > 1 }
											<img class="svg" style="margin-top: -10px; margin-left: -20px; fill: #{$team.color1}" src="content/img/team/{$team.picture}" width="125px"/>
										{else}
											<img src="content/img/car/team/{$team.id}.png" width="150px" style="margin-top: 10px; margin-left: -20px">
										{/if}
									</div>
									<div class="details">
										<div class="number"> {if $team['rank'].ranking != -1}{$team['rank'].ranking}{else}-{/if} ({if $team['rank_last'].ranking != -1}{$team['rank_last'].ranking}{else}-{/if}) </div>
										<div class="desc"> 
											{translate}aim_of_the_season{/translate}: 
											{if $team.goal == 0}{translate}world_champion{/translate}{/if}
											{if $team.goal == 1}{translate}win_some_races{/translate}{/if}
											{if $team.goal == 2}{translate}solid_midfield{/translate}{/if}
											{if $team.goal == 3}{translate}avoid_relegation{/translate}{/if}
										</div>
									</div>
									<a class="more" href="?site=statistic_team">
										{translate}tr_statistic_team_title{/translate}
										<i class="m-icon-swapright m-icon-white"></i>
									</a>
								</div>
							</div>
							<div class="col-md-4 col-xs-12 padding-side">
								<div class="dashboard-stat red">
									<div class="visual">
										{if $user.picture == null}
											<i class="fa fa-play-circle"></i>
										{else}
											<img src="content/img/{$user.picture}" class="fa" width="125px" style="margin-top: -10px; margin-left: -20px"/>
										{/if}
									</div>
									<div class="details">
										<div class="number"> {if $user['rank'].ranking != -1}{$user['rank'].ranking}{else}-{/if} ({if $user['rank_last'].ranking != -1}{$user['rank_last'].ranking}{else}-{/if}) </div>
										<div class="desc"> {$user['name']} </div>
									</div>
									<a class="more" href="?site=statistic_manager">
										{translate}tr_statistic_user_title{/translate}
										<i class="m-icon-swapright m-icon-white"></i>
									</a>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
    </div>
</div>
