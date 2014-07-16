<!DOCTYPE html>
<!--
    Licensed to the Apache Software Foundation (ASF) under one
    or more contributor license agreements.  See the NOTICE file
    distributed with this work for additional information
    regarding copyright ownership.  The ASF licenses this file
    to you under the Apache License, Version 2.0 (the
    "License"); you may not use this file except in compliance
    with the License.  You may obtain a copy of the License at

    http://www.apache.org/licenses/LICENSE-2.0

    Unless required by applicable law or agreed to in writing,
    software distributed under the License is distributed on an
    "AS IS" BASIS, WITHOUT WARRANTIES OR CONDITIONS OF ANY
     KIND, either express or implied.  See the License for the
    specific language governing permissions and limitations
    under the License.
-->
<html>
    <head>
        <meta charset="utf-8" />
        <meta name="format-detection" content="telephone=no" />
        <!-- WARNING: for iOS 7, remove the width=device-width and height=device-height attributes. See https://issues.apache.org/jira/browse/CB-4323 -->
        <meta name="viewport" content="user-scalable=no, initial-scale=1, maximum-scale=1, minimum-scale=1, width=device-width, height=device-height, target-densitydpi=device-dpi" />
        <link rel="stylesheet" type="text/css" href="css/index.css" />
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
            @Snapchat Login Page
            =========================================*/
            #snapchatForm .button {
                width: auto;
                height: auto;
                border-radius: inherit;
                border: inherit;
            }

            .validation-advice {
                color: red;
            }


        </style>
        <title>The Social Nuke</title>
                 <script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
        <script type="text/javascript">

            $(document).ready(function() {
                /* This is a mock object used to simulate the app */
                var user = {
                    email: "fakeEmail@test.com",
                    FBtoken : "testToken12345"
                }
                var request = new AjaxRequest();
//                request.initialize('settings', user);

            /* This is the constructor used in the real app;
                except for the url, this is the real deal */

                /*=====================================================
                @Visual Styling
                ======================================================*/
                function Api() {}
                Api.prototype.initialize = function(base) {
                    this.base = $(base);
                    this.socNetwork  = this.base.attr('data-type');

                    this._button = $(this.base.find('.button'));
                    this._input = $(this.base.find('.input-text'));
                    this.active = false;
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
                Api.prototype.callback = function() {
                    this._input.removeClass('hidden');
                } 

                var snapchatForm = {};
                snapchatForm.initialize = function() {
                    this.base = $('#snapchatForm');
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
                snapchatForm.launchListener = function() {
                    var self = this;
                    this._button.click(function() {
                        if(self.validate()) {
                            self.sendRequest();
                        }
                    })
                }
                snapchatForm.validate = function() {
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
                snapchatForm.sendRequest = function() {
                    var request = new AjaxRequest();
                    request.initialize('snapchatConnect', this.user, this.callback, this);   
                }
                snapchatForm.callback = function(data) {
                    window.location.href = data['redirect'];
                }
                snapchatForm.initialize();

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
                                    // window.localStorage.snapchatActivated = true;
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
                
            })

            </script>
            
    </head>

    <body>
        <div id="page-container">
            <div class="content">
                <div id="snapchatForm" data-type="Snapchat" class="api-container">
                    <h3>Log in to Snapchat</h3>
                    <div class="input-container">
                        <label>Username</label>
                        <input name="user" type="text" class="input-text"></input>
                        <div class="validation-advice user hidden">Please enter a username.</div>
                    </div>
                    <div class="input-container">
                        <label>Password</label>
                        <input name="password" type="text" class="input-text"></input>
                        <div class="validation-advice password hidden">Please enter a password.</div>
                    </div>
                    <button type="button" class="button" onclick="">Submit</button>
                </div>
            </div>
        </div>
    </body>
</html>