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
	<script type="text/javascript" src="<?php echo URL::asset('js/jquery.js') ?>"></script>
	<script type="text/javascript" src="<?php echo URL::asset('js/scripts.js')?>"></script>

</head>
<body class="login">
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
