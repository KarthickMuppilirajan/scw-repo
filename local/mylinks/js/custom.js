require(['jquery'], function( $ ) {
	$('.connect').on('click', function() {
		$this= $(this);
		$this.html('Sending..');
		var connecter_id= $(this).data('userid');
		var connected_id= $(this).data('connected_id');
		var action = $(this).data('action');
		var pdata= { 
			'connecter_id': connecter_id,
			'connected_id': connected_id,
			'action': action
		};
		$.ajax({
				url: 'connect.php', 
				type: "POST",
				data: pdata,
				dataType: "json",
				success : function(res){
					console.log($this);
					if(res.message=="sent"){
						$this.css('pointer-events', 'none');
						$this.addClass('disabled').html('Request sent');
					}else{
						$this.removeAttr('data-action');
						$this.css('pointer-events', 'none');
						$this.addClass('disabled').html('Connected');
						 setTimeout(function(){
							location.reload();
						}, 500);

					}
				}
			})
	});
	
	$('#search_form #reset').on('click', function(){
		$('#profession,#cmbcountry,#cmbindustry,#cmbfarea,#search_name').val("");
	});
		
});