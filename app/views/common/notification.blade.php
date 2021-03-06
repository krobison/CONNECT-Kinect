<li class="notification" data="{{{$notification->id}}}" read="{{{$notification->read}}}"> 
	@if($notification->read == 0)
	<div class="row" style="width:103%; background-color:#EBEBFF"> <b>
	@else
	<div class="row" style="width:103%">
	@endif
		<div title="Delete Notification" class="col-md-1 delete">
			<button type="button" class="close">&times;</button>
        </div>
		@if ($notification->type == 'tag')
			<a href="{{{URL::to('singlepost')}}}/{{{$notification->origin_id}}}">
		@elseif ($notification->type == 'conversationCreated' || $notification->type == 'conversationReply' || $notification->type == 'conversationAdd')
			<a href="{{{URL::to('showConversation')}}}/{{{$notification->origin_id}}}">
		@elseif ($notification->type == 'postComment')
			<a href="{{{URL::to('singlepost')}}}/{{{$notification->origin_id}}}">
		@endif
			<div class="col-xs-1 picture">
					{{HTML::image(User::find($notification->initiator_id)->getProfilePictureURL(), 'none', array('width' => '35', 'height' => '35', 'class' => 'img-circle'))}}
			</div>
				
			<div class="col-xs-9 text" style="background-color: inherit; margin-top:0px; margin-left:6px;">
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
			<div class="col-xs-9 time" style="background-color: inherit">
				<small>{{{ $notification->created_at->diffForHumans() }}}</small>
			</div>
		</a>
	@if($notification->read == 0)
		</b>
	@endif
    </div>
</li>