<div class="page-content-wrapper">
    <div class="page-content">
    	<div class="row">
    		<div class="col-md-12">
    			<div class="portlet box purple-wisteria">
    				<div class="portlet-title">
    					<div class="caption">{translate}tr_profile_title{/translate}</div>
    				</div>
    				<div class="portlet-body">	
    					<div class="row">
    						<div class="col-md-1 col-xs-4">
    							<img src="content/img/{$user.picture}?{$rand}" width="100px"/>
								<div style="width:100px">
									<form name="create_avatar_image" action="create_avatar.php" method="post">
										<input type="hidden" value="{$user.language}" id="language_id" name="language_id"/>
										<input type="hidden" value="{$user.id}" id="user_id" name="user_id"/>
										<input type="hidden" value="{$user.ins_id}" id="ins_id" name="ins_id"/>
										<input type="submit" class="btn btn-primary" value="{translate}tr_profile_foto{/translate}"/>
									</form>
								</div>
    						</div>
    						<div class="col-md-11 col-xs-8">
								<table>
									<tr>
										<td>{translate}tr_driver_setting_name{/translate}:</td>
										<td>{$user.name}</td>
									</tr>
									<tr>
										<td>eMail:</td>
										<td>{$user.email}</td>
									</tr>
									<tr>
										<td>{translate}tr_profile_last_login{/translate}:</td>
										<td>{$user.last_last_login}</td>
									</tr>
									<tr>
										<td>{translate}tr_profile_instance{/translate}:</td>
										<td>{$instance.name}</td>
									</tr>
									<tr>
										<td>{translate}tr_statistic_driver_team_name{/translate}:</td>
										<td style="color:#{$team.color1};font-weight:bold">{$team.name}</td>
									</tr>
									<tr>
										<td>{translate}tr_statistic_driver_points{/translate}:</td>
										<td>{$user.points}</td>
									</tr>
									<tr>
										<td>{translate}tr_profile_refresh_time{/translate}:</td>
										<td>
											<form name="user_select" action="?site=profile" method="post">
												<select id="user_refreshtime" name="user_refreshtime" onchange="javascript:document.user_select.submit()">
													{section name=value loop=$refreshtime_values}
														{if $refreshtime_values[value] == $user.refreshtime}
															<option selected value='{$refreshtime_values[value]}'>{$refreshtime_values[value]} {translate}tr_profile_seconds{/translate}</option>
														{else}
															<option value='{$refreshtime_values[value]}'>{$refreshtime_values[value]} {translate}tr_profile_seconds{/translate}</option>
														{/if}
													{/section}
												</select>
											</form>
										</td>
									</tr>
									<tr>
										<td>{translate}tr_profile_language{/translate}:</td>
										<td>
											<form name="user_select_language" action="?site=profile" method="post">
												<img src="content/img/flags/{$language_values[$user.language].flag}.gif" width="50px"/>
												<select id="user_language" name="user_language" onchange="javascript:document.user_select_language.submit()">
													{section name=value loop=$language_values}
														{if $language_values[value].id == $user.language}
															<option selected value='{$language_values[value].id}'>{$language_values[value].name}</option>
														{else}
															<option value='{$language_values[value].id}'>{$language_values[value].name}</option>
														{/if}
													{/section}
												</select>
											</form>
										</td>
									</tr>
								 </table>
    						</div>
					    </div>
					</div>
				</div>
				<div class="portlet box purple-wisteria">
    				<div class="portlet-title">
    					<div class="caption">{translate}tr_profile_password{/translate}</div>
    				</div>
    				<div class="portlet-body">
    					<div class="row">
					    	<p>{translate}tr_profile_password_info{/translate}</p>
					    	{if $message}
					    		{$message}
					    	{/if}
					    	<form name="new_password" action="?site=profile" method="post">
								<table>
									<tr>
										<td>{translate}tr_profile_password_new_password{/translate}:</td>
										<td><input type="password" id="new_passwd1" name="new_passwd1"/></td>
									</tr>
									<tr>
										<td>{translate}tr_profile_password_new_password_acknowledge{/translate}:</td>
										<td><input type="password" id="new_passwd2" name="new_passwd2"/></td>
									</tr>
									<tr>
										<td colspan="2" align="right"><input type="submit" class="btn btn-small btn-danger" value="{translate}tr_button_save{/translate}"/></td>
									</tr>
								</table>
					    	</form>
					    </div>
					 </div>
				</div>
				<div class="portlet box purple-wisteria">
    				<div class="portlet-title">
    					<div class="caption">{translate}tr_profile_delete{/translate}</div>
    				</div>
    				<div class="portlet-body">
    					<div class="row">
					    	<p>{translate}tr_profile_delete_info{/translate}</p>
					    	<a class="btn btn-small btn-danger" href="#responsive" data-toggle="modal">{translate}tr_profile_delete{/translate}</a>

							<div id="responsive" class="modal fade" aria-hidden="true" tabindex="-1" style="display: none;">
								<div class="modal-dialog">
									<div class="modal-content">
										<div class="modal-header">
											<button class="close" aria-hidden="true" data-dismiss="modal" type="button"></button>
											<h4 class="modal-title">{translate}tr_profile_delete_note{/translate}:</h4>
										</div>
										<div class="modal-body">
											<div class="row">
												<p>{translate}tr_profile_delete_note_info{/translate}</p>
											</div>
										</div>
										<div class="modal-footer">
											<form name="delete_profile" action="?site=profile" method="post" style="float:left">
												<input type="hidden" id="delete_profile" name="delete_profile" value="{$user.id}"/>
												<input type="submit" class="btn red" value="{translate}tr_profile_delete{/translate}"/>
											</form>
											<button class="btn green" data-dismiss="modal" type="button">{translate}tr_profile_no_delete{/translate}</button>
										</div>
									</div>
								</div>
							</div>
					    </div>
    				</div>
    			</div>
			</div>
		</div>
	</div>
</div>