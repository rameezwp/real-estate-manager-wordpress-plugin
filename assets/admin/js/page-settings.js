jQuery(document).ready(function($) {
    $('select').select2();
    $('.wcp-progress').hide();
    var icons = {
        header: "dashicons dashicons-plus",
        activeHeader: "dashicons dashicons-minus"
    }

    // tabs relates
    $("#rem-settings-form .panel-default").hide().first().show();
    $(".wcp-tabs-menu a:first").addClass("active");
    $(".wcp-tabs-menu a").on('click', function (e) {
        e.preventDefault();
        $(this).addClass("active").siblings().removeClass("active");
        $($(this).attr('href')).show().siblings('.panel-default').hide();
    });
    var hash = $.trim( window.location.hash );
    if (hash) $('.wcp-tabs-menu a[href$="'+hash+'"]').trigger('click');


	$('#rem-settings-form').submit(function(event) {
		event.preventDefault();
        $('.wcp-progress').show();
        var data = $(this).serialize();

        $.post(ajaxurl, data, function(resp) {
            $('.wcp-progress').hide();
            swal(resp.title, resp.message, resp.status);
		}, 'json');
	});

    $('.colorpicker').wpColorPicker();

    // Media Uploader
    var ich_cpt_uploader;
     
    jQuery('.upload_image_button').live('click', function( event ){
     
        event.preventDefault();

        var this_widget = jQuery(this).closest('.form-group');
     
        // Create the media frame.
        ich_cpt_uploader = wp.media.frames.ich_cpt_uploader = wp.media({
          title: jQuery( this ).data( 'title' ),
          button: {
            text: jQuery( this ).data( 'btntext' ),
          },
          multiple: false  // Set to true to allow multiple files to be selected
        });
     
        // When an image is selected, run a callback.
        ich_cpt_uploader.on( 'select', function() {
          // We set multiple to false so only get one image from the uploader
          attachment = ich_cpt_uploader.state().get('selection').first().toJSON();
            jQuery(this_widget).find('.image-url').val(attachment.url);
        });
     
        // Finally, open the modal
        ich_cpt_uploader.open();
    });

    // Google Maps and Leaflet Switch Settings
    if ($('#use_map_from').val() == 'leaflet') {
        $('.wrap_maps_api_key').hide();
        $('.wrap_maps_type').hide();
        $('.wrap_maps_property_image_hover').hide();
        $('.wrap_maps_my_location_image').hide();
        $('.wrap_maps_styles').hide();
        $('.wrap_maps_circle_image').hide();
    } else {
        $('.wrap_leaflet_style').hide();
    }

    $('#use_map_from').change(function(event) {
        event.preventDefault();
        if ($(this).val() == 'google_maps') {
            $('.wrap_maps_api_key').show();
            $('.wrap_maps_api_key').show();
            $('.wrap_maps_type').show();
            $('.wrap_maps_property_image_hover').show();
            $('.wrap_maps_my_location_image').show();
            $('.wrap_maps_styles').show();            
            $('.wrap_maps_circle_image').show();
            $('.wrap_leaflet_style').hide();
        } else {
            $('.wrap_maps_api_key').hide();
            $('.wrap_maps_api_key').hide();
            $('.wrap_maps_type').hide();
            $('.wrap_maps_property_image_hover').hide();
            $('.wrap_maps_my_location_image').hide();
            $('.wrap_maps_styles').hide();            
            $('.wrap_maps_circle_image').hide();
            $('.wrap_leaflet_style').show();            
        }
    });
});