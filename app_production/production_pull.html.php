<?php

mysql_connect('localhost','njyoung02','Rachel37') or die('failed to connect');
mysql_select_db('nadsoilco');

class groupedreport{
  
	public function reportbasicdeclares(){
		$this->battery =  'ARCO Fee G Tank Battery'; //$battery 
		$this->rowheader = '';
		$this->tankarray = array();
		$this->datearray = array();
		$this->datarray = array();
		$this->subheaderarray = array();
		$this->headerhtml = '';
		$this->subheaderhtmlstr = "";
		$this->subheaderhtmlitem1 = 
			'<th class="subheaderclass">Ft</th>'.
			'<th class="subheaderclass">Inch</th>'.
			'<th class="subheaderclass">Bal</th>'.
			'<th class="subheaderclass">Prod</th>'.
			'<th class="subheaderclass">Run</th>'.
			'<th class="subheaderclass">Net</th>';
			
		$this->subheaderhtmlitem2 = 
			'<th class="totalsubheaderclass">Ft</th>'.
			'<th class="totalsubheaderclass">Inch</th>'.
			'<th class="totalsubheaderclass">Bal</th>'.
			'<th class="totalsubheaderclass">Prod</th>'.
			'<th class="totalsubheaderclass">Run</th>'.
			'<th class="totalsubheaderclass">Net</th>';	
		
		$this->bodyhtml1 = '';
		$this->bodyhtml2 = '';
		$this->sql = '';
		
	}
	
	public function reportheader(){
		$x = 0;
		$this->sql = 'SELECT DISTINCT `TankID` FROM `tblproductionreport1`';
		$result = mysql_query($this->sql);
		
		//Loads the header Tank IDs into the title
		while ($row=mysql_fetch_array($result)){
			$x++;
			$this->tankarray[$x] = $row['TankID'];
			//Loading the sub-header fields into the header fields
			$this->headerhtml = $this->headerhtml.'<th colspan="6" class="headerclass">Tank ID:'.$this->tankarray[$x].'</th>';
			$this->subheaderhtmlstr = $this->subheaderhtmlstr.$this->subheaderhtmlitem1;
		}
		//Loads the total header cluster
		$this->headerhtml = $this->headerhtml.'<th colspan="6" class="totalheaderclass">Total Oil</th>';
		$this->subheaderhtmlstr = $this->subheaderhtmlstr.$this->subheaderhtmlitem2;
		 
		 //Puts together the battery title, tank ID header, and subheader fields
		$this->headerhtml = '<table id="mytable">'.
			'<thead>'.
				'<tr align="justified" id="headerbat">
					<th colspan="25">'.$this->battery.'</th>'.
				'</tr>'.
				'<tr align="justified">
					<th class="emptyheaderclass"></th>'.
					$this->headerhtml.
				'</tr>'.
				'<tr align="justified">'.
					'<th class="emptyheaderclass">Date</th>'.
					$this->subheaderhtmlstr.
				'</tr>'.
			'</thead>';
		return; 
	}
	
	public function datearrayloader(){
		//Loads the dates in the selection into the date array
		$x = 0;
		$this->sql = 'SELECT DISTINCT `Date` FROM `tblproductionreport1` ORDER BY `Date` ASC';
		$result = mysql_query($this->sql);
		while ($row=mysql_fetch_array($result)){
			$x++;
			$this->datearray[$x] = $row['Date'];
		}
	}
	
	public function subheaderarrayloader(){
		//Loads the sub-header fields into the sub-header array
		$this->subheaderarray[0] = 'Ft';
		$this->subheaderarray[1] = 'Inch';
		$this->subheaderarray[2] = 'Bal';
		$this->subheaderarray[3] = 'Prod';
		$this->subheaderarray[4] = 'Run';
		$this->subheaderarray[5] = 'Net';	
	}
	
	public function reportbody(){
			
		$this->bodyhtml1 = '<tbody>';
		
		foreach($this->datearray as $datevalue){
			
			//Resets the cumulative total values of each tank grouping
			$ftvalue = 0;
			$inchvalue = 0;
			$balvalue = 0;
			$prodvalue = 0;
			$runvalue = 0;
			$netvalue = 0;
			
			//Starts each row with each unique date in selection
			$mydate = date('m/d/Y', strtotime($datevalue));
			$this->bodyhtml1 = $this->bodyhtml1.'<tr><td class="prodataclass">'.$mydate.'</td>';
			$this->bodyhtml2 = '';
			
			foreach($this->tankarray as $tankvalue){
				foreach($this->subheaderarray as $sha){
					//Looks up each subarray parameter for each tank for each unique date
					$lookval = dlookup('`'.$sha.'`', 'tblproductionreport1', '`TankID` = "'.$tankvalue.
						'" AND (`Date` = "'.$datevalue.'")', ''.$sha.''); 
					switch ($sha){
						case 'Ft':
							$dec = False;
							$ftvalue = $ftvalue + $lookval;
							break;
						case 'Inch':
							$dec = False;
							$inchvalue = $inchvalue + $lookval;
							break;
						case 'Bal':
							$dec = True;
							$balvalue = $balvalue + $lookval;
							break;
						case 'Prod':
							$dec = True;
							$prodvalue = $prodvalue + $lookval;
							break;
						case 'Run':
							$dec = False;
							$runvalue = $runvalue + $lookval;
							break;
						case 'Net':
							$dec = true;
							$netvalue = $netvalue + $lookval;
							break;
					}
					$this->bodyhtml2 = $this->bodyhtml2loader($lookval, $dec);
				}
			}	
			
			//Converts the total ft/inches into correct ft + inches
			$conversionarray = explode('|', feetinchconverter($inchvalue), 10);
			$inchvalue = $conversionarray[0];
			$ftvalue = $ftvalue + $conversionarray[1];
			//Creates the total cluster into the last columns of the tabl
			$this->bodyhtml1 = $this->bodyhtml1.$this->bodyhtml2.
				'<td class="prodataclass">'.$ftvalue.'</td>'.
				'<td class="prodataclass">'.$inchvalue.'</td>'.
				'<td class="prodataclass">'.number_format($balvalue, 2).'</td>'.
				'<td class="prodataclass">'.number_format($prodvalue, 2).'</td>'.
				'<td class="prodataclass">'.$runvalue.'</td>'.
				'<td class="prodataclass">'.number_format($netvalue, 2).'</td></tr>';
		} 
		echo $this->headerhtml.$this->bodyhtml1.
		'<tr>'.  
			'<td class="totalrow"></td>'.
			'<td class="totalrow"></td>'.
			'<td class="totalrow"></td>'.
			'<td class="totalrow">Total</td>'.
			'<td class="totalrow"></td>'.
			'<td class="totalrow"></td>'.
			'<td class="totalrow"></td>'.
			'<td class="totalrow"></td>'.
			'<td class="totalrow"></td>'.
			'<td class="totalrow">Total</td>'.
			'<td class="totalrow"></td>'.
			'<td class="totalrow"></td>'.
			'<td class="totalrow"></td>'.
			'<td class="totalrow"></td>'.
			'<td class="totalrow"></td>'.
			'<td class="totalrow">Total</td>'.
			'<td class="totalrow"></td>'.
			'<td class="totalrow"></td>'.
			'<td class="totalrow"></td>'.
			'<td class="totalrow"></td>'.
			'<td class="totalrow"></td>'.
			'<td class="totalrow">Total</td>'.
			'<td class="totalrow"></td>'.
			'<td class="totalrow"></td>'.
			'<td class="totalrow"></td>'.
		'</tr>'.	
		'</tbody></table>';
		return;
	}
	
	public function bodyhtml2loader($lv, $d){
		switch($d){
			case True:
				return $this->bodyhtml2.'<td class="prodataclass">'.number_format($lv,2).'</td>';
				break;
			case False:
				return $this->bodyhtml2.'<td class="prodataclass">'.$lv.'</td>';
				break;
		}
	}
}

if(isset($_POST['arg0'])){
	if($_POST['arg0']=='report'){
			$mynewreport = new groupedreport;
			$mynewreport->reportbasicdeclares();
			$mynewreport->reportheader();
			$mynewreport->datearrayloader();
			$mynewreport->subheaderarrayloader();			
			$mynewreport->reportbody();
			return;
	}

	if($_POST['arg0']=='reportype'){
		$hid=$_POST['arg1'];
		$sql='SELECT Value FROM tbloption WHERE HashID="'.$hid.'" ORDER BY `Order` ASC';
		$result=mysql_query($sql);
		$sqlreturn='<option value="null"></option>';	
		while ($row=mysql_fetch_array($result)){
			$sqlreturn=$sqlreturn."<option value='".$row['Value']."'>".
			$row['Value']."</option>";
		}
		echo $sqlreturn;
	}	
	
	if($_POST['arg0']=='itemtype'){
		$rtype=$_POST['arg1'];
		$sql='SELECT DISTINCT `'.$rtype.'` FROM tblproductionreport1';
		$result=mysql_query($sql);
		$sqlreturn='<option value="null"></option>';
		while ($row=mysql_fetch_array($result)){
			$sqlreturn=$sqlreturn."<option value='".$row[$rtype]."'>".
			$row[$rtype]."</option>"; 	
		}
		echo $sqlreturn;
	}
	
	if($_POST['arg0']=='datemonth'){
		$hid='Date Month';
		$sql='SELECT Value FROM tbloption WHERE HashID="'.$hid.
			'" AND (`Order` < 59) ORDER BY `Order` DESC';
		$result=mysql_query($sql);
		$sqlreturn='<option value="null"></option>';
		while ($row=mysql_fetch_array($result)){
			$sqlreturn=$sqlreturn."<option value='".$row['Value']."'>".
			$row['Value']."</option>";
		}
		echo $sqlreturn;
	}
}

function feetinchconverter($i){
	$extraft = 0;
	$newinch = 0;
	while ($i >= 0){	
		$newinch = $i;
		$i = $i - 12;
		$extraft = $extraft + 1;
	}
	$extraft = $extraft - 1;
	return $newinch.'|'.$extraft;
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



