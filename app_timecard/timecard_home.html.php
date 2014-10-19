<!DOCTYPE HTML>

<?php
if (isset($authen)){
}else{
	echo 'Access denied';
	exit();
} 
?>

<html lang="en">
<title>Time Card</title>

<head>
<meta http-equiv="Content-type" content="text/html; chaset=UTF-8"></meta>

<!--Common references-->
<script type="text/javascript" src="online_commons/jquery-1.10.2.min.js"></script>
<script src="online_commons/jquery-ui.js"></script>
<link rel="stylesheet" type="text/css" href="online_commons/common_style.css"></link>
<script type="text/javascript" src="online_commons/common_action.js"></script>

<!--Timecard reference-->
<script type="text/javascript" src="app_timecard/timecard_action.js"></script>
</head>

<div id="topborder"></div>
<div id="page-wrap">
<body>
	<div id="headerhome">
	<label id="headerlabelhome">Timecard Application</label>
		<div id="miscbuttons">
			<form method="post" action="index.html.php">
				<button id="listbutton" name="redirect" value="dictionary"></button>
			</form>
		</div>
		<div id="exportbuttons">
			<form method="post" action="online_commons/phpexporter.html.php">
				<input type="text" id="pdfpasser" name="pdftblpasser"></input>
				<button id="adobebutton" name="pdf"></button>
				<button id="excelbutton" name="excel"></button>
			</form>
		</div>
	</div>
	<div id="mainwrap">
			<div id="homemain">
				<div id="homelabels">
					<div class="c01"><label id="choicelabel">(1) Action:</label></div>
					<div class="c01"><label id="datelabel">(2) Date:</label></div>
					<div class="c01"><label id="namelabel">(3) Name:</label></div>
					<div class="c01"><label id="tasklabel">(4) Tasks:</label></div>
				</div>	
				<div id="homeinput">
					<div class="c0s">
						<select name="choiceselect" id="choiceselect" class="c0sdrop">
							<option val=""></option>
							<option val="Enter Work Hours">Enter Work Hours</option>
							<option val="View Entries">View Entries</option>
							<option val="Update Lists">View Report</option>
						</select>
					</div>
					<div class="c0s"><input id="startdateinput" class="c0sDT"></input></div>
					<div class="c0s"><select name="nameselect" id="nameselect" class="c0sdrop"></select></div>
					<div class="c0s" id="mainchanger"></div>
				</div>
				<div id="endlabeldiv"></div>
				<div id="endinput">
					<input id="endateinput" class="c0" style="display: inline-block;"></input>
				</div>
				<div id="logbutton"></div>
				<div id="mainalert"></div>
				<div id="applydiv"></div>
				<div id="selectrowaction">
					<div id="selectmatting"></div>
					<label id="selectlabel">Select Action:</label>
					<select id="selectoption">
						<option selected value="update">Update</option>
						<option value="close">Approve</option>
						<!--<option value="delete">Delete</option>-->
					</select>
					<button type="button" id="selectbutton">Apply</button>
				</div>
			</div>
			<div id="timetable">
				<form id="formtimetable"></form>
			</div> 
	</div>
	<!--<button type="button" id="mytestbutton">Jesus</button>-->

</body>
</div>
</html>








