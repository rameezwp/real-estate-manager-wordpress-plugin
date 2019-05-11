<?php
    $inputFields = array(
        array(
            'key' => 'property_price',
            'type' => 'text',
            'tab' => 'general_settings',
            'default' => '',
            'title' => __( 'Price', 'real-estate-manager' ),
            'help' => __( 'Regular Price of Property', 'real-estate-manager' ),
            'editable' => false,
            'accessibility' => 'public',
        ),
        array(
            'key' => 'before_price_text',
            'type' => 'text',
            'tab' => 'general_settings',
            'default' => '',
            'title' => __( 'Before Price', 'real-estate-manager' ),
            'help' => __( 'Text to display before price, Eg: Starting From', 'real-estate-manager' ),
            'editable' => false,
            'accessibility' => 'agent',
        ),
        array(
            'key' => 'after_price_text',
            'type' => 'text',
            'tab' => 'general_settings',
            'default' => '',
            'title' => __( 'After Price', 'real-estate-manager' ),
            'help' => __( 'Text to display after price, Eg: / Month', 'real-estate-manager' ),
            'editable' => false,
            'accessibility' => 'agent',
        ),
        array(
            'key' => 'property_sale_price',
            'type' => 'text',
            'tab' => 'general_settings',
            'default' => '',
            'title' => __( 'Sale Price', 'real-estate-manager' ),
            'help' => __( 'Sale Price of Property', 'real-estate-manager' ),
            'editable' => false,
            'accessibility' => 'public',
        ),
        array(
            'key' => 'property_latitude',
            'type' => 'text',
            'tab' => 'general_settings',
            'default' => '',
            'title' => __( 'Latitude', 'real-estate-manager' ),
            'help' => __( 'Latitude of property, will use for map', 'real-estate-manager' ),
            'editable' => false,
            'accessibility' => 'agent',
        ),
        array(
            'key' => 'property_longitude',
            'type' => 'text',
            'tab' => 'general_settings',
            'default' => '',
            'title' => __( 'Longitude', 'real-estate-manager' ),
            'help' => __( 'Longitude of property, will use for map', 'real-estate-manager' ),
            'editable' => false,
            'accessibility' => 'agent',
        ),
        array(
            'key' => 'property_video',
            'type' => 'text',
            'tab' => 'property_video',
            'default' => '',
            'title' => __( 'Video URL', 'real-estate-manager' ),
            'help' => __( 'Provide video URL', 'real-estate-manager' ),
            'editable' => false,
            'accessibility' => 'agent',
        ),
        array(
            'key' => 'file_attachments',
            'type' => 'upload',
            'tab' => 'property_attachments',
            'default' => '',
            'title' => __( 'File Attachments', 'real-estate-manager' ),
            'help' => __( 'One file ID per line', 'real-estate-manager' ),
            'editable' => false,
            'accessibility' => 'agent',
        ),

        array(
            'key' => 'property_type',
            'type' => 'select',
            'tab' => 'general_settings',
            'default' => 'duplex',
            'title' => __( 'Property Type', 'real-estate-manager' ),
            'help' => __( 'Choose type of property', 'real-estate-manager' ),
            'options'   => $this->get_all_property_types(),
            'editable' => false,
            'accessibility' => 'public',
        ),

        array(
            'key' => 'property_purpose',
            'type' => 'select',
            'tab' => 'general_settings',
            'default' => 'sale',
            'title' => __( 'Purpose', 'real-estate-manager' ),
            'help' => __( 'Choose purpose of property', 'real-estate-manager' ),
            'options'   => $this->get_all_property_purpose(),
            'editable' => false,
            'accessibility' => 'public',
        ),
        array(
            'key' => 'property_status',
            'type' => 'select',
            'tab' => 'general_settings',
            'default' => 'normal',
            'title' => __( 'Status', 'real-estate-manager' ),
            'help' => __( 'Choose status of property', 'real-estate-manager' ),
            'options'   => $this->get_all_property_status(),
            'editable' => false,
            'accessibility' => 'public',
        ),
        array(
            'key' => 'property_bedrooms',
            'type' => 'text',
            'tab' => 'internal_structure',
            'default' => '',
            'title' => __( 'Bedrooms', 'real-estate-manager' ),
            'help' => __( 'Number of bedrooms', 'real-estate-manager' ),
            'editable' => false,
            'accessibility' => 'public',
        ),

        array(
            'key' => 'property_bathrooms',
            'type' => 'text',
            'tab' => 'internal_structure',
            'default' => '',
            'title' => __( 'Bathrooms', 'real-estate-manager' ),
            'help' => __( 'Number of bathrooms', 'real-estate-manager' ),
            'editable' => false,
            'accessibility' => 'public',
        ),

        array(
            'key' => 'property_area',
            'type' => 'text',
            'tab' => 'general_settings',
            'default' => '',
            'title' => __( 'Area', 'real-estate-manager' ),
            'help' => __( 'Size - ', 'real-estate-manager' ).$area_unit,
            'editable' => true,
            'accessibility' => 'public',
        ),

        array(
            'key' => 'property_address',
            'type' => 'text',
            'tab' => 'general_settings',
            'default' => '',
            'title' => __( 'Address', 'real-estate-manager' ),
            'help' => __( 'If latitude and longitude fields are blank, this address will be used for rendering map', 'real-estate-manager' ),
            'editable' => true,
            'accessibility' => 'public',
        ),

        array(
            'key' => 'property_state',
            'type' => 'text',
            'tab' => 'general_settings',
            'default' => '',
            'title' => __( 'State', 'real-estate-manager' ),
            'help' => __( 'State', 'real-estate-manager' ),
            'editable' => true,
            'accessibility' => 'public',
        ),

        array(
            'key' => 'property_zipcode',
            'type' => 'text',
            'tab' => 'general_settings',
            'default' => '',
            'title' => __( 'Zip Code', 'real-estate-manager' ),
            'help' => __( 'Zipcode', 'real-estate-manager' ),
            'editable' => true,
            'accessibility' => 'public',
        ),

        array(
            'key' => 'property_city',
            'type' => 'text',
            'tab' => 'general_settings',
            'default' => '',
            'title' => __( 'City', 'real-estate-manager' ),
            'help' => __( 'City', 'real-estate-manager' ),
            'editable' => true,
            'accessibility' => 'public',
        ),

        array(
            'key' => 'property_country',
            'type' => 'text',
            'tab' => 'general_settings',
            'default' => '',
            'title' => __( 'Country', 'real-estate-manager' ),
            'help' => __( 'Country', 'real-estate-manager' ),
            'editable' => true,
            'accessibility' => 'public',
        ),

        array(
            'key' => 'property_rooms',
            'type' => 'number',
            'tab' => 'internal_structure',
            'default' => '',
            'title' => __( 'Rooms', 'real-estate-manager' ),
            'help' => __( 'Number of rooms', 'real-estate-manager' ),
            'editable' => true,
            'accessibility' => 'public',
        ),

        array(
            'key' => 'property_featured',
            'type' => 'select',
            'tab' => 'general_settings',
            'default' => '',
            'title' => __( 'Featured Property', 'real-estate-manager' ),
            'help' => __( 'Make it featured', 'real-estate-manager' ),
            'options' => array(
                __( 'No', 'real-estate-manager' ),
                __( 'Yes', 'real-estate-manager' ),
            ),
            'editable' => false,
            'accessibility' => 'agent',
        ),        
    );
?>