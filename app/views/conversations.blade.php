@extends('common.master')

@section('content')

	<a href="{{ URL::to('composeConversation') }}">
		Create Message
	</a>
	
	<h2> List of Conversations </h2>
	
	@foreach ($user->conversations as $conversation)
		<a href="{{ URL::to('showConversation/'.$conversation->id) }}">
			<div class="well">
				{{ $conversation->notes->last()->content }}<br/>
				-> {{ User::find($conversation->notes->last()->user_id)->first }}
			</div>
		</a>
	@endforeach

	{{-- At this point we want to pull all the users conversations... --}}

@stop