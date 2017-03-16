<?php

$this->load->view('header.php',$title);

if(isset($post) && !empty($post)){
	$this->load->view($view,$post);
}else{
	$this->load->view($view);
}

$this->load->view('footer.php');

?>