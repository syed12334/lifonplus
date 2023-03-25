<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class users_db extends CI_Model{

    function usersList($det){
        $post_data = $this->input->post(null, true);
        $desg = $post_data["form"][0]["value"];
        $userid = $post_data["form"][1]["value"];
        $status = $post_data["form"][2]["value"];
        $order_column = array("", "", "ds.name", "dp.name", "d.name", "a.username", "a.status");
        $this->db->select("a.id, a.username, IFNULL(d.name, '') division, IFNULL(dp.name, '') department, ds.name designation, a.status");
        $this->db->from('admin a');
        $this->db->join('designation ds', 'a.desg_id=ds.id', 'inner');
        $this->db->join('division d', 'ds.div_id=d.id', 'left');
        $this->db->join('department dp', 'ds.dept_id=dp.id', 'left');
        $where = array("ds.status!="=>-1, "a.id!="=>$det[0]->id, "role_id !="=>1);
        /* if($div != ""){
            $where["ds.div_id"]  = $div;
        }
        if($dept != ""){
            $where["ds.dept_id"]  = $dept;
        } */
        if($desg != "" && $desg != "0"){
            $where["ds.id"]  = $desg;
        }
        if($userid != ""){
            $this->db->like("a.username", $userid, "both");
        }
        if($status != ""){
            $this->db->where("a.status", $status);
        }
        else{
            $where["a.status !="]  = -1;
        }
        
        $this->db->where($where);
        if(isset($post_data["search"]["value"])){
            $this->db->where("( a.username like '%{$post_data["search"]["value"]}%' or ds.name like '%{$post_data["search"]["value"]}%'
                                        or d.name like '%{$post_data["search"]["value"]}%' or dp.name like '%{$post_data["search"]["value"]}%')");
        }
        
        if(isset($post_data["order"]))
        {
            $this->db->order_by($order_column[$post_data['order']['0']['column']]." ".$post_data['order']['0']['dir']);
        }
        else{
            $this->db->order_by("a.id desc");
        }
        
        
        if($post_data["length"] != -1)
        {
            if($post_data['start'] > 0){
                $this->db->limit($post_data['length'], $post_data['start']);
            }
            else{
                $this->db->limit($post_data['length']);
            }
            
        }
        $q = $this->db->get();
        return $q !== FALSE ? $q->result() : array();
       
    }
    
    function designationList(){
        $this->db->select("ds.id, IFNULL(d.name, '') division, IFNULL(dp.name, '') department, ds.name designation");
        $this->db->from('designation ds');
        $this->db->join('division d', 'ds.div_id=d.id', 'left');
        $this->db->join('department dp', 'ds.dept_id=dp.id', 'left');
        $where = array("ds.status!="=>-1, "role_id !="=>1);
        $this->db->where($where);
        $this->db->group_by("ds.id");
        $q = $this->db->get();
        return $q !== FALSE ? $q->result() : array();
    }
    
    function getDesignationList($det){
        $post_data = $this->input->post(null, true);
        $div = $post_data["form"][0]["value"];
        $dept = $post_data["form"][1]["value"];
        $role = $post_data["form"][2]["value"]; 
        $desg = $post_data["form"][3]["value"];
        $status = $post_data["form"][4]["value"]; 
        $order_column = array("", "", "ds.name", "dp.name", "d.name", "r.name", "ds.status");
        $this->db->select("ds.id, ds.code, IFNULL(d.name, '') division, IFNULL(dp.name, '') department, ds.name designation, ds.status, r.name role, ds.is_app");
        $this->db->from('designation ds');
        $this->db->join('roles r', 'ds.role_id=r.id', 'inner');
        $this->db->join('division d', 'ds.div_id=d.id', 'left');
        $this->db->join('department dp', 'ds.dept_id=dp.id', 'left');
        
        $where = array("ds.status!="=>-1, "role_id !="=>1);
       
        if($div != ""){
            $where["ds.div_id"]  = $div;
        }
        if($dept != ""){
            $where["ds.dept_id"]  = $dept;
        }
        if($role != ""){
            $where["ds.role_id"]  = $role;
        }
        if($desg != ""){
            $this->db->where("( ds.name like '%{$desg}%' or ds.code like '%{$desg}%')");
        }
        if($status != ""){
            $this->db->where("ds.status", $status);
        }
        else{
            $where["ds.status !="]  = -1;
        }
        
        $this->db->where($where);
        if(isset($post_data["search"]["value"])){
            $this->db->where("( ds.name like '%{$post_data["search"]["value"]}%' or ds.code like '%{$post_data["search"]["value"]}%' or r.name like '%{$post_data["search"]["value"]}%'
                                        or d.name like '%{$post_data["search"]["value"]}%' or dp.name like '%{$post_data["search"]["value"]}%')");
        }
        
        if(isset($post_data["order"]))
        {
            $this->db->order_by($order_column[$post_data['order']['0']['column']]." ".$post_data['order']['0']['dir']);
        }
        else{
            $this->db->order_by("ds.id desc");
        }
        
        
        if($post_data["length"] != -1)
        {
            
            if($post_data['start'] > 0){
                $this->db->limit($post_data['length'], $post_data['start']);
            }
            else{
                $this->db->limit($post_data['length']);
            }
            
        }
        $this->db->group_by("ds.id");
        $q = $this->db->get();
        return $q !== FALSE ? $q->result() : array();
        
    }
	
    
    function appusersList($det){
        $post_data = $this->input->post(null, true);
        $desg = $post_data["form"][0]["value"];
        $userid = $post_data["form"][1]["value"];
        $status = $post_data["form"][2]["value"];
        $order_column = array("", "", "a.status", "a.name", "ds.name", "dp.name", "d.name", "a.pf_no", "a.phone_no");
        $this->db->select("a.id, a.name, IFNULL(d.name, '') division, IFNULL(dp.name, '') department, ds.name designation, a.status, phone_no, pf_no");
        $this->db->from('users a');
        $this->db->join('designation ds', 'a.desg_id=ds.id', 'inner');
        $this->db->join('division d', 'ds.div_id=d.id', 'left');
        $this->db->join('department dp', 'ds.dept_id=dp.id', 'left');
        $where = array("ds.status!="=>-1);
        
        if($desg != "" && $desg != "0"){
            $where["ds.id"]  = $desg;
        }
        if($userid != ""){
            $this->db->like("a.name", $userid, "both");
        }
        if($status != ""){
            $this->db->where("a.status", $status);
        }
        else{
            $where["a.status !="]  = -1;
        }
        
        $this->db->where($where);
        if(isset($post_data["search"]["value"])){
            $this->db->where("( a.name like '%{$post_data["search"]["value"]}%' or ds.name like '%{$post_data["search"]["value"]}%' or pf_no like '%{$post_data["search"]["value"]}%'
                                        or d.name like '%{$post_data["search"]["value"]}%' or dp.name like '%{$post_data["search"]["value"]}%' or phone_no like '%{$post_data["search"]["value"]}%')");
        }
        
        if(isset($post_data["order"]))
        {
            $this->db->order_by($order_column[$post_data['order']['0']['column']]." ".$post_data['order']['0']['dir']);
        }
        else{
            $this->db->order_by("a.id desc");
        }
        
        
        if($post_data["length"] != -1)
        {
            if($post_data['start'] > 0){
                $this->db->limit($post_data['length'], $post_data['start']);
            }
            else{
                $this->db->limit($post_data['length']);
            }
            
        }
        $q = $this->db->get();
        return $q !== FALSE ? $q->result() : array();
        
    }

    /** update 10-9-2020 */
    function getCategoryList($det){
        $post_data = $this->input->post(null, true);
        /*
        $div = $post_data["form"][0]["value"];
        $dept = $post_data["form"][1]["value"];
        $role = $post_data["form"][2]["value"]; 
        $desg = $post_data["form"][3]["value"];
        $status = $post_data["form"][4]["value"]; 
        */
        $order_column = array("c.id","c.id","c.name", "c.status");
        $this->db->select("c.id, c.name, c.status");
        $this->db->from('category c');
        
        $where = array("c.status!="=>2);
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
        /*
        $div = $post_data["form"][0]["value"];
        $dept = $post_data["form"][1]["value"];
        $role = $post_data["form"][2]["value"]; 
        $desg = $post_data["form"][3]["value"];
        $status = $post_data["form"][4]["value"]; 
        */
        $order_column = array("s.id","s.id","c.name","s.name","s.status");
        $this->db->select("s.id, c.name as category,s.name,s.status");
        $this->db->from('category c')->join('sub_category s','s.cat_id=c.id');
        
        $where = array("s.status!=" => 2 ,"c.status != " => 2);
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

    function getBrandList($det){
        $post_data = $this->input->post(null, true);
        /*
        $div = $post_data["form"][0]["value"];
        $dept = $post_data["form"][1]["value"];
        $role = $post_data["form"][2]["value"]; 
        $desg = $post_data["form"][3]["value"];
        $status = $post_data["form"][4]["value"]; 
        */
        $order_column = array("b.id","b.id","b.name", "b.status");
        $this->db->select("b.id, b.name, b.status");
        $this->db->from('brand b');
        
        $where = array("b.status!="=>2);
        $this->db->where($where);
        if(isset($post_data["search"]["value"])){
            $this->db->where(" ( b.name like '%{$post_data["search"]["value"]}%' ) ");
        }
        
        if(isset($post_data["order"])){
            $this->db->order_by($order_column[$post_data['order']['0']['column']]." ".$post_data['order']['0']['dir']);
        }else{
            $this->db->order_by("b.id desc");
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

    function getProductList($det){
        $post_data = $this->input->post(null, true);
        /*
        $div = $post_data["form"][0]["value"];
        $dept = $post_data["form"][1]["value"];
        $role = $post_data["form"][2]["value"]; 
        $desg = $post_data["form"][3]["value"];
        $status = $post_data["form"][4]["value"]; 
        */
        $order_column = array("p.id","p.id","c.name", "s.name", "b.name", "p.name", "p.sku", "p.quantity", "p.costprice", "p.selling_price1", "p.selling_price2", "p.selling_price3", "p.selling_price4", "p.gst1", "p.gst2", "p.gst3", "p.gst4","p.discount", "p.status");
        $this->db->select("p.*,c.name as category,s.name as subcategory,b.name as brand");
        $this->db->from('products p')
             ->join('sub_category s','s.id=p.subcat_id')
             ->join('category c','c.id=s.cat_id')
             ->join('brand b','b.id=p.brand_id');
        
        $where = array("p.status!="=>2);
        $this->db->where($where);
        if(isset($post_data["search"]["value"])){
            $sql = "( c.name like '%{$post_data["search"]["value"]}%' or s.name like '%{$post_data["search"]["value"]}%'
                        or b.name like '%{$post_data["search"]["value"]}%' or p.name like '%{$post_data["search"]["value"]}%'
                        or p.sku like '%{$post_data["search"]["value"]}%' or p.sellprice like '%{$post_data["search"]["value"]}%'
                        or p.quantity like '%{$post_data["search"]["value"]}%' or p.discount like '%{$post_data["search"]["value"]}%'
                        or p.costprice like '%{$post_data["search"]["value"]}%' or p.gst like '%{$post_data["search"]["value"]}%' 
                        or p.selling_price1 like '%{$post_data["search"]["value"]}%' or p.gst1 like '%{$post_data["search"]["value"]}%' 
                        or p.selling_price2 like '%{$post_data["search"]["value"]}%' or p.gst2 like '%{$post_data["search"]["value"]}%' 
                        or p.selling_price3 like '%{$post_data["search"]["value"]}%' or p.gst3 like '%{$post_data["search"]["value"]}%' 
                        or p.selling_price4 like '%{$post_data["search"]["value"]}%' or p.gst4 like '%{$post_data["search"]["value"]}%' 
                    ) ";
            $this->db->where($sql);
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

    function getBatchList($det,$id = ''){
        $post_data = $this->input->post(null, true);
        /*
        $div = $post_data["form"][0]["value"];
        $dept = $post_data["form"][1]["value"];
        $role = $post_data["form"][2]["value"]; 
        $desg = $post_data["form"][3]["value"];
        $status = $post_data["form"][4]["value"]; 
        */
        $order_column = array("b.id","b.id","b.batch_name", "b.batch_date", "c.symb", "b.total_amt", "b.freight");
        $this->db->select("b.*,c.symb,c.descp");
        $this->db->from('batches b')
             ->join('currencylst c','c.id=b.currency');
        
        $where = array("b.status!="=>2);
        if( $id != '' )
            $where['b.id'] = $id;

        $this->db->where($where);
        if(isset($post_data["search"]["value"])){
            $sql = "( b.batch_name like '%{$post_data["search"]["value"]}%' or b.batch_date like '%{$post_data["search"]["value"]}%'
                        or b.total_amt like '%{$post_data["search"]["value"]}%' or b.freight like '%{$post_data["search"]["value"]}%'
                        or c.symb like '%{$post_data["search"]["value"]}%' or c.descp like '%{$post_data["search"]["value"]}%' 
                    ) ";
            $this->db->where($sql);
        }
        
        if(isset($post_data["order"])){
            $this->db->order_by($order_column[$post_data['order']['0']['column']]." ".$post_data['order']['0']['dir']);
        }else{
            $this->db->order_by("b.id desc");
        }
        
        
        if( isset($post_data["length"]) && $post_data["length"] != -1){
            
            if($post_data['start'] > 0){
                $this->db->limit($post_data['length'], $post_data['start']);
            }else{
                $this->db->limit($post_data['length']);
            }
            
        }
        $q = $this->db->get();
        return $q !== FALSE ? $q->result() : array();
        
    }

    function getBatchProductList($det,$id = ''){
        $post_data = $this->input->post(null, true);
        /*
        $div = $post_data["form"][0]["value"];
        $dept = $post_data["form"][1]["value"];
        $role = $post_data["form"][2]["value"]; 
        $desg = $post_data["form"][3]["value"];
        $status = $post_data["form"][4]["value"]; 
        */
        $order_column = array("b.id","b.batch_name","c.name", "s.name", "br.name", "p.name");
        $this->db->select("bp.*,b.batch_name,c.name as cat_name,s.name as subcat_name,br.name as brand_name,p.name as product_name");
        $this->db->from('batch_products bp')
             ->join('batches b','b.id=bp.batchid')
             ->join('category c','c.id=bp.cat_id')
             ->join('sub_category s','s.id=bp.sub_id')
             ->join('brand br','br.id=bp.brand_id')
             ->join('products p','p.id=bp.prod_id');
        
        $where = array("bp.status!="=>2);
        if( $id != '' )
            $where['bp.id'] = $id;

        $this->db->where($where);
        if(isset($post_data["search"]["value"])){
            $sql = "( b.batch_name like '%{$post_data["search"]["value"]}%' or c.name like '%{$post_data["search"]["value"]}%'
                        or s.name like '%{$post_data["search"]["value"]}%' or br.name like '%{$post_data["search"]["value"]}%'
                        or p.name like '%{$post_data["search"]["value"]}%' 
                    ) ";
            $this->db->where($sql);
        }
        
        if(isset($post_data["order"])){
            $this->db->order_by($order_column[$post_data['order']['0']['column']]." ".$post_data['order']['0']['dir']);
        }else{
            $this->db->order_by("bp.id desc");
        }
        
        
        if( isset($post_data["length"]) && $post_data["length"] != -1){
            
            if($post_data['start'] > 0){
                $this->db->limit($post_data['length'], $post_data['start']);
            }else{
                $this->db->limit($post_data['length']);
            }
            
        }
        $q = $this->db->get();
        return $q !== FALSE ? $q->result() : array();
        
    }

    function getProductRanking($order = 'desc'){

        $this->db->select('p.name,c.name as category,s.name as sub_category,b.name as brand,p.sku,sum(op.qty) as qty,sum(op.total_price) as total_price')
             ->from('orders o')
             ->join('orders_products op','op.orderid = o.id')
             ->join('products p','p.id = op.prod_id')
             ->join('category c','c.id = p.cat_id')
             ->join('sub_category s','s.id = p.subcat_id')
             ->join('brand b','b.id = p.brand_id')
             ->where('op.status',0)
             ->group_by('op.prod_id')
             ->order_by('qty',$order);
        
        return $this->db->get()->result();
    }

    function getCancelledBills($where){

        $this->db->select('o.*,pm.name as payment_method,dm.name as delivery_method')
             ->from('orders o')
             //->join('orders_products op','op.orderid=o.id')
             ->join('master_types pm','pm.id=o.payment_med')
             ->join('master_types dm','dm.id=o.delivery_med')
             ->where('o.status',1);
        
        if( !empty($where['from_date']))
            $this->db->where('o.cancel_date >=',date('Y-m-d',strtotime($where['from_date'])));
        
        if( !empty($where['to_date']))
            $this->db->where('o.cancel_date <=',date('Y-m-d',strtotime($where['to_date'])));
        
        if( !empty($where['invoice_no']))
            $this->db->where('o.orderno',date('Y-m-d',strtotime($where['invoice_no'])));

        return $this->db->get()->result();
    }

    function getOrderTypes(){
        $order_type = $this->master_db->getRecords('master_types',array('type'=>3,'status'=>0),'id,name');
        $result = array(
            'label' =>  array(),
            'value' =>  array()
        );
        foreach($order_type as $item){
            $where = array(
                'status'    =>  0,
                'order_type'=>  $item->id    
            );
            $order = $this->master_db->getRecords('orders',$where,'id');

            $result['label'][] = $item->name;
            $result['value'][] = count($order);
        }
        return $result;
    }

    function getWholesalerList($det,$id = ''){
        $post_data = $this->input->post(null, true);
        $order_column = array("w.id","w.id","w.bp_id","w.company_name", "w.address1", "w.representative", "w.contact_no", "w.email", "w.shipping", "w.payment_method", "w.status");
        $this->db->select("w.*");
        $this->db->from('wholesaler w');
        $where = array("w.status!="=>2);
        $this->db->where($where);
        if(isset($post_data["search"]["value"])){
            $sql = "( w.company_name like '%{$post_data["search"]["value"]}%' or w.address1 like '%{$post_data["search"]["value"]}%'
                        or w.address2 like '%{$post_data["search"]["value"]}%' or w.representative like '%{$post_data["search"]["value"]}%'
                        or w.contact_no like '%{$post_data["search"]["value"]}%' or w.email like '%{$post_data["search"]["value"]}%'
                        or w.shipping like '%{$post_data["search"]["value"]}%' or w.bp_id like '%{$post_data["search"]["value"]}%' 
                    ) ";
            $this->db->where($sql);
        }

        if( $id != '' )
            $this->db->where('w.id',$id);
        
        if(isset($post_data["order"])){
            $this->db->order_by($order_column[$post_data['order']['0']['column']]." ".$post_data['order']['0']['dir']);
        }else{
            $this->db->order_by("w.id desc");
        }
        
        
        if( isset($post_data["length"]) && $post_data["length"] != -1){
            if($post_data['start'] > 0){
                $this->db->limit($post_data['length'], $post_data['start']);
            }else{
                $this->db->limit($post_data['length']);
            }
        }
        $q = $this->db->get();
        return $q !== FALSE ? $q->result() : array();
        
    }
}

?>