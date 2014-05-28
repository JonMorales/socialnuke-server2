<!doctype html
<html>
<head>
	<!-- This is a barebones registration page. It has forms for name, username, email, and password. -->
	<title>Look at das Reggiestration!!</title>
</head>
<body>

	{{ Form::open(array('url' => 'registration')) }}
		<h1>Registrar</h1>

		<!-- if there are login errors, show them here -->
		<p>
			{{ Form::label('name', 'Name') }}
			{{ Form::text('name', Input::old('name'), array('placeholder' => 'Input Name')) }}
		</p>

		{{ Form::label('username', 'Username') }}
			{{ Form::text('username', Input::old('username'), array('placeholder' => 'Input Username')) }}

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

</body>
</html>