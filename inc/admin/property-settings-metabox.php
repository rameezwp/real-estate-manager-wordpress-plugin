<div class="rem-settings-box ich-settings-main-wrap">
	<ul class="nav nav-tabs">
		<?php
			$tabsData = rem_get_single_property_settings_tabs();
			
			$inputFields = $this->get_all_property_fields();
			
			foreach ($tabsData as $name => $title) {
				echo '<li role="presentation"><a href="#'.$name.'">'.$title.'</a></li>';
			}
		?>
	</ul>
	
	<div class="tabs-data">
		<?php
			foreach ($tabsData as $name => $title) { ?>
				<div id="<?php echo $name; ?>" class="tabs-panel">
				<br>
					<?php
						do_action( 'rem_before_admin_tab_'.$name );

						foreach ($inputFields as $field) {
							$show_condition = isset($field['show_condition']) ? $field['show_condition'] : 'true' ; 
							$conditions = isset($field['condition']) ? $field['condition'] : array() ;
							
							if($field['tab'] == $name && $field['accessibility'] != 'disable'){ ?>
			                    <div class="form-group" data-condition_status="<?php echo $show_condition; ?>" data-condition_bound="<?php echo isset($field['condition_bound']) ? $field['condition_bound'] : 'all' ?>" data-condition='<?php echo json_encode($conditions); ?>'>
			                        <label for="<?php echo $field['key']; ?>" class="col-sm-3 control-label">
			                            <?php echo stripcslashes($field['title']); ?>
			                        </label>
			                        <div class="col-sm-9">
			                            <?php rem_render_field($field); ?>
			                            <p class="help-block"><?php echo stripcslashes($field['help']); ?>	</p>
			                        </div>
			                        <div class="clearfix"></div>
			                    </div>

							<?php }
						}

						do_action( 'rem_after_admin_tab_'.$name ); ?>
				</div>
			<?php }
		?>	
	</div>
	
</div>