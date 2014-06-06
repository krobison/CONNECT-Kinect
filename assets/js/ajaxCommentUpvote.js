function bindUpvoteCommentsListener() {
	$(".upvoteComment-ajax").unbind().click(function (event){

		// Get url
		var pathArray = window.location.href.split( '/' );
		var protocol = pathArray[0];
		var host = pathArray[2];
		
		// The issue here is that development takes place at toilers.mines.edu/csconnect
		// Deployment is at connect.mines.edu, so one has a two level base path and one has a one level base path
		var local_url = "";
		if(pathArray[2] === "connect.mines.edu") {
			local_url = protocol + "//" + pathArray[2];
		} else {
			local_url = protocol + "//" + pathArray[2] + "/" + pathArray[3];
		}
		
		var comment_id = $( event.target ).closest(".options-panel").find("#comment-id").val();
		var button = $( event.target ).closest(":button");
		button.html('<img src="' + local_url + '/assets/img/spinner.gif" alt="loading...">');//{{HTML::image("assets/img/spinner.gif", "none", array("width" => "20", "height" => "20", "class" => "img-circle"))}}'); 
		button.attr('disabled',true);

		
		$.ajax({
			url: local_url + "/upvoteCommentAJAX",
			type: 'POST',
			async: true,
			data: {"comment_id": comment_id},
			dataType: 'json',
			success: function(data){
				var number = data.data;
				var upOrDown = data.upOrDown;
				if(upOrDown == "up"){
					button.empty().append('<i class="image glyphicon glyphicon-hand-down"></i> ' + number); 
					button.attr('class',"btn btn-success btn-sm two-marg upvoteComment-ajax");
					button.attr('title',"Undo your upvote of this comment");
				} else if (upOrDown == "down") {
					button.empty().append('<i class="image glyphicon glyphicon-hand-up"></i> ' + number);
					button.attr('class',"btn btn-default btn-sm two-marg upvoteComment-ajax");
					button.attr('title',"Upvote this comment");
				} else {
					button.html('An error occured');
				}
				button.attr('disabled',false);
			},
			timeout: 6000,
			error: function(x, t, m){ 
				button.empty().append('Error');
				button.attr('class',"btn btn-warning btn-sm upvote-ajax");
				button.attr('title',"An error occured. Check your connection and try again.");
				button.attr('disabled',false);
			}
			
		});
		
	});
}

$(document).ready(function() {
	bindUpvoteCommentsListener();
});