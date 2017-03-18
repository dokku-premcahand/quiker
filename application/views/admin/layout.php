<?php

$newData = "";
if(!empty($userData)){
	$newData['newData'] = $userData;
}

$this->load->view('admin/header.php',$title);

$this->load->view('admin/'.$view,$newData);

$this->load->view('admin/footer.php');

?>