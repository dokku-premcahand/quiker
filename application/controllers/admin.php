<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Admin extends CI_Controller {
	public function __construct(){
		parent::__construct();
		$action = $this->router->fetch_method();
		if($action != "login"){
			$session = $this->session->all_userdata();
			if(!empty($session) && $this->session->userdata('type') != 'admin'){
				$this->session->sess_destroy();
				header('Location:'.base_url('admin/login'));
			}
		}
		$this->load->model('agents');
	}

	public function login(){
		$this->form_validation->set_rules('username', 'Username', 'required');
		$this->form_validation->set_rules('password', 'Password', 'required');
		
		if($this->form_validation->run() == FALSE){
			$data['title']='Admin Login';
			$data['view']='admin_login.php';
			$this->load->view('admin/layout.php',$data);
		}else{
			$data['username'] = $this->input->post('username');
			$password = $this->input->post('password');
			$data['password'] = md5($password);
			
			$this->load->model('users');
			$responce = $this->users->login($data);
			
			$userId=$this->session->userdata('id');
			if(isset($userId) && !empty($userId)){
				$this->session->set_flashdata('success', 'You logged in successfully');
				header('Location:'.base_url('admin/agent'));
			}else{
				$this->session->set_flashdata('error', 'Username or password is wrong');
				$data['title']='Admin Login';
				$data['view']='admin_login.php';
				$this->load->view('admin/layout.php',$data);
			}
		}
	}

	public function agent($affectedRows=0){
		$agents = $this->agents->getAllagents();
		if($affectedRows > 0){
			$this->session->set_flashdata('success','Promoter status changed successfully.');
		}
		$data['title']='Agents Listing';
		$data['view']='agent.php';
		$data['userData']=$agents;
		$this->load->view('admin/layout.php',$data);
	}
	
	public function addAgent(){
		$this->form_validation->set_rules('name','Name','required');
		$this->form_validation->set_rules('username','Username','required');
		$this->form_validation->set_rules('password','Password','required');
		
		if($this->form_validation->run() == FALSE){
			$data['title']='Add Agents';
			$data['view']='add_agent.php';
			$this->load->view('admin/layout.php',$data);
		}else{
			$addRows=$this->agents->addAgent($this->input->post());
			if($addRows == 1){
				$this->session->set_flashdata('success','Promoter added successfully.');
			}else if($addRows == 2){
				$this->session->set_flashdata('error','Username already exists.');
			}else{
				$this->session->set_flashdata('error','Unable to add promoter.Please try again.');
			}
			$data['title']='Add Agents';
			$data['view']='add_agent.php';
			$this->load->view('admin/layout.php',$data);
		}
	}
	
	public function changeStatus($agentId,$status){
		$affectedRows = $this->agents->changeStatus($agentId,$status);
		
		header('Location:'.base_url('admin/agent/'.$affectedRows));
	}
	
	//Used get the complete listing of products.
	public function product(){
		$this->load->model('products');
		$product['data'] = $this->products->getAllProducts();
		
		$data['title']='Product Listing';
		$data['view']='product.php';
		$data['userData']=$product;
		$this->load->view('admin/layout.php',$data);
	}

	public function searchProduct(){
		$this->form_validation->set_rules('fromDate', 'From Date', 'required');
		$this->form_validation->set_rules('toDate', 'To Date', 'required');
		$this->load->model('products');

		if($this->form_validation->run() == FALSE){
			$product['data'] = $this->products->getAllProducts();
			
			$data['title']='Product Listing';
			$data['view']='product.php';
			$data['userData']=$product;
			$this->load->view('admin/layout.php',$data);
		}else{
			if($this->input->post()){
				$product['data'] = $this->products->dateSeach($this->input->post());
				$product['post'] = $this->input->post();
				$data['title']='Product Listing';
				$data['view']='product.php';
				$data['userData']=$product;
				$this->load->view('admin/layout.php',$data);
			}else{
				header('Location:'.base_url('admin/product'));
			}
		}
	}

	public function export(){
		$this->form_validation->set_rules('fromDate', 'From Date', 'required');
		$this->form_validation->set_rules('toDate', 'To Date', 'required');
		$this->load->model('products');

		if($this->form_validation->run() == FALSE){
			$product['data'] = $this->products->getAllProducts();
			
			$data['title']='Product Listing';
			$data['view']='product.php';
			$data['userData']=$product;
			$this->load->view('admin/layout.php',$data);
		}else{
			if($this->input->post()){
				$this->load->model('products');
				$product['data'] = $this->products->dateSeach($this->input->post());
				$product['post'] = $this->input->post();

				//Loading PHPExcel Library
				$this->load->library('Excel');
				$fileName = './assets/docs/product_listing.xlsx';
				$fileType = PHPExcel_IOFactory::identify($fileName);

				// Read the file
				$objReader = PHPExcel_IOFactory::createReader($fileType);
				$objPHPExcel = $objReader->load($fileName);
				$objPHPExcel->disconnectWorksheets();
				$objPHPExcel->createSheet();
				$objPHPExcel->getActiveSheet()->setTitle("Product Listing");

				// Inserting Data
				$objPHPExcel->setActiveSheetIndex(0)
					->setCellValue('A1', 'Name')
					->setCellValue('B1', 'Phone Number')
					->setCellValue('C1', 'Marital Status')
					->setCellValue('D1', 'Email')
					->setCellValue('E1', 'Agent Name');
				$cnt = 2;
				foreach($product['data'] as $tempData){
					$objPHPExcel->setActiveSheetIndex(0)
					->setCellValue('A'.$cnt, $tempData->name)
					->setCellValue('B'.$cnt, $tempData->phone_number)
					->setCellValue('C'.$cnt, $tempData->marital_status)
					->setCellValue('D'.$cnt, $tempData->email)
					->setCellValue('E'.$cnt, $tempData->pramoterName);
					$cnt++;
				}

				// Write the file
				$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, $fileType);
				$objWriter->save($fileName);
				//Force Download
				header('Content-Type: application/octet-stream');
				header("Content-Transfer-Encoding: Binary"); 
				header("Content-disposition: attachment; filename=\"".basename($fileName)."\""); 
				readfile($fileName);
			}else{
				header('Location:'.base_url('admin/product'));
			}
		}
	}

	public function exportAll(){
		$this->load->model('products');
		$product['data'] = $this->products->getAllProducts();

		//Loading PHPExcel Library
				$this->load->library('Excel');
				$fileName = './assets/docs/product_listing.xlsx';
				$fileType = PHPExcel_IOFactory::identify($fileName);

				// Read the file
				$objReader = PHPExcel_IOFactory::createReader($fileType);
				$objPHPExcel = $objReader->load($fileName);
				$objPHPExcel->disconnectWorksheets();
				$objPHPExcel->createSheet();
				$objPHPExcel->getActiveSheet()->setTitle("Product Listing");

				// Inserting Data
				$objPHPExcel->setActiveSheetIndex(0)
					->setCellValue('A1', 'Name')
					->setCellValue('B1', 'Phone Number')
					->setCellValue('C1', 'Marital Status')
					->setCellValue('D1', 'Email')
					->setCellValue('E1', 'Agent Name');
				$cnt = 2;
				foreach($product['data'] as $tempData){
					$objPHPExcel->setActiveSheetIndex(0)
					->setCellValue('A'.$cnt, $tempData->name)
					->setCellValue('B'.$cnt, $tempData->phone_number)
					->setCellValue('C'.$cnt, $tempData->marital_status)
					->setCellValue('D'.$cnt, $tempData->email)
					->setCellValue('E'.$cnt, $tempData->pramoterName);
					$cnt++;
				}

				// Write the file
				$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, $fileType);
				$objWriter->save($fileName);
				//Force Download
				header('Content-Type: application/octet-stream');
				header("Content-Transfer-Encoding: Binary"); 
				header("Content-disposition: attachment; filename=\"".basename($fileName)."\""); 
				readfile($fileName);
	}

	//Used to get agent start day listing.
	public function startDayAgents(){
		$this->load->model('agents');
		$agentData = $this->agents->getAgentStartDay();

		$data['title']='Agent Start Day Listing';
		$data['view']='agent_start_day.php';
		$data['userData']=$agentData;
		$this->load->view('admin/layout.php',$data);
	}
	
	//Used for admin logout.
	public function logout(){
		$this->session->sess_destroy();
		header('Location:'.base_url('admin/login'));
	}

}
?>