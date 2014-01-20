function bindUpvoteListener() {
	$(".upvote-ajax").unbind().click(function (event){
		
		// Get url
		var pathArray = window.location.href.split( '/' );
		var protocol = pathArray[0];
		var host = pathArray[2];
		var local_url = protocol + "//" + pathArray[2] + "/" + pathArray[3];
		
		var post_id = $( event.target ).closest(".row").find("#post-id").val();
		var button = $( event.target ).closest(":button");
		var previous_upvotes = $( event.target ).attr('data');
		button.html('<img src="' + local_url + '/assets/img/spinner.gif" alt="loading...">');//{{HTML::image("assets/img/spinner.gif", "none", array("width" => "20", "height" => "20", "class" => "img-circle"))}}'); 
		button.attr('disabled',true);
		
		$.ajax({
			url: local_url + "/upvotePostAJAX",
			type: 'POST',
			data: {"post_id": post_id},
			dataType: 'json',
			async: true,
			success: function(data){
				var number = data.data;
				var upOrDown = data.upOrDown;
				if(upOrDown == "up"){
					button.empty().append('<i class="image glyphicon glyphicon-hand-down"></i> ' + number); 
					button.attr('class',"btn btn-success btn-sm upvote-ajax");
					button.attr('title',"Undo your upvote of this post");
				} else if (upOrDown == "down") {
					button.empty().append('<i class="image glyphicon glyphicon-hand-up"></i> ' + number);
					button.attr('class',"btn btn-default btn-sm upvote-ajax");
					button.attr('title',"Upvote this post");
				} else {
					button.html('An error occured');
				}
				button.attr('disabled',false);
			},
			timeout: 6000,
			error: function(x, t, m){ 
				button.empty().append('Error');
				button.attr('class',"btn btn-warning btn-sm upvoteComment-ajax");
				button.attr('title',"An error occured. Check your connection and try again.");
				button.attr('disabled',false);
			}
			
		});
		
	});
}

$(document).ready(function() {
	bindUpvoteListener();
});