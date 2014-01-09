function bindUpvoteListener() {
	$(".upvote-ajax").unbind().click(function (event){

		var post_id = $( event.target ).closest(".row").find("#post-id").val();
		var button = $( event.target );
		var previous_upvotes = $( event.target ).attr('data');
		button.html('loading...');//{{HTML::image("assets/img/spinner.gif", "none", array("width" => "20", "height" => "20", "class" => "img-circle"))}}'); 
		
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
					button.html('<i class="image glyphicon glyphicon-hand-down"></i> Undo Upvote: ' + number); 
					button.attr('class',"btn btn-danger btn-sm upvote-ajax");
				} else if (upOrDown == "down") {
					button.html('<i class="image glyphicon glyphicon-hand-up"></i> Upvote: ' + number);
					button.attr('class',"btn btn-primary btn-sm upvote-ajax");
				} else {
					console.log("prev    : " + previous_upvotes);
					button.html('An error occured');
				}
				
			}
			
		});
		
	});

}

$(document).ready(function() {
	bindUpvoteListener();
});