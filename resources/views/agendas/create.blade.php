@extends('adminlte::layouts.app')

@section('htmlheader_title')
Create Agenda
@endsection

@section('main-content')
	<div class="container-fluid spark-screen">
		<div class="row">
			<div class="col-md-4 col-md-offset-4">
				<div class="panel panel-default">
					<div class="panel-heading">Create new Agenda</div>
					<div class="panel-body">
					<form action="/agendas" method="POST" role="form">
						{{ csrf_field() }}
					    @if (count($errors) > 0)
					        <div class="alert alert-danger">
					            <ul>
					                @foreach ($errors->all() as $error)
					                    <li>{{ $error }}</li>
					                @endforeach
					            </ul>
					        </div>
					    @endif
						<div class="form-group">
							<label for="start_date">Start Date:</label>
							<input type="text" class="form-control" name="start_date" id="agenda_start_date" 
							val="{{ \Carbon\Carbon::now()->toDateString() }}">
						</div>
						<div class="form-group">
							<label for="end_date">End Date:</label>
							<input type="text" class="form-control" name="end_date" id="agenda_end_date" 
							val="{{ \Carbon\Carbon::now()->addDays(4)->toDateString() }}">
						</div>
						<button type="submit" class="btn btn-primary">Create Agenda</button>
					</form>
					</div>
				</div>
			</div>
		</div>
	</div>
@endsection
@section('scripts.footer')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Zebra_datepicker/1.9.4/javascript/zebra_datepicker.js"></script>
    <script>
    $(document).ready(function(){
        $("input#agenda_start_date").Zebra_DatePicker();
        $("input#agenda_end_date").Zebra_DatePicker();
    });
    </script>
@endsection