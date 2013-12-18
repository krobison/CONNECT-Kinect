<div class="well">
	<div style="float:left; padding-right: 10px">
	@if (!empty($comment->user->picture))
		@if ( File::exists('assets/img/profile_images/' . $comment->user->picture ))
			{{ HTML::image('assets/img/profile_images/'.$comment->user->picture, '$comment->user->id', array('width' => '70', 'height' => '70')) }}
		@else
			{{ HTML::image('assets/img/dummy.png', $comment->user->id , array('width' => '70', 'height' => '70')) }}
		@endif
	@else
		{{ HTML::image('assets/img/dummy.png', $comment->user->id , array('width' => '70', 'height' => '70')) }}
	@endif
	</div>

	<p>{{ $comment->content }}</p>
	<p>{{ $comment->user->first }} {{ $comment->user->last }}, {{ $comment->created_at->diffForHumans() }}</p>
</div>