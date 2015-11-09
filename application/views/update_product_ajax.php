<?php
/*
___________________________________________________

project : crud
file	: update_product_ajax.php
author	: kozlova Marina.
date	: 02.10.2015
___________________________________________________

*/
require_once('header.php');
?>
<body>
<div class="container">

<div id="productForm" align="left">
<br/>
<br/><br/>

<?php $attributes = array('id' => 'addProductForm', 'novalidate' => 'novalidate', 'enctype' => 'multipart/form-data');
	  echo form_open('ajax/ajax_update_product/', $attributes);?>

	<h3>UPDATE PRODUCT</h3><br/> 

 	<div class="form-group">
		<div class="col-sm-4" style="float: none; padding-left: 0px">
          <label class="col-sm-1 control-label required" for="Pproduct_title" style="float: none; padding-left: 0px" >Title</label>
            <input type="text" name="title" id="title" class="form-control" value="<?php echo htmlspecialchars($single_product['title']); ?>"/>
					<span class="help-block"> </span>
              
		</div>
    </div>
	
	<div class="form-group">
		<div class="col-sm-4" style="float: none; padding-left: 0px">
            <label class="col-sm-1 control-label required" for="product_description" style="float: none; padding-left: 0px">Description</label>
					<input type="text" name="description" id="description" class="form-control" value="<?php echo htmlspecialchars($single_product['description']); ?>"/>
					<span class="help-block"> </span>
               
		</div>
    </div>			


 	<div class="form-group">
		<div class="col-sm-4" style="float: none; padding-left: 0px">
		<img width="30" height="30" alt="" id="small_image" src="<?php echo base_url(). 'bootstrap/img/'.htmlspecialchars($single_product['photo']); ?>">
         <label class="col-sm-1 control-label required" for="product_photo" style="float: none; padding-left: 0px">Photo</label>
					<input type="file" name="photo_file" id="photo_file" accept="image/jpeg,image/gif,image/x-png" value=""/>
					
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



