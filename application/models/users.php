<?php
class Users extends CI_Model {
	
	public function login($data){
		$sql = 'SELECT * FROM users WHERE username="'.$data['username'].'" AND password="'.$data['password'].'"';
		$query = $this->db->query($sql);
		$result = $query->result();
		$resultCount = count($result);
		if(isset($resultCount) && !empty($resultCount) && $resultCount == 1){
			$type = ($result[0]->type == 1) ? 'admin' : 'backoffice';
			$userdata = array('id'=>$result[0]->id,'username'=>$result[0]->username,'type'=>$type);
			$this->session->set_userdata($userdata);
			return $userdata;
		}
		return false;
	}

}