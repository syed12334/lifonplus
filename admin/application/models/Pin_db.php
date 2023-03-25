<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Pin_db extends CI_Model{

    function getPinList($det){
        $post_data = $this->input->post(null, true);
        
        $order_column = array("p.id","p.id","p.type","p.type","p.qty");
        $select = "p.id,if(p.type=1,'Package',if(p.type=2,'Service','Equipment/Item')) as pintype,p.type,p.qty,
                  i.name as item,pp.name as package,s.name as service";
        $this->db->select($select);
        $this->db->from('pins p')
                ->join('items i','i.id=p.item_id','left')
                ->join('packages pp','pp.id=p.package_id','left')
                ->join('services s','s.id=p.service_id','left')
                ->join('category c','c.id=p.cat_id','left')
                ->join('subcategory sub','sub.id=p.subcat_id','left');
        
        $where = array("p.status"=>1);

        if( !empty($post_data['form'][0]["value"]) ){ $where['p.type'] = $post_data['form'][0]["value"]; }
        if( !empty($post_data['form'][1]["value"]) ){ $where['pp.id'] = $post_data['form'][1]["value"]; }
        if( !empty($post_data['form'][2]["value"]) ){ $where['c.id'] = $post_data['form'][2]["value"]; }
        if( !empty($post_data['form'][3]["value"]) ){ $where['sub.id'] = $post_data['form'][3]["value"]; }
        if( !empty($post_data['form'][4]["value"]) ){ $where['i.id'] = $post_data['form'][4]["value"]; }
        if( !empty($post_data['form'][5]["value"]) ){ $where['s.id'] = $post_data['form'][5]["value"]; }

        $this->db->where($where);    
        
        if(isset($post_data["search"]["value"])){
            $this->db->where(" ( pp.name like '%{$post_data["search"]["value"]}%'
                or i.name like '%{$post_data["search"]["value"]}%'
                or s.name like '%{$post_data["search"]["value"]}%'
                or p.qty like '%{$post_data["search"]["value"]}%'
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

    function getPin($pin_id){
        $select = "p.id,if(p.type=1,'Package',if(p.type=2,'Service','Equipment/Item')) as pintype,p.type,p.qty,
                  i.name as item,pp.name as package,s.name as service,c.name as category,sub.name subcategory";
        $this->db->select($select);
        $this->db->from('pins p')
                ->join('items i','i.id=p.item_id','left')
                ->join('packages pp','pp.id=p.package_id','left')
                ->join('services s','s.id=p.service_id','left')
                ->join('category c','c.id=p.cat_id','left')
                ->join('subcategory sub','sub.id=p.subcat_id','left');

        $where = array("p.status"=>1,"p.id"=>$pin_id);
        $this->db->where($where);     
        $q = $this->db->get();
        return $q !== FALSE ? $q->result() : array();           

    }

    function getPinHistory($pin_id){
        $select = "p.id,h.action,h.qty,h.txn_id,DATE_FORMAT(h.created_at,'%d-%m-%Y %h:%i %p') as created_at";
        $this->db->select($select);
        $this->db->from('pins p')
            ->join('pin_history h','h.pin_id=p.id');

        $where = array("p.status"=>1,"h.pin_id"=>$pin_id);
        $this->db->order_by("h.id desc");
        $this->db->where($where);     
        $q = $this->db->get();
        return $q !== FALSE ? $q->result() : array();           
    }

    function getPartner($db =''){
        $select = "p.id,p.company_name,pp.fullname,p.code,c.name as country,pp.address,p.gst_no,p.type,pp.country_id,pp.state_id";
        $this->db->select($select);
        $this->db->from('partners p')
            ->join('partner_personal pp','pp.partner_id=p.id')
            ->join('countries c','c.id=pp.country_id','left');
        $where = array("p.verified"=>1);
        $this->db->where($where);     
        if( $db != '' ){ $this->db->where($db); }
        $this->db->order_by("p.code asc");
        $q = $this->db->get();
        return $q !== FALSE ? $q->result() : array();
    }

    function getPartnerLocation($db =''){
        $select = "l.id,l.partner_id,l.country_id,l.state_id,s.tax_type,s.name";
        $this->db->select($select);
        $this->db->from('partners p')
            ->join('partner_location l','l.partner_id=p.id')
            ->join('countries c','c.id=l.country_id')
            ->join('states s','s.id=l.state_id');
        if( $db != '' ){ $this->db->where($db); }
        $this->db->order_by("p.code asc");
        $q = $this->db->get();
        return $q !== FALSE ? $q->result() : array();
    }

    function getPackages($db =''){
        $select = "p.id,p.name,p.price";
        $this->db->select($select);
        $this->db->from('packages p');
        $where = array("p.status"=>1);
        $this->db->where($where);     
        if( $db != '' ){ $this->db->where($db); }
        $this->db->order_by("p.name asc");
        $q = $this->db->get();
        return $q !== FALSE ? $q->result() : array();
    }

    function getPackagesPins($db =''){
        $select = "p.id,p.name,p.price,pin.qty";
        $this->db->select($select);
        $this->db->from('packages p')
            ->join('pins pin','pin.package_id=p.id');
        $where = array("p.status"=>1,"pin.status"=>1);
        $this->db->where($where);     
        if( $db != '' ){ $this->db->where($db); }
        $this->db->order_by("p.name asc");
        $q = $this->db->get();
        return $q !== FALSE ? $q->result() : array();
    }

    function getServicePins($db =''){
        $select = "s.id,s.name,s.price,pin.qty";
        $this->db->select($select);
        $this->db->from('services s')
            ->join('pins pin','pin.service_id=s.id');
        $where = array("s.status"=>1,"pin.status"=>1);
        $this->db->where($where);     
        if( $db != '' ){ $this->db->where($db); }
        $this->db->order_by("s.name asc");
        $q = $this->db->get();
        return $q !== FALSE ? $q->result() : array();
    }

    function getItemPins($db =''){
        $select = "i.id,i.name,i.price,pin.qty";
        $this->db->select($select);
        $this->db->from('items i')
            ->join('pins pin','pin.item_id=i.id');
        $where = array("i.status"=>1,"pin.status"=>1);
        $this->db->where($where);     
        if( $db != '' ){ $this->db->where($db); }
        $this->db->order_by("i.name asc");
        $q = $this->db->get();
        return $q !== FALSE ? $q->result() : array();
    }

    function getTransferList($det){
        $post_data = $this->input->post(null, true);
        
        $order_column = array("t.id","t.id","p.type","p.type","p.qty");
        $select = "t.id,if(p.type=1,'Package',if(p.type=2,'Service','Equipment/Item')) as pintype,p.type,
                  i.name as item,pp.name as package,s.name as service,t.id as txn_id,t.txn_no,t.qty,
                  DATE_FORMAT(t.created_at,'%d-%m-%Y %h:%i %p') as created_at,t.pin_amt,t.total_amt,
                    case pt.type   
                        when 1 then 'Country Partner' 
                        when 2 then 'Stockist'
                        when 3 then 'State C&F'
                        when 4 then 'Distributor'
                        when 5 then 'Dealer'
                        when 6 then 'Retailer'
                    end as partner_type ,pt.code,pt.company_name";
        $this->db->select($select);
        $this->db->from('pins p')
                ->join('company_transfers t','t.pin_id=p.id')
                ->join('partners pt','pt.id=t.partner_id')
                ->join('items i','i.id=p.item_id','left')
                ->join('packages pp','pp.id=p.package_id','left')
                ->join('services s','s.id=p.service_id','left')
                ->join('category c','c.id=p.cat_id','left')
                ->join('subcategory sub','sub.id=p.subcat_id','left');
        
        $where = array("p.status"=>1);
        if( !empty($post_data['form'][0]["value"]) ){ $where['p.type'] = $post_data['form'][0]["value"]; }
        if( !empty($post_data['form'][1]["value"]) ){ $where['t.partner_id'] = $post_data['form'][1]["value"]; }
        if( !empty($post_data['form'][2]["value"]) ){ $where['t.txn_no'] = $post_data['form'][2]["value"]; }

        $fromdate = $todate = $condition = '';
        if( !empty($post_data['form'][3]["value"]) ){
            $fromdate = date('Y-m-d',strtotime($post_data['form'][3]["value"]));
            $fromdate = $fromdate.' 00:00:00';
            $condition .= "t.created_at >= '".$fromdate."'";
        }

        if( !empty($post_data['form'][4]["value"]) ){
            $todate = date('Y-m-d',strtotime($post_data['form'][4]["value"]));
            $todate = $todate.' 23:59:59';
            if( $condition != '' ){
                $condition .= " and t.created_at >= '".$todate."'";
            }
        }

        if( !empty($post_data['form'][5]["value"]) ){ $where['pp.id'] = $post_data['form'][5]["value"]; }
        if( !empty($post_data['form'][6]["value"]) ){ $where['c.id'] = $post_data['form'][6]["value"]; }
        if( !empty($post_data['form'][7]["value"]) ){ $where['sub.id'] = $post_data['form'][7]["value"]; }
        if( !empty($post_data['form'][8]["value"]) ){ $where['i.id'] = $post_data['form'][8]["value"]; }
        if( !empty($post_data['form'][9]["value"]) ){ $where['s.id'] = $post_data['form'][9]["value"]; }
        $this->db->where($where);
        if( $condition != '' ){
            $this->db->where($condition);
        }        

        if(isset($post_data["search"]["value"])){
            $this->db->where(" ( 
                i.name like '%{$post_data["search"]["value"]}%' or pp.name like '%{$post_data["search"]["value"]}%' or
                s.name like '%{$post_data["search"]["value"]}%' or t.pin_amt like '%{$post_data["search"]["value"]}%' or
                t.qty like '%{$post_data["search"]["value"]}%' or t.total_amt like '%{$post_data["search"]["value"]}%'
            ) ");
        }

        if(isset($post_data["order"])){
            $this->db->order_by($order_column[$post_data['order']['0']['column']]." ".$post_data['order']['0']['dir']);
        }else{
            $this->db->order_by("t.id desc");
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
}
?>