@extends('common.master')

@section('content')
	<form class="form-horizontal" role="form" action="{{ URL::to('composeConversation')}}" method="get">
		<button type="submit" class="btn btn-default btn-lg" style="float:right;">
			<span class="glyphicon glyphicon-envelope"></span> Compose A Conversation
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
					@if ( File::exists('assets/img/profile_images/' . User::find($conversation->owner)->picture ))
						{{ HTML::image('assets/img/profile_images/'.User::find($conversation->owner)->picture, 'profile picture', array('width' => '70', 'height' => '70', 'class' => 'img-circle')) }}
					@else
						{{ HTML::image('assets/img/dummy.png', $user->id , array('width' => '70', 'height' => '70', 'class' => 'img-circle')) }}
					@endif
				@endif 
			</div>
			<h2><a href="{{ URL::to('showConversation/'.$conversation->id) }}">{{{$conversation->name}}}</a></h2>
			<a href="{{ URL::to('leaveConversation/'.$conversation->id) }}" style="text-decoration:none;float:right;" onclick="return confirm('Are you sure you want to leave this conversation? You will not be able to view these messages or reply any longer.');"><span style="color:red;">Leave This Conversation</span></a>
		</div>
	@endforeach
	</div>

@stop