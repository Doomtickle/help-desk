    <div class="container">
        <div class="row">
            <div class="form-group col-md-5 button-group">
                <input type="text" name="quicksearch" class="quicksearch form-control" data-filter=".quicksearch" placeholder="Search" autofocus />
            </div>
        </div>
        <div class="row">
            <div id="status-filters" class="button-group col-md-5">
                <h3>Status</h3>
                <button class="button is-checked" data-filter="*">Show All</button>
                <button class="button" data-filter=".incomplete">Incomplete</button>
                <button class="button" data-filter=".complete">Complete</button>
            </div>
            <div id="priority-filters" class="button-group col-md-5">
                <h3>Priority</h3>
                <button class="button is-checked" data-filter="*">Show All</button>
                <button class="button" data-filter=".priority-1">Priority 1</button>
                <button class="button" data-filter=".priority-2">Priority 2</button>
                <button class="button" data-filter=".priority-3">Priority 3</button>
            </div>
        </div>
    </div>
    <div class="container">
        <div class="grid">
            <div class="row">
                <div class="grid-sizer"></div>
                @foreach($tickets as $tt)
                    <div class="grid-item{{ $tt->complete ? ' complete' : ' incomplete' }} priority-{{ $tt->priority }} {{ str_replace('.', '-', $tt->website) }}" data-category="{{ str_replace('.', '-', $tt->website) }}">
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
                                    @unless($tt->complete)
                                       <div class="form-group">
                                           <button type="submit" class="btn btn-danger btn-full-width">Mark Complete</button>
                                       </div> 
                                   @endunless
                                </form>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
