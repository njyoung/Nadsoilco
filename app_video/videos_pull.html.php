<?php

//Connect to the db or die

mysql_connect('localhost','njyoung02','Rachel37') or die('failed to connect');
mysql_select_db('nadsoilco');

//video library

if($_POST['arg0']=='videoembedselect'){

	$videoname=$_POST['arg1'];
	$embed=dlookup('Embed', '`tblvideolibrary`', '`VideoName`="'.$videoname.'"', 'Embed');
	echo $embed;
}

if($_POST['arg0']=='videonameselect'){
	
	$sql='SELECT VideoName FROM `tblvideolibrary` ORDER BY VideoName ASC';
	$result=mysql_query($sql);
	$sqlreturn='<option value="null"></option>';
	while ($row=mysql_fetch_array($result)){
		$sqlreturn=$sqlreturn."<option value='".$row['VideoName']."'>".
		$row['VideoName']."</option>";
	}
	echo $sqlreturn;	
}

if($_POST['arg0']=='updatevideo'){
	$vname=$_POST['arg1'];
	$embed=$_POST['arg2'];
	$myid=$_POST['arg3'];
	//var datastring={arg: qtype, sarg: mtype, targ: ntype, uarg: otype}
	$sql="UPDATE `tblvideolibrary` SET `VideoName`='".$vname."', `Embed`='".$embed."' WHERE `myID`=".$myid;
	mysql_query($sql);
}

if($_POST['arg0']=='deletevideo'){
	$myid=$_POST['arg1'];
	$sql="DELETE FROM `tblvideolibrary` WHERE `myID`=".$myid;
	mysql_query($sql);
}

if ($_POST['arg0']=='videotable'){
	$sql='SELECT VideoName, Embed, myID FROM tblvideolibrary ORDER BY VideoName ASC';
	$result=mysql_query($sql);
	$sqlreturn='<thead><tr><th>Video Name</th><th>Embed Source</th><th>Action</th></tr></thead>';
	while ($row=mysql_fetch_array($result)){
		$sqlreturn=$sqlreturn.
		"<tr>".
			"<td class='v1'><input class='v1' id='v1-".$row['myID']."' value='".$row['VideoName']."'></input></td>".
			"<td class='v3'><input class='v3' id='v3-".$row['myID']."' value='".$row['Embed']."'></input></td>".
			"<td class='v2'><button class='gridbutton1' type='button' id='savecommand".$row['myID']."'>Save</button></td>".
		"</tr>";
	}
	$sqlreturn=$sqlreturn.
		"<tr>".
			"<td class='v1'><input class='v1' id='addinput1'></input></td>".
			"<td class='v3'><input class='v3' id='addinput2'></input></td>".
			"<td class='v2'><button class='gridbutton2' type='button' id='addcommand'>Add</button></td>".
		"</tr>";
	echo $sqlreturn;
}

if ($_POST['arg0']=='insert_video'){
	$vname=$_POST['arg1'];
	$embed=$_POST['arg2'];
	$sql="INSERT INTO `tblvideolibrary`(`VideoName`, `Embed`) VALUES ('".$vname."', '".$embed."')";
	mysql_query($sql);
}

function DLookup($fld, $tab, $whr, $fieldret){
	$q = "SELECT ".$fld." FROM ".$tab." WHERE ".$whr;

	$rst = mysql_query($q); 
	while ($row=mysql_fetch_array($rst)){
		$sqlreturn = $row[$fieldret];
		//value
	}
	return $sqlreturn; 
}

/*THIS IS MY TEST FUNCTION
if ($_POST['arg0']=='test'){
	trymystoredproc();
	echo "jesus";
	
}

function trymystoredproc(){
	$sql = 'CALL TimeCardReport1()';
	//$sql = "DELETE FROM tbltimereport1";
	mysql_query($sql);
}*/
	
?>
