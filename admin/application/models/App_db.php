<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class App_db extends CI_Model{

    function __construct(){
        parent::__construct();
    }

    //update 14-07-2021
    function checkPartner($db){
        $select = "p.id";
        $this->db->select($select)->from('partners p')
                ->join('partner_personal pp','pp.partner_id=p.id','inner')
                ->where($db);
        $q = $this->db->get();
        //echo $this->db->last_query();exit;
        return $q !== FALSE ? $q->result() : array();
    }

    function getCustomerDetail($db,$select = ''){
        if( $select == '' ){
            $select = "c.id as user_id,c.name,c.email as email_id,DATE_FORMAT(c.dob,'%d-%m-%Y') as dob,c.bloodgroup as blood_group,c.address,
                    if(c.gender=1,'Male','Female') as gender,ct.id as country_id,ct.name as country_name,
                    st.id as state_id,st.name as state_name,dt.id as dist_id,dt.name as dist_name,t.id as city_id,
                    t.name as city_name,c.code,c.photo,c.mobileno,cp.card_no,cp.valid_from,cp.valid_to,cp.created_at,cp.card_img,
                    p.color,p.card_type,p.name as package,p.price,p.validity,cp.qrcode,cp.expiry_date";
        }
        
        $this->db->select($select)->from('customers c')
                ->join('customer_package cp','cp.customer_id=c.id','inner')
                ->join('packages p','p.id=cp.package_id','inner')
                //->join('customer_points po','po.customer_id=c.id','inner')
                ->join('countries ct','ct.id=c.country_id','left')
                ->join('states st','st.id=c.state_id','left')
                ->join('districts dt','dt.id=c.district_id','left')
                ->join('cities t','t.id=c.taluk_id','left')
                ->group_by('cp.customer_id')
                ->order_by('cp.id desc')
                ->where($db);
        $q = $this->db->get();
        //echo $this->db->last_query();exit;
        return $q !== FALSE ? $q->result() : array();
    }

    function getCustomerDocument($db,$start = 0,$len=1){
        $select = 'd.id,d.title,d.speciality_id,DATE_FORMAT(d.ddate,"%d-%m-%Y") as date,d.notes,s.name as speciality_name';
        //GROUP_CONCAT(concat("'.app_asset_url().'",i.image)) as image
        $this->db->select($select)->from('customers c')
                ->join('cust_documents d','d.customer_id=c.id','inner')
                ->join('speciality_master s','s.id=d.speciality_id','inner')
                ->where($db);
        $this->db->order_by('d.id','desc');
        if( $len != 1 ){
            $this->db->limit($len, $start);
        }else{
            $this->db->limit($len, $start);
        }        
        $q = $this->db->get();
        //echo $this->db->last_query();exit;
        return $q !== FALSE ? $q->result() : array();
    }

    function getDistricts($db){
        $this->db->select('d.id,d.name')->from('districts d')
                ->join('states s','s.id=d.state_id','inner')
                ->join('countries c','c.id=s.country_id','inner')
                ->where($db);
        $this->db->order_by('d.name','asc');
        $q = $this->db->get();
        return $q !== FALSE ? $q->result() : array();
    }

    function getTaluks($db){
        $this->db->select('t.id,t.name')->from('cities t')
                ->join('districts d','d.id=t.district_id','inner')
                ->join('states s','s.id=d.state_id','inner')
                ->join('countries c','c.id=s.country_id','inner')
                ->where($db);
        $this->db->order_by('c.name','asc');
        $q = $this->db->get();
        return $q !== FALSE ? $q->result() : array();
    }

    function getServiceCategory($db){
        $this->db->select('s.id,s.name as title')->from('subcategory s')
                ->join('category c','c.id=s.cat_id','inner')
                ->where($db);
        $this->db->order_by('s.name','asc');
        $q = $this->db->get();
        return $q !== FALSE ? $q->result() : array();
    }

    function getServiceList($db){
        $this->db->select('s.id,s.name')->from('services s')
                ->join('package_service ps','ps.service_id=s.id','inner')
                ->join('packages p','p.id=ps.package_id','inner')
                ->join('customer_package cp','cp.package_id=p.id','inner')
                ->join('customers c','c.id=cp.customer_id','inner')
                ->where($db);
        $this->db->order_by('s.name','asc');
        $q = $this->db->get();
        return $q !== FALSE ? $q->result() : array();
    }

    function getServiceFields($db){
        $select = "s.id as service_id,sf.id as field_id,sf.type,sf.label as title,sf.is_required,sf.note";
        $this->db->select($select)->from('services s')
                ->join('service_fields sf','sf.service_id=s.id','inner')
                ->where($db);
        $this->db->order_by('sf.order_no','asc');
        $q = $this->db->get();
        return $q !== FALSE ? $q->result() : array();
    }

    //get health tips list
    function gethealthtips($db,$start = 0,$len = 1){
        $select = "h.id,h.title,h.short_descr,descr,DATE_FORMAT(h.date_time,'%d-%m-%Y %h:%i %p') as datetime,c.name as category,h.image_path as image";
        $this->db->select($select)->from('health_notify hn')
                ->join('healthtips h','h.id=hn.health_id','inner')
                ->join('app_submodules c','c.id=h.cat_id','inner')
                ->where($db);
        $this->db->order_by('hn.sent_at','asc');
        $this->db->limit($len, $start);
        $q = $this->db->get();
        return $q !== FALSE ? $q->result() : array();
    }

    //get flashnews tips list
    function getflashnews($db,$start = 0,$len = 1){
        $select = "f.id,f.title,f.short_descr,descr,
                    DATE_FORMAT(fn.sent_at,'%d-%m-%Y %h:%i %p') as datetime,
                    c.name as category,f.image_path as image";
        $this->db->select($select)->from('flashnews_notify fn')
                ->join('flashnews f','f.id=fn.flash_id','inner')
                ->join('app_submodules c','c.id=f.cat_id','inner')
                ->where($db);
        $this->db->order_by('fn.sent_at','asc');
        $this->db->limit($len, $start);
        $q = $this->db->get();
        return $q !== FALSE ? $q->result() : array();
    }

    //get notifications tips list
    function getnotifications($db,$start = 0,$len = 1){
        $select = "n.id,n.title,n.descr,n.image_path as image,
                    DATE_FORMAT(n.date_time,'%d-%m-%Y %h:%i %p') as datetime";
        $this->db->select($select)->from('recipient_notify rn')
                ->join('notifications n','n.id=rn.notify_id','inner')
                ->where($db);
        $this->db->order_by('rn.sent_at','asc');
        $this->db->limit($len, $start);
        $q = $this->db->get();
        //echo $this->db->last_query();exit;
        return $q !== FALSE ? $q->result() : array();
    }

    //get package modules tips list
    function getpackagemodules($db){
        $select = "m.id,m.name,m.health_tip,m.flashnews,if(pm.status=1,'Yes','no') as status";
        $this->db->select($select)->from('package_module pm')
                ->join('app_modules m','m.id=pm.module_id','inner')
                ->where($db);
        $this->db->order_by('m.order_no','asc');
        $q = $this->db->get();
        return $q !== FALSE ? $q->result() : array();
    }

    function getpackagesubmodules($db){
        $select = "sm.id,sm.name,if(ps.status=1,'Yes','no') as status";
        $this->db->select($select)->from('package_submodule ps')
                ->join('app_submodules sm','sm.id=ps.submodule_id','inner')
                ->where($db);
        $this->db->order_by('sm.order_no','asc');
        $q = $this->db->get();
        return $q !== FALSE ? $q->result() : array();
    }

    function getservicedata($db,$limit = 10){

        $select = "cs.id,csf.id,sf.label,sf.type,csf.data";
        $this->db->select("csf.data,DATE_FORMAT(cs.created_at,'%d-%m-%Y') as date")->from('services s ')
                ->join('service_fields sf','sf.service_id = s.id')
                ->join('cust_service cs','cs.service_id = s.id')
                ->join('cust_service_field csf','csf.main_id = cs.id and csf.field_id = sf.id')
                ->where($db)->order_by('cs.created_at desc');
        $this->db->limit($limit,0);
        $q = $this->db->get();
        return $q !== FALSE ? $q->result() : array();
    }


    function generateOrderNo($oid){
        $sql = "SELECT CONCAT(  'LIFELAB', INSERT( LPAD( id, 5,  '0' ) , 0, 3,  'GGA' ) ) AS OrderNo FROM orders WHERE id=$oid";
        $q=$this->db->query($sql);
        if($q->num_rows()>0){
            $res = $q->result();
            return $res[0]->OrderNo;
        }
        else
            return 'LIFELAB000001';
    }
    //end

    

}

?>