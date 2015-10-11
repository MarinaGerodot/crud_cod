<?php
/*
___________________________________________________

project : crud
file	: product_model.php
author	: kozlova Marina.
date	: 29.07.2015
___________________________________________________

*/

if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Product_model extends CI_Model 
{
    
     function __construct()
	 { 
         parent::__construct();
         $this->load->database();
         $this->load->library('table');
       	 $this->load->library('session');
     }
	
	 /**
	 * Method of creating a new product
	 * @param $product_info array, $username string
	 **/
	 
	 function create_product ($product_info, $user_id){

		$created_date =  date("Y-m-d H:i:s", time());
		
		//We create an array to store the database
		$data = array(

             'title' => $product_info['title'],

               'description' => $product_info['description'],
			   
			   'photo' => $product_info['photo'],
			   
			   'category_id' => $product_info['category'],
			   
			   'user_id' => $user_id,

               'created_at' => $created_date

        );
		//stores the data in the table 
		$this->db->insert('products', $data);

   	}
	
	/**This code fetches all records from the products table, and returns them as an array
	* @return array all products
	**/
	
    function get_products() {
	
        $query = $this->db->get('products')->result_array();
        return $query;
    }
	
	/*
	* This method get product on id 
	* @param $id string
	* @return array 
	*/
	function get_product($id)
    {
		$this->db->where('id', $id);
		$result = $this->db->get('products')->result_array();
        return $result;
		
    } 
		
	/*//метод устанавливающий флаг updating = 1
    function updating_active($product_id) {
        $updating = 1;	
		//обновление записи в таблице
        $this->db->where('id', $product_id);
		$this->db->set('updating', $updating);
		$this->db->update('products');
    }
	//метод устанавливающий флаг updating = 0
    function updating_passive($product_id) {
        $updating = 0;	
		//обновление записи в таблице
        $this->db->where('id', $product_id);
		$this->db->set('updating', $updating);
		$this->db->update('products');
    }
	*/
	
	/**
	* Method of changing the product
	* @param $product_info array, $username string, $product_id string
	**/
	
	 function update_product ($product_info, $user_id, $product_id){

		$created_date =  date("Y-m-d H:i:s", time());

		$data = array(

               'title' => $product_info['title'],

               'description' => $product_info['description'],
			   
			   'photo' => $product_info['photo'],
			   
			   'category_id' => $product_info['category'],
			   
			   'user_id' => $user_id,

               'created_at' => $created_date

        );
		
		$this->db->where('id', $product_id);
		$this->db->update('products', $data);
		
   	}
		
    /**Method to delete rows from the products table
	* @param $product_id string
	**/
    function delete($product_id) {

        $this->db->where('id', $product_id);
		$this->db->delete('products');
		
    }	
	
	/**This method  gets the data from the table category
	* @return $data array
	**/
	
	function get_select_category() {	
		
		$result = $this->db->get('category')->result_array();
		$data = array();
		
        foreach ($result as $res)
        {
            $category_id = $res["id"];
            $category_name = $res["name"];	
			$data[$category_id] = $category_name;	
        }		
        return $data;	
	}

	/*
	* This method get photo on id product 
	* @param $id string
	* @return string $photo
	*/
	function get_photo($id)
    {
		$this->db->where('id', $id);
		$result = $this->db->get('products')->result_array();
		foreach ($result as $res)
        {	
			$photo = $res['photo'];
		}
        return $photo;
		
    }
	
}
