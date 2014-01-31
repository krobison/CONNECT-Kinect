@extends('common.master')

@section('additionalHeaders')
	{{ HTML::style('assets/css/profile.css') }}
	{{ HTML::style('assets/css/select2.css') }}
@stop

@section('title')
	EDIT PROFILE.
@stop

@section('content')
	<div class="basic">
	
		{{-- Delete Account Button --}}
		<form class="form-horizontal" role="form" action="{{ URL::to('deleteaccount/')}}" method="post">
			<button type="submit" class="btn btn-danger" style="float:right;margin-top:16px;" onclick="return confirm('Are you sure you would like to delete your account FOREVER? This includes deletion of all posts, comments, and up-votes as well as uploaded projects and pictures.');">
				<span class="glyphicon glyphicon-trash"></span> Delete Account
			</button>
		</form>
		
		<h3 class="editheader">Edit Profile <small>{{$user->first.' '.$user->last.' ('.$user->email.')'}}</small></h3>
		
		{{ Form::open(array('url' => 'changedAccount', 'files' => true, 'class' => 'form-horizontal')) }}
		
			{{-- Profile Picture --}}
			<div style="margin-left: 80px; margin-bottom: 10px">
			<div class="pictureDivEdit" style="background: url(@if(is_null($user->picture))
					{{ URL::asset('assets/img/dummy.png') }}
				@else
					{{ URL::asset('assets/img/profile_images/'.$user->picture) }}
				@endif ) no-repeat center center; background-size: cover">
			</div>
			</div>
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
			
			{{-- First Name --}}
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
			
			{{-- Last Name --}}
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
			
			{{-- Degree --}}
			<div class="form-group">
				<label for="degree" class="col-sm-3 control-label">Degree</label>
				<div class="col-sm-4">
					{{ Form::select('degree_type', 
					array(
						null => null,
						'Bachelors' => 'Bachelors',
						'Combined Bachelors/Masters' => 'Combined Bachelors/Masters',
						'Masters' => 'Masters',
						'PhD' => 'PhD',
						'N/A' => 'N/A'
					),$user->degree_type,array(
						'id' => 'degree_type',
						'style' => 'width:100%'
					))}}	
				</div>
			</div>
			
			{{-- Graduation Date --}}
			<div class="form-group">
				<label for="grad" class="col-sm-3 control-label">Graduation</label>
				<div class="col-sm-4">
					{{ Form::select('grad_date', 
					array(
						null => null,
						'May 2014' => 'May 2014',
						'Dec 2014' => 'Dec 2014',
						'May 2015' => 'May 2015',
						'Dec 2015' => 'Dec 2015',
						'May 2016' => 'May 2016',
						'Dec 2016' => 'Dec 2016',
						'May 2017' => 'May 2017',
						'Dec 2017' => 'Dec 2017',
						'May 2018' => 'May 2018',
						'Dec 2018' => 'Dec 2018',
						'May 2019' => 'May 2019',
						'Dec 2019' => 'Dec 2019'
					),$user->grad_date,array(
							'id' => 'grad_date',
							'style' => 'width:100%'
					))}}
				</div>
			</div>
			
			{{-- Major --}}
			<div class="form-group">
				<label for="major" class="col-sm-3 control-label">Major</label>
				<div class="col-sm-4">
					{{ Form::select('major[]', 
						array(
							'Applied Mathematics and Statistics' => 'Applied Mathematics and Statistics',
							'Chemical Engineering' => 'Chemical Engineering',
							'Chemical & Biochemical Engineering' => 'Chemical & Biochemical Engineering',
							'Chemistry' => 'Chemistry',
							'Civil Engineering' => 'Civil Engineering',
							'Computer Science' => 'Computer Science',
							'Economics' => 'Economics',
							'Electrical Engineering' => 'Electrical Engineering',
							'Engineering' => 'Engineering',
							'Engineering Physics' => 'Engineering Physics',
							'Environmental Engineering' => 'Environmental Engineering',
							'Geological Engineering' => 'Geological Engineering',
							'Geophysical Engineering' => 'Geophysical Engineering',
							'Mechanical Engineering' => 'Mechanical Engineering',
							'Metallurgical & Materials Engineering' => 'Metallurgical & Materials Engineering',
							'Mining Engineering' => 'Mining Engineering',
							'Petroleum Engineering' => 'Petroleum Engineering'
						),explode(', ',$user->major),array(
							'multiple',
							'id' => 'major',
							'style' => 'width:100%'
						))
					}}
				</div>
			</div>
			
			{{-- Minor --}}
			<div class="form-group">
				<label for="minor" class="col-sm-3 control-label">Minor</label>
				<div class="col-sm-4">
					{{ Form::select('minor[]', 
						array(
							'Bioengineering and Life Sciences (BELS)' => 'Bioengineering and Life Science (BELS)',
							'Chemistry' => 'Chemistry',
							'Computational & Applied Mathematics' => 'Computational & Applied Mathematics',
							'Computer Sciences' => 'Computer Sciences',
							'Economics' => 'Economics',
							'Energy' => 'Energy',
							'Engineering (General)' => 'Engineering (General)',
							'Engineering – Civil' => 'Engineering – Civil',
							'Engineering – Electrical' => 'Engineering – Electrical',
							'Engineering – Environmental' => 'Engineering – Environmental',
							'Engineering – Mechanical' => 'Engineering – Mechanical',
							'Engineering Physics' => 'Engineering Physics',
							'Explosive Processing of Materials' => 'Explosive Processing of Materials',
							'Explosives Engineering' => 'Explosives Engineering',
							'Geological Engineering' => 'Geological Engineering',
							'Geophysical Engineering' => 'Geophysical Engineering',
							'Humanitarian Engineering' => 'Humanitarian Engineering',
							'Humanitarian Studies & Technology' => 'Humanitarian Studies & Technology',
							'Humanities' => 'Humanities',
							'International Political Economy' => 'International Political Economy',
							'International Studies' => 'International Studies',
							'Liberal Arts' => 'Liberal Arts',
							'Liberal Arts & International Studies Individualized Undergraduate Minor' => 'Liberal Arts & International Studies Individualized Undergraduate Minor',
							'Literature Society & the Environment' => 'Literature, Society, & the Environment',
							'Mathematical & Computer Sciences' => 'Mathematical & Computer Sciences',
							'Mathematical Sciences' => 'Mathematical Sciences',
							'McBride Honors in Public Affairs' => 'McBride Honors in Public Affairs',
							'Metallurgical & Materials Engineering' => 'Metallurgical & Materials Engineering',
							'Military Science' => 'Military Science',
							'Mining Engineering' => 'Mining Engineering',
							'Music Technology' => 'Music Technology',
							'Operations Research' => 'Operations Research',
							'Organic Chemistry' => 'Organic Chemistry',
							'Petroleum Engineering' => 'Petroleum Engineering',
							'Public Affairs' => 'Public Affairs',
							'Science Technology & Society' => 'Science, Technology, & Society',
							'Science Technology Engineering & Policy' => 'Science, Technology, Engineering & Policy',
							'Statistics' => 'Statistics',
							'Underground Construction & Tunneling' => 'Underground Construction & Tunneling'
						),explode(', ',$user->minor),array(
							'multiple',
							'id' => 'minor',
							'style' => 'width:100%'
						))
					}}	
				</div>
			</div>
			
			<hr>
			
			{{-- Password --}}
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
			
			{{-- Bio --}}
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
			
			{{-- Tags --}}
			<div class="form-group">
				<label for="hashtags[]" class="col-sm-3 control-label">Subscribed Tags</label>
				<div class="col-sm-4">
					<select multiple class="select2-container-tags classSelect" name="hashtags[]" id="tagSelect">
						@foreach($tagHTML as $html)
							{{$html}}
						@endforeach
					</select>
				</div>
			</div>
			
			<hr>
			
			{{-- Classes Teaching --}}
			{{--
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
			--}}
			
			{{-- Classes Taking --}}
			{{--
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
			--}}
			
			{{-- Email Preferences --}}
			<div class="form-group">
				{{Form::label('email_pref', 'Email Preferences',array('class' => 'col-sm-3 control-label'))}}	
				<div class ="col-sm-8">
					<div class="row checkbox-label">
					{{ Form::checkbox('email_conversation', true, (Auth::user()->email_conversation == '1') ? true : false , array('id' => 'conversation_email')) }}
					Receive an email when somebody starts a conversation with you, adds you to a conversation, or replies to a conversation you are in.
					</div>
					<br>
					<div class="row checkbox-label">
					{{ Form::checkbox('email_tag', true, (Auth::user()->email_tag == '1') ? true : false , array('id' => 'post_email')) }}
					Receive an email when a user posts with a tag you are subscribed to.
					</div>
					<br>
					<div class="row checkbox-label">
					{{ Form::checkbox('email_comment', true, (Auth::user()->email_comment == '1') ? true : false , array('id' => 'comment_email')) }}
					Receive an email when somebody comments on a post you made.
					</div>
				</div>
			</div>
			
			<br>
			<button type="submit" class="btn btn-primary" style="float:right">
				<span class="glyphicon glyphicon-ok"></span> Save Changes
			</button>
		</form>
		<form action="{{ URL::to('profile/'.$user->id)}}">
			<button type="submit" class="btn btn-danger">
				<span class="glyphicon glyphicon-remove"></span> Cancel
			</button>
		</form>
		<form action="">
			<button type="submit" class="btn btn-warning" id="resetbutton">
				<span class="glyphicon glyphicon-arrow-left"></span> Undo Any Changes
			</button>
		</form>
	</div>
	<!-- Loading all scripts at the end for performance-->
	{{ HTML::script('//ajax.googleapis.com/ajax/libs/jquery/2.0.3/jquery.min.js') }}
	{{ HTML::script('assets/js/select2.min.js') }}
	<script>
		$(document).ready(function() { 
			{{--
			$(".select2-container-student").select2({
				placeholder: "Select Your Classes"
			});
			$(".select2-container-teacher").select2({
				placeholder: "Select Your Classes"
			}); --}}
			$(".select2-container-tags").select2({
				placeholder: "Select Your Classes"
			});
			
			$("#major").select2({
				placeholder: "Select Your Major(s)"
			});
			$("#minor").select2({
				placeholder: "Select Your Minors(s)"
			});
			$("#grad_date").select2({
				placeholder: "Expected Graduation Date"
			});
			$("#degree_type").select2({
				placeholder: "Degree Type"
			});
			
		});
	</script>
@stop