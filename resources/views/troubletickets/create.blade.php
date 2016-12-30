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
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/js/select2.min.js"></script>
    <script>
        $('#website').select2();
    </script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/iCheck/1.0.2/icheck.min.js"></script>
    <script>
        $(document).ready(function(){
          $('input').iCheck({
            radioClass: 'iradio_flat-red',
            increaseArea: '20%' // optional
          });
        });
    </script>
@stop
