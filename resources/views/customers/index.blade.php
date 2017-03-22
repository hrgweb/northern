@extends('layouts.app')

@section ('content')
	<div class="container">
		<customer
			auth="{{ $user }}" 
			date="{{ date('Y-m-d') }}"
			token="{{ csrf_token() }}"
		></customer>
	</div>
@endsection
