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
        </style>
        <title>The Social Nuke</title>
        <script type="text/javascript" src="<?php echo URL::asset('js/jquery.js') ?>"></script>
        <script type="text/javascript" src="<?php echo URL::asset('js/scripts.js')?>"></script>

    </head>
    <body class="settings">

        <div id="page-container">
            <div class="content">
                <h1>Settings</h1>
                <div data-type="Facebook" class="api-container hidden">
                    <h3>Facebook</h3>
                    <div class="button"></div>
                    <input type="text" class="input-text"></input>
                </div>
                <div data-type="Twitter" class="api-container">
                    <h3>Twitter</h3>
                    <div class="button"></div>
                    <input type="text" class="input-text"></input>
                </div>
                <div data-type="Snapchat" class="api-container">
                    <h3>Snapchat</h3>
                    <div class="button"></div>
                    <input type="text" class="input-text"></input>
                </div>
                <div data-type="Instagram" class="api-container">
                    <h3>Instagram</h3>
                    <div class="button"></div>
                    <input type="text" class="input-text"></input>
                </div>
                <div data-type="Phone" class="api-container">
                    <h3>Phone</h3>
                    <div class="button"></div>
                    <input type="text" class="input-text"></input>
                </div>
            </div>
        </div>

        <div id="fb-root"></div>

        
        <!-- These are the notifications that are displayed to the user through pop-ups if the above JS files does not exist in the same directory-->
            
        <div id="log"></div>
    </body>
</html>
