<div class="row" style="width:500px">
	<a href="{{{URL::to('singlepost')}}}/{{{$notification->origin_id}}}">
		<div class="col-md-1 picture">
			{{HTML::image(User::find($notification->initiator_id)->getProfilePictureURL(), 'none', array('width' => '35', 'height' => '35', 'class' => 'img-circle'))}}
		</div>
		
		<div class="col-md-9 text">
		@if ($notification->type == 'conversation')
			{{{User::find($notification->initiator_id)->first}}} responded in one of your conversations.  
		@else
			{{{User::find($notification->initiator_id)->first}}} tagged a post with a tag you are subscribed to. 
		@endif
		</div>
		
	</a>
	
	<div class="col-md-1 delete">
		<button type="button" class="close">&times;</button>
	</div>
</div>

<script>
	$( ".close" ).click(function() {
		console.log("Not working yet");	
		$(".close").html('{{HTML::image("assets/img/spinner.gif", "none", array("width" => '20', "height" => "20", "class" => "img-circle"))}}');
		
		/*
		$.ajax({
			url: {{{URL::to('deleteNotification')}}},
			data: "ItsAColdAndItsABroken",
			context: document.body
		}).done(function() {
			$( this ).addClass( "done" );
			$(".close").html("A");
		});
		*/
		
	});
	

</script>