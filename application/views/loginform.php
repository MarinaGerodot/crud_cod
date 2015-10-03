<?php
/*
___________________________________________________

project : crud
file	: loginform.php
author	: kozlova Marina.
date	: 22.07.2015
___________________________________________________

*/
?>
<div align="left">
<br/>
      
<?php  $attributes = array('novalidate' => 'novalidate');
	   echo form_open('user/login/', $attributes); ?>

<?php if ($message_enter): ?>
			<h3><font color = #ff0000><?php echo $message_enter; ?></font></h3><br/>
<?php else: ?>
			<h3>Please, will enter name and password:</h3><br/> 
<?php endif; ?>	
		  
	<div class="form-group">
		<div class="col-sm-4" style="float: none; padding-left: 0px">
          <label class="col-sm-1 control-label required" for="user_username" style="float: none; padding-left: 0px" >Name</label>
              <input type="text" name="username" class="form-control" value="<?php  echo set_value('username'); ?>"/>
			  <font color = #ff0000><?php echo form_error('username');?></font>
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
            <button type="submit" class="btn btn-primary btn-success left-block">Login</button>
     	</div>
	</div>
	
<?php echo form_close();?>


