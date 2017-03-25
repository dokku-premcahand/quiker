<?php
class Products extends CI_Model {
	public function getAllProducts(){
		$sql="SELECT pd.*,pr.name as pramoterName FROM products pd 
			JOIN agents pr ON pr.id=pd.agent_id 
			WHERE pd.flag <> 1
			ORDER BY pd.date";
		$query=$this->db->query($sql);
		$resultData=$query->result();
		return $resultData;
	}

	public function updateProductStatus($productStr){
		$sql = "UPDATE products SET flag = 1 WHERE id IN(".$productStr.")";
		$this->db->query($sql);
		return $this->db->affected_rows();
	}

	public function dateSeach($post){
		$sql = "SELECT pd.*,pr.name as pramoterName FROM products pd 
			JOIN agents pr ON pr.id=pd.agent_id 
			WHERE pd.date BETWEEN '".$post['fromDate']."' AND '".$post['toDate']."'
			ORDER BY pd.date";
			
		$query=$this->db->query($sql);
		$resultData=$query->result();
		return $resultData;
	}

	public function getLatestProducts($id){
		$sql="SELECT pd.*,pr.name as pramoterName FROM products pd 
			JOIN agents pr ON pr.id=pd.agent_id 
			WHERE pd.flag <> 1 and pd.id > ".$id."
			ORDER BY pd.date";
		$query=$this->db->query($sql);
		$resultData=$query->result();
		return $resultData;
	}

	//Will return max and min dates for complete export
	public function getMaxMinDates(){
		$sql = "SELECT max(date) AS maxDate, min(date) AS minDate FROM products WHERE flag <> 1";
		$query=$this->db->query($sql);
		$resultData=$query->result();
		$data['maxDate'] = substr($resultData[0]->maxDate, 0, 10);
		$data['minDate'] = substr($resultData[0]->minDate, 0, 10);
		$dateRange = $this->generateDateRange($data['minDate'],$data['maxDate']);
		return $dateRange;
	}

	public function getUniqueAgents(){
		$sql = "SELECT distinct ag.username FROM products pd LEFT JOIN agents ag ON ag.id = pd.agent_id 
		WHERE pd.date BETWEEN '".$post['fromDate']."' AND '".$post['toDate']."'";
		$query=$this->db->query($sql);
		$resultData=$query->result();
		$usernameArray = array();
		foreach($resultData as $data){
			$usernameArray[] = $data->username;
		}
		return $usernameArray;
	}

	public function getAgentSeq($username){
		$sql = "SELECT distinct pd.sequence FROM products pd 
				LEFT JOIN agents ag ON ag.id = pd.agent_id
				WHERE pd.flag <> 1 AND ag.username LIKE '%".$username."%'";
		$query=$this->db->query($sql);
		$resultData=$query->result();
		$sequenceArray = array();
		foreach($resultData as $data){
			$sequenceArray[] = $data->sequence;
		}
		return $sequenceArray;
	}

	//Will return date range between 2 dates.
	private function generateDateRange($strDateFrom,$strDateTo)
	{
		$begin = new DateTime($strDateFrom);
		$end = new DateTime($strDateTo);
		$end->add(new DateInterval('P1D'));

		$daterange = new DatePeriod($begin, new DateInterval('P1D'), $end);
		$dateArray = array();
		foreach($daterange as $date){
			$dateArray[] = $date->format("d_m_Y");
		}
		return $dateArray;
	}

	public function exportSelected($post){
		$productStr = @implode($post['product'],',');

		$sql="SELECT pd.*,pr.name as pramoterName FROM products pd 
			JOIN agents pr ON pr.id=pd.agent_id 
			WHERE pd.id IN (".$productStr.")
			ORDER BY pd.date";
		$query=$this->db->query($sql);
		$resultData=$query->result();
		return $resultData;
	}

	public function generateDateRangeSelected($products){
		$sql = "SELECT max(date) AS maxDate, min(date) AS minDate FROM products WHERE id IN (".$products.")";
		$query=$this->db->query($sql);
		$resultData=$query->result();
		$data['maxDate'] = substr($resultData[0]->maxDate, 0, 10);
		$data['minDate'] = substr($resultData[0]->minDate, 0, 10);
		$dateRange = $this->generateDateRange($data['minDate'],$data['maxDate']);
		return $dateRange;
	}

	public function getUniqueAgentsSelected($products){
		$sql = "SELECT distinct ag.username FROM products pd LEFT JOIN agents ag ON ag.id = pd.agent_id 
		WHERE pd.id IN (".$products.")";
		$query=$this->db->query($sql);
		$resultData=$query->result();
		$usernameArray = array();
		foreach($resultData as $data){
			$usernameArray[] = $data->username;
		}
		return $usernameArray;
	}
}