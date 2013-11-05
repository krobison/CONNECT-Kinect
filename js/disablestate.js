function disableState() {
	var country = document.getElementById('countrySelect').value;
	var stateSelect = document.getElementById('stateSelect');
	
	if (country == "US" || country == "CA") {
		stateSelect.disabled = false;
	} else {
		stateSelect.disabled = true;
		stateSelect.selectedIndex = 0;
	}
}