<?php

$newData = "";
if(!empty($userData)){
	$newData['newData'] = $userData;
}

$this->load->view('backoffice/header.php',$title);

$this->load->view('backoffice/'.$view,$newData);

$this->load->view('backoffice/footer.php');

?>