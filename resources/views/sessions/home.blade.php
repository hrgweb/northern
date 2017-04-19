@extends('layouts.app')

@section ('content')
	<div class="container">
		<div class="dashboard">
			<div class="dashboard__logo">
				{{-- <img src="#" alt="northern"> --}}
				{{-- <h2 class="text-center">Northern</h2> --}}
			</div>

			<div class="dashboard__actions">
				<a href="{{ url('/customers') }}" role="button" class="btn btn-info btn-lg">Search For Existing Record</a>
				<a href="{{ url('/customers/create') }}" role="button" class="btn btn-warning btn-lg">Create A New Record</a>
				<a href="{{ url('/customers/signature') }}" role="button" class="btn btn-danger btn-lg">Signature</a>
				<a href="{{ url('collections') }}" role="button" class="btn btn-primary btn-lg">Collection</a>
			</div>
		</div>
	</div>
@endsection
