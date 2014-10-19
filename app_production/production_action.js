$(document).ready(function(){
	pageloader()
	$('#reportbutton').click(function(){
		var reportype = $('#outputype').val();
		reportype = "report"; //remove later
		console.log(reportype);
		var htmlreturn = phpcaller(reportype);
		$('#reportoutputs').html(htmlreturn);
		$('#inputs').hide();
	})
	
	$('#outputype').change(function(){
		var outputype = $('#outputype').val();
		if(outputype=='table'){
			$('#reportnamelabel').html('Table Name:'); 
			$('#reportypelabel').html('Table Type:');
		}else{
			$('#reportnamelabel').html('Report Name:');
			$('#reportypelabel').html('Report Type:');
		}
	})
	
	$('#datequeryselect').change(function(){
		var datequery = $('#datequeryselect').val();
		switch (datequery){
			case 'Date Month':
				$('#datemonthrow').show();
				$('#reportbutton').show();
				var datemonthoption = phpcaller('datemonth');
				$('#datemonth').html(datemonthoption);
				$('#daterangerow1').hide();
				$('#daterangerow2').hide();
				break;
			case 'Date Range':
				$('#daterangerow1').show();
				$('#daterangerow2').show();
				$('#reportbutton').show();
				$('#datemonthrow').hide();
				addDatepicker(); 
				break;
		}
	})
	
	$('#reportype').change(function(){
		var reportype = $('#reportype').val();
		$('#itemtypelabel').html(reportype + ':');
		switch (reportype){
			case 'Tank ID':
				reportype = 'TankID';
				break;
			case 'Tank Battery':
				reportype = 'TankBattery';
				break;
		}
		console.log(reportype);
		var itempull = phpcaller('itemtype', reportype);
		$('#itemtypeselect').html(itempull);
	})
	
	$('#itemtypeselect').change(function(){
		var datequeryhtml=
			'<option></option>' +
			'<option>Date Month</option>' + 
			'<option>Date Range</option>';
		$('#datequeryselect').html(datequeryhtml);
	})
	$('#reportname').change(function(){
		var prodpull = phpcaller('reportype', 'Production');
		$('#reportype').html(prodpull);
	})    

	function phpcaller(a0, a1){
		var result = '';
		var datastring = {arg0: a0, arg1: a1}
		$.ajax({
			url: 'app_production/production_pull.html.php',
			type: 'POST',
			async: false,
			data: datastring,
			success: function(myecho){
				result = myecho;			
			}
		});
		return result;
	}
	
	//Page load actions
	
	function pageloader(){
		$('#datemonthrow').hide();
		$('#daterangerow1').hide();
		$('#daterangerow2').hide();
		$('#reportbutton').hide();
	}
})