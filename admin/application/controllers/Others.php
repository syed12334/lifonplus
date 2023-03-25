<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
//error_reporting(E_ALL);ini_set('display_errors', '1');
class Others extends CI_Controller {   

	protected $data;
    public function __construct()
    {
        parent::__construct();
        $this->load->helper('utility_helper');
        no_cache();
        $this->data['detail'] = '';
        $this->data['session'] = ADMIN_SESSION;
        $this->load->model('home_db');
        $this->load->model('master_db');
        $this->load->model('web_db');
        
        if (!$this->session->userdata($this->data['session'])) {
            redirect('Login', 'refresh');
        }else{
            $sessionval = $this->session->userdata($this->data['session']);
            $exp = explode("~", $sessionval);
            if(count($exp) == 2){
                $db['phone']=$exp[0];
                $db['password']=$exp[1];
                $details = $this->home_db->getlogin($db, 0);
                if(count($details) && $details[0]->password == $exp[1]){  
                    
                    if($details[0]->status == 1){
                        $this->data['detail']=$details;
                    }else{
                        $this->session->set_flashdata('message','<div class="alert alert-danger alert-dismissable"><button class="close" aria-hidden="true" data-dismiss="alert" type="button">&times;</button>Your account has been deactivated. Please contact Administrator.</div>');
                        redirect(base_url()."login/logout");
                    }
                }else{
                    $this->session->set_flashdata('message','<div class="alert alert-danger alert-dismissable"><button class="close" aria-hidden="true" data-dismiss="alert" type="button">&times;</button>Invalid Credentials.</div>');
                    redirect(base_url()."login/logout");
                }
            }else{
                $this->session->set_flashdata('message','<div class="alert alert-danger alert-dismissable"><button class="close" aria-hidden="true" data-dismiss="alert" type="button">&times;</button>Invalid Credentials.</div>');
                redirect(base_url()."login/logout");
            }
        }
        
        $this->data['updatelogin']=$this->load->view('updatelogin', NULL , TRUE);
        $this->data['style']=$this->load->view('style', $this->data , TRUE);
        $this->data['header']=$this->load->view('header', $this->data , TRUE);
        $this->data['footer']=$this->load->view('footer', $this->data , TRUE);
        $this->data['leftmain']=$this->load->view('leftmenudynamic', NULL , TRUE);
        $this->data['jsfile']=$this->load->view('jsfile', NULL , TRUE);
    }    

    public function index(){
        $this->coupons();
    }
	
	
	
	public function points(){
		$this->data['settings'] = $this->master_db->getRecords('points_setting',array(),'id,signup,referral');
        $this->load->view('others/points_view',$this->data);
    }
	
	public function savepoints()
	{
		$det = $this->data['detail'];
		$signup = $this->input->post('signup');
		$referral = $this->input->post('referral');
		$check = $this->master_db->getRecords('points_setting',array(),'id');
		
		if($signup == "" || $referral == "")
		{
			$this->session->set_flashdata('message','<div class="alert alert-danger alert-dismissable"><button class="close" aria-hidden="true" data-dismiss="alert" type="button">&times;</button>Missing Mandatory Fields!</div>');
		    redirect(base_url().'others/points');
		}
		$update_data = array(
			'signup'        =>  $signup,
			'referral'        =>  $referral,
			'updated_at'    =>  date('Y-m-d H:i:s'),
			'updated_by'    =>  $det[0]->id
		);
			
		if(count($check) == 0 ){
		    $this->master_db->insertRecord('points_setting',$update_data);
		}
		else{
			$this->master_db->updateRecord('points_setting',$update_data,array('id'=>$check[0]->id));
		}
		$this->session->set_flashdata('message','<div class="alert alert-success alert-dismissable"><button class="close" aria-hidden="true" data-dismiss="alert" type="button">&times;</button> Updated Successfully!</div>');
			
		redirect(base_url().'others/points');
	}
	

	public function terms(){
		$this->data['terms'] = $this->master_db->getRecords('terms_conditions',array(),'id,terms');
        $this->load->view('others/terms_conditions_view',$this->data);
    }
	
	public function saveterms()
	{
		$det = $this->data['detail'];
		$terms = $this->input->post('terms');
		$check = $this->master_db->getRecords('terms_conditions',array(),'id');
		
		if($terms == "")
		{
			$this->session->set_flashdata('message','<div class="alert alert-success alert-dismissable"><button class="close" aria-hidden="true" data-dismiss="alert" type="button">&times;</button>Enter Terms and conditions!</div>');
		    redirect(base_url().'others/terms');
		}
		$update_data = array(
			'terms'   =>  $terms,
			'updated_at'    =>  date('Y-m-d H:i:s'),
			'updated_by'    =>  $det[0]->id
		);
			
		if(count($check) == 0 ){
		    $this->master_db->insertRecord('terms_conditions',$update_data);
		}
		else{
			$this->master_db->updateRecord('terms_conditions',$update_data,array('id'=>$check[0]->id));
		}
		$this->session->set_flashdata('message','<div class="alert alert-success alert-dismissable"><button class="close" aria-hidden="true" data-dismiss="alert" type="button">&times;</button> Updated Successfully!</div>');
			
		redirect(base_url().'others/terms');
	}
	
	
	public function privacy(){
		$this->data['privacy'] = $this->master_db->getRecords('privacy_policy',array(),'id,privacy');
        $this->load->view('others/privacy_policy_view',$this->data);
    }
	
	public function saveprivacy()
	{
		$det = $this->data['detail'];
		$privacy = $this->input->post('privacy');
		$check = $this->master_db->getRecords('privacy_policy',array(),'id');
		
		if($privacy == "")
		{
			$this->session->set_flashdata('message','<div class="alert alert-success alert-dismissable"><button class="close" aria-hidden="true" data-dismiss="alert" type="button">&times;</button>Enter Privacy Policy!</div>');
		    redirect(base_url().'others/privacy');
		}
		$update_data = array(
			'privacy'   =>  $privacy,
			'updated_at'    =>  date('Y-m-d H:i:s'),
			'updated_by'    =>  $det[0]->id
		);
			
		if(count($check) == 0 ){
		    $this->master_db->insertRecord('privacy_policy',$update_data);
		}
		else{
			$this->master_db->updateRecord('privacy_policy',$update_data,array('id'=>$check[0]->id));
		}
		$this->session->set_flashdata('message','<div class="alert alert-success alert-dismissable"><button class="close" aria-hidden="true" data-dismiss="alert" type="button">&times;</button> Updated Successfully!</div>');
			
		redirect(base_url().'others/privacy');
	}
	
	
	
	
	
	public function aboutus(){
		$this->data['about'] = $this->master_db->getRecords('about_us',array(),'id,aboutus');
        $this->load->view('others/aboutus_view',$this->data);
    }
	
	public function saveabout()
	{
		$det = $this->data['detail'];
		$about = $this->input->post('about');
		$check = $this->master_db->getRecords('about_us',array(),'id');
		
		if($about == "")
		{
			$this->session->set_flashdata('message','<div class="alert alert-success alert-dismissable"><button class="close" aria-hidden="true" data-dismiss="alert" type="button">&times;</button>Enter About Us!</div>');
		    redirect(base_url().'others/aboutus');
		}
		$update_data = array(
			'aboutus'   =>  $about,
			'updated_at'    =>  date('Y-m-d H:i:s'),
			'updated_by'    =>  $det[0]->id
		);
			
		if(count($check) == 0 ){
		    $this->master_db->insertRecord('about_us',$update_data);
		}
		else{
			$this->master_db->updateRecord('about_us',$update_data,array('id'=>$check[0]->id));
		}
		$this->session->set_flashdata('message','<div class="alert alert-success alert-dismissable"><button class="close" aria-hidden="true" data-dismiss="alert" type="button">&times;</button> Updated Successfully!</div>');
			
		redirect(base_url().'others/aboutus');
	}


    public function coupons(){
        $this->data['state'] = $this->master_db->getRecords('states',array('status'=>1),"id,name,state_code",'name asc');
        $this->data['district'] = $this->master_db->getRecords('districts',array('status'=>1),"id,name",'name asc');
        $this->data['taluk'] = $this->master_db->getRecords('cities',array('status'=>1),"id,name",'name asc');
        $this->data['customers'] = $this->master_db->getRecords('customers',array('status'=>1),"id,name",'name asc');
        $this->load->view('others/coupons',$this->data);
    }
    public function states() {
                $id = $this->input->post('id');
                
        $district = $this->master_db->getRecords('districts',array("state_id"=>$id),"id,name",'name asc');
        $html ="";
        $html .="<option value=''>Select district</option>";
        foreach ($district as $key => $value) {
            $html .="<option value='".$value->id."'>".$value->name."</option>";
        }
        echo $html;

    }

    public function taluks() {
                $id = $this->input->post('id');
                
        $taluk = $this->master_db->getRecords('cities',array("district_id"=>$id),"id,name",'name asc');
        $html ="";
        $html .="<option value=''>Select taluk</option>";
        foreach ($taluk as $key => $value) {
            $html .="<option value='".$value->id."'>".$value->name."</option>";
        }
        echo $html;

    }
     public function custmer_names() {
        //echo "<pre>";print_r($_POST);exit;
        $sid = trim(html_escape($this->input->post('state')));
        $dis = trim(html_escape($this->input->post('dis')));
        $tal = trim(html_escape($this->input->post('taluk')));

        $customers = $this->master_db->getRecords('customers',array("state_id"=>$sid,"district_id"=>$dis,'taluk_id'=>$tal,'status='=>1),"id,name",'name asc');
       // echo $this->db->last_query();exit;
        $html ="";
        $html .="<option value=''>Select Customer</option>";
        foreach ($customers as $key => $value) {
            $html .="<option value='".$value->id."'>".$value->name."</option>";
        }
        echo $html;

    }

    public function couponsList(){
        $det = $this->data['detail'];
        $data_list = $this->web_db->getCouponsList($det);
        $log = $this->db->last_query();
        $file = 'sql.txt';
        //$json = "sdsd";
        $log = $log."\r\n";
        //file_put_contents($file, $log , FILE_APPEND | LOCK_EX);
        $data = array();
        $i = $_POST["start"]+1;
        
        foreach($data_list as $row)
        {
            $sub_array = array();
            $sub_array[] = $i++;
            $state = $row->state;
            $district = $row->district;
            $cid = $row->cname;

            $taluk = $row->taluk;
            $states = $this->master_db->getRecords('states',array("id"=>$state),"name,state_code");
            $districts = $this->master_db->getRecords('districts',array("id"=>$district),"name");
            $taluks = $this->master_db->getRecords('cities',array("id"=>$taluk),"name");
           // $customers = $this->master_db->sqlExecute("select name from customers where id in ($cid)");
        //     $cusArr =[];
        //     foreach ($customers as $key => $value) {
        //        $cusArr[]=$value->name;
        //     }
        //    $cuscomma = implode(',',$cusArr);
        //     $sta ="";$dist="";$tal ="";
        //     foreach ($states as $key => $value) {
        //         $sta .= $value->name." - ".$value->state_code;            
        //     }

        //  foreach ($districts as $key => $value) {
        //     $dist .= $value->name;            
        // }

        //  foreach ($taluks as $key => $value) {
        //     $tal .= $value->name;            
        // }

            $action = '<button type="button" title="Edit" name="update" onclick="modifyRow('.$row->id.');" class="btn btn-primary btn-sm"><i class="fas fa-edit"></i></button>&nbsp;';
            
            if( (int)$row->status == 1 ){
                $status = "<span class='text-success'><i class='fas fa-check'></i> Active</span>";
                $action .= "<button title='Deactive' onclick='updateStatus(".$row->id.", 0)' class='btn btn-warning btn-sm'><i class='fas fa-times-circle'></i></button>&nbsp;";
            }else{
                $status = "<span class='text-warning'><i class='fas fa-times-circle'></i> In-Active</span>";
                $action .= "<button title='Activate' onclick='updateStatus(".$row->id.", 1)' class='btn btn-success btn-sm'><i class='fas fa-check'></i></button>&nbsp;";
            }
            $action .= "<button title='Delete' onclick='updateStatus(".$row->id.", -1)' class='btn btn-danger btn-sm'><i class='fas fa-trash'></i></button>&nbsp;";
            $sub_array[] = $action;
            $sub_array[] = $row->coupon_title;
            $sub_array[] = $row->coupon_code;
			$sub_array[] = $row->from_date;
			$sub_array[] = $row->to_date;
			$sub_array[] = $row->discount_type;
			$sub_array[] = $row->amount;
            $sub_array[] = $status;
            $data[] = $sub_array;
            
        }
        $_POST["length"] = -1;
        $coupons = $this->web_db->getCouponsList($det);
        
        $total = count($coupons);
        $output = array(
            "draw"              =>  intval($_POST["draw"]),
            "recordsTotal"      =>  $total,
            "recordsFiltered"   =>  $total,//$this->master_db->get_filtered_data("guards")
            "data"              =>  $data
        );
        echo json_encode($output);
    }

    public function saveCoupon(){
        $det = $this->data['detail'];
        //echo "<pre>";print_r($_POST);exit;
		$id = trim(preg_replace('!\s+!', ' ',html_escape($this->input->post('id', true))));
		$coupon_code = trim(preg_replace('!\s+!', ' ',html_escape($this->input->post('coupon_code', true))));
		$coupon_title = trim(preg_replace('!\s+!', ' ',html_escape($this->input->post('coupon_title', true))));
		$from_date = trim(preg_replace('!\s+!', ' ',html_escape($this->input->post('from_date', true))));
		$to_date = trim(preg_replace('!\s+!', ' ',html_escape($this->input->post('to_date', true))));
		$no_of_users = trim(preg_replace('!\s+!', ' ',html_escape($this->input->post('no_of_users', true))));
		//$cname = $this->input->post('cname', true);
        //$im = implode(",", $cname);
        $state = trim(preg_replace('!\s+!', ' ',html_escape($this->input->post('state', true))));
        $district = trim(preg_replace('!\s+!', ' ',html_escape($this->input->post('district', true))));
        $taluk = trim(preg_replace('!\s+!', ' ',html_escape($this->input->post('taluk', true))));
		$discount_type = trim(preg_replace('!\s+!', ' ',html_escape($this->input->post('discount_type', true))));
		$amount = trim(preg_replace('!\s+!', ' ',html_escape($this->input->post('amount', true))));
        $phone = trim(preg_replace('!\s+!', ' ',html_escape($this->input->post('phone', true))));
        $customers = $this->input->post('customer');
       
        if( !empty($_POST['coupon_code']) && !empty($_POST['coupon_title']) && !empty($_POST['id']) ){
            $where = array(
                'id != '        =>  $id,        
                'coupon_code'   =>  $coupon_code,
                'status != '    =>  -1
            );
            $check = $this->master_db->getRecords('coupons',$where,'id');
            if( count($check) == 0 ){

                $update_data['coupon_code'] = $coupon_code;
                $update_data['coupon_title'] = $coupon_title;
                if(is_array($customers) && !empty($customers)) {
                     $cname = implode(",", $customers);
                     $update_data['cname'] = $cname;
                }
                $update_data['state'] = $state;
                $update_data['district'] = $district;
                $update_data['taluk'] = $taluk;
                $update_data['mphone'] = $phone;
                $update_data['from_date'] = $from_date;
                $update_data['to_date'] = $to_date;
                $update_data['discount_type'] = $discount_type;
                $update_data['amount'] = $amount;
                $update_data['updated_by'] = date('Y-m-d H:i:s');
                $update_data['updated_by'] = $det[0]->id;
                $this->master_db->updateRecord('coupons',$update_data,array('id'=>$id));
                echo 1;
            }else{
                echo "Coupon Code already exists.";
            }
        }
		else if( !empty($_POST['coupon_code']) && !empty($_POST['coupon_title']) ){
           
            $where = array(
                'coupon_code'   =>  $coupon_code,
                'status != '=>  -1
            );
            $check = $this->master_db->getRecords('coupons',$where,'id');
            if( count($check) == 0 ){
                 
                $insert_data['coupon_code'] = $coupon_code;
                $insert_data['coupon_title'] = $coupon_title;
                if(is_array($customers) && !empty($customers)) {
                     $cname = implode(",", $customers);
                     $insert_data['cname'] = $cname;
                }
                $insert_data['state'] = $state;
                $insert_data['district'] = $district;
                $insert_data['taluk'] = $taluk;
                $insert_data['mphone'] = $phone;
                $insert_data['from_date'] = $from_date;
                $insert_data['to_date'] = $to_date;
                $insert_data['discount_type'] = $discount_type;
                $insert_data['amount'] = $amount;
                $insert_data['created_at'] = date('Y-m-d H:i:s');
                $insert_data['created_by'] = $det[0]->id;
                $insert_data['status'] = 1;
               
                $id = $this->master_db->insertRecord('coupons',$insert_data);
                echo 1;
            }else{
                echo "Coupon already exists.";
            }
        }
    }

    public function setCouponStatus(){
        $det = $this->data['detail'];
        $id = trim($this->input->post('id'));
        $status = trim($this->input->post('status'));

        $where_data = array(
            'status'=>$status,
            'updated_at'=>date('Y-m-d H:i:s'),
            'updated_by'=>$det[0]->id
        );
        $this->master_db->updateRecord('coupons',$where_data,array('id'=>$id));
        echo 1;
    }

    public function getCoupon($id = ''){
        $det = $this->data['detail'];
        if( $id != '' ){
            $where = array(
                'id'        =>  $id,
                'status != '=>  -1
            );
            $check = $this->master_db->getRecords('coupons',$where,'id,coupon_code,coupon_title,cname,state,district,taluk,mphone,from_date,to_date,no_of_users,amount,discount_type');
            $cid = $check[0]->cname;
            $ex = explode(",", $cid);
            if( count($check) == 0 ){
                echo json_encode(array('status'=>'fail'));
            }else{
                echo json_encode(array('status'=>'success','data'=>$check[0],'cid'=>$ex));
            }
        }
    }
    //end
	
	
	
	 public function healthtips(){
        $this->load->view('others/healthtips',$this->data);
    }

    public function healthtipsList(){
        $det = $this->data['detail'];
        $data_list = $this->web_db->getHealthtipsList($det);
        $log = $this->db->last_query();
        $file = 'sql.txt';
        //$json = "sdsd";
        $log = $log."\r\n";
        //file_put_contents($file, $log , FILE_APPEND | LOCK_EX);
        $data = array();
        $i = $_POST["start"]+1;
        
        foreach($data_list as $row)
        {
            $sub_array = array();
            $sub_array[] = $i++;
            $action = '<button type="button" title="Edit" name="update" onclick="modifyRow('.$row->id.');" class="btn btn-primary btn-sm"><i class="fas fa-edit"></i></button>&nbsp;';
            
            if( (int)$row->status == 1 ){
                $status = "<span class='text-success'><i class='fas fa-check'></i> Active</span>";
                $action .= "<button title='Deactive' onclick='updateStatus(".$row->id.", 0)' class='btn btn-warning btn-sm'><i class='fas fa-times-circle'></i></button>&nbsp;";
            }else{
                $status = "<span class='text-warning'><i class='fas fa-times-circle'></i> In-Active</span>";
                $action .= "<button title='Activate' onclick='updateStatus(".$row->id.", 1)' class='btn btn-success btn-sm'><i class='fas fa-check'></i></button>&nbsp;";
            }
            $action .= "<button title='Delete' onclick='updateStatus(".$row->id.", -1)' class='btn btn-danger btn-sm'><i class='fas fa-trash'></i></button>&nbsp;";
            $sub_array[] = $action;
            $sub_array[] = $row->coupon_title;
            $sub_array[] = $row->coupon_code;
			$sub_array[] = $row->from_date;
			$sub_array[] = $row->to_date;
            $sub_array[] = $status;
            $data[] = $sub_array;
            
        }
        $_POST["length"] = -1;
        $healthtips = $this->web_db->getHealthtipsList($det);
        
        $total = count($healthtips);
        $output = array(
            "draw"              =>  intval($_POST["draw"]),
            "recordsTotal"      =>  $total,
            "recordsFiltered"   =>  $total,//$this->master_db->get_filtered_data("guards")
            "data"              =>  $data
        );
        echo json_encode($output);
    }

    public function saveHealthTips(){
        $det = $this->data['detail'];
		$id = trim(preg_replace('!\s+!', ' ',html_escape($this->input->post('id', true))));
		$coupon_code = trim(preg_replace('!\s+!', ' ',html_escape($this->input->post('coupon_code', true))));
		$coupon_title = trim(preg_replace('!\s+!', ' ',html_escape($this->input->post('coupon_title', true))));
		$from_date = trim(preg_replace('!\s+!', ' ',html_escape($this->input->post('from_date', true))));
		$to_date = trim(preg_replace('!\s+!', ' ',html_escape($this->input->post('to_date', true))));
		$no_of_users = trim(preg_replace('!\s+!', ' ',html_escape($this->input->post('no_of_users', true))));
        if( !empty($_POST['coupon_code']) && !empty($_POST['coupon_title']) && !empty($_POST['id']) ){
            
            $where = array(
                'id != '        =>  $id,        
                'coupon_code'   =>  $coupon_code,
                'status != '    =>  -1
            );
            $check = $this->master_db->getRecords('healthtips',$where,'id');
            if( count($check) == 0 ){
                $update_data = array(
                    'coupon_code'   =>  $coupon_code,
					'coupon_title'  =>  $coupon_title,
					'from_date'     =>  $from_date,
					'to_date'       =>  $to_date,
					'no_of_users'   =>  $no_of_users,
                    'updated_at'    =>  date('Y-m-d H:i:s'),
                    'updated_by'    =>  $det[0]->id
                );
                $this->master_db->updateRecord('healthtips',$update_data,array('id'=>$id));
                echo 1;
            }else{
                echo "Coupon Code already exists.";
            }
        }
		else if( !empty($_POST['coupon_code']) && !empty($_POST['coupon_title']) ){
           
            $where = array(
                'coupon_code'   =>  $coupon_code,
                'status != '=>  -1
            );
            $check = $this->master_db->getRecords('healthtips',$where,'id');
            if( count($check) == 0 ){
                $insert_data = array(
                   'coupon_code'   =>  $coupon_code,
					'coupon_title'  =>  $coupon_title,
					'from_date'     =>  $from_date,
					'to_date'       =>  $to_date,
					'no_of_users'   =>  $no_of_users,
                    'created_at'    =>  date('Y-m-d H:i:s'),
                    'created_by'    =>  $det[0]->id,
                    'status'        =>  1,
                );
                $id = $this->master_db->insertRecord('healthtips',$insert_data);
                echo 1;
            }else{
                echo "Coupon already exists.";
            }
        }
    }

    public function sethealthtipstatus(){
        $det = $this->data['detail'];
        $id = trim($this->input->post('id'));
        $status = trim($this->input->post('status'));

        $where_data = array(
            'status'=>$status,
            'updated_at'=>date('Y-m-d H:i:s'),
            'updated_by'=>$det[0]->id
        );
        $this->master_db->updateRecord('healthtips',$where_data,array('id'=>$id));
        echo 1;
    }
	
	
	
	
	
	
	
	
	
	
}
?>