//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

(function(window, $, undefined) {
	var $form = $("#sendContactsSignupForm"),
		$results = $form.find(".results");
	
	$form.find(".subscribe").on("click", function(e) {
		addContactToDatabase();
	});
	
	$form.on("submit", function(e) {
		addContactToDatabase();
	});
	
	function addContactToDatabase(){
		$form.find("input").addClass("hide");
		$results.removeClass("success error").text("Please wait while we process your request...");
	
		var apiKey = $form.find(".apiKey").val(),
			listId = $form.find(".listId").val(),
			emailAddress = $form.find(".emailToAdd").val(),
			dataToSend, resultText;

		if (apiKey == "" || listId == ""){
			resultText = "Required parameters are missing, please contact the Webmaster.";
		} else if (emailAddress == "") {
			resultText = "Please fill-in the Email Address field in order to be added to the mailing list.";
		}
	
		if (resultText == undefined || resultText == "") {
			dataToSend = '[{"email":"' + emailAddress + '"}]';
	
			$.ajax({
				url: 'https://api.sendgrid.com/v3/contactdb/recipients',
				headers: {'Authorization': 'Bearer ' + apiKey},
				contentType: "application/json",
				data: dataToSend,
				method: 'POST',
				success: function (data) {
					if (data.error_count > 0) {
						displayError(data.errors[0].message);
					} else {
						addContactToList(apiKey, listId, data.persisted_recipients);
					}
				}
			});
		} else {
			displayError(resultText);
		}
	}
	
	function addContactToList(apiKey, listId, contactId){
		var contactsToSend = "[";
	
		for(var i=0;i<contactId.length;i++){
			if (i > 0) {
				contactsToSend += ",";
			}
		
			contactsToSend += '"' + contactId[i] + '"';
		}
	
		contactsToSend += "]";

		$.ajax({
			url: 'https://api.sendgrid.com/v3/contactdb/lists/' + listId + '/recipients',
			headers: {'Authorization': 'Bearer ' + apiKey},
			contentType: "application/json",
			data: contactsToSend,
			method: 'POST',
			statusCode: {
				201: function () {
					$results.addClass("success").text("You've been added to our mailing list!");
				}
			}
		});	
	}
	
	function displayError(message) {
		$results.addClass("error").text(message);
		$form.find("input").removeClass("hide");
	}
})(this, jQuery);