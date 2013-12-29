<div class="well">
	<div style="float:left; padding-right: 10px">
	@if (!empty($comment->user->picture))
		@if ( File::exists('assets/img/profile_images/' . $comment->user->picture ))
			{{ HTML::image('assets/img/profile_images/'.$comment->user->picture, '$comment->user->id', array('width' => '70', 'height' => '70', 'class' => 'img-circle')) }}
		@else
			{{ HTML::image('assets/img/dummy.png', $comment->user->id , array('width' => '70', 'height' => '70', 'class' => 'img-circle')) }}
		@endif
	@else
		{{ HTML::image('assets/img/dummy.png', $comment->user->id , array('width' => '70', 'height' => '70', 'class' => 'img-circle')) }}
	@endif
	</div>
	
	<p>{{{ $comment->content }}}</p>
	<p>{{{ $comment->user->first }}} {{{ $comment->user->last }}}, {{{ $comment->created_at->diffForHumans() }}}</p>
	
	@if(Auth::user()->admin == '1')
		{{ Form::open(array('url' => 'deletecomment', 'method'=>'post')) }}
		{{ Form::hidden('id', $comment->id) }}
		<button type="submit" class="btn btn-danger" style="float:right;" onclick="return confirm('Are you sure you would like to delete this comment FOREVER?');">
				<span class="glyphicon glyphicon-trash"></span> Delete Comment
		</button>
		{{ Form::close() }}
	@endif
	<br>
	
</div>