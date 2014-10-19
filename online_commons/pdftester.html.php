<!DOCTYPE HTML> 

<html lang="en">

<title>PDF Tester</title>
<head>
	<meta http-equiv="Content-type" content="text/html; chaset=UTF-8"></meta>
	<script type="text/javascript" src="jquery-1.10.2.min.js"></script>
	<script type="text/javascript" src="home_action.js"></script>
	<script type="text/javascript" src="common_action.js"></script>
	<script src="jquery-ui.js"></script>
	<link rel="stylesheet" type="text/css" href="common_style.css"></link>
</head>

<body>

<img src="nadsoilco.png" alt="Smiley face" height="60" width="70"><b>Time Card Item Report</b>

<div id="mainWrapper">
	<form method="post" action="phpexporter.html.php">
		<textarea name="content" id="content"></textarea>
		<div id="elementpasser" style="display: none;">
			<input name="phpcatcher" value="PDF"></input>
		</div>
		</br>
		<select id="exportselect">Export Type>
			<option id="pdf">PDF</option>
			<option id="excel">Excel</option>
		</select>
		<div id="submitbutton">
			<input type="submit" name="submit" value="Export" class="myButton"></input>
		</div>
	</form>
</div>

</body>

</html>
