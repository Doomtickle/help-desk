@extends('adminlte::page')

@section('htmlheader_title')
	Change Title here!
@endsection


@section('main-content')
	<div class="container-fluid spark-screen">
		<div class="row">
			<div class="col-md-8 col-md-offset-2">
				<div class="panel panel-default">
					<div class="panel-heading">Enter your Beebole API key</div>
					<div class="panel-body">
						<div class="alert alert-info">
						You won't be able to log your hard work into Beebole unless you provide your beebole API key. 
						</div>
						<form action="/beebole_key" method="POST" role="form">
						    @if (count($errors) > 0)
						        <div class="alert alert-danger">
						            <ul>
						                @foreach ($errors->all() as $error)
						                    <li>{{ $error }}</li>
						                @endforeach
						            </ul>
						        </div>
						    @endif
							{{ csrf_field() }}
							<legend>API Key</legend>
							<div class="form-group">
								<input type="text" class="form-control" name="beebole_key" id="beebole_key" placeholder="Paste your beebole API key here">
							</div>
							<button type="submit" class="btn btn-primary">Submit</button>
						</form>
					</div>
				</div>
			</div>
		</div>
	</div>
@endsection
