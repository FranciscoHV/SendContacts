<?php
/*
Plugin Name: SendContacts
Plugin URI:  http://www.smartdatasystems.net/wordpress/SendContacts
Description: Provides simple mechanism to allow site visitors to sign up for SendGrid-powered marketing lists.
Version:     0.5
Author:      Smart Data Systems
Author URI:  http://www.smartdatasystems.net/
License:     GPL2
License URI: https://www.gnu.org/licenses/gpl-2.0.html

{Plugin Name} is free software: you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation, either version 2 of the License, or
any later version.
 
{Plugin Name} is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
GNU General Public License for more details.
 
You should have received a copy of the GNU General Public License
along with {Plugin Name}. If not, see {License URI}.
*/

defined( 'ABSPATH' ) or die( 'No script kiddies please!' );

// Hook for adding admin menus
add_action( 'admin_menu', 'sendContacts_settingsMenu' );

// action function for above hook
function sendContacts_settingsMenu() {
	// Add a new submenu under Settings:
	add_options_page( __( 'SendContacts Configuration', 'config-pageTitle' ), __( 'SendContacts', 'config-menuName' ), 'manage_options', 'SendContacts', 'sendContacts_settingsPage' );
}

// register style sheet
function register_sendContacts_styles() {
	wp_register_style( 'sendContacts', plugins_url( '/SendContacts/form.css' ) );
	wp_enqueue_style( 'sendContacts' );
}

// register javascript
add_action( 'admin_enqueue_scripts', 'register_sendContacts_optionsScripts' );
function register_sendContacts_optionsScripts() {
	wp_register_script( 'sendContacts-options', plugins_url( '/SendContacts/options.js' ), [], false, true );
	wp_enqueue_script( 'sendContacts-options' );
}

// register javascript
function register_sendContacts_formScripts() {
	wp_register_script( 'sendContacts-form', plugins_url( 'form.js', __FILE__ ), [], false, true );
	wp_enqueue_script( 'sendContacts-form' );
}

class sendContactOptions {
	public $apiKey = "";
	public $listId = "";
	public $listName = "";
	public $apiKeyAtNetwork = false;
}

// displays the page content for the Settings submenu
function sendContacts_settingsPage() {
	if ( !current_user_can( 'manage_options' ) )  {
		wp_die( __( 'You do not have sufficient permissions to access this page.' ) );
	}
	
    // variables for the field and option names 
    $opt_name = 'sendContacts_configData';
    $hidden_field_name = 'sg_submit_hidden';
    $api_key_field = 'sg_api_key';
    $list_id_field = 'sg_list_id';

    // Read in existing option value from database
    $opt_val = get_option( $opt_name );
    
    $savedData = json_decode($opt_val);
    
    $apiKey = $savedData->apiKey;
    $listName = $savedData->listName;
    $listId = $savedData->listId;
    $atNetwork = "";
    
    if ($savedData->apiKeyAtNetwork) {
    	$atNetwork = 'disabled="disabled" data-autoRun="true"';
    }

    // See if the user has posted us some information
    // If they did, this hidden field will be set to 'Y'
    if( isset($_POST[ $hidden_field_name ]) && $_POST[ $hidden_field_name ] == 'Y' ) {
    	$apiInfo = explode("~", $_POST[ $list_id_field ]);
        
        // Read posted values
        $opts = new sendCOntactOptions();
		$opts->apiKey = $_POST[ $api_key_field ];
		$opts->listId = $apiInfo[0];
		$opts->listName = $apiInfo[1];
		
		// ensure that if the API Key changes, the List info is either changed or cleared out.
		if ($opts->apiKey != $apiKey && $opts->listId == $listId) {
			$opts->listId = "";
			$opts->listName = "";
		}

        // Save the posted value in the database
        update_option( $opt_name, json_encode($opts) );

        // Put a "settings saved" message on the screen
		?>
		<div class="updated"><p><strong><?php _e('Your configuration options have been saved.', 'config-saveSuccessful' ); ?></strong></p></div>
		<?php

		$apiKey = $opts->apiKey;
    	$listName = $opts->listName;
    }

    // Now display the settings editing screen

    echo '<div class="wrap">';

    // header

    echo "<h2>" . __( 'SendContacts Configuration', 'config-pageTitle' ) . "</h2>";

    // settings form
    
    ?>

	<form id="SendContactsOptions" name="form1" method="post" action="">
	<input type="hidden" name="<?php echo $hidden_field_name; ?>" value="Y">

	<table class="form-table">
		<tbody>
			<tr>
				<th scope="row"><?php _e("SendGrid API Key", 'config-apiKeyFieldName' ); ?></th>
				<td><input type="text" class="regular-text code <?php echo $api_key_field; ?>" name="<?php echo $api_key_field; ?>" value="<?php echo $apiKey; ?>" <?php echo $atNetwork ?> size="75"></td>
			</tr>
			<tr>
				<th scope="row"><?php _e("Current Marketing List", 'config-currentListFieldName' ); ?></th>
				<td><input type="text" value="<?php echo $listName; ?>" disabled="disabled" class="regular-text ltr" /></td>
			</tr>
		</tbody>
	</table>

	<input class="button getListsForApiKey" type="button" value="<?php esc_attr_e('Retrieve Marketing Lists for API Key') ?>" />
	
	<table class="form-table">
		<tbody>
			<tr>
				<th scope="row"><?php _e("Marketing Lists for API Key", 'config-listSelectionFieldName' ); ?></th>
				<td class="listOfLists"></td>
			</tr>
		</tbody>
	</table>

	<p class="submit">
	<input type="submit" name="Submit" class="button button-primary" value="<?php esc_attr_e('Save Options') ?>" />
	</p>

	</form>
	</div>

	<?php
 
}

function sendContactsForm() {	
	add_action( 'wp_enqueue_style', 'register_sendContacts_styles' );
	add_action( 'wp_enqueue_script', 'register_sendContacts_formScripts' );

	// Read in existing option value from database
    $opt_val = get_option( 'sendContacts_configData' );
    
    $savedData = json_decode($opt_val);
    
    $apiKey = $savedData->apiKey;
    $listId = $savedData->listId;
    ?>
    
    <form id="sendContactsSignupForm">
		<input type="hidden" class="apiKey" value="<?php echo $apiKey; ?>" />
		<input type="hidden" class="listId" value="<?php echo $listId; ?>" />
		<input type="email" class="emailToAdd" />
		<input type="button" class="subscribe" value="Subscribe to List" />
		<div class="results"></div>
	</form>
	
	<?php
}

?>