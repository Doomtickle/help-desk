@extends('adminlte::layouts.app')

@section ('main-content')
    <div class="container">
        <div class="col-md-4">
            <div class="panel panel-primary">
                <div class="panel-heading">Trouble Ticket #{{ $tt->id }}</div>
                    <div class="panel-body">
                        <ul class="list-group">
                            <li class="list-group-item"><strong>Title: </strong><br/> {{ $tt->title }}</li>
                            <li class="list-group-item"><strong>Description:</strong> {{ $tt->description }}</li>
                            <li class="list-group-item"><strong>Status:</strong> {{ $tt->status }} </li>
                            <li class="list-group-item"><strong>Completed?:</strong> {{ $tt->complete ? 'Yes' : 'No' }}</li>
                            <li class="list-group-item"><strong>Website:</strong> <a href="http://{{ $tt->website }}" target="_blank">{{ $tt->website }}</a></li>
                        </ul>
                        <a href="/ticket/{{ $tt->id }}/edit" class="btn btn-primary btn-full-width">Edit this ticket</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop
