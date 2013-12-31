@extends('common.master')

@section('content')

	<a href="{{ URL::to('composeConversation') }}">
		Create Message
	</a>
	
	<h2> List of Conversations </h2>
	
	@foreach ($conversations as $conversation)
		<a href="{{ URL::to('showConversation/'.$conversation->id) }}">
			<div class="well">
				{{ $conversation->notes->last()->content }}<br/>
				-> {{ $conversation->notes->last()->user->first }}
			</div>
		</a>
	@endforeach

	{{-- At this point we want to pull all the users conversations... --}}

@stop