<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Agent extends CI_Controller {
	public function __construct(){
		parent::__construct();
		$action = $this->router->fetch_method();
		$this->load->model('agents');
		if($action != "login"){
			$session = $this->session->all_userdata();
			if(empty($session) || $this->session->userdata('type') != 'agent'){
				$this->session->sess_destroy();
				header('Location:'.base_url('agent/login'));
			}
			else{
				$agentId = $this->session->userdata('id');
				$agentStatus = $this->agents->getStatus($agentId);
				if($agentStatus != 'enabled'){
					$this->session->sess_destroy();
					header('Location:'.base_url('agent/login'));
				}			
			}			
		}
		
	}
	
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
		$agentId = $this->session->userdata('id');
		if(isset($agentId) && !empty($agentId)){
			$this->load->model('agents');
			$todayCount = $this->agents->getTodayCount($agentId);
			$data['todayCount'] = $todayCount;
			$this->form_validation->set_rules('name','Name','required');
			$this->form_validation->set_rules('phonenumber','Phone Number','required|numeric');
			$this->form_validation->set_rules('marital_status','Marital Status','required');
			
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
					$name = $this->input->post('name');
					$currSeq = $todayCount + 1;
					$agentUserName = $this->session->userdata('username');
					
					$folderName = 'assets/uploads/'.date('d_m_Y').'/'.$agentUserName.'/'.$currSeq;
					
					if (!is_dir($folderName)) {
						mkdir($folderName, 0777, true);
					}
					
					$files = $_FILES;
					
					$ctr = 0;
					foreach($files as $fileData){
						
						if($fileData['name'] != ''){
							$fileName="";$fileExt="";$newFileName="";
							$fileName=pathinfo($fileData['name']);
							$fileExt=$fileName['extension'];
							$fileName=$fileName['filename'];
							$ctr++;
							$newFileName=$fileName.'_'.$ctr.'.'.$fileExt;
							move_uploaded_file($fileData['tmp_name'], $folderName.'/'.$newFileName);
						}
					}
					
					$affectedRows = $this->agents->uploadProduct($this->input->post(),$todayCount);
					if($affectedRows > 0){
						$data['title']='Add Product';
						$data['view']='agent_product.php';
						$data['todayCount'] = $currSeq;
						$this->session->set_flashdata('success','Product added successfully.');
						$this->load->view('layout.php',$data);
					}else{
						rmdir(base_url().$folderName);
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
							$error='Only jpg,png and jpeg formats are allowed.'; 
						}
					}
				}
			}
		}
		
		return $error;
	}
	
	public function logout(){
		$this->session->sess_destroy();
		header('Location:'.base_url('agent/login'));
	}
}
