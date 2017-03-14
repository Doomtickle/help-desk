@extends('adminlte::layouts.app')
@section ('main-content')
    @php
        if($_GET){
        $notification = Auth::user()->notifications->where('id', $_GET['mark'])->first();
        $notification->markAsRead();
        }
    @endphp
    <div class="container">
        <div class="col-md-offset-3 col-md-6">
            <div class="box box-{{$tt->complete ? 'success' : 'danger'}} {{$tt->status == 'On Hold' ? 'on-hold': ''}}">
                <div class="box-header with-border">
                    <div class="box-title">
                        <h3>
                            Task #{{ $tt->id }}
                        </h3>
                    </div>
                </div>
                <div class="box-body">
                    <ul class="list-group">
                        <li class="list-group-item"><strong>Company:</strong> {{ $tt->company }}</a></li>
                        <li class="list-group-item"><strong>Title: </strong> {{ $tt->title }}</li>
                        <li class="list-group-item"><strong>Description:</strong> {{ $tt->description }}</li>
                        <li class="list-group-item"><strong>Status:</strong> {{ $tt->status }} </li>
                        <li class="list-group-item"><strong>Category:</strong> {{ $tt->category }} </li>
                        <li class="list-group-item"><strong>Priority</strong> {{ $tt->priority }}</li>
                        <li class="list-group-item"><strong>Created:</strong> {{ $tt->created_at->diffForHumans() }}</li>
                        @if($tt->supportingFiles->count())
                        <li class="list-group-item"><strong>Attachments:</strong>
                            <ul>
                                @foreach($tt->supportingFiles as $sf)
                                <li class="list-group-item no-border"><a href="{{ asset($sf->path) }}">{{ $sf->original_name }}</a></li>
                                @endforeach
                            </ul>
                        </li>
                        @endif

                    </ul>

                    {{-- <a href="/ticket/{{ $tt->id }}/edit" class="btn btn-info btn-full-width">Edit this ticket</a> --}}
{{--                     @unless($tt->complete)
                        <form action="/complete/{{ $tt->id }}" method="post">
                            {{ method_field('PATCH') }}
                            {{ csrf_field() }}
                            <div class="form-group">
                                <button type="submit" class="btn btn-danger btn-full-width">Mark Complete</button>
                            </div> 
                        </form>
                    @endunless--}}
                </div>
                <div class="box-footer">
                    <div class="well">
                        <ul>
                            @foreach( $tt->comments as $comment)
                            <li>{{ $comment->body }}</li>
                            <li>Time Spent: {{ $comment->time_spent }} hrs</li>
                            <li>By: {{ App\User::find($comment->user_id)->name }}</li>
                            @endforeach
                        </ul>
                    </div>
                    
                </div>
            </div>
        </div>
    </div>
@stop
