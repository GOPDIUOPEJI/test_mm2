jQuery(function($){
	
	if($('body').hasClass('blog')){
		$('.blog .add-bookmark').each(remove_wrong_bookmarks);
	} else {
		$('.single .add-bookmark').each(remove_wrong_bookmarks);
	}
	

	function remove_wrong_bookmarks(key, title){
		if(!$(title).closest('.post')[0]){
			$(title).remove();
			return;
		}
		if($(title).closest('h2')[0]){
			$(title).parent().parent().append(title);
			return;
		}
		if($(title).closest('h1')[0]){
			$(title).parent().append(title);
			return;
		} else {
			$(title).remove();
			return;
		}
	}
	$('.add-bookmark').on('click', initiate_bookmark);

	function initiate_bookmark() {
		var data = parseInt($(this).attr('data-post-id'), 10);
		var form_data = new FormData();
		form_data.append('action', 'add_to_bookmark');
		form_data.append('post-id', data);
		var object = this;		

		$.ajax({
		  type: "POST",
		  url: frontendajax.ajaxurl,
		  data: form_data,
		  contentType: false,
    	  processData: false,
    	  success: function(response){
    	  	response = jQuery.parseJSON(response);
    	  	if(response.status == 1){
    	  		$(object).addClass('added');
    	  	} else {
    	  		if($(object).hasClass('added')){
    	  			$(object).removeClass('added');
    	  		}
    	  	}
    	  },
    	  error: function(err_msg){
    	  	console.log(err_msg);
    	  }
		});
	}
});