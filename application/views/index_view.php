<?php
/*
___________________________________________________

project : crud
file	: index.php
author	: kozlova Marina.
date	: 22.07.2015
___________________________________________________

*/
require_once('header.php');
?>
<body>
<div class="container">
</br>
			               
<?php  if($id): ?>

				<div class="row">
				<div align="left">
				<div class="col-sm-3"><font color = #3333cc><span> </span><?php echo htmlspecialchars($id);?></font></div>
				<br/>
				<div class="col-sm-3"><font color = #3333cc><span> </span><?php echo htmlspecialchars($username);?></font></div>
				<br/>
				<div class="col-sm-3"><font color = #3333cc><span> </span><?php echo htmlspecialchars($email);?></font>	</div>
				</div> 
				
				<div align="right">
				   <ul class="list-inline">
			             <li><a href="<?php echo base_url().'index.php/user/logout/';?>"><span> </span>LOGOUT</a></li> 
			             
                   </ul>
				</div>
				</div>
				<br/>
				 <div align="left">                    
				<a href="<?php echo base_url().'index.php/shop/add_product/';?>"><span> </span>CREATE NEW PRODUCT</a>
				</div>
<?php  else:  ?> 
				<div class="row">
				<div class="col-sm-3"><font color = #3333cc><span> </span>YOUR ACCOUNT</font></div>
               <div align="right">
				  <ul class="list-inline">
						<li ><a href="<?php echo base_url().'index.php/user/login/';?>"><span> </span>LOGIN</a></li> |
						<li ><a href="<?php echo base_url().'index.php/user/register/';?>">SIGNUP</a></li>
				  </ul>
				</div>
				<div align="left">	
				<br/>
				<a href="<?php echo base_url().'index.php/ajax/register_form/';?>"><span> </span>register_ajax</a>
				<br/>
				<a href="<?php echo base_url().'index.php/ajax/login_form/';?>"><span> </span>login_ajax</a>
				</div>
<?php  endif; ?>



							
	</div>				
</div>
                    
<div class="container">
</br></br>
		<div align="center">
			<h4><font color = #ff0000><?php echo $message_add; ?></font></h4>	
        </div>
 </br></br></br> 
	
<!-- Если пользователь не Anonymous выводим список всех товаров с редактированием -->
<?php  if($id): //здесь сделать привязку по ID(есть в сессии ID или нет)(empty($id))
       
	 $count = 0; 
     foreach( $product_fields as $product):
			  
          if($product['user_id'] == $id):  ?>
                                    
	   		     <div class="product-left">
	   		     	<div class="col-md-4 chain-grid">
	   		     	    <div class="left-grid-view grid-view-left">
	   		     		<a href="<?php echo base_url(). 'index.php/shop/single_product/?id='.$product['id'];?>"><img class="img-responsive chain" src="<?php echo base_url(). 'bootstrap/img/'.htmlspecialchars($product['photo']); ?>" alt=""/></a>
                        
						
	   		     		<div class="grid-chain-bottom">
	   		     			
                            <h4><a href="<?php echo base_url(). 'index.php/shop/single_product/?id='.$product['id'];?>"><?php echo htmlspecialchars($product['title']); ?></a></h4>
	   		     			
	   		     		   </div>
	   		     	    </div>
                    </div>
                 </div>
                
                    	<!-- Выводим построчно, по три товара в строке  -->    
	   		     		<?php  $count = $count + 1; 
                              if($count == 3 ):  ?>
		                         <div class="clearfix"> </div>
                               	<?php  $count = 0;
                              endif;
					   
             endif;
			
     endforeach;  ?>
                  
                  <div class="clearfix"> </div>     
                  </br></br></br></br>
                 
<?php  else: ?><!-- Если пользователь Anonymous выводим список всех товаров без редактирования -->
				 
	<?php $count = 0;       
	foreach( $product_fields as $product):  ?>
            
		  <div class="product-grid">
			<div class="col-md-4 chain-grid">
			   	<div class="left-grid-view grid-view-left">
			 <img src="<?php echo base_url(). 'bootstrap/img/'.htmlspecialchars($product['photo']); ?>" class="img-responsive watch-right" alt=""/>
				</div>
				    <h4><?php echo htmlspecialchars($product['title']); ?></h4>
				     <p>It is a long established fact that a reader</p>
				     Rs. 499
			   	</div>
              </div>
              <!-- Выводим построчно, по три товара в строке  -->    
              <?php $count = $count + 1;
                if($count == 3):  ?>
		          <div class="clearfix"> </div>
                  <?php $count = 0;
                endif;
	endforeach;  ?>
 
 	 
<?php endif; ?>
       
		    
</div>
	
<?php require_once('footer.php'); ?>

  
   

