@extends('layouts.app')

@section ('content')
	<div class="container" style="margin-top: 5em;">
		<signature-form date="{{ date('Y-m-d') }}"></signature-form>
	</div>
@endsection

@section ('footer')
	<script src="/js/html2canvas.js"></script>
@endsection