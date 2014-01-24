<div class="ajax-container" style="margin-bottom:16px;padding:5px;border:1px #CCCCCC solid;border-radius:4px; float:left;width:100%">    
    
	{{-- Display the profile picture (if it exists) and user is not anonmyous--}}
	
		<div style="float:left; padding-right: 10px">
			@if (isset($detail) && $detail == "true")
				@if ($post->postable_type == "PostHelpRequest" && $post->postable->anonymous == 1)
					{{ HTML::image('assets/img/anonymous.png', 'anonymous' , array('width' => '76', 'height' => '76', 'class' => 'img-circle')) }}
				@else
					<a href="{{URL::to('profile', $post->user->id)}}">
						{{HTML::image($post->user->getProfilePictureURL(), '$post->user->id', array('width' => '76', 'height' => '76', 'class' => 'img-circle'))}}
					</a>
				@endif
			@else
				@if ($post->postable_type == "PostHelpRequest" && $post->postable->anonymous == 1)
					{{ HTML::image('assets/img/anonymous.png', 'anonymous' , array('width' => '46', 'height' => '46', 'class' => 'img-circle')) }}
				@else
					<a href="{{URL::to('profile', $post->user->id)}}">
						{{HTML::image($post->user->getProfilePictureURL(), '$post->user->id', array('width' => '46', 'height' => '46', 'class' => 'img-circle'))}}
					</a>
				@endif
			@endif
		</div>
	
	{{-- Display the upvote button --}}
	
		<div style="padding-left:15px">
				{{ Form::hidden('user_id', Auth::user()->id)}}
				{{ Form::hidden('post_id', $post->id, array('id' => 'post-id')) }}
						<?php
								$result = DB::table('upvotes')->where('user_id','=',Auth::User()->id)->where('post_id','=',$post->id)->get();
						?>
						@if (sizeof($result) == 0)
								<button title="Upvote this post" type="submit" data="{{$post->postupvotes->count()}}" class="btn btn-default btn-sm upvote-ajax" style="float:right; margin: 2px">
									<i class="image glyphicon glyphicon-hand-up"></i> {{ $post->postupvotes->count() }}</button>
						@else
								<button title="Undo your upvote of this post" type="submit" data="{{$post->postupvotes->count()}}" class="btn btn-success btn-sm upvote-ajax" style="float:right; margin: 2px">
									<i class="image glyphicon glyphicon-hand-down"></i> {{$post->postupvotes->count()}}</button>
						@endif
		</div>

	{{-- Display the Delete Post button if user is an admin or the post belongs to the user--}}
		
		@if ((Auth::user()->admin == '1')||($post->user_id == Auth::user()->id))
			{{ Form::open(array('url' => 'deletepost', 'method'=>'post')) }}
			{{ Form::hidden('id', $post->id) }}
			<button type="submit" class="btn btn-danger btn-sm" style="float:right; margin: 2px; margin-left: 4px" title="Delete this post" onclick="return confirm('Are you sure you would like to delete this post FOREVER?');">
				<span class="glyphicon glyphicon-trash"></span>
			</button>
			{{ Form::close() }}
		@endif
		
	{{-- Display the post content --}}
	
        @if (isset($detail) && $detail == "true")
            <div style="white-space:pre-wrap"> {{ $post->getPurifiedContent() }} </div>
			<br>
        @else
            <div class="list-group" style="margin-left:60px;margin-right:56px;margin-bottom:0px">
                    <h4 style="margin-bottom:5px"><a href="{{URL::to('singlepost', $post->id)}}" class="list-group-item" style="padding-top:4px;line-height:200%;height:46px;overflow:hidden;"> {{{ strip_tags($post->content) }}} </p></a></h4>
            </div>
        @endif

    {{-- Display the name of the user who made the post (if the user is not anonymous) --}}
		
        @if ($post->postable_type == "PostHelpRequest" && $post->postable->anonymous == 1)
            <p style="margin-bottom:5px">Anonymous, {{ $post->created_at->diffForHumans() }}</p>
        @else
            <p style="margin-bottom:5px"><a href="{{URL::to('profile', $post->user->id)}}">{{{ $post->user->first }}} {{{ $post->user->last }}}</a>, {{ $post->created_at->diffForHumans() }}</p>
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
			<small class="hashtag" style="color:#000000;">#{{{$tag->name}}}</small>
		@endforeach
		
	{{-- Display code, if it exists and details are enabled --}}
		
		@if ($post->code != "" && isset($detail) && $detail == "true")
			<div style="float:left; width:100%; padding:10px">
				Language: {{ $post->language }}
				<div id="editor{{$post->id}}" style="z-index:0">
					{{{ $post->code }}}
				</div>
			</div>
			{{ HTML::script('assets/js/ace/ace.js') }}
			<script>
				// Setting up the ace text editor language
				var editor = ace.edit("editor{{$post->id}}");
				editor.getSession().setUseWorker(false);
				editor.setTheme("ace/theme/eclipse");
				var language = "{{$post->language}}";
				editor.getSession().setMode("ace/mode/" + language);
				editor.setReadOnly(true);
				editor.setOptions({
					maxLines: 50
				});
			</script>
		@endif
</div>

{{ HTML::script('assets/js/ajaxUpvote.js') }}

