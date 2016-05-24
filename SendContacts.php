<?php

class SendContacts {
	function register_menu() {
		// Add a new submenu under Settings:
		add_options_page( __( 'SendContacts Configuration', 'config-pageTitle' ), __( 'SendContacts', 'config-menuName' ), 'manage_options', 'SendContacts', array( 'SendContacts', 'get_settings_page' ) );
	}

	function register_styles() {
		if (!is_admin())
		{
			wp_register_style( 'sendContacts', plugins_url( 'form.css', __FILE__ ) );
			wp_enqueue_style( 'sendContacts' );
		}
	}

	function register_scripts() {
		if (is_admin()) {
			wp_register_script( 'sendContacts', plugins_url( 'options.js', __FILE__ ), [], false, true );
		} else {
			wp_register_script( 'sendContacts', plugins_url( 'form.js', __FILE__ ), [], false, true );
		}

		wp_enqueue_script( 'sendContacts' );
	}

    function load() {
        //add_action( 'wp_enqueue_style', array( 'SendContacts', 'register_styles' ) );
        //add_action( 'wp_enqueue_script', array( 'SendContacts', 'register_scripts' ) );

        $sc = new SendContacts();

        $sc->register_styles();
        $sc->register_scripts();
    }

	function get_settings_page() {
		if ( !current_user_can( 'manage_options' ) )  {
			wp_die( __( 'You do not have sufficient permissions to access this page.' ) );
		}

		// variables for the field and option names
		$opt_name = 'sendContacts_configData';
		$hidden_field_name = 'sg_submit_hidden';
		$api_key_field = 'sg_api_key';
		$list_id_field = 'sg_list_id';

		$view_bag = array();

		// Read in existing option value from database
		$opt_val = get_option( 'sendContacts_configData' );

		$saved_data = json_decode($opt_val);

		$api_key = $saved_data->api_key;
		$list_name = $saved_data->list_name;
		$list_id = $saved_data->list_id;
		$at_network = "";

		if ($saved_data->api_key_at_network) {
			$at_network = 'disabled="disabled" data-autoRun="true"';
		}

		// See if the user has posted us some information
		// If they did, this hidden field will be set to 'Y'
		if( isset($_POST[ $hidden_field_name ]) && $_POST[ $hidden_field_name ] == 'Y' ) {
			$apiInfo = explode("~", $_POST[$list_id_field]);

			// Read posted values
			$opts = new SendContactsOptions();
			$opts->api_key = $_POST[$api_key_field];
			$opts->list_id = $apiInfo[0];
			$opts->list_name = $apiInfo[1];

			// ensure that if the API Key changes, the List info is either changed or cleared out.
			if ($opts->api_key != $api_key && $opts->list_id == $list_id) {
				$opts->list_id = "";
				$opts->list_name = "";
			}

			// Save the posted value in the database
			update_option($opt_name, json_encode($opts));

			$api_key = $opts->api_key;
			$list_name = $opts->list_name;

			$view_bag['saved'] = true;
		}

		$view_bag['api_key_field'] = $api_key_field;
		$view_bag['list_id_field'] = $list_id_field;
		$view_bag['hidden_field_name'] = $hidden_field_name;
		$view_bag['api_key'] = $api_key;
		$view_bag['list_name'] = $list_name;
		$view_bag['at_network'] = $at_network;

		$sc = new SendContacts();

		$sc->get_render( 'options.php', $view_bag );
	}

	function short_code_func(){
		// Read in existing option value from database
		$opt_val = get_option( 'sendContacts_configData' );

		$savedData = json_decode($opt_val);

		$view_bag['list_id'] = $savedData->list_id;
		$view_bag['api_key'] = $savedData->api_key;

		$sc = new SendContacts();

		$sc->get_render( 'form.php', $view_bag );
	}

	function get_render($tpl, $data = array()){
		extract($data);
		return require(dirname(__FILE__).'/'.$tpl);
	}
}

class SendContactsOptions {
	public $api_key = "";
	public $list_id = "";
	public $list_name = "";
	public $api_key_at_network = false;
}

add_action( 'admin_menu', array( 'SendContacts', 'register_menu' ) );
add_action( 'admin_enqueue_scripts', array( 'SendContacts', 'register_scripts' ) );

add_action( 'plugins_loaded', array( 'SendContacts', 'load' ) );

add_shortcode( 'sendcontacts', array( 'SendContacts', 'short_code_func' ) );


