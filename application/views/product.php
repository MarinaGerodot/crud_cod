<?php
/*
___________________________________________________

project : crud
file	: product.php
author	: kozlova Marina.
date	: 29.07.2015
___________________________________________________

*/
require_once('header.php');
?>
<body>
<div class="container">   
     
       
<div align="left">
<br/>
<br/><br/>

<?php $attributes = array('novalidate' => 'novalidate','enctype' => 'multipart/form-data');
	  echo form_open('shop/add_product/', $attributes);?>

<?php if ($message_enter): ?>
			<h3><font color = #ff0000><?php echo $message_enter; ?></font></h3><br/>
<?php else: ?>
			<h3>ADD NEW PRODUCT</h3><br/> 
<?php endif; ?>	

 	<div class="form-group">
		<div class="col-sm-4" style="float: none; padding-left: 0px">
          <label class="col-sm-1 control-label required" for="Pproduct_title" style="float: none; padding-left: 0px" >Title</label>
            <input type="text" name="title" class="form-control" value="<?php echo set_value('title'); ?>"/>
			<font color = #ff0000><?php echo form_error('title');?></font>
					<span class="help-block"> </span>
              
		</div>
    </div>
	
	<div class="form-group">
		<div class="col-sm-4" style="float: none; padding-left: 0px">
            <label class="col-sm-1 control-label required" for="product_description" style="float: none; padding-left: 0px">Description</label>
					<input type="text" name="description" class="form-control" value="<?php echo set_value('description'); ?>"/>
					<font color = #ff0000><?php echo form_error('description');?></font>
					<span class="help-block"> </span>
               
		</div>
    </div>			


 	<div class="form-group">
		<div class="col-sm-4" style="float: none; padding-left: 0px">
         <label class="col-sm-1 control-label required" for="product_photo" style="float: none; padding-left: 0px">Photo</label>
					<input type="file" name="userfile" class="form-control" value="<?php echo set_value('userfile'); ?>"/>
					<font color = #ff0000><?php echo form_error('userfile');?></font>
					<span class="help-block"></span>
            	<button type="submit" value="upload" class="btn btn-small btn-info left-block">Upload</button>
		</div>
    </div>
	
<br/>	

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



