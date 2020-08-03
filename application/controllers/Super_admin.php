<?php
//session_start();
defined('BASEPATH') OR exit('No direct script access allowed');

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class Super_admin extends CI_Controller {
	
	public function __construct(){
		parent::__construct();
		$type = $this->session->userdata('type');
		if ($type == NULL || $type == 0) {
			redirect('accounts', 'refresh');	
		}

	}

	public function index()
	{
		$this->load->view('admin/item/report');
	}

	public function logout()
	{
		$this->session->unset_userdata('email');
		$this->session->unset_userdata('type');
		$sdata = array();
		$sdata['message'] = '<div class="alert alert-success">You are successfuly logged out!</div>';
		$this->session->set_userdata($sdata);
		redirect('accounts', 'refresh');

	}

/**
 *
 * Inventory
 *
 */

	public function inventory()
	{
		$data = array();

		$data['type'] = $this->session->userdata('type');

		$this->load->view('admin/item/report', $data);
	}

	public function newItem()
	{
		$data = array();
		$data['type'] = $this->session->userdata('type');
		$this->load->view('admin/item/add_new', $data);
	}

	public function saving_new_item()
	{
		$data = array();
		$data['name'] = $this->input->post('name', true);
		$data['stock'] = $this->input->post('stock', true);
		$data['per_day'] = $this->input->post('per_day', true);

		$this->Super_admin_model->add_inventory_item($data);

		$sdata['message'] = "<div class='alert alert-success'>Added successfully!</div>";
		$this->session->set_userdata($sdata);
		redirect('Super_admin/inventory');			
	}

	public function editItem($id)
	{
		$data = array();
		$data['type'] = $this->session->userdata('type');
		
		$data['item_data'] = $this->Super_admin_model->get_inventory_item_by_id($id);

		$this->load->view('admin/item/edit_item', $data);
	}

	public function save_updated_inventory_item()
	{
		$data = array();
		$id = $this->input->post('id', true);
		$data['name'] = $this->input->post('name', true);
		$data['stock'] = $this->input->post('stock', true);
		$data['per_day'] = $this->input->post('per_day', true);

		$this->Super_admin_model->save_updated_inventory_item($id, $data);

		$sdata['message'] = "<div class='alert alert-success'>Updated successfully!</div>";
		$this->session->set_userdata($sdata);
		redirect('Super_admin/inventory');	
	}

	public function delete_inventory_item($id)
	{
		$this->Super_admin_model->delete_inventory_item($id);
		$sdata['message'] = "<div class='alert alert-success'>Deleted successfully!</div>";
		$this->session->set_userdata($sdata);
		redirect('Super_admin/inventory');		
	}

	public function getInventoryItem()
	{
		$id = $this->input->post('id', true);
		$data = $this->Super_admin_model->get_inventory_item_by_id($id);
		echo json_encode($data);
	}

	public function addOrTakeFromInventory()
	{
		$id = $this->input->post('id', true);
		$button_action = $this->input->post('button_action', true);
		$addedOrTaken = $this->input->post('addOrTake', true);
		$stock = $this->input->post('stock', true);


		if($button_action == 'add')
		{
			$stock = $stock + $addedOrTaken;
			$message = '<div class="alert alert-success">Added successfully!</div>';
		}
		if($button_action == 'take')
		{
			$stock = $stock - $addedOrTaken;
			$message = '<div class="alert alert-success">Taken successfully!</div>';
		}

		$this->Super_admin_model->updateInventoryStock($id, $stock);

       $output = array(
            'success'   =>  $message
        );

       echo json_encode($output);
	}

	public function ajax_inventory_items()
	{

		$fetch_data = $this->Super_admin_model->make_datatables_for_inventory();  

           $data = array();  

           foreach($fetch_data as $row)  
           {  
                $sub_array = array(); 
                 
                $sub_array[] = '<a href="'.base_url().'Super_admin/editItem/'.$row->id.'">'.$row->name.'</a>';  

                $sub_array[] = $row->stock; 

                $sub_array[] = $row->per_day == 0 ? '---' : $row->per_day; 

                $sub_array[] = $row->per_day == 0 ? '---' : number_format($row->stock / $row->per_day, 1);  

                $sub_array[] = '<a href="#" class="btn btn-default btn-sm add_to_stock" id="'.$row->id.'"><i class="glyphicon glyphicon-plus"></i></a>
                <a href="#" class="btn btn-default btn-sm take_from_stock" id="'.$row->id.'"><i class="glyphicon glyphicon-minus"></i></a>';  
  
                $data[] = $sub_array;                
           }  
           $output = array(  
                "draw"                  =>     intval($_POST["draw"]),  
                "recordsTotal"          =>     $this->Super_admin_model->count_all_inventory_items(),  
                "recordsFiltered"       =>     $this->Super_admin_model->get_filtered_data_for_inventory_items(),  
                "data"                  =>     $data  
           );  
           echo json_encode($output); 
	}

}