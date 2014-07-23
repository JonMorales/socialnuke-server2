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
        <script type="text/javascript" src="<?php echo URL::asset('js/jquery.js') ?>"></script>
    <script type="text/javascript" src="<?php echo URL::asset('js/scripts.js')?>"></script>

            
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