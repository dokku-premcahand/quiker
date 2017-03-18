<?php
class Agents extends CI_Model {
	
	public function login($data){
		$sql = 'SELECT * FROM agents WHERE username="'.$data['username'].'" AND password="'.$data['password'].'"';
		$query = $this->db->query($sql);
		$result = $query->result();
		$resultCount = count($result);
		if(isset($resultCount) && !empty($resultCount) && $resultCount == 1){	
			$userdata = array('id'=>$result[0]->id,'name'=>$result[0]->name,'username'=>$result[0]->username,
				'status'=>$result[0]->status, 'type'=>'agent');
			if($result[0]->status != 'disabled'){
				$this->session->set_userdata($userdata);
			}
			return $userdata;
		}
		return false;
	}
	
	public function getStatus($agentId){
		$sql = 'SELECT status FROM agents WHERE id = '.$agentId;
		$query = $this->db->query($sql);
		$result = $query->result();
		return $result[0]->status;
	}
	
	public function uploadProduct($post,$todayCount){
		$agentId = $this->session->userdata('id');
		$currentTime = date('Y-m-d H:i:s');
		$sequence = $todayCount + 1;
		
		$sql = "INSERT INTO products VALUES (null,'".$post['name']."','".$post['phonenumber']."','".$post['marital_status']."',
			'".$post['email']."',1,".$sequence.", ".$agentId.", '".$currentTime."')";
		$this->db->query($sql);
		$affectedRows = $this->db->affected_rows();
		return $affectedRows;
	}
	
	public function getTodayCount($agentId){
		$sql = "SELECT count(id) as totalCount FROM products where agent_id = ".$agentId." and date > '".date('Y-m-d 00:00:00')."'";
		$query=$this->db->query($sql);
		$result = $query->result();
		
		return $result[0]->totalCount;		
	}
	
	public function getAllAgents(){
		$sql = "SELECT * FROM agents";
		$query=$this->db->query($sql);
		$result = $query->result();
		return $result;
	}

	public function changeStatus($pramoterId,$status){
		$sql = "UPDATE agents SET status='".$status."' WHERE id=".$pramoterId;
		$this->db->query($sql);
		$affectedRows = $this->db->affected_rows();
		return $affectedRows;
	}
	
	public function addAgent($post){
		$sql = "SELECT * FROM agents WHERE username LIKE '%".$post['username']."%'";
		$query = $this->db->query($sql);
		$result = $query->result();
		
		if(count($result) > 0){
			$affectedRows=2;
		}else{
			$password = md5($post['password']);
			$sql = "INSERT INTO agents VALUES ('','".$post['name']."','".$post['username']."','".$password."','enabled')";
			$this->db->query($sql);
			$affectedRows = $this->db->affected_rows();
		}
		return $affectedRows;
	}
}