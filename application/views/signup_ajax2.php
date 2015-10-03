<?php
/*
___________________________________________________

project : crud
file	: signup_ajax2.php
author	: kozlova Marina.
date	: 22.07.2015
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
	$('#signupForm').submit(function(e){

		// If a previous submit is in progress:
		if($('#submit').hasClass('active')) return false;
		
		// Adding the active class to the button. Will show the preloader gif:
		$('#submit').addClass('active');
		
		// Removing the current error tooltips
		$('.errorTip').remove();
		
		// Issuing a POST ajax request to submit.php (the action attribute of the form):
		$.post($('#signupForm').attr('action'),$('#signupForm').serialize()+'&fromAjax=1',function(response){
			
			if(!response.status)
			{
				// Some kind of input error occured
				
				// Looping through all the input text boxes,
				// and checking whether they produced an error
				$('input[type!=submit]').each(function(){
					var elem = $(this);
					var id = elem.attr('id');
					
					if(response[id])
						showTooltip(elem,response[id]);
				});
			}
			else location.replace(response.redirectURL);
			
			$('#submit').removeClass('active');
		},'json');
		
		e.preventDefault();
	});
	
	$(window).resize();
});
// Centering the form vertically on every window resize:
$(window).resize(function(){
	var cf = $('#carbonForm');
	
	$('#carbonForm').css('margin-top',($(window).height()-cf.outerHeight())/3)
});

// Helper function that creates an error tooltip:
function showTooltip(elem,txt)
{
	// elem is the text box, txt is the error text
	$('<div class="errorTip">').html(txt).appendTo(elem.closest('.form-group'));
}

</script>     
<style>
            
.errorTip {

font-color: #ff0000;
	
}
</style>       

<div id="carbonForm" align="left">
<?php $attributes = array('id' => 'signupForm', 'novalidate' => 'novalidate');
	  echo form_open('ajax/ajax_check/', $attributes);?>

			<h3>REGISTER INFORMATION</h3><br/> 

 	<div class="form-group">
		<div class="col-sm-4" style="float: none; padding-left: 0px">
          <label class="col-sm-1 control-label required" for="user_username" style="float: none; padding-left: 0px" >Name</label>
            <input type="text" name="username" id="username" class="form-control" value="<?php echo set_value('username'); ?>"/>			
					<span class="help-block"> </span>
              
		</div>
    </div>
	
	<div class="form-group">
		<div class="col-sm-4" style="float: none; padding-left: 0px">
            <label class="col-sm-1 control-label required" for="user_email" style="float: none; padding-left: 0px">Email</label>
					<input type="text" name="email" id="email" class="form-control" value="<?php echo set_value('email'); ?>"/>					
					<span class="help-block"> </span>
               
		</div>
    </div>			


 	<div class="form-group">
		<div class="col-sm-4" style="float: none; padding-left: 0px">
         <label class="col-sm-1 control-label required" for="user_password" style="float: none; padding-left: 0px">Password</label>
					<input type="password" name="password" id="password" class="form-control" value="<?php echo set_value('password'); ?>"/>				
					<span class="help-block"></span>
            	
		</div>
    </div>
	
<br/>	

	<div class="form-group">
		<div class="col-md-5 center-block" style="padding-left: 0px">
            <button type="submit" name="submit" id="submit" class="btn btn-primary btn-success left-block">Register</button>
     	</div>
	</div>
<?php echo form_close();?>
</div>		
	
</br></br>
      <div align="left">
          <br/>
                <a href="javascript:history.back()">COME BACK</a>
      </div>

             
</div>				

<?php require_once('footer.php'); ?>



