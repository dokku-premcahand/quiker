<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Backoffice extends CI_Controller {
	public function __construct(){
		parent::__construct();
		$action = $this->router->fetch_method();
		if($action != "login"){
			$session = $this->session->all_userdata();
			if(!empty($session) && $this->session->userdata('type') != 'backoffice'){
				$this->session->sess_destroy();
				header('Location:'.base_url('user/login'));
			}
		}
		$this->load->model('agents');
	}
	
	public function login(){
		$this->form_validation->set_rules('username', 'Username', 'required');
		$this->form_validation->set_rules('password', 'Password', 'required');
		
		if($this->form_validation->run() == FALSE){
			$data['title']='Back Office Login';
			$data['view']='admin_login.php';
			$this->load->view('backoffice/layout.php',$data);
		}else{
			$data['username'] = $this->input->post('username');
			$password = $this->input->post('password');
			$data['password'] = md5($password);
			
			$this->load->model('users');
			$responce = $this->users->login($data);
			
			$userId=$this->session->userdata('id');
			if(isset($userId) && !empty($userId)){
				$this->session->set_flashdata('success', 'You logged in successfully');
				header('Location:'.base_url('backoffice/product'));
			}else{
				$this->session->set_flashdata('error', 'Username or password is wrong');
				$data['title']='Back Office Login';
				$data['view']='admin_login.php';
				$this->load->view('backoffice/layout.php',$data);
			}
		}
	}

	public function pull(){
		echo "<pre>";print_r($this->input->post());exit;
	}

	public function export(){
		echo "<pre>";print_r($this->input->post());exit;
	}
	
	public function product(){
		$this->load->model('products');
		$product = $this->products->getAllProducts();
		// echo "<pre>";print_r($product);exit;
		$data['title']='Product Listing';
		$data['view']='product.php';
		$data['userData']=$product;
		$this->load->view('backoffice/layout.php',$data);
	}
	
	public function downloadProduct($folder){
		$this->load->helper('directory');
		$this->load->library('zip');
		
		$path = 'assets/uploads/'.$folder;
		$map = directory_map($path);
		
		foreach($map as $fileName){
			$this->zip->read_file($path.'/'.$fileName);
		}
		$this->zip->download($folder.'.zip');
	}
	
	public function logout(){
		$this->session->sess_destroy();
		header('Location:'.base_url('backoffice/login'));
	}

	public function changeProductStatus(){
		$productArr = $this->input->post('product');
		$productStr = implode($productArr);
		$this->load->model('products');
		$product = $this->products->updateProductStatus($productStr);
		if($product > 0){
			$this->session->set_flashdata('success','Product/s status updated successfully');
		}else{
			$this->session->set_flashdata('error','Error occured. Please try after sometime.');
		}
		header('Location:'.base_url('backoffice/product'));
	}
}
