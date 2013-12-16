@extends('common.master')

@section('additionalHeaders')
	{{ HTML::style('assets/css/profile.css') }}
@stop

@section('content')
	<div class="basic">
		<h3 class="editheader">Edit Profile <small>{{$user->first.' '.$user->last.' ('.$user->email.')'}}</small></h3>
		<form class="form-horizontal" role="form">
			<div class="form-group">
				<label for="first" class="col-sm-3 control-label">First</label>
					<div class="col-sm-4">
						<input type="text" class="form-control" id="first" value="{{$user->first}}">
					</div>
			</div>
			<div class="form-group">
				<label for="last" class="col-sm-3 control-label">Last</label>
					<div class="col-sm-4">
						<input type="text" class="form-control" id="lst" value="{{$user->last}}">
					</div>
			</div>
			<div class="form-group">
				<label for="degree" class="col-sm-3 control-label">Degree</label>
					<div class="col-sm-4">
						<input type="text" class="form-control" id="degree" value="{{$user->degree_type}}">
					</div>
			</div>
			<div class="form-group">
				<label for="grad" class="col-sm-3 control-label">Graduation</label>
					<div class="col-sm-4">
						<input type="text" class="form-control" id="grad" value="{{$user->grad_date}}">
					</div>
			</div>
			<div class="form-group">
				<label for="major" class="col-sm-3 control-label">Major</label>
					<div class="col-sm-4">
						<input type="text" class="form-control" id="major" value="{{$user->major}}">
					</div>
			</div>
			<div class="form-group">
				<label for="minor" class="col-sm-3 control-label">Minor</label>
					<div class="col-sm-4">
						<input type="text" class="form-control" id="minor" value="{{$user->minor}}">
					</div>
			</div>
		</form>

	</div>
@stop