checked();

function checked() {
	
	var checkbox = document.getElementById("sourcesBox");
	var label = document.getElementById("sourcesLabel");
	
	label.innerHTML = checkbox.checked ? "&#x25B2; Hide Sources" : "&#x25BC; Display Sources";
}