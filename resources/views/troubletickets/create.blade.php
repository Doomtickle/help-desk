@extends('adminlte::layouts.app')

@section('main-content')
    <div class="container">
        <div class="col-md-6">
            <h1>New Ticket</h1>
            @include('forms.createTicket')
        </div>
    </div>
@stop
@section('scripts.footer')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/iCheck/1.0.2/icheck.min.js"></script>
    <script>
        $(document).ready(function(){
          $('input').iCheck({
            radioClass: 'iradio_flat-red',
            increaseArea: '20%' // optional
          });
        });
    </script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/dropzone/4.3.0/min/dropzone.min.js"></script>
    <script>
    Dropzone.options.createTicket = { // The camelized version of the ID of the form element

      // The configuration we've talked about above
      addRemoveLinks: true,
      paramName: 'files[]',
      autoProcessQueue: false,
      uploadMultiple: true,
      parallelUploads: 100,
      maxFiles: 100,
      clickable: false,


      // The setting up of the dropzone
      init: function() {
        var myDropzone = this;

        // First change the button to actually tell Dropzone to process the queue.
        this.element.querySelector("button[type=submit]").addEventListener("click", function(e) {
            if(!myDropzone.files || myDropzone.files.length){
              // Make sure that the form isn't actually being sent.
              e.preventDefault();
              e.stopPropagation();
              myDropzone.processQueue();
            }else{
                myDropzone.processQueue();
            }
            myDropzone.on("successmultiple", function(files, response) {
                window.location.replace("/home");
            });
        });
    }
}
    </script>
@stop
