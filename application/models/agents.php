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
	
	public function setStartDay($agentId){
		$timePart = $this->getStartDay($agentId);
		
		if($timePart == ""){
			$currentDateTime = date('Y-m-d H:i:s');
			$sql = "INSERT INTO start_day value (null, ".$agentId.", '".$currentDateTime."')";
			$this->db->query($sql);
		}
	}
	
	public function getStartDay($agentId){
		$sql = "SELECT start_date_time FROM start_day WHERE agent_id = ".$agentId." AND start_date_time >= '".date('Y-m-d 00:00:00')."' ORDER BY id ASC LIMIT 0,1";
		$query = $this->db->query($sql);
		$result = $query->result();
		$timePart = "";
		
		if(!empty($result)){
			$timePart = date('h:i A', strtotime($result[0]->start_date_time));
		}
		
		return $timePart;
	}
	
	public function uploadProduct($post,$todayCount){
		$agentId = $this->session->userdata('id');
		$currentTime = date('Y-m-d H:i:s');
		$sequence = $todayCount + 1;
		$isDuplicate = $this->getIsDuplicate($post['phonenumber'], $post['aadhar']);
		
		$sql = "INSERT INTO products VALUES (null,'".$post['name']."','".$post['phonenumber']."','".$post['marital_status']."', '".$post['payment_type']."', '".$post['aadhar']."', '".$post['father_name']."', '".$post['father_age']."', '".$post['caste']."', '".$post['house_type']."', '".$post['salary']."',
			'".$post['email']."',0,".$sequence.", ".$agentId.", '".$currentTime."', ".$isDuplicate.")";
		$this->db->query($sql);
		$affectedRows = $this->db->affected_rows();
		return $affectedRows;
	}
	
	private function getIsDuplicate($phoneNumber, $aadhar){
		$sqlStr = "";
		$isDuplicate = 0;
		if(!empty($aadhar)){
			$sqlStr = " OR aadhar = '".$aadhar."'";
		}
		
		$sql = "SELECT id FROM products where phone_number = '".$phoneNumber."'".$sqlStr;
		$query=$this->db->query($sql);
		$result = $query->result();
		if(!empty($result)){
			$isDuplicate = 1;
		}
		
		return $isDuplicate;
	}
	
	public function getTodayCount($agentId){
		$sql = "SELECT count(id) as totalCount FROM products where agent_id = ".$agentId." and date >= '".date('Y-m-d 00:00:00')."'";
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

	public function getAgentStartDay(){
		$todaysDate = date('Y-m-d').' 00:00:00';
		$sql = "SELECT ag.id,ag.name,ag.username,sd.start_date_time FROM agents ag 
				LEFT JOIN start_day sd ON ag.id = sd.agent_id
				WHERE start_date_time >= '".$todaysDate."'";
		$query = $this->db->query($sql);
		$result = $query->result();
		return $result;
	}

	public function dateAgentSeach($post){
		$sql = "SELECT ag.name,DATE_FORMAT(sd.start_date_time,'%d-%m-%Y') as date, DATE_FORMAT(sd.start_date_time,'%h:%i %p')
				as time FROM agents ag LEFT JOIN start_day sd ON ag.id = sd.agent_id
				WHERE start_date_time >= '".$post['fromDate']." 00:00:00' AND start_date_time <= '".$post['toDate']." 23:59:59'";
		$query = $this->db->query($sql);
		$result = $query->result();
		return $result;
	}
}