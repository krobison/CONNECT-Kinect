<div style="margin-bottom:16px;padding:8px;border:1px #CCCCCC solid;border-radius:4px;">    
    {{-- Display the post content --}}
    
    <div style="float:left; padding-right: 10px">
		{{-- Display the profile picture (if it exists) and user is not anonmyous--}}
        @if ($post->postable_type == "PostHelpRequest" && $post->postable->anonymous == 1)
            {{ HTML::image('assets/img/anonymous.png', 'anonymous' , array('width' => '76', 'height' => '76', 'class' => 'img-circle')) }}
        @else
			<a href="{{URL::to('profile', $post->user->id)}}">
				{{HTML::image($post->user->getProfilePictureURL(), '$post->user->id', array('width' => '76', 'height' => '76', 'class' => 'img-circle'))}}
			</a>
        @endif
        </div>
        @if (isset($detail) && $detail == "true")
            <p> {{{ $post->content }}} </p>
        @else
            <div class="list-group" style="margin-left:80px;">
                @if (strlen($post->content) > 55)
                    <h4><a href="{{URL::to('singlepost', $post->id)}}" class="list-group-item" style="padding-top:16px;"> <p> {{{ substr($post->content,0,55)."..." }}} </p> </a></h4>
                @else
                    <h4><a href="{{URL::to('singlepost', $post->id)}}" class="list-group-item" style="padding-top:16px;"> <p> {{{ $post->content }}} </p> </a></h4>
                @endif
            </div>
        @endif

        {{-- Display the name of the user who made the post (if the user is not anonymous) --}}
        @if ($post->postable_type == "PostHelpRequest" && $post->postable->anonymous == 1)
                <p>Anonymous, {{ $post->created_at->diffForHumans() }}</p>
        @else
                <p><a href="{{URL::to('profile', $post->user->id)}}">{{{ $post->user->first }}} {{{ $post->user->last }}}</a>, {{ $post->created_at->diffForHumans() }}</p>
        @endif

        {{-- Display tags --}}

        <style>
            .hashtag{
                padding:4px;
                font-family:"Trebuchet MS", Helvetica, sans-serif;
                font-weight:bold;
                display:inline-block;
                margin-bottom:2px;
                background-color:rgba(0,0,0,0.15); 
                border:1px rgba(0,0,0,0.15) solid;
            }
        </style>

		@foreach($post->hashtags as $tag)
			<span class="hashtag">#{{{$tag->name}}}</span>
		@endforeach
        
        {{-- Display the upvote button --}}
		<div class="row" style="padding-left:15px">
				{{ Form::hidden('user_id', Auth::user()->id)}}
				{{ Form::hidden('post_id', $post->id, array('id' => 'post-id')) }}
						<?php
								$result = DB::table('upvotes')->where('user_id','=',Auth::User()->id)->where('post_id','=',$post->id)->get();
						?>
						@if (sizeof($result) == 0)
								<button type="submit" data="{{$post->postupvotes->count()}}" class="btn btn-primary btn-sm upvote-ajax" style="margin-top:6px;">
									<i class="image glyphicon glyphicon-hand-up"></i> Upvote: {{ $post->postupvotes->count() }}
						@else
								<button type="submit" data="{{$post->postupvotes->count()}}" class="btn btn-danger btn-sm upvote-ajax">
									<i class="image glyphicon glyphicon-hand-down"></i> Undo Upvote: {{$post->postupvotes->count()}}
						@endif
				</button>
		</div>
	
	{{-- Display the Delete Post button if user is an admin --}}
	@if ((Auth::user()->admin == '1')||($post->user_id == Auth::user()->id))
		{{ Form::open(array('url' => 'deletepost', 'method'=>'post')) }}
		{{ Form::hidden('id', $post->id) }}
		<button type="submit" class="btn btn-danger btn-sm" style="float:right;margin-top:-30px;" onclick="return confirm('Are you sure you would like to delete this post FOREVER?');">
				<span class="glyphicon glyphicon-trash"></span> Delete Post
		</button>
		{{ Form::close() }}
	@endif
</div>

{{ HTML::script('assets/js/ajaxUpvote.js') }}

