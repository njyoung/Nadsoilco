<?php

//Connect to the db or die

mysql_connect('localhost','njyoung02','Rachel37') or die('failed to connect');
mysql_select_db('nadsoilco');

//timecard application

if($_POST['arg0']=='nameselect'){
	$sql='SELECT Value FROM tbloption WHERE HashID="nameselect"';
	$result=mysql_query($sql);
	$sqlreturn='<option value="null"></option>';	
	while ($row=mysql_fetch_array($result)){
		$sqlreturn=$sqlreturn."<option value='".$row['Value']."'>".
		$row['Value']."</option>";
	}
	echo $sqlreturn;
}

if ($_POST['arg0']=='taskcatselect'){
	$sql='SELECT `Value` FROM `tbloption` WHERE HashID="taskcat" ORDER BY `Value` ASC';
	$result=mysql_query($sql);
	$sqlreturn='<option value="null"></option>';
	while ($row=mysql_fetch_array($result)){
		$sqlreturn=$sqlreturn."<option value='".$row['Value']."'>".
		$row['Value']."</option>";
	}
	echo $sqlreturn;
}

if ($_POST['arg0']=='timeselect'){
	$sql='SELECT Value FROM tbloption WHERE HashID="time" ORDER BY `Order` ASC';
	$result=mysql_query($sql);
	$sqlreturn='<option value="null"></option>';
	while ($row=mysql_fetch_array($result)){
		$sqlreturn=$sqlreturn."<option value='".$row['Value']."'>".
		$row['Value']."</option>";
	}
	echo $sqlreturn;
}

if ($_POST['arg0']=='addtimecard'){
	$name=$_POST['name'];
	$sdate=$_POST['startdate'];
	$tcat=$_POST['taskcat'];
	$tdet=$_POST['taskdet'];
	$start=$_POST['start'];
	$end=$_POST['end'];
	$dur=$_POST['duration'];
	
	$start=new DateTime($sdate." ".$start);
	$start=date_format($start, 'Y-m-d H:i:s');

	$end=new DateTime($sdate." ".$end);
	$end=date_format($end, 'Y-m-d H:i:s');
	
	$sdate=new DateTime($sdate);
	$sdate=date_format($sdate, 'Y-m-d');
	
	$sql ="SELECT `TaskID` FROM `tbltimecard` ORDER BY `TaskID` DESC LIMIT 1";
	
	try{
		$result=mysql_query($sql);
		$row=mysql_fetch_array($result);
		$nextID=$row['TaskID']+1;
	}catch(Exception $e){
		$nextID=1;
		echo('catch');
	}
	
	$sql="INSERT INTO `tbltimecard`(`TaskID`, `Name`, `StartDate`, `TaskCategory`, ".
	"`TaskDetail`, `StartTime`, `EndTime`, `Duration`, `Status`, `Type`) VALUES (".$nextID.", '".$name."', ".
	"'".$sdate."', '".$tcat."', '".$tdet."', '".$start."', '".$end."', ".$dur.", 'Open', 'Active')";
	
	mysql_query($sql);
	
}

if ($_POST['arg0']=='timecardreportlog|items'){

	$name=$_POST['arg1'];
	$sdate=$_POST['arg2'];
	$edate=$_POST['arg3'];
	$ctr=0;
	$sqlreturn='';

	$sdate=new DateTime($sdate);
	$sdate=date_format($sdate, 'Y-m-d');

	$edate=new DateTime($edate);
	$edate=date_format($edate, 'Y-m-d');
	
	
	$pendinghrs=0;
	$approvedhrs=0;
	$mytable="";
	
	$sqlsum="SELECT SUM(`Duration`) AS `total` FROM `tbltimecard` WHERE `Name` ".$name." AND `StartDate` >= '".$sdate.
	"' AND (`StartDate` <= '".$edate."') AND (`Type` = 'Active')";
	$result=mysql_query($sqlsum);
	$row=mysql_fetch_array($result);
	$totalduration=$row['total'];
	
	$sql="SELECT t.Name As Name, ".
		"t.StartDate As `Date`, ".
		"t.StartTime AS `StartTime`, ".
		"t.EndTime AS `EndTime`, ".
		"SUM(t.Duration) As Duration, ".
		"t.Status As Status ".     
		"FROM tbltimecard t ".
		"WHERE t.Type = 'Active' AND (t.StartDate >= '".$sdate."') ".
		"AND (t.StartDate <= '".$edate."') AND (t.Name ".$name.") ".                       
		"GROUP BY t.Name, t.StartDate, t.Status, t.StartTime, t.EndTime ".
		"ORDER BY `StartDate` ASC";
	
	$result=mysql_query($sql);
	
	while ($row=mysql_fetch_array($result)){
		$name=$row['Name'];
		$sdate = date('m/d/Y', strtotime($row['Date']));
		$stime = $row['StartTime'];
		$etime = $row['EndTime'];
		$status = $row['Status'];
		$duration = $row['Duration'];

		$stime=new DateTime($stime);
		$stime=date_format($stime, 'H:i:s');
		
		$etime=new DateTime($etime);
		$etime=date_format($etime, 'H:i:s');
		
		if ($etime[0]==0){
			$etime=(substr($etime, 1));
		}
		if ($stime[0]==0){
			$stime=(substr($stime, 1));
		}
		
		$itime = DLookup("`Value`", "`tbloption`", "`Attribute1`='".$stime."'", 'Value');	
		$ftime = DLookup("`Value`", "`tbloption`", "`Attribute1`='".$etime."'", 'Value');

		$mytable=$mytable.
			"<tr align='justified'>".
				"<td>".$name."</td>".
				"<td>".$sdate."</td>".
				"<td>".$itime."</td>".
				"<td>".$ftime."</td>".
				"<td>".$duration."</td>".
				"<td>".$status."</td>".
			"</tr>";
	}

	echo "<tbody id='tbody1' value='".$totalduration."'>".$mytable;
	
}

if ($_POST['arg0']=='timecardreportlog|summary'){

	$name=$_POST['arg1'];
	$sdate=$_POST['arg2'];
	$edate=$_POST['arg3'];
	$ctr=0;
	$sqlreturn='';

	$sdate=new DateTime($sdate);
	$sdate=date_format($sdate, 'Y-m-d');

	$edate=new DateTime($edate);
	$edate=date_format($edate, 'Y-m-d');
	
	$pendinghrs=0;
	$approvedhrs=0;
	$mytable="";
	
	$sql="SELECT DISTINCT `Name` FROM `tbltimecard` WHERE (`Name` ".$name.") AND (`Type`='Active')";
	$result=mysql_query($sql);
	
	$qrytimecardreport="(SELECT Name, If((Status = 'Approved'), 'Approved', 'Pending') As NewStatus, ".
						"SUM(Duration) As Duration ".
						"FROM tbltimecard ".
						"WHERE Type = 'Active' AND (`StartDate` >= '".$sdate."') ".
						"AND (`StartDate` <= '".$edate."') AND (`Name` ".$name.") ".
						"GROUP BY Name, NewStatus) AS t";   

	$totwherepending="`NewStatus`='Pending'";
	$totwhereapproved="`NewStatus`='Approved'";	
	$totpendinghrs=DLookup('SUM(t.Duration) AS `Total`', $qrytimecardreport, $totwherepending, 'Total');
	$totapprovedhrs=DLookup('SUM(t.Duration) AS `Total`', $qrytimecardreport, $totwhereapproved, 'Total');
		
		if($totpendinghrs==0){
			$totpendinghrs='-';
		}
		if($totapprovedhrs==0){
			$totapprovedhrs='-';
		}
		
	while ($row=mysql_fetch_array($result)){
		$name=$row['Name'];
		$wherepending="`Name`='".$name."' AND (`NewStatus`='Pending')";
		$whereapproved="`Name`='".$name."' AND (`NewStatus`='Approved')";	
		$pendinghrs=DLookup('SUM(t.Duration) AS `Total`', $qrytimecardreport, $wherepending, 'Total');
		$approvedhrs=DLookup('SUM(t.Duration) AS `Total`', $qrytimecardreport, $whereapproved, 'Total');
		
		if ($pendinghrs==0){
			$pendinghrs='-';
		}
		if ($approvedhrs==0){
			$approvedhrs='-';
		}
		
		if ($pendinghrs!='-' || $approvedhrs!='-'){
			$mytable=$mytable.
			"<tr align='justified'>".
				"<td>".$name."</td>".
				"<td>".$pendinghrs."</td>".
				"<td>".$approvedhrs."</td>".
			"</tr>";
		}
	}
	
	$mytable=$mytable.
		"<tr align='justified'>".
			"<td style='border-top:solid #330033'><b>Total</b></td>".
			"<td style='border-top:solid #330033'><b>".$totpendinghrs."</b></td>".
			"<td style='border-top:solid #330033'><b>".$totapprovedhrs."</b></td>".
		"</tr>";
		
	echo "<tbody id='tbody1' value='0'>".$mytable;
}

if ($_POST['arg0']=='timecardreportlog|category'){

	$name=$_POST['arg1'];
	$sdate=$_POST['arg2'];
	$edate=$_POST['arg3'];
	$ctr=0;
	$sqlreturn='';
	
	$sdate=new DateTime($sdate);
	$sdate=date_format($sdate, 'Y-m-d');

	$edate=new DateTime($edate);
	$edate=date_format($edate, 'Y-m-d');
	
	$pendinghrs=0;
	$approvedhrs=0;
	$mytable="";
	
	$sqlsum="SELECT SUM(`Duration`) AS `total` FROM `tbltimecard` WHERE `Name` ".$name." AND `StartDate` >= '".$sdate.
	"' AND (`StartDate` <= '".$edate."') AND (`Type` = 'Active')";
	$result=mysql_query($sqlsum);
	$row=mysql_fetch_array($result);
	$totalduration=$row['total'];
	
	$sql="SELECT `Name`, `StartDate`, `TaskCategory`, ".
		"SUM(`Duration`) As Duration ".
		"FROM tbltimecard ".
		"WHERE `Type` = 'Active' AND (`StartDate` >= '".$sdate."') ".
		"AND (`StartDate` <= '".$edate."') AND (`Name` ".$name.") ".
		"GROUP BY `Name`, `StartDate`, `TaskCategory`";   
	$result=mysql_query($sql);
	
	while ($row=mysql_fetch_array($result)){
		$name=$row['Name'];
		$sdate=date('m/d/Y', strtotime($row['StartDate']));
		$category=$row['TaskCategory'];
		$duration=$row['Duration'];
		
		$mytable=$mytable.
		"<tr align='justified'>".
			"<td>".$name."</td>".
			"<td>".$sdate."</td>".
			"<td>".$category."</td>".
			"<td>".$duration."</td>".
		"</tr>";
	}
	
	echo "<tbody id='tbody1' value='".$totalduration."'>".$mytable;

}

if ($_POST['arg0']=='timecardentrieslog'){
	
	$name=$_POST['arg1'];
	$sdate=$_POST['arg2'];
	$edate=$_POST['arg3'];
	$ctr=0;
	$sqlreturn='';
	
	$sdate=new DateTime($sdate);
	$sdate=date_format($sdate, 'Y-m-d');
	
	$edate=new DateTime($edate);
	$edate=date_format($edate, 'Y-m-d');
	
	$sqlsum="SELECT SUM(`Duration`) AS `total` FROM `tbltimecard` WHERE `Name` ".$name." AND `StartDate` >= '".$sdate.
	"' AND (`StartDate` <= '".$edate."') AND (`Type` = 'Active')";
	$result=mysql_query($sqlsum);
	$row=mysql_fetch_array($result);
	$totalduration=$row['total'];
	
	$sql="SELECT * FROM `tbltimecard` WHERE `Name` ".$name." AND `StartDate` >= '".$sdate.
	"' AND (`StartDate` <= '".$edate."') AND (`Type` = 'Active') ORDER BY `EndTime` DESC ";
	$result=mysql_query($sql);

		while ($row=mysql_fetch_array($result)){	
			$ctr++;
			$stime = $row['StartTime'];
			$etime = $row['EndTime'];
			
			$stime=new DateTime($stime);
			$stime=date_format($stime, 'H:i:s');
			
			$etime=new DateTime($etime);
			$etime=date_format($etime, 'H:i:s');
			
			if ($etime[0]==0){
				$etime=(substr($etime, 1));
			}
			if ($stime[0]==0){
				$stime=(substr($stime, 1));
			}
			
			$itime = DLookup("`Value`", "`tbloption`", "`Attribute1`='".$stime."'", 'Value');	
			$ftime = DLookup("`Value`", "`tbloption`", "`Attribute1`='".$etime."'", 'Value');
			$sdate = date('m/d/Y', strtotime($row['StartDate']));
			
			$sqlreturn=$sqlreturn.
				"<tr>". 
					"<td class='c1'><input value='".$row['Name']."' class='c1' id='name".$row['myID']."' disabled='disabled'></input></td>".
					"<td class='c2'><input value='".$sdate."' class='c2' id='taskdate".$row['myID']."'></input></td>".
					"<td class='c3'><select value='".$row['TaskCategory']."' class='c3select' id='taskcat".$row['myID']."'></select></td>".
					"<td class='c4'><input value='".$row['TaskDetail']."' class='c4detail' id='taskdetail".$row['myID']."'></input></td>".
					"<td class='c5'><select value='".$itime."' class='c5time' id='start".$row['myID']."'></select></div></td>".
					"<td class='c5'><select value='".$ftime."' class='c5time' id='end".$row['myID']."'></select></td>".
					"<td class='c6'><input value='".$row['Duration']."' class='c6' disabled='disabled' id='duration".$row['myID']."'></input></td>".
					"<td class='c7'><label class='c7status'>".$row['Status']."</label></td>".
					"<td class='c8'><input type='checkbox' id='itemcheck-".$row['myID']."-".$row['TaskID']."' class='itemchecker' value='1'></input></td>".
				"</tr>";
		}
	$sqlreturn="<tbody id='mytbody' name='".$ctr."' value='".$totalduration."'>".$sqlreturn."</tbody>";
		
	echo $sqlreturn;
	
}

if ($_POST['arg0']=='timecardupdate'){
	$name=$_POST['name'];
	$sdate=$_POST['startdate'];
	$tcat=$_POST['taskcat'];
	$tdet=$_POST['taskdet'];
	$start=$_POST['start'];
	$end=$_POST['end'];
	$dur=$_POST['duration'];
	$myID=$_POST['myID'];
	$taskID=$_POST['taskID'];
	$timestamp=date("Y-m-d H:i:s");
	$status=$_POST['status'];
	$type=$_POST['type'];
	
	$start=new DateTime($sdate." ".$start);
	$start=date_format($start, 'Y-m-d H:i:s');

	$end=new DateTime($sdate." ".$end);
	$end=date_format($end, 'Y-m-d H:i:s');
	
	$sdate=new DateTime($sdate);
	$sdate=date_format($sdate, 'Y-m-d');
	
	$checkapprov=DLookup("`Status`", "`tbltimecard`", "`myID`='".$myID."' AND (`Type`='Active')", 'Status');
	
	if($checkapprov=='Approved'){
		echo 'Time closed for update';
		return;
	}
	
	$sql="UPDATE `tbltimecard` SET `Type`='Inactive' WHERE myID=".$myID;
	mysql_query($sql);
	
	$sql="INSERT INTO `tbltimecard`(`TaskID`, `Name`, `StartDate`, `TaskCategory`, ".
	"`TaskDetail`, `StartTime`, `EndTime`, `Duration`, `Status`, `Type`) VALUES (".$taskID.", '".$name."', ".
	"'".$sdate."', '".$tcat."', '".$tdet."', '".$start."', '".$end."', ".$dur.", '".$status."', '".$type."')";
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

?>
