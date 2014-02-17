@extends('common.master')

@section('title')
	CONVERSATIONS.
@stop

@section('content')
	<form class="form-horizontal" role="form" action="{{ URL::to('composeConversation')}}" method="get">
		<button type="submit" class="btn btn-default btn-lg" style="float:right;margin-top:8px;">
			<span class="glyphicon glyphicon-envelope"></span> Start A Conversation
		</button>
	</form>
	
	<div class="page-header" style="margin-top:-8px;">
		<h2> Conversations </h2>
	</div>
	
	<div class="list-group">
	@foreach ($conversations as $conversation)
		<div class="list-group-item" style="min-height:96px;">
			<div style="float:left; padding-right: 10px">
				@if(is_null(User::find($conversation->owner)->picture))
					{{ HTML::image('assets/img/dummy.png', 'profile picture', array('width' => '70', 'height' => '70', 'class' => 'img-circle')) }}
				@else
					<a href="{{URL::to('profile', $conversation->owner)}}">
						{{HTML::image(User::find($conversation->owner)->getProfilePictureURL(), '$post->user->id', array('width' => '70', 'height' => '70', 'class' => 'img-circle'))}}
					</a>
				@endif 
			</div>
			<h2 style="margin:0px; margin-bottom:3px"><a href="{{ URL::to('showConversation/'.$conversation->id) }}">{{{$conversation->name}}}</a></h2>
			@foreach ($conversation->users()->get() as $conversation_member)
				<a href="{{URL::to('profile', $conversation_member->id)}}">
					{{HTML::image($conversation_member->getProfilePictureURL(), '$conversation_member->id', array('title' => $conversation_member->first, 'width' => '30', 'height' => '30', 'class' => 'img-circle'))}}
				</a>
			@endforeach
			<a href="{{ URL::to('leaveConversation/'.$conversation->id) }}" style="text-decoration:none;float:right;margin-top:-16px;" onclick="return confirm('Are you sure you want to leave this conversation? You will not be able to view these messages or reply any longer.');"><span style="color:red;">Leave This Conversation</span></a>
		</div>
	@endforeach
	</div>

@stop