<?php
/*
___________________________________________________

project : crud
file	: signup_ajax.php
author	: kozlova Marina.
date	: 22.07.2015
___________________________________________________

*/
// 'onsubmit' => 'return ajaxSubmit();'
//'onsubmit' => 'return submitForm(this);'
//$('#signupForm').submit.disabled = true;
require_once('header.php');
?>
<body>
<div class="container"> 

<div id="carbonForm" align="left">

<?php $attributes = array('id' => 'signupForm', 'novalidate' => 'novalidate' );
	  echo form_open('ajax/ajax_register/', $attributes);?>

			<h3>REGISTER INFORMATION</h3><br/> 

 	<div class="form-group">
		<div class="col-sm-4" style="float: none; padding-left: 0px">
          <label class="col-sm-1 control-label required" for="username" style="float: none; padding-left: 0px" >Name</label>
            <input type="text" name="username" id="username" class="form-control" value=""/>			
					<span class="help-block"> </span>
              
		</div>
    </div>
	
	<div class="form-group">
		<div class="col-sm-4" style="float: none; padding-left: 0px">
            <label class="col-sm-1 control-label required" for="email" style="float: none; padding-left: 0px">Email</label>
					<input type="text" name="email" id="email" class="form-control" value=""/>					
					<span class="help-block"> </span>
               
		</div>
    </div>			


 	<div class="form-group">
		<div class="col-sm-4" style="float: none; padding-left: 0px">
         <label class="col-sm-1 control-label required" for="password" style="float: none; padding-left: 0px">Password</label>
					<input type="password" name="password" id="password" class="form-control" value=""/>				
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
                <a href="<?php echo base_url(). 'index.php/shop/index';?>">COME BACK</a>
      </div>
             
</div>				

<?php require_once('footer.php'); ?>



