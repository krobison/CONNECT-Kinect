<li class="notification" data="{{{$notification->id}}}"> 
	<div class="row" style="width:500px">
		<div class="col-md-1 delete">
			<button type="button" class="close">&times;</button>
        </div>
		@if ($notification->type == 'tag')
			<a href="{{{URL::to('singlepost')}}}/{{{$notification->origin_id}}}">
		@elseif ($notification->type == 'conversationCreated')
			<a href="{{{URL::to('showConversation')}}}/{{{$notification->origin_id}}}">
		@elseif ($notification->type == 'conversationReply')
			<a href="{{{URL::to('showConversation')}}}/{{{$notification->origin_id}}}">
		@elseif ($notification->type == 'conversationAdd')
			<a href="{{{URL::to('showConversation')}}}/{{{$notification->origin_id}}}">
		@elseif ($notification->type == 'postComment')
			<a href="{{{URL::to('singlepost')}}}/{{{$notification->origin_id}}}">
		@endif
			<div class="col-md-1 picture">
				{{HTML::image(User::find($notification->initiator_id)->getProfilePictureURL(), 'none', array('width' => '35', 'height' => '35', 'class' => 'img-circle'))}}
			</div>
			
			<div class="col-md-9 text" style="margin-top:0px;margin-left:6px;">
				<small>
					@if ($notification->type == 'conversationCreated')
						&nbsp;{{{User::find($notification->initiator_id)->first}}} created a conversation with you.
					@elseif ($notification->type == 'conversationReply')
						&nbsp;{{{User::find($notification->initiator_id)->first}}} replied to a conversation that you are in.
					@elseif ($notification->type == 'conversationAdd')
						&nbsp;{{{User::find($notification->initiator_id)->first}}} added you to a conversation.
					@elseif ($notification->type == 'tag')
						&nbsp;{{{User::find($notification->initiator_id)->first}}} made a post with a tag you are subscribed to.
					@elseif ($notification->type == 'postComment')
						&nbsp;{{{User::find($notification->initiator_id)->first}}} commented on your post.
					@endif
				</small>
			</div>
			<br>
			<div class="col-md-9 time">
				<small> {{{ $notification->created_at->diffForHumans() }}} </small>
			</div>
		</a>
    </div>
</li>