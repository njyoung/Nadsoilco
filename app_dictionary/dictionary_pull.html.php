<?php

//Connect to the db or die

mysql_connect('localhost','njyoung02','Rachel37') or die('failed to connect');
mysql_select_db('nadsoilco');

if ($_POST['arg0']=='dictionarytable'){
	$qfilter=$_POST['arg1'];
	$sql='SELECT HashID, myID, Value FROM tbloption WHERE HashID = "'.$qfilter.'" ORDER BY Value ASC';
	$result=mysql_query($sql);
	$sqlreturn='<thead><tr><th>Value</th><th>Action</th></tr></thead>';
	while ($row=mysql_fetch_array($result)){
		$sqlreturn=$sqlreturn."<tr><td><input id='".$row['myID'].
		"' value='".$row['Value']."'></input></td><td><button id='changeButton".$row['myID'].
		"' type='button' class='gridbutton1' id='savecommand'".$row['myID'].">Save</button></td></tr>";
	}
	$sqlreturn=$sqlreturn."<tr><td><input id='addinput'></input></td><td>".
	"<button type='button' class='gridbutton2' id='addcommand'>Add</button></td></tr>";
	echo $sqlreturn;
}

if ($_POST['arg0']=='insert_dictionary'){
	$val=$_POST['arg1'];
	$hash=$_POST['arg2'];
	$sql="INSERT INTO `tbloption`(`HashID`, `Value`, `Order`) VALUES ('".$hash."', '".$val."', 0)";
	mysql_query($sql);
	echo 'success';
}

if ($_POST['arg0']=='updateoptions'){
	$val=$_POST['arg1'];
	$myid=$_POST['arg2'];
	$sql="UPDATE `tbloption` SET `Value`='".$val."' WHERE `myID`=".$myid;
	mysql_query($sql);
}

if ($_POST['arg0']=='deleteoptions'){
	$val=$_POST['arg1'];
	$myid=$_POST['arg2'];
	$sql="DELETE FROM `tbloption` WHERE `myID`=".$myid;
	mysql_query($sql);
}
	
?>
