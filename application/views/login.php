<?php
/*
___________________________________________________

project : crud
file	: login.php
author	: kozlova Marina.
date	: 22.07.2015
___________________________________________________

*/
require_once('header.php');
?>
<body>
<div class="container">       
<br/>  
<?php 
//Выводим форму идентификации администратора
require_once('loginform.php');
?>
</br></br>
   <div align="left">
       <br/><br/>
       <a href="<?php echo base_url(). 'index.php/shop/index';?>">COME BACK</a>
   </div>
</div>
<?php require_once('footer.php'); ?>
