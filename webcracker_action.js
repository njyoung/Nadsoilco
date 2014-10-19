$(document).ready(function(){
	$('#timecardbutton').click(function(){
		var tablegetty={arg:'timecard'};
		$('#loader').load('index.html.php', tablegetty);
		$('#webcracker').hide();
	})
	$('#videosbutton').click(function(){
		var tablegetty={arg:'videos'};
		$('#loader').load('index.html.php', tablegetty);
		$('#webcracker').hide();
	})
	$('#reportsbutton').click(function(){
		var tablegetty={arg:'production'};
		$('#loader').load('index.html.php', tablegetty);
		$('#webcracker').hide();
	})
})