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
                $action .= "<button title='Deactive' onclick='updateStatus(".$row->id.", 0)' class='btn btn-warning btn-sm'><i class='fas fa-times-circle'></i></button>&nbsp;";
            }else{
                $status = "<span class='text-warning'><i class='fas fa-times-circle'></i> In-Active</span>";
                $action .= "<button title='Activate' onclick='updateStatus(".$row->id.", 1)' class='btn btn-success btn-sm'><i class='fas fa-check'></i></button>&nbsp;";
            }
            $action .= "<button title='Delete' onclick='updateStatus(".$row->id.", -1)' class='btn btn-danger btn-sm'><i class='fas fa-trash'></i></button>&nbsp;";
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
        if( !empty($_POST['name']) ){
            $id = trim(preg_replace('!\s+!', ' ',html_escape($this->input->post('cat_id', true))));
            $name = trim(preg_replace('!\s+!', ' ',html_escape($this->input->post('name', true))));
            $where = array(
                'id != '    =>  $id,        
                'name'      =>  $name,
                'status != '=>  -1
            );
            $check = $this->master_db->getRecords('company_name',$where,'id');
			echo $this->db->last_query();exit;
            if( count($check) == 0 ){
                $update_data = array(
                    'name'          =>  $name,
                    'updated_at'    =>  date('Y-m-d H:i:s'),
                    'updated_by'    =>  $det[0]->id
                );
                $this->master_db->updateRecord('company_name',$update_data,array('id'=>$id));
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
            $check = $this->master_db->getRecords('company_name',$where,'id');
            if( count($check) == 0 ){
                $insert_data = array(
                    'name'          =>  $name,
                    'created_at'    =>  date('Y-m-d H:i:s'),
                    'created_by'    =>  $det[0]->id,
                    'status'        =>  1,
                );
                $id = $this->master_db->insertRecord('company_name',$insert_data);
				echo $this->db->last_query();
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
            'updated_at'=>date('Y-m-d H:i:s'),
            'updated_by'=>$det[0]->id
        );
        $this->master_db->updateRecord('company_name',$where_data,array('id'=>$id));
        echo 1;
    }

    public function getcompany_name($id = ''){
        $det = $this->data['detail'];
        if( $id != '' ){
            $where = array(
                'id'        =>  $id,
                'status != '=>  -1
            );
            $check = $this->master_db->getRecords('company_name',$where,'id,name');
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
            $sub_array[] = $row->name;
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
        if( !empty($_POST['name']) ){
            $id = trim(preg_replace('!\s+!', ' ',html_escape($this->input->post('cat_id', true))));
            $name = trim(preg_replace('!\s+!', ' ',html_escape($this->input->post('name', true))));
            $where = array(
                'id != '    =>  $id,        
                'name'      =>  $name,
                'status != '=>  -1
            );
            $check = $this->master_db->getRecords('district',$where,'id');
			echo $this->db->last_query();exit;
            if( count($check) == 0 ){
                $update_data = array(
                    'name'          =>  $name,
                    'updated_at'    =>  date('Y-m-d H:i:s'),
                    'updated_by'    =>  $det[0]->id
                );
                $this->master_db->updateRecord('district',$update_data,array('id'=>$id));
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
            $check = $this->master_db->getRecords('district',$where,'id');
            if( count($check) == 0 ){
                $insert_data = array(
                    'name'          =>  $name,
                    'created_at'    =>  date('Y-m-d H:i:s'),
                    'created_by'    =>  $det[0]->id,
                    'status'        =>  1,
                );
                $id = $this->master_db->insertRecord('district',$insert_data);
				echo $this->db->last_query();
                echo 1;
            }else{
                echo "Company Name already exists.";
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
        $this->master_db->updateRecord('district',$where_data,array('id'=>$id));
        echo 1;
    }

    public function getdistrict($id = ''){
        $det = $this->data['detail'];
        if( $id != '' ){
            $where = array(
                'id'        =>  $id,
                'status != '=>  -1
            );
            $check = $this->master_db->getRecords('district',$where,'id,name');
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

    public function savetaluk(){
        $det = $this->data['detail'];
        if( !empty($_POST['name']) ){
            $id = trim(preg_replace('!\s+!', ' ',html_escape($this->input->post('cat_id', true))));
            $name = trim(preg_replace('!\s+!', ' ',html_escape($this->input->post('name', true))));
            $where = array(
                'id != '    =>  $id,        
                'name'      =>  $name,
                'status != '=>  -1
            );
            $check = $this->master_db->getRecords('taluk',$where,'id');
			echo $this->db->last_query();exit;
            if( count($check) == 0 ){
                $update_data = array(
                    'name'          =>  $name,
                    'updated_at'    =>  date('Y-m-d H:i:s'),
                    'updated_by'    =>  $det[0]->id
                );
                $this->master_db->updateRecord('taluk',$update_data,array('id'=>$id));
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
            $check = $this->master_db->getRecords('taluk',$where,'id');
            if( count($check) == 0 ){
                $insert_data = array(
                    'name'          =>  $name,
                    'created_at'    =>  date('Y-m-d H:i:s'),
                    'created_by'    =>  $det[0]->id,
                    'status'        =>  1,
                );
                $id = $this->master_db->insertRecord('taluk',$insert_data);
				echo $this->db->last_query();
                echo 1;
            }else{
                echo "Company Name already exists.";
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
        $this->master_db->updateRecord('taluk',$where_data,array('id'=>$id));
        echo 1;
    }

    public function gettaluk($id = ''){
        $det = $this->data['detail'];
        if( $id != '' ){
            $where = array(
                'id'        =>  $id,
                'status != '=>  -1
            );
            $check = $this->master_db->getRecords('taluk',$where,'id,name');
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