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

	$('.add-bookmark').on('click', function(){
		initiate_bookmark(this);
	});

	function initiate_bookmark(object) {
		var data = parseInt($(object).attr('data-post-id'), 10);
		var form_data = new FormData();
		form_data.append('action', 'add_to_bookmark');
		form_data.append('post-id', data);

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

	$('.wp-admin #Bookmarks .remove-bookmark').on('click', function() {
		if($(this).parent().hasClass('removed') && $(this).hasClass('fa-plus')){
			initiate_bookmark(this);
			$(this).parent().removeClass('removed');
			$(this).removeClass('fa-plus');
    	  	$(this).addClass('fa-times');
    	  	return;
		} else {
			var data = parseInt($(this).attr('data-post-id'), 10);
			var form_data = new FormData();
			form_data.append('action', 'remove_bookmark');
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
	    	  		$(object).parent().addClass('removed');
	    	  		$(object).removeClass('fa-times');
	    	  		$(object).addClass('fa-plus');
	    	  	}
	    	  },
	    	  error: function(err_msg){
	    	  	console.log(err_msg);
	    	  }
			});
		}
		
	});
});