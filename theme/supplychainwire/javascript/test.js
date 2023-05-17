$(function(){
	
$(".block_scw_interviews").addClass("interview-blk");
$(".block_scw_videos").addClass("video-blk");
$(".block_scw_events").addClass("event-blk");
//$("#profession").val("recent-graduates");

  $( "#profession" ).on('change', function() {
    //var v = $(this).text();
	 var v = jQuery(this).find(":selected").val();
	 alert(v);
  });

});