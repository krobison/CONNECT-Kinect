//$(document).ready(writeEvents(6, 3, 2013));	
var $prevStart = "";
var $prevEnd = "";
var $myEventIds = new Array();
var $userId = "";
var $conference = "";

var $how_to_string = "Click the title of an event on the left to find more information about it.";
			
function writeEvents(day, month, year, userId, conference){
	$.post("../../modules/core/api.php", {conf: conference, func: "getAllEvents", date: day, month: month, year: year, web: true, userId: userId}, function(data) {
		decoded = JSON.parse(data);
		$userId = userId;
		$conference = conference;
		var allEventsHTML = "";
		for (var i=0; i < decoded.length; i++){
			escapedTitle = escape(decoded[i]['title']);
			escapedType = escape(decoded[i]['type']);
			allEventsHTML += writeTimeStamp(decoded[i]);
			allEventsHTML += "<div class=\"event\">";
				allEventsHTML += "<div class=\"event_type\">";
					allEventsHTML += decoded[i]['type'];
				allEventsHTML += "</div>";
				allEventsHTML += "<div class=\"event_location\">";
				if(decoded[i]['location']==null){
					allEventsHTML += "TBD"
				}else{
					allEventsHTML += decoded[i]['location'];
				}
				allEventsHTML += "</div>";
				allEventsHTML += "<div class=\"event_name\">";
					allEventsHTML += "<a href=\"javascript:;\" id=\"event" + decoded[i]['id'] + "\" onclick=\"writeSubs(" + decoded[i]['id']+", '"+escapedType+"' , '"+escapedTitle+"' )\">" + decoded[i]['title'] + "</a>"; 
				allEventsHTML += "</div>";
			allEventsHTML += "</div>";
			allEventsHTML += "</div>";
		}

		document.getElementById("allEvents").innerHTML = allEventsHTML;
		document.getElementById("how_to_info").innerHTML = $how_to_string;

		var date = moment(new Date(year, month-1, day));
		writeDateLinks(date.format('YYYY-MM-DD'));
		getMyEvents();
		
	});
}

function getMyEvents(){
	$.post("../../modules/core/api.php", {conf: $conference, func: "getMyEvents", userId: $userId, web: true }, function(data) {
		decoded = JSON.parse(data);
		$myEventIds = new Array();
		for (var i=0; i < decoded.length; i++){
			$myEventIds[i]=decoded[i]['subEventId'];
		}

	});
}

function writeDateLinks(date){
	$.post("../../modules/core/api.php", {conf: $conference, func: "getConferenceDateRange"}, function(range){
		decoded = JSON.parse(range);
		//alert(JSON.stringify($decoded[0], null, 4));
		firstDate = decoded[0]['start_date'];
		//alert($firstDate < "2013-03-08" );
		lastDate = decoded[0]['end_date'];
		//alert($lastDate);
		var displayDate = moment(date, "YYYY-MM-DD").format("MMM Do YYYY");
		var dateLinksHTML ="";
		dateLinksHTML += "<div id=\"date_picker_prev\">";
		if(firstDate < date){
			dateLinksHTML += "<a href=\"javascript:;\" id=\"dayDec\" onclick=\"decDay(\'" + date + "\')\"><< Prev</a>";
		}else{
			dateLinksHTML += "<a href=\"#\" id=\"dayDecNonVis\"><< Prev</a>";
		}
		dateLinksHTML += "</div>";

		dateLinksHTML += "<div id=\"date_picker_date\">";
		dateLinksHTML += "<h3 id=\"dayCur\">" + displayDate + "<h2>";
		dateLinksHTML += "</div>";

		dateLinksHTML += "<div id=\"date_picker_next\">";
		if(lastDate>date){
			dateLinksHTML += "<a href=\"javascript:;\" id=\"dayInc\" onclick=\"incDay(\'" + date + "\')\">Next \>\></a>";
		}else{
			dateLinksHTML += "<a href=\"#\" id=\"dayIncNonVis\" onclick=\"incDay(\'" + date + "\')\">Next \>\></a>";
		}
		dateLinksHTML += "</div>";

		document.getElementById("changeDate").innerHTML = dateLinksHTML;
	});
}

function decDay(inputDate){
	var newDate = moment(inputDate, "YYYY-MM-DD").subtract('days', 1);
	var day = newDate.format('DD');
	var month = newDate.format('MM');
	var year = newDate.format('YYYY');
	var newDateLong = newDate.format('YYYY-MM-DD');

	writeEvents(day, month, year, $userId, $conference);
	writeDateLinks(newDateLong);

	//clears out sub events
	writeSubs(0);
}

function incDay(inputDate){
	var newDate = moment(inputDate, "YYYY-MM-DD").add('days', 1);
	var day = newDate.format('DD');
	var month = newDate.format('MM');
	var year = newDate.format('YYYY');
	var newDateLong = newDate.format('YYYY-MM-DD');

	writeEvents(day, month, year, $userId, $conference);
	writeDateLinks(newDateLong);
	
	//clears out sub Events
	writeSubs(0);
}

function writeSubs(myVar, type, title){
	$.post("../../modules/core/api.php", {conf: $conference, func: "getAllSubEventsWithPresenters", eventId: myVar , web: true, userId: $userId }, function(subs){
		subDecode = JSON.parse(subs);
		//alert(JSON.stringify(subDecode[0], null, 4));
		//Writes the header of the sub file
		if(unescape(type) == "Paper Session") {
			document.getElementById("how_to_info").innerHTML = unescape(title);
		} else if(myVar == 0){
			document.getElementById("how_to_info").innerHTML = $how_to_string;
		} else {
			document.getElementById("how_to_info").innerHTML = unescape(type);
		}


		//writes the sub events
		var subText = "";
		for(var i = 0; i < subDecode.length; i++) {
			subText += "<div class=\"subevent_header\">";

			subText += "<div class=\"attending_checkbox_container\">";
			if (jQuery.inArray(subDecode[i]['id'], $myEventIds) == -1) {
			 	subText += "I Will Attend<input type=\"checkbox\" name=\"attend\" class=\"attending_checkbox\" onclick=\"setAttendance(this ,"+subDecode[i]['id']+")\" />"; 
			} else {
			 	subText += "I Will Attend<input type=\"checkbox\" name=\"attend\" class=\"attending_checkbox\" onclick=\"setAttendance(this ,"+subDecode[i]['id']+")\" checked />"; 
			}
			subText += "</div>";

			subText += "<div class=\"subevent_title\">";
			subText += subDecode[i]['title'];
			subText += "</div>";

			subText += "<div class=\"subevent_location\">";
			if(subDecode[i]['location']==null){
				subText += "TBD";
			}else{
				subText += subDecode[i]['location'];
			}
			subText += "</div>";

			subText += "</div>";

			// Writes the description
			subText += "<div class=\"subevent_description\">";
			if (subDecode[i]['description'] != null){
				subText += subDecode[i]['description'];
			}
			subText += "</div>";
			if (subDecode[i]['presenters']!= ""){
				subText += "<div class=\"subevent_presenters\">";
				subText += subDecode[i]['presenters'];
				subText += "</div>";
			}

			// Writes the attendees link
			subText += "<div class=\"subevent_attendees\">";
			subText += "<a href=\"../../modules/attendees/?sub_event_id=" + subDecode[i]['id'] + "\">View Attendees</a>";
			subText += "</div>";
		}

		document.getElementById("subEvents").innerHTML = subText;
	});
	
}

function writeTimeStamp(decoded){
	var startTime = moment(decoded['start_time'], "YYYY-MM-DD h:mm").format("h:mma");
	var endTime = moment(decoded['end_time'], "YYYY-MM-DD h:mm").format("h:mma");
	var timeStampHTML = "";
	if(startTime != $prevStart || endTime != $prevEnd){
		timeStampHTML += "<div class=\"timestamp\">";
		timeStampHTML += startTime+" - "+endTime;
		timeStampHTML += "</div>";
		$prevStart = startTime;
		$prevEnd = endTime;
	}	else {
		timeStampHTML += "<hr />";
	}
	return timeStampHTML;
	
}

function setAttendance(checkbox, id){
	//toggles the checkbox
	if (checkbox.checked) {
		$.post("../../modules/core/api.php", {conf: $conference, func: "setIsAttending", userId: $userId, subEventId: id, web: true }).done(function() {
			getMyEvents();
		});
	} else {
		$.post("../../modules/core/api.php", {conf: $conference, func: "setNotAttending", userId: $userId, subEventId: id, web: true }).done(function() {
			getMyEvents();
		});
	}	

}
