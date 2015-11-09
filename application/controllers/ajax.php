<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Ajax extends CI_Controller {

    function __construct(){

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
	* Metod register form
	* @return response
	*/ 
    public function register_form() 
	{           
		$this->load->view('signup_ajax', array('title' => 'Register form'));						
    }

	/*
	* Metod ajax registration
	* @return response
	*/ 
	function ajax_register() 
	{
		$redirectURL = base_url(). 'index.php/shop/index';
		$errors = array();
		
		$username = $this->input->post('username');
		$email = $this->input->post('email');
		$password = $this->input->post('password');
		
		if($this->input->post('fromAjax')) 
		{
			$this->form_validation->set_rules('username', 'username', 'required|trim|min_length[3]|max_length[255]|callback_is_username_exist');
        	$this->form_validation->set_rules('password', 'password', 'required|trim|min_length[3]|max_length[255]');
        	$this->form_validation->set_rules('email', 'email', 'required|trim|valid_email|callback_is_email_exist');	
			
	        if($this->form_validation->run() == FALSE) 
			{
				$errors['username'] = form_error('username');
				$errors['password'] = form_error('password');
				$errors['email'] = form_error('email');				
				//echo validation_errors();
				
				$errString = array();
				foreach($errors as $key=>$value)
				{
					// The name of the field that caused the error, and the
					// error text are grouped as key/value pair for the JSON response:
					$errString[]='"'.$key.'":"'.$value.'"';
				}
				echo ('{"status":0,'.join(',',$errString).'}');
				return;
									
	        } else {
				
				//save datebase
        		$this->user_model->create_user($username, $password, $email);
				///write in session flash-message
				$this->session->set_flashdata('message_add', 'Add user success!');
				// JSON success response. Returns the redirect URL:
				echo '{"status":1,"redirectURL":"'.$redirectURL.'"}';
				return;				
	      	}
		}
	}
	
	/**
     * Callback looking for a match in the database username 
     * @param $username string
     * @return bool TRUE if username missing in datebase
     */
    public function is_username_exist($username)
    {		
        if (!$this->user_model->is_username_in_db($username))
        {
            return true;
			
        }else {
			 
			$this->form_validation->set_message ('is_username_in_db', 'Username already exists');
			return false;
		}
    }
	
	/**
     * Callback looking for a match in the database email
     * @param $email string
     * @return bool TRUE if email missing in datebase
     */
    public function is_email_exist($email)
    {	
		if (!$this->user_model->is_email_in_db($email))
        {
            return true;
			
        }else {
			 
			$this->form_validation->set_message ('is_email_in_db', 'Email already exists');
			return false;
		}
    }
	
	/*
	* Metod login form
	* @return response
	*/
    public function login_form() 
	{           
		$this->load->view('loginform_ajax', array('title' => 'Login form'));						
    }
	
	/*
	* Metod ajax login
	* @return response
	*/
    public function ajax_login() 
	{
		
		$redirectURL1 = base_url(). 'index.php/shop/index';
		$redirectURL2 = base_url(). 'index.php/ajax/login_form';
		$errors = array();
		
		$username = $this->input->post('username');
		$password = $this->input->post('password');
		
		if($this->input->post('fromAjax')) 
		{
			$this->form_validation->set_rules('username', 'username', 'required|trim|min_length[3]|max_length[255]');
        	$this->form_validation->set_rules('password', 'password', 'required|trim|min_length[3]|max_length[255]');
			
	        if($this->form_validation->run() == FALSE) 
			{
				$errors['username'] = form_error('username');
				$errors['password'] = form_error('password');		
				//echo validation_errors();
				
				$errString = array();
				foreach($errors as $key=>$value)
				{
					// The name of the field that caused the error, and the
					// error text are grouped as key/value pair for the JSON response:
					$errString[]='"'.$key.'":"'.$value.'"';
				}
				echo ('{"status":0,'.join(',',$errString).'}');
				return;
									
	        } else {
				
				//check database
				$user_row = $this->user_model->find_for_login($this->input->post('username'), $this->input->post('password'));
				if($user_row)
				{
					//write in session 
					$this->session->set_userdata('id', $user_row['id']);
					
					// JSON success response. Returns the redirect URL:
					echo '{"status":1,"redirectURL":"'.$redirectURL1.'"}';
					return;	
				
				}else {
			
					//$this->load->view('login', array('title' => 'Login form', 'message_enter' => 'Invalid name and/or password!'));
					// JSON success response. Returns the redirect URL:
					echo '{"status":1,"redirectURL":"'.$redirectURL2.'"}';
					return;	
				}
			}
		}
       
    }
	
	
	/*
	* Metod add_product form
	* @return response
	*/ 
    public function add_product_form() 
	{
		try {
				//We obtain from the session user_id
				$user_id = $this->session->userdata('id');
				if($user_id)
				{
					//obtain array category
					$select_category = $this->product_model->get_select_category();
		           
					$this->load->view('add_product_ajax', array('title' => 'Add product form', 'error_upload' => false, 'select_category' => $select_category));
				
			}else {
				
				throw new Exception('Error access, please come to login!');
			}
		} catch(Exception $e) {
			
			$this->load->view('error', array('title' => 'Add product error', 'text_error' => $e->getMessage()));			
        }	       				
								
    }
	
	/*
	* Metod ajax add_product
	* @return response
	*/ 
	function ajax_add_product() 
	{
		$redirectURL = base_url(). 'index.php/shop/index';
		$errors = array();
		$product_info = array();
		//We obtain from the session user_id
		$user_id = $this->session->userdata('id');
		
		$title = $this->input->post('title');
		$description = $this->input->post('description');
		$category = $this->input->post('category');
		
		//if($this->input->get('fromAjax')) 
		//{
			$this->form_validation->set_rules('title', 'title', 'required|trim|min_length[3]|max_length[255]|');
        	$this->form_validation->set_rules('description', 'description', 'required|trim|min_length[3]|max_length[255]');
			
	        if($this->form_validation->run() == FALSE) 
			{
				$errors['title'] = form_error('title');
				$errors['description'] = form_error('description');
				
				$errString = array();
				foreach($errors as $key=>$value)
				{
					// The name of the field that caused the error, and the
					// error text are grouped as key/value pair for the JSON response:
					$errString[]='"'.$key.'":"'.$value.'"';
				}
				echo ('{"status":0,'.join(',',$errString).'}');
				return;
									
	        } else {
				
				$product_info['title'] = $title;
				$product_info['description'] = $description;
				$product_info['category'] = $category;
				
				$config['upload_path'] = './bootstrap/img/'; 
				$config['allowed_types'] = 'gif|jpg|png';
				$config['max_size']	= 2000; 
				$config['encrypt_name'] = FALSE; 
				$config['remove_spaces'] = TRUE; 
	
				$this->load->library('upload', $config);
				$upload = $this->upload->do_upload('photo_file'); 
			 	if(!$upload)
				{
					$errors['photo_file'] = $this->upload->display_errors(); 
				
					$errString = array();
					foreach($errors as $key=>$value)
					{
						// The name of the field that caused the error, and the
						// error text are grouped as key/value pair for the JSON response:
						$errString[]='"'.$key.'":"'.$value.'"';
					}
					echo ('{"status":0,'.join(',',$errString).'}');
					return;
											
				}else {
					
					$upload_data = $this->upload->data();
					$product_photo = $upload_data['file_name'];
					$product_info['photo'] = $product_photo;
				}				
				
				//call method to create_product 
				$this->product_model->create_product($product_info, $user_id);
				///write in session flash-message
				$this->session->set_flashdata('message_add', 'Add product success!');
				// JSON success response. Returns the redirect URL:
				echo '{"status":1,"redirectURL":"'.$redirectURL.'"}';
				return;				
	      	}
		//}
	}
	
	/*
	* Metod update_product form
	* @return response
	*/ 
    public function update_product_form() 
	{
		try {	
				//We obtain from the session user_id
				$user_id = $this->session->userdata('id');
				if($user_id)//Если пользователь залогинился
				{
					//obtain array category
					$select_category = $this->product_model->get_select_category();
		           
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
							if($user_id != $product_user_id)//if it is product other user, Если это продукт другого пользователя
							{ 
            					throw new Exception('Error access, please come to login!');						
							}							
							$single_product = $product;						
						}
						//write in session id product
						$this->session->set_userdata('product_id', $single_product['id']);
						
         				$this->load->view('update_product_ajax', array('title' => 'Update product form' , 'select_category' => $select_category , 'single_product' => $single_product));			
					
					}			
							
			  }else {
				
				throw new Exception('Error access, please come to login!');
			}
		} catch(Exception $e) {
			
			$this->load->view('error', array('title' => 'Add product error', 'text_error' => $e->getMessage()));			
        }	       				
								
    }
	
	/*
	* Method to update product 
	* @return response
	*/
	
	public function ajax_update_product() 
	{
		$redirectURL = base_url(). 'index.php/shop/index';
		$errors = array();
		$product_info = array();
		//We obtain from the session user_id
		$user_id = $this->session->userdata('id');
		
		$title = $this->input->post('title');
		$description = $this->input->post('description');
		$category = $this->input->post('category');
		
		$this->form_validation->set_rules('title', 'title', 'required|trim|min_length[3]|max_length[255]|');
        $this->form_validation->set_rules('description', 'description', 'required|trim|min_length[3]|max_length[255]');
			
	    if($this->form_validation->run() == FALSE) 
		{
			$errors['title'] = form_error('title');
			$errors['description'] = form_error('description');
				
			$errString = array();
			foreach($errors as $key=>$value)
			{
				// The name of the field that caused the error, and the
				// error text are grouped as key/value pair for the JSON response:
				$errString[]='"'.$key.'":"'.$value.'"';
			}
			echo ('{"status":0,'.join(',',$errString).'}');
			return;
									
	     } else {
				
			$product_info['title'] = $title;
			$product_info['description'] = $description;
			$product_info['category'] = $category;
				
			$config['upload_path'] = './bootstrap/img/'; 
			$config['allowed_types'] = 'gif|jpg|png';
			$config['max_size']	= 2000; 
			$config['encrypt_name'] = FALSE; 
			$config['remove_spaces'] = TRUE; 
	
			$this->load->library('upload', $config);
			$upload = $this->upload->do_upload('photo_file'); 
			if(!$upload)
			{
				$errors['photo_file'] = $this->upload->display_errors(); 
				
				$errString = array();
				foreach($errors as $key=>$value)
				{
					// The name of the field that caused the error, and the
					// error text are grouped as key/value pair for the JSON response:
					$errString[]='"'.$key.'":"'.$value.'"';
				}
				echo ('{"status":0,'.join(',',$errString).'}');
				return;
											
			}else {
					
				$upload_data = $this->upload->data();
				$product_photo = $upload_data['file_name'];
				$product_info['photo'] = $product_photo;
			}				
				
			//obtain from the session id product
			$product_id = $this->session->userdata('product_id');
			//call method to  update_product 
			$this->product_model->update_product($product_info, $user_id, $product_id);
			///write in session flash-message
			$this->session->set_flashdata('message_add', 'Add product success!');
			// JSON success response. Returns the redirect URL:
			echo '{"status":1,"redirectURL":"'.$redirectURL.'"}';
			return;				
	      }
		
	} 
	
}


