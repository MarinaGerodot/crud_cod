<?php
/*
___________________________________________________

project : crud
file	: add_product_ajax.php
author	: kozlova Marina.
date	: 02.10.2015
___________________________________________________

*/
require_once('header.php');
?>
<body>
<div class="container">   
     
<script type="application/javascript">


	$(document).ready(function(){
	// $(document).ready() is executed after the page DOM id loaded
	
		// Binding an listener to the submit event on the form:
		$('#addProductForm').submit(function(e){
	
			// If a previous submit is in progress:
			if($('#submit').hasClass('active')) return false;
		
			// Adding the active class to the button. Will show the preloader gif:
			$('#submit').addClass('active');
		
			// Removing the current error tooltips
			$('.errorTip').remove();
		
			console.log("execut 1");
			var url = $('#addProductForm').attr('action');
			//var data = $('#addProductForm').serialize()+'&fromAjax=1';
			var formData = new FormData(this);

			$.ajax({
    			type: 'POST',
				dataType : 'json', 
    			url: url,
    			data: formData,
				processData: false,
    			beforeSend: function(response) {

					$('#addProductForm').submit.disabled = true;
    			},
    			success: function(response) { 
					
					if(response.status)
					{ 
                    	location.replace(response.redirectURL);
						console.log("execut success");			
						$('#submit').removeClass('active');	
					}else {
					
						console.log("execut error");
				
						$('input[type!=submit]').each(function(){
							var elem = $(this);
							var id = elem.attr('id');
					
							if(response[id])
								showTooltip(elem,response[id]);
						});
						$('#submit').removeClass('active');
					}			
    			},
				error: function(data){
                console.log("error");
            	},
    			complete: function(response) {
        		
					$('#addProductForm').removeAttr("disabled");
					//console.log("execut complete");
    			},
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

</script>     

       
<div id="productForm" align="left">
<br/>
<br/><br/>

<?php $attributes = array('id' => 'addProductForm', 'novalidate' => 'novalidate', 'enctype' => 'multipart/form-data');
	  echo form_open('ajax/ajax_add_product/', $attributes);?>

	<h3>NEW PRODUCT</h3><br/> 

 	<div class="form-group">
		<div class="col-sm-4" style="float: none; padding-left: 0px">
          <label class="col-sm-1 control-label required" for="Pproduct_title" style="float: none; padding-left: 0px" >Title</label>
            <input type="text" name="title" id="title" class="form-control" value="<?php echo set_value('title'); ?>"/>
			<font color = #ff0000><?php echo form_error('title');?></font>
					<span class="help-block"> </span>
              
		</div>
    </div>
	
	<div class="form-group">
		<div class="col-sm-4" style="float: none; padding-left: 0px">
            <label class="col-sm-1 control-label required" for="product_description" style="float: none; padding-left: 0px">Description</label>
					<input type="text" name="description" id="description" class="form-control" value="<?php echo set_value('description'); ?>"/>
					<font color = #ff0000><?php echo form_error('description');?></font>
					<span class="help-block"> </span>
               
		</div>
    </div>			


 	<div class="form-group">
		<div class="col-sm-4" style="float: none; padding-left: 0px">
		
         <label class="col-sm-1 control-label required" for="product_photo" style="float: none; padding-left: 0px">Photo</label>
					<input type="file" name="photo_file" id="photo_file" accept="image/jpeg,image/gif,image/x-png" value="<?php echo set_value('photo_file'); ?>"/>
					<font color = #ff0000><?php  if ($error_upload) { echo $error_upload; } ?></font>
		</div>
    </div>
	<br/>
	<div class="form-group">
		<div class="col-sm-10" style="float: none; padding-left: 0px">
		 <label class="col-sm-1 control-label required" for="product_photo" style="float: none; padding-left: 0px">Category</label>
		 
         	<?php echo form_dropdown('category', $select_category, '1'); ?>
			
		</div>
    </div>
	
<br/><br/>	

	<div class="form-group">
		<div class="col-md-5 center-block" style="padding-left: 0px">
            <button type="submit" class="btn btn-primary btn-success left-block"> Add </button>
     	</div>
	</div>
<?php echo form_close();?>
	
	
	

</br></br>
      <div align="left">
          <br/><br/><br/>
                <a href="javascript:history.back()">COME BACK</a>
      </div>

               
	</div>
</div>				

<?php require_once('footer.php'); ?>



