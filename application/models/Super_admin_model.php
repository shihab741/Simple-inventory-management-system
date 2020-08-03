<?php
	class Super_admin_model extends CI_Model
	{
		

		public function allItems()
		{
			return $this->db->select('*')->from('item')->get()->result();
		}

		public function add_inventory_item($data)
		{
			$this->db->insert('item', $data);
		}

		public function get_inventory_item_by_id($id)
		{
			return $this->db->select('*')->from('item')->where('id', $id)->get()->row();			
		}

		public function save_updated_inventory_item($id, $data)
		{
			$this->db->where('id', $id)->update('item', $data);			
		}

		public function delete_inventory_item($id)
		{
			$this->db->where('id', $id)->delete('item');					
		}

// For ajax inventory
		
      function make_ajax_query_for_inventory_items()  
      {  
      	$order_column = array("name", "stock", "per_day", null, null); 

           $this->db->select('*');  
           $this->db->from('item');  
           if(isset($_POST["search"]["value"]))  
           {  
                $this->db->like("name", $_POST["search"]["value"]);  
           }  
           if(isset($_POST["order"]))  
           {  
                $this->db->order_by($order_column[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);  
           }  
           else  
           {  
                $this->db->order_by('name', 'ASC');  
           }  
      }  

      function make_datatables_for_inventory()
      {  
           $this->make_ajax_query_for_inventory_items();  
           if($_POST["length"] != -1)  
           {  
                $this->db->limit($_POST['length'], $_POST['start']);  
           }  
           $query = $this->db->get();  
           return $query->result();  
      }  

      function get_filtered_data_for_inventory_items()
      {  
           $this->make_ajax_query_for_inventory_items();  
           $query = $this->db->get();  
           return $query->num_rows();  
      }       

      function count_all_inventory_items()  
      {  
           $this->db->select("*");  
           $this->db->from('item');  
           return $this->db->count_all_results();  
      }  

  	function updateInventoryStock($id, $stock)
 	{
		$this->db->set('stock', $stock)->where('id', $id)->update('item');    	
  	}


}