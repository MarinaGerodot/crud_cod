<?php
/*
___________________________________________________

project : crud
file	: user_model.php
author	: kozlova Marina.
date	: 22.07.2015
___________________________________________________

*/

if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class User_model extends CI_Model 
{
    
     function __construct()
	 {
         // constructor that inherits all the methods of the parent class and loads the support of databases
         parent::__construct();
         $this->load->database();
        
         // download library 
         $this->load->library('table');     
     }
	 
	/*
	* This code fetches all records from the users table and returns them as an array
	* @return array 
	*/
    function get_users()
    {
        $query = $this->db->get('users')->result_array();
        return $query;
    } 
	
	/* 
	* This method search email in datebase
	* @param $email string
	* @return array $result ['email'] => 'user_email', if such email exists in the users table
	*/
	function is_email_in_db($email)
    {
		$this->db->where('email', $email);//WHERE email = 'user_email'
		$result = $this->db->get('users')->result_array();
        return $result;
		
    }
	
	/*
	* This method get username on id user 
	* @param $id string
	* @return string $username
	*/
	function get_username($id)
    {
		$this->db->where('id', $id);
		$result = $this->db->get('users')->result_array();
		foreach ($result as $res)
        {	
			$username = $res['username'];
		}
        return $username;
		
    }
	
	/*
	* This method get email on id user 
	* @param $id string
	* @return string $email
	*/
	function get_email($id)
    {
		$this->db->where('id', $id);
		$result = $this->db->get('users')->result_array();
		foreach ($result as $res)
        {	
			$email = $res['email'];
		}
        return $email;
		
    }    
	
	/* 
	* This method search username in datebase
	* @param $username string
	* @return array $result ['username'] => 'user_username', if such username exists in the users table
	*/
	function is_username_in_db($username)
    {
		$this->db->where('username', $username);
		$result = $this->db->get('users')->result_array();		
        return $result;		
    }
	
	/* 
	* Search user by his username & password in the database
    * 
	* @param string $password Raw password. It will be automatically encoded inside this method
    * @param string $username
	* @return array $user User if found, FALSE otherwise 
	*/
	
	function find_for_login($username, $password )
    {
        // Encode password in the same way as in the register method
        // If you want to change this, don't forget to update the register as well
		$password = hash('sha512', $password);
		
		$this->db->where('username', $username);
		$this->db->where('password', $password);
		
		$results = $this->db->get('users')->result_array();		

        return (empty($results)) ? FALSE : $results[0];		
    }  
		
	 // method to create a new user
	 /* 
	* This method to create a new user in datebase
	* @param $email string , $username string, $password string
	*/
	 function create_user ($username, $password, $email)
	 {
		$password = hash('sha512', $password); 
		
		$created_date =  date("Y-m-d H:i:s", time());

		$data = array(

               'username' => $username,

               'password' => $password,

               'email' => $email,

               'created_at' => $created_date

        );
		$this->db->insert('users', $data);

   	}

}
