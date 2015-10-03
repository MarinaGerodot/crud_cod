<?php
/*
___________________________________________________

project : crud
file	: update_product.php
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
	  echo form_open('shop/update_product/', $attributes);?>


	<h3>UPDATE PRODUCT</h3><br/> 

 	<div class="form-group">
		<div class="col-sm-4" style="float: none; padding-left: 0px">
          <label class="col-sm-1 control-label required" for="Pproduct_title" style="float: none; padding-left: 0px" >Title</label>
            <input type="text" name="title" class="form-control" value="<?php  if (is_array ($single_product))  { echo htmlspecialchars($single_product['title']); } if($message_enter) { echo set_value('title'); } ?>"/>
			<font color = #ff0000><?php echo form_error('title');?></font>
					<span class="help-block"> </span>
              
		</div>
    </div>
	
	<div class="form-group">
		<div class="col-sm-4" style="float: none; padding-left: 0px">
            <label class="col-sm-1 control-label required" for="product_description" style="float: none; padding-left: 0px">Description</label>
					<input type="text" name="description" class="form-control" value="<?php  if (is_array ($single_product))  { echo htmlspecialchars($single_product['description']); }	if($message_enter) { echo set_value('description'); } ?>"/>
					<font color = #ff0000><?php echo form_error('description');?></font>
					<span class="help-block"> </span>
               
		</div>
    </div>			


 	<div class="form-group">
		<div class="col-sm-4" style="float: none; padding-left: 0px">
         <label class="col-sm-1 control-label required" for="product_photo" style="float: none; padding-left: 0px">Photo</label>
					<input type="text" name="photo" class="form-control" value="<?php  if (is_array ($single_product))  { echo htmlspecialchars($single_product['photo']); }	if($message_enter) { echo set_value('photo'); } ?>"/>
					<font color = #ff0000><?php echo form_error('photo');?></font>
					<span class="help-block"></span>
		</div>
    </div>
	<br/>
	<div class="form-group">
		<div class="col-sm-10" style="float: none; padding-left: 0px">
		 <label class="col-sm-1 control-label required" for="product_photo" style="float: none; padding-left: 0px">Category</label>
		 
         	<?php echo form_dropdown('category', $select_category, $single_product['category_id']); ?>
			
		</div>
    </div>
	
<br/><br/>	

	<div class="form-group">
		<div class="col-md-5 center-block" style="padding-left: 0px">
            <button type="submit" class="btn btn-primary btn-success left-block"> UPDATE </button>
     	</div>
	</div>
<?php echo form_close();?>
	
	
	

</br></br>
      <div align="left">
          <br/><br/><br/>
                <a href="<?php echo base_url().'index.php/shop/single_product/?id='.$single_product['id'];?>">COME BACK</a>
      </div>

               
	</div>
</div>
				
<?php require_once('footer.php'); ?>



