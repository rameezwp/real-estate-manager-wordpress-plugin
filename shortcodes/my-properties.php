<div class="ich-settings-main-wrap">
	<div class="row">
		<div class="col-sm-12">
			<div class="row" style="margin-bottom:25px;">
				<div class="col-sm-6">
				<form action="#" method="GET">
					<select name="sort_by" class="form-control" onchange="this.form.submit()">
						<option value="all"><?php _e( 'Display All', 'real-estate-manager' ); ?></option>
						<option value="publish" <?php echo (isset($_GET['sort_by']) && $_GET['sort_by'] == 'publish') ? 'selected' : '' ; ?>><?php _e( 'Only Published', 'real-estate-manager' ); ?></option>
						<option value="pending" <?php echo (isset($_GET['sort_by']) && $_GET['sort_by'] == 'pending') ? 'selected' : '' ; ?>><?php _e( 'Only Pending', 'real-estate-manager' ); ?></option>
						<option value="draft" <?php echo (isset($_GET['sort_by']) && $_GET['sort_by'] == 'draft') ? 'selected' : '' ; ?>><?php _e( 'Only Draft', 'real-estate-manager' ); ?></option>
					</select>
					<input type="hidden" value="<?php echo (isset($_GET['rem_search_query'])) ? $_GET['rem_search_query'] : '' ; ?>" name="rem_search_query">
				</form>
				</div>
				<div class="col-sm-6">
				    	<form action="" method="GET">
						<input type="hidden" value="<?php echo (isset($_GET['sort_by'])) ? $_GET['sort_by'] : '' ; ?>" name="sort_by">
				    <div class="input-group">
					      <input type="text" value="<?php echo (isset($_GET['rem_search_query'])) ? $_GET['rem_search_query'] : '' ; ?>" name="rem_search_query" class="form-control" placeholder="Search for...">
					      <span class="input-group-btn">
					        <button class="btn btn-default" type="submit"><?php _e( 'Search', 'real-estate-manager' ); ?></button>
					      </span>
				    </div><!-- /input-group -->					
				    	</form>
				</div>
			</div>
		</div>
	</div>
<div id="user-profile">
	<div class="table-responsive property-list">
		<table class="table-striped table-hover">
		  <thead>
			<tr>
				<th><?php _e( 'Thumbnail', 'real-estate-manager' ); ?></th>
				<th><?php _e( 'Title', 'real-estate-manager' ); ?></th>
				<th class="hidden-xs"><?php _e( 'Type', 'real-estate-manager' ); ?></th>
				<th class="hidden-xs hidden-sm"><?php _e( 'Added', 'real-estate-manager' ); ?></th>
				<th class="hidden-xs"><?php _e( 'Purpose', 'real-estate-manager' ); ?></th>
				<th><?php _e( 'Status', 'real-estate-manager' ); ?></th>
				<th><?php _e( 'Actions', 'real-estate-manager' ); ?></th>
			</tr>
		  </thead>
		  <tbody>
			<?php 
				$current_user_data = wp_get_current_user();
				if (isset($_GET['sort_by']) && $_GET['sort_by'] != '') {
					$statuses = array($_GET['sort_by']);
				} else {
					$statuses = array( 'pending', 'draft', 'future', 'publish' );
				}
				$args = array(
					'author'	=> $current_user_data->ID,
					'post_type' => 'rem_property',
					'posts_per_page' => 10,
					'post_status' => $statuses
				);
				if (isset($_GET['rem_search_query'])) {
					$args['s'] = $_GET['rem_search_query'];
				}
		    	if (is_front_page()) {
		    		$paged = ( get_query_var('page') ) ? get_query_var('page') : 1;
		    	} else {
					$paged = ( get_query_var('paged') ) ? get_query_var('paged') : 1;
		    	}
				$args['paged'] = $paged;

				$myproperties = new WP_Query( $args );
				if( $myproperties->have_posts() ){
					while( $myproperties->have_posts() ){ 
						$myproperties->the_post(); ?>	
							<tr>
								<td class="img-wrap">
									<?php do_action( 'rem_property_picture', get_the_id(), 'thumbnail' ); ?>
								</td>
								<td><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a> <?php echo get_post_meta(get_the_id(),'rem_property_address', true); ?></td>
								<td class="hidden-xs"><?php echo ucfirst(get_post_meta(get_the_id(),'rem_property_type', true )); ?></td>
								<td class="hidden-xs hidden-sm"><?php the_time('Y/m/d'); ?></td>
								<td class="hidden-xs"><?php echo ucfirst(get_post_meta(get_the_id(),'rem_property_purpose', true )); ?></td>
								<td>
									<?php
										$p_status = get_post_status(get_the_id());
										$status_class = ($p_status == 'publish') ? 'label-success' : 'label-info' ;
									?>
									<span class="label <?php echo $status_class; ?>"><?php echo ucfirst($p_status); ?></span></td>
								<td>
									<?php
										$edit_page_id = rem_get_option('property_edit_page', 1);
										$link_page = get_permalink( $edit_page_id );

									?>
									<a href="<?php echo esc_url( add_query_arg( 'property_id', get_the_id(), $link_page ) ); ?>" class="btn btn-info btn-sm">
										<i class="fas fa-pencil-alt"></i>
										<?php _e( 'Edit', 'real-estate-manager' ); ?>
									</a>
									<a class="btn btn-danger btn-sm delete-property" data-pid="<?php echo get_the_id(); ?>" href="#">
										<i class="fa fa-trash"></i>
										<?php _e( 'Delete', 'real-estate-manager' ); ?>
									</a>
								</td>
							</tr>
						<?php 
					}
					wp_reset_postdata();
				}
			?>
		  </tbody>
		</table>
		<?php do_action( 'rem_pagination', $paged, $myproperties->max_num_pages ); ?>
	</div>
</div>
</div>