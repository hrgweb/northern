@extends('layouts.app')

@section ('content')
    <collection date="{{ date('Y-m-d') }}" auth="{{ auth()->user() }}"></collection>
@endsection
