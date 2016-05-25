(function(window, $, undefined) {
	var $form = $("#SendContactsOptions"),
		$listOfLists = $form.find(".listOfLists");

	$form.find(".getListsForApiKey").on("click", function(e) {
		var apiKey = $form.find(".sg_api_key").val();

		if (apiKey == "")
		{
			// if it's not in the UI field, then try the DB field as a backup...
			apiKey = $form.find("db_api_key_value").val();
		}

		if (apiKey == "") {
			alert("API Key is required in order to get Lists.");
		}
		
		$listOfLists.text("Please wait while we retrieve your Marketing Lists.");
		
		$.ajax({
			url: 'https://api.sendgrid.com/v3/contactdb/lists',
			headers: {'Authorization': 'Bearer ' + apiKey},
			success: function (data) {
				var lists = data.lists,
					resultHtml = "";
			
				for(var i=0;i<lists.length;i++){
					resultHtml += '<input id="list' + lists[i].id + '" type="radio" name="sg_list_id" value="' + lists[i].id + '~' + lists[i].name + '" /><label for="list' + lists[i].id + '">' + lists[i].name + '</label><br />';
				}
			
				$listOfLists.html(resultHtml);
			},
			error: function () {
				$listOfLists.text("We encountered a problem while attempting to retrieve your Marketing Lists.  Please ensure that your API Key is correct and re-try retrieval.  Thank you!");
			}
		});
	});
})(this, jQuery);

