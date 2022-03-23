<?php
defined('BASEPATH') OR exit('No direct script access allowed');
// require('./mpdf/mpdf.php');

class Mycart extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model("Model");
	}

	public function index()
	{		
		$this->load->view('header');
		$this->load->view('products_view');
		$this->load->view('footer');
	}

	function product()
	{
		$this->load->view('header');
		$this->load->view('cart_view');
		$this->load->view('footer');
	}


	function getProducts(){


		$table='products';
		$orderby="id DESC";
		$data['list'] = $this->Model->get_all($table,$orderby);
		// $table='discount';
		// $orderby="discount ASC";
		// $data['discount_details'] = $this->Model->get_all($table,$orderby);
		echo json_encode($data);

	}

	function SaveProducts(){

		if ($_SERVER['REQUEST_METHOD']==='POST')
      	{
	        $this->form_validation->set_rules('product', 'Product', 'required|alpha_numeric_spaces');
	        $this->form_validation->set_rules('price', 'Price','required|numeric');

	        if ($this->form_validation->run()==false)
	        {
	        	echo json_encode(array('response' => '3', 'error' => $this->form_validation->error_array()));

	        }else{

	        	$table='products';
				$data=array('product'=>$_POST['product'],
							'price'=>$_POST['price']
							);

				if (!empty($_POST['product_id'])) {
					$id=$_POST['product_id'];
					$field="id";
					$this->db->trans_start();
					$this->Model->update($table,$data,$id,$field);
					if ($this->db->trans_complete()) {
						echo json_encode(array('response' => '1'));
					} else {
						echo json_encode(array('response' => '2'));
					}
					
				}else{
				$condition="product='".$_POST['product']."' and price='".$_POST['price']."'";
				$chk=$this->Model->get_count_rows($table,$condition);
				if(!$chk){
					$data['status']=1;
					$this->db->trans_start();
					$this->Model->insert($table,$data);
					if ($this->db->trans_complete()) {
					echo json_encode(array('response' => '1'));
					} else {
					echo json_encode(array('response' => '2'));
					}
				}else{
					echo json_encode(array('response' => '4'));
				}


				}

			}
		}

	}


	public function UpdateStatus(){

		if ($_SERVER['REQUEST_METHOD']==='POST')
      	{
      		if ($_POST['id']) {
      			$table='products';
				$data['status']=$_POST['status'];
				$id=$_POST['id'];
				$field="id";

				$this->db->trans_start();
				$this->Model->update($table,$data,$id,$field);
				if ($this->db->trans_complete()) {
					echo json_encode(array('response' => '1'));
				} else {
					echo json_encode(array('response' => '2'));
				}
      		}

      	}

	}


	public function delete_product(){

		if ($_SERVER['REQUEST_METHOD']==='POST')
      	{
      		if ($_POST['id']) {
      			$table='products';
				$id=$_POST['id'];
				$field="id";
				$this->db->trans_start();
				$this->Model->delete($table,$id,$field);
				if ($this->db->trans_complete()) {
					echo json_encode(array('response' => '1'));
				} else {
					echo json_encode(array('response' => '2'));
				}
      		}

      	}

	}


	public function get_all_products_details(){

		if ($_SERVER['REQUEST_METHOD']==='POST')
      	{

      	$table='products';
		$cond="status=1";
		$data['list'] = $this->Model->get_data_with_condition($table,$cond);

		$table='cart_details';
		$condition="user_id=4 and order_status=0";
		$data['count_cart']=$this->Model->get_count_rows($table,$condition);

		$table='order_details';
		$condition="user_id=4";
		$data['invoice']=$this->Model->get_count_rows($table,$condition);

		echo json_encode($data);

      	}



	}


	public function add_to_cart(){
		if ($_SERVER['REQUEST_METHOD']==='POST')
      	{

      		if ($_POST['product_id']) {

      			$table='cart_details';
				$data=array('product_id'=>$_POST['product_id'],
							'quantity'=>$_POST['quantity'],
							'user_id'=>4
							);
				$this->db->trans_start();
				$this->Model->insert($table,$data);
				if ($this->db->trans_complete()) {
				echo json_encode(array('response' => '1'));
				} else {
				echo json_encode(array('response' => '2'));
				}
      		}


      	}

	}

	public function get_cart_details(){
		// $order_id=18;
		$user_id=4;
		$data['cart_details'] = $this->Model->get_cart_datas($user_id);

		$table='discount';
		$orderby="discount_id ASC";
		$data['discount'] = $this->Model->get_all($table,$orderby);

		$table='tax';
		$orderby="tax_id ASC";
		$data['tax'] = $this->Model->get_all($table,$orderby);
		echo json_encode($data);

		
	}

	public function remove_cart_item(){
		if ($_SERVER['REQUEST_METHOD']==='POST')
      	{
      		if ($_POST['id']) {
      			$table='cart_details';
				$id=$_POST['id'];
				$field="cart_id";
				$this->db->trans_start();
				$this->Model->delete($table,$id,$field);
				if ($this->db->trans_complete()) {
					echo json_encode(array('response' => '1'));
				} else {
					echo json_encode(array('response' => '2'));
				}
      		}

      	}
      }

			public function Place_order(){

				if ($_SERVER['REQUEST_METHOD']==='POST')
			{

				

				$table="order_details";
				$data = array(
					'without_tax' => $_POST['with_out_tax'],
					'tax' => $_POST['tax'],
					'with_tax' =>$_POST['with_tax'] ,
					'discount' => $_POST['discount'],
					'total' => $_POST['grand_total'],
					'user_id'=>4,
				);

				$this->db->trans_start();
				$order_id=$this->Model->insert($table,$data);
				
					if ($this->db->trans_complete()) {
					$table='cart_details';
					$cart['order_status']=1;
					$cart['order_id']=$order_id;
					$id='4';
					$field="user_id";
					$this->Model->update($table,$cart,$id,$field);
					echo json_encode(array('response' => '1'));
					} else {
					echo json_encode(array('response' => '2'));
					}

			}

			}


			public function invoice_details(){

				$table='order_details';
				$orderby="id DESC";
			$data['invoice_details'] = $this->Model->get_invoice_details($table,$orderby);
				$this->load->view('header');
				$this->load->view('invoice_view',$data);
				$this->load->view('footer');

			}



		function invoice($order_id)
		{

		$invoice = $this->Model->get_order_details($order_id);

		$mpdf = new mPDF('',  
		'A4',
		10, 
		'Courier New', 
		15,   
		13,  
		3,    
		16,    
		9,    
		9,     
		'P'
		);

		ob_start(); ?>
		<div class="row">
		<div class="col-sm-12">
			<span style="text-align: center;"><h1>Invoice</h1></span><hr>
		</div>
		</div>
		<?php $header = ob_get_contents();
		ob_end_clean();

		$mpdf->WriteHTML($header);

		ob_start(); ?>
		<div class="row">
		<span><b>{PAGENO} of {nbpg}</b></span>
		</div>
		<?php $footer = ob_get_contents();
		ob_end_clean();

		ob_start(); ?>

		<div class="row">
		<div class="col-sm-12">
			<h4 align="right">Date: <?= date('d-m-Y') ?></h4>
				<table border='1' cellpadding='7px' style="border-collapse: collapse;">
				<thead>
				<tr>
					<th width="10%">Sl No.</th>
					<th width="10%">Product</th>
					<th width="10%">Price </th>
					<th width="10%">Quantity</th>
					<th width="10%">Total</th>
				</tr>
				</thead>
				<tbody>
				<?php
				$sub_total = 0;
				foreach ($invoice as $key=>$val) { ?>
					<tr>
						<td align="center"><?= $key+1; ?></td>
						<td align="center"><?= $val['product']; ?></td>
						<td align="center">$ <?= $val['price']; ?></td>
						<td align="center"><?= $val['quantity'];?></td>
						<td align="center">$ 
							<?php 
							$total = $value['price'] * $value['quantity'];
							$sub_total = $sub_total + ($value['price'] * $value['quantity']);
							echo $total;
							?>
						</td>
					</tr>
					<?php } ?>

				<tr>
					<th colspan="5"></th>
				</tr>
				<tr>
					<th colspan="4">Subtotal:</th>
					<td align="center">
						<span>$<?= $invoice[0]['without_tax'];?></span>    
					</td>
				</tr>

				<tr>
					<th colspan="4">Tax (<?= $order_details->tax_per ?>%):</th>
					<td align="center">
						<span>$<?= $invoice[0]['tax']  ?></span>   
					</td>
				</tr>

				<tr>
					<th colspan="4">Subtotal With tax:</th>
					<td align="center">
						<span>$<?= $invoice[0]['with_tax']; ?></span>   
					</td>
				</tr>

				<tr>
					<th colspan="4">Discount:</th>
					<td align="center">
						<span>$<?= $invoice[0]['discount']; ?></span>   
					</td>
				</tr>

				<tr>
					<th colspan="4">Grand Total:</th>
					<td align="center">
						<span style="color: red; font-weight: bold;font-size: 1.5em;">$<?= $invoice[0]['total']; ?></span>  
					</td>
				</tr>
				</tbody>
				</table>
		</div>
		</div>

		<?php $content = ob_get_contents();
		ob_end_clean();
echo $content;
		$mpdf->WriteHTML($content);
		$mpdf->SetFooter($footer);
		$mpdf->Output('invoice','I');
		}

	function discount_details()
	{
		$table='discount';
		$orderby="discount_id ASC";
		$data['list'] = $this->Model->get_all($table,$orderby);
		$this->load->view('header');
		$this->load->view('discount_view', $data);
		$this->load->view('footer');
	}

	function getDiscounts(){


		$table='discount';
		$orderby="discount ASC";
		$data['list'] = $this->Model->get_all($table,$orderby);
		echo json_encode($data);

	}


	function Savediscounts(){

		if ($_SERVER['REQUEST_METHOD']==='POST')
      	{
	        $this->form_validation->set_rules('discount', 'Discount', 'required|numeric');

	        if ($this->form_validation->run()==false)
	        {
	        	echo json_encode(array('response' => '3', 'error' => $this->form_validation->error_array()));

	        }else{

	        	$table='discount';
				$data=array('discount'=>$_POST['discount']
							);

				if (!empty($_POST['discount_id'])) {
					$id=$_POST['discount_id'];
					$field="discount_id";
					$this->db->trans_start();
					$this->Model->update($table,$data,$id,$field);
					if ($this->db->trans_complete()) {
						echo json_encode(array('response' => '1'));
					} else {
						echo json_encode(array('response' => '2'));
					}
					
				}else{
				$condition="discount=".$_POST['discount'];
				$chk=$this->Model->get_count_rows($table,$condition);
				if(!$chk){					
					$this->db->trans_start();
					$this->Model->insert($table,$data);
					if ($this->db->trans_complete()) {
					echo json_encode(array('response' => '1'));
					} else {
					echo json_encode(array('response' => '2'));
					}
				}else{
					echo json_encode(array('response' => '4'));
				}


				}

			}
		}

	}

	public function delete_discount(){

		if ($_SERVER['REQUEST_METHOD']==='POST')
      	{
      		if ($_POST['id']) {
      			$table='discount';
				$id=$_POST['id'];
				$field="discount_id";
				$this->db->trans_start();
				$this->Model->delete($table,$id,$field);
				if ($this->db->trans_complete()) {
					echo json_encode(array('response' => '1'));
				} else {
					echo json_encode(array('response' => '2'));
				}
      		}

      	}

	}

	
	

}