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
    //end

    function getProduct($product_id = '',$variant_id = ''){

        $where = array(
            'i.status !='   =>  -1,
            'v.status !='   =>  -1
        );

        if( $product_id != '' ){
            $where['i.id'] = $product_id;
        }

        if( $variant_id != '' ){
            $where['v.id'] = $variant_id;
        }

        $select = "i.id,i.sku,i.descr as description,i.name,v.purchase_price,v.margin_id,
                    v.selling_price,v.unit_id,v.height,v.weight,v.width,v.size,m.margin,u.name as unit_name,v.qty,t.percent";
        $this->db->select($select)->from('item_master i')
            ->join('item_variant v','v.item_id=i.id')
            ->join('margin_master m','v.margin_id=m.id','left')
            ->join('unit_master u','v.unit_id=u.id','left')
            ->join('tax_master t','t.id=i.tax_id','left')
            ->where($where);

        $q = $this->db->get();
        return $q !== FALSE ? $q->result() : array();
    }

    function getRandomItemImages($cat_id = 0,$sub_cat_id = 0,$limit = 4){
        
        $where = array(
            'i.status != '  =>  -1,
            'f.status != '  =>  -1
        );

        if(intval($cat_id) != 0){
            $where['i.cat_id'] = $cat_id;
        }
        $select = "concat('".asset_url()."',f.path) as path";
        $this->db->select($select)->from('item_images f')
                ->join('item_master i','i.id=f.item_id','inner')
                ->join('item_category c','c.id=i.cat_id','inner')
                ->join('item_subcategory s','s.id=i.sub_cat_id','inner')
                ->where($where)
                ->limit($limit);

        $q = $this->db->get();
        //echo $this->db->last_query();exit;
        return $q !== FALSE ? $q->result() : array();
    }

    function getProductDetail($id = 0,$cat_id = 0,$sub_cat_id = 0){

        $where = array(
            'i.status !='   =>  -1,
            'f.status !='   =>  -1,
            'f.default_img' =>  1,
            'v.default_variant' =>  1
        );

        if( $id != 0 ){
            $where['i.id'] = $id;
        }

        if( $cat_id != 0 ){
            $where['i.cat_id'] = $cat_id;
        }

        if( $sub_cat_id != 0 ){
            $where['i.sub_cat_id'] = $sub_cat_id;
        }

        $select = "i.id,i.sku,i.name,concat('".asset_url()."',f.path) as image_url,v.selling_price as price";
        $this->db->select($select)->from('item_master i')
            ->join('item_images f','f.item_id=i.id','inner')
            ->join('item_variant v','v.item_id=i.id','inner')
            ->where($where)->order_by('i.id desc');

        $q = $this->db->get();
        //echo $this->db->last_query();exit;
        return $q !== FALSE ? $q->result() : array();
    }

    function getProductVariant($db){
        
        $this->db->select('v.id,v.vsku,v.purchase_price,v.margin_id,v.selling_price,v.unit_id,v.height,v.weight,v.width,v.size,m.margin,u.name as unit_name,v.qty')
                 ->from('item_variant v')
                 ->join('item_master i','i.id=v.item_id')
                 ->join('margin_master m','m.id=v.margin_id')
                 ->join('unit_master u','u.id=v.unit_id')
                 ->where($db);

        $q = $this->db->get();
        //echo $this->db->last_query();exit;
        return $q !== FALSE ? $q->result() : array();
    }

    function getNotification($user_id,$limit,$start){

        $this->db->select('n.id,n.title,n.type,n.message,DATE_FORMAT(n.sent_at,"%d-%m-%Y %h:%i %p") as sent_at')
                ->from('notifications n')
                ->join('notification_recipients r','r.notify_id=n.id')
                ->where('n.status',1)
                ->where('r.user_id',$user_id)
                ->limit($limit, $start)->order_by('n.sent_at desc');

        $q = $this->db->get();
        //echo $this->db->last_query();exit;
        return $q !== FALSE ? $q->result() : array();
    }  

    function getProductsList($start = 0,$limit = 2,$search = ''){

        $where = array(
            'i.status'  =>  1,
            'v.status'  =>  1
        );

        $select = 'i.id,i.sku,i.name,i.descr,i.order_qty,i.stock_status,i.track_status,i.show_catalog,i.stock_out_order';
        $this->db->select($select)->from('item_master i')
            ->join('item_variant v','v.item_id=i.id','inner')
            ->where($where);

        if( $search != '' ){
            $this->db->where("i.name like '%".$search."%' or i.sku like '%".$search."%'");
        }

        $this->db->group_by('i.id')->limit($limit, $start);
        $q = $this->db->get();
        $list = $q !== FALSE ? $q->result() : array();
        
        foreach($list as $item){
            
            $where = array(
                'v.item_id' =>  $item->id,
                'v.status'  =>  1
            );
            $this->db->select('v.id as variant_id,v.item_id,v.qty,v.vsku,v.selling_price,u.name as unit,v.height,v.weight,v.width,v.size')
             ->from('item_variant v')
             ->join('unit_master u','u.id=v.unit_id')
             ->where($where);

            $q = $this->db->get();
            $item->variant = $q !== FALSE ? $q->result() : array();

            $item->images = $this->master_db->getRecords('item_images',array('item_id'=>$item->id),"concat('".asset_url()."',path) as path","default_img desc");
            //echo $this->db->last_query();exit;

        }
        return $list;
    }

    function getOrdersList($status = 1){
        $where = array('o.status'=>$status,'i.status'=>1);
        $this->db->select('o.id as orderid,o.order_no,c.name,c.mobile_no as phone,c.email,count(i.id) as total_items,o.grand_total as total_amount,o.status')
                 ->from('orders o')
                 ->join('order_items i','i.order_id=o.id')
                 ->join('customers c','c.id=o.cust_id')
                 ->where($where)->group_by('i.order_id');
        $q = $this->db->get();
        return $q !== FALSE ? $q->result() : array();
    }

    function getOrderDetail($order_id){
        $where = array('o.id'=>$order_id);
        $select = 'o.id as orderid,o.order_no,c.name,c.mobile_no as phone,c.email,c.gst_number,c.aadhar,
                    date_format(o.created_at,"%d-%m-%Y %h:%I %p") as order_datetime,o.status,o.grand_total as total_amount,
                    o.sub_total,o.discount,o.country,o.state,o.address2,o.address1,o.pincode,o.landmark,o.shipping,o.tax_total';
        $this->db->select($select)
                 ->from('orders o')
                 ->join('customers c','c.id=o.cust_id')
                 ->where($where);
        $q = $this->db->get();
        $order = $q !== FALSE ? $q->result() : array();
        
        if(count($order)){
            $where = array(
                'oi.order_id'   =>  $order_id,
                'oi.status'     =>  1,
            );
            $select = 'i.id as product,v.id as variant,i.name,oi.qty,v.height,v.weight,v.width,v.size,
                        b.name as brand,oi.selling_price as price,oi.total,oi.tax,oi.tax_id,t.percent
                        ';
            $this->db->select($select)->from('order_items oi')
                 ->join('item_master i','i.id=oi.item_id')
                 ->join('item_variant v','v.id=oi.variant_id')
                 ->join('brand_master b','b.id=i.brand_id','left')
                 ->join('tax_master t','t.id=oi.tax_id','left')
                 ->where($where);
            $q = $this->db->get();
            $items = $q !== FALSE ? $q->result() : array();

            foreach($items as $item){
                $item->images = $this->master_db->getRecords('item_images',array('item_id'=>$item->product),"concat('".asset_url()."',path) as path");
            }

            $order[0]->items = $items;

        }
        return $order;
    }

    function getEnquiryList($catalogue_id = 0,$start = 0,$limit = 10){
        $this->db->select('c.name,c.mobile_no as phone,e.product_id,e.variant_id,e.message,i.name as product_name,
                v.height,v.weight,v.width,v.size,b.name as brand,v.selling_price as price,DATE_FORMAT(e.created_at,"%d-%m-%Y %h:%i %p") as send_at
                ')
             ->from('cust_enquiry e')
             ->join('customers c','c.id=e.cust_id')
             ->join('item_master i','i.id=e.product_id')
             ->join('item_category cat','cat.id=i.cat_id')
             ->join('catalogue_master ca','ca.cat_id=cat.id')
             ->join('item_variant v','v.id=e.variant_id')
             ->join('brand_master b','b.id=i.brand_id');
        
        if( intval($catalogue_id) )
            $this->db->where('ca.id',$catalogue_id);
        
        $this->db->order_by('e.created_at desc')->limit($limit, $start);
        $q = $this->db->get();
        $list = $q !== FALSE ? $q->result() : array();
        //echo $this->db
        foreach($list as $item){
            $images = $this->master_db->getRecords('item_images',array('item_id'=>$item->product_id),"concat('".asset_url()."',path) as image",'default_img desc');
            if(count($images)){
                $item->image = $images[0]->image;
            }else{
                $item->image = '';
            }
            //$s = time() - strtotime($item->send_at);
            //$item->total_view_time = sprintf('%d:%02d:%02d:%02d', $s/86400, $s/3600%24, $s/60%60, $s%60);
        }
        return $list;
    }

    function getVisitorList($catalogue_id,$start = 0,$limit = 10){

        $select = "c.id as visitor_id,ca.id as catalogue_id,c.name as visitor_name,c.mobile_no as phone,c.email,ca.name as catalogue_name,
                    ca.cat_id,DATE_FORMAT(v.visited_at,'%d-%m-%Y %h:%i %p') as last_view_time";
        
        $this->db->select($select)->from('catalogue_visits v')
                ->join('catalogue_master ca','ca.id = v.catalogue_id')
                ->join('customers c','c.id = v.cust_id','left');
        /*
        $this->db->select($select)
             ->from('customer_view_history h')
             ->join('catalogue_visits v','v.catalogue_id = h.catalogue_id and v.cust_id = h.cust_id')
             ->join('catalogue_master ca','ca.id = v.catalogue_id')
             ->join('item_master i','i.cat_id = ca.cat_id and i.id = h.product_id')
             ->join('customers c','c.id = h.cust_id');
        */

        if( intval($catalogue_id) ){
            $this->db->where('ca.id',$catalogue_id);
        }
        $this->db->order_by('v.visited_at desc')->limit($limit, $start);
             
        $q = $this->db->get();
        $list = $q !== FALSE ? $q->result() : array();
        //echo $this->db->last_query();echo '<pre>';print_r($list);exit;

        foreach($list as $item){
            
            $item->total_view_time = 0;
            //var_dump($item->visitor_id);continue;
            if( !empty($item->visitor_id) && $item->visitor_id != null ){
                $condition = "cust_id = ".$item->visitor_id." and catalogue_id = $item->catalogue_id 
                        and visited_at like '%".date('Y-m-d',strtotime($item->last_view_time))."%'";
                $total_seconds = $this->master_db->getRecords('customer_view_history',$condition,'sum(seconds) as seconds');
                //print_r($total_seconds);exit;
                $item->total_view_time = $total_seconds[0]->seconds;
            }

            $item->last_view_time = $item->last_view_time;
            $item->time_ago = time_elapsed_string($item->last_view_time);

            $s = (int)$item->total_view_time;
            $item->total_view_time = sprintf('%d:%02d:%02d:%02d', $s/86400, $s/3600%24, $s/60%60, $s%60);
            
            if( !empty($item->visitor_id) && $item->visitor_id != null ){
                $sql = "select round(sum(seconds)) as seconds from customer_view_history 
                    where visited_at like '%".date('Y-m-d',strtotime($item->last_view_time))."%' and  catalogue_id = ".$item->catalogue_id."
                     and cust_id = ".$item->visitor_id;
                $s = $this->master_db->sqlExecute($sql)[0]->seconds;
                $item->last_view_time = sprintf('%d:%02d:%02d:%02d', $s/86400, $s/3600%24, $s/60%60, $s%60);
            }else{
                $item->last_view_time = 0;
            }

            $where = array(
                'i.status'  =>  1,
                'v.status'  =>  1
            );

            if( !empty($item->cat_id) ){
                $where['i.cat_id'] = $item->cat_id;
            }
    
            $select = 'i.id,i.sku,i.name,i.descr,i.order_qty,i.stock_status,i.track_status,i.show_catalog,i.stock_out_order';
            $this->db->select($select)->from('item_master i')
                ->join('item_variant v','v.item_id=i.id','inner')
                ->where($where);
            $this->db->group_by('i.id');//->limit($limit, $start);
            $q = $this->db->get();
            $products = $q !== FALSE ? $q->result() : array();
            //echo $this->db->last_query();print_r($products);exit;

            $total_products = count($products);

            $visited = 0;
            if( !empty($item->visitor_id) && $item->visitor_id != null ){
                $where = array(
                    'catalogue_id'  =>  $item->catalogue_id,
                    'cust_id'       =>  $item->visitor_id
                );            
                $this->db->select('count(id) as products')
                    ->from('customer_view_history')
                    ->where($where);
                $this->db->group_by('product_id');
                $q = $this->db->get();
                $products = $q !== FALSE ? $q->result() : array();
                $visited = count($products);
            }
            
            //echo $visited.' --- '.$total_products.'<br>';exit;
            
            $item->interest = 0;
            if( $visited == $total_products ){
                $item->interest = 100;
            }else if( $visited ){
                $item->interest = round(($visited/$total_products)*100);
            }
            $item->visits = count($this->master_db->getRecords('catalogue_visits',array('catalogue_id'=>$item->catalogue_id),'id'));
            unset($item->id);
        }
        //echo '<pre>';print_r($list);exit;
        return $list;
    }

    function getVisitorDetail($visitor_id,$catalogue_id = ''){
        
        $select = "c.id,ca.id as catalogue_id,c.name as visitor_name,c.mobile_no as phone,c.email,ca.name as catalogue_name,
                    ca.cat_id,DATE_FORMAT(v.visited_at,'%d-%m-%Y %h:%i %p') as last_view_time,sum(h.seconds) as total_view_time";
        $this->db->select($select)
             ->from('customer_view_history h')
             ->join('catalogue_visits v','v.catalogue_id = h.catalogue_id and v.cust_id = h.cust_id')
             ->join('catalogue_master ca','ca.id = v.catalogue_id')
             ->join('item_master i','i.cat_id = ca.cat_id and i.id = h.product_id')
             ->join('customers c','c.id = h.cust_id');

        $this->db->where('v.cust_id',$visitor_id);

        if( intval($catalogue_id) ){
            $this->db->where('h.catalogue_id',$catalogue_id);
        }
        $this->db->group_by('h.catalogue_id')->order_by('v.visited_at desc');//->limit($limit, $start);
             
        $q = $this->db->get();
        $list = $q !== FALSE ? $q->result() : array();
        //echo '<pre>';print_r($list);exit;
        foreach($list as $item){
            
            $where = array(
                'i.status'  =>  1,
                'v.status'  =>  1,
                'i.cat_id'  =>  $item->cat_id
            );
    
            $select = 'i.id,';
            $this->db->select($select)->from('item_master i')
                ->join('item_variant v','v.item_id=i.id','inner')
                ->where($where);
            $this->db->group_by('i.id');
            $q = $this->db->get();
            $ptotal = $q !== FALSE ? $q->result() : array();
            //echo $this->db->last_query();print_r($products);exit;

            $total_products = count($ptotal);
            $where = array(
                'h.catalogue_id'  =>  $item->catalogue_id,
                'h.cust_id'       =>  $item->id
            );            

            $select = "i.id,i.sku,i.name,concat('".asset_url()."',g.path) as image,
                        CONCAT(
                            FLOOR(TIME_FORMAT(SEC_TO_TIME(sum(h.seconds)), '%H') / 24), 'days ',
                            MOD(TIME_FORMAT(SEC_TO_TIME(sum(h.seconds)), '%H'), 24), 'h:',
                            TIME_FORMAT(SEC_TO_TIME(sum(h.seconds)), '%im:%ss')
                        ) as time_spent";
            $this->db->select($select)
                ->from('customer_view_history h')
                ->join('item_master i','i.id=h.product_id')
                ->join('item_images g','g.item_id=i.id','inner')
                ->where($where);
            $this->db->group_by('h.product_id');
            $q = $this->db->get();
            $pvisited = $q !== FALSE ? $q->result() : array();
            //echo $this->db->last_query();print_r($pvisited);exit;
            $visited = count($pvisited);
            //echo $visited.' --- '.$total_products.'<br>';exit;
            
            $item->interest = 0;
            if( $visited == $total_products ){
                $item->interest = 100;
            }else if( $visited ){
                $item->interest = round(($visited/$total_products)*100);
            }

            $item->opens = count($this->master_db->getRecords('catalogue_visits',array('catalogue_id'=>$item->catalogue_id),'id'));
            //enquiry
            $where = array(
                'e.cust_id' =>  $visitor_id,
                'i.cat_id'  =>  $item->cat_id,
                'e.status'  =>  1
            );
            $this->db->select('e.id,e.message,i.sku,i.name,concat("'.asset_url().'",g.path) as image')
                ->from('cust_enquiry e')
                ->join('item_master i','i.id=e.product_id')
                ->join('item_images g','g.item_id=i.id','inner')
                ->where($where)->group_by('g.item_id');
            $q = $this->db->get();
            $enquiry = $q !== FALSE ? $q->result() : array();
            //echo $this->db->last_query();exit;
            $item->enquiry = count($enquiry);
            $item->enquiry_product = $enquiry;
            //end

            $item->seen_products = $pvisited;
            
            $product_id = $array = json_decode(json_encode($pvisited),true);
            $product_id = implode(',',array_column($product_id,'id'));

            $condition = "i.status = 1 and v.status = 1 and i.cat_id = $item->cat_id ";
            if( $product_id != '' ){
                $condition .= " and i.id not in ($product_id) ";
            }

            $select = 'i.id,i.sku,i.name,concat("'.asset_url().'",g.path) as image';
            $this->db->select($select)->from('item_master i')
                ->join('item_variant v','v.item_id=i.id','inner')
                ->join('item_images g','g.item_id=i.id')
                ->where($condition);
            $this->db->group_by('g.item_id');
            $q = $this->db->get();
            $notseen = $q !== FALSE ? $q->result() : array();
            //echo $this->db->last_query();print_r($notseen);exit;

            $item->notseen_products = $notseen;

            $where = array(
                'h.catalogue_id'  =>  $item->catalogue_id,
                'h.cust_id'       =>  $item->id
            );    
            $select = "i.sku,i.name,concat('".asset_url()."',g.path) as image,ROUND(seconds) as seconds,visited_at";
            $this->db->select($select)
                ->from('customer_view_history h')
                ->join('item_master i','i.id=h.product_id')
                ->join('item_images g','g.item_id=i.id','inner')
                ->where($where);
            $this->db->group_by('h.id');
            $q = $this->db->get();
            $pvisited = $q !== FALSE ? $q->result() : array();
            $item->activity = $pvisited;
            //echo $this->db->last_query();print_r($pvisited);exit;

            foreach($item->activity as $row){
                $row->time_ago = time_elapsed_string($row->visited_at);
            }

            unset($item->id);
            unset($item->cat_id);
            unset($item->catalogue_id);
        }
        //echo '<pre>';print_r($list);exit;
        return $list;

    }

    function orderItems($order_id){

        $where = array(
            'oi.order_id'   =>  $order_id,
            'oi.status'     =>  1,
        );
        $select = 'i.id as product,v.id as variant,i.name,oi.qty,v.height,v.weight,v.width,v.size,
                    b.name as brand,oi.selling_price as price,oi.total,oi.tax,oi.tax_id,t.percent
                    ';
        $this->db->select($select)->from('order_items oi')
             ->join('item_master i','i.id=oi.item_id')
             ->join('item_variant v','v.id=oi.variant_id')
             ->join('brand_master b','b.id=i.brand_id','left')
             ->join('tax_master t','t.id=oi.tax_id','left')
             ->where($where);
        $q = $this->db->get();
        return $q !== FALSE ? $q->result() : array();

    }

    function getCustomerDetail($db,$select = ''){
        if( $select == '' ){
            $select = "c.id as user_id,c.name,c.email as email_id,DATE_FORMAT(c.dob,'%d-%m-%Y') as dob,c.bloodgroup as blood_group,c.address,
                    if(c.gender=1,'Male','Female') as gender,ct.id as country_id,ct.name as country_name,
                    st.id as state_id,st.name as state_name,dt.id as dist_id,dt.name as dist_name,t.id as city_id,
                    t.name as city_name,c.code,c.photo,c.mobileno,cp.card_no,cp.pstatus,cp.valid_from,cp.valid_to,cp.created_at,cp.card_img,
                    p.color,p.card_type,p.name as package,p.price,p.validity,cp.qrcode";
        }
        
        $this->db->select($select)->from('customers c')
                ->join('customer_package cp','cp.customer_id=c.id','inner')
                ->join('packages p','p.id=cp.package_id','inner')
                //->join('customer_points po','po.customer_id=c.id','inner')
                ->join('countries ct','ct.id=c.country_id','left')
                ->join('states st','st.id=c.state_id','left')
                ->join('districts dt','dt.id=c.district_id','left')
                ->join('cities t','t.id=c.taluk_id','left')
                ->where($db);
        $q = $this->db->get();
        //echo $this->db->last_query();exit;
        return $q !== FALSE ? $q->result() : array();
    }

}

?>