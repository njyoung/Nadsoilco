<!DOCTYPE HTML>

<?php
if (isset($authen)){
}else{
	echo 'Access denied';
	exit();
}
?>

<html lang="en">
<title>Dictionary</title>

<head>
<meta http-equiv="Content-type" content="text/html; chaset=UTF-8"></meta>

<!--Common references-->
<script type="text/javascript" src="online_commons/jquery-1.10.2.min.js"></script>
<script src="online_commons/jquery-ui.js"></script>
<link rel="stylesheet" type="text/css" href="online_commons/common_style.css"></link>
<script type="text/javascript" src="online_commons/common_action.js"></script>

<!--Dictionary reference-->
<script type="text/javascript" src="app_dictionary/dictionary_action.js"></script>
</head>

<div id="headerdictionary">
	<form method="post" action="index.html.php">
		<button id="homebutton" name="redirect" value="home"></button>
	</form>
	<label id="headerlabeldictionary">List Manager</label>
</div>
</br>
</br>
<div id="mainwrap">
	<body>
		<form name="mainform" id="mainform" method="POST">
			<div id="dictionarymain">
				<div id="dictionarylabels">
					<label class="c0l">(1) Select Dictionary:</label>
				</div>
				<div id="dictionaryinput">
					<select name="mainselect" id="mainselect" class="c0s"></select>
				</div>
			</div>
		</form>
		<div id="maingrid"></div>
	</body>

</div>
</html>
