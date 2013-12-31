@extends('common.master')

@section('content')
	<h2> People in this conversation: </h2>
	<h3>
	@foreach ($conversation->users as $someUser)
		{{ $someUser->first }} {{ $someUser->last }}
	@endforeach
	</h3>
	<br/>
	
	@foreach ($conversation->notes as $note)
		<div class="well">
			{{ $note->content }}
			<br/>
			{{ User::find($note->user_id)->first }}
		</div>
	@endforeach
	
	{{-- Form to add to conversation--}}
	
	{{ Form::open(array('url' => 'addToConversation', 'method' => 'POST')) }}
		<div class="form-group">
			<textarea type="text" class="form-control" id="subject" style="width:500px;height:300px;" name="content"></textarea>
		</div>

		<br/>
		<button type="submit" class="btn btn-primary">
			<span class="glyphicon glyphicon-ok"></span> Send Message
		</button>
	{{ Form::hidden('conversationID', $conversation->id) }}
	{{ Form::close() }}
	
@stop