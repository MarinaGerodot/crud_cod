<?php
/*
___________________________________________________

project : crud
file	: loginform_ajax.php
author	: Kozlova Marina.
date	: 22.07.2015
___________________________________________________

*/
require_once('header.php');
?>
<body>
<br/>  
<div class="container">

<div id="carbonForm" align="left">
<?php  $attributes = array('id' => 'form','novalidate' => 'novalidate');
	   echo form_open('ajax/ajax_login/', $attributes); ?>
	   
<div id="message_enter">
	<h3>Please, will enter name and password:</h3>
</div>
	<br/>	  
	<div class="form-group">
		<div class="col-sm-4" style="float: none; padding-left: 0px">
          <label class="col-sm-1 control-label required" for="username" style="float: none; padding-left: 0px">Name</label>
              <input type="text" name="username" id="username" class="form-control" value=""/>
			  <span class="help-block"> </span>
        </div>
    </div>
    <div class="form-group">
		<div class="col-sm-4" style="float: none; padding-left: 0px">
         <label class="col-sm-1 control-label required" for="password" style="float: none; padding-left: 0px">Password</label>
          <input type="password" name="password" id="password" class="form-control" value=""/>
		  <span class="help-block"> </span>
		  </div>
    </div>		  
<br/>	
	<div class="form-group">
		<div class="col-md-5 center-block" style="padding-left: 0px">
            <button type="submit" name="submit" id="submit" class="btn btn-primary btn-success left-block">Login</button>
     	</div>
	</div>
	
<?php echo form_close();?>

</div>

</br></br>
   <div align="left">
       <br/><br/>
       <a href="<?php echo base_url(). 'index.php/shop/index';?>">COME BACK</a>
   </div>
   
<?php require_once('footer.php'); ?>	
