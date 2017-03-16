@extends('layouts.app')

@section ('content')
	<div class="container">
		<div class="dashboard">
			<div class="dashboard__logo">
				{{-- <img src="#" alt="northern"> --}}
				<h2 class="text-center">Northern</h2>
			</div>

			<div class="dashboard__actions">
				<a href="{{ url('/customers') }}" role="button" class="btn btn-default btn-lg">Search For Existing Record</a>
				<a href="{{ url('/customers/create') }}" role="button" class="btn btn-default btn-lg">Create A New Record</a>
			</div>
		</div>
	</div>
@endsection
