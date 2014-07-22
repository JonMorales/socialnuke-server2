<html>
<head>
<link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css">
	<style>
		#page-container { width: 50%; margin:150px auto; text-align: center; }
		#nuke-container { width: 50%; margin:-325px auto; text-align: center; }
    
    	.button {
            border-radius: 500px;
            border: 1px solid black;
            height: 500px;
            width: 500px;
            background-color: #980000;
            margin: 0 auto 10px;
        }

        .button:hover {
        	cursor: pointer;
        }

        .text {
        	font-size: 500%;
        	color: #FFFFFF;
        }
	</style>
    <script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
    <script type="text/javascript">
    	$(document).ready(function() {
    		var nuke = {};
    			nuke.initialize = function() {
    				this.base = $('#page-container');
    				this._button = $(this.base.find('.button'));
    				this.launchListener();
    			}
    			nuke.launchListener = function() {
    				var self = this;
    				this._button.click(function() {
    					//code
    				}    	
    			)}
    		nuke.initialize();  
		})

    </script>

</head>
<body>

	<div id="page-container">
		<button type="button" class="button"></button>
			<div id="nuke-container">
				<div class="text"><p>NUKE</p></div>
			</div>
	</div>
</body>
</html>