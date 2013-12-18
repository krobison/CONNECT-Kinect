<div class="well">

@if ($post->postable_type == "PostHelpRequest")

    {{-- This is a PostHelpRequest post! --}}

@elseif ($post->postable_type == "PostHelpOffer")

    {{-- This is a PostHelpOffer post! --}}
    		
@else

    {{-- This is a Unspecified post! --}}
    
@endif

    <a href="{{URL::to('singlepost', $post->id)}}"> <p> {{ $post->content }} </p> </a>
  
    <div style="float:left; padding-right: 10px">
	@if (!empty($post->user->picture))
		@if ( File::exists('assets/img/profile_images/' . $post->user->picture ))
			{{ HTML::image('assets/img/profile_images/'.$post->user->picture, '$comment->user->id', array('width' => '70', 'height' => '70', 'class' => 'img-circle')) }}
		@else
			{{ HTML::image('assets/img/dummy.png', $post->user->id , array('width' => '70', 'height' => '70', 'class' => 'img-circle')) }}
		@endif
	@else
		{{ HTML::image('assets/img/dummy.png', $post->user->id , array('width' => '70', 'height' => '70', 'class' => 'img-circle')) }}
	@endif
	</div>
	
	{{ Form::open(array('url' => 'upvote', 'method'=>'post')) }}

    {{ Form::hidden('user_id', Auth::user()->id) }}

    {{ Form::hidden('post_id', $post->id) }}

    <button type="submit" class="btn btn-primary">
        <i class="glyphicon glyphicon-hand-up"></i> Upvote: {{ $post->postupvotes->count() }}
    </button>

    {{ Form::close() }}

    <br>

	<p>{{ $post->user->first }} {{ $post->user->last }}, {{ $post->created_at->diffForHumans() }}</p>

</div>
