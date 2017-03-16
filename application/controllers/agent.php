<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Agent extends CI_Controller {
	public function login(){
		$this->form_validation->set_rules('username', 'Username', 'required');
		$this->form_validation->set_rules('password', 'Password', 'required');
		
		if($this->form_validation->run() == FALSE){
			$data['title']='Agent Login';
			$data['view']='agent_login.php';
			$this->load->view('layout.php',$data);
		}else{
			$data['username'] = $this->input->post('username');
			$password = $this->input->post('password');
			$data['password'] = md5($password);
			
			$this->load->model('agents');
			$agentData = $this->agents->login($data);
			
			$agentId=$agentData['id'];
			if(isset($agentId) && !empty($agentId)){
				if($agentData['status'] == 'disabled'){
					$this->session->set_flashdata('error', 'You have been blocked by Admin.');
					$data['title']='Agent Login';
					$data['view']='agent_login.php';
					$this->load->view('layout.php',$data);
				}else{
					$this->session->set_flashdata('success', 'You logged in successfully');
					header('Location:'.base_url('agent/products'));
				}
			}else{
				$this->session->set_flashdata('error', 'Username or password is wrong');
				$data['title']='Agent Login';
				$data['view']='agent_login.php';
				$this->load->view('layout.php',$data);
			}
		}
	}
	
	public function products(){
		/* echo "<pre>";print_r($this->session->all_userdata());exit; */
		$agentId = $this->session->userdata('id');
		if(isset($agentId) && !empty($agentId)){
			$this->form_validation->set_rules('shopname','Shop Name','required');
			$this->form_validation->set_rules('email','Email Address','required');
			$this->form_validation->set_rules('phonenumber','Phone Number','required|numeric');
			$this->form_validation->set_rules('address','Address','required');
			
			if($this->form_validation->run() == FALSE){
				$data['title']='Add Product';
				$data['view']='agent_product.php';
				$data['post']=$this->input->post();
				$this->load->view('layout.php',$data);
			}else{
				$errors = $this->validateFiles($_FILES);
				if($errors){
					$data['title']='Add Product';
					$data['view']='agent_product.php';
					$data['post']=$this->input->post();
					$this->session->set_flashdata('error',$errors);
					$this->load->view('layout.php',$data);
				}else{
					$shopName = $this->input->post('shopname');
					$time=time();
					$folderName =$shopName.$time; 
					mkdir('assets/uploads/'.$folderName);
					$uploadFilePath = 'assets/uploads/'.$folderName;
					$files = $_FILES;
					
					foreach($files as $fileData){
						if($fileData['name'] != ''){
							$fileName="";$fileExt="";$newFileName="";
							$fileName=pathinfo($fileData['name']);
							$fileExt=$fileName['extension'];
							$fileName=$fileName['filename'];
							$microTime=microtime();
							$newFileName=$fileName.'_'.$microTime.'.'.$fileExt;
							move_uploaded_file($fileData['tmp_name'], $uploadFilePath.'/'.$newFileName);
						}
					}
					
					$this->load->model('agents');
					$affectedRows = $this->agents->uploadProduct($this->input->post(),$folderName);
					if($affectedRows > 0){
						$data['title']='Add Product';
						$data['view']='agent_product.php';
						$this->session->set_flashdata('success','Product added successfully.');
						$this->load->view('layout.php',$data);
					}else{
						rmdir(base_url().'assets/uploads/'.$folderName);
						$data['title']='Add Product';
						$data['view']='agent_product.php';
						$this->session->set_flashdata('error','Some error has occured.Please try again.');
						$this->load->view('layout.php',$data);
					}
				}
			}
		}else{
			header('Location:'.base_url('agent/login'));
		}
	}
	
	private function validateFiles($files){
		$fileArr=array();
		$error=array();
		foreach($files as $fileData){
			if($fileData['name']){
				$fileArr[]=$fileData['name'];
				$type = explode('/',$fileData['type']);
				if(count($type) > 0){
					$type = $type[1];
					if($type != 'jpg' && $type != 'png' && $type != 'jpeg'){
						if(empty($error)){
							$error='Only jpg,png and jpeg formate allowed.'; 
						}
					}
				}
			}
		}
		$fileCount = count($fileArr);
		if($fileCount != 5){
			$error= 'All images are mandatory.';
		}
		return $error;
	}
	
	public function logout(){
		$this->session->sess_destroy();
		header('Location:'.base_url('agent/login'));
	}
}
