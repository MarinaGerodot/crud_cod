$(document).ready(function(){
	// $(document).ready() is executed after the page DOM id loaded
		// Binding an listener to the submit event on the form:
		$('#form').submit(function(e){
		
			// If a previous submit is in progress:
			if($('#submit').hasClass('active')) return false;
		
			// Adding the active class to the button. Will show the preloader gif:
			$('#submit').addClass('active');
		
			// Removing the current error tooltips
			$('.errorTip').remove();

			var url = $('#form').attr('action');
			var data = $('#form').serialize()+'&fromAjax=1';
			var redirURL1 = 'http://localhost/crud_cod/index.php/shop/index';
			var redirURL2 = 'http://localhost/crud_cod/index.php/ajax/login_form';
			$.ajax({
    			type: 'POST',
				dataType : 'json', 
    			url: url,
    			data: data,
    			beforeSend: function(response) {

					$('#form').submit.disabled = true;
    			},
    			success: function(response) { 

					if(response.status)
					{
						if(response.redirectURL == redirURL1)
						{
							location.replace(response.redirectURL);
							$('#submit').removeClass('active');
						}
						if(response.redirectURL == redirURL2)
						{							
							$('#message_enter').html('<h3><font color = #ff0000>Invalid name and/or password!</font></h3>');	
							$('#submit').removeClass('active');
						}
							
					}else {

						$('input[type!=submit]').each(function(){
							var elem = $(this);
							var id = elem.attr('id');
					
							if(response[id])
								showTooltip(elem,response[id]);
						});
						
						$('#submit').removeClass('active');	
					}			
    			},
    			complete: function(response) {

					$('#form').removeAttr("disabled");

    			},
			}); 

			e.preventDefault();
			$(window).resize();
	
		});

	});
// Centering the form vertically on every window resize:
$(window).resize(function(){
	var cf = $('#carbonForm');
	
	$('#carbonForm').css('margin-top',($(window).height()-cf.outerHeight())/22)
});

// Helper function that creates an error tooltip:
function showTooltip(elem,txt)
{
	// elem is the text box, txt is the error text
	$('<div class="errorTip">').html(txt).appendTo(elem.closest('.form-group'));
}