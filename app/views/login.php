<!-- Test file for Facebook login -->
<!doctype html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>The Social Nuke</title>
	<style>
        /* Styles for the main page */


        #page-container { width: 50%; margin: 0 auto; }
        #page-container .content { text-align: center }

        .hidden { display: none; }


        /*========================================
        @Settings Page
        =========================================*/

        .button {
            border-radius: 10px;
            border: 1px solid black;
            height: 10px;
            width: 10px;
            margin: 0 auto 10px;
        }

        .button.active {
            background: #000;
        }

        .button:hover {
            cursor: pointer;
        }

        /*========================================
        @Facebook Login Page
        =========================================*/
        #facebookForm .button {
            width: auto;
            height: auto;
            border-radius: inherit;
            border: inherit;
        }

        .validation-advice {
            color: red;
        }
    </style>
	<script src="<?php echo URL::asset('js/jquery.js') ?>"></script>
	<script type="text/javascript">

	$(document).ready(function() {
		/* This is a mock object used to simulate the app */
		
        var facebookForm = {};
        facebookForm.initialize = function() {
            this.base = $('#facebookForm');
            this._button = $(this.base.find('.button'));
            this._inputContainers = [];
            this.user = {};
            var self = this;
            var i=0;

            $('.input-container').each(function(){
                self._inputContainers[i] = {};
                $this = $(this);
                self._inputContainers[i]['input'] = $this;
                self._inputContainers[i]['text'] = $this.find('.input-text');
                self._inputContainers[i]['validation'] = $this.find('.validation-advice');
                i++;
            })

            this.launchListener();
        }
        facebookForm.launchListener = function() {
            var self = this;
            this._button.click(function() {
                if(self.validate()) {
                    self.sendRequest();
                }
            })
        }
        facebookForm.validate = function() {
            for(var i=0; i<this._inputContainers.length; i++) {
                if(this._inputContainers[i]['text'].val().length < 1) {
                    $(this._inputContainers[i]['validation']).removeClass('hidden');
                    return false;
                }
                else {
                    this.user[this._inputContainers[i]['text'].attr('name')] = this._inputContainers[i]['text'].val();
                    $(this._inputContainers[i]['validation']).addClass('hidden');
                }
            }
            return true;
        }
        facebookForm.sendRequest = function() {
            var request = new AjaxRequest();
            request.initialize('login', this.user, this.callback, this);   
        }
        facebookForm.callback = function(data) {
        	if(data['success']) {
            	window.location.href = data['redirect'];
            }
            else {
            	alert('Please try again');
            }
        }
        facebookForm.initialize();

	})
	/* This is the constructor used in the real app;
		except for the url, this is the real deal */

		/*=====================================================
        @AJAX Request
        ======================================================*/
        function AjaxRequest() {}
        AjaxRequest.prototype.initialize = function(url, dataToSend, callback, parent){
            this.url = url;
            this.dataToSend = dataToSend;
            this.callback = callback;
            this._parent = parent;
            this.connect();
        }
        AjaxRequest.prototype.connect = function() {
            var self = this;
            $.ajax({
                async: false,
                url: "/" + self.url,
                data: self.dataToSend,
                type: "POST",
                dataType: "json",
                error: function(jqXhr, textStatus, errorThrown) {
                    /* uncomment if you want to see the errors
                    alert("There was an error");
                    for(var i=0; i<jqXhr.length; i++) {
                        alert(jqXhr[i]);
                    };
                    alert(textStatus);
                    alert(errorThrown);
                    */
                },
                success: function(data, status, jqXhr){
                    if(status === "success") {
                        if(data['success']) {
                            self._parent.callback(data);
                        }
                        else {
                            alert('Incorrect username or password.');
                        }
                    }
                    else {
                        alert("There was an error!");
                    }
                }
            })
        }
		
	</script>
</head>
<body>
	<div id="page-container">
        <div class="content">
            <div id="facebookForm" data-type="Snapchat" class="api-container">
                <h3>Log in to Facebook</h3>
                <div class="input-container">
                    <label>Username</label>
                    <input name="email" type="text" class="input-text"></input>
                    <div class="validation-advice user hidden">Please enter a username.</div>
                </div>
                <div class="input-container">
                    <label>Password</label>
                    <input name="FBtoken" type="text" class="input-text"></input>
                    <div class="validation-advice password hidden">Please enter a Facebook token.</div>
                </div>
                <button type="button" class="button" onclick="">Submit</button>
            </div>
        </div>
    </div>
</body>

</html>
