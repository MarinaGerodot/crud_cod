<?php
/*
___________________________________________________

project : crud
file	: user.php
author	: Kozlova Marina.
date	: 22.07.2015.
___________________________________________________

*/ 
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class User extends CI_Controller 
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
	 
	/**
     * Register () method to the controller class «User», which registers a new user
     * @return response
     */
    public function register() 
	{
    
        $this->form_validation->set_rules('username', 'username', 'required|min_length[3]|max_length[255]|callback_is_username_exist');
        $this->form_validation->set_rules('password', 'password', 'required|trim|min_length[3]|max_length[255]');
        $this->form_validation->set_rules('email', 'email', 'required|trim|valid_email|callback_is_email_exist');

        if($this->form_validation->run() == FALSE)
		{		
			$this->load->view('signup', array('title' => 'Register form'));			

        }
        else{
            //save datebase
            $this->user_model->create_user($this->input->post('username'), $this->input->post('password'),$this->input->post('email'));
			///write in session flash-message
			$this->session->set_flashdata('message_add', 'Add user success!');
            redirect( base_url(). 'index.php/shop/index');
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
			 
			$this->form_validation->set_message ('is_username_exist', 'Username already exists');//вот здесь была ошибка: is_username_in_db
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
	 
	/**
	* Method of user login to the site
	* @return response
	*/
    public function login() 
	{    
        $this->form_validation->set_rules('username', 'username', 'required|trim|min_length[3]|max_length[255]');
        $this->form_validation->set_rules('password', 'password', 'required|trim|min_length[3]|max_length[255]');

        if($this->form_validation->run() == FALSE)
		{		
            $this->load->view('login', array('title' => 'Login form', 'message_enter' => FALSE));		
        }
        else{
            // Try to find user in the database by his username/password
			$user = $this->user_model->find_for_login($this->input->post('username'), $this->input->post('password'));
            if($user)
			{
				// Put user info into the session. ID is enough to authenticate user
				$this->session->set_userdata('id', $user['id']);
				
				redirect( base_url(). 'index.php/shop/index');
				
			}else {
			
				$this->load->view('login', array('title' => 'Login form', 'message_enter' => 'Invalid name and/or password!'));
			}
        }           
    }
	
    /** 
	* Method to exit User
	* @return response
	*/
    public function logout()
    {
		// delete from the session variable username
        $this->session->unset_userdata('id');
        // We make a redirect users to the home page
        redirect( base_url(). 'index.php/shop/index');
    }
}
  


