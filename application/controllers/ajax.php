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
			 
			$this->form_validation->set_message ('is_username_exist', 'Username already exists');
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
			 
			$this->form_validation->set_message ('is_email_exist', 'Email already exists');
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
				
				//check datebase
				$user_row = $this->user_model->is_username_password_in_db($this->input->post('username'), $this->input->post('password'));
				if($user_row)
				{
					foreach ($user_row as $row)
					{	
						$id = $row['id'];
					}
					//write in session 
					$this->session->set_userdata('id', $id);
					
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
}


