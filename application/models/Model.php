<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Model extends CI_Model 
{
	function __construct()
	{
		parent::__construct();
		$this->load->database();
	}
	function get_all($table=null,$orderby=null)
	{
		if ($table) {
			$data=$this->db->select('*')
			->from($table)
			->order_by($orderby)
			->get()->result_array();
			return $data;			
		}
		return false;
		
		
	}

	function update($table=null,$data=null,$id=null,$field=null){

		if ($table) {
			$this->db->where($field,$id);
			$this->db->update($table,$data);
			return true;			
		}
		return false;	

	}

	function insert($table=null,$data=null){

		if ($table) {
			$this->db->insert($table,$data);
			return $this->db->insert_id();			
		}
		return false;	

	}
	function delete($table=null,$id=null,$field=null){
		if ($table && $id) {
			$this->db->where($field,$id);
			$this->db->delete($table);
			return true;			
		}
		return false;	

	}

	function get_count_rows($table=null,$cond=null){

		if ($table && $cond) {
			$num_rows=$this->db->select('*')
			->from($table)
			->where($cond)
			->get()->num_rows();
			return $num_rows;
		}
		return false;



	}

	function get_all_test(){

		$data=$this->db->select('*')
		->from('products')
		->get()->result_array();

		return $data;
	}

	function get_data_with_condition($table,$cond){
		if ($table && $cond) {
			$result=$this->db->select('*')
			->from($table)
			->where($cond)
			->get()->result_array();
			return $result;
		}
		return false;

	}

	function get_cart_datas($user_id=null){

		if ($user_id) {
		$data=$this->db->select('b.quantity,a.product,a.price,a.tax,b.cart_id')
					->from('products a')
					->join('cart_details b','b.product_id=a.id')
					// ->where('order_id',$order_id)
					->where('b.order_status',0)
					->where('user_id',$user_id)
					->get()->result_array();
		if ($data) {
			return $data;
		}
	}
		return false;

		
	}

	function get_invoice_details(){

		$details=$this->db->select('*')
		->from('order_details a')
		->join('cart_details b','b.order_id=a.id')
		->join('products c','c.id=b.product_id')
		->get()->result_array();

		return $details;

	}

	function get_order_details($order_id=null){

		$details=$this->db->select('*')
		->from('order_details a')
		->join('cart_details b','b.order_id=a.id')
		->join('products c','c.id=b.product_id')
		->where('b.order_id',$order_id)
		->get()->result_array();

		return $details;

	}


}