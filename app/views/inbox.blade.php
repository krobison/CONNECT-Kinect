@extends('common.master')

@section('content')
	<table class = "table table-hover">
		<thead><tr>
			<th>From</th>
			<th>Subject</th>
			<th>Body</th>
		</tr></thead>
		@foreach ($showMessages as $message)
			<tbody>
				<tr href="{{ URL::to('showmessage/'.$message->id) }}">
					<td>{{{ $users[$message->from] }}}</td>
					<td>{{{ $message->subject }}}</td>
					<td>{{{ substr($message->content,0,50) }}}...</td>
				</tr>
			</tbody>
		@endforeach
	</table>
	<script>
		$(document).ready(function(){
		    $('table tr').click(function(){
		        window.location = $(this).attr('href');
		        return false;
		    });
		});
	</script
@stop