@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="form-group form-inline button-group">
            <input type="text" name="quicksearch" class="quicksearch form-control" data-filter=".quicksearch" placeholder="Search" />
        </div>
        <div id="filters" class="button-group">
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
                @endforeach
            </div>
        </div>
    </div>
@stop
@section('scripts.footer')
    <script src="https://unpkg.com/isotope-layout@3/dist/isotope.pkgd.min.js"></script>
    <script>
        // quick search regex
        var qsRegex;
        var buttonFilter;

        // init Isotope
        var $grid = $('.grid').isotope({
            itemSelector: '.grid-item',
            layoutMode: 'fitRows',
            filter: function() {
                var $this = $(this);
                var searchResult = qsRegex ? $this.text().match( qsRegex ) : true;
                var buttonResult = buttonFilter ? $this.is( buttonFilter ) : true;
                return searchResult && buttonResult;
            }
        });

        $('#filters').on( 'click', 'button', function() {
            buttonFilter = $( this ).attr('data-filter');
            $grid.isotope();
        });

        // use value of search field to filter
        var $quicksearch = $('.quicksearch').keyup( debounce( function() {
            qsRegex = new RegExp( $quicksearch.val(), 'gi' );
            $grid.isotope();
        }) );


        // change is-checked class on buttons
        $('.button-group').each( function( i, buttonGroup ) {
            var $buttonGroup = $( buttonGroup );
            $buttonGroup.on( 'click', 'button', function() {
                $buttonGroup.find('.is-checked').removeClass('is-checked');
                $( this ).addClass('is-checked');
            });
        });


        // debounce so filtering doesn't happen every millisecond
        function debounce( fn, threshold ) {
            var timeout;
            return function debounced() {
                if ( timeout ) {
                    clearTimeout( timeout );
                }
                function delayed() {
                    fn();
                    timeout = null;
                }
                setTimeout( delayed, threshold || 100 );
            };
        }
    </script>
@stop
