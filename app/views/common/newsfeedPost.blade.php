<div class="well">

@if ($post->postable_type == "PostHelpRequest")

    <p>This is a PostHelpRequest post!</p>
 
    <p>Language: {{$post->postable->language}}</p>

@elseif ($post->postable_type == "PostHelpOffer")

    <p>This is a PostHelpOffer post!</p>
    		
@else

    <p>This is a Unspecified post!</p>
    
@endif

    <a href="{{URL::to('singlepost', $post->id)}}"> <p> {{ $post->content }} </p> </a>
    <p> {{ $post->user->first }} {{ $post->user->last }}, {{ $post->created_at->diffForHumans() }} </p>
    	
    <p> Upvote count: {{ $post->postupvotes->count() }} </p>

    {{ Form::open(array('url' => 'upvote', 'method'=>'post')) }}

    {{ Form::hidden('user_id', Auth::user()->id) }}

    {{ Form::hidden('post_id', $post->id) }}

    <button type="submit" class="btn btn-primary">
        <i class="glyphicon glyphicon-hand-up"></i> Upvote
    </button>

    {{ Form::close() }}

</div>
