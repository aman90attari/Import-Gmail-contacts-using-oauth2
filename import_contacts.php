<!DOCTYPE html>
<html>
  <head>
    <meta charset='utf-8' />
    <script src="https://code.jquery.com/jquery-1.11.2.min.js"></script>
  </head>
  <body>
    <script type="text/javascript">
          var clientId = 'something.apps.googleusercontent.com';/*Replace from your Client ID */
          var apiKey = 'somethingB1e_';/*Replace from your Client secret*/
          var scopes = 'https://www.googleapis.com/auth/contacts.readonly';

          $(document).on("click",".googleContactsButton", function(){
            gapi.client.setApiKey(apiKey);
            window.setTimeout(authorize);
          });

          function authorize() {
            gapi.auth.authorize({client_id: clientId, scope: scopes, immediate: false}, handleAuthorization);
          }

          function handleAuthorization(authorizationResult) {
            if (authorizationResult && !authorizationResult.error) {
              $.get("https://www.google.com/m8/feeds/contacts/default/thin?alt=json&access_token=" + authorizationResult.access_token + "&max-results=500&v=3.0",
                	function(response){
					//console.log(response.feed.entry.length);
					var container = $('<div class="form-group"/>');
					for(var i = 0;i<response.feed.entry.length; i++){
						if(response.feed.entry[i].gd$email)
						{
							 container.append('<input type="checkbox" value="'+response.feed.entry[i].gd$email[0].address+'" name="ema[]"> '+response.feed.entry[i].gd$email[0].address+'</br>');
							console.log("Email " + response.feed.entry[i].gd$email[0].address);
							$('#somewhere').html(container);
						}
					}
				});
            }
          }
        </script>
        <script src="https://apis.google.com/js/client.js"></script>
        <div style="margin-top:10%; margin-left:40%;">
        <button class="googleContactsButton">Get my contacts</button>
        <div id="somewhere"></div>
        </div>
  </body>
</html>
