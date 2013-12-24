@extends('common.master')

@section('content')
	<div id="centered" style="text-align: center">
		<h1>Under Construction </h1>
		<div>
			@foreach ($sentMessages as $message)
				<div class="well">
					{{ $message->subject }}
					<br/>
					{{ $message->content }}
				</div>
			@endforeach

		</div>
		<div>

			@foreach ($receivedMessages as $message)
				<div class="well">
					
					{{ $message->subject }}
					<br/>
					{{ $message->content }}
				</div>
			@endforeach
			
		</div>
	<div>
	<?php if(isset($messages)) echo $messages ?>
@stop