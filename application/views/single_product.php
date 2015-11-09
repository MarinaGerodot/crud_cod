<?php
/*
___________________________________________________

project : crud
file	: single_product.php
author	: kozlova Marina.
date	: 22.07.2015
___________________________________________________

*/
require_once('header.php');
?>
<body>

</br>
	
                    
<div class="container">
</br></br>
		<div align="left">
			<h4><font color = #ff0000><?php echo $message_add; ?></font></h4>	
        </div>
 </br></br></br> 
		 

<div align="left">
    
    <img src="<?php echo base_url(). 'bootstrap/img/'.htmlspecialchars($single_product['photo']); ?>" alt=""/>
						 
    <br/><br/>    		
</div> 


		<div class="desc1 span_3_of_2">
             <h5>Title:</h5>
				  <h4><?php echo htmlspecialchars($single_product['title']); ?></h4>
                        <h5>Description:</h5>
                        <h4><?php echo htmlspecialchars($single_product['description']); ?></h4>
							<!--<h5>Category:</h5>-->
                        	<h6><?php //echo $single_product['category_id']; ?></h6>
		</div>
        <div class="clearfix"> </div>
          <br/><br/>    
            <div align="left">
 				<a class="now-get get-cart" href="<?php echo base_url(). 'index.php/shop/update_product/?id='.$single_product['id'];?>">Update Product |</a>
				<a class="now-get get-cart" href="<?php echo base_url(). 'index.php/ajax/update_product_form/?id='.$single_product['id'];?>">Update Product AJAX|</a>
                <a class="now-get get-cart" href="<?php echo base_url(). 'index.php/shop/delete_product/?id='.$single_product['id'];?>" onclick='return erase();'>Delete Product</a>
            </div>
         <div class="clearfix"> </div>     
           <br/><br/>
           		<div align="left">
                <a class="now-get get-cart" href="<?php echo base_url(). 'index.php/shop/index';?>">COME BACK</a>
            	</div>
         <div class="clearfix"> </div>
           <br/><br/>                  
    	  
    	   
<script type="text/javascript">

        function erase(){ 
            return confirm ('Are you sure you want to delete this product?');
        }
  
</script>
	            
 
      	<div class="clearfix"> </div>     
                  		    
</div>
	
<?php require_once('footer.php'); ?>

  
   

