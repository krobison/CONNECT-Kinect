function log(conference, user_id, data, type) {
	type = typeof type !== 'undefined' ? type : "default"; // Default type of "default"

	$.post("../../modules/core/api.php", {conf: conference, func: "writeLog", userId: user_id, data: data, type: type}, function(data) {
		//alert(data);
	});
}