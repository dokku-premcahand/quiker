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
				header('Location:'.base_url('backoffice/login'));
			}
		}
		$this->load->model('agents');
	}

	//Used for back office login function.
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

	//Used to filter products listing based on date filter.
	public function searchProduct(){
		$this->form_validation->set_rules('fromDate', 'From Date', 'required');
		$this->form_validation->set_rules('toDate', 'To Date', 'required');
		$this->load->model('products');

		if($this->form_validation->run() == FALSE){
			$product['data'] = $this->products->getAllProducts();
			
			$data['title']='Product Listing';
			$data['view']='product.php';
			$data['userData']=$product;
			$this->load->view('backoffice/layout.php',$data);
		}else{
			if($this->input->post()){
				$product['data'] = $this->products->dateSeach($this->input->post());
				$product['post'] = $this->input->post();
				$data['title']='Product Listing';
				$data['view']='product.php';
				$data['userData']=$product;
				$this->load->view('backoffice/layout.php',$data);
			}else{
				header('Location:'.base_url('backoffice/product'));
			}
		}
	}

	//Used to export products based on date filter.
	public function export(){
		$this->form_validation->set_rules('fromDate', 'From Date', 'required');
		$this->form_validation->set_rules('toDate', 'To Date', 'required');
		$this->load->model('products');

		if($this->form_validation->run() == FALSE){
			$product['data'] = $this->products->getAllProducts();
			
			$data['title']='Product Listing';
			$data['view']='product.php';
			$data['userData']=$product;
			$this->load->view('backoffice/layout.php',$data);
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
					->setCellValue('A1', 'Sequence')
					->setCellValue('B1', 'Name')
					->setCellValue('C1', 'Phone Number')
					->setCellValue('D1', 'Marital Status')
					->setCellValue('E1', 'Type')
					->setCellValue('F1', 'Email')
					->setCellValue('G1', 'Agent Name')
					->setCellValue('H1', 'Date');
				$cnt = 2;
				foreach($product['data'] as $tempData){
					$objPHPExcel->setActiveSheetIndex(0)
					->setCellValue('A'.$cnt, $tempData->sequence)
					->setCellValue('B'.$cnt, $tempData->name)
					->setCellValue('C'.$cnt, $tempData->phone_number)
					->setCellValue('D'.$cnt, $tempData->marital_status)
					->setCellValue('E'.$cnt, $tempData->payment_type)
					->setCellValue('F'.$cnt, $tempData->email)
					->setCellValue('G'.$cnt, $tempData->pramoterName)
					->setCellValue('H'.$cnt, $tempData->date);
					$cnt++;
				}

				// Write the file
				$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, $fileType);
				$objWriter->save($fileName);
				//Force Download the generated excel.
				// header('Content-Type: application/octet-stream');
				// header("Content-Transfer-Encoding: Binary"); 
				// header("Content-disposition: attachment; filename=\"".basename($fileName)."\""); 
				// readfile($fileName);
				$this->downloadProduct($this->input->post('fromDate'),$this->input->post('toDate'));
			}else{
				header('Location:'.base_url('backoffice/product'));
			}
		}
	}

	//Used to export all the products with out any date filter.
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
			->setCellValue('E1', 'Agent Name')
			->setCellValue('F1', 'Date');
		$cnt = 2;
		foreach($product['data'] as $tempData){
			$objPHPExcel->setActiveSheetIndex(0)
			->setCellValue('A'.$cnt, $tempData->name)
			->setCellValue('B'.$cnt, $tempData->phone_number)
			->setCellValue('C'.$cnt, $tempData->marital_status)
			->setCellValue('D'.$cnt, $tempData->email)
			->setCellValue('E'.$cnt, $tempData->pramoterName)
			->setCellValue('E'.$cnt, $tempData->date);
			$cnt++;
		}

		// Write the file
		$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, $fileType);
		$objWriter->save($fileName);
		// $this->downloadProduct();
	}
	
	//Used get the complete listing of products.
	public function product(){
		$this->load->model('products');
		$product['data'] = $this->products->getAllProducts();
		
		$data['title']='Product Listing';
		$data['view']='product.php';
		$data['userData']=$product;
		$this->load->view('backoffice/layout.php',$data);
	}

	//Used to update the listing. Called by ajax.
	public function latestProducts(){
		$latestProductId = $this->input->post('id');
		$this->load->model('products');
		$product = $this->products->getLatestProducts($latestProductId);
		if(!empty($product)){
			echo json_encode($product);
		}else{
			echo 1;
		}
	}
	
	//Used to export the images upload by agent.
	public function downloadProduct($fromDate,$toDate){
		$this->load->helper('directory');
		$this->load->library('zip');
		$dates = $this->products->generateDateRange($fromDate,$toDate);
		$agents = $this->products->getUniqueAgents($fromDate,$toDate);
		
		foreach($dates as $date){
			$fromPath = 'assets/uploads/'.$date;
			$toPath = 'assets/imagesZip/'.$date;
			if(file_exists($fromPath)){
				foreach($agents as $agent){
					if(file_exists($fromPath.'/'.$agent)){
						$sequences = $this->products->getAgentSeq($agent);
						foreach($sequences as $sequence){
							if(file_exists($fromPath.'/'.$agent.'/'.$sequence)){
								$folderData = scandir($fromPath.'/'.$agent.'/'.$sequence);
								mkdir($toPath,0777);
								mkdir($toPath.'/'.$agent,0777);
								mkdir($toPath.'/'.$agent.'/'.$sequence,0777);
								foreach ($folderData as  $file) {
									if(strlen($file) > 2){
										$fromFilePath = $fromPath.'/'.$agent.'/'.$sequence.'/'.$file;
										$toFilePath = $toPath.'/'.$agent.'/'.$sequence.'/'.$file;
										copy($fromFilePath,$toFilePath);
									}
								}
							}
						}
					}
				}
			}
		}

		copy('./assets/docs/product_listing.xlsx','./assets/imagesZip/product_listing.xlsx');
		$path = 'assets/imagesZip';
		$this->zip->read_dir($path,FALSE);

		unlink('./assets/imagesZip/product_listing.xlsx');
		foreach($dates as $date){
			$toPath = 'assets/imagesZip/'.$date;
			if(file_exists($toPath)){
				foreach($agents as $agent){
					if(file_exists($toPath.'/'.$agent)){
						$sequences = $this->products->getAgentSeq($agent);
						foreach($sequences as $sequence){
							if(file_exists($toPath.'/'.$agent.'/'.$sequence)){
								$folderData = scandir($toPath.'/'.$agent.'/'.$sequence);
								foreach ($folderData as  $file) {
									if(strlen($file) > 2){
										$toFilePath = $toPath.'/'.$agent.'/'.$sequence.'/'.$file;
										unlink($toFilePath);
									}
								}
								rmdir($toPath.'/'.$agent.'/'.$sequence);
							}
						}
						rmdir($toPath.'/'.$agent);
					}
				}
				rmdir($toPath);
			}
		}
		$this->zip->download('Export.zip');
	}

	//Used to change the product status
	public function changeProductStatus(){
		$productArr = $this->input->post('product');
		$productStr = @implode($productArr,',');
		$this->load->model('products');
		$product = $this->products->updateProductStatus($productStr);
		if($product > 0){
			$this->session->set_flashdata('success','Product/s status updated successfully');
		}else{
			$this->session->set_flashdata('error','Error occured. Please try after sometime.');
		}
		header('Location:'.base_url('backoffice/product'));
	}
	
	public function logout(){
		$this->session->sess_destroy();
		header('Location:'.base_url('backoffice/login'));
	}
}
