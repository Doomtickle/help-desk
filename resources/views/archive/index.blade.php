@extends('adminlte::page')
@section('htmlheader_title')
Archive
@endsection
@section('main-content')
<div class="container">
	<h1>Archive</h1>
	<div class="row">
		<div class="form-group col-md-4 button-group searchbar">
			<input type="text" name="quicksearch" class="quicksearch form-control" data-filter=".quicksearch" placeholder="Search" autofocus />
		</div>
		<div class="col-md-8">
			<div id="status-filters" class="button-group col-md-3">
				<div class="status-buttons">
					<h3>Status</h3>
					<button class="button is-checked" data-filter="*">Show All</button>
					<button id="incomplete-btn" class="button" data-filter=".incomplete">Incomplete</button>
					<button id="complete-btn" class="button" data-filter=".complete">Complete</button>
					<button class="button" data-filter=".on-hold">On hold</button>
				</div>
			</div>
			<div id="priority-filters" class="button-group col-md-3">
				<div class="status-buttons">
					<h3>Priority</h3>
					<button class="button is-checked" data-filter="*">Show All</button>
					<button class="button" data-filter=".priority-1">Priority 1</button>
					<button class="button" data-filter=".priority-2">Priority 2</button>
					<button class="button" data-filter=".priority-3">Priority 3</button>
				</div>
			</div>
			<div id="category-filters" class="button-group col-md-3">
				<div class="status-buttons">
					<h3>Category</h3>
					<button class="button is-checked" data-filter="*">Show All</button>
					<button class="button" data-filter=".category-web">Web</button>
					<button class="button" data-filter=".category-creative">Creative</button>
				</div>
			</div>
		</div>
	</div>
	<div class="container">
		<div class="grid">
			<div class="row">
				<div class="grid-sizer"></div>
				@foreach($tickets as $tt)
				<div id="box{{ $tt->id }}" class="grid-item{{ $tt->complete ? ' complete' : ' incomplete' }} priority-{{ $tt->priority }} {{$tt->status == 'On Hold' ? 'on-hold': ''}} category-{{ strtolower($tt->category) }}" data-category="{{ $tt->company }}" style="word-wrap: break-word;">
					<div id="ticket{{ $tt->id }}" class="box box-{{$tt->complete ? 'success' : 'danger'}}">
						<div class="box-header with-border">
							<div class="box-title">
								<h3>{{  $tt->title }}</h3>
							</div>
						</div>
						<div class="box-body">
							<ul class="list-group">
								<li class="list-group-item"><strong>Company:</strong> {{ $tt->company }}</a></li>
								<li class="list-group-item"><strong>Description:</strong> {{ $tt->description }}</li>
								<li id="status{{$tt->id}}" class="list-group-item"><strong>Status:</strong> {{ $tt->status }} </li>
								<li id="category{{$tt->id}}" class="list-group-item"><strong>Category:</strong> {{ $tt->category }} </li>
								<li class="list-group-item"><strong>Priority:</strong> {{ $tt->priority }}</li>
								<li class="list-group-item"><strong>Created:</strong> {{ $tt->created_at->diffForHumans() }}</li>
								@if($tt->supportingFiles->count())
								<li class="list-group-item"><strong>Attachments:</strong>
									<dl>
										@foreach($tt->supportingFiles as $sf)
										<li class="list-group-item no-border"><a href="{{ asset($sf->path) }}">{{ $sf->original_name }}</a></li>
										@endforeach
									</dl>
								</li>
								@endif
							</ul>
							@unless($tt->complete)
							<a href="/ticket/{{ $tt->id }}/edit" class="btn btn-info btn-full-width">Edit this ticket</a>
							@endunless
							@if($tt->comments->count())
							<a class="btn btn-full-width btn-warning" id="ticket-comment-{{$tt->id}}" role="button" data-toggle="collapse" href="#ticket-{{ $tt->id }}-comment" aria-expanded="false" aria-controls="ticket-{{ $tt->id }}-comment">View Comments</a>
							<div class="collapse collaspe-target" id="ticket-{{ $tt->id }}-comment">
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
							@endif
							@unless($tt->complete)
							<form action="/complete/{{ $tt->id }}" id="complete{{ $tt->id }}" method="post" class="mark-complete">
								{{ method_field('PATCH') }}
								{{ csrf_field() }}
								<input type="hidden" class="get-id" value="{{ $tt->id }}">
								<div class="form-group">
									<button type="submit" name="mark_complete" class="btn btn-danger btn-full-width" id="submit{{ $tt->id }}" >Mark Complete</button>
								</div>
							</form>
							@endunless
						</div>
					</div>
				</div>
				@endforeach
			</div>
		</div>
	</div>
</div>
@endsection
@section('scripts.footer')
	@include('partials.indexScripts')
@endsection