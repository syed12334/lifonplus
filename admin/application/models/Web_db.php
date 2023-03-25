<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Web_db extends CI_Model{
   

    //functions
    function getCouponsList($det){
        $post_data = $this->input->post(null, true);
        
        $order_column = array("c.id","c.coupon_code", "c.coupon_title", "c.status");
        $this->db->select("c.id, c.coupon_code, c.cname,c.state,c.district,c.taluk,c.mphone,c.coupon_title,DATE_FORMAT(c.from_date,'%d-%m-%Y') as from_date,DATE_FORMAT(c.to_date,'%d-%m-%Y') as to_date,no_of_users,IF(discount_type=1,'Flat Discount','Percentage Discount') as discount_type,amount, c.status");
        $this->db->from('coupons c');
        
        $where = array("c.status!="=>-1);
        $this->db->where($where);
        if(isset($post_data["search"]["value"])){
            $this->db->where(" ( c.coupon_code like '%{$post_data["search"]["value"]}%' ) ");
        }
        
        if(isset($post_data["order"])){
            $this->db->order_by($order_column[$post_data['order']['0']['column']]." ".$post_data['order']['0']['dir']);
        }else{
            $this->db->order_by("c.id desc");
        }
        
        if($post_data["length"] != -1){
            
            if($post_data['start'] > 0){
                $this->db->limit($post_data['length'], $post_data['start']);
            }else{
                $this->db->limit($post_data['length']);
            }
            
        }
        $q = $this->db->get();
        return $q !== FALSE ? $q->result() : array();
        
    }
	
	/******healthtips*****/
	 function getHealthCategoryList($det){
        $post_data = $this->input->post(null, true);
        
        $order_column = array("c.id","c.id","c.name", "c.status");
        $this->db->select("c.id, c.name, c.status");
        $this->db->from('health_category c');
        
        $where = array("c.status!="=>-1);
        $this->db->where($where);
        if(isset($post_data["search"]["value"])){
            $this->db->where(" ( c.name like '%{$post_data["search"]["value"]}%' ) ");
        }
        
        if(isset($post_data["order"])){
            $this->db->order_by($order_column[$post_data['order']['0']['column']]." ".$post_data['order']['0']['dir']);
        }else{
            $this->db->order_by("c.id desc");
        }
        
        if($post_data["length"] != -1){
            
            if($post_data['start'] > 0){
                $this->db->limit($post_data['length'], $post_data['start']);
            }else{
                $this->db->limit($post_data['length']);
            }
            
        }
        $q = $this->db->get();
        return $q !== FALSE ? $q->result() : array();
        
    }
	
	
	function getHealthtipsList($det){
        $post_data = $this->input->post(null, true);
        
        $order_column = array("c.id","ca.name", "c.title", "c.status");
        $this->db->select("c.id, ca.name, c.title,DATE_FORMAT(c.date_time,'%d-%m-%Y %h:%i %p') as datetime,descr,image_path, c.status");
        $this->db->from('healthtips c');
        $this->db->join('health_category ca','ca.id=c.cat_id','inner');
        $where = array("c.status!="=>-1);
        $this->db->where($where);
        if(isset($post_data["search"]["value"])){
            $this->db->where(" ( ca.name like '%{$post_data["search"]["value"]}%' or c.title like '%{$post_data["search"]["value"]}%' ) ");
        }
        
        if(isset($post_data["order"])){
            $this->db->order_by($order_column[$post_data['order']['0']['column']]." ".$post_data['order']['0']['dir']);
        }else{
            $this->db->order_by("c.id desc");
        }
        
        if($post_data["length"] != -1){
            
            if($post_data['start'] > 0){
                $this->db->limit($post_data['length'], $post_data['start']);
            }else{
                $this->db->limit($post_data['length']);
            }
            
        }
        $q = $this->db->get();
        return $q !== FALSE ? $q->result() : array();
        
    }

    function getPopupList($det){
        $post_data = $this->input->post(null, true);
        
        $order_column = array("c.id", "c.title", "c.status");
        $this->db->select("c.id, c.title,descr,image_path, c.status");
        $this->db->from('popupalerts c');
        $where = array("c.status!="=>-1);
        $this->db->where($where);
        if(isset($post_data["search"]["value"])){
            $this->db->where(" ( c.title like '%{$post_data["search"]["value"]}%' ) ");
        }
        
        if(isset($post_data["order"])){
            $this->db->order_by($order_column[$post_data['order']['0']['column']]." ".$post_data['order']['0']['dir']);
        }else{
            $this->db->order_by("c.id desc");
        }
        
        if($post_data["length"] != -1){
            
            if($post_data['start'] > 0){
                $this->db->limit($post_data['length'], $post_data['start']);
            }else{
                $this->db->limit($post_data['length']);
            }
            
        }
        $q = $this->db->get();
        return $q !== FALSE ? $q->result() : array();
        
    }
	
	
	/***********flash News**********/
	function getFlashCategoryList($det){
        $post_data = $this->input->post(null, true);
        
        $order_column = array("c.id","c.id","c.name", "c.status");
        $this->db->select("c.id, c.name, c.status");
        $this->db->from('flashnews_category c');
        
        $where = array("c.status!="=>-1);
        $this->db->where($where);
        if(isset($post_data["search"]["value"])){
            $this->db->where(" ( c.name like '%{$post_data["search"]["value"]}%' ) ");
        }
        
        if(isset($post_data["order"])){
            $this->db->order_by($order_column[$post_data['order']['0']['column']]." ".$post_data['order']['0']['dir']);
        }else{
            $this->db->order_by("c.id desc");
        }
        
        if($post_data["length"] != -1){
            
            if($post_data['start'] > 0){
                $this->db->limit($post_data['length'], $post_data['start']);
            }else{
                $this->db->limit($post_data['length']);
            }
            
        }
        $q = $this->db->get();
        return $q !== FALSE ? $q->result() : array();
        
    }
	
	
	function getFlashnewsList($det){
        $post_data = $this->input->post(null, true);
        
        $order_column = array("c.id","ca.name", "c.title", "c.status");
        $this->db->select("c.id, ca.name, c.title,DATE_FORMAT(c.date_time,'%d-%m-%Y %h:%i %p') as datetime,descr,image_path, c.status");
        $this->db->from('flashnews c');
        $this->db->join('flashnews_category ca','ca.id=c.cat_id','inner');
        $where = array("c.status!="=>-1);
        $this->db->where($where);
        if(isset($post_data["search"]["value"])){
            $this->db->where(" ( ca.name like '%{$post_data["search"]["value"]}%' or c.title like '%{$post_data["search"]["value"]}%' ) ");
        }
        
        if(isset($post_data["order"])){
            $this->db->order_by($order_column[$post_data['order']['0']['column']]." ".$post_data['order']['0']['dir']);
        }else{
            $this->db->order_by("c.id desc");
        }
        
        if($post_data["length"] != -1){
            
            if($post_data['start'] > 0){
                $this->db->limit($post_data['length'], $post_data['start']);
            }else{
                $this->db->limit($post_data['length']);
            }
            
        }
        $q = $this->db->get();
        return $q !== FALSE ? $q->result() : array();
        
    }
	
	
	function getCustomerDocuments($customer_id){ //User Documents
        $select = 'd.id,d.title,s.name as speciality,DATE_FORMAT(d.ddate,"%d-%m-%Y") as date,d.notes';
        //GROUP_CONCAT(concat("'.app_asset_url().'",i.image)) as image
        $this->db->select($select)->from('customers c')
                ->join('cust_documents d','d.customer_id=c.id','inner')
				->join('speciality_master s','d.speciality_id=s.id','inner')
                ->where('d.customer_id='.$customer_id);
        $this->db->order_by('d.id','desc');
        
        $q = $this->db->get();
        //echo $this->db->last_query();exit;
        return $q !== FALSE ? $q->result() : array();
    }
	
	function getCustomerDoc($doc_id){
        $select = 'd.id,i.image';
        //GROUP_CONCAT(concat("'.app_asset_url().'",i.image)) as image
        $this->db->select($select)->from('cust_documents d')
                ->join('cust_doc_images i','d.id=i.doc_id','inner')
                ->where('i.doc_id='.$doc_id);
        $this->db->order_by('d.id','desc');
        
        $q = $this->db->get();
        //echo $this->db->last_query();exit;
        return $q !== FALSE ? $q->result() : array();
    }
	
	function getNotifyList($det){
        $post_data = $this->input->post(null, true);
        
        $order_column = array("c.id", "c.title", "c.status");
        $this->db->select("c.id, c.title,DATE_FORMAT(c.date_time,'%d-%m-%Y %h:%i %p') as datetime,descr,image_path, c.status");
        $this->db->from('notifications c');
        $this->db->join('states s','s.id=c.state_id','inner');
		$this->db->join('districts d','d.id=c.district_id','inner');
		$this->db->join('cities ct','ct.id=c.taluk_id','inner');
        $where = array("c.status!="=>-1);
        $this->db->where($where);
        if(isset($post_data["search"]["value"])){
            $this->db->where(" ( d.name like '%{$post_data["search"]["value"]}%' or s.name like '%{$post_data["search"]["value"]}%' or ct.name like '%{$post_data["search"]["value"]}%' or c.title like '%{$post_data["search"]["value"]}%' ) ");
        }
        
        if(isset($post_data["order"])){
            $this->db->order_by($order_column[$post_data['order']['0']['column']]." ".$post_data['order']['0']['dir']);
        }else{
            $this->db->order_by("c.id desc");
        }
        
        if($post_data["length"] != -1){
            
            if($post_data['start'] > 0){
                $this->db->limit($post_data['length'], $post_data['start']);
            }else{
                $this->db->limit($post_data['length']);
            }
            
        }
        $q = $this->db->get();
        return $q !== FALSE ? $q->result() : array();
        
    }
	
	
	function getCustomers($state_id,$district_id,$taluk_id){
         $select = "c.id,c.name,c.code";
        
	     $this->db->select($select)->from('customers c')
                ->join('countries ct','ct.id=c.country_id','left')
                ->join('states st','st.id=c.state_id','left')
                ->join('districts dt','dt.id=c.district_id','left')
                ->join('cities t','t.id=c.taluk_id','left');
				$where = array("c.status"=>1);
        if($state_id !='')
		{
			$where["c.state_id"] = $state_id;
		}
		if($district_id !='')
		{
			$where["c.district_id"]=$district_id;
		}
		
		if($taluk_id !='')
		{
			$where["c.taluk_id"]=$taluk_id;
		}
        
		
        $q = $this->db->get();
        return $q !== FALSE ? $q->result() : array();
    }
   
}
?>