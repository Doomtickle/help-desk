    <div class="container">
        <div class="form-group col-md-5 button-group">
            <input type="text" name="quicksearch" class="quicksearch form-control" data-filter=".quicksearch" placeholder="Search" autofocus />
        </div>
        <div id="filters" class="button-group col-md-offset-2 col-md-5">
            <button class="button is-checked" data-filter="*">Show All</button>
            <button class="button" data-filter=".complete">Complete</button>
            <button class="button" data-filter=".incomplete">Incomplete</button>
        </div>
    </div>
    <div class="container">
        <div class="grid">
            <div class="row">
                <div class="grid-sizer"></div>
                @foreach($tickets as $tt)
                    <div class="grid-item{{ $tt->complete ? ' complete' : ' incomplete' }} {{ str_replace('.', '-', $tt->website) }}" data-category="{{ str_replace('.', '-', $tt->website) }}">
                        <div class="box box-solid box-{{$tt->complete ? 'success' : 'danger'}} {{$tt->status == 'On Hold' ? 'on-hold': ''}}">
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
                                    <li class="list-group-item"><strong>Title: </strong><br/> {{ $tt->title }}</li>
                                    <li class="list-group-item"><strong>Description:</strong> {{ $tt->description }}</li>
                                    <li class="list-group-item"><strong>Status:</strong> {{ $tt->status }} </li>
                                    <li class="list-group-item"><strong>Priority</strong> {{ $tt->priority }}</li>
                                    <li class="list-group-item"><strong>Created:</strong> {{ $tt->created_at->diffForHumans() }}</li>
                                </ul>
                                <a href="/ticket/{{ $tt->id }}/edit" class="btn btn-primary btn-full-width">Edit this ticket</a>
                                <form action="/complete/{{ $tt->id }}" method="post">
                                    {{ method_field('PATCH') }}
                                    {{ csrf_field() }}
                                   <div class="form-group">
                                       <button type="submit" class="btn btn-success btn-full-width">Mark Complete</button>
                                   </div> 
                                </form>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
