<!--references the css doc...laravel style-->
<?php echo HTML::style('css/styles.css');?>

<!doctype html
<html>
<!-- This is a barebones login page. It has forms where user can put in email and password. -->
<head>
	<title>This is the Login</title>
</head>
<body>
	<div class="container">
	<!--creates form-->
	{{ Form::open(array('url' => 'login')) }}
		<h1>Login</h1>

		<!-- if there are login errors, show them here -->
		<p>
			{{ $errors->first('email') }}
			{{ $errors->first('password') }}
		</p>
		
		<p>
			{{ Form::label('email', 'Email Address') }}
			{{ Form::text('email', Input::old('email'), array('placeholder' => 'awesome@awesome.com')) }}
		</p>

		<p>
			{{ Form::label('password', 'Password') }}
			{{ Form::password('password') }}
		</p>

		<p>{{ Form::submit('Submit!') }}</p>

	{{ Form::close() }}
	</div>
</body>
</html>