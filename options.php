
<div class="wrap">

    <h2><?php _e( 'SendContacts Configuration', 'config-pageTitle' ) ?></h2>

    <?php if(array_key_exists( 'saved', $data )): ?>
        <div class="updated"><p><strong><?php _e('Your configuration options have been saved.', 'config-saveSuccessful') ?></strong></p></div>
    <?php endif; ?>
    
    <form id="SendContactsOptions" name="form1" method="post" action="">
        <input type="hidden" name="<?php echo $data['hidden_field_name']; ?>" value="Y">

        <table class="form-table">
            <tbody>
                <tr>
                    <th scope="row"><label for="<?php echo $data['api_key_field']; ?>"><?php _e( 'SendGrid API Key', 'config-apiKeyFieldName' ); ?></label></th>
                    <td>
                        <input type="hidden" class=".db_api_key_value" value="<?php echo $data['api_key']; ?>" >
                        <input type="text" class="regular-text code <?php echo $data['api_key_field']; ?>" id="<?php echo $data['api_key_field']; ?>" name="<?php echo $data['api_key_field']; ?>" <?php echo $data['at_network'] ?> size="75">
                    </td>
                </tr>
                <tr>
                    <th scope="row"><?php _e( 'Current Marketing List', 'config-currentListFieldName' ); ?></th>
                    <td><?php echo $data['list_name']; ?></td>
                </tr>
            </tbody>
        </table>

        <input class="button getListsForApiKey" type="button" value="<?php _e( 'Retrieve Marketing Lists for API Key', 'config-listRetrievalButton' ) ?>" />

        <table class="form-table">
            <tbody>
                <tr>
                    <th scope="row"><?php _e( 'Marketing Lists for API Key', 'config-listSelectionFieldName' ); ?></th>
                    <td class="listOfLists"></td>
                </tr>
            </tbody>
        </table>

        <p class="submit">
            <input type="submit" name="Submit" class="button button-primary" value="<?php _e( 'Save Options', 'config-saveOptions' ) ?>" />
        </p>
    </form>
</div>
