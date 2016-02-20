<style type="text/css">
{literal}
flash {
	width: 500px;
	margin: 10px 5px;
	border-color: #D9E4FF;

	-moz-border-radius-topleft : 5px;
	-webkit-border-top-left-radius : 5px;
    -moz-border-radius-topright : 5px;
    -webkit-border-top-right-radius : 5px;
    -moz-border-radius-bottomleft : 5px;
    -webkit-border-bottom-left-radius : 5px;
    -moz-border-radius-bottomright : 5px;
    -webkit-border-bottom-right-radius : 5px;

}


#btnSubmit { margin: 0 0 0 155px ; }


.progressWrapper {
	width: 357px;
	overflow: hidden;
}

.progressContainer {
	margin: 5px;
	padding: 4px;
	border: solid 1px #E8E8E8;
	background-color: #F7F7F7;
	overflow: hidden;
}
/* Message */
.message {
	margin: 1em 0;
	padding: 10px 20px;
	border: solid 1px #FFDD99;
	background-color: #FFFFCC;
	overflow: hidden;
}
/* Error */
.red {
	border: solid 1px #B50000;
	background-color: #FFEBEB;
}

/* Current */
.green {
	border: solid 1px #DDF0DD;
	background-color: #EBFFEB;
}

/* Complete */
.blue {
	border: solid 1px #CEE2F2;
	background-color: #F0F5FF;
}

.progressName {
	font-size: 8pt;
	font-weight: 700;
	color: #555;
	width: 323px;
	height: 14px;
	text-align: left;
	white-space: nowrap;
	overflow: hidden;
}

.progressBarInProgress,
.progressBarComplete,
.progressBarError {
	font-size: 0;
	width: 0%;
	height: 2px;
	background-color: blue;
	margin-top: 2px;
}

.progressBarComplete {
	width: 100%;
	background-color: green;
	visibility: hidden;
}

.progressBarError {
	width: 100%;
	background-color: red;
	visibility: hidden;
}

.progressBarStatus {
	margin-top: 2px;
	width: 337px;
	font-size: 7pt;
	font-family: Arial;
	text-align: left;
	white-space: nowrap;
}

a.progressCancel {
	font-size: 0;
	display: block;
	height: 14px;
	width: 14px;
	background-image: url(../images/cancelbutton.gif);
	background-repeat: no-repeat;
	background-position: -14px 0px;
	float: right;
}

a.progressCancel:hover {
	background-position: 0px 0px;
}

.swfupload {
	vertical-align: top;
}


#fsUploadProgress {
	border: 1px #CCCCCC solid;
	background: #EEEEEE;
	margin: 15px;
	min-height: 100px;
	width: 400px;
	float: left;
}

#divStatus {
	margin: 5px;
	color: #888888;
}

#selgal {
	border: 1px #888888 solid;
	background-color: #FFFFFF;
	font-size: 10px;
	font-family: Verdana, Arial, "Trebuchet MS";
	margin-bottom: 3px;
	padding: 2px;
	display: none;
	color: #555555;
}
{/literal}
</style>
<script type="text/javascript" src="{$_lib}swfupload.js"></script>
<script type="text/javascript" src="{$_lib}swfupload_plugins.js"></script>
<script type="text/javascript">
var clientLib= "{$_lib}";
var tplPath= "{$_tpl}";
var swfu;
var gid = 0;
var valstr = "{$str}";
{literal}
function changeGid() {
for (i = 0; i < ebi("galsel").length; ++i) {
    if (ebi("galsel").options[i].selected == true) {
      gid = ebi("galsel").options[i].value;
      var gtext = ebi("galsel").options[i].text;
    }
}
ebi("galsel").style.display = "none";
ebi("selgal").innerHTML =gtext;
ebi("selgal").style.display = "inline";
ebi("uploadtext").style.display = "none";
ebi("form").style.display = "inline";
uploader();
}
		//window.onload = function() {
		function uploader() {
			var settings = {
				flash_url : clientLib+"swfupload.swf",
				upload_url: "gallery.php?action=moveuploaded&gid="+gid+"&valstr="+valstr,
				file_size_limit : "20971520",	// 20mb
				file_types : "*.jpg;*.gif;*.png;*.JPG;*.PNG;*.GIF;*.JPEG;*.jpeg",
				file_types_description : "Image Files",
				file_upload_limit : "50",
				custom_settings : {
					progressTarget : "fsUploadProgress",
					cancelButtonId : "btnCancel"
				},
				debug: false,

				// Button settings
				button_image_url: tplPath+"misc/uploadBtn.png",
				button_width: "59",
				button_height: "29",
				button_placeholder_id: "spanButtonPlaceHolder",

				// The event handler functions are defined in handlers.js
				file_queued_handler : fileQueued,
				file_queue_error_handler : fileQueueError,
				file_dialog_complete_handler : fileDialogComplete,
				upload_start_handler : uploadStart,
				upload_progress_handler : uploadProgress,
				upload_error_handler : uploadError,
				upload_success_handler : uploadSuccess,
				upload_complete_handler : uploadComplete,
				queue_complete_handler : queueComplete	// Queue plugin event
			};

			swfu = new SWFUpload(settings);
	     };
{/literal}
</script>
<form id="form1" action="index.php" method="post" enctype="multipart/form-data">
<h1><img src="{$_tpl}misc/uploadgal.png" border=0 alt="" /> {lng k='uploadtitle' d='gal'}</h1>
<div class="fieldset flash" id="fsUploadProgress"></div>

<div style="float: left;margin: 15px; width: 210px;">

	<div id="selgal" style="width: 185px;float: left;">Album</div>

	<select name="gallery" style="width: 191px; margin-bottom: 3px;" id="galsel" onchange="changeGid()">
	<option value="0">{lng k='select' d='gal'}</option>
	{html_options options=$gal}
	</select>

	<div id="uploadtext" style="float:left;width: 191px;">{lng k='selecttext' d='gal'}</div>
	<div id="form" style="display: none;">
		<span id="spanButtonPlaceHolder"></span>
		<input id="btnCancel" type="button" value="{lng k='cancle' d='gal'}" onclick="swfu.cancelQueue();" disabled="disabled" style="margin-left: 2px; font-size: 8pt; height: 29px;" />
		<div id="divStatus">0 {lng k='uploaded' d='gal'}</div>
	</div>

</div>
</form>
