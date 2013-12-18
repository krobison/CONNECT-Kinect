<div class="well">

@if ($post->postable_type == "PostHelpRequest")

    <p>This is a PostHelpRequest post!</p>
 
    <p>Language: {{$post->postable->language}}</p>

@elseif ($post->postable_type == "PostHelpOffer")

    <p>This is a PostHelpOffer post!</p>

@elseif ($post->postable_type == "PostQuestion")

	<p>This is a PostQuestion post!</p>
    		
@else

    <p>This is a Unspecified post!</p>
    
@endif

	<a href="{{URL::to('singlepost', $post->id)}}"> <p> {{ $post->content }} </p> </a>
  
    <div style="float:left; padding-right: 10px">
        @if (!empty($post->user->picture))
                @if ( File::exists('assets/img/profile_images/' . $post->user->picture ))
                        {{ HTML::image('assets/img/profile_images/'.$post->user->picture, '$comment->user->id', array('width' => '70', 'height' => '70')) }}
                @else
                        {{ HTML::image('assets/img/dummy.png', $post->user->id , array('width' => '70', 'height' => '70')) }}
                @endif
        @else
                {{ HTML::image('assets/img/dummy.png', $post->user->id , array('width' => '70', 'height' => '70')) }}
        @endif
        </div>
        
        {{ Form::open(array('url' => 'upvote', 'method'=>'post')) }}

    {{ Form::hidden('user_id', Auth::user()->id) }}

    {{ Form::hidden('post_id', $post->id) }}

    <button type="submit" class="btn btn-primary">
        <i class="glyphicon glyphicon-hand-up"></i> Upvote - {{ $post->postupvotes->count() }}
    </button>

    {{ Form::close() }}
    <br>

        <p>{{ $post->user->first }} {{ $post->user->last }}, {{ $post->created_at->diffForHumans() }}</p>
    
    {{-- Need to clean up --}}
    
    

</div>
