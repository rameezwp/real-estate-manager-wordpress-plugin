<?php
/**
* Real Estate Manager - This Class handles all hook (filters + actions) for templates
*/
class REM_Hooks
{
	
	function __construct(){
        // Agent Page
		add_action( 'rem_agent_picture', array($this, 'agent_picture'), 10, 1 );
        add_action( 'rem_single_agent_after_contact_form', array($this, 'display_agent_custom_data'), 10, 1 );
        add_action( 'agent_page_contact_form', array($this, 'display_agent_contact_form'), 10, 1 );
        add_action( 'rem_contact_social_icons', array($this, 'contact_social_icons'), 10, 1 );
        add_action( 'rem_single_property_agent', array($this, 'single_property_agent_form'), 10, 1 );
        
        add_action( 'rem_property_box', array($this, 'property_box'), 10, 3 );
        add_action( 'rem_agent_box', array($this, 'agent_box'), 10, 2 );
        add_action( 'rem_property_details_icons', array($this, 'property_icons'), 20, 2 );
        add_action( 'rem_property_picture', array($this, 'property_picture'), 10, 2 );
        add_action( 'rem_listing_footer', array($this, 'property_template_footer_buttons'), 20, 3 );

        // Sending email on new property submission
        add_action( 'transition_post_status', array($this, 'property_submission_email'), 10, 3 );        

        // Property Fields Related
        add_filter( 'rem_property_features', array($this, 'property_features' ), 10, 1 );        
        add_filter( 'rem_property_types', array($this, 'property_types' ), 10, 1 );
        add_filter( 'rem_property_purposes', array($this, 'property_purposes' ), 10, 1 );
        add_filter( 'rem_property_statuses', array($this, 'property_statuses' ), 10, 1 );
        add_filter( 'rem_maps_location_icon', array($this, 'location_icon' ), 10, 2 );
        add_filter( 'rem_maps_drag_icon', array($this, 'drag_icon' ), 10, 1 );
        add_filter( 'rem_maps_api', array($this, 'maps_api' ), 10, 1 );

        // Single Property Display
        add_action( 'rem_single_property_slider', array($this, 'single_property_slider' ), 10, 1 );
        add_action( 'rem_single_property_contents', array($this, 'single_property_title' ), 15, 1 );
        add_action( 'rem_single_property_contents', array($this, 'single_property_contents' ), 20, 1 );
        add_action( 'rem_single_property_contents', array($this, 'single_property_details' ), 30, 1 );
        add_action( 'rem_single_property_contents', array($this, 'single_property_additional_tabs' ), 35, 1 );
        add_action( 'rem_single_property_contents', array($this, 'single_property_features' ), 40, 1 );
        add_action( 'rem_single_property_contents', array($this, 'single_property_attachments' ), 45, 1 );
        add_action( 'rem_single_property_contents', array($this, 'single_property_video' ), 50, 1 );
        add_action( 'rem_single_property_contents', array($this, 'single_property_map' ), 60, 1 );
        add_action( 'rem_single_property_contents', array($this, 'single_property_tags' ), 70, 1 );
        add_action( 'rem_single_property_contents', array($this, 'single_property_edit_button' ), 80, 1 );

        // Pagination
        add_action( 'rem_pagination', array($this, 'render_rem_pagination' ), 10, 2 );

        // Tags page Title
        add_filter( 'get_the_archive_title', array($this, 'custom_archive_title' ), 10, 1 );
        add_action( 'pre_get_posts', array($this, 'archive_page_properties_count'), 99 );
        add_filter( 'plugin_row_meta', array($this, 'rem_action_btns'), 10, 2 );

        add_filter('manage_rem_property_posts_columns', array($this, 'rem_property_column_head'));
        add_action('manage_rem_property_posts_custom_column', array($this, 'rem_property_column_content'), 10, 2);        

        // Captcha on contact forms
        add_action('rem_agent_contact_before_submit', array($this, 'insert_captcha'), 10, 1);

        // Redirect After property submission
        add_filter('rem_redirect_after_property_submit', array($this, 'rem_redirect_after_submission'), 10, 2);

        // Redirect After edit property
        add_filter('rem_redirect_after_property_edit', array($this, 'rem_redirect_after_editing_property'), 10, 2);

        // Restrict Access to Media
        add_filter('ajax_query_attachments_args', array($this, 'show_current_user_attachments'));
        add_filter( 'user_has_cap', array($this, 'allow_attachment_actions'), 10, 3 );

        // Ribbons
        add_filter('rem_property_ribbon', array($this, 'add_ribbon_with_listings'), 10, 2 );

        // Customize icon data on listings
        add_filter( 'rem_property_icons', array($this, 'rem_custom_listing_icons'), 30, 2 );

        // Create/Edit Property Fields Columns
        add_filter( 'rem_property_fields_cols', array($this, 'property_edit_create_columns'), 30, 2 );

        // Additional Property Settings Tabs
        add_filter( 'rem_property_settings_tabs', array($this, 'property_settings_tabs'), 10, 1 );

        // Instructions after checkboxes in admin
        add_filter( 'rem_after_admin_tab_property_details', array($this, 'property_details_add_more_instruction') );

        // Random display agents
        add_action( 'pre_user_query', array($this, 'random_display_agents') );

        // Containers max width
        add_action( 'rem_max_container_width', array($this, 'templates_apply_max_width'), 10, 1 );

        // GDPR with CFs
        add_action( 'rem_agent_contact_before_submit', array($this, 'display_gdpr_checkbox'), 10, 1 );
	}

	function agent_picture($user_id){
		if(get_the_author_meta( 'rem_agent_meta_image', $user_id ) != '') {
			echo '<img src="'.esc_url_raw( get_the_author_meta( 'rem_agent_meta_image', $user_id ) ).'">';
		} else {
			echo get_avatar( $user_id , 512 );
		}		
	}

	function property_picture($id = '', $thumbnail = 'full'){
		if ($id == '') {
			global $post;
			$id = $post->ID;
		}

        $image_size = rem_get_option('featured_image_size', $thumbnail);

        $image_size = apply_filters( 'rem_featured_image_size', $image_size, $id );

        $attr = array('class' => 'img-responsive', 'data-pid' => $id );
        if( has_post_thumbnail($id) ){
            echo get_the_post_thumbnail( $id, $image_size, $attr );
        } else {
        // Use the first gallery picture
        $property_images = get_post_meta( $id, 'rem_property_images', true );
            if (is_array($property_images)) {
                foreach ($property_images as $image_id) {
                    echo wp_get_attachment_image( $image_id, $image_size, false, $attr );
                    break;
                }
            }
        }
	}
    function property_template_footer_buttons( $property_id, $style , $target ) { ?>
        <?php if ( $style == 5 ): ?>
            <a target="<?php echo $target; ?>" href="<?php echo get_permalink($property_id); ?>" class="btn btn-reverse button">
        <i class="fa fa-search"></i> <?php _e( 'Details', 'real-estate-manager' ); ?></a>
        <?php 
            return ;
        endif ?>
        <a target="<?php echo $target ?>" class="btn btn-default" href="<?php echo get_permalink($property_id); ?>"><?php _e( 'Details', 'real-estate-manager' ); ?></a>
    <?php  }
    function property_box($property_id, $style = '3', $target=""){
        global $rem_ob;
        $area = get_post_meta($property_id, 'rem_property_area', true);
        $property_type = get_post_meta($property_id, 'rem_property_type', true);
        $address = get_post_meta($property_id, 'rem_property_address', true);
        $latitude = get_post_meta($property_id, 'rem_property_latitude', true);
        $longitude = get_post_meta($property_id, 'rem_property_longitude', true);
        $city = get_post_meta($property_id, 'rem_property_city', true);
        $country = get_post_meta($property_id, 'rem_property_country', true);
        $purpose = get_post_meta($property_id, 'rem_property_purpose', true);
        $status = get_post_meta($property_id, 'rem_property_status', true);
        $bathrooms = get_post_meta($property_id, 'rem_property_bathrooms', true);
        $bedrooms = get_post_meta($property_id, 'rem_property_bedrooms', true);
        
        $in_theme = get_stylesheet_directory().'/rem/style'.$style.'.php';

        if (file_exists($in_theme)) {
            $file_path = $in_theme;
        } elseif (defined('REM_PROPERTY_STYLES_PATH')) {
            $file_path = REM_PROPERTY_STYLES_PATH . '/templates/style'.$style.'.php';
        } else {
            $file_path = REM_PATH . '/templates/property/style'.$style.'.php';
        }

        if (file_exists($file_path)) {
          include $file_path;
        }
    }

    function agent_box($author_id, $style = '1'){
        
        $in_theme = get_stylesheet_directory().'/agent/style'.$style.'.php';

        if (file_exists($in_theme)) {
            $file_path = $in_theme;
        } else {
            $file_path = REM_PATH . '/templates/agent/style'.$style.'.php';
        }

        if (file_exists($file_path)) {
          include $file_path;
        }
    }


    function property_submission_email( $new_status, $old_status, $property ) {
        if (isset($property->post_type) && $property->post_type == 'rem_property' && rem_get_option('property_submission_mode') == 'approve') {
            if ( $new_status === "pending" && $old_status !== 'pending' ) {
                do_action( 'rem_new_property_submitted', $property );
            }
            if ( $new_status === "publish" && $old_status === 'pending' ) {
                do_action( 'rem_new_property_approved', $property );
            }
        }
    }

    function property_icons($property_id, $display = 'table'){
		$bathrooms = get_post_meta( $property_id, 'rem_property_bathrooms', true );
		$bedrooms = get_post_meta( $property_id, 'rem_property_bedrooms', true );
		$status = get_post_meta($property_id, 'rem_property_status', true);
		$area = get_post_meta($property_id, 'rem_property_area', true);

        $property_details = array(
            /*'status' => array(
                'label' => __( 'Status', 'real-estate-manager' ),
                'class' => 'status',
                'value' => $status,
            ),*/
            'bed' => array(
                'label' => __( 'Beds', 'real-estate-manager' ),
                'class' => 'fa fa-bed',
                'value' => $bedrooms,
            ),
            'bath' => array(
                'label' => __( 'Baths', 'real-estate-manager' ),
                'class' => 'fa fa-bath',
                'value' => $bathrooms,
            ),
            'area' => array(
                'label' => __( 'Area', 'real-estate-manager' ),
                'class' => 'fa fa-arrows-alt',
                'value' => $area,
            ),
        );

        if(has_filter('rem_property_icons')) {
            $property_details = apply_filters('rem_property_icons', $property_details, $property_id);
        }

        // Rendering
        if ($display == 'inline') { ?>
            <div class="detail inline-property-icons">
                <?php
                    foreach ($property_details as $key => $data) { ?>
                        <?php if ($data['value'] != '') { ?>
                            <?php $data['value'] = (preg_match('/(_|\b)area(_|\b)/', $key)) ? $data['value'].' '.rem_get_option('properties_area_unit', 'Sq Ft') : $data['value'] ; ?>
                            <?php if (rem_get_option('display_listing_features', 'icons_data') == 'icons_data') { ?>
                                <span title="<?php echo $data['label']; ?>">
                                    <i class="<?php echo $data['class']; ?>"></i> &nbsp;
                                    <?php echo $data['value']; ?>
                                </span>
                            <?php } elseif (rem_get_option('display_listing_features', 'icons_data') == 'labels_data') { ?>
                                <span>
                                    <?php echo $data['label']; ?>:
                                    &nbsp;
                                    <?php echo $data['value']; ?>
                                </span>
                            <?php } else { ?>
                                <span>
                                    <i class="<?php echo $data['class']; ?>"></i>
                                    <?php echo $data['label']; ?>: &nbsp;
                                    <?php echo $data['value']; ?>
                                </span>
                            <?php } ?>
                        <?php } ?>
                    <?php }
                ?>
            </div>
        <?php } else { ?>
            <div class="detail">
                <table class="table table-bordered">
                    <?php
                        foreach ($property_details as $key => $data) { ?>
                            <?php if ($data['value'] != '') { ?>
                            <?php $data['value'] = (preg_match('/(_|\b)area(_|\b)/', $key)) ? $data['value'].' '.rem_get_option('properties_area_unit', 'Sq Ft') : $data['value'] ; ?>
                                <?php if (rem_get_option('display_listing_features', 'icons_data') == 'icons_data') { ?>
                                    <tr>
                                        <td title="<?php echo $data['label']; ?>">
                                            <i class="<?php echo $data['class']; ?>"></i>
                                        </td>
                                        <td><?php echo $data['value']; ?></td>
                                    </tr>
                                <?php } elseif (rem_get_option('display_listing_features', 'icons_data') == 'labels_data') { ?>
                                    <tr>
                                        <td><?php echo $data['label']; ?></td>
                                        <td><?php echo $data['value']; ?></td>
                                    </tr>
                                <?php } else { ?>
                                    <tr>
                                        <td><i class="<?php echo $data['class']; ?>"></i></td>                                    
                                        <td><?php echo $data['label']; ?></td>
                                        <td><?php echo $data['value']; ?></td>
                                    </tr>
                                <?php } ?>
                            <?php } ?>
                        <?php }
                    ?>
                </table>
            </div>
        <?php }
    }

    function single_property_agent_form($author_id){
        $single_property_agent = rem_get_option('property_page_agent_card', 'enable');
        $p_sidebar = rem_get_option('property_page_sidebar', '');
        if ($single_property_agent == 'enable') {
            include REM_PATH . '/inc/sidebar-agent-contact.php';
        }
        if ( is_active_sidebar( $p_sidebar )  ) :
            dynamic_sidebar( $p_sidebar ); 
        endif;
    }

    function property_features($default_fields){

        if (rem_get_option('property_detail_fields') != '') {
            $options_arr = explode(PHP_EOL, rem_get_option('property_detail_fields'));
            $default_fields = array();
            foreach ($options_arr as $option) {
                $option = trim($option);
                if ($option != '') {
                    if (in_array($option, $default_fields)) {
                        $default_fields = array_diff($default_fields, array($option));
                    } else {
                        $default_fields[] = $option;
                    }
                }
            }
        }

        return $default_fields;
    }

    function property_types($default_fields){

        if (rem_get_option('property_type_options') != '') {
            $default_fields = array();
            $options_arr = explode(PHP_EOL, rem_get_option('property_type_options'));
            foreach ($options_arr as $option) {
                $option = trim($option);
                if ($option != '') {
                    if (in_array($option, $default_fields)) {
                        $default_fields = array_diff($default_fields, array($option));
                    } else {
                        $default_fields[$option] = $option;
                    }
                }
            }
        }

        return $default_fields;
    }

    function property_purposes($default_fields){

        if (rem_get_option('property_purpose_options') != '') {
            $options_arr = explode(PHP_EOL, rem_get_option('property_purpose_options'));
            $default_fields = array();
            foreach ($options_arr as $option) {
                $option = trim($option);
                if ($option != '') {
                    if (in_array($option, $default_fields)) {
                        $default_fields = array_diff($default_fields, array($option));
                    } else {
                        $default_fields[$option] = $option;
                    }
                }
            }
        }

        return $default_fields;
    }

    function property_statuses($default_fields){

        if (rem_get_option('property_status_options') != '') {
            $options_arr = explode(PHP_EOL, rem_get_option('property_status_options'));
            $default_fields = array();
            foreach ($options_arr as $option) {
                $option = trim($option);
                if ($option != '') {
                    if (in_array($option, $default_fields)) {
                        $default_fields = array_diff($default_fields, array($option));
                    } else {
                        $default_fields[$option] = $option;
                    }
                }
            }
        }

        return $default_fields;
    }

    function drag_icon($url){

        if (rem_get_option('maps_drag_image') != '') {
            $url = rem_get_option('maps_drag_image');
        }

        return $url;
    }

    function location_icon($url, $property_id){

        if (rem_get_option('maps_location_image') != '') {
            $url = rem_get_option('maps_location_image');
        }

        return $url;
    }

    function maps_api($api){

        if (rem_get_option('maps_api_key') != '') {
            $api = rem_get_option('maps_api_key');
        }

        return $api;
    }

    function single_property_slider($property_id){
        global $rem_ob;
        $property_images = get_post_meta( $property_id, 'rem_property_images', true );
        $price = get_post_meta($property_id, 'rem_property_price', true);
        $include_featured_image = (has_post_thumbnail( $property_id ) && rem_get_option('slider_featured_image', 'enable') == 'enable');
        if ($include_featured_image || is_array($property_images)) { ?>
            <?php if($price){ ?>
                <span class="large-price"><?php echo rem_display_property_price($property_id); ?></span>
            <?php } ?>

            <div class="fotorama-custom" <?php echo $this->fotorama_data_attrs(); ?>>
                <?php if($include_featured_image){
                    echo get_the_post_thumbnail( $property_id, 'full' );
                } ?>
                <?php if (is_array($property_images)) {
                    foreach ($property_images as $id) {
                        $image_url = wp_get_attachment_url( $id );
                        echo '<img src="'.$image_url.'">';
                    }
                } ?>
            </div>
        <?php }        
    }

    function fotorama_data_attrs(){
        $slider_width = rem_get_option('slider_width', '100%');
        $slider_height = rem_get_option('slider_height', '100%');
        $slider_fit = rem_get_option('slider_fit', 'cover');        
        $attrs = array(
            'allowfullscreen' => 'true',
            'width' => $slider_width,
            'height' => $slider_height,
            'fit' => $slider_fit,
            'max-width' => '100%',
            'nav' => 'thumbs',
            'transition' => 'slide',
        );
        $attrs = apply_filters( 'rem_fotorama_attrs', $attrs );
        $data_attrs = '';
        foreach ($attrs as $data => $value) {
            $data_attrs .= ' data-'.$data.'="'.$value.'"';
        }
        return $data_attrs;
    }

    function single_property_contents($property_id){
        ?>
            <div class="description">
                <?php
                    $content_property = get_post($property_id);
                    $content = $content_property->post_content;
                    $content = apply_filters('the_content', $content);
                    $content = str_replace(']]>', ']]&gt;', $content);
                    echo $content;
                ?>
            </div>            
        <?php
    }

    function single_property_title($property_id){
        ?>
            <div class="section-title line-style property-title">
                <h3 class="title"><?php echo get_the_title( $property_id ); ?></h3>
            </div>
        <?php
    }

    function single_property_features($property_id){
        $title = rem_get_option('single_property_features_text', __( 'Features', 'real-estate-manager' ));
        $property_details_cbs = get_post_meta( $property_id, 'rem_property_detail_cbs', true );
        if (is_array($property_details_cbs)) { ?>
            <div class="section-title line-style line-style">
                <h3 class="title"><?php _e( $title, 'real-estate-manager' ); ?></h3>
            </div>
            <div class="details property-features-container">
                <div class="row">
                    <?php foreach ($property_details_cbs as $option_name => $value) { ?>
                        <div class="col-sm-4 col-xs-12 wrap_<?php echo (str_replace(' ', '_', strtolower($option_name))); ?>">
                            <span class="detail"><i class="fa fa-square"></i>
                                <?php
                                    $feature = stripcslashes($option_name);
                                    $translated_feature = (function_exists('pll__')) ? pll__($feature) : _e( $feature, 'real-estate-manager' );
                                    echo $translated_feature;
                                ?>
                            </span>
                        </div>
                    <?php } ?>
                </div>
            </div>
        <?php }
    }

    function single_property_attachments($property_id){
        $attachment_data = get_post_meta( $property_id, 'rem_file_attachments', true );
        if ($attachment_data != '') {
            $attachments = explode(PHP_EOL, $attachment_data);
        }
        $title =  rem_get_option('single_property_attachments_text', __( 'Attachments', 'real-estate-manager' ));
        if (isset($attachments)) {
            $max_langth = apply_filters( 'rem_attachments_title_length', '15' ); ?>
            <div class="section-title line-style line-style">
                <h3 class="title"><?php _e( $title, 'real-estate-manager' ); ?></h3>
            </div>
            <div class="details attachments-wrap">
                <div class="row">
                    <?php foreach ($attachments as $a_id) {
                        if ($a_id != '') {
                            $a_id = intval($a_id);
                            $filename_only = basename( get_attached_file( $a_id ) );
                            $fullsize_path = get_attached_file( $a_id );
                            $attachment_title = get_the_title($a_id);
                            $display_title = ($attachment_title != '') ? $attachment_title : $filename_only ;                        
                            $file_url = wp_get_attachment_url( $a_id );
                            $file_type = wp_check_filetype_and_ext($fullsize_path, $filename_only);
                            $extension = ($file_type['ext']) ? $file_type['ext'] : 'file' ; ?>
                            <div class="col-sm-3 rem-attachment-icon">
                                <span class="file-type-icon pull-left <?php echo $extension; ?>" filetype="<?php echo $extension; ?>">
                                    <span class="fileCorner"></span>
                                </span>
                                <a target="_blank" href="<?php echo $file_url; ?>"><?php echo substr($display_title, 0, $max_langth); ?></a>
                            </div>
                    <?php
                        }
                    } ?>
                </div>        
            </div>
        <?php }        
    }    

    function single_property_video($property_id){
        $title = rem_get_option('single_property_video_text', __( 'Video', 'real-estate-manager' ));
        $property_video = get_post_meta($property_id, 'rem_property_video', true);
        if ($property_video != '') { ?>
            <div class="section-title line-style line-style">
                <h3 class="title"><?php _e( $title, 'real-estate-manager' ); ?></h3>
            </div>
            <div class="details">
                <div class="row">
                    <div class="col-sm-12 video-wrap">
                        <?php echo apply_filters( 'the_content', $property_video ); ?>
                    </div>
                </div>
            </div>
        <?php }
    }

    function single_property_tags($property_id){
        $terms = wp_get_post_terms( $property_id ,'rem_property_tag' );
        if (!empty($terms)) {
            $title = rem_get_option('single_property_tags_text', __( 'Tags', 'real-estate-manager' ));
            ?>
            <div class="section-title line-style">
                <h3 class="title"><?php _e( $title, 'real-estate-manager' ); ?></h3>
            </div>
            <?php
                 
            echo '<div id="filter-box">';
                 
                foreach ( $terms as $term ) {
                 
                    // The $term is an object, so we don't need to specify the $taxonomy.
                    $term_link = get_term_link( $term );
                    
                    // If there was an error, continue to the next term.
                    if ( is_wp_error( $term_link ) ) {
                        continue;
                    }
                 
                    // We successfully got a link. Print it out.
                    echo '<a class="filter" href="' . esc_url( $term_link ) . '">' . $term->name . ' <span class="glyphicon glyphicon-tags"></span></a>';
                }
                 
            echo '</div>';
        }
    }

    function single_property_edit_button($property_id){
        $current_user_data = wp_get_current_user();
        if (get_post_field( 'post_author', $property_id ) == $current_user_data->ID) {
            $edit_page_id = rem_get_option('property_edit_page', 1);
            $link_page = get_permalink( $edit_page_id );

            ?><br>
                <a class="btn btn-default" href="<?php echo esc_url( add_query_arg( 'property_id', $property_id, $link_page ) ); ?>"><?php _e( 'Edit Property', 'real-estate-manager' ); ?></a>
            <?php
        }
    }

    function single_property_map($property_id){
        $title    = rem_get_option('single_property_maps_text', __( 'Find on Map', 'real-estate-manager' ));
        
        if (rem_single_property_has_map($property_id)) { ?>
            <div class="section-title line-style">
                <h3 class="title"><?php _e( $title, 'real-estate-manager' ); ?></h3>
            </div>
            <div class="map-container" id="map-canvas"></div>
        <?php }
    }

    function single_property_details($property_id){
        $title = rem_get_option('single_property_details_text', __( 'Details', 'real-estate-manager' ) );

        global $rem_ob;

        $all_fields = $rem_ob->single_property_fields();
        ?>
        <div class="section-title line-style line-style">
            <h3 class="title"><?php _e( $title, 'real-estate-manager' ); ?></h3>
        </div>
        <div class="details property-details-box">
            <div class="row">
                <?php if (rem_get_option('display_p_id', 'enable') == 'enable') { ?>
                    <div class="col-sm-4 col-xs-12 wrap_property_id">
                        <div class="details no-padding">
                            <div class="detail" style="padding: 6px 15px;">
                                <strong><?php _e( 'ID', 'real-estate-manager' ); ?></strong> : <?php echo $property_id; ?> 
                            </div>
                        </div>
                    </div>
                <?php } ?>

                <?php foreach ($all_fields as $field) {
                    $field_tab = (isset($field['tab'])) ? $field['tab'] : '' ;
                    $label = $field['title'];
                    $key = $field['key'];
                    $accessibility = (isset($field['accessibility'])) ? $field['accessibility'] : 'public' ;
                    $value = get_post_meta($property_id, 'rem_'.$key, true);
                    if ($value != '' && $accessibility == 'public' && $key != 'property_sale_price' && $key != 'property_featured' && ($field_tab == 'general_settings' || $field_tab == 'internal_structure')) { ?>
                        <div class="col-sm-4 col-xs-12 wrap_<?php echo $key; ?>">
                            <div class="details no-padding">
                              <div class="detail" style="padding: 6px 15px;">
                                <?php
                                    if ('property_price' == $key){
                                        $val_to_show = rem_display_property_price($property_id);
                                    } elseif (preg_match('/(_|\b)area(_|\b)/', $key)){
                                        $val_to_show = stripcslashes($value).' '. rem_get_option('properties_area_unit', 'Sq Ft');  
                                    } elseif (preg_match('/(_|\b)price(_|\b)/', $key)){
                                        $val_to_show = rem_get_property_price($value);  
                                    } else {
                                        $val_to_show = stripcslashes($value);
                                    }
                                    if (isset($field['type']) && $field['type'] == 'date') {
                                        $format = rem_get_option('date_format', 'd-m-Y');
                                        $retVal = date($format, strtotime($val_to_show));
                                    } else {
                                        $retVal = (function_exists('pll__')) ? pll__($val_to_show) : __($val_to_show, 'real-estate-manager' );
                                    }
                                ?>
                                <strong><?php echo stripcslashes($label); ?></strong> : <?php echo $retVal; ?>
                              </div>
                            </div>
                        </div>
                    <?php }
                } ?>
            </div>
        </div>

        <?php
    }

    function single_property_additional_tabs($property_id){
        $property_tabs = rem_get_single_property_settings_tabs();
        global $rem_ob;
        $all_fields = $rem_ob->single_property_fields();
        $valid_tabs = array();
        foreach ($property_tabs as $tab_key => $tab_title) {
            foreach ($all_fields as $field) {
                $field_tab = (isset($field['tab'])) ? $field['tab'] : '' ;
                $key = $field['key'];
                $value = get_post_meta($property_id, 'rem_'.$key, true);
                if ($value != '') {
                   $valid_tabs[] = $field_tab; 
                }
            }
        }
        foreach ($property_tabs as $tab_key => $tab_title) {
            if (in_array($tab_key, $valid_tabs) && $tab_key != 'general_settings' && $tab_key != 'internal_structure' && $tab_key != 'property_details' && $tab_key != 'property_attachments' && $tab_key != 'property_video' && $tab_key != 'private_fields') {
                ?>
                <div class="section-title line-style line-style <?php echo $tab_key; ?>">
                    <h3 class="title"><?php _e( $tab_title, 'real-estate-manager' ); ?></h3>
                </div>
                <div class="details tab-<?php echo $tab_key; ?>">
                    <div class="row">

                        <?php foreach ($all_fields as $field) {
                            $field_tab = (isset($field['tab'])) ? $field['tab'] : '' ;
                            $label = $field['title'];
                            $key = $field['key'];
                            $value = get_post_meta($property_id, 'rem_'.$key, true);
                            if ($value != '' && $field_tab == $tab_key) { ?>
                                <div class="col-sm-4 col-xs-12 wrap_<?php echo $key; ?>">
                                    <div class="details no-padding">
                                      <div class="detail" style="padding: 6px 15px;">
                                        <?php
                                            if (isset($field['type']) && $field['type'] == 'date') {
                                                $format = rem_get_option('date_format', 'd-m-Y');
                                                $val_to_show = date($format, strtotime($value));
                                            }
                                             elseif ('property_price' == $key){
                                                $val_to_show = rem_display_property_price($property_id);
                                            } elseif (preg_match('/(_|\b)area(_|\b)/', $key)){
                                                $val_to_show = $value.' '. rem_get_option('properties_area_unit', 'Sq Ft');  
                                            } elseif (preg_match('/(_|\b)price(_|\b)/', $key)){
                                                $val_to_show = rem_get_property_price($value);  
                                            } else {
                                                $val_to_show = $value;
                                            }
                                        ?>
                                        <strong><?php echo stripcslashes($label); ?></strong> : <?php _e( stripcslashes($val_to_show), 'real-estate-manager' ); ?>
                                      </div>
                                    </div>
                                </div>
                            <?php }
                        } ?>
                    </div>
                </div>
            <?php
                
            }

            if (in_array($tab_key, $valid_tabs) && $tab_key == 'private_fields' && is_user_logged_in()) {
                $current_user_data = wp_get_current_user();
                if (get_post_field( 'post_author', $property_id ) == $current_user_data->ID) { ?>
                <div class="section-title line-style line-style <?php echo $tab_key; ?>">
                    <h3 class="title"><?php echo $tab_title; ?></h3>
                </div>
                <div class="details tab-<?php echo $tab_key; ?>">
                    <div class="row">

                        <?php foreach ($all_fields as $field) {
                            $field_tab = (isset($field['tab'])) ? $field['tab'] : '' ;
                            $label = $field['title'];
                            $key = $field['key'];
                            $value = get_post_meta($property_id, 'rem_'.$key, true);
                            if ($value != '' && $field_tab == $tab_key) { ?>
                                <div class="col-sm-4 col-xs-12 wrap_<?php echo $key; ?>">
                                    <div class="details no-padding">
                                      <div class="detail" style="padding: 6px 15px;">
                                        <?php
                                            $val_to_show = '';
                                            if (isset($field['type']) && $field['type'] == 'date') {
                                                $format = rem_get_option('date_format', 'd-m-Y');
                                                $val_to_show = date($format, strtotime($value));
                                            }                                        
                                            $val_to_show = ('property_price' == $key) ? rem_display_property_price($property_id) : $val_to_show ;
                                            $val_to_show = ('property_area' == $key) ? $value.' '. rem_get_option('properties_area_unit', 'Sq Ft') : $val_to_show ;
                                            if ($val_to_show == '') {
                                                $val_to_show = $value;
                                            }
                                        ?>
                                        <strong><?php echo stripcslashes($label); ?></strong> : <?php echo stripcslashes($val_to_show); ?>
                                      </div>
                                    </div>
                                </div>
                            <?php }
                        } ?>
                    </div>
                </div>
                <?php }
            }
        }


    }

    function contact_social_icons($agent_id){
        global $rem_ob;
        $agent_fields = $rem_ob->get_agent_fields();
        $count = 0;
        foreach ($agent_fields as $field) {
            if ((isset($field['display']) && in_array('card', $field['display']) && get_user_meta( $agent_id, $field['key'] , true ) != '') || $field['key'] == 'rem_agent_url') {
              $count++;
            }
        }
        echo '<ul class="contact">';
        
            foreach ($agent_fields as $field) {
                if ((isset($field['display']) && in_array('card', $field['display']) && get_user_meta( $agent_id, $field['key'] , true ) != '') || $field['key'] == 'rem_agent_url') {
                    $url = get_user_meta( $agent_id, $field['key'] , true );
                    $target = '_blank';

                    if($field['key'] == 'rem_mobile_url'){
                        $target = '';
                    }

                    if($field['key'] == 'rem_agent_url'){
                        $url = ($url != '') ? $url : get_author_posts_url( $agent_id ) ;
                        $target = '';
                    }
                    if ($url != '' && $url != 'disable') { ?>
                        <li style="width: <?php echo 100/$count; ?>%;">
                            <a class="icon" href="<?php echo $url; ?>" target="<?php echo $target; ?>">
                                <i class="<?php echo $field['icon_class']; ?>"></i>
                            </a>
                        </li>
                    <?php
                    } 
                }
            } ?>
        <?php
        echo '</ul>';
    }

    function display_agent_custom_data($agent_id){
        global $rem_ob;
        $agent_fields = $rem_ob->get_agent_fields();

        echo '<table class="table table-bordered">';
        foreach ($agent_fields as $field) {
            if (isset($field['display']) && in_array('content', $field['display']) && get_user_meta( $agent_id, $field['key'] , true ) != '') { ?>
                <tr>
                    <th><?php echo $field['title']; ?></th>
                    <td><?php echo get_user_meta( $agent_id, $field['key'] , true ); ?></td>
                </tr>
            <?php }
        }
        echo '</table>';
    }

    function display_agent_contact_form($author_id){
        if (rem_get_option('agent_page_display_cform', 'enable') == 'enable') {
            $custom_form = get_the_author_meta( 'rem_user_contact_sc', $author_id );
                if ($custom_form != '') {
                    echo do_shortcode( $custom_form );
                } else {
            ?>
                <form class="form-contact" method="post" action="" id="contact-agent" role="form" data-toggle="validator" data-ajaxurl="<?php echo admin_url( 'admin-ajax.php' ); ?>">
                    <div class="row">
                        <div class="col-md-6 col-sm-12">
                            <input type="hidden" name="agent_id" value="<?php echo $author_id; ?>">
                            <input type="hidden" name="action" value="rem_contact_agent">               
                            <input name="client_name" id="name" type="text" class="form-control" placeholder="<?php _e( 'Name', 'real-estate-manager' ); ?> *" required>
                        </div>
                        <div class="col-md-6 col-sm-12">
                            <input type="email" class="form-control" name="client_email" id="email" placeholder="<?php _e( 'Email', 'real-estate-manager' ); ?> *" required>
                        </div>
                        <div class="col-md-12 col-sm-12">
                            <input name="subject" id="subject" type="text" class="form-control" placeholder="<?php _e( 'Subject', 'real-estate-manager' ); ?> *">
                        </div>
                        <div class="col-md-12 col-sm-12">
                            <textarea name="client_msg" id="text-message" class="form-control text-form" placeholder="<?php _e( 'Your Message', 'real-estate-manager' ); ?> *" required></textarea>
                        </div>
                        <div class="col-sm-12">
                            <?php do_action( 'rem_agent_contact_before_submit', $author_id ); ?>
                        </div>
                        <div class="col-md-12 col-sm-12">
                            <button type="submit" class="btn btn-default"><span class=""></span> <?php _e( 'SEND MESSAGE', 'real-estate-manager' ); ?></button>
                        </div>
                    </div><!-- /.row -->
                </form><!-- /.form -->
                <br>
                <div class="alert with-icon alert-info sending-email" style="display:none;" role="alert">
                    <i class="icon fa fa-info"></i>
                    <span class="msg"><?php _e( 'Sending Email, Please Wait...', 'real-estate-manager' ); ?></span>
                </div>
            <?php }
        }
    }

    function render_rem_pagination($paged = '', $max_page = ''){
        global $wp_query;
        wp_enqueue_script( 'rem-pagination', REM_URL . '/assets/front/js/pagination.js' , array('jquery'));
        $big = 999999999; // need an unlikely integer
        if( ! $paged )
            $paged = get_query_var('paged');
        if( ! $max_page )
            $max_page = $wp_query->max_num_pages;
        echo '<div class="text-center">';
        $search_for   = array( $big, '#038;' );
        $replace_with = array( '%#%', '&' );          
        echo paginate_links( array(
            'base'       => str_replace($search_for, $replace_with, esc_url(get_pagenum_link( $big ))),
            'format'     => '?paged=%#%',
            'current'    => max( 1, $paged ),
            'total'      => $max_page,
            'mid_size'   => 1,
            'prev_text'  => __('«', 'real-estate-manager'),
            'next_text'  => __('»', 'real-estate-manager'),
            'type'       => 'list'
        ) );
        echo '</div>';
    }

    function custom_archive_title($title){
        if( is_tax('rem_property_tag') ) {
            $title = (rem_get_option('archive_title') != '') ? str_replace('%tag%', single_cat_title( '', false ), rem_get_option('archive_title')) : __( 'Tag:', 'real-estate-manager' ).single_cat_title( '', false ) ;
        }
        if (is_post_type_archive( 'rem_property' )) {
            $title = (rem_get_option('archive_title_properties') != '') ? rem_get_option('archive_title_properties') : __( 'Properties:', 'real-estate-manager' );
        }
        return $title;        
    }

    function archive_page_properties_count($query){
        if ( is_admin() || ! $query->is_main_query() ) {
            return;
        }
        $number_of_properties = rem_get_option('properties_per_page_archive', 10);
        if (is_tax('rem_property_tag')) {
            $query->set( 'posts_per_page', $number_of_properties );
        }
    }

    function rem_action_btns($links, $file){
        if ( strpos( $file, 'rem.php' ) !== false ) {
            $settings_url = admin_url( 'edit.php?post_type=rem_property&page=rem_settings' );
            $new_links = array(
                    'rem_settings' => '<a href="'.$settings_url.'">'.__( 'Settings', 'real-estate-manager' ).'</a>',
                    'rem_custom'       => '<a href="https://webcodingplace.com/real-estate-manager-wordpress-plugin/" target="_blank"><strong>'.__( 'Upgrade to Pro', 'real-estate-manager' ).'</strong></a>'
                    );
            
            $links = array_merge( $links, $new_links );
        }
        
        return $links;
    }

    function rem_redirect_after_submission($url, $meta){
        if (rem_get_option('property_submit_redirect') != '') {
            return esc_url(rem_get_option('property_submit_redirect'));
        } else {
            return $url;
        }
    }

    function rem_redirect_after_editing_property($url, $meta){
        if (rem_get_option('property_edit_redirect') != '') {
            return esc_url(rem_get_option('property_edit_redirect'));
        } else {
            return $url;
        }
    }

    function show_current_user_attachments($query){
        $user_id = get_current_user_id();
        if ( $user_id && !current_user_can('activate_plugins') && !current_user_can('edit_others_rem_properties') ) {
            $query['author'] = $user_id;
        }
        return $query;
    }

    function allow_attachment_actions( $user_caps, $req_cap, $args ){
      // if no property is connected with capabilities check just return original array
      if ( empty($args[2]) )
        return $user_caps;
      $post = get_post( $args[2] );

      if ( isset($post->post_type) && 'attachment' == $post->post_type ) {
        $user_caps[$req_cap[0]] = true;
        return $user_caps;
      }

      // for any other post type return original capabilities
      return $user_caps;
    }

    function add_ribbon_with_listings($property_id, $page = 'list-view'){

        $sold_ribbon_text = rem_get_option('property_sold_ribbon_text', '');
        $featured_ribbon_text = rem_get_option('property_featured_ribbon_text', '');
        $sale_ribbon_text = rem_get_option('property_sale_ribbon_text', '');
        $rent_ribbon_text = rem_get_option('property_rent_ribbon_text', '');
        $sell_ribbon_text = rem_get_option('property_sell_ribbon_text', '');

        $custom_ribbon_text = rem_get_option('custom_ribbon_text', '');
        $custom_ribbon = rem_get_option('listings_ribbon_type', '');

        $text_to_display = '';

        if ($sold_ribbon_text != '' && strtolower(get_post_meta( $property_id, 'rem_property_status', true )) == 'sold') {
            $text_to_display = $sold_ribbon_text;
        } elseif ($featured_ribbon_text != '' && strtolower(get_post_meta( $property_id, 'rem_property_featured', true )) == 'yes') {
            $text_to_display = $featured_ribbon_text;
        } elseif ($sale_ribbon_text != '' && strtolower(get_post_meta( $property_id, 'rem_property_sale_price', true )) != '') {
            $text_to_display = $sale_ribbon_text;
        } elseif ($rent_ribbon_text != '' && strtolower(get_post_meta( $property_id, 'rem_property_purpose', true )) == 'rent') {
            $text_to_display = $rent_ribbon_text;
        } elseif ($sell_ribbon_text != '' && strtolower(get_post_meta( $property_id, 'rem_property_purpose', true )) == 'sell') {
            $text_to_display = $sell_ribbon_text;
        } elseif ($custom_ribbon_text != '' && $custom_ribbon != '') {
            $custom_ribbon_type = explode("=", $custom_ribbon);
            if(isset($custom_ribbon_type[1]) && $custom_ribbon_type[1] == 'ANY'){
                if (get_post_meta( $property_id, 'rem_'.$custom_ribbon_type[0], true ) != '') {
                    $text_to_display = $custom_ribbon_text;
                    if (get_post_meta( $property_id, 'rem_'.$custom_ribbon_text, true ) != '') {
                        $text_to_display =  get_post_meta( $property_id, 'rem_'.$custom_ribbon_text, true );
                    }
                }
            } else {
                if (get_post_meta( $property_id, 'rem_'.$custom_ribbon_type[0], true ) == $custom_ribbon_type[1]) {
                    $text_to_display = $custom_ribbon_text;
                    if (get_post_meta( $property_id, 'rem_'.$custom_ribbon_text, true ) != '') {
                        $text_to_display =  get_post_meta( $property_id, 'rem_'.$custom_ribbon_text, true );
                    }
                }
            }
        }

        $ribbon_style = rem_get_option('ribbon_style', 'rem-sale rem-sale-top-left');

        $text_to_display = apply_filters( 'rem_ribbon_text', $text_to_display, $property_id );

        if ($text_to_display != '') {
            if ($page == 'single-page') { ?>
                <div class="single-property-page-ribbon <?php echo rem_string_into_id($text_to_display); ?>">
                    <div><?php _e( $text_to_display, 'real-estate-manager' ); ?></div>
                </div>
            <?php } else { ?>
                <div class="<?php echo $ribbon_style; ?> <?php echo rem_string_into_id($text_to_display); ?>"><span>
                    <?php _e( $text_to_display, 'real-estate-manager' ); ?>
                </span></div>
            <?php }?>
        <?php }
    }

    function rem_custom_listing_icons($property_details, $property_id){
        if (rem_get_option('custom_listing_features') != '') {
            $custom_features_data = rem_get_option('custom_listing_features');
            $custom_features = explode("\n", $custom_features_data);
            $property_details = array();
            foreach ($custom_features as $key => $single_feature) {
                $cfexpd = explode(",", $single_feature);
                $property_details['feature_'.trim($cfexpd[1])] = array(
                    'label' => (isset($cfexpd[0])) ? trim($cfexpd[0]) : '',
                    'class' => (isset($cfexpd[2])) ? trim($cfexpd[2]) : '',
                    'value' => get_post_meta($property_id, 'rem_'.trim($cfexpd[1]), true),
                );
            }
        }
        return $property_details;
    }

    function property_edit_create_columns($col_class, $field){
        if ($field['type'] == 'upload' || $field['key'] == 'property_video') {
            $col_class = 'col-sm-12';
        }
        return $col_class;
    }

    function property_settings_tabs($tabsData){
        if (rem_get_option('property_settings_tabs', '') != '') {
            $additional_tabs = explode("\n", rem_get_option('property_settings_tabs'));
            foreach ($additional_tabs as $tab_title) {
                if ($tab_title != '') {
                    $tab_key = str_replace(' ', '_', $tab_title);
                    $tab_key = strtolower($tab_key);
                    $tab_key = preg_replace('/[^A-Za-z0-9\-]/', '', $tab_key);
                    $tabsData[$tab_key] = $tab_title;
                }
            }
        }
        return $tabsData;
    }

    function property_details_add_more_instruction(){
        ?>
        <div class="alert alert-info"><?php _e( 'You can add more features', 'real-estate-manager' ); ?>
        <a target="_blank" href="<?php echo admin_url('edit.php?post_type=rem_property&page=rem_settings#property-settings'); ?>"><?php _e( 'here', 'real-estate-manager' ); ?></a></div>
        <?php
    }

    function random_display_agents( $class ) {
       if( isset($class->query_vars['orderby']) && 'rand' == $class->query_vars['orderby'] )
           $class->query_orderby = str_replace( 'user_login', 'RAND()', $class->query_orderby );
       return $class;
    }

    function templates_apply_max_width($width){
        if (rem_get_option('templates_max_width') != '') {
            return rem_get_option('templates_max_width');
        }
        return $width;
    }

    function display_gdpr_checkbox($agent_id){
        if (rem_get_option('gdpr_message') != '') {
            echo '<div><input type="checkbox" required> '.stripcslashes(rem_get_option('gdpr_message')).'</div><br>';
        }
    }

    function rem_property_column_head($defaults){
        $new_fields = array(
            'wcp_pid' => __( 'Property ID', 'real-estate-manager' ),
            'wcp_pthumb' => __( 'Featured Image', 'real-estate-manager' ),
        );

        return $defaults+$new_fields;
    }

    function rem_property_column_content($column_name, $p_id){
        if ($column_name == 'wcp_pid') {
            echo $p_id;
        }
        if ($column_name == 'wcp_pthumb') {
            echo get_the_post_thumbnail( $p_id, array(50,50) );
        }
    }

    function insert_captcha($agent_id){
        if (rem_get_option('captcha_on_agent_contact') == 'on') { ?>
            <script src='https://www.google.com/recaptcha/api.js'></script>
            <div class="g-recaptcha" style="transform:scale(0.77);-webkit-transform:scale(0.77);transform-origin:0 0;-webkit-transform-origin:0 0;" data-sitekey="<?php echo rem_get_option('captcha_site_key', '6LcDhUQUAAAAAFAsfyTUPCwDIyXIUqvJiVjim2E9'); ?>"></div>
            <br>
        <?php }
    }
}
?>