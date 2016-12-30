@extends('adminlte::layouts.app')

@section ('main-content')
    <div class="container">
        <div class="col-md-offset-3 col-md-6">
            <div class="box box-{{$tt->complete ? 'success' : 'danger'}} {{$tt->status == 'On Hold' ? 'on-hold': ''}}">
                <div class="box-header with-border">
                    <div class="box-title">
                        <h3>
                            Trouble Ticket #{{ $tt->id }}
                        </h3>
                    </div>
                </div>
                <div class="box-body">
                    <ul class="list-group">
                        <li class="list-group-item"><strong>Website:</strong> <a href="http://{{ $tt->website }}" target="_blank">{{ $tt->website }}</a></li>
                        <li class="list-group-item"><strong>Title: </strong> {{ $tt->title }}</li>
                        <li class="list-group-item"><strong>Description:</strong> {{ $tt->description }}</li>
                        <li class="list-group-item"><strong>Status:</strong> {{ $tt->status }} </li>
                        <li class="list-group-item"><strong>Priority</strong> {{ $tt->priority }}</li>
                        <li class="list-group-item"><strong>Created:</strong> {{ $tt->created_at->diffForHumans() }}</li>
                    </ul>
                    <a href="/ticket/{{ $tt->id }}/edit" class="btn btn-info btn-full-width">Edit this ticket</a>
                    <form action="/complete/{{ $tt->id }}" method="post">
                        {{ method_field('PATCH') }}
                        {{ csrf_field() }}
                        <div class="form-group">
                            <button type="submit" class="btn btn-danger btn-full-width">Mark Complete</button>
                        </div> 
                    </form>
                </div>
            </div>
        </div>
    </div>
@stop
