<!-- Test file for Facebook login -->
<!doctype html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Test File for Facebook Login - Sends a simple mock User object</title>
</head>
<body>

	<script src="<?php echo URL::asset('js/jquery.js') ?>"></script>
	<script type="text/javascript">
	
	$(document).ready(function() {
		/* This is a mock object used to simulate the app */
		var user = {
            email: "testemail@testmail.com",
            FBtoken : "testToken12345"
        }
        var request = new AjaxRequest();
        request.initialize('login', user);
        alert(request);

	})
	/* This is the constructor used in the real app;
		except for the url, this is the real deal */

		/*=====================================================
		@AJAX Request
		======================================================*/
		function AjaxRequest() {}
		AjaxRequest.prototype.initialize = function(url, dataToSend) {
		    this.url = url;
		    this.dataToSend = dataToSend;
		    this.connect();
		}
		AjaxRequest.prototype.connect = function() {
			
		    var self = this;
		    for(var key in self.dataToSend) {
		        alert(key + " : " + self.dataToSend[key]);
		    }
		    $.ajax({
		        async: false,
		        url: "/" + self.url,
		        data: self.dataToSend,
		        type: "POST",
		        dataType: "text",
		        error: function(jqXhr, textStatus, errorThrown) {
		            //uncomment if you want to see the errors
		            alert("There was an error");
		            for(var i=0; i<jqXhr.length; i++) {
		                alert(jqXhr[i]);
		            };
		            alert(textStatus);
		            alert(errorThrown);
		            
		        },
		        success: function(data, status, jqXhr){
		            if(status === "success") {
		                alert(data);
		            }
		            else {
		                alert("There was an error!");
		            }
		        }
		    })
		}

	
	</script>
</body>
</html>
