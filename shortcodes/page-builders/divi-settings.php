<?php
/**
* Classes for Divi Modules
*/

function rem_vc_into_divi_settings($sc){
	$fields = rem_page_builder_fields($sc);
	$divi_fields = array();
	foreach ($fields as $field) {
		$settings_arr = array();
		foreach ($field as $key => $value) {
			if ($key == 'type' && $value == 'dropdown') {
				$value = 'select';
			}
			if($key == 'value' && is_array($value)){
				$value = array_flip($value);
				$key = 'options';
			}
			if ($key == 'heading') {
				$key = 'label';
			}
			if ($key == 'type' && $value == 'textfield') {
				$value = 'text';
			}
			if ($key == 'type' && $value == 'colorpicker') {
				$value = 'color';
			}
			if ($key == 'type' && $value == 'exploded_textarea') {
				$value = 'textarea';
			}
			if ($key == 'type' && $value == 'textarea_html') {
				$value = 'tiny_mce';
			}
			if ($key == 'type' && $value == 'checkbox') {
				$value = 'multiple_checkboxes';
			}
			$settings_arr[$key] =	$value;
		}
		$divi_fields[$field['param_name']] = $settings_arr;
	}
	return $divi_fields;
}

class Divi_REM_List_Properties extends ET_Builder_Module
{
	
	function init() {
	    $this -> name = __('List Properties', 'real-estate-manager');
	    $this -> slug = 'et_pb_rem_list_properties';
	    $this -> icon = 'P';
	}

	function get_fields() {
		return rem_vc_into_divi_settings('rem_list_properties');
	}
	
	public function render( $unprocessed_props, $content = null, $render_slug ) {
		global $rem_sc_ob;
		return $rem_sc_ob->list_properties($unprocessed_props, $content);
	}	
}

class Divi_REM_Register_Agent extends ET_Builder_Module
{
	
	function init() {
	    $this -> name = __('Register Agent', 'real-estate-manager');
	    $this -> slug = 'et_pb_rem_register_agent';
	    $this -> icon = 'G';
	}

	function get_fields() {
		return rem_vc_into_divi_settings('rem_register_agent');
	}
	
	public function render( $unprocessed_props, $content = null, $render_slug ) {
		global $rem_sc_ob;
		return $rem_sc_ob->register_agent($unprocessed_props, $content);
	}	
}

class Divi_REM_Edit_Agent extends ET_Builder_Module
{
	
	function init() {
	    $this -> name = __('Edit Agent Form', 'real-estate-manager');
	    $this -> slug = 'et_pb_rem_agent_edit';
	    $this -> icon = 'G';
	}

	function get_fields() {
		return rem_vc_into_divi_settings('rem_agent_edit');
	}
	
	public function render( $unprocessed_props, $content = null, $render_slug ) {
		global $rem_sc_ob;
		return $rem_sc_ob->edit_agent($unprocessed_props, $content);
	}	
}

class Divi_REM_Login_Agent extends ET_Builder_Module
{
	
	function init() {
	    $this -> name = __('Login Agent Form', 'real-estate-manager');
	    $this -> slug = 'et_pb_rem_agent_login';
	    $this -> icon = 'G';
	}

	function get_fields() {
		return rem_vc_into_divi_settings('rem_agent_login');
	}
	
	public function render( $unprocessed_props, $content = null, $render_slug ) {
		global $rem_sc_ob;
		return $rem_sc_ob->login_agent($unprocessed_props, $content);
	}	
}

class Divi_REM_Create_Property extends ET_Builder_Module
{
	
	function init() {
	    $this -> name = __('Create Property Form', 'real-estate-manager');
	    $this -> slug = 'et_pb_rem_create_property';
	    $this -> icon = 'V';
	}

	function get_fields() {
		return rem_vc_into_divi_settings('rem_create_property');
	}
	
	public function render( $unprocessed_props, $content = null, $render_slug ) {
		global $rem_sc_ob;
		return $rem_sc_ob->create_property($unprocessed_props, $content);
	}	
}

class Divi_REM_List_Agents extends ET_Builder_Module
{
	
	function init() {
	    $this -> name = __('List Agents', 'real-estate-manager');
	    $this -> slug = 'et_pb_rem_list_agents';
	    $this -> icon = 'P';
	}

	function get_fields() {
		return rem_vc_into_divi_settings('rem_list_agents');
	}
	
	public function render( $unprocessed_props, $content = null, $render_slug ) {
		global $rem_sc_ob;
		return $rem_sc_ob->list_agents($unprocessed_props, $content);
	}	
}


class Divi_REM_Edit_Property extends ET_Builder_Module
{
	
	function init() {
	    $this -> name = __('Edit Property', 'real-estate-manager');
	    $this -> slug = 'et_pb_rem_edit_property';
	    $this -> icon = 'B';
	}

	function get_fields() {
		return rem_vc_into_divi_settings('rem_edit_property');
	}
	
	public function render( $unprocessed_props, $content = null, $render_slug ) {
		global $rem_sc_ob;
		return $rem_sc_ob->edit_property($unprocessed_props, $content);
	}	
}

class Divi_REM_Single_Property extends ET_Builder_Module
{
	
	function init() {
	    $this -> name = __('Single Property', 'real-estate-manager');
	    $this -> slug = 'et_pb_rem_property';
	    $this -> icon = 'p';
	}

	function get_fields() {
		return rem_vc_into_divi_settings('rem_property');
	}
	
	public function render( $unprocessed_props, $content = null, $render_slug ) {
		global $rem_sc_ob;
		return $rem_sc_ob->single_property($unprocessed_props, $content);
	}	
}

class Divi_REM_My_Properties extends ET_Builder_Module
{
	
	function init() {
	    $this -> name = __('My Properties', 'real-estate-manager');
	    $this -> slug = 'et_pb_rem_my_properties';
	    $this -> icon = 'p';
	}

	function get_fields() {
		return rem_vc_into_divi_settings('rem_my_properties');
	}
	
	public function render( $unprocessed_props, $content = null, $render_slug ) {
		global $rem_sc_ob;
		return $rem_sc_ob->my_properties($unprocessed_props, $content);
	}	
}

class Divi_REM_Agent_Profile extends ET_Builder_Module
{
	
	function init() {
	    $this -> name = __('Agent Profile', 'real-estate-manager');
	    $this -> slug = 'et_pb_rem_agent_profile';
	    $this -> icon = 'G';
	}

	function get_fields() {
		return rem_vc_into_divi_settings('rem_agent_profile');
	}
	
	public function render( $unprocessed_props, $content = null, $render_slug ) {
		global $rem_sc_ob;
		return $rem_sc_ob->display_agent($unprocessed_props, $content);
	}	
}

class Divi_REM_My_Profile extends ET_Builder_Module
{
	
	function init() {
	    $this -> name = __('My Profile', 'real-estate-manager');
	    $this -> slug = 'et_pb_rem_my_profile';
	    $this -> icon = 'G';
	}

	function get_fields() {
		return rem_vc_into_divi_settings('rem_my_profile');
	}
	
	public function render( $unprocessed_props, $content = null, $render_slug ) {
		global $rem_sc_ob;
		return $rem_sc_ob->my_profile($unprocessed_props, $content);
	}	
}

class Divi_REM_Search_Results extends ET_Builder_Module
{
	
	function init() {
	    $this -> name = __('Search Results', 'real-estate-manager');
	    $this -> slug = 'et_pb_rem_search_results';
	}

	function get_fields() {
		return rem_vc_into_divi_settings('rem_search_results');
	}
	
	public function render( $unprocessed_props, $content = null, $render_slug ) {
		global $rem_sc_ob;
		return $rem_sc_ob->display_search_results($unprocessed_props, $content);
	}	
}

class Divi_REM_Maps extends ET_Builder_Module
{
	
	function init() {
	    $this -> name = __('Large Map', 'real-estate-manager');
	    $this -> slug = 'et_pb_rem_maps';
	    $this -> icon = 'F';
	}

	function get_fields() {
		return rem_vc_into_divi_settings('rem_maps');
	}
	
	public function render( $unprocessed_props, $content = null, $render_slug ) {
		global $rem_sc_ob;
		return $rem_sc_ob->display_maps($unprocessed_props, $content);
	}	
}

class Divi_REM_Search_Property extends ET_Builder_Module
{
	
	function init() {
	    $this -> name = __('Search Property Form', 'real-estate-manager');
	    $this -> slug = 'et_pb_rem_search_property';
	}

	function get_fields() {
		return rem_vc_into_divi_settings('rem_search_property');
	}
	
	public function render( $unprocessed_props, $content = null, $render_slug ) {
		$all_search_fields = get_search_fields_for_page_builders();
		$selected_fields = explode('|', $unprocessed_props['fields_to_show']);
		$new_fields = array_combine($all_search_fields, $selected_fields);
		$values_string = '';
		foreach ($new_fields as $key => $value) {
			if ($value == 'on') {
				$values_string .= $key.',';
			}
		}
		$values_string = rtrim($values_string,',');
		$unprocessed_props['fields_to_show'] = $values_string;
		global $rem_sc_ob;
		return $rem_sc_ob->search_property($unprocessed_props, $content);
	}	
}

class Divi_REM_Carousel extends ET_Builder_Module
{
	
	function init() {
	    $this -> name = __('Properties Slider', 'real-estate-manager');
	    $this -> slug = 'et_pb_rem_carousel';
	    $this -> icon = 'S';
	}

	function get_fields() {
		return rem_vc_into_divi_settings('rem_carousel');
	}
	
	public function render( $unprocessed_props, $content = null, $render_slug ) {
		global $rem_sc_ob;
		return $rem_sc_ob->display_carousel($unprocessed_props, $content);
	}	
}

class Divi_REM_Simple_Search extends ET_Builder_Module
{
	
	function init() {
	    $this -> name = __('Simple Search Properties', 'real-estate-manager');
	    $this -> slug = 'et_pb_rem_simple_search';
	}

	function get_fields() {
		return rem_vc_into_divi_settings('rem_simple_search');
	}
	
	public function render( $unprocessed_props, $content = null, $render_slug ) {
		global $rem_sc_ob;
		return $rem_sc_ob->simple_search_property($unprocessed_props, $content);
	}	
}

class Divi_REM_Manage_Properties extends ET_Builder_Module
{
	
	function init() {
	    $this -> name = __('Manage Properties', 'real-estate-manager');
	    $this -> slug = 'et_pb_rem_manage_properties';
	}

	function get_fields() {
		return rem_vc_into_divi_settings('rem_manage_properties');
	}
	
	public function render( $unprocessed_props, $content = null, $render_slug ) {
		global $rem_sc_ob;
		return $rem_sc_ob->manage_properties($unprocessed_props, $content);
	}	
}

class Divi_REM_Logout_Button extends ET_Builder_Module
{
	
	function init() {
	    $this -> name = __('Logout Button', 'real-estate-manager');
	    $this -> slug = 'et_pb_rem_agent_logout';
	}

	function get_fields() {
		return rem_vc_into_divi_settings('rem_agent_logout');
	}
	
	public function render( $unprocessed_props, $content = null, $render_slug ) {
		global $rem_sc_ob;
		return $rem_sc_ob->logout_button($unprocessed_props, $content);
	}	
}

new Divi_REM_List_Properties;
new Divi_REM_Register_Agent;
new Divi_REM_Edit_Agent;
new Divi_REM_Login_Agent;
new Divi_REM_Create_Property;
new Divi_REM_List_Agents;
new Divi_REM_Edit_Property;
new Divi_REM_Single_Property;
new Divi_REM_My_Properties;
new Divi_REM_Agent_Profile;
new Divi_REM_My_Profile;
new Divi_REM_Search_Results;
new Divi_REM_Maps;
new Divi_REM_Search_Property;
new Divi_REM_Carousel;
new Divi_REM_Simple_Search;
new Divi_REM_Logout_Button;
new Divi_REM_Manage_Properties;
?>