$(document).ready(function($) {
	$('#check_my_links').on('click', function(){

		$(this).attr('disabled', true)	
	    $('.hidy2').show();
    	$('._mess').show();
	    $('.hidy').hide();
        $('.edit-row').attr('disabled', true)
        $('.btn-delete').attr('disabled', true)
        $('.add-btn').attr('disabled', true)
        $('input[name=checky]').attr('disabled', true)
		
		let options = $('input[name=checky]:checked').val() ? $('input[name=checky]:checked').val() : ''

		$.ajax({
		  url: base_url + 'api/scripts/check_user_links/' + $(this).data('user_id') + '/' + options,
		  type: 'POST',
		  data: {},
		  success: function (result, textStatus, xhr) {

      	    $(this).removeAttr('disabled')
	        $('.hidy3').show();
	        $('.hidy2').hide();
	        $('._mess').hide();
		    
		    if(xhr.status == 200){
		      window.location.replace(base_url + 'cms/link_builds');
		    }else{
		      console.log(result)
		    }

		  },
		  error: function(err){
		    console.error(err);
		  }
		});

	})	
});