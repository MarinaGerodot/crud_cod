 $(document).ready(function() {
			
	        $("form#addProductForm").submit(function(e) {
			var url = $('#addProductForm').attr('action');

			$('.errorTip').remove();	
			
            var formData = new FormData($(this)[0]);
            $.ajax({
                url: url,
                type: 'POST',
                data: formData,
                async: false,
                success: function(data) {
				
					var responseData = jQuery.parseJSON(data);

                    	if(responseData.status)
						{	
 	                  		location.replace(responseData.redirectURL);		
							$('#submit').removeClass('active');	
							
						}else {

							$('input[type!=submit]').each(function(){
							var elem = $(this);
							var id = elem.attr('id');
					
							if(responseData[id])
								showTooltip(elem,responseData[id]);
							});
							$('#submit').removeClass('active');	
						}			
								
						$('#submit').removeClass('active');
                },
				error: function(data){
				
                	console.log("error");
                },
                contentType: false,
                processData: false
            });
			
			e.preventDefault();
			$(window).resize();	
        });

    });
	
// Centering the form vertically on every window resize:
$(window).resize(function(){
	var cf = $('#productForm');
	
	$('#productForm').css('margin-top',($(window).height()-cf.outerHeight())/22)
});	
	
// Helper function that creates an error tooltip:
function showTooltip(elem,txt)
{
	// elem is the text box, txt is the error text
	$('<div class="errorTip">').html(txt).appendTo(elem.closest('.form-group'));
}