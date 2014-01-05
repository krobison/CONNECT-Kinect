<li class="notification"> 
	<div class="row" style="width:500px">
		@if ($notification->type == 'tag')
			<a href="{{{URL::to('singlepost')}}}/{{{$notification->origin_id}}}">
		@elseif ($notification->type == 'conversationCreated')
			<a href="{{{URL::to('showConversation')}}}/{{{$notification->origin_id}}}">
		@endif
			<div class="col-md-1 picture">
				{{HTML::image(User::find($notification->initiator_id)->getProfilePictureURL(), 'none', array('width' => '35', 'height' => '35', 'class' => 'img-circle'))}}
			</div>
			
			<div class="col-md-9 text" style="margin-top:0px;margin-left:6px;">
			@if ($notification->type == 'conversationCreated')
				{{{User::find($notification->initiator_id)->first}}} created a conversation with you.
			@elseif ($notification->type == 'tag')
				&nbsp;{{{User::find($notification->initiator_id)->first}}} tagged a post with a tag you are subscribed to.
			@endif
			</div>
		</a>
		
		<div class="col-md-1 delete">
			<button type="button" class="close">&times;</button>
		</div>
	</div>
</li> 