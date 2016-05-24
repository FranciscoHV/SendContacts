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
			resultText = "Please fill-in the Email Address field in order to be added to our mailing list.";
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
					} else if (data.unmodified_indices.length > 0) {
						var encodedAddress = encodeURI(emailAddress),
							base64Address = btoa(encodedAddress);

						addContactToList(apiKey, listId, [base64Address]);
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
				},
				400: function () {
					displayError("There was a problem adding your address to our mailing list.  Please try again.");
				}
			}
		});	
	}
	
	function displayError(message) {
		$results.addClass("error").text(message);
		$form.find("input").removeClass("hide");
	}
})(this, jQuery);