function updateConnection(user_id, other_user_id, conference) {
	var connectionSelect = document.getElementById("updateConnection" + other_user_id);
	var connection = connectionSelect.options[connectionSelect.selectedIndex].value;

	$.post("../../modules/core/api.php", {conf: conference, func: "setConnection", userId: user_id, connectionCode: connection, otherUserId: other_user_id}, function(data) {
		//alert(data);
	}).done(function() {
		generateMatches(user_id, 5, conference);
	});
}

function generateMatches(user_id, num_matches, conference) {
	$.post("../../modules/core/api.php", {conf: conference, func: "generateMatches", userId: user_id, numMatches: num_matches}, function(data) {
		//alert(data);
	}).done(function() {
		updateSuggestions(user_id, 5, conference);
		updateHaveMet(user_id, conference);
	});
}

function updateSuggestions(user_id, limit, conference) {
	$.post("../../modules/core/api.php", {conf: conference, func: "getMatches", userId: user_id, limit: limit}, function(data) {
		//alert(data);
		var matches = JSON.parse(data);

		var matchesHTML = "";
		if (matches.length == 0) {
			matchesHTML += "<p><em>You have no suggestions, please update your profile</em></p>"
		} else {
			for(var i = 0; i < matches.length; i++) {
				var person_id = matches[i]['id'];
				//var person_name = matches[i]['first_name'] + " " + matches[i]['last_name'];

				var person_name = stripslashes(matches[i]['first_name']) + " " + stripslashes(matches[i]['last_name']);

				matchesHTML += "<p>";
				matchesHTML += "<a href=\"../../modules/connection/?profile_code=" + person_id + "\">" + person_name + "</a>";
				matchesHTML += "</p>";
			}
		}

		var suggestions = document.getElementById("suggestions");
		if (suggestions != null) {
			suggestions.innerHTML = matchesHTML;
		}
	});
}

function updateHaveMet(user_id, conference) {
	$.post("../../modules/core/api.php", {conf: conference, func: "getPeopleIHaveMet", userId: user_id}, function(data) {
		//alert(data);
		var people_i_have_met = JSON.parse(data);

		var peopleHTML = "";
		if (people_i_have_met.length == 0) {
			peopleHTML += "<p><em>Update people you've met on the people page</em></p>"
		} else {
			for(var i = 0; i < people_i_have_met.length; i++) {
				var person_id = people_i_have_met[i]['id'];
				var person_name = stripslashes(people_i_have_met[i]['first_name']) + " " + stripslashes(people_i_have_met[i]['last_name']);

				peopleHTML += "<p>";
				peopleHTML += "<a href=\"../../modules/connection/?profile_code=" + person_id + "\">" + person_name + "</a>";
				peopleHTML += "</p>";
			}
		}

		var peopleIHaveMet = document.getElementById("people_i_have_met");
		if (peopleIHaveMet != null) {
			peopleIHaveMet.innerHTML = peopleHTML;
		}
	});

function stripslashes (str) 
  {
    // +   original by: Kevin van Zonneveld (http://kevin.vanzonneveld.net)
    // +   improved by: Ates Goral (http://magnetiq.com)
    // +      fixed by: Mick@el
    // +   improved by: marrtins
    // +   bugfixed by: Onno Marsman
    // +   improved by: rezna
    // +   input by: Rick Waldron
    // +   reimplemented by: Brett Zamir (http://brett-zamir.me)
    // +   input by: Brant Messenger (http://www.brantmessenger.com/)
    // +   bugfixed by: Brett Zamir (http://brett-zamir.me)
    // *     example 1: stripslashes('Kevin\'s code');
    // *     returns 1: "Kevin's code"
    // *     example 2: stripslashes('Kevin\\\'s code');
    // *     returns 2: "Kevin\'s code"
    return (str + '').replace(/\\(.?)/g, function (s, n1) {
      switch (n1) {
        case '\\':
          return '\\';
        case '0':
          return '\u0000';
        case '':
          return '';
        default:
          return n1;
      }
    });
  }	
}