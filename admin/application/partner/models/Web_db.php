<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Web_db extends CI_Model{
   

    //update 13-07-2021
    function getusersList($det){
        $post_data = $this->input->post(null, true);
        
         $select = "c.id,c.name,c.email as email_id,DATE_FORMAT(c.dob,'%d-%m-%Y') as dob,c.package as cpackage,c.bloodgroup as blood_group,c.address,
         if(c.gender=1,'Male','Female') as gender,ct.id as country_id,ct.name as country_name,
         st.id as state_id,st.name as state_name,dt.id as dist_id,dt.name as dist_name,t.id as city_id,
         t.name as city_name,c.code,c.photo,c.mobileno,cp.card_img,cp.card_no,cp.valid_from,cp.valid_to,cp.created_at,cp.card_img,
         p.color,p.card_type,p.name as package,p.price,p.validity,c.referral_code,c.status,cp.card_no";
        
         $order_column = array("c.id","c.name","c.code", "c.mobileno", "c.email", "c.status");
       
	   
	     $this->db->select($select)->from('customers c')
                ->join('customer_package cp','cp.customer_id=c.id','inner')
                ->join('packages p','p.id=cp.package_id','inner')
                ->join('countries ct','ct.id=c.country_id','left')
                ->join('states st','st.id=c.state_id','left')
                ->join('districts dt','dt.id=c.district_id','left')
                ->join('cities t','t.id=c.taluk_id','left');
        
        $where = array("c.status!="=>-1,"c.partner_id"=>$det[0]->id);

        if( !empty($post_data['form'][0]["value"]) ){
            $where['c.code'] = $post_data['form'][0]["value"];
        }

        if( !empty($post_data['form'][1]["value"]) ){
            $where['c.name'] = $post_data['form'][1]["value"];
        }

        if( !empty($post_data['form'][2]["value"]) ){
            $where['c.email'] = $post_data['form'][2]["value"];
        }

        if( trim($post_data['form'][3]["value"])  != '' ){
            $where['c.mobileno'] = $post_data['form'][3]["value"];
        }

        if( !empty($post_data['form'][4]["value"]) ){
            $where['c.status'] = $post_data['form'][4]["value"];
        }

        $this->db->where($where);
        if(isset($post_data["search"]["value"])){
            $this->db->where(" ( 
                c.code like '%{$post_data["search"]["value"]}%' or
                c.name like '%{$post_data["search"]["value"]}%' or
                c.email like '%{$post_data["search"]["value"]}%' or
                c.mobileno like '%{$post_data["search"]["value"]}%' 
            ) ");
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
        //echo $this->db->last_query();exit;
        return $q !== FALSE ? $q->result() : array();
        
    }
	
	
	  function getUserDetail($id = ''){
         $select = "c.id,c.name,c.email as email_id,DATE_FORMAT(c.dob,'%d-%m-%Y') as dob,c.bloodgroup as blood_group,c.address,
		 IF(c.gender !='',IF(c.gender=1,'Male','Female'),'') as gender,ct.id as country_id,ct.name as country_name,
		 st.id as state_id,st.name as state_name,dt.id as dist_id,dt.name as dist_name,t.id as city_id,
		 t.name as city_name,c.code,c.photo,c.mobileno,cp.card_no,cp.valid_from,cp.valid_to,cp.created_at,cp.card_img,
		 p.color,p.card_type,p.name as package,p.price,p.validity,c.referral_code,IFNULL(cpo.total,0) as total,c.status";
        
         $order_column = array("c.id","c.name","c.code", "c.mobileno", "c.email", "c.status");
       
	   
	     $this->db->select($select)->from('customers c')
                ->join('customer_package cp','cp.customer_id=c.id','inner')
                ->join('packages p','p.id=cp.package_id','inner')
                ->join('countries ct','ct.id=c.country_id','left')
                ->join('states st','st.id=c.state_id','left')
				->join('customer_points cpo','cpo.customer_id=c.id','left')
                ->join('districts dt','dt.id=c.district_id','left')
                ->join('cities t','t.id=c.taluk_id','left');
        
        $where = array("c.status!="=>-1);
		 $where = array("c.id=".$id);
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
	

   
}
?>