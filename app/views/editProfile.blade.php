@extends('common.master')

@section('additionalHeaders')
	{{ HTML::style('assets/css/profile.css') }}
	{{ HTML::style('assets/css/select2.css') }}
@stop

@section('content')
	<div class="basic">
		<form class="form-horizontal" role="form" action="{{ URL::to('deleteaccount/')}}" method="post">
			<button type="submit" class="btn btn-danger" style="float:right;margin-top:16px;" onclick="return confirm('Are you sure you would like to delete your account FOREVER? This includes deletion of all posts, comments, and up-votes as well as uploaded projects and pictures.');">Delete Account</button>
		</form>
		<h3 class="editheader">Edit Profile <small>{{$user->first.' '.$user->last.' ('.$user->email.')'}}</small></h3>
		{{ Form::open(array('url' => 'changedAccount', 'files' => true, 'class' => 'form-horizontal')) }}
			@if(is_null(Auth::User()->picture))
				{{ HTML::image('assets/img/dummy.png', 'profile picture', array('width' => '256', 'height' => '256', 'class' => 'editimage')) }}
			@else
				{{ HTML::image('assets/img/profile_images/'.Auth::User()->picture, 'profile picture', array('width' => '256', 'height' => '256', 'class' => 'editimage')) }}
			@endif 
			<div class="form-group">
				<label for="first" class="col-sm-3 control-label">Profile Picture</label>
					<div class="col-sm-4">
						{{Form::file('profilepic', array())}}	
					</div>
			</div>
			@if($errors->has('profilepic'))
				<span class="errormessage">
					{{$errors->first('profilepic')}}
				</span>
			@endif
			<hr>
			@if($errors->has('first'))
				<span class="errormessage">
					{{$errors->first('first')}}
				</span>
			@endif
			<div class="form-group">
				<label for="first" class="col-sm-3 control-label">First</label>
					<div class="col-sm-4">
						<input type="text" class="form-control" id="first" name="first" value="{{{$user->first}}}"/>
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
						<input type="text" class="form-control" id="last" name="last" value="{{{$user->last}}}"/>
					</div>
			</div>
			<div class="form-group">
				<label for="degree" class="col-sm-3 control-label">Degree</label>
					<div class="col-sm-4">
						<input type="text" class="form-control" id="degree" name="degree" value="{{{$user->degree_type}}}"/>
					</div>
			</div>
			<div class="form-group">
				<label for="grad" class="col-sm-3 control-label">Graduation</label>
					<div class="col-sm-4">
						<input type="text" class="form-control" id="grad" name="grad" value="{{{$user->grad_date}}}"/>
					</div>
			</div>
			<div class="form-group">
				<label for="major" class="col-sm-3 control-label">Major</label>
					<div class="col-sm-4">
						<input type="text" class="form-control" id="major" name="major" value="{{{$user->major}}}"/>
					</div>
			</div>
			<div class="form-group">
				<label for="minor" class="col-sm-3 control-label">Minor</label>
					<div class="col-sm-4">
						<input type="text" class="form-control" id="minor" name="minor" value="{{{$user->minor}}}"/>
					</div>
			</div>
			<hr>
				@if (isset($badPassword))
					<span class="errormessage">
						You have entered your current password incorrectly
					</span>
				@endif
				<div class="form-group">
				<label for="old" class="col-sm-3 control-label">Current Password</label>
					<div class="col-sm-4">
						<input type="password" class="form-control" id="old" name="old" value=""/>
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
						<input type="password" class="form-control" id="new" name="new"/>
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
						<input type="password" class="form-control" id="new_confirmation" name="new_confirmation"/>
					</div>
				</div>
				<hr>
				
				@if($errors->has('bio'))
				<span class="errormessage">
					{{$errors->first('bio')}}
				</span>
				@endif
				<div class="form-group">
				<label for="bio" class="col-sm-3 control-label">Bio</label>
					<div class="col-sm-4">
						<textarea type="text" class="form-control" id="bio" name="bio">{{{$user->bio}}}</textarea>
					</div>
				</div>
			<hr>
				<div class="form-group">
				<label for="classesStudent[]" class="col-sm-3 control-label">Courses Taking</label>
					<div class="col-sm-4">
						<select multiple class="select2-container-student classSelect" name="classesStudent[]" id="studentSelect">
							@foreach($studentSelectHTML as $html)
								{{$html}}
							@endforeach
						</select>
					</div>
				</div>
				<div class="form-group">
				<label for="classesTeacher[]" class="col-sm-3 control-label">Courses Teaching</label>
					<div class="col-sm-4">
						<select multiple class="select2-container-teacher classSelect" name="classesTeacher[]" id="teacherSelect">
							<optgroup label="Computer Science">
								@foreach($teacherSelectHTML as $html)
									{{$html}}
								@endforeach
							</optgroup>
						</select>
					</div>
				</div>
			<br>
			<button type="submit" class="btn btn-primary" style="float:right">Save Changes</button>
		</form>
		<form action="">
			<button type="submit" class="btn btn-danger">Cancel</button>
		</form>
	</div>
	<!-- Loading all scripts at the end for performance-->
	{{ HTML::script('//ajax.googleapis.com/ajax/libs/jquery/2.0.3/jquery.min.js') }}
	{{ HTML::script('assets/js/select2.min.js') }}
	<script>
		$(document).ready(function() { 
			$(".select2-container-student").select2({
				placeholder: "Select Your Classes"
			});
			$(".select2-container-teacher").select2({
				placeholder: "Select Your Classes"
			});		
		});
	</script>
@stop