<div class="page-content-wrapper">
    <div class="page-content">
    	<div class="row">
    		<div class="col-md-12">
				<div class="portlet box grey-silver">
    				<div class="portlet-title">
    					<div class="caption">{translate}car_construct{/translate}</div>
    				</div>
    				<div class="portlet-body">
    					<div class="desktop_slider">
    						<form action="?site=car_construct" method="post" id="car_construct" name="car_construct">
								<div class="row">
									<div class="col-md-1">
										{translate}component{/translate}:
									</div>
									<div class="col-md-3">
										<select name="item" onchange="javascript:document.car_construct.submit()">
											<option value="">{translate}choose{/translate}</option>
											{for $i = 0 to count($items) - 1 }
												{if $selected_item == $i}
													<option selected value="{$i}">{translate}{$items[$i]}{/translate}</option>
												{else}
													<option value="{$i}">{translate}{$items[$i]}{/translate}</option>
												{/if}
											{/for}
										</select>
									</div>
								</div>
								<div class="row">
									<div class="col-md-1">
										{translate}design{/translate}:
									</div>
									<div class="col-md-3">
										<select name="type">
											<option value="">{translate}choose{/translate}.</option>
											{for $i = 0 to count($types) - 1 }
												{if $selected_type == $i}
													<option selected value="{$i}">{$types[$i]}</option>
												{else}
													<option value="{$i}">{$types[$i]}</option>
												{/if}
											{/for}
										</select>
									</div>
								</div>
								<div class="row">
									<div class="col-md-1">
										{translate}first_color{/translate}:
									</div>
									<div class="col-md-3">
										<input type="hidden" id="color1" name="color1" value="{$color1}">
										<input type='text' id="colorpicker1"/>
									</div>
								</div>
								<div class="row">
									<div class="col-md-1">
										{translate}second_color{/translate}:
									</div>
									<div class="col-md-3">
										<input type="hidden" id="color2" name="color2" value="{$color2}">
										<input type='text' id="colorpicker2"/>
									</div>
								</div>
								<div class="row">
									<div class="col-md-1">
									</div>
									<div class="col-md-3">
										<input type="button" class="btn btn-small btn-success" value="Teil austauschen" onclick="javascript:document.car_construct.submit()"/>
									</div>
								</div>
							</form>
						</div>
							
						<div class="mobile_slider">
							<form action="?site=car_construct" method="post" id="car_construct1" name="car_construct1">
								<div class="row">
									<div class="col-xs-2">
										{translate}component{/translate}:
									</div>
									<div class="col-xs-10">
										<select name="item" onchange="javascript:document.car_construct1.submit()">
											<option value="">{translate}choose{/translate}</option>
											{for $i = 0 to count($items) - 1 }
												{if $selected_item == $i}
													<option selected value="{$i}">{translate}{$items[$i]}{/translate}</option>
												{else}
													<option value="{$i}">{translate}{$items[$i]}{/translate}</option>
												{/if}
											{/for}
										</select>
									</div>
								</div>
								<div class="row">
									<div class="col-xs-2">
										{translate}design{/translate}:
									</div>
									<div class="col-xs-10">
										<select name="type">
											<option value="">{translate}choose{/translate}</option>
											{for $i = 0 to count($types) - 1 }
												{if $selected_type == $i}
													<option selected value="{$i}">{$types[$i]}</option>
												{else}
													<option value="{$i}">{$types[$i]}</option>
												{/if}
											{/for}
										</select>
									</div>
								</div>
								<div class="row">
									<div class="col-xs-2">
										{translate}first_color{/translate}:
									</div>
									<div class="col-xs-10">
										<input type="hidden" id="mobile_color1" name="color1" value="{$color1}">
										<input type='text' id="mobile_colorpicker1"/>
									</div>
								</div>
								<div class="row">
									<div class="col-xs-2">
										{translate}second_color{/translate}:
									</div>
									<div class="col-xs-10">
										<input type="hidden" id="mobile_color2" name="color2" value="{$color2}">
										<input type='text' id="mobile_colorpicker2"/>
									</div>
								</div>
								<div class="row">
									<div class="col-xs-2">
									</div>
									<div class="col-xs-10">
										<input type="button" class="btn btn-small btn-success" value="Teil austauschen" onclick="javascript:document.car_construct1.submit()"/>
									</div>
								</div>
							</form>
						</div>
    					<div class="row">
							<div class="desktop_slider">
								<div class="col-md-12">
									<div class="col-md-1"></div>
									<div class="col-md-10">
										<a href="?site=car_construct"><img src="content/img/car/team/{$tea_id}.png?{$rand}" width="100%"></a>
									</div>
								</div>
							</div>
							<div class="mobile_slider">
								<a href="?site=car_construct"><img src="content/img/car/team/{$tea_id}.png?{$rand}" width="100%"></a>
							</div>
						</div>
    				</div>
    			</div>
    		</div>
    	</div>
    </div>
</div>
<script>
$("#colorpicker1").spectrum({
    preferredFormat: "hex",
    showInput: true,
    showPalette: true,
    palette: [["red", "blue", "green", "grey", "black", "white"]],
    change: function(color) {
		$("#color1").val(color.toHexString());
	}
});
$("#colorpicker2").spectrum({
    preferredFormat: "hex",
    showInput: true,
    showPalette: true,
    palette: [["red", "blue", "green", "grey", "black", "white"]],
    change: function(color) {
		$("#color2").val(color.toHexString());
	}
});
$("#colorpicker1").spectrum("set", '{$color1}');
$("#colorpicker2").spectrum("set", '{$color2}');

$("#mobile_colorpicker1").spectrum({
    preferredFormat: "hex",
    showInput: true,
    showPalette: true,
    palette: [["red", "blue", "green", "grey", "black", "white"]],
    change: function(color) {
		$("#mobile_color1").val(color.toHexString());
	}
});
$("#mobile_colorpicker2").spectrum({
    preferredFormat: "hex",
    showInput: true,
    showPalette: true,
    palette: [["red", "blue", "green", "grey", "black", "white"]],
    change: function(color) {
		$("#mobile_color2").val(color.toHexString());
	}
});
$("#mobile_colorpicker1").spectrum("set", '{$color1}');
$("#mobile_colorpicker2").spectrum("set", '{$color2}');
</script>
