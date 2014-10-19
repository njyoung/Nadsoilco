$(document).ready(function(){

var html= 
	"<option></option>" +
	"<option>Name</option>" +
	"<option>Task Categories</option>"
$('#mainselect').html(html);
	
$('#mainselect').change(function(){
	var pully=''
	switch ($('#mainselect').val()){
		case 'Name':
			pully='nameselect';
			break;
		case 'Task Categories':
			pully='taskcat';
			break;
		default:
			break;
	}
	var pulltable='<table id="maintable">';
	pulltable=pulltable + phpcaller('dictionarytable', pully);
	pulltable=pulltable + '</table>';
	$('#maingrid').html(pulltable);
	
	$('.gridbutton1').click(function(){
		var myid=this.id;
		myid=searchalpha(myid);
		myid=myid.end;
		var myval=document.getElementById(myid).value;
		if (myval){ 
			phpcaller('updateoptions', myval, myid);
		}else{phpcaller('deleteoptions',myval, myid);}
		$('#mainselect').change();
	})
	$('#addcommand').click(function(){
		if($('#addinput').val()){
			var addcat=$('#mainselect').val();
			switch (addcat){
				case 'Task Categories':
					addcat='taskcat';
					break;
				case 'Name':
					addcat='nameselect';
					break;
				default:	
					addcat='';
					break;
			}
			var addval=$('#addinput').val();
			phpcaller('insert_dictionary',addval, addcat);
			$('#mainselect').change();
		}else{console.log('omg-->its null');}
	})
})

function phpcaller(a0, a1, a2){
	var result = '';
	var datastring = {arg0: a0, arg1: a1, arg2: a2}
	$.ajax({
		url: 'app_dictionary/dictionary_pull.html.php',
		type: 'POST',
		async: false,
		data: datastring,
		success: function(myecho){
			result = myecho;
		}
	});
	return result;
}


})