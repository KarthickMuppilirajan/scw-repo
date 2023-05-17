require(['jquery'], function( $ ) {
	 $('.delete_mail').on('change', function(){
	  if ($(".delete_mail:checked").length) {
				$(".mailbox .message_id").prop("checked", true);
			} else {
				  $(".mailbox .message_id").prop("checked", false);
		}
	 });
	 
	$('.btn-delete').on('click',function(){ 
	 var checkedVals = $('.mailbox .message_id:checkbox:checked').map(function() {
				return this.value;
			}).get();
			
			if(checkedVals==""){
				alert('Atleast check one mail item to delete');
			}
		else{	
		var result = confirm("Are you sure to delete this?");	
			if (result) {
					$('.delete_msg_id').val(checkedVals);
					$("#msg_delete").submit();
			}
		}
	});
	
	$('.delete-view').on('click',function(){ 
	 var checkedVals = $('.delete_msg_id').val();
			
			if(checkedVals==""){
				alert('Atleast check one mail item to delete');
			}
		else{	
		var result = confirm("Are you sure to delete this?");	
			if (result) {
					$('.delete_msg_id').val(checkedVals);
					$("#msg_delete").submit();
			}
		}
	});
});