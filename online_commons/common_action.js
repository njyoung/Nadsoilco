function toProperCase(s){
	  return s.toLowerCase().replace(/^(.)|\s(.)/g, 
			  function($1) { return $1.toUpperCase(); });
}
		
function searchalpha(str){
	var rightstr=0;
	var x=0;
	while($.isNumeric(rightstr)==true){
		x=x + 1;
		rightstr=str.slice(-x);
	}
	//console.log(str.slice(-x+1));
	//console.log(str.substr(0,str.length-x+1));
	var slicey=new Object();
	slicey.end=str.slice(-x+1);
	slicey.beg=str.substr(0, str.length-x+1);
	return slicey;
}

function get_time_difference(start,end){               
	start=new Date(start);
	end=new Date(end);
	var diff=end.getTime() - start.getTime();                 
	var time_difference=new Object();

	time_difference.hours=Math.floor(diff/1000/60/60);        
	diff -= time_difference.hours*1000*60*60;
	if(time_difference.hours < 10) time_difference.hours="0" + time_difference.hours;

	time_difference.minutes=Math.floor(diff/1000/60);     
	diff -= time_difference.minutes*1000*60;    
	if(time_difference.minutes < 10) time_difference.minutes="0" + time_difference.minutes;                                  
	
	time_difference.total=(+time_difference.hours*60)+ +time_difference.minutes;
	return time_difference;              
}

//Begin formatting and adding drop down to time card table
function addDatepicker(){
	$('#startdateinput').datepicker({
		inline: true,
		showOtherMonths: true,
		dayNamesMin: ['Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat'],
	});
	$('#endateinput').datepicker({
		inline: true,
		showOtherMonths: true,
		dayNamesMin: ['Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat'],
	});
};




