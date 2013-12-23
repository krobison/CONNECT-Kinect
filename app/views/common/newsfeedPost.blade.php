<div class="well">

	{{-- Display the post content --}}
    <a href="{{URL::to('singlepost', $post->id)}}"> <p> {{ $post->content }} </p> </a>
  
	{{-- Display the profile picture (if it exists) and user is not anonmyous--}}
    <div style="float:left; padding-right: 10px">
	@if ($post->postable_type == "PostHelpRequest" && $post->postable->anonymous == 1)
		{{ HTML::image('assets/img/anonymous.png', 'anonymous' , array('width' => '70', 'height' => '70', 'class' => 'img-circle')) }}
	@else
	<a href="{{URL::to('profile', $post->user->id)}}">
		@if (!empty($post->user->picture))
			@if ( File::exists('assets/img/profile_images/' . $post->user->picture ))
				{{ HTML::image('assets/img/profile_images/'.$post->user->picture, '$comment->user->id', array('width' => '70', 'height' => '70', 'class' => 'img-circle')) }}
			@else
				{{ HTML::image('assets/img/dummy.png', $post->user->id , array('width' => '70', 'height' => '70', 'class' => 'img-circle')) }}
			@endif
		@else
			{{ HTML::image('assets/img/dummy.png', $post->user->id , array('width' => '70', 'height' => '70', 'class' => 'img-circle')) }}
		@endif
	</a>
	@endif
	</div>
	
	{{-- Display the upvote button --}}
	{{ Form::open(array('url' => 'upvote', 'method'=>'post')) }}
		{{ Form::hidden('user_id', Auth::user()->id) }}
		{{ Form::hidden('post_id', $post->id) }}
			<?php
				$result = DB::table('upvotes')->where('user_id','=',Auth::User()->id)->where('post_id','=',$post->id)->get();
			?>
			@if (sizeof($result) == 0)
				<button type="submit" class="btn btn-primary">
				<i class="glyphicon glyphicon-hand-up"></i> Upvote: {{ $post->postupvotes->count() }}
			@else
				<button type="submit" class="btn btn-danger">
				<i class="glyphicon glyphicon-hand-down"></i> Undo Upvote: {{ $post->postupvotes->count() }}
			@endif
		</button>
    {{ Form::close() }}

    <br>
	
	{{-- Display the name of the user who made the post (if the user is not anonymous) --}}
	@if ($post->postable_type == "PostHelpRequest" && $post->postable->anonymous == 1)
		<p>Anonymous, {{ $post->created_at->diffForHumans() }}</p>
	@else
		<p><a href="{{URL::to('profile', $post->user->id)}}">{{ $post->user->first }} {{ $post->user->last }}</a>, {{ $post->created_at->diffForHumans() }}</p>
	@endif

</div>
