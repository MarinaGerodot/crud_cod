<?php
/*
___________________________________________________

project : crud
file	: shop.php
author	: Kozlova Marina.
date	: 22.07.2015.
___________________________________________________

*/ 
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Shop extends CI_Controller 
{

    function __construct()
	{
        //constructor with initialization parameters required
       
	    parent::__construct(); 
        $this->load->library('table');
        $this->load->helper('url');
        $this->load->helper('form');
        $this->load->library('form_validation');
        $this->load->library('session');
        $this->load->model('user_model','',TRUE);
        $this->load->model('product_model','',TRUE);
    }
		
    /* 
	* The method of outputting the main page
	* @return response
	*/
    public function index()
	{
		//We obtain from the session 
		$id = $this->session->userdata('id');
		if($id)
		{
			$username = $this->user_model->get_username($id);
			$email = $this->user_model->get_email($id);
		} else {
			
			$id = false;
			$username = '';
			$email = '';
		}
		//obtain from the session flash-message
		$message_add = $this->session->flashdata('message_add');
		//we obtain array all products
		$product_fields = $this->product_model->get_products();
			
		//if there is no flash-message
		if(!$message_add) 
		{
			$message_add = '';
		}
		$this->load->view('index_view', array('title' => 'Shop', 'username' => $username,  'email' => $email, 'id' => $id,'message_add' => $message_add, 'product_fields' => $product_fields));
							   	
    }

	/**
	* Method removing page of one product
	* @return response
	*/
	
    public function single_product()
	{
		try {
			//We obtain from the session user_id
			$user_id = $this->session->userdata('id');
			if($user_id)
			{
				$username = $this->user_model->get_username($user_id);
				//we obtain from GET, id product 
        		$product_id = $this->input->get('id');
				//obtain from the session flash-message
				$message_add = $this->session->flashdata('message_add');
		
				//we obtain array all products
				$product_row = $this->product_model->get_product($product_id);
				//select product for its issues in single_product.php 
				foreach ($product_row as $product)
        		{	
					$product_user_id = $product['user_id'];
					if($user_id != $product_user_id)//if it is product other user
					{ 
            			throw new Exception('Error access, please come to login!');						
					}							
					$single_product = $product;
				}					
				//if there is no flash-message
				if(!$message_add) 
				{
					$message_add = '';
				}
				$this->load->view('single_product', array('title' => 'Single product','single_product' => $single_product, 'message_add' => $message_add)); 
			}else {
				
				throw new Exception('Error access, please come to login!');
			}
		} catch(Exception $e) {
			
			$this->load->view('error', array('title' => 'Single product error', 'text_error' => $e->getMessage()));			
        }				
    }

	/**
	* Method to add product
	* @return response
	*/
	
	public function add_product() 
	{
		try {
			
			//We obtain from the session user_id
			$user_id = $this->session->userdata('id');
			if($user_id)
			{
				//$username = $this->user_model->get_username($user_id);
				//obtain from the session flash-message
				$message_enter = $this->session->flashdata('message_enter');
				//obtain array category
				$select_category = $this->product_model->get_select_category();
				//we obtain all data from POST
        		$product_info = $this->input->post(); //if array else 0
				if(!$product_info) 
				{		
         			$this->load->view('add_product', array('title' => 'Add product form', 'error_upload' => false, 'select_category' => $select_category, 'request_category' => false));
					return;			
				}			
				if(is_array ($product_info))//if there is a data get from form 
				{	
					$this->form_validation->set_rules('title', 'title', 'required|trim|min_length[3]|max_length[255]|callback_title_not_exists');
					$this->form_validation->set_rules('description', 'description', 'required|trim|min_length[3]|max_length[255]');
					
					//We obtain from the request_category from POST
					$request_category = $product_info['category'];
                   	
            		if($this->form_validation->run() == FALSE) 
					{
						$this->load->view('add_product', array('title' => 'Add product form', 'error_upload' => false, 'select_category' => $select_category, 'request_category' => $request_category));
				
					} else {
			
						$config['upload_path'] = './bootstrap/img/'; 
						$config['allowed_types'] = 'gif|jpg|png';
						$config['max_size']	= 2000; 
						$config['encrypt_name'] = FALSE; 
						$config['remove_spaces'] = TRUE; 
	
						$this->load->library('upload', $config);
						$upload = $this->upload->do_upload('photo_file'); 
			 			if(!$upload)
						{
							$error_upload = $this->upload->display_errors();
							$this->load->view('add_product', array('title' => 'Add product form', 'error_upload' => $error_upload, 'select_category' => $select_category, 'request_category' => $request_category));
							
							return;
											
						}else {
					
							$upload_data = $this->upload->data();
							$product_photo = $upload_data['file_name'];
							$product_info['photo'] = $product_photo;
						}				
						//call method to create_product 
						$this->product_model->create_product($product_info, $user_id);
						//write in session flash-message
						$this->session->set_flashdata('message_add', 'Add product success!');					
						//redirect to index page
            			redirect( base_url(). 'index.php/shop/index');
					}			
				}
			}else {
				
				throw new Exception('Error access, please come to login!');
			}
		} catch(Exception $e) {
			
			$this->load->view('error', array('title' => 'Add product error', 'text_error' => $e->getMessage()));			
        }	       
	}
	

	/**
	* Method to delete product
	* @return response
	*/
	
	public function delete_product() 
	{
		try {
			
			//We obtain from the session user_id
			$user_id = $this->session->userdata('id');
			if($user_id)
			{
				$username = $this->user_model->get_username($user_id);
				//we obtain from GET, id product
        		$product_id = $this->input->get('id');
				//obtain array products
				$product_row = $this->product_model->get_product($product_id);
				//select product for its issues update_product.php 
				foreach( $product_row as $product) 
				{	
					$product_user_id = $product['user_id'];
					if($user_id != $product_user_id)//if it is product other user
					{ 
            			throw new Exception('Error access, please come to login!');						
					}								
				}
				//call method to  delete
				$this->product_model->delete($product_id);
			
				//write in session flash-message
				$this->session->set_flashdata('message_add', 'Delete product success!');		
				//redirect to index page
        		redirect( base_url(). 'index.php/shop/index');
				
			}else {
				
				throw new Exception('Error access, please come to login!');
			}
			
		} catch(Exception $e) {
			
			$this->load->view('error', array('title' => 'Delete product error', 'text_error' => $e->getMessage()));			
        }
	}	 
	
	/** (prob)
	* Method to update product 
	* @return response
	*/
	
	public function update_product() 
	{
		try {			
			
			//We obtain from the session user_id
			$user_id = $this->session->userdata('id');
			if($user_id)
			{
				//$username = $this->user_model->get_username($user_id);
				//obtain from the session flash-message
				$message_add = $this->session->flashdata('message_add');
				$message_enter = $this->session->flashdata('message_enter');
				//obtain array category
				$select_category = $this->product_model->get_select_category();
			
				//we obtain all data from POST(if come )
        		$product_info = $this->input->post();
				//we obtain from GET, id product
        		$product_id = $this->input->get('id');
				if($product_id) 
				{
					//obtain array products
					$product_row = $this->product_model->get_product($product_id);
					//select product for its issues update_product.php 
					foreach( $product_row as $product) 
					{	
						$product_user_id = $product['user_id'];
						if($user_id != $product_user_id)//if it is product other user
						{ 
            				throw new Exception('Error access, please come to login!');						
						}							
						$single_product = $product;						
					}
					//write in session id product
					$this->session->set_userdata('product_id', $single_product['id']);
	
         			$this->load->view('update_product', array('title' => 'Update product form' , 'error_upload' => false, 'select_category' => $select_category , 'single_product' => $single_product, 'request_category' => false));			
					
				}
				//if there is a data get from form 
				if(is_array ($product_info)) 
				{				
					$this->form_validation->set_rules('title', 'title', 	'required|trim|min_length[3]|max_length[255]|callback_title_not_exists');
					$this->form_validation->set_rules('description', 'description', 	'required|trim|min_length[3]|max_length[255]|callback_description_not_exists');
					
					//We obtain from the request_category from POST
					$request_category = $product_info['category'];
            	
            		if($this->form_validation->run() == FALSE) 
					{			
						$this->load->view('update_product',  array('title' => 'Update product form' , 'select_category' => $select_category , 'error_upload' => false, 'photo_file' => false, 'single_product' => false, 'request_category' => $request_category));
				
					} else {
					
						$config['upload_path'] = './bootstrap/img/'; 
						$config['allowed_types'] = 'gif|jpg|png';
						$config['max_size']	= 2000; 
						$config['encrypt_name'] = FALSE; 
						$config['remove_spaces'] = TRUE; 
	
						$this->load->library('upload', $config);
						$upload = $this->upload->do_upload('photo_file'); 
						
			 			if(!$upload)
						{
							$error_upload = $this->upload->display_errors();
							
							//var_dump($single_product);
							//exit();
							
							$this->load->view('update_product', array('title' => 'Update product form', 'error_upload' => $error_upload, 'select_category' => $select_category , 'single_product' => false, 'request_category' => $request_category));
							
							
							return;
									
						}else {
					
							$upload_data = $this->upload->data();
							$product_info['photo'] = $upload_data['file_name'];
						}				
						//obtain from the session id product
						$product_id = $this->session->userdata('product_id');
						//call method to  update_product 
						$this->product_model->update_product($product_info, $user_id, $product_id);
						//write in session flash-message
						$this->session->set_flashdata('message_add', 'Update product success!');
						//redirect to single_product.php
            			redirect( base_url(). 'index.php/shop/single_product/?id='.$product_id);
					}							
				}
			}else {
				
				throw new Exception('Error access, please come to login!');
			}
		} catch(Exception $e) {
			
			$this->load->view('error', array('title' => 'Update product error', 'text_error' => $e->getMessage()));			
        }
	}
	
}
  


