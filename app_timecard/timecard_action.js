$(document).ready(function(){
	reloadpage();

	/*Start of My Test button--UPDATED
		$('#mytestbutton').show();
		$('#mytestbutton').click(function(){	
			pullmysql('test');
		})

	$('#exportselect').change(function(){
		var exportsel=$('#exportselect').val();
		console.log(exportsel);
		var phpstring= 
			"<input name='phpexportcatcher' value='" + exportsel + "'></input>";
		$('#elementpasser').html(phpstring);
	})
	End of My Test button*/

	var namelen=$('#nameselect').length;
	$('#choiceselect').change(function(){
		switch ($('#choiceselect').val()){
			case 'Enter Work Hours':
				$('#miscbuttons').show();
				$('#exportbuttons').hide();
				$('#startdateinput').show();
				$('#nameselect').show();
				$('#mainchanger').show();
				$('#tasklabel').show();
				$('#namelabel').show();
				$('#datelabel').show();
				$('#logbutton').html('');
				$('#endinput').hide();
				$('#endlabeldiv').html('');
				$('#formtimetable').html('');
				$('#datelabel').html('(2) Date:');
				$('#endlabeldiv').html('');	
				$('#applydiv').html('');
				$('#selectrowaction').hide();	
				var mselect=
				"<select name='mainselect' id='mainselect' class='c0sdrop'>" +
				"<option value='null'></option><option value='1'>1</option>" +
				"<option value='2'>2</option><option value='3'>3</option>" + 
				"<option value='4'>4</option><option value='5'>5</option>" + 
				"<option value='6'>6</option><option value='7'>7</option>" + 
				"<option value='8'>8</option><option value='9'>9</option>" +
				"<option value='10'>10</option></select>";
				$('#mainchanger').html(mselect);
				$('#tasklabel').html('(4) Tasks:');
				loadmainselectchange();
				break;
			case 'View Entries':
				$('#miscbuttons').show();
				$('#exportbuttons').hide();
				$('#datelabel').html('(2) Date:');
				$('#startdateinput').show();
				$('#nameselect').show();
				$('#mainselect').hide();
				$('#tasklabel').hide();
				$('#namelabel').show();
				$('#datelabel').show();
				var myhtml = '<button class="showlogbutton" id="showentriesbutton" type="button">Show Entries</button>'		
				$('#logbutton').html(myhtml);
				$('#formtimetable').html('');
				$('#datelabel').html('(2) Start:');
				myhtml=
				'<label id="endlabel">End:</label>'
				$('#endlabeldiv').html(myhtml);
				//myhtml=
				//'<input id="endateinput" class="c0" style="display: inline-block;"></input>'
				//$('#endinput').html(myhtml);
				$('#endinput').show();
				$('#mainalert').html('');
				$('#applydiv').html('');
				$('#selectrowaction').hide();	
				addDatepicker();
				break;
			case 'View Report':
				$('#miscbuttons').hide();
				$('#exportbuttons').show();
				$('#datelabel').html('(2) Date:');
				$('#startdateinput').show();
				$('#nameselect').show();
				$('#namelabel').show();
				$('#datelabel').show();
				var myhtml = '<button class="showlogbutton" id="showreportbutton" type="button">Show Report</button>'			
				$('#logbutton').html(myhtml);
				$('#formtimetable').html('');
				$('#datelabel').html('(2) Start:');
				myhtml=
				'<label id="endlabel">End:</label>'
				$('#endlabeldiv').html(myhtml);
				//myhtml=
				//'<input id="endateinput" class="c0" style="display: inline-block;"></input>'
				//$('#endinput').html(myhtml);
				$('#endinput').show();
				$('#mainalert').html('');
				$('#applydiv').html('');
				$('#selectrowaction').hide();	
				
				$('#mainchanger').show();
				$('#mainchanger').val('');
				$('#tasklabel').show();
				
				var mselect=
				"<select name='mainselect' id='mainselect' class='c0sdrop'>" +
				"<option value='null'></option><option value='category'>Category Summary</option>" +
				"<option value='summary'>Hours Summary</option>" +
				"<option value='items'>Item Summary</option></select>";
				$('#mainchanger').html(mselect);
				$('#tasklabel').html('(4) Report:');
				
				addDatepicker();
				break;
		}
		
		$('#showreportbutton').click(function(){
			var html1='';
			var html2='';
			var tblctr=0;
			var tbldur=0;
			try {
				var rowcounter=0;
				
					try{
						var edatelen=$('#endateinput').val().length;
						var sdatelen=$('#startdateinput').val().length;
						var iname=$('#nameselect').val();
						var reportype=$('#mainselect').val();
					}catch(err){
						edatelen=0;
					}
						if (sdatelen>0){
							var sdate=$('#startdateinput').val();
						}else{
							sdate='01/01/2010';
						}
						if (iname!='null'){
							var iname="= '" + $('#nameselect').val() + "'";
						}else{
							iname='IS NOT NULL';
						}
						if (edatelen>0){
							var edate = $('#endateinput').val();
						}else{	
							edate = '01/01/2050';
						}
					var sqlreturn = pullmysql('timecardreportlog' + '|' + reportype, iname, sdate, edate);

					var html = '';
					
					switch (reportype){
						case 'summary':
							html1 = 
							"<table cellspacing='0' cellpadding='0' id='timetablenest3' width='350'>" +
								"<thead>" +
									"<tr align='justified' bgcolor='#330033'>" + 
										"<th><font color='white'>Name</font></th>" +
										"<th><font color='white'>Pending</font></th>" +
										"<th><font color='white'>Approved</font></th>" +
									"</tr>" +
								"</thead>";
							html1=html1 + sqlreturn + 
							"</tbody>" +
							"</table>";
						break;
						case 'items':
							html1 = 
							"<table cellspacing='0' cellpadding='0' id='timetablenest3' width='700'>" +
								"<thead>" +
									"<tr align='justified' bgcolor='#330033'>" + 
										"<th><font color='white'>Name</font></th>" +
										"<th><font color='white'>Date</font></th>" +
										"<th><font color='white'>Start Time</font></th>" +
										"<th><font color='white'>End Time</font></th>" +
										"<th><font color='white'>Duration</font></th>" +
										"<th><font color='white'>Status</font></th>" +
									"</tr>" +
								"</thead>";
							html1=html1 + sqlreturn + 
							"<tr>" +
								"<td style='border-top:solid #330033'></td>" +
								"<td style='border-top:solid #330033'></td>" +
								"<td style='border-top:solid #330033'></td>" +
								"<td style='border-top:solid #330033'><b>Total</b></td>" +
								"<td id='totduration' style='border-top:solid #330033'><b></b></td>" +
								"<td style='border-top:solid #330033'><font size='1'>-</font></td>" +
							"</tr>" +
							"</tbody>" +
							"</table>";
						break;
						case 'category':
							html1 = 
							"<table cellspacing='0' cellpadding='0' id='timetablenest3' width='700'>" +
								"<thead>" +
									"<tr align='justified' bgcolor='#330033'>" + 
										"<th><font color='white'>Name</font></th>" +
										"<th><font color='white'>Date</font></th>" +
										"<th><font color='white'>Category</font></th>" +
										"<th><font color='white'>Duration</font></th>" +
									"</tr>" +
								"</thead>";
							html1=html1 + sqlreturn + 
							"<tr>" +
								"<td style='border-top:solid #330033'></td>" +
								"<td style='border-top:solid #330033'></td>" +
								"<td style='border-top:solid #330033'><b>Total</b></td>" +
								"<td id='totduration' style='border-top:solid #330033'><b></b></td>" +
							"</tr>" +
							"</tbody>" +
							"</table>";
					}
					html1="<div id='tablecluster3'>"+html1+"</div>";
					$('#formtimetable').html(html1);
			} finally {
				switch (reportype){
					case 'items':
						var totaltime = $('#tbody1').attr('value');
						$('#totduration').html(totaltime);
						html2 = "<img src='nadsoilco.png' height='60' width='90'><b>Time Card Item Report</b>" +
						"<br><br>"+
						"<table cellspacing='0' cellpadding='0' id='timetablenest3' width='500'>" +
							"<thead>" +
								"<tr align='justified' bgcolor='#330033'>" + 
									"<th><font color='white' cellspacing='1'>Name</font></th>" +
									"<th><font color='white' cellspacing='1'>Date</font></th>" +
									"<th><font color='white' cellspacing='1'>Start Time</font></th>" +
									"<th><font color='white' cellspacing='1'>End Time</font></th>" +
									"<th><font color='white' cellspacing='1'>Duration</font></th>" +
									"<th><font color='white' cellspacing='1'>Status</font></th>" +
								"</tr>" +
							"</thead>";
						html2=html2 + sqlreturn + 
						"<tr>" +
							"<td style='border-top:solid #330033' width='80'></td>" +
							"<td style='border-top:solid #330033' width='80'></td>" +
							"<td style='border-top:solid #330033' width='80'></td>" +
							"<td style='border-top:solid #330033' width='80'><b>Total</b></td>" +
							"<td id='totduration' style='border-top:solid #330033' width='80'><b>"+totaltime+"</b></td>" +
							"<td style='border-top:solid #330033' width='80'></td>" +
						"</tr>" +
						"</tbody>" +
						"</table>";
						$('#pdfpasser').val(html2);		
					break;
					case 'summary':
						html2 = "<img src='nadsoilco.png' height='60' width='90'><b>Time Card Summary Report</b><br><br>" + html1;
						$('#pdfpasser').val(html2);		
					break;
					case 'category':
						var totaltime = $('#tbody1').attr('value');
						$('#totduration').html(totaltime);
						html2 = "<img src='nadsoilco.png' height='60' width='90'><b>Time Card Item Report</b>" +
						"<br><br>"+
						"<table cellspacing='0' cellpadding='0' id='timetablenest3' width='400'>" +
							"<thead>" +
								"<tr align='justified' bgcolor='#330033'>" + 
									"<th><font color='white' cellspacing='1'>Name</font></th>" +
									"<th><font color='white' cellspacing='1'>Date</font></th>" +
									"<th><font color='white' cellspacing='1'>Category</font></th>" +
									"<th><font color='white' cellspacing='1'>Duration</font></th>" +
								"</tr>" +
							"</thead>";
						html2=html2 + sqlreturn + 
						"<tr>" +
							"<td style='border-top:solid #330033' width='80'></td>" +
							"<td style='border-top:solid #330033' width='80'></td>" +
							"<td style='border-top:solid #330033' width='80'><b>Total</b></td>" +
							"<td id='totduration' style='border-top:solid #330033' width='80'><b>"+totaltime+"</b></td>" +
						"</tr>" +
						"</tbody>" +
						"</table>";
						$('#pdfpasser').val(html2);	
					break;
				}
			}
		})
		
		$('#showentriesbutton').click(function(){
			var tblctr=0;
			var tbldur=0;
			try {
				var rowcounter=0;
				var sdate=$('#startdateinput').val();
					try{
						var edatelen=$('#endateinput').val().length;
						var sdatelen=$('#startdateinput').val().length;
						var iname=$('#nameselect').val();
					}catch(err){
						edatelen=0;
					}
						if (sdatelen>0){
							var sdate=$('#startdateinput').val();
						}else{
							sdate='01/01/2010';
						}
						if (iname!='null'){
							var iname="= '" + $('#nameselect').val() + "'";
						}else{
							iname='IS NOT NULL';
						}
						if (edatelen>0){
							var edate = $('#endateinput').val();
						}else{	
							edate = '01/01/2050';
						}
					var sqlreturn = pullmysql('timecardentrieslog', iname, sdate, edate);
					var html=
					"<div id='tablecluster1'><table cellspacing='1' cellpadding='2' id='timetablenest1' width='600'>" +
						"<thead>" + 
							"<tr>" + 
								"<th class='c1'>Name</th>" +
								"<th class='c2'>Start Date</th>" +
								"<th class='c3'>Task Category</th>" +
								"<th class='c4'>Task Detail</th>" +
								"<th class='c5'>Start Time</th>" +
								"<th class='c5'>End Time</th>" +
								"<th class='c6'>Duration</th>" +
								"<th class='c7'>Status</th>" +
								"<th class='c8'><input type='checkbox' id='headchecker'></input></th>"
							"</tr>" +
						"</thead>";
					html=html+sqlreturn;
					html=html+ "</table><div id='totlabeldiv'><label id='totlabel'></label></div></div>";
					$('#formtimetable').html(html);
					
					var tblselect=pullmysql('taskcatselect');
					$('.c3select').html(tblselect);
					
					tblselect=pullmysql('timeselect');
					$('.c5time').html(tblselect);
				
					tblctr=$('#mytbody').attr('name');
		
			} finally {
				poptimetable();
				
				tbldur=$('#mytbody').attr('value');
				
				if(tbldur.length==0){
					$('#totlabel').html('');
				}else{
					$('#totlabel').html('Total:    ' + tbldur + ' hrs');
				}
			}
			
			$('.itemchecker').click(function(){
				if($(this).prop('checked')){
					$('#selectrowaction').show();
					$('#applydiv').show();
				}else{
					$('#selectrowaction').hide();
					$('#applydiv').hide();
				}	
			})
			
			$('#headchecker').click(function(){
				markcheckbox();
				if($(this).prop('checked')&&tblctr>0){
					$('#selectrowaction').show();		
				}else{$('#selectrowaction').hide();}
			})

			$('#selectbutton').click(function(){
				var soption=$('#selectoption').val();
				readcheckbox(soption);
			})
		})
	})

	var sqlname=pullmysql('nameselect');
	$('#nameselect').html(sqlname);	
	addDatepicker();	

	$('#nameselect').change(function(){
		var namesel=$('#nameselect').val();
		var datesel=$('#startdateinput').val().length;
	})

	$('#listbutton').click(function(){
		//window.location.replace("../index.html.php");--REPLACE
	})

	function loadmainselectchange(){
		$('#mainselect').change(function(){
			var namesel=$('#nameselect').val();
			var datesel=$('#startdateinput').val().length;
			if(namesel!=='null' && datesel!==0){
				var count=$(this).val();
				var name=toProperCase($('#nameselect').val());
				var idate=$('#startdateinput').val();
				var html=
					"<div id='tablecluster2'><table cellspacing='1' cellpadding='2' id='timetablenest2' width='600'>" +
						"<thead>" + 
							"<tr>" + 
								"<th class='c1'>Name</th>" +
								"<th class='c2'>Start Date</th>" +
								"<th class='c3'>Task Category</th>" +
								"<th class='c4'>Task Detail</th>" +
								"<th class='c5'>Start Time</th>" +
								"<th class='c5'>End Time</th>" +
								"<th class='c6'>Duration</th>" +
							"</tr>" +
						"</thead>";
				var x=0
				for (x=0; x<count; x++){
					html=html +
						"<tbody>" +
							"<tr>" + 
								"<td class='c1'><input class='c1' id='name" + x + "' disabled='disabled' value='" + name + "'></input></td>" +
								"<td class='c2'><input disabled='disabled' class='c2' id='startdateinput" + x + "' value='" + idate + "'></input></td>" +
								"<td class='c3'><select class='c3select' id='taskcat" + x + "'></select></td>" +
								"<td class='c4'><input class='c4detail' id='taskdetail" + x + "'></input></td>" +
								"<td class='c5'><select class='c5time' id='start" + x + "'></select></td>" +
								"<td class='c5'><select id='end" + x + "' class='c5time'></select></td>" +
								"<td class='c6'><input class='c6' disabled='disabled' id='duration" + x + "'></input></td>" +
							"</tr>" +
						"</tbody>"
				}
				html=html + "</table><div id='formbuttons'></div></div>";
				$('#formtimetable').html(html);
				
				var tblselect=pullmysql('taskcatselect');
				$('.c3select').html(tblselect);
				tblselect=pullmysql('timeselect');
				$('.c5time').html(tblselect);	
				$('.cname').disabled = true;
				var buttonhtml=
					"<li class='item'><button id='submitcommand' type='button'>Submit</button><div id='warninglabel'>" +
					"</div></li>"
				$('#formbuttons').html(buttonhtml);
			
				$('#submitcommand').click(function(){
					var tblgetty = new Array(8);
					var t = 0;
					var istart='.';
					var iend='.';
					var tdetail='.';
					var taskcat='.';
					
					while(t<count){
						iduration=$('#duration'+t).val();
						tdetail=$('#taskdetail'+t).val();
						istart=$('#start'+t).val();
						iend=$('#end'+t).val()	
						taskcat=$('#taskcat'+t).val();
						if(tdetail==''||taskcat=='null'||istart=='null'||iend=='null'){
							$('#warninglabel').html('<label id="badsubmit">Please complete table before submitting</label>');
							return;
						}
						
						if(iduration=='NaN'){
							$('#warninglabel').html('<label id="badsubmit">Bad start end times please reenter</label>');
							return;
						}
						t++;
					}
					t=0;
					while(t<count){
				
						istart=timeconversion($('#start'+t).val());
						iend=timeconversion($('#end'+t).val());	
						tdetail=$('#taskdetail'+t).val();
						iduration=$('#duration'+t).val();
						taskcat=$('#taskcat'+t).val();
						
						tblgetty={arg:'addtimecard', 
						name:$('#name'+t).val(), 
						startdate:convertphpdate($('#startdateinput'+t).val()),
						taskcat:taskcat, 
						taskdet: tdetail,
						start:istart, 
						end:iend,
						duration:iduration};
						addmysql(tblgetty);
						t++;
					}
					$('#mainselect').change();
					$('#warninglabel').html('<label id="goodsubmit"> Submission complete</label>');
					
				})
				
				$('#logbutton').html('');
				$('#endinput').hide();
				$('#endlabel').hide();
				$('#mainalert').html('');
			}else{myhtml='Please enter date and name'
				$('#mainalert').html(myhtml);
			}
		});	
	}
	$('#timetable').on('change', '.c5time', function(){
		var timeid=event.target.id;
		var timeid=searchalpha(timeid);
		var idate=$('#startdateinput'+timeid.end).val();
		var atimeval=$('#start'+timeid.end).val();
		var ptimeval=$('#end'+timeid.end).val();
		if(atimeval!=='null'&&ptimeval!=='null'&&idate!=='null'){
			atimeval=idate+' '+atimeval;
			ptimeval=idate+' '+ptimeval;
			var duration=get_time_difference(atimeval, ptimeval);
				duration=duration.total/60;
				$('#duration'+timeid.end).val(duration);
		}
		if(timeid.beg=='end'){
			var nextstart=parseInt(timeid.end)+1;
			var prevend=$('#end'+timeid.end).val();
			$('#start'+nextstart).val(prevend);
		}
	})
	function convertphpdate(mydate){
		var myyear=mydate.slice(-2);
		var searchslash=mydate.indexOf('/', 3);
		mydate=mydate.substring(0,searchslash+1);
		mydate=mydate+myyear;
		return mydate;
	}	
	function timeconversion(mytime){
		var hours = Number(mytime.match(/^(\d+)/)[1]);
		var minutes = Number(mytime.match(/:(\d+)/)[1]);
		var AMPM = mytime.match(/\s(.*)$/)[1];
		if(AMPM == "PM" && hours<12) hours = hours+12;
		if(AMPM == "AM" && hours==12) hours = hours-12;
		var sHours = hours.toString();
		var sMinutes = minutes.toString();
		if(hours<10) sHours = "0" + sHours;
		if(minutes<10) sMinutes = "0" + sMinutes;
		newtime=sHours + ":" + sMinutes + ":00";
		return newtime;
	}	
	function poptimetable(){
		$('#timetablenest1').find('tr').each(function(){
			$(this).find('td').each(function(){
				$(this).find('select').each(function() {
					var select = $(this);
					var finderid = select.attr('id');
					var finderval = select.attr('value');
					$('#' + finderid).val(finderval);
				})
			})
		})
	}		
	function markcheckbox(){	
		$('#timetablenest1').find('tbody').each(function(){
			$(this).find('tr').each(function(){
				$(this).find('td').each(function(){
					$(this).find('input').each(function() {
						if($('#headchecker').prop('checked')){
							$(this).prop('checked', true);						
						}else{$(this).prop('checked', false);}
					})
				})
			})
		})
	}
	function readcheckbox(type){
		var w=0
		var selectedID='';				
		$('#timetablenest1').find('tbody').each(function(){
			$(this).find('tr').each(function(){
				$(this).find('td').each(function(){
					$(this).find('input').each(function(){
						if($(this).prop('checked')&&$(this).prop('class')=='itemchecker'){
								selectedID=$(this).prop('id');
								selectedID=new stringsplitter(selectedID, '-');
								changerowstatus(type, selectedID.midstr, selectedID.endstr);
						}else{}
					})
				})
			})
		})
		$('#showentriesbutton').click();
	}
	function stringsplitter(mystr, delim){
		var fdelim=mystr.indexOf(delim);
			this.frontstr=mystr.substring(0, fdelim);
			fdelim++;
		var ldelim=mystr.indexOf(delim, fdelim);
			this.midstr=mystr.substring(fdelim, ldelim);
		var strlength=mystr.length;
			ldelim++;
			this.endstr=mystr.substring(ldelim, strlength);
	}
		
	function changerowstatus(type, mID, tID){	
		var t=mID;
		var m=tID;
		var phparg='.';
		var mystatus='.';
		var istart='.';
		var iend='.';
		var tdetail='.';
		var checkapprov='.';
		switch (type){
			case 'delete':
				phparg='Deleted';
				mystatus='Inactive';
				break;
			case 'update':
				phparg='Updated';
				mystatus='Active';
				break;
			case 'close':
				phparg='Approved';
				mystatus='Active';
				break;
		}
		try {
			istart=timeconversion($('#start'+t).val());
			iend =timeconversion($('#end'+t).val());
			tdetail=$('#taskdetail'+t).val();
			tblgetty={arg:'timecardupdate', 
			name:$('#name'+t).val(), 
			startdate:convertphpdate($('#startdateinput'+t).val()),
			taskcat:$('#taskcat'+t).val(), 
			taskdet: tdetail,
			start:istart, 
			end:iend,
			duration:$('#duration'+t).val(),
			myID:t,
			taskID:m,
			status:phparg,
			type:mystatus};
				if (tdetail==''){
					$('#applydiv').html('<label id="applylabelbad">Incomplete Fields<label>');
					return;
				}else{
					checkapprov=addmysql(tblgetty);	
					if(checkapprov==''){
						$('#applydiv').html('<label id="applylabelgood">'+phparg+' Complete<label>');
					}else{
						$('#applydiv').html('<label id="applylabelgood">'+checkapprov+'<label>');
					}
				}
		} 
		catch(err){
			$('#applydiv').html('<label id="applylabelgood">Incomplete Fields<label>');
			return;
		}
	}	
	function pullmysql(a0, a1, a2, a3){
		var result='';
		var datastring={arg0: a0, arg1: a1, arg2: a2, arg3: a3}
		$.ajax({
			url: 'app_timecard/timecard_pull.html.php',
			type: 'POST',
			async: false,
			data: datastring,
			success: function(myecho){
				result=myecho;
			}
		});
		return result;
	} 
	function addmysql(a0){
		var result='';
		$.ajax({
			url: 'app_timecard/timecard_pull.html.php',
			type: 'POST',
			async: false,
			data: qtype,
			success: function(myecho){
				result=myecho;
			}
		});
		return result;
	}
	function reloadpage(){
		$('#startdateinput').hide();
		$('#nameselect').hide();
		$('#tasklabel').hide();
		$('#namelabel').hide();
		$('#datelabel').hide();
		$('#selectrowaction').hide();
		$('#exportbuttons').hide();
		$('#endinput').hide();
		$('#pdfpasser').hide();
		$('#miscbuttons').hide();
	}
})
