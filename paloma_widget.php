<?php
/*
Plugin Name: Postman Widget
Plugin URI: 
Description: Form to capture email subscriptions and send them to your Postman Address List
Version: 1.4
Author: Paloma
Author URI: http://www.paloma.se/
*/

/*
	This file is part of Postman Widget.

    Postman Widget is free software: you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation, either version 3 of the License, or
    (at your option) any later version.

    Postman Widget is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with Postman Widget.  If not, see <http://www.gnu.org/licenses/>.
	*/


class paloma_newsletter_widget extends WP_Widget {
	
	/**
	* constructor
	*/	 
	
	
	
	function paloma_newsletter_widget() {
		parent::WP_Widget('paloma_newsletter_widget', 'Postman Widget', array('description' => __('Allows visitors to subscribe to a Postman newsletter.','paloma')));	
		
		paloma_newsletter_widget::loadJS();	
	}
	
	
	public function loadJS()
	{
		//wp_deregister_script( 'jquery' );
    	//wp_register_script( 'jquery', plugins_url('js/jquery-1.4.4.min.js', __FILE__));
	    wp_enqueue_script( 'jquery' );		
	}
	
  
  public function set_up_admin_page () {
		
  	add_submenu_page('paloma_widget_admin.php', __('Postman Widget Options', 'paloma'), 
					 'Postman Widget', 'activate_plugins', __FILE__, array('paloma_newsletter_widget', 'admin_page'));		
	}
	
	
	public function admin_page()
	{
		$file = dirname(__FILE__).'/paloma_widget_admin.php';
		include($file);
	}
	
  
  /**
	 * display widget
	 */	 
	function widget($args, $instance) {
		extract($args, EXTR_SKIP);
		echo $before_widget;
		$title = empty($instance['paloma_title']) ? '&nbsp;' : apply_filters('widget_title', $instance['paloma_title']);
		if ( !empty( $title ) ) { echo $before_title . $title . $after_title; };
		
		paloma_newsletter_widget::load_form(	$instance['paloma_list_id'], 
									$instance['paloma_box_title'],
									$instance['paloma_thanks'],
									$instance['paloma_showmailings'],
									$instance['paloma_get_title'],
									$instance['paloma_get_company'],
									$instance['paloma_get_mobilenr'],
									$instance['paloma_get_phonenr'],
									$instance['paloma_get_fax'],
									$instance['paloma_get_address'],
									$instance['paloma_get_postcode'],
									$instance['paloma_get_city'],
									$instance['paloma_get_state']);
		
		echo $after_widget;
	}
	
	/**
	 *	update/save function
	 */	 	
	function update($new_instance, $old_instance) {
		$instance = $old_instance;
		$instance['paloma_title'] = strip_tags($new_instance['paloma_title']);
		$instance['paloma_box_title'] = strip_tags($new_instance['paloma_box_title']);
		$instance['paloma_list_id'] = strip_tags($new_instance['paloma_list_id']);
		$instance['paloma_thanks'] = strip_tags($new_instance['paloma_thanks']);
		$instance['paloma_showmailings'] = strip_tags($new_instance['paloma_showmailings']);
		$instance['paloma_get_title'] = strip_tags($new_instance['paloma_get_title']);
		$instance['paloma_get_company'] = strip_tags($new_instance['paloma_get_company']);
		$instance['paloma_get_mobilenr'] = strip_tags($new_instance['paloma_get_mobilenr']);
		$instance['paloma_get_phonenr'] = strip_tags($new_instance['paloma_get_phonenr']);
		$instance['paloma_get_fax'] = strip_tags($new_instance['paloma_get_fax']);
		$instance['paloma_get_address'] = strip_tags($new_instance['paloma_get_address']);
		$instance['paloma_get_postcode'] = strip_tags($new_instance['paloma_get_postcode']);
		$instance['paloma_get_city'] = strip_tags($new_instance['paloma_get_city']);
		$instance['paloma_get_state'] = strip_tags($new_instance['paloma_get_state']);
		return $instance;
	}
	
	/**
	 *	admin control form
	 */	 	
	function form($instance) {
		$default = 	array( 'paloma_title' 		=> __('Postman Newsletter', 'paloma'),
						   'paloma_box_title'	=> __('Subscribe to our newsletter', 'paloma'),
						   'paloma_list_id' 		=> '0',
						   'paloma_thanks'		=> '',
						   'paloma_showmailings' => '0',
						   'paloma_get_title' => '',
						   'paloma_get_company' => '',
						   'paloma_get_mobilenr' => '',
						   'paloma_get_phonenr' => '',
						   'paloma_get_fax' => '',
						   'paloma_get_address' => '',
						   'paloma_get_postcode' => '',
						   'paloma_get_city' => '',
						   'paloma_get_state' => '');
						   
		$instance = wp_parse_args( (array) $instance, $default );
		
		$field_id_title = $this->get_field_id('paloma_title');
		$field_name_title = $this->get_field_name('paloma_title');
		
		$field_id_box_title = $this->get_field_id('paloma_box_title');
		$field_name_box_title = $this->get_field_name('paloma_box_title');
		
		$field_id_list = $this->get_field_id('paloma_list_id');
		$field_name_list = $this->get_field_name('paloma_list_id');
		
		$field_id_thanks = $this->get_field_id('paloma_thanks');
		$field_name_thanks = $this->get_field_name('paloma_thanks');
		
		$field_id_showmailings = $this->get_field_id('paloma_showmailings');
		$field_name_showmailings = $this->get_field_name('paloma_showmailings');
		
		$field_id_get_title = $this->get_field_id('paloma_get_title');
		$field_name_get_title = $this->get_field_name('paloma_get_title');

		$field_id_get_company = $this->get_field_id('paloma_get_company');
		$field_name_get_company = $this->get_field_name('paloma_get_company');

		$field_id_get_mobilenr = $this->get_field_id('paloma_get_mobilenr');
		$field_name_get_mobilenr = $this->get_field_name('paloma_get_mobilenr');

		$field_id_get_phonenr = $this->get_field_id('paloma_get_phonenr');
		$field_name_get_phonenr = $this->get_field_name('paloma_get_phonenr');

		$field_id_get_fax = $this->get_field_id('paloma_get_fax');
		$field_name_get_fax = $this->get_field_name('paloma_get_fax');

		$field_id_get_address = $this->get_field_id('paloma_get_address');
		$field_name_get_address = $this->get_field_name('paloma_get_address');

		$field_id_get_postcode = $this->get_field_id('paloma_get_postcode');
		$field_name_get_postcode = $this->get_field_name('paloma_get_postcode');

		$field_id_get_city = $this->get_field_id('paloma_get_city');
		$field_name_get_city = $this->get_field_name('paloma_get_city');

		$field_id_get_state = $this->get_field_id('paloma_get_state');
		$field_name_get_state = $this->get_field_name('paloma_get_state');

		$file = dirname(__FILE__).'/control.php';
		include($file);
		
		
	}
  
 
  function load_form($list_id, $boxTitle, $thanksUrl, $mailings, $getTitle, $getCompany, $getMobileNr, $getPhoneNr, $getFax, $getAddress, $getPostcode, $getCity, $getState)
  {
	$mailarr = array();
	$cid = 0;
	$chash = '';
  	if($mailings > 0 || 1 > 0)
	{
		$client = new SoapClient("https://api.paloma.se/PalomaWebService.asmx?WSDL");
		$cid = get_option('paloma_customer_id');
		$chash = get_option('paloma_customer_hash');
		
		$results = $client->ListMailings(array('customerID' => $cid,
								'customerHash' => $chash,
								'addressListID' => $list_id));
		
		$i = 0;
		if(isset($results->ListMailingsResult->Mailings->Mailing))
		{
			foreach($results->ListMailingsResult->Mailings->Mailing as &$mailing)
			{
				if($i < $mailings)
				{
					$i++;
					$mailarr[$i] = $mailing;
				}
			}
		}
	}
	
	$file = dirname(__FILE__).'/form.php';
	include($file);
  }
  
  
}

/* register widget when loading the WP core */
add_action('widgets_init', 'just_register_widgets');
add_action('plugins_loaded', 'paloma_init');

add_action('wp_print_styles', 'add_paloma_stylesheet');
add_action('admin_menu', 'paloma_newsletter_actions');
    /*
     * Enqueue style-file, if it exists.
     */

    function add_paloma_stylesheet() {
		$myStyleFile = dirname(__FILE__).'/paloma_style.css';	
        if ( file_exists($myStyleFile) ) {
            wp_register_style('paloma_stylesheet', plugins_url('paloma_style.css', __FILE__));
            wp_enqueue_style( 'paloma_stylesheet');
        }
    }

function just_register_widgets(){
	// curl need to be installed
	register_widget('paloma_newsletter_widget');
}

	function paloma_newsletter_actions() {
		add_options_page('Postman Widget', 'Postman Widget', "edit_plugins", "paloma_widget_admin.php", "paloma_admin");
	}
	
	function paloma_admin(){
		include('paloma_widget_admin.php');
	}

	function paloma_init(){
		load_plugin_textdomain( 'paloma', false, dirname( plugin_basename( __FILE__ ) ) );
	}
?>