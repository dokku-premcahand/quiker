<?php
class Products extends CI_Model {
	public function getAllProducts(){
		$sql="SELECT pd.*,pr.name as pramoterName FROM products pd JOIN agents pr ON pr.id=pd.agent_id ORDER BY pd.id DESC";
		$query=$this->db->query($sql);
		$resultData=$query->result();
		return $resultData;
	}
}