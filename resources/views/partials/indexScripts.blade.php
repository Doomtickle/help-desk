    <script src="https://unpkg.com/isotope-layout@3/dist/isotope.pkgd.min.js"></script>
    <script>
// quick search regex
var qsRegex;
var statusButtonFilter;
var priorityButtonFilter;
var categoryButtonFilter;

// init Isotope
var grid = $('.grid').isotope({
    itemSelector: '.grid-item',
    layoutMode: 'fitRows',
    filter: function() {
        var $this = $(this);
        var searchResult = qsRegex ? $this.text().match( qsRegex ) : true;
        var statusButtonResult = statusButtonFilter ? $this.is( statusButtonFilter ) : true;
        var priorityButtonResult = priorityButtonFilter ? $this.is( priorityButtonFilter ) : true;
        var categoryButtonResult = categoryButtonFilter ? $this.is( categoryButtonFilter ) : true;
        return searchResult && statusButtonResult && priorityButtonResult && categoryButtonResult;
    }
});
$('#status-filters').on( 'click', 'button', function() {
    statusButtonFilter = $( this ).attr('data-filter');
    grid.isotope();
});
$('#priority-filters').on( 'click', 'button', function() {
    priorityButtonFilter = $( this ).attr('data-filter');
    grid.isotope();
});
$('#category-filters').on( 'click', 'button', function() {
    categoryButtonFilter = $( this ).attr('data-filter');
    grid.isotope();
});
// use value of search field to filter
var $quicksearch = $('.quicksearch').keyup( debounce( function() {
    qsRegex = new RegExp( $quicksearch.val(), 'gi' );
    grid.isotope();
}) );
// change is-checked class on buttons
$('.button-group').each( function( i, buttonGroup ) {
    var $buttonGroup = $( buttonGroup );
    $buttonGroup.on( 'click', 'button', function() {
        $buttonGroup.find('.is-checked').removeClass('is-checked');
        $( this ).addClass('is-checked');
    });
});
$("div").on("shown.bs.collapse", function(){
    grid.isotope();
});
$("div").on("hidden.bs.collapse", function(){
    grid.isotope();
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
                    var i;
                    $("#comment-modal").attr("action", "/" + data.id + "/comment");
                    $("#trouble_ticket_id").val(data.id);
                    $("#company_id").val(data.company_id);
                    $("#company_name").html(data.company_name);
                    for (i = 0; i < data.projects.length; i++){
                        $("select#projects").append( $("<option>")
                            .val(data.projects[i].id)
                            .html(data.projects[i].name)
                        );
                    }

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
    <script>
        $('select#projects').on('change', function () {

            var i;
            var data = $("select#projects").val();
            var myurl = "/subprojects/" + data;
            console.log(data);
            $.ajax({
                type: "GET",
                url: myurl,
                data: data,
                success: function (data) {
                    if(data.subprojects.length > 0){
                        for (i = 0; i < data.subprojects.length; i++){
                            $("select#subprojects").append( $("<option>")
                                .val(data.subprojects[i].beebole_id)
                                .html(data.subprojects[i].name)
                            );
                        }
                        $("#subproject-field").css("display", "block");
                    }

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
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Zebra_datepicker/1.9.4/javascript/zebra_datepicker.js"></script>
    <script>
    $(document).ready(function(){
        $("input#date_completed").Zebra_DatePicker();
    });
    </script>
    <script>
    $(document).ready(function(){
        $("input#start_date").Zebra_DatePicker();
        $("input#end_date").Zebra_DatePicker();
    });
    </script>
    <script>
        $(document).ready(function(){
           $('[data-toggle="tooltip"]').tooltip()
        });
    </script>



