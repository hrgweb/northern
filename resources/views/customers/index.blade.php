@extends('layouts.app')

@section ('content')
	<div class="container">
		<customer auth="{{ $user }}"></customer>
	</div>
@endsection
