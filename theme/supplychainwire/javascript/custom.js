require(['jquery'], function( $ ) {
    $(".block_scw_interviews").addClass("interview-blk");
    $(".block_scw_videos").addClass("video-blk");
    $(".block_scw_events").addClass("event-blk");
   
     $( "#profession" ).on('change', function() {
	   var v = $(this).find(":selected").val();
	   if(v=="recent-graduates"){
		  $("#industry-gp, #functionalarea-gp").fadeOut(500);
	   }else{
		  $("#industry-gp, #functionalarea-gp").fadeIn(500);
	   }
	 
    });
  
    $("#page-login-index form#login").submit(function(e){
		
		var cnt = 0;
		var email = $.trim($("#username").val());
		var password = $.trim($("#password").val());
		
		$("#id_error_username,#id_error_break_username,#id_error_password,#id_error_break_password").addClass("hide");
		
		if(email.length==0){
		  $("#id_error_username").html("Please enter the email").removeClass("hide");
		  $("#id_error_break_username").removeClass("hide");
		  cnt++;
		}else if(email.length > 0){
		  var vd = /[a-zA-Z0-9._-]+@[a-zA-Z0-9._-]+\.[a-zA-Z]{2,6}$/.test( email );
		  if(!vd){
			$("#id_error_username").html("Please enter the valid email").removeClass("hide");
			$("#id_error_break_username").removeClass("hide");
		    cnt++;  
		  }
		}
		
		if(password.length==0){
		  $("#id_error_password").html("Please enter the password").removeClass("hide");
		  $("#id_error_break_password").removeClass("hide");
		  cnt++;
		}
		
		if(cnt==0){
			return true;
		}
		
      return false; 
    });
	
	$("#page-login-index input#username").keyup(function(){
	    var email = $.trim($("#username").val());
		
		if(email.length==0){
		  $("#id_error_username").html("Please enter the email").removeClass("hide");
		  $("#id_error_break_username").removeClass("hide");
		}else if(email.length > 0){
		  var vd = /[a-zA-Z0-9._-]+@[a-zA-Z0-9._-]+\.[a-zA-Z]{2,6}$/.test( email );
		  if(!vd){
			$("#id_error_username").html("Please enter the valid email").removeClass("hide");
			$("#id_error_break_username").removeClass("hide");
		  }else{
			  $("#id_error_username,#id_error_break_username").addClass("hide");
		  }
		}
	 
	 });
	 
	 $("#page-login-index input#password").keyup(function(){
        var password = $.trim($("#password").val());
		if(password.length==0){
		  $("#id_error_password").html("Please enter the password").removeClass("hide");
		  $("#id_error_break_password").removeClass("hide");
		}else{
			$("#id_error_password,#id_error_break_password").addClass("hide");
		}
     });
	 
	 $('#profession').on('change', function(){
		 var prof = $(this).val();
		 
		if($(this).val()==2 || $(this).val()==3 ){
			$('#cmbcountry,#cmbindustry,#cmbfarea,#search_name').val("");
		}
		if($(this).val()==""){
			  $('#industry-gp,#functionalarea-gp,#country-gp').show(100);
			  $('#name-gp').hide();
		}
		
		 if(prof==1){
			  $('#industry-gp,#functionalarea-gp,#country-gp').show(100);
			  $('#name-gp').hide();
		 }
		 if(prof==2){
			 $('#industry-gp,#functionalarea-gp,#name-gp').hide();
			 $('#country-gp').show();
		 }if(prof==3){
			 $('#industry-gp,#functionalarea-gp,#country-gp').hide();
			  $('#name-gp').show();
		 }
	 });	
	 
	
	 
	 $("#page-login-forgot_password input#id_submitbuttonemail").addClass("btn").addClass("btn-brown");
	 $("#page-login-forgot_password input#id_submitbutton").addClass("btn").addClass("btn-brown");
	 
	 var mailUrl = M.cfg.wwwroot+'/local/scwmail/refresh_mail.php';
	 var MylinkURL = M.cfg.wwwroot+'/local/mylinks/refresh_link.php';
	 
	  function refresh_mod(){
		  $('#promailbox').load(mailUrl, function(data){
			  if(data=="loggedout"){
				  location.reload();
			  }
		  });
		  $('#promylink').load(MylinkURL, function(data){
			  if(data=="loggedout"){
				  location.reload();
			  }			  
		  });
	  }
	
	  refresh_mod(); // This will run on page load
	  setInterval(function(){
		  refresh_mod() // this will run after every 10 seconds
	  }, 10000);
	  

/*   $(".video-blk-contnt .bgvideo").click(function(){
    var vid = $(".video-blk-contnt .bgvideo").attr("data-id") || "";
    if(vid!=""){
      var vurl = M.cfg.wwwroot+'/local/scwvideos/view.php?id='+vid;
	  $(location).attr("href",vurl);
    }
  });*/
   
});

