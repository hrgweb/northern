@extends('layouts.app')

@section ('content')
	<div class="container">
		<div class="login">
			<h2>Staff Login</h2>

			<form action="/login" method="POST" role="form">
				{{ csrf_field() }}

				@include ('errors._list')

				<div class="form-group">
					<label for="username">Username</label>
					<input type="text" name="username" class="form-control" id="username" value="{{ old('username') }}">
				</div>
			
				<div class="form-group">
					<label for="password">Password</label>
					<input type="password" name="password" class="form-control" id="password">
				</div>	
			
				<button type="submit" class="btn btn-info">Sign In</button>
			</form>
		</div>
	</div>
@endsection
