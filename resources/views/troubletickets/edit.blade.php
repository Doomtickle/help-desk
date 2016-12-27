@extends ('layouts.app')

@section('content')
    <div class="container">
        <div class="jumbotron">
              <h1>This is where we'll edit a ticket.</h1>
              @include('forms.editTicket')
        </div>
    </div>
@stop
@section('scripts.footer')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/js/select2.min.js"></script>
    <script>
        $('#website').select2();
    </script>
@stop
