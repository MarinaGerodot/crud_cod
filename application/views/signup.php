<?php
/*
___________________________________________________

project : crud
file	: signup.php
author	: kozlova Marina.
date	: 22.07.2015
___________________________________________________

*/
require_once('header.php');
?>
<body>
<div class="container">   
     
       
<div align="left">
<br/>

       <!--<h3>REGISTER INFORMATION</h3>-->

<br/><br/>

<?php $attributes = array('novalidate' => 'novalidate');
	  echo form_open('user/register/', $attributes);?>


	<h3>REGISTER INFORMATION</h3><br/> 

 	<div class="form-group">
		<div class="col-sm-4" style="float: none; padding-left: 0px">
          <label class="col-sm-1 control-label required" for="user_username" style="float: none; padding-left: 0px" >Name</label>
            <input type="text" name="username" class="form-control" value="<?php echo set_value('username'); ?>"/>
			<font color = #ff0000><?php echo form_error('username');?></font>
					<span class="help-block"> </span>
              
		</div>
    </div>
	
	<div class="form-group">
		<div class="col-sm-4" style="float: none; padding-left: 0px">
            <label class="col-sm-1 control-label required" for="user_email" style="float: none; padding-left: 0px">Email</label>
					<input type="text" name="email" class="form-control" value="<?php echo set_value('email'); ?>"/>
					<font color = #ff0000><?php echo form_error('email');?></font>
					<span class="help-block"> </span>
               
		</div>
    </div>			


 	<div class="form-group">
		<div class="col-sm-4" style="float: none; padding-left: 0px">
         <label class="col-sm-1 control-label required" for="user_password" style="float: none; padding-left: 0px">Password</label>
					<input type="password" name="password" class="form-control" value="<?php echo set_value('password'); ?>"/>
					<font color = #ff0000><?php echo form_error('password');?></font>
					<span class="help-block"></span>
            	
		</div>
    </div>
	
<br/>	

	<div class="form-group">
		<div class="col-md-5 center-block" style="padding-left: 0px">
            <button type="submit" class="btn btn-primary btn-success left-block">Register</button>
     	</div>
	</div>
<?php echo form_close();?>
	
	
	

</br></br>
      <div align="left">
          <br/><br/><br/>
                <a href="<?php echo base_url(). 'index.php/shop/index';?>">COME BACK</a>
      </div>

               
	</div>
</div>				

<?php require_once('footer.php'); ?>



