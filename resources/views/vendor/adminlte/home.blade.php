@extends('adminlte::layouts.app')

@section('htmlheader_title')
	KMA HelpDesk
@endsection


@section('main-content')
    @if( ! \Auth::user()->beebole_key)
        @include('partials.beebolekey')
    @else
        @include('partials.index')
    @endif
@stop

@section('scripts.footer')
    @include('partials.indexScripts')
@stop
