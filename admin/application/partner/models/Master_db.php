<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Master_db extends CI_Model{
    function getRecords($table,$db = array(),$select = "*",$ordercol = '',$group = '',$start='',$limit='')
    {
        $this->db->select($select);
        if(!empty($ordercol))
        {
            $this->db->order_by($ordercol);
        }
        if($limit != '' && $start !='')
        {
            $this->db->limit($limit,$start);
        }
        if($group != '')
        {
            $this->db->group_by($group);
        }
        $q=$this->db->get_where($table, $db);
        return $q !== FALSE ? $q->result() : array();
        //return $q->result();
        //return $this->db->last_query();
    }
	
	function insertRecord($table,$db=array())
    {
        $q=$this->db->insert($table, $db); 
        return $q !== FALSE ? $this->db->insert_id() : null;
        /* $total = $this->db->insert_id();
        if($total>0)
        return $total;
        else 
        return 0; */
    }
    
	function getnumberformat($num){
    	return str_replace(".00", "", (string)number_format((float)$num, 0, '.', ','));
    }
    
    function getnumberformat_zero($num){
        return number_format((float)$num, 2, '.', ',');
    }
    
    function getnumberformatnocomma($num){
        return str_replace(".00", "", (string)number_format((float)$num, 2, '.', ''));
    }
    
	function deleterecord($table,$db=array())
	{
		$this->db->delete($table, $db);
	}
	
	function updateRecord($table,$data,$where=array())
	{
	    $q = $this->db->update($table,$data,$where);
	    return $q !== FALSE ? $this->db->affected_rows() : array();
	   
	}
	
	/* dont use this unnecessarily Ask to Aruna before using */
	function sqlExecute($sql)
	{
	    $q=$this->db->query($sql);
	    return $q !== FALSE ? $q->result() : array();
	}
	
    public function create_unique_slug($string,$table,$field,$key=NULL,$value=NULL)
    {
        $t =& get_instance();
        $slug = url_title($string);
        $slug = strtolower($slug);
        $i = 0;
        $params = array ();
        $params[$field] = $slug;
    
        if($key)$params["$key !="] = $value;
    
        while ($t->db->where($params)->get($table)->num_rows())
        {
            if (!preg_match ('/-{1}[0-9]+$/', $slug ))
                $slug .= '-' . ++$i;
            else
                $slug = preg_replace ('/[0-9]+$/', ++$i, $slug );
                
            $params [$field] = $slug;
        }
        return $slug;
    }

    //functions
    function getCategoryList($det){
        $post_data = $this->input->post(null, true);
        
        $order_column = array("c.id","c.id","c.name", "c.type", "c.status");
        $this->db->select("c.id, c.name, if(c.type=1,'Virtual','Physical') as type, c.status");
        $this->db->from('category c');
        
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

    function getSubCategoryList($det){
        $post_data = $this->input->post(null, true);
        
        $order_column = array("s.id","s.id","c.name","s.name","s.status");
        $this->db->select("s.id, c.name as category,s.name,s.status");
        $this->db->from('category c')->join('subcategory s','s.cat_id=c.id');
        
        $where = array("s.status!=" => -1 ,"c.status != " => -1);
        $this->db->where($where);
        if(isset($post_data["search"]["value"])){
            $this->db->where(" ( c.name like '%{$post_data["search"]["value"]}%' or s.name like '%{$post_data["search"]["value"]}%' ) ");
        }
        
        if(isset($post_data["order"])){
            $this->db->order_by($order_column[$post_data['order']['0']['column']]." ".$post_data['order']['0']['dir']);
        }else{
            $this->db->order_by("s.id desc");
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

    function getServiceList($det){
        $post_data = $this->input->post(null, true);
        
        $order_column = array("s.id","s.id","c.name", "b.name","s.name", "s.price","s.status");
        $this->db->select("s.id,c.name as category,b.name as subcategory,s.name,s.price,s.status");
        $this->db->from('services s')->join('category c','c.id=s.cat_id')->join('subcategory b','b.id=s.subcat_id');
        
        $where = array("s.status!="=>-1);
        $this->db->where($where);
        if(isset($post_data["search"]["value"])){
            $this->db->where(" ( b.name like '%{$post_data["search"]["value"]}%'
                or c.name like '%{$post_data["search"]["value"]}%'
                or s.name like '%{$post_data["search"]["value"]}%'
                or s.price like '%{$post_data["search"]["value"]}%'
                 ) ");
        }
        
        if(isset($post_data["order"])){
            $this->db->order_by($order_column[$post_data['order']['0']['column']]." ".$post_data['order']['0']['dir']);
        }else{
            $this->db->order_by("s.id desc");
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

    function getPackageList($det){
        $post_data = $this->input->post(null, true);
        
        $order_column = array("p.id","p.id","p.name","c.name","p.card_type","p.price","p.validity","p.status");
        $this->db->select("p.id,p.name as package,c.name as category,p.card_type,p.price,p.validity,p.status");
        $this->db->from('packages p')->join('category c','c.id=p.cat_id');
        
        $where = array("p.status!="=>-1);
        $this->db->where($where);
        if(isset($post_data["search"]["value"])){
            $this->db->where(" ( p.name like '%{$post_data["search"]["value"]}%'
                or c.name like '%{$post_data["search"]["value"]}%'
                or p.validity like '%{$post_data["search"]["value"]}%'
                or p.price like '%{$post_data["search"]["value"]}%'
                 ) ");
        }
        
        if(isset($post_data["order"])){
            $this->db->order_by($order_column[$post_data['order']['0']['column']]." ".$post_data['order']['0']['dir']);
        }else{
            $this->db->order_by("p.id desc");
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

    function getPackageDetail($id){

        $this->db->select("p.id,p.cat_id,p.color,p.name as package,p.descr,c.name as category,p.card_type,p.price,p.validity,p.status");
        $this->db->from('packages p')->join('category c','c.id=p.cat_id');
        $where = array("p.status!="=>-1,"p.id"=>$id);
        $this->db->where($where);
        $q = $this->db->get();

        $data = array();
        $data = $q !== FALSE ? $q->result() : array();
        if( count($data) ){
            $this->db->select("ps.id,ps.package_id,ps.service_id,ps.status,s.name,s.price");
            $this->db->from('package_service ps')->join('services s','s.id=ps.service_id');
            $where = array("ps.status"=>1,"ps.package_id"=>$id);
            $this->db->where($where);
            $q = $this->db->get();
            $data[0]->services = $q !== FALSE ? $q->result() : array();        
        }
        return $data;
    }
    //end
        function getcompany_nameList($det){
        $post_data = $this->input->post(null, true);
        
        $order_column = array("c.id","c.name", "c.status");
        $this->db->select("c.id, c.name, c.status");
        $this->db->from('company_name c');
        
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
    function getstateList($det){
        $post_data = $this->input->post(null, true);
        
        $order_column = array("c.id","c.name", "c.status");
        $this->db->select("c.id, c.name, c.status");
        $this->db->from('states c');
        
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
	
	   function getdistrictList($det){
       $post_data = $this->input->post(null, true);
        
        $order_column = array("d.id","d.name", "d.status");
        $this->db->select("s.name state_name,d.id,d.name as district_name,d.status");
		$this->db->from('districts d');
        $this->db->join('states s','d.state_id=s.id','inner');
        
        $where = array("d.status!="=>-1);
        $this->db->where($where);
        if(isset($post_data["search"]["value"])){
            $this->db->where(" ( s.name like '%{$post_data["search"]["value"]}%' or d.name like '%{$post_data["search"]["value"]}%' ) ");
        }
        
        if(isset($post_data["order"])){
            $this->db->order_by($order_column[$post_data['order']['0']['column']]." ".$post_data['order']['0']['dir']);
        }else{
            $this->db->order_by("d.name asc");
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
	
	  function gettalukList($det){
        $post_data = $this->input->post(null, true);
        
        $order_column = array("c.id","c.name", "c.status");
        $this->db->select("s.name state_name,d.id as district_id,d.name as district_name,c.name city_name,c.status,c.id");
		$this->db->from('cities c');
        $this->db->join('districts d','d.id=c.district_id','inner');
		$this->db->join('states s','d.state_id=s.id','inner');
        
        $where = array("c.status!="=>-1);
        $this->db->where($where);
		$this->db->group_by("c.id");
        if(isset($post_data["search"]["value"])){
            $this->db->where(" ( s.name like '%{$post_data["search"]["value"]}%' or d.name like '%{$post_data["search"]["value"]}%' or c.name like '%{$post_data["search"]["value"]}%' ) ");
        }
        
        if(isset($post_data["order"])){
            $this->db->order_by($order_column[$post_data['order']['0']['column']]." ".$post_data['order']['0']['dir']);
        }else{
            $this->db->order_by("c.name asc");
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

    //update 13-07-2021
    function getPartnerList($det){
        $post_data = $this->input->post(null, true);
        
        $order_column = array("p.id","p.id","p.type","p.code", "p.company_name", "p.company_type", "p.gst_no", "pp.fullname", "pp.contactno", "p.status","p.login_access");
        $this->db->select("p.id,p.type,p.code,p.company_name,p.company_type,p.gst_no,p.company_doc,pp.fullname,pp.contactno,p.status,p.verified,p.login_access");
        $this->db->from('partners p')
                ->join('partner_personal pp','pp.partner_id=p.id')
                ->join('partner_payment pa','pa.partner_id=p.id');
        
        $where = array("p.status!="=>-1);

        if( !empty($post_data['form'][0]["value"]) ){
            $where['p.type'] = $post_data['form'][0]["value"];
        }

        if( !empty($post_data['form'][1]["value"]) ){
            $where['p.company_type'] = $post_data['form'][1]["value"];
        }

        if( !empty($post_data['form'][2]["value"]) ){
            $where['p.code'] = $post_data['form'][2]["value"];
        }

        if( trim($post_data['form'][3]["value"])  != '' ){
            $where['p.status'] = $post_data['form'][3]["value"];
        }

        if( !empty($post_data['form'][4]["value"]) ){
            $where['pa.payment_id'] = $post_data['form'][4]["value"];
        }

        $this->db->where($where);
        if(isset($post_data["search"]["value"])){
            $this->db->where(" ( 
                p.type like '%{$post_data["search"]["value"]}%' or
                p.code like '%{$post_data["search"]["value"]}%' or
                p.company_name like '%{$post_data["search"]["value"]}%' or
                p.company_type like '%{$post_data["search"]["value"]}%' or
                p.gst_no like '%{$post_data["search"]["value"]}%' or
                pp.fullname like '%{$post_data["search"]["value"]}%' or
                pp.contactno like '%{$post_data["search"]["value"]}%'
            ) ");
        }
        
        if(isset($post_data["order"])){
            $this->db->order_by($order_column[$post_data['order']['0']['column']]." ".$post_data['order']['0']['dir']);
        }else{
            $this->db->order_by("p.id desc");
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

    function getParterDetail($id = ''){
        $select = " p.id,p.type,p.code,p.company_name,p.company_type,p.gst_no,p.doc_type,p.company_doc,pp.fullname,
                    pp.contactno,pp.emailid,pp.dob,pp.bloodgroup,pp.address,pp.city_id,pp.country_id,pp.state_id,
                    pp.district_id,pp.taluk_id,pp.pincode,pp.photo,pp.kyc_type,pp.kyc_doc,p.status,
                    pa.payment_id,pa.cheque_no,pa.cheque_date,pa.bank_name,pa.branch_name,pa.utr_no";
        $this->db->select($select);
        $this->db->from('partners p')
                ->join('partner_personal pp','pp.partner_id=p.id')
                ->join('partner_payment pa','pa.partner_id=p.id');
        $q = $this->db->get();
        return $q !== FALSE ? $q->result() : array();
    }
    
}
?>