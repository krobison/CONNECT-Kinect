@extends('common.master')

@section('content')
	<div id="centered">
		<div>
			@if ($users[0] != "")
				@foreach ($messages as $message)
					<div class="well">
						<div>
							<strong>To: </strong>
							{{ $users[$message->to] }}
							<br/>
							<strong>From: </strong>
							{{ $users[$message->from] }}
							<br/>
							<strong>Subject:</strong>
							{{ $message->subject }}
							<br/>
						</div>
						<br/>
						<div class="well">
							{{ $message->content }}
						</div>
					</div>
				@endforeach
			@else
				<h2>You have no messages!</h2>
			@endif
		</div>
	<div>
@stop