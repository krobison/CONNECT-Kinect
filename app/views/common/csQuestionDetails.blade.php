<a href="{{URL::to('questiondetails', $question->id)}}">
	<div class="well">
		<h3> {{ $question->content }} </h3>
		<h5> Posted: {{ $question->created_at }} </h5>
	</div>
</a> 