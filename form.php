<form id="sendContactsSignupForm">
    <input type="hidden" class="apiKey" value="<?php echo $data['api_key']; ?>" />
    <input type="hidden" class="listId" value="<?php echo $data['list_id']; ?>" />
    <input type="email" class="emailToAdd" />
    <input type="button" class="subscribe" value="Subscribe" />
    <div class="results"></div>
</form>