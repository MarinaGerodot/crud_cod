<?php

class Form extends CI_Controller {

	
	function __construct(){
        //конструктор класса с инициализацией необходимых параметров
        parent::__construct();

        // загрузка библиотек 
        $this->load->library('table');

        // загрузка helper
        $this->load->helper('url');
        $this->load->helper('form');
        
        //загрузка класса Валидатор
        $this->load->library('form_validation');
        //загрузка класса сессий 
        $this->load->library('session');

        // загрузка классов моделей 
        $this->load->model('user_model','',TRUE);
		$this->load->model('product_model','',TRUE);
        
    }

	function index()
	{
		//$this->load->helper(array('form', 'url'));

		//$this->load->library('form_validation');//is_unique[users.email] - это правило всегда выдаёт ошибку!!!
		
		$this->form_validation->set_rules('username', 'Username', 'trim|strip_tags|required|min_length[5]|max_length[12]|xss_clean');
		$this->form_validation->set_rules('password', 'Password', 'trim|strip_tags|required|matches[passconf]|md5');
		$this->form_validation->set_rules('passconf', 'Password Confirmation', 'trim|strip_tags|required');
		$this->form_validation->set_rules('email', 'Email', 'trim|strip_tags|required|valid_email');

		if ($this->form_validation->run() == FALSE)
		{
			$this->load->view('myform');
		}
		else
		{
			//здесь должна быть идентификация пользователя 
			$this->load->view('formsuccess');
		}
	}
}
?>