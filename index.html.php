<!DOCTYPE HTML>
<!--this is a test...-->

<?php 

$authen = 'true';

//Sharepoint authentication
if(isset($_SERVER['HTTP_REFERER'])){

	$mybrowser=$_SERVER['HTTP_USER_AGENT'];
	$mycheck = preg_match('/Chrome/i', $mybrowser);
	$checky = $_SERVER['HTTP_REFERER'];

	if($mycheck!=1){
		echo '<h3>Please use Google Chrome to Access this page.</h3>' ;
		return;
	}

	if($checky=='http://nadsoilco.sp.ex4.secureserver.net/Lists/Work%20Calendar%20NEW/AllItems.aspx'){
		include "app_timecard/timecard_home.html.php";
		return;
	}

	if($checky=='http://nadsoilco.sp.ex4.secureserver.net/Video%20Tutorials/Forms/AllItems.aspx'){
		include "app_video/videos_home.html.php";
		return;
	} 
	
	if($checky=='http://nadsoilco.sp.ex4.secureserver.net/Production/Lists/Production%20Reporting%20App/AllItems.aspx'){
		include "app_production/production_home.html.php";
		return;
	} 

}else{}

//Dictionary redirect
if(isset($_POST['redirect'])){
	if($_POST['redirect']=='home'){
		include "app_timecard/timecard_home.html.php";
		return;
	}
	if($_POST['redirect']=='dictionary'){
		include "app_dictionary/dictionary_home.html.php";
		return;
	}	
}else{}

//Webcracker authentication
if(isset($_POST['arg'])){
	if($_POST['arg']=='timecard'){
		include "app_timecard/timecard_home.html.php";
		return;
	}
	if($_POST['arg']=='videos'){
		include "app_video/videos_home.html.php";
		return;
	}
	if($_POST['arg']=='production'){
		include "app_production/production_home.html.php";
		return;
	}
}else{
	echo 'Access denied';
	return;
}

?>