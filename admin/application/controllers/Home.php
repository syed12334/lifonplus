<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
error_reporting(E_ALL);ini_set('display_errors', '1');
class Home extends CI_Controller {   

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
        $this->load->model('app_db');
        
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

   /*******Company Name*******/
     public function company_name(){
        $this->load->view('masters/company_name',$this->data);
    }

    public function company_nameList(){
        $det = $this->data['detail'];
        $data_list = $this->master_db->getcompany_nameList($det);
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
                //$action .= "<button title='Deactive' onclick='updateStatus(".$row->id.", 0)' class='btn btn-warning btn-sm'><i class='fas fa-times-circle'></i></button>&nbsp;";
            }else{
                $status = "<span class='text-warning'><i class='fas fa-times-circle'></i> In-Active</span>";
               // $action .= "<button title='Activate' onclick='updateStatus(".$row->id.", 1)' class='btn btn-success btn-sm'><i class='fas fa-check'></i></button>&nbsp;";
            }
           // $action .= "<button title='Delete' onclick='updateStatus(".$row->id.", -1)' class='btn btn-danger btn-sm'><i class='fas fa-trash'></i></button>&nbsp;";
            $sub_array[] = $action;
            $sub_array[] = $row->name;
            $sub_array[] = $status;
            $data[] = $sub_array;
            
        }
        $_POST["length"] = -1;
        $members = $this->master_db->getcompany_nameList($det);
        
        $total = count($members);
        $output = array(
            "draw"              =>  intval($_POST["draw"]),
            "recordsTotal"      =>  $total,
            "recordsFiltered"   =>  $total,//$this->master_db->get_filtered_data("guards")
            "data"              =>  $data
        );
        echo json_encode($output);
    }

    public function savecompanyname(){
         $det = $this->data['detail'];
        if( !empty($_POST['name']) && !empty($_POST['address']) && !empty($_POST['phone_no']) && !empty($_POST['email']) && !empty($_POST['pan_no']) && !empty($_POST['bank_name']) && !empty($_POST['account_no']) && !empty($_POST['ifsc_code']) && !empty($_POST['branch_name'])){
            //echo '<pre>';print_r($_POST);exit;
            $id = trim(preg_replace('!\s+!', ' ',html_escape($this->input->post('cat_id', true))));
            $name = trim(preg_replace('!\s+!', ' ',html_escape($this->input->post('name', true))));
            $address = trim(preg_replace('!\s+!', ' ',html_escape($this->input->post('address', true))));
            $phone_no = trim(preg_replace('!\s+!', ' ',html_escape($this->input->post('phone_no', true))));
            $email = trim(preg_replace('!\s+!', ' ',html_escape($this->input->post('email', true))));
            $pan_no = trim(preg_replace('!\s+!', ' ',html_escape($this->input->post('pan_no', true))));
            $gst_no = trim(preg_replace('!\s+!', ' ',html_escape($this->input->post('gst_no', true))));
            $bank_name = trim(preg_replace('!\s+!', ' ',html_escape($this->input->post('bank_name', true))));
            $account_no = trim(preg_replace('!\s+!', ' ',html_escape($this->input->post('account_no', true))));
            $ifsc_code = trim(preg_replace('!\s+!', ' ',html_escape($this->input->post('ifsc_code', true))));
            $branch_name = trim(preg_replace('!\s+!', ' ',html_escape($this->input->post('branch_name', true))));
            $where = array(
                'id != '    =>  $id,     
                'name'      =>  $name,
                'address'      =>  $address,
                'phone_no'      =>  $phone_no,
                'email'      =>  $email,
                'pan_no'      =>  $pan_no,
                'gst_no'      =>  $gst_no,
                'bank_name'      =>  $bank_name,
                'account_no'      =>  $account_no,
                'ifsc_code'      =>  $ifsc_code,
                'branch_name'      =>  $branch_name,
                'status != '=>  -1
            );
            $check = $this->master_db->getRecords('company_detail',$where,'id');
            if( count($check) == 0 ){
                $update_data = array(
                    'id'    =>  $id,
                    'name'          =>  $name,
					'address'      =>  $address,
					'phone_no'      =>  $phone_no,
					'email'      =>  $email,
					'pan_no'      =>  $pan_no,
					'gst_no'      =>  $gst_no,
					'bank_name'      =>  $bank_name,
					'account_no'      =>  $account_no,
					'ifsc_code'      =>  $ifsc_code,
					'branch_name'      =>  $branch_name,
                );
                $this->master_db->updateRecord('company_detail',$update_data,array('id'=>$id));
                echo 1;
            }else{
                echo "Company Name already exists.";
            }
        }else if( !empty($_POST['name']) && !empty($_POST['address']) && !empty($_POST['phone_no']) && !empty($_POST['email']) && !empty($_POST['pan_no']) && !empty($_POST['bank_name']) && !empty($_POST['account_no']) && !empty($_POST['ifsc_code']) && !empty($_POST['branch_name'])  ){
            
            $id = trim(preg_replace('!\s+!', ' ',html_escape($this->input->post('id', true))));
			$name = trim(preg_replace('!\s+!', ' ',html_escape($this->input->post('name', true))));
			$address = trim(preg_replace('!\s+!', ' ',html_escape($this->input->post('address', true))));
            $phone_no = trim(preg_replace('!\s+!', ' ',html_escape($this->input->post('phone_no', true))));
            $email = trim(preg_replace('!\s+!', ' ',html_escape($this->input->post('email', true))));
            $pan_no = trim(preg_replace('!\s+!', ' ',html_escape($this->input->post('pan_no', true))));
            $gst_no = trim(preg_replace('!\s+!', ' ',html_escape($this->input->post('gst_no', true))));
            $bank_name = trim(preg_replace('!\s+!', ' ',html_escape($this->input->post('bank_name', true))));
            $account_no = trim(preg_replace('!\s+!', ' ',html_escape($this->input->post('account_no', true))));
            $ifsc_code = trim(preg_replace('!\s+!', ' ',html_escape($this->input->post('ifsc_code', true))));
            $branch_name = trim(preg_replace('!\s+!', ' ',html_escape($this->input->post('branch_name', true))));
            $where = array(
                'name'      =>  $name,
				'address'      =>  $address,
				'phone_no'      =>  $phone_no,
				'email'      =>  $email,
				'pan_no'      =>  $pan_no,
				'gst_no'      =>  $gst_no,
				'bank_name'      =>  $bank_name,
				'account_no'      =>  $account_no,
				'ifsc_code'      =>  $ifsc_code,
				'branch_name'      =>  $branch_name,
                'status != '=>  -1
            );
            $check = $this->master_db->getRecords('company_detail',$where,'id');
            if( count($check) == 0 ){
                $insert_data = array(
                    'id'    =>  $id,
                   'name'          =>  $name,
					'address'      =>  $address,
					'phone_no'      =>  $phone_no,
					'email'      =>  $email,
					'pan_no'      =>  $pan_no,
					'gst_no'      =>  $gst_no,
					'bank_name'      =>  $bank_name,
					'account_no'      =>  $account_no,
					'ifsc_code'      =>  $ifsc_code,
					'branch_name'      =>  $branch_name,
                    'status'        =>  1,
                );
                $this->master_db->insertRecord('company_detail',$insert_data);
				echo $this->db->last_query();exit;
                echo 1;
            }else{
                echo "Company Name already exists.";
            }
        }
    }

    public function setcompany_nameStatus(){
        $det = $this->data['detail'];
        $id = trim($this->input->post('id'));
        $status = trim($this->input->post('status'));

        $where_data = array(
            'status'=>$status,
        );
        $this->master_db->updateRecord('company_detail',$where_data,array('id'=>$id));
        echo 1;
    }

    public function getcompany_name($id = ''){
        $det = $this->data['detail'];
        if( $id != '' ){
            $where = array(
                'id'        =>  $id,
                'status != '=>  -1
            );
            $check = $this->master_db->getRecords('company_detail',$where,'*');
            if( count($check) == 0 ){
                echo json_encode(array('status'=>'fail'));
            }else{
                echo json_encode(array('status'=>'success','data'=>$check[0]));
            }
        }
    }
/*****end of Company Name******/
/*****Start State****/
        public function state(){
        $this->load->view('masters/state',$this->data);
    }

    public function StateList(){
        $det = $this->data['detail'];
        $data_list = $this->master_db->getstateList($det);
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
            $sub_array[] = $row->name." - ".$row->state_code;
            $sub_array[] = $status;
            $data[] = $sub_array;
            
        }
        $_POST["length"] = -1;
        $members = $this->master_db->getstateList($det);
        
        $total = count($members);
        $output = array(
            "draw"              =>  intval($_POST["draw"]),
            "recordsTotal"      =>  $total,
            "recordsFiltered"   =>  $total,//$this->master_db->get_filtered_data("guards")
            "data"              =>  $data
        );
        echo json_encode($output);
    }

    public function savestate(){
        $det = $this->data['detail'];
        if( !empty($_POST['name']) ){
            $id = trim(preg_replace('!\s+!', ' ',html_escape($this->input->post('cat_id', true))));
            $name = trim(preg_replace('!\s+!', ' ',html_escape($this->input->post('name', true))));
            $where = array(
                'id != '    =>  $id,        
                'name'      =>  $name,
                'status != '=>  -1
            );
            $check = $this->master_db->getRecords('states',$where,'id');
			//echo $this->db->last_query();exit;
            if( count($check) == 0 ){
                $update_data = array(
                    'name'          =>  $name,
                    'updated_at'    =>  date('Y-m-d H:i:s'),
                    'updated_by'    =>  $det[0]->id
                );
                $this->master_db->updateRecord('states',$update_data,array('id'=>$id));
				echo $this->db->last_query();
                echo 1;
            }else{
                echo "Company Name already exists.";
            }
        }else if( !empty($_POST['name']) ){
            $name = trim(preg_replace('!\s+!', ' ',html_escape($this->input->post('name', true))));
            $where = array(
                'name'      =>  $name,
                'status != '=>  -1
            );
            $check = $this->master_db->getRecords('states',$where,'id');
            if( count($check) == 0 ){
                $insert_data = array(
                    'name'          =>  $name,
                    'created_at'    =>  date('Y-m-d H:i:s'),
                    'created_by'    =>  $det[0]->id,
                    'status'        =>  1,
                );
                $id = $this->master_db->insertRecord('states',$insert_data);
				//echo $this->db->last_query();
                echo 1;
            }else{
                echo "Company Name already exists.";
            }
        }
    }

    public function setstateStatus(){
        $det = $this->data['detail'];
        $id = trim($this->input->post('id'));
        $status = trim($this->input->post('status'));

        $where_data = array(
            'status'=>$status,
            'updated_at'=>date('Y-m-d H:i:s'),
            'updated_by'=>$det[0]->id
        );
        $this->master_db->updateRecord('states',$where_data,array('id'=>$id));
        echo 1;
    }

    public function getstate($id = ''){
        $det = $this->data['detail'];
        if( $id != '' ){
            $where = array(
                'id'        =>  $id,
                'status != '=>  -1
            );
            $check = $this->master_db->getRecords('states',$where,'id,name');
            if( count($check) == 0 ){
                echo json_encode(array('status'=>'fail'));
            }else{
                echo json_encode(array('status'=>'success','data'=>$check[0]));
            }
        }
    }
	/****** end of state*******/
	/***** ditrict****/
	  public function district(){
        $this->load->view('masters/district',$this->data);
    }

    public function districtList(){
        $det = $this->data['detail'];
        $data_list = $this->master_db->getdistrictList($det);
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
            $sub_array[] = $row->state_name;
            $sub_array[] = $row->district_name;
            $sub_array[] = $status;
            $data[] = $sub_array;
            
        }
        $_POST["length"] = -1;
        $members = $this->master_db->getdistrictList($det);
        
        $total = count($members);
        $output = array(
            "draw"              =>  intval($_POST["draw"]),
            "recordsTotal"      =>  $total,
            "recordsFiltered"   =>  $total,//$this->master_db->get_filtered_data("guards")
            "data"              =>  $data
        );
        echo json_encode($output);
    }

    public function savedistrict(){
        $det = $this->data['detail'];
       // echo "<pre>";print_r($_POST);exit;
        if($_POST['cat_id'] !='0' ){
            $id = trim(preg_replace('!\s+!', ' ',html_escape($this->input->post('cat_id', true))));
            $state_id = trim(preg_replace('!\s+!', ' ',html_escape($this->input->post('state_id', true))));
            $name = trim(preg_replace('!\s+!', ' ',html_escape($this->input->post('name', true))));
            $where = array(
                'id != '    =>  $id,        
                'name'      =>  $name,
                'state_id'      =>  $state_id,
                'status != '=>  -1
            );
            $check = $this->master_db->getRecords('districts',$where,'id');
            if( count($check) == 0 ){
                $update_data = array(
                    'name'          =>  $name,
                    'state_id'          =>  $state_id,
                );
                $this->master_db->updateRecord('districts',$update_data,array('id'=>$id));
                echo 1;
            }else{
                echo "Districts Name already exists.";
            }
        }else if( !empty($_POST['name'])  && !empty($_POST['state_id'])){
            $name = trim(preg_replace('!\s+!', ' ',html_escape($this->input->post('name', true))));
            $state_id = trim(preg_replace('!\s+!', ' ',html_escape($this->input->post('state_id', true))));
            $where = array(
                'name'      =>  $name,
                'state_id'      =>  $state_id,
                'status != '=>  -1
            );
            $check = $this->master_db->getRecords('districts',$where,'id');
            if( count($check) == 0 ){
                $insert_data = array(
                    'name'          =>  $name,
                    'state_id'          =>  $state_id,
                    'status'        =>  1,
                );
                $id = $this->master_db->insertRecord('districts',$insert_data);
                echo 1;
            }else{
                echo "Districts Name already exists.";
            }
        }
    }

    public function setdistrictStatus(){
        $det = $this->data['detail'];
        $id = trim($this->input->post('id'));
        $status = trim($this->input->post('status'));

        $where_data = array(
            'status'=>$status,
            'updated_at'=>date('Y-m-d H:i:s'),
            'updated_by'=>$det[0]->id
        );
        $this->master_db->updateRecord('districts',$where_data,array('id'=>$id));
        echo 1;
    }

    public function getdistrict($id = ''){
        $det = $this->data['detail'];
        if( $id != '' ){
            $where = array(
                'id'        =>  $id,
                'status != '=>  -1
            );
            $check = $this->master_db->getRecords('districts',$where,'*');
            if( count($check) == 0 ){
                echo json_encode(array('status'=>'fail'));
            }else{
                echo json_encode(array('status'=>'success','data'=>$check[0]));
            }
        }
    }
	/**********end of district****************/
	/****************Taluk********************/
		  public function taluk(){
        $this->load->view('masters/taluk',$this->data);
    }
	
		public function get_district()
    {
        $det = $this->data['detail'];
		$state_id = $this->input->post('state_id');
		$where = array(
                'state_id'      =>  $state_id,
		);
		$check = $this->master_db->getRecords('districts',$where,'');
        $val="";
        $val.='<option value="">--Select District--</option>';
        foreach($check as $s)
        {
            $val.= '<option value="'.$s->id.'" >'.$s->name.'</option>';
        }
        echo $val;
    }

    public function talukList(){
        $det = $this->data['detail'];
        $data_list = $this->master_db->gettalukList($det);
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
			$sub_array[] = $row->state_name;
            $sub_array[] = $row->district_name;
			$sub_array[] = $row->city_name;
            $sub_array[] = $status;
            $data[] = $sub_array;
            
        }
        $_POST["length"] = -1;
        $members = $this->master_db->gettalukList($det);
        
        $total = count($members);
        $output = array(
            "draw"              =>  intval($_POST["draw"]),
            "recordsTotal"      =>  $total,
            "recordsFiltered"   =>  $total,//$this->master_db->get_filtered_data("guards")
            "data"              =>  $data
        );
        echo json_encode($output);
    }

    public function saveTalukname(){
        $det = $this->data['detail'];
        //echo "<pre>";print_r($_POST);exit;
        if( $_POST['cat_id'] !='0' ){
            $id = trim(preg_replace('!\s+!', ' ',html_escape($this->input->post('cat_id', true))));
            $name = trim(preg_replace('!\s+!', ' ',html_escape($this->input->post('name', true))));
            $district_id = trim(preg_replace('!\s+!', ' ',html_escape($this->input->post('district_id', true))));
            $where = array(
                'id != '    =>  $id,        
                'name'      =>  $name,
                'district_id'      =>  $district_id,
                'status != '=>  -1
            );
            $check = $this->master_db->getRecords('cities',$where,'id');
            if( count($check) == 0 ){
                $update_data = array(
                    'name'          =>  $name,
					'district_id'      =>  $district_id,
                    'updated_at'    =>  date('Y-m-d H:i:s'),
                    'updated_by'    =>  $det[0]->id
                );
                $this->master_db->updateRecord('cities',$update_data,array('id'=>$id));
                echo 1;
            }else{
                echo "Taluk Name already exists.";
            }
        }else if( !empty($_POST['name']) ){
            $name = trim(preg_replace('!\s+!', ' ',html_escape($this->input->post('name', true))));
            $district_id = trim(preg_replace('!\s+!', ' ',html_escape($this->input->post('district_id', true))));
            $where = array(
                'name'      =>  $name,
                'status != '=>  -1
            );
            $check = $this->master_db->getRecords('cities',$where,'id');
            if( count($check) == 0 ){
                $insert_data = array(
                    'name'          =>  $name,
					'district_id'      =>  $district_id,
                    'created_at'    =>  date('Y-m-d H:i:s'),
                    'created_by'    =>  $det[0]->id,
                    'status'        =>  1,
                );
                $id = $this->master_db->insertRecord('cities',$insert_data);
                echo 1;
            }else{
                echo "Taluk Name already exists.";
            }
        }
    }

    public function settalukStatus(){
        $det = $this->data['detail'];
        $id = trim($this->input->post('id'));
        $status = trim($this->input->post('status'));

        $where_data = array(
            'status'=>$status,
            'updated_at'=>date('Y-m-d H:i:s'),
            'updated_by'=>$det[0]->id
        );
        $this->master_db->updateRecord('cities',$where_data,array('id'=>$id));
        echo 1;
    }

    public function getTaluk_name($id = ''){
        $det = $this->data['detail'];
        if( $id != '' ){
            $where = array(
                'id'        =>  $id,
                'status != '=>  -1
            );
            $check = $this->master_db->getRecords('cities',$where,'*');
            if( count($check) == 0 ){
                echo json_encode(array('status'=>'fail'));
            }else{
                echo json_encode(array('status'=>'success','data'=>$check[0]));
            }
        }
    }
	/***************end of taluk*****************/
	

}
?>