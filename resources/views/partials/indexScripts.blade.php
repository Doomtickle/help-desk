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
    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.js"></script>
    <script>
        $('.mark-complete').submit(function (e) {

            //TODO: find out why I have to do this
            //this is a workaround for ajax requests sometimes throwing a 500 Internal Server
            //error.  This will prefilter before each request.
            $.ajaxPrefilter(function (options, originalOptions, xhr) { // this will run before each request
                var token = $('meta[name="csrf-token"]').attr('content'); // or _token, whichever you are using

                if (token) {
                    return xhr.setRequestHeader('X-CSRF-TOKEN', token); // adds directly to the XmlHttpRequest Object
                }
            });

            e.preventDefault();

            var el = $(this);

            //TODO:
            //make this not suck so hard 
            //
            var id = el[0].children[2].value;
            //this is the easiest way I can think of to get the trouble ticket id. 
            //it's just a hidden form element at position el[0].children[2]

            var myurl = "/complete/" + id;
            $.ajax({
                type: "POST",
                url: myurl,
                data: $(this).serialize(),
                success: function (data) {
                    $("#comment-modal").attr("action", "/" + data.id + "/comment");
                    $("#trouble_ticket_id").val(data.id);
                    $('#myModal').modal("show");

                },
                error: function (xhr, ajaxOptions, thrownError) {
                    alert('There was an error processing your request. Please notify an administrator \n Error: ' + thrownError);
                    console.log(xhr.status);
                    console.log(xhr.responseText);
                    console.log(thrownError);
                }
            })
        });
    </script>
