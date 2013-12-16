@extends('common.master')

@section('additionalHeaders')
	{{ HTML::style('assets/css/profile.css') }}
@stop

@section('content')
	<div class="basic">
		<h3 class="editheader">Edit Profile <small>{{$user->first.' '.$user->last.' ('.$user->email.')'}}</small></h3>
		<form class="form-horizontal" role="form" action="<?php echo asset('changedAccount'); ?>" method="post">
			@if($errors->has('first'))
				<span class="errormessage">
					{{$errors->first('first')}}
				</span>
			@endif
			<div class="form-group">
				<label for="first" class="col-sm-3 control-label">First</label>
					<div class="col-sm-4">
						<input type="text" class="form-control" id="first" name="first" value="{{$user->first}}">
					</div>
			</div>
			
			@if($errors->has('last'))
				<span class="errormessage">
					{{$errors->first('last')}}
				</span>
			@endif
			<div class="form-group">
				<label for="last" class="col-sm-3 control-label">Last</label>
					<div class="col-sm-4">
						<input type="text" class="form-control" id="last" name="last" value="{{$user->last}}">
					</div>
			</div>
			<div class="form-group">
				<label for="degree" class="col-sm-3 control-label">Degree</label>
					<div class="col-sm-4">
						<input type="text" class="form-control" id="degree" name="degree" value="{{$user->degree_type}}">
					</div>
			</div>
			<div class="form-group">
				<label for="grad" class="col-sm-3 control-label">Graduation</label>
					<div class="col-sm-4">
						<input type="text" class="form-control" id="grad" name="grad" value="{{$user->grad_date}}">
					</div>
			</div>
			<div class="form-group">
				<label for="major" class="col-sm-3 control-label">Major</label>
					<div class="col-sm-4">
						<input type="text" class="form-control" id="major" name="major" value="{{$user->major}}">
					</div>
			</div>
			<div class="form-group">
				<label for="minor" class="col-sm-3 control-label">Minor</label>
					<div class="col-sm-4">
						<input type="text" class="form-control" id="minor" name="minor" value="{{$user->minor}}">
					</div>
			</div>
			<hr>
				@if (isset($badPassword))
					<span class="errormessage">
						You have entered you current password incorrectly
					</span>
				@endif
				<div class="form-group">
				<label for="old" class="col-sm-3 control-label">Current Password</label>
					<div class="col-sm-4">
						<input type="password" class="form-control" id="old" name="old" value="">
					</div>
				</div>
				
				@if($errors->has('new'))
				<span class="errormessage">
					{{$errors->first('new')}}
				</span>
				@endif
				<div class="form-group">
				<label for="last" class="col-sm-3 control-label">New Password</label>
					<div class="col-sm-4">
						<input type="password" class="form-control" id="new" name="new">
					</div>
				</div>
				@if($errors->has('new_confirmation'))
				<span class="errormessage">
					{{$errors->first('new_confirmaiton')}}
				</span>
				@endif
				<div class="form-group">
				<label for="new_confirmation" class="col-sm-3 control-label">Confirm Password</label>
					<div class="col-sm-4">
						<input type="password" class="form-control" id="new_confirmation" name="new_confirmation">
					</div>
				</div>
			<hr>
			<br>
			<button type="submit" class="btn btn-primary" style="float:right">Save Changes</button>
		</form>
		<form action="">
			<button type="submit" class="btn btn-danger">Cancel</button>
		</form>

	</div>
@stop