<!DOCTYPE HTML>

<?php
if (isset($authen)){
}else{
	echo 'Access denied';
	exit();
}
?>

<html lang="en">
<title>Report Generator</title>

<head>
<meta http-equiv="Content-type" content="text/html; chaset=UTF-8"></meta>

<!--Common references-->
<script type="text/javascript" src="online_commons/jquery-1.10.2.min.js"></script>
<script src="online_commons/jquery-ui.js"></script>
<script type="text/javascript" src="online_commons/common_action.js"></script>

<!--Production reference-->
<link rel="stylesheet" type="text/css" href="app_production/production_style.css"></link>
<script type="text/javascript" src="app_production/production_action.js"></script>

</head>

<div id="inputs">
	<div id="headerhome">
		<label id="reportlabelhome">Report Generator</label> 
	</div>

	<body>
	<table id="reportgeneratortable" class="reportgenerator">
	<tr>
		<td class="reportlabels">
			<label>Variant:</label>
		</td>
		<td class="reportcontrols">
			<input id="variantype" class="reportgeneratorinput" value="New"></input>
		</td>
	</tr>
	<tr>
		<td class="reportlabels">
			<label id="outputlabel">Output Type:</label>
		</td>
		<td class="reportcontrols">
			<select id="outputype" class="reportgeneratorselect">
				<option value=""></option>
				<option value="table">Table</option>
				<option value="report">Report</option>
			</select>
		</td>
	</tr>
	<tr>	
		<td class="reportlabels">
			<label id="reportnamelabel">Report Name:</label>
		<td class="reportcontrols">
			<select id="reportname" class="reportgeneratorselect">
				<option value=""></option> 
				<option value="production">Production</option>
			</select>
		</td>
	</tr>
	<tr>
		<td class="reportlabels">
			<label id="reportypelabel">Report Type:</label>
		</td>
		<td class="reportcontrols">
			<select id="reportype" class="reportgeneratorselect">
				<option value=""></option>
			</select>
		</td>
	</tr> 
	<tr>
		<td class="reportlabels">
			<label id="itemtypelabel">Item Type:</label>
		</td>
		<td class="reportcontrols">
			<select id="itemtypeselect" class="reportgeneratorselect">
				<option value=""></option>
			</select>
		</td>
	</tr>
	<tr>
		<td class="reportlabels">
			<label id="datequerylabel">Date Query:</label>
		</td>
		<td class="reportcontrols">
			<select id="datequeryselect" class="reportgeneratorselect">
				<option value=""></option>
			</select>
	</td>
	</tr>
	<tr id="datemonthrow">
		<td class="reportlabels">
			<label>Date Month:</label>
		</td>
		<td class="reportcontrols">
			<select id="datemonth" class="reportgeneratorselect">
				<option value=""></option>
			</select>
		</td>
	</tr>
	<tr id="daterangerow1">
		<td class="reportlabels">
			<label>Start Date:</label>
		</td>
		<td class="reportcontrols">
			<input id="startdateinput" class="reportgeneratorinput c0sDT"></input>
		</td>
	</tr>
	<tr id="daterangerow2">
		<td class="reportlabels">
			<label>End Date:</label>
		</td>
		<td class="reportcontrols">
			<input id="endateinput" class="reportgeneratorinput c0sDT"></input>
		</td>
	</tr>
	<tr>
		<td class="reportlabels">
		</td>
		<td class="reportcontrols">
			<button id="reportbutton">Submit</button>
		</td>
	</tr>
	</table>
	</div>
</body>
</div>

<div id="reportoutputs"></div>

</html>