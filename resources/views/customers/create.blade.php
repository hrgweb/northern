@extends('layouts.app')

@section ('content')
	<div class="container">
		<customer-create
			auth="{{ $user }}" 
			date="{{ date('Y-m-d') }}"
			token="{{ csrf_token() }}"
		></customer-create>
	</div>
@endsection
