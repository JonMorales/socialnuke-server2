$(document).ready(function() {

/*=====================================================
@Page-Specific Objects
======================================================*/

    /*========================
    Login Page
    =========================*/

    if($('body').hasClass('login')) {

        /* An object to handle the Facebook form */
        
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
                for(var key in data['activation']) {
                    window.localStorage[key] = data['activation'][key];
                }
                // console.log(window.localStorage);
            	window.location.href = data['redirect'];
            }
            else {
            	alert('Please try again');
            }
        }
        facebookForm.initialize();

    }


    /*========================
    Settings Page
    =========================*/
    if($('body').hasClass('settings')) {
        console.log(window.localStorage);
        /* Constructor for various API requests */
        function Api() {}
        Api.prototype.initialize = function(base) {
            this.base = $(base);
            this.socNetwork  = this.base.attr('data-type');

            this._button = $(this.base.find('.button'));
            this.active = window.localStorage[this.socNetwork.toLowerCase() + 'Activation'];
            this._input = $(this.base.find('.input-text'));
            
            if(this.active != true) {
                this._input.addClass('hidden');
            }

            this.launchListener();
        }
        Api.prototype.launchListener = function() {
            var self = this;
            this._button.click(function() {
                if(self.active) {
                    self.active = false;
                    self._button.removeClass('active');
                }
                else {
                    self.active = true;
                    self._button.addClass('active');
                    self.sendRequest();
                }
            })
        }
        Api.prototype.sendRequest = function() {
            var request = new AjaxRequest();

            request.initialize('settings' + this.socNetwork, user, this.callback, this);
        }
        Api.prototype.callback = function(data) {
            console.log(data);
            var URL = data['redirect'];
            window.location.href = URL;
        }


        /* Create API functionality and store objects into an array */
        var socNetworkArray = [];
        $('.api-container').each(function(){
            var socialNetwork = new Api();
            socialNetwork.initialize(this);
            socNetworkArray.push(socialNetwork);
        })


        /* Loop to set styles of input boxes based on localstorage */
        for(var key in window.localStorage['activated']) {
            if(window.localStorage[activated][key]) {

            }
        }
    }
   
/*=====================================================
@Global Constructors
======================================================*/

	/*=========================
    @AJAX Request
    ===========================*/
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

}) /*=======================> END $(document).ready() */