<!DOCTYPE HTML>

<title>MyUsernameGetter</title>

<head>

<script type="text/javascript" src="jquery-1.10.2.min.js"></script>
<script type="text/javascript" src="jquery.ajax-cross-origin.min.js"></script>

</head>

<html>

<body>

<script type="text/javascript">

$(document).ready(function(){
	
	$('#btn').click(function(){
		
		//var url='http://www.njydev.com/home.html.php';
		
		//$('#cross').load(url + ' #choicelabel');
		
		$.ajax({
			crossOrigin: true,
			url: 'http://code.jsontest.com/',
			success: function(data){
				$('#cross').html(data);
			}
		});

		
		
	})
	
	
})

/*
$.ajax({
crossOrigin: true,
url: 'http://localhost/nadsoilco/home.html.php',
success: function(data) {
$('#cross').html(data);
}
});
*/

</script>

<form>

<br>
<br>

<div id="cross"></div>

<button type="button" id="btn">clicky</button>
</form>

</body>

</html>

