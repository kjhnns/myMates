<!--
var zoomedImgs = new Array();
var commentpop = new Array();

function statusTyping() {
	var txtBox = ebi("clogPost");
	ebi("clogPostLengthDiv").innerHTML = 140-txtBox.value.length;
}

function chatBing() {
	ebi("chatBing").play();
}

function switchDynNav() {
	var oBox = ebi("onlineBox");
	var nBox = ebi("dynNavBox");
	var tBox = ebi("dynTitle");
	if(oBox.style.display == "none") {
		tBox.innerHTML = "<a style=\"color: #FFFFFF; font-weight: normal;\" href=\"javascript:switchDynNav()\">"+lng_options+"</a> | "+lng_online+" ("+onlineUser+")";
		nBox.style.display = "none";
		oBox.style.display = "inline";
	} else {
		tBox.innerHTML = lng_options+" | <a style=\"color: #FFFFFF; font-weight: normal;\" href=\"javascript:switchDynNav()\">"+lng_online+" ("+onlineUser+")</a>";
		oBox.style.display = "none";
		nBox.style.display = "inline";
	}
}

function switchclogPost(key) {
	setClogPostKey(key);
	if(key == 'cloglink') {
		ebi('clogPost').value='http://';
		ebi('tabClog').innerHTML =	"<a href=\"javascript:switchclogPost('clogstatus')\">"+lng_status+"</a> | "+
									"<label id=\"tabClogSelected\" for=\"clogPost\"><b>"+lng_link+"</b></label>";
	}
	if(key == 'clogstatus') {
		ebi('clogPost').value=lng_clogText;
		ebi('tabClog').innerHTML = 	"<label id=\"tabClogSelected\" for=\"clogPost\"><b>"+lng_status+"</b></label> | "+
									"<a href=\"javascript:switchclogPost('cloglink')\">"+lng_link+"</a>";
	}
	statusTyping();
}

function zoomImg(imgid,url) {
	var imgID = ebi(imgid);
	var img = new Image();
	img.src = url;
	var mul = img.height/img.width;
	if(zoomedImgs[imgid] == 'y') {
		zoomedImgs[imgid] = 'n';
		imgID.style.width = "150px";
		imgID.style.height = ""+(mul*150)+"px";
	} else {
		zoomedImgs[imgid] = 'y';
		imgID.style.width = "460px";
		imgID.style.height = ""+(mul*460)+"px";
	}
}

function setSize(imgid,url) {
	var imgID = ebi(imgid);
	var img = new Image();
	img.src = url;
	var mul = img.height/img.width;
		zoomedImgs[imgid] = 'n';
		imgID.style.width = "150px";
		imgID.style.height = ""+(mul*150)+"px";
}


// comment function
function commentPost(pid,pitem,report) {
	var inputObj = ebi("commentText"+pid+pitem);
	if(inputObj.value != "") {
		$.post("./ajax.response.php?section=comment", {text: inputObj.value, cat: pid, item: pitem, report: report});
		inputObj.value = "";
	} else {
		return false;
	}
	var box = ebi("comments"+pid+pitem);
	box.innerHTML += commentSuccessLayout;
}

function postcomment(item) {
	var box = ebi("gocomment"+item);
	if(commentpop[item] == 'y') {
		box.style.display = "none";
		commentpop[item] = 'n';
	} else {
		box.style.display = "inline";
		commentpop[item] = 'y';
	}
}
//-->