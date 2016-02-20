<!--
var clogPostKey = "clogstatus";
var firstRun = true;

function ebi(id) {
	return document.getElementById(id);
}

$(document).ready(function() {
	chatRefresh();
});

// CHAT STUFF
function chatRefresh() {
	$.post("./ajax.response.php?section=chat&act=fetch", { whatup:"?" }, function(text) {
		$("#chatBox").html( text );

	}, "text");
	window.setTimeout("chatRefresh()",chatRefreshTime);
}

function chatPost() {
	var inputObj = ebi("chatText");
	if(inputObj.value != "" && inputObj.value != inputObj.defaultValue) {
		$.post("./ajax.response.php?section=chat&act=write", {text: inputObj.value});
		inputObj.value = "";
	} else {
		return false;
	}
}

// CHANGELOG BACKEND
function changelogRefreshStatus() {
	$.get("./ajax.response.php", { section: "clog", action: "whatsup" }, function(data) {
		if(data == '1' || firstRun) {
			changelogRefresh();
			firstRun = false;
		}
	}, "text");
	window.setTimeout("changelogRefreshStatus()", 5000);
}

function changelogRefresh() {
	$.get("./ajax.response.php", { section: "clog", action: "fetch"}, function(text) {
		$("#changeLogBox").html(text);
	}, "text");
}

function setClogPostKey(key) {
	clogPostKey = key;
}


function clogPost() {
	var txtBox = ebi("clogPost");
	if(txtBox.value != "" && txtBox.value != txtBox.defaultValue && txtBox.value.length < 141) {
		$.post("./ajax.response.php?action=post&section=clog", {text: txtBox.value, key: clogPostKey});
		txtBox.value ="";
	} else {
		return false;
	}
}
//-->