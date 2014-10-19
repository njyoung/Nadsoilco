$(document).ready(function(){

	$('#choiceselect').change(function(){
		switch ($('#choiceselect').val()){
			case 'View Video':
				var sizechecker=0;
				var vidwidth=100;
				var vidheight=100;
				var myhtml = '<button class="showlogbutton" id="showvideobutton" type="button">Show Video</button>'		
				$('#videologbutton').html(myhtml);
				myhtml = '<select name="videoselect" id="videoselect" class="c0sdrop"></select>';
				$('#videoselectmain').html(myhtml);
				myhtml = '<label id="videolog">(2) Videos</label>';
				$('#videoselectlabel').html(myhtml);
				$('#videoselect').show();
				$('#videolog').show();
				$('#videologbutton').show();
				$('#videodiv').html('');
				$('#videodiv').show();
				$('#videotable').html('');
				$('#videotable').hide();
				loadvideonames();
				break;
			case 'Add Video':
				loadmainselectchange();
				$('#videoselect').hide();
				$('#videolog').hide();
				$('#videologbutton').hide();
				$('#videodiv').html('');
				$('#videodiv').hide();
				$('#videotable').show();
				break;
		}
		
		$('#videoselect').change(function(){
			sizechecker=0;
		})

		$('#showvideobutton').click(function(){
			var np=$('#videoselect').val();
			if(np!='null'){			
				if (sizechecker>2){sizechecker=0};
				console.log(sizechecker);
				switch (sizechecker){
					case 0:
						vidwidth = 635;
						break;
					case 1:
						vidwidth = 835;
						break;
					case 2:
						vidwidth = 1035;
						break;
				}
				sizechecker++;
				vidheight = vidwidth * 0.562587904360056;
				console.log(vidwidth);
				var myvideoembed=loadvideoembed(np);
				var videohtml='<iframe width="' + vidwidth + '" height="' + vidheight + '" src="' +
					myvideoembed + '?rel=0" frameborder="0" allowfullscreen></iframe>';
				$('#videodiv').html(videohtml);
			}else{$('#videodiv').html('')};
			
		})
	})
	function loadvideoembed(namepass){
			var videoembed=pullmysql('videoembedselect', namepass);
			return videoembed;
	}
	function loadvideonames(){
		var videonames=pullmysql('videonameselect');
		$('#videoselect').html(videonames);
	}
	function loadmainselectchange(){
		var pulltable='<table id="maintable">';
		pulltable=pulltable + pullmysql('videotable');
		pulltable=pulltable + '</table>';
		$('#videotable').html(pulltable);

		$('.gridbutton1').click(function(){
			var myid=this.id;
			myid=searchalpha(myid);
			myid=myid.end;
			var myval1=document.getElementById('v1-' + myid).value;
			var myval3=document.getElementById('v3-' + myid).value;
			if (myval1 && myval3){
				pullmysql('updatevideo', myval1, myval3, myid);
			}else{pullmysql('deletevideo', myid);}
			loadmainselectchange();
		})
		$('#addcommand').click(function(){
			if($('#addinput1').val() && $('#addinput2').val()){
				var a1=$('#addinput1').val();
				var a2=$('#addinput2').val();
				
				var addval=$('#addinput').val();
				pullmysql('insert_video',a1, a2);	
				loadmainselectchange();
			}else{console.log('omg-->its null');}
			
		})	
	}
	
	function pullmysql(a0, a1, a2, a3){
		var result='';
		var datastring={arg0: a0, arg1: a1, arg2: a2, arg3: a3}
		$.ajax({
			url: 'app_video/videos_pull.html.php',
			type: 'POST',
			async: false,
			data: datastring,
			success: function(myecho){
				result=myecho;
			}
		});
		return result;
	} 
	
})




