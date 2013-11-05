//$(document).ready(writeEvents(6, 3, 2013));
var $prevStart = "";
var $prevEnd = "";
var $requestUserId = "";
var $currentUserId = "";
var $conference = "";
			
function writeEvents(day, month, year, requestUserId, currentUserId, conference){
	$.post("../../modules/core/api.php", {conf: conference, func: "getMyEventsByDate", userId: requestUserId, date: day, month: month, year: year, web: true }, function(data) {
		decoded = JSON.parse(data);
		$requestUserId = requestUserId;
		$currentUserId = currentUserId;
		$conference = conference;
		$prevStart = "";
		$prevEnd = "";
		//alert(JSON.stringify(decoded[0], null, 4));

		var myEventsHTML = "";

		if (decoded.length == 0) {
			if ($requestUserId == $currentUserId) {
				myEventsHTML += "<em>You have not selected any events to attend for this day. You can do this on the <a href=\"../../modules/schedule/\">Schedule</a> page.</em>";
			} else {
				myEventsHTML +="<em>This user has not selected any events to attend for this day.</em>";
			}	
		} else {
			for (var i=0; i < decoded.length; i++){
				subEventTitle = escape(decoded[i]['subEventTitle']);
				subEventType = escape(decoded[i]['eventType']);
				subEventDescription =escape( decoded[i]['subEventDescription']);
				subEventPresenters = escape( decoded[i]['presenters'])
				myEventsHTML += writeTimeStamp(decoded[i]);

				myEventsHTML += "<div class=\"sub_event\">";

				myEventsHTML += "<div class=\"attending_checkbox_container\">";
				myEventsHTML += "<form method=\"get\">";
				if ($requestUserId == $currentUserId) {
					myEventsHTML += "I Will Attend<input type=\"checkbox\" value=\"remove\" name=\"attend\" class=\"attending_checkbox\" onclick=\"setAttendance(this ,"+decoded[i]['subEventId']+")\" checked />";
				}
				myEventsHTML += "</form>";
				myEventsHTML += "</div>";

				myEventsHTML += "<div class=\"title\">";
				myEventsHTML += "<a href=\"javascript:;\" id=\"event" + decoded[i]['subEventId'] + "\" onclick=\"writeDescription('"+decoded[i]['subEventId']+"' , '"+subEventTitle+"' , '"+subEventType+"' ,'"+subEventDescription+"' , '"+subEventPresenters+"')\">" + unescape(subEventTitle) + "</a>";
				myEventsHTML += "</div>";

				myEventsHTML += "<div class=\"location\">";
				myEventsHTML += "Location: " + decoded[i]['subEventLocation'];
				myEventsHTML += "</div>";

				myEventsHTML += "</div>";
			}
		}

		document.getElementById("myEvents").innerHTML = myEventsHTML;

		var date = moment(new Date(year, month-1, day));
		writeDateLinks(date.format("YYYY-MM-DD"));

	});
}

function writeDateLinks(date){
	$.post("../../modules/core/api.php", {conf: $conference, func: "getConferenceDateRange"}, function(range){
		decoded = JSON.parse(range);
		//alert(JSON.stringify($decoded[0], null, 4));
		firstDate = decoded[0]['start_date'];
		lastDate = decoded[0]['end_date'];
		var displayDate = moment(date, "YYYY-MM-DD").format("MMM Do YYYY");
		var dateLinksHTML ="";
		dateLinksHTML += "<div class=\"date_picker_prev\">";
		if(firstDate < date){
			dateLinksHTML += "<a href=\"javascript:;\" id=\"dayDec\" onclick=\"decDay(\'" + date + "\')\"><< Prev</a>";
		}else{
			dateLinksHTML += "<a href=\"#\" id=\"dayDecNonVis\"><< Prev</a>";
		}
		dateLinksHTML += "</div>";

		dateLinksHTML += "<div class=\"date_picker_date\">";
		dateLinksHTML += "<h3 id=\"dayCur\">" + displayDate + "<h2>";
		dateLinksHTML += "</div>";

		dateLinksHTML += "<div class=\"date_picker_next\">";
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
	var newDateLong = newDate.format("YYYY-MM-DD");

	writeEvents(day, month, year, $requestUserId, $currentUserId, $conference);
	writeDateLinks(newDateLong);
	writeDescription(-1, -1, -1, -1);
}

function incDay(inputDate){
	var newDate = moment(inputDate, "YYYY-MM-DD").add('days', 1);
	var day = newDate.format('DD');
	var month = newDate.format('MM');
	var year = newDate.format('YYYY');
	var newDateLong = newDate.format("YYYY-MM-DD");

	writeEvents(day, month, year, $requestUserId, $currentUserId, $conference);
	writeDateLinks(newDateLong);
	writeDescription(-1, -1, -1, -1);
}

function writeDescription(id, name, type, des, presenters){
	var infoHTML = "";
	if(id >= 0){
		infoHTML += "<div class=\"sub_event_header\">";

		infoHTML += "<div class=\"sub_event_title\">";
		infoHTML += unescape(name);
		infoHTML += "</div>";

		infoHTML += "<div class=\"sub_event_type\">";
		infoHTML += unescape(type);
		infoHTML += "</div>";

		infoHTML += "</div>";

		if(unescape(des)!="null"){
			infoHTML += "<div class=\"sub_event_description\">";
			infoHTML += unescape(des);
			infoHTML += "</div>";
		}

		if(unescape(presenters)!= ""){
			infoHTML += "<div class=\"sub_event_presenters\">";
			infoHTML += unescape(presenters);
			infoHTML += "</div>";
		}

		// Writes the attendees link
		infoHTML += "<div class=\"subevent_attendees\">";
		infoHTML += "<a href=\"../../modules/attendees/?sub_event_id="+id+"\">View Attendees</a>";
		infoHTML += "</div>";
    }
	document.getElementById("eventDescription").innerHTML = infoHTML;
}

function writeTimeStamp(decoded){
	var startTime = moment(decoded['eventStartTime'], "YYYY-MM-DD h:mm").format("h:mma");
	var endTime = moment(decoded['eventEndTime'], "YYYY-MM-DD h:mm").format("h:mma");
	var timeStampHTML = "";
	if(startTime != $prevStart || endTime != $prevEnd){
		timeStampHTML += "<div class=\"timestamp\">";
		timeStampHTML += startTime+" - "+endTime;
		timeStampHTML += "</div>";
		$prevStart = startTime;
		$prevEnd = endTime;
	} else {
		timeStampHTML += "<hr />";
	}
	return timeStampHTML;
}

function setAttendance(checkbox, id){
	//toggles the checkbox
	if ($requestUserId == $currentUserId) {
		if (checkbox.checked) {
			$.post("../../modules/core/api.php", {conf: $conference, func: "setIsAttending", userId: $requestUserId, subEventId: id, web: true });
		} else {
			$.post("../../modules/core/api.php", {conf: $conference, func: "setNotAttending", userId: $requestUserId, subEventId: id, web: true });
		}	
	}

}