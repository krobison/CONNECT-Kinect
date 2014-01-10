@extends('common.master')

@section('additionalHeaders')
	{{ HTML::style('assets/css/select2.css') }}
@stop

@section('title')
	CONVERSATIONS.
@stop

@section('content')
	<form class="form-horizontal" role="form" action="{{ URL::to('leaveConversation/'.$conversation->id) }}" method="get">
		<button type="submit" class="btn btn-danger btn" style="float:right;margin-top:8px;" onclick="return confirm('Are you sure you want to leave this conversation? You will not be able to view these messages or reply any longer.');">
			<span class="glyphicon glyphicon-remove"></span> Leave Conversation
		</button>
	</form>
	<div class="page-header" style="margin-top:-8px;">
		<h2>{{{$conversation->name}}}</h2>
	</div>

		<h4>Users in Conversation</h4>
	@if ($conversation->owner == Auth::user()->id)
		<div style="width:700px; text-align: center;">
	@else
		<div style="width:700px; text-align: center;">
	@endif
		@foreach ($conversation->users as $someUser)
			@if ($someUser->id != Auth::user()->id)
				<div style="padding-top:5px; min-height:40px; position:relative; display: inline-block;">
					@if ($conversation->owner == Auth::user()->id)
						<form role="form" action="{{ URL::to('removeUser/'.$someUser->id.'/'.$conversation->id) }}" method="get">
							<style type="text/css"> #remove:hover { color:grey; } </style>
							<button id="remove" type="submit" style="background:none; border:none; position:absolute; right:-3px; top:5px;" onclick="return confirm('Are you sure you want to remove this user? They will not be able to view these messages or reply any longer.');">
								<span class="glyphicon glyphicon-remove"></span>
							</button>
						</form>
					@endif
					@if(is_null($someUser->picture))
						{{ HTML::image('assets/img/dummy.png', 'profile picture', array('width' => '80', 'height' => '80', 'class' => 'img-box')) }}
					@else
						@if ( File::exists('assets/img/profile_images/' . $someUser->picture ))
							{{ HTML::image('assets/img/profile_images/'.$someUser->picture, 'profile picture', array('width' => '80', 'height' => '80', 'class' => 'img-box')) }}
						@else
							{{ HTML::image('assets/img/dummy.png', $someUser->id , array('width' => '80', 'height' => '80', 'class' => 'img-box')) }}
						@endif
					@endif 
					<a style="color: #FCFCC5; text-decoration: none; background-color:rgba(0,0,0,0.5); position: absolute; left: 0px; top: 47%; width:100%" href="{{ URL::to('profile/'.$someUser->id) }}"><span>{{{$someUser->first}}} </br> {{{$someUser->last}}}</span></a>
				</div>
			@endif
		@endforeach
	</div>
	@if ($conversation->owner == Auth::user()->id)
		<br/>
		<form style="text-align: center;" class="form-horizontal" role="form" action="{{ URL::to('addUsers/'.$conversation->id) }}" method="get">
			<select multiple class="select2-container" style="width:400px;" name="users[]">
				@foreach(User::all() as $messageUser)
				<?php
					$result = DB::table('conversation_user')->where('user_id','=',$messageUser->id)->where('conversation_id','=',$conversation->id)->get();
				?>
					@if (empty($result))
						<option value="{{{ $messageUser->id }}}">{{{ $messageUser->first }}} {{{ $messageUser->last }}}</option>
					@endif
				@endforeach
			</select>
			<button type="submit" class="btn-sm btn-success btn" style="width:64px;margin-left:30px;">
				<span class="glyphicon glyphicon-plus"></span> Add
			</button>
		</form>
	@endif

	<br/>
	
	<h4>Conversation</h4>
	<div class="list-group">
	@foreach ($conversation->notes as $note)
		<div class="list-group-item" style="min-height:56px;">
			<small style="float:right"> {{{ $note->created_at->diffForHumans() }}} </small>
			<div style="float:left; padding-right: 10px">
				<a href="{{URL::to('profile', User::find($note->user_id)->id)}}">
					{{HTML::image(User::find($note->user_id)->getProfilePictureURL(), '$post->user->id', array('width' => '40', 'height' => '40', 'class' => 'img-circle'))}}
				</a>
			</div>
			<b>{{{User::find($note->user_id)->first}}}{{{User::find($note->user_id)->last}}}</b><br>
			<span>{{$note->content}}</span>
		</div>
	@endforeach
	</div>
	
	{{-- Form to add to conversation--}}
	
	{{ Form::open(array('url' => 'addToConversation', 'method' => 'POST')) }}
		<div class="form-group">
			<textarea type="text" class="form-control" id="subject" style="height:200px;" name="content"></textarea>
		</div>

		<br/>
		<button type="submit" class="btn btn-primary">
			<span class="glyphicon glyphicon-ok"></span> Send Message
		</button>
		<br/>
		<br/>
	{{ Form::hidden('conversationID', $conversation->id) }}
	{{ Form::close() }}

	<!-- Loading all scripts at the end for performance-->
	{{ HTML::script('assets/js/select2.min.js') }}
	<script>
		$(document).ready(function() { 
			$(".select2-container").select2({
				placeholder: "Add Users"
			});
		});
	</script>
	
@stop