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
		$sql = "UPDATE products SET flag = 1 WHERE id IN('".$productStr."')";
		$this->db->query($sql);
		return $this->db->affected_rows();
	}
}