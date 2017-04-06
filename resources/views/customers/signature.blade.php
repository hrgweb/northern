@extends('layouts.app')

@section ('content')
	<div class="container" style="margin-top: 5em;">
		<customer-signature-form date="{{ date('Y-m-d') }}"></customer-signature-form>
	</div>
@endsection
