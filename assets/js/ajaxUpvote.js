function bindUpvoteListener() {
	$(".upvote-ajax").unbind().click(function (event){

		var post_id = $( event.target ).closest(".row").find("#post-id").val();
		var button = $( event.target ).closest(":button");
		var previous_upvotes = $( event.target ).attr('data');
		button.html('<img src="assets/img/spinner.gif" alt="loading...">');//{{HTML::image("assets/img/spinner.gif", "none", array("width" => "20", "height" => "20", "class" => "img-circle"))}}'); 
		button.attr('disabled',true);
		
		// Get url
		var pathArray = window.location.href.split( '/' );
		var protocol = pathArray[0];
		var host = pathArray[2];
		var local_url = protocol + "/" + pathArray[3];
		
		$.ajax({
			url: local_url + "/upvotePostAJAX",
			type: 'POST',
			data: {"post_id": post_id},
			dataType: 'json',
			success: function(data){
				var number = data.data;
				var upOrDown = data.upOrDown;
				if(upOrDown == "up"){
					button.empty().append('<i class="image glyphicon glyphicon-hand-down"></i> ' + number); 
					button.attr('class',"btn btn-success btn-sm upvote-ajax");
					button.attr('title',"Undo your upvote of this post");
					//button.attr('style',"float:right;margin-right:16px;");
				} else if (upOrDown == "down") {
					button.empty().append('<i class="image glyphicon glyphicon-hand-up"></i> ' + number);
					button.attr('class',"btn btn-default btn-sm upvote-ajax");
					button.attr('title',"Upvote this post");
					//button.attr('style',"float:right;margin-right:16px;");
				} else {
					button.html('An error occured');
				}
				console.log(button.html());
				console.log(button);
				button.attr('disabled',false);
			}
			
		});
		
	});
}

$(document).ready(function() {
	bindUpvoteListener();
});