<div class="page-content-wrapper">
    <div class="page-content">
    	<div class="row">
    		<div class="col-md-12">
    			<div class="portlet box green">
    				<div class="portlet-title">
    					<div class="caption">{translate}tr_admin_main_title{/translate}</div>
    				</div>
    				<div class="portlet-body">
    					<ul class="nav nav-tabs">
    						<li class="active"><a data-toggle="tab" href="#global"> {translate}tr_admin_title{/translate} </a></li>
    						<!--<li><a data-toggle="tab" href="#settings"> {translate}tr_race_qualification_setting_detail{/translate} </a></li>-->
						<li><a data-toggle="tab" href="#statistics"> Statistiken </a></li>
							<!--<li><a data-toggle="tab" href="#race_calendar"> {translate}tr_administration_race_calendar{/translate} </a></li>-->
    					</ul>
    					<div class="tab-content">
    						<div id="global" class="tab-pane fade active in">
    							{if $params.driver_bid_type == 1 and count($bids) > 0}
								<table class="table table-striped" id="driver_market_table">
				                    <thead>
				                    <tr>
				                    	<th>{translate}tr_statistic_driver_picture{/translate}</th>
				                        <th>{translate}tr_statistic_driver_name{/translate}</th>
				                        <th>{translate}tr_statistic_driver_team_name{/translate}</th>
				                        <th>{translate}tr_driver_market_chance{/translate}</th>
				                        <th>{translate}tr_driver_setting_wage{/translate}</th>
				                        <th>{translate}tr_driver_setting_bonus{/translate}</th>
				                        <th>{translate}tr_driver_setting_created{/translate}</th>
					                    <th>{translate}tr_driver_setting_last_change{/translate}</th>
				                        <th>{translate}tr_driver_setting_action{/translate}</th>
				                    </tr>
				                    </thead>
				                    <tbody>
				                    {section name=bid loop=$bids}
				                    	<tr class="{$bids[bid].class}">
				                    		<td class="center"><img src="content/img/driver/{$bids[bid].picture}" width="50px"/></td>
											<td class="center">{$bids[bid].firstname} {$bids[bid].lastname}</td>
											<td class="center">{$bids[bid].team}</td>
											<td class="center">{$bids[bid].chance} %</td>
											<td class="center">{$bids[bid].wage} {translate}tr_global_currency_symbol{/translate}</td>
											<td class="center">{$bids[bid].bonus} {translate}tr_global_currency_symbol{/translate}</td>
											<td class="center">{$bids[bid].created}</td>
											<td class="center">{$bids[bid].last_update}</td>
											<td class="center"><form action="?site=administration" method="post"><input type="hidden" id="bid_id" name="bid_id" value="{$bids[bid].id}"/><input type="submit" class="btn btn-small btn-primary" value="{translate}tr_button_bid_acknowledge{/translate}"/></form></td>
				                    	</tr>
				                    	
				                    {/section}
				                    </tbody>
								</table>
								{/if}
								<!-- deprecated because of user individual setups
								<form action="?site=administration" method="post">
						            <input type="hidden" name="trackreset" value="1">
						            <button type="submit" class="btn btn-primary">zufällige Setup Werte für alle Stecken</button>
						        </form>
						        -->
								<form action="?site=administration" method="post">
						            <input type="hidden" name="driverreset" value="1">
						            <button type="submit" class="btn btn-primary">zufällige Fahrer erstellen</button>
						        </form>
						        <form action="?site=administration" method="post">
						            <input type="hidden" name="carreset" value="1">
						            <button type="submit" class="btn btn-primary">zufällige Wagen erstellen</button>
						        </form>
						        <!--
						        <form action="?site=administration" method="post">
						            <input type="hidden" name="reset" value="1">
						            <button type="submit" class="btn btn-primary">alles zurücksetzen</button>
						        </form>-->
						        <form action="?site=administration" method="post">
						            <input type="hidden" name="reset_tqr" value="1">
						            <button type="submit" class="btn btn-primary">reset Training/Qualifikation/Rennen</button>
						        </form>
						        <form action="?site=administration" method="post">
						            <input type="hidden" name="reset_qr" value="1">
						            <button type="submit" class="btn btn-primary">reset Qualifikation/Rennen</button>
						        </form>
						        <form action="?site=administration" method="post">
						            <input type="hidden" name="training" value="1">
						            <button type="submit" class="btn btn-primary">KI Training berechnen / Fahrer zuweisen</button>
						        </form>
						        <!-- deprecated ai repairs its items
						        <form action="?site=administration" method="post">
						            <input type="hidden" name="repairAiItem" value="1">
						            <button type="submit" class="btn btn-primary">Repariere KI Teile</button>
						        </form>
						        -->
						        <!-- deprecated ai does this automatically
						        <form action="?site=administration" method="post">
						            <input type="hidden" name="deleteAiItems" value="1">
						            <button type="submit" class="btn btn-primary">KI Teile entfernen (werden neu verteilt)</button>
						        </form>
						        -->
						        <form action="?site=administration" method="post">
						            <input type="hidden" name="quali" value="1">
						            <button type="submit" class="btn btn-primary">Qualifikation berechnen</button>
						        </form>
						        <form action="?site=administration" method="post">
						            <input type="hidden" name="reset_r" value="1">
						            <button type="submit" class="btn btn-primary">reset Rennen</button>
						        </form>
						        <form action="?site=administration" method="post">
						            <input type="hidden" name="race" value="1">
						            <button type="submit" class="btn btn-primary">Rennen berechnen</button>
						        </form>
						        <form action="?site=administration" method="post">
						            <input type="hidden" name="next_race" value="1">
						            <button type="submit" class="btn btn-primary">nächstes Rennen</button>
						        </form>
						        <form action="?site=administration" method="post">
						            <input type="hidden" name="next_saison" value="1">
						            <button type="submit" class="btn btn-primary">nächste Saison</button>
						        </form>
						        <form action="?site=administration" method="post">
						            max. Runden Training (100): <input type="text" name="training_max_rounds" value="{$params.training_max_rounds}"><br>
						            max. Runden Qualifikation (12): <input type="text" name="qualification_max_rounds" value="{$params.qualification_max_rounds}"><br>
						            Qualifikation 1. Schnitt (17): <input type="text" name="qualification_cut1" value="{$params.qualification_cut1}"><br>
						            Qualifikation 2. Schnitt (11): <input type="text" name="qualification_cut2" value="{$params.qualification_cut2}"><br>
						            Ausfallwahrscheinlichkeit (in Promille) (80): <input type="text" name="drop_out" value="{$params.drop_out}"><br>
						            Zufallswert (0.004): <input type="text" name="random" value="{$params.random}"><br>
						            Auswirkung der Autoteile (0.05): <input type="text" name="item_value" value="{$params.item_value}"><br>
						            Auswirkung des Autosetups (0.05): <input type="text" name="setup_value" value="{$params.setup_value}"><br>
						            Auswirkung der Fahrerwerte (0.05): <input type="text" name="driver_value" value="{$params.driver_value}"><br>
						            Auswirkung der Reifenwerte (0.05): <input type="text" name="tire_value" value="{$params.tire_value}"><br>
						            Geschwindigkeitswert (10): <input type="text" name="speed" value="{$params.speed}"><br>
						            Auswirkung der Motorleistung (1.0): <input type="text" name="engine_power" value="{$params.engine_power}"><br>
						            Prozentuelle Änderung aller Rennparameter (50): <input type="text" name="round_factor" value="{$params.round_factor}"><br>
						            KI Stärke Liga 1 (20): <input type="text" name="ai_strength1" value="{$params.ai_strength1}"><br>
						            KI Stärke Liga 2 (20): <input type="text" name="ai_strength2" value="{$params.ai_strength2}"><br>
						            KI Stärke Liga 3 (20): <input type="text" name="ai_strength3" value="{$params.ai_strength3}"><br>
						            <!--Überholmanöver (50): <input type="text" name="overtake" value="{$params.overtake}"><br>-->
						            Harte Reifen pro Rennwochenende (3): <input type="text" name="hard_tires_per_weekend" value="{$params.hard_tires_per_weekend}"><br>
						            Weiche Reifen pro Rennwochenende (3): <input type="text" name="soft_tires_per_weekend" value="{$params.soft_tires_per_weekend}"><br>
						            Reifenabnutzung (Meter zu Runde) (5000): <input type="text" name="meter_to_round" value="{$params.meter_to_round}"><br>
						            Reifenzustandsampel (50,100,150): <input type="text" name="tire_condition" value="{$params.tire_condition}"><br>
						            Art des Fahrer Transfermarkts:
						            <select name="driver_bid_type">
						            	{if $params.driver_bid_type == 0}
						                    <option value='0' selected>Fahrer direkt kaufen</option>
						                    <option value='1'>Fahrer Angebot machen</option>
						                {else}
						                	<option value='0'>Fahrer direkt kaufen</option>
						                    <option value='1' selected>Fahrer Angebot machen</option>
						                {/if}
						            </select><br>
						            Spieler sehen Infos zu Geboten:
						            <select name="driver_bid_visible">
						            	{if $params.driver_bid_visible == 0}
						                    <option value='0' selected>Chance wird bei mehreren Geboten nicht angezeigt</option>
						                    <option value='1'>Chance wird bei mehreren Geboten angezeigt</option>
						                {else}
						                	<option value='0'>Chance wird bei mehreren Geboten nicht angezeigt</option>
						                    <option value='1' selected>Chance wird bei mehreren Geboten angezeigt</option>
						                {/if}
						            </select><br>
						            Reifen Quali und Rennen:
						            <select name="qualification_race_tires">
						            	{if $params.qualification_race_tires == 0}
						                    <option value='0' selected>Reifen dürfen vor dem Rennen gewechselt werden</option>
						                    <option value='1'>Reifen von Q3 sind Startreifen im Rennen</option>
						                {else}
						                	<option value='0'>Reifen dürfen vor dem Rennen gewechselt werden</option>
						                    <option value='1' selected>Reifen von Q3 sind Startreifen im Rennen</option>
						                {/if}
						            </select><br>
						            Reifen im Rennen:
						            <select name="race_diff_tires">
						            	{if $params.race_diff_tires == 0}
						                    <option value='0' selected>es ist egal welche Reifen im Rennen verwendet werden</option>
						                    <option value='1'>man muss beide Reifentypen verwenden</option>
						                {else}
						                	<option value='0'>es ist egal welche Reifen im Rennen verwendet werden</option>
						                    <option value='1' selected>man muss beide Reifentypen verwenden</option>
						                {/if}
						            </select><br>
						            Reifen in der Qualifikation:
						            <select name="qualification_diff_tires">
						            	{if $params.qualification_diff_tires == 0}
						                    <option value='0' selected>es ist egal welche Reifen in der Qualifikation verwendet werden</option>
						                    <option value='1'>man muss beide Reifentypen verwenden</option>
						                {else}
						                	<option value='0'>es ist egal welche Reifen in der Qualifikation verwendet werden</option>
						                    <option value='1' selected>man muss beide Reifentypen verwenden</option>
						                {/if}
						            </select><br>
						            <button type="submit" class="btn btn-primary">{translate}tr_button_save{/translate}</button>
						        </form>
						        aktueller User:
						        <form name="user_select" action="?site=administration" method="post">
						            <select name="user" onchange="javascript:document.user_select.submit()">
						                    <option selected></option>
						                {section name=user loop=$users}
						                    <option value='{$users[user].id}'>{$users[user].name}</option>
						                {/section}
						            </select>
						        </form>
	    					</div>
	    					<div id="settings" class="tab-pane fade">
    							<div class="row">
									<div class="portlet box green">
										<div class="portlet-title">
											<div class="caption">Training</div>
											<div class="tools">
												<a class="expand" href="javascript:;"> </a>
											</div>
										</div>
										<div class="portlet-body">
											Training gemacht:
											<table class="table table-striped" id="training">
												{section name=tu loop=$training_users}
													<tr>
														<td style="color:green">{$training_users[tu].name}</td>
													</tr>
												{/section}
											</table>
											Training nicht gemacht:
											<table class="table table-striped" id="no_training">
												{section name=tu loop=$no_training_users}
													<tr>
														<td style="color:red">{$no_training_users[tu].name}</td>
													</tr>
												{/section}
											</table>
										</div>
									</div>
								</div>
    							
								<div class="row">
									<div class="portlet box green">
										<div class="portlet-title">
											<div class="caption">Qualifikation</div>
											<div class="tools">
												<a class="expand" href="javascript:;"> </a>
											</div>
										</div>
										<div class="portlet-body">
											Qualifikationeinstellungen gemacht:
											<table class="table table-striped" id="qualification">
												{section name=tu loop=$qualification_users}
													<tr>
														<td style="color:green">{$qualification_users[tu].name}</td>
													</tr>
												{/section}
											</table>
											Qualifikationeinstellungen nicht gemacht:
											<table class="table table-striped" id="no_qualification">
												{section name=tu loop=$no_qualification_users}
													<tr>
														<td style="color:red">{$no_qualification_users[tu].name}</td>
													</tr>
												{/section}
											</table>
										</div>
									</div>
								</div>
								
								<div class="row">
									<div class="portlet box green">
										<div class="portlet-title">
											<div class="caption">Rennen</div>
											<div class="tools">
												<a class="expand" href="javascript:;"> </a>
											</div>
										</div>
										<div class="portlet-body">
											Renneinstellungen gemacht:
											<table class="table table-striped" id="grandprix">
												{section name=tu loop=$grandprix_users}
													<tr>
														<td style="color:green">{$grandprix_users[tu].name}</td>
													</tr>
												{/section}
											</table>
											Renneinstellungen nicht gemacht:
											<table class="table table-striped" id="no_grandprix">
												{section name=tu loop=$no_grandprix_users}
													<tr>
														<td style="color:red">{$no_grandprix_users[tu].name}</td>
													</tr>
												{/section}
											</table>
										</div>
									</div>
								</div>
    						</div>
						<div id="statistics" class="tab-pane fade">
    							<div class="row">
									<div class="portlet box green">
										<div class="portlet-title">
											<div class="caption">freie Teams</div>
											<div class="tools">
												<a class="expand" href="javascript:;"> </a>
											</div>
										</div>
										<div class="portlet-body">
											Freie Teams: {$freeTeams}
										</div>
									</div>
								</div>
							</div>
    						<!-- deprecated because of random generated track calendar
	    					<div id="race_calendar" class="tab-pane fade">
    							<form action="?site=administration" method="post">
									<table>
										<thead>
											<tr>
												<th>Reihenfolge</th>
												<th>Rennen</th>
											</tr>
										</thead>
										<tbody>
											{for $i = 0 to count($races) - 1 }
												<tr>
													<td>{$i+1}</td>
													<td>
														<select id="race_{$races[$i].id}" name="race_{$races[$i].id}">
														{section name=track loop=$tracks}
															{if $tracks[track].id == $races[$i].tra_id}
																<option value="{$tracks[track].id}" selected>{$tracks[track].name}</option>
															{else}
																<option value="{$tracks[track].id}">{$tracks[track].name}</option>
															{/if}
														{/section}
														</select>
													</td>
												</tr>
											{/for}
										</tbody>
									</table>
									<input type="hidden" class="btn btn-small btn-primary" name="save_race" value="1"/>
									<input type="submit" class="btn btn-small btn-primary" value="{translate}tr_button_save{/translate}"/>
								</form>
								<form action="?site=administration" method="post">
									<input type="hidden" class="btn btn-small btn-primary" name="add_race" value="1"/>
									<input type="submit" class="btn btn-small btn-primary" value="+"/>
								</form>
								<form action="?site=administration" method="post">
									<input type="hidden" class="btn btn-small btn-primary" name="del_race" value="1"/>
									<input type="submit" class="btn btn-small btn-primary" value="-"/>
								</form>
							</div>
							-->
						</div>
    				</div>
    			</div>
    		</div>
    	</div>
    </div>
</div>
