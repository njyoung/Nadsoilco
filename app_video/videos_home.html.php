<!DOCTYPE HTML>

<?php
if (isset($authen)){
}else{
	echo 'Access denied';
	exit();
}
?>

<html lang="en">
<title>Videos</title>

<head>
<meta http-equiv="Content-type" content="text/html; chaset=UTF-8"></meta>

<!--Common references-->
<script type="text/javascript" src="online_commons/jquery-1.10.2.min.js"></script>
<script src="online_commons/jquery-ui.js"></script>
<link rel="stylesheet" type="text/css" href="online_commons/common_style.css"></link>
<script type="text/javascript" src="online_commons/common_action.js"></script>

<!--Video reference-->
<script type="text/javascript" src="app_video/video_action.js"></script>
</head>

<body>
<div id="headerhome">
	<label id="videolabel">Instruction Videos</label> 
</div>

<div id="mainwrap">

	<div id="homemain">
		<div id="homelabels">
			<div class="c01"><label id="choicelabel">(1) Action</label></div>
			<div class="c01" id="videoselectlabel"></div>
		</div>

		<div id="homeinput"> 
			<div class="c0s">
				<select name="choiceselect" id="choiceselect" class="c0sdrop">
					<option val=""></option>
					<option val="addvideo">Add Video</option>
					<option val="viewvideo">View Video</option>
				</select>
			</div>
			<div class="c0s" id="videoselectmain">
				
			</div>
		</div>
	
		<div id="videologbutton"></div>
	</div> 
	
	<div id="videodiv"></div>
	
	<div id="videotable">
	</div>
	
</div>

</body>

</html>
