    <script src="https://unpkg.com/isotope-layout@3/dist/isotope.pkgd.min.js"></script>
    <script>
// quick search regex
var qsRegex;
var statusButtonFilter;
var priorityButtonFilter;

// init Isotope
var $grid = $('.grid').isotope({
    itemSelector: '.grid-item',
    layoutMode: 'fitRows',
    filter: function() {
        var $this = $(this);
        var searchResult = qsRegex ? $this.text().match( qsRegex ) : true;
        var statusButtonResult = statusButtonFilter ? $this.is( statusButtonFilter ) : true;
        var priorityButtonResult = priorityButtonFilter ? $this.is( priorityButtonFilter ) : true;
        return searchResult && statusButtonResult && priorityButtonResult;
    }
});

$('#status-filters').on( 'click', 'button', function() {
    statusButtonFilter = $( this ).attr('data-filter');
    $grid.isotope();
});
$('#priority-filters').on( 'click', 'button', function() {
    priorityButtonFilter = $( this ).attr('data-filter');
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
