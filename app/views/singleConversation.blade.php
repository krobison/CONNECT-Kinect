@extends('common.master')

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
	<div class="list-group" style="width:500px;">
	@foreach ($conversation->users as $someUser)
		<div class="list-group-item" style="min-height:40px;">
			<div style="float:left; padding-right: 10px">
				@if(is_null($someUser->picture))
					{{ HTML::image('assets/img/dummy.png', 'profile picture', array('width' => '25', 'height' => '25', 'class' => 'img-circle')) }}
				@else
					@if ( File::exists('assets/img/profile_images/' . $someUser->picture ))
						{{ HTML::image('assets/img/profile_images/'.$someUser->picture, 'profile picture', array('width' => '25', 'height' => '25', 'class' => 'img-circle')) }}
					@else
						{{ HTML::image('assets/img/dummy.png', $someUser->id , array('width' => '25', 'height' => '25', 'class' => 'img-circle')) }}
					@endif
				@endif 
			</div>
			@if (($someUser->id != Auth::user()->id)&&($conversation->owner == Auth::user()->id))
				<form class="form-horizontal" role="form" action="{{ URL::to('removeUser/'.$someUser->id.'/'.$conversation->id) }}" method="get">
					<button type="submit" class="btn-sm btn-danger btn" style="float:right;margin-top:-5px;" onclick="return confirm('Are you sure you want to remove this user? They will not be able to view these messages or reply any longer.');">
						<span class="glyphicon glyphicon-remove"></span> Remove User
					</button>
				</form>
			@endif
			<a href="{{ URL::to('profile/'.$someUser->id) }}"><span>{{{$someUser->first}}} {{{$someUser->last}}}</span></a>
		</div>
	@endforeach
	</div>

	<br/>
	
	<h4>Conversation</h4>
	<div class="list-group">
	@foreach ($conversation->notes as $note)
		<div class="list-group-item" style="min-height:56px;">
			<div style="float:left; padding-right: 10px">
				@if(is_null(User::find($note->user_id)->picture))
					{{ HTML::image('assets/img/dummy.png', 'profile picture', array('width' => '40', 'height' => '40', 'class' => 'img-circle')) }}
				@else
					@if ( File::exists('assets/img/profile_images/' . User::find($note->user_id)->picture ))
						{{ HTML::image('assets/img/profile_images/'.User::find($note->user_id)->picture, 'profile picture', array('width' => '40', 'height' => '40', 'class' => 'img-circle')) }}
					@else
						{{ HTML::image('assets/img/dummy.png', User::find($note->user_id)->picture , array('width' => '40', 'height' => '40', 'class' => 'img-circle')) }}
					@endif
				@endif 
			</div>
			<span>{{$note->content}}</h5>
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
	
@stop