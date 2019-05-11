<?php
global $post;
?>
<div class="ich-settings-main-wrap">
	<?php if (rem_get_option('use_map_from', 'leaflet') == 'google_maps') { ?>
	<input type="text" class="form-control" id="search-map" placeholder="<?php _e( 'Type to Search...', 'real-estate-manager' ); ?>">
	<?php } ?>
	<div id="map-canvas" style="height: 300px"></div>
	<br>
	<div id="position" class="alert alert-info">
		<?php
			_e( 'Search the address on search bar. ', 'real-estate-manager' );
			_e( 'Drag the pin to the location on the map', 'real-estate-manager' );
		?>
	</div>
	<hr>
	<div class="checkbox">
		<?php $checked = (get_post_meta( $post->ID, '_disable_map', true ) == 'yes') ? 'checked' : '' ; ?>
		<label>
			<input <?php echo $checked; ?> style="margin-top: 0;" type="checkbox" name="_disable_map"> <strong><?php _e( 'Disable', 'real-estate-manager' ); ?></strong>
		</label>
		-
		<?php _e( 'Checking this will disable map for this listing', 'real-estate-manager' ); ?>
	</div>	
</div>