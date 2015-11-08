$(document).ready(function(){
	// $(document).ready() is executed after the page DOM id loaded
	
		// Binding an listener to the submit event on the form:
		$('#signupForm').submit(function(e){
	
			// If a previous submit is in progress:
			if($('#submit').hasClass('active')) return false;
		
			// Adding the active class to the button. Will show the preloader gif:
			$('#submit').addClass('active');
		
			// Removing the current error tooltips
			$('.errorTip').remove();
		
			console.log("execut 1");
			var url = $('#signupForm').attr('action');
			var data = $('#signupForm').serialize()+'&fromAjax=1';

			$.ajax({
    			type: 'POST',
				dataType : 'json', 
    			url: url,
    			data: data,
    			beforeSend: function(response) {
			
					//console.log("execut beforeSend");
					$('#signupForm').submit.disabled = true;
    			},
    			success: function(response) { 

					if(response.status)
					{ 
                    	location.replace(response.redirectURL);
		
						$('#submit').removeClass('active');	
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

					$('#signupForm').removeAttr("disabled");
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