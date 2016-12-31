@extends('adminlte::layouts.app')

@section('main-content')
    <div class="container">
        <div class="row">
            <div class="col-md-6">
                <h1>Edit Ticket #{{ $ticket->id }}</h1>
            </div>
            <div class="col-md-6">
                @unless($ticket->complete)
                    <form action="/complete/{{ $ticket->id }}" method="post">
                        {{ method_field('PATCH') }}
                        {{ csrf_field() }}
                           <div class="form-group">
                               <button type="submit" class="btn btn-danger pull-right">Mark Complete</button>
                           </div> 
                    </form>
               @endunless
            </div>
        </div>
          @include('forms.editTicket')
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
    <script>
    @php
        switch($ticket->priority){
           case 1:
              echo '$("#priority-1").iCheck("check");'; 
              break;
           case 2:
              echo '$("#priority-2").iCheck("check");'; 
              break;
           case 3:
              echo '$("#priority-3").iCheck("check");'; 
              break;
          }
    @endphp
    </script>
    <script>
    @php
        switch($ticket->status){
           case 'Pending':
              echo '$("#pending").iCheck("check");'; 
              break;
           case 'On Hold':
              echo '$("#on-hold").iCheck("check");'; 
              break;
           case 'Complete':
              echo '$("#complete").iCheck("check");'; 
              break;
          }
    @endphp
    </script>
@stop
