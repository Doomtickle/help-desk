@extends('adminlte::layouts.app')

@section('htmlheader_title')
	KMA HelpDesk
@endsection


@section('main-content')
    @include('partials.index')
@stop

@section('scripts.footer')
    @include('partials.indexScripts')
@stop
