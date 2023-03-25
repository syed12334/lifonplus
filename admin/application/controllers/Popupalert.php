<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
//error_reporting(E_ALL);ini_set('display_errors', '1');
class Popupalert extends CI_Controller {   

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
        $this->healthtips();
    }
	
	
	public function category(){
        $this->load->view('healthtips/category_view',$this->data);
    }

    public function categoryList(){
        $det = $this->data['detail'];
        $data_list = $this->web_db->getHealthCategoryList($det);
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
        $members = $this->web_db->getHealthCategoryList($det);
        
        $total = count($members);
        $output = array(
            "draw"              =>  intval($_POST["draw"]),
            "recordsTotal"      =>  $total,
            "recordsFiltered"   =>  $total,//$this->master_db->get_filtered_data("guards")
            "data"              =>  $data
        );
        echo json_encode($output);
    }

    public function saveCategory(){
        $det = $this->data['detail'];
        if( !empty($_POST['name']) && !empty($_POST['id']) ){
            $id = trim(preg_replace('!\s+!', ' ',html_escape($this->input->post('id', true))));
            $name = trim(preg_replace('!\s+!', ' ',html_escape($this->input->post('name', true))));
            
            $where = array(
                'id != '    =>  $id,        
                'name'      =>  $name,
                'status != '=>  -1
            );
            $check = $this->master_db->getRecords('health_category',$where,'id');
            if( count($check) == 0 ){
                $update_data = array(
                    'name'          =>  $name,
                    'updated_at'    =>  date('Y-m-d H:i:s'),
                    'updated_by'    =>  $det[0]->id
                );
                $this->master_db->updateRecord('health_category',$update_data,array('id'=>$id));
                echo 1;
            }else{
                echo "Category already exists.";
            }
        }else if( !empty($_POST['name'])){
            $name = trim(preg_replace('!\s+!', ' ',html_escape($this->input->post('name', true))));
           
            $where = array(
                'name'      =>  $name,
                'status != '=>  -1
            );
            $check = $this->master_db->getRecords('health_category',$where,'id');
            if( count($check) == 0 ){
                $insert_data = array(
                    'name'          =>  $name,
                    'created_at'    =>  date('Y-m-d H:i:s'),
                    'created_by'    =>  $det[0]->id,
                    'status'        =>  1,
                );
                $id = $this->master_db->insertRecord('health_category',$insert_data);
                echo 1;
            }else{
                echo "Category already exists.";
            }
        }
    }

    public function setCategoryStatus(){
        $det = $this->data['detail'];
        $id = trim($this->input->post('id'));
        $status = trim($this->input->post('status'));

        $where_data = array(
            'status'=>$status,
            'updated_at'=>date('Y-m-d H:i:s'),
            'updated_by'=>$det[0]->id
        );
        $this->master_db->updateRecord('health_category',$where_data,array('id'=>$id));
        echo 1;
    }

    public function getCategory($id = ''){
        $det = $this->data['detail'];
        if( $id != '' ){
            $where = array(
                'id'        =>  $id,
                'status != '=>  -1
            );
            $check = $this->master_db->getRecords('health_category',$where,'id,name');
            if( count($check) == 0 ){
                echo json_encode(array('status'=>'fail'));
            }else{
                echo json_encode(array('status'=>'success','data'=>$check[0]));
            }
        }
    }
	
	public function healthtips(){
        $this->load->view('popups/popup_view',$this->data);
    }
	
	


    public function popupalertList(){
        $det = $this->data['detail'];
        $data_list = $this->web_db->getPopupList($det);
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
			
			$image="<img src='".app_asset_url().$row->image_path."' width='100px' height='100px'>";
            $sub_array[] = $action;
            $sub_array[] = $row->title;
			$sub_array[] = $image;
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
	
	
	public function add_popups(){
		$this->data['type'] = 1;
        // echo "<pre>";print_r( $this->data['detail']);exit;
        $this->data['customer'] =  $this->master_db->getRecords('customers',array('status ='=>'1'),'id,name');
                $this->data['package'] =  $this->master_db->getRecords('packages',array('status !='=>'-1'),'id,name');

        $this->load->view('popups/popup_add',$this->data);
    }
	
	
	public function edit_popups(){
		$this->data['type'] = 2;
		$id = trim($this->input->get('id'));
		$this->data['details'] =  $this->master_db->getRecords('popupalerts',array('status !='=>'-1','id'=>$id),'id,title,descr,image_path');
		$this->data['customer'] =  $this->master_db->getRecords('customers',array('status ='=>'1'),'id,name');
        $this->data['package'] =  $this->master_db->getRecords('packages',array('status !='=>'-1'),'id,name');
        $this->load->view('popups/popup_add',$this->data);
    }
	
	
	
    public function savePopupalerts(){
        $det = $this->data['detail'];
        $id = trim(preg_replace('!\s+!', ' ',html_escape($this->input->post('id', true))));
        $title = trim(preg_replace('!\s+!', ' ',html_escape($this->input->post('title', true))));
        $package = trim(preg_replace('!\s+!', ' ',html_escape($this->input->post('package', true))));
        $descr = $this->input->post('descr');
        
        $user_id = $this->input->post('user_id');
        if( !empty($_POST['title']) && !empty($_POST['descr']) && !empty($_POST['id'])){
            $pid = "";
            if(!empty($package)) {
                $pack = $this->master_db->sqlExecute('select c.id from customers c left join customer_package cp on cp.customer_id = c.id where cp.package_id ='.$package.'');

            }
            
            $where = array(
                'id != '        =>  $id, 
                'title'         =>  $title,
                'status != '    =>  -1
            );
            $check = $this->master_db->getRecords('popupalerts',$where,'id');
            if( count($check) == 0 ){
                $update_data = array(
                    'title'       =>  $title,
                    'descr'       =>  $descr,
                    'updated_at'  =>  date('Y-m-d H:i:s'),
                    'updated_by'  =>  $det[0]->id,
                    'pid'=>$package
                );
                //echo '<pre>';print_r($_FILES['image_path']['name']);exit;
                if( !empty($_FILES['image_path']['name']) ){
                    $config = array();
                    $config['upload_path'] = '../app_assets/popupalerts/';  
                    $config['allowed_types'] = 'pdf|jpeg|jpg|png';
                    $config['max_size'] = 0;    
                    // I have chosen max size no limit 
                    //$new_name = $code.'_'. $_FILES["document"]['name']; 
                    $ext = pathinfo($_FILES["image_path"]['name'], PATHINFO_EXTENSION);
                    $new_name = 'popupalerts'.'.'.$ext; 

                    $config['file_name'] = $new_name;
                    //Stored the new name into $config['file_name']
                    $this->load->library('upload', $config);
                    if (!$this->upload->do_upload('image_path') && !empty($_FILES['image_path']['name'])) {
                        $error = array('error' => $this->upload->display_errors());
                        //echo '<pre>';print_r($error);exit;
                    } else {
                        $upload_data = $this->upload->data();
                        //echo '<pre>';print_r($upload_data);exit;
                        $update_data['image_path'] = 'popupalerts/'.$upload_data['file_name'];
                    }
                }


                // $imgfile = "https://www.lifeonplus.com/app_assets/health_tips/healthtips.jpeg";
               // echo "<pre>";print_r($imgfile[0]);exit;
                
                $this->master_db->updateRecord('popupalerts',$update_data,array('id'=>$id));

                 if(count($user_id) || !empty($package))
                 {
                    $this->master_db->updateRecord('popup_notify',array('status'=>'-1'),array('popup_id'=>$id));
                    foreach($user_id as $u)
                    {
                        $check = $this->master_db->getRecords('popup_notify',array('popup_id'=>$id,'user_id'=>$u),'id');
                        
                        $insert_user = array('popup_id'=>$id,'user_id'=>$u,'status'=>1);
                        if(count($check) == 0)
                        {
                           $this->master_db->insertRecord('popup_notify',$insert_user);
                        }
                        else{
                            $this->master_db->updateRecord('popup_notify',array('status'=>1),array('popup_id'=>$id,'user_id'=>$u));
                        }
                    }
                 }
                $this->session->set_flashdata('message','<div class="alert alert-success alert-dismissable"><button class="close" aria-hidden="true" data-dismiss="alert" type="button">&times;</button> Updated Successfully!</div>');
                redirect(base_url().'popupalert');
            }else{
                
                $this->session->set_flashdata('message','<div class="alert alert-danger alert-dismissable"><button class="close" aria-hidden="true" data-dismiss="alert" type="button">&times;</button> Popupalert already exists.</div>');
                redirect(base_url().'popupalert');
            }
        }
        else if(!empty($_POST['title']) && !empty($_POST['descr'])){
           
            $where = array(
                'title'   =>  $title,
                'status != '=>  -1
            );
            $check = $this->master_db->getRecords('popupalerts',$where,'id');
            

            if( count($check) == 0 ){
                $insert_data = array(
                    'title'        =>  $title,
                    'descr'        =>  $descr,
                
                    'created_at'   =>  date('Y-m-d H:i:s'),
                    'created_by'   =>  $det[0]->id,
                    'status'       =>  1,
                    'pid'=>$package
                );
                //echo '<pre>';print_r($_FILES['image_path']['name']);exit;
                if( !empty($_FILES['image_path']['name']) ){
                $config = array();
                $config['upload_path'] = '../app_assets/popupalerts/';  
                $config['allowed_types'] = 'pdf|jpeg|jpg|png';
                $config['max_size'] = 0;    
                // I have chosen max size no limit 
                //$new_name = $code.'_'. $_FILES["document"]['name']; 
                $ext = pathinfo($_FILES["image_path"]['name'], PATHINFO_EXTENSION);
                $new_name = 'popupalerts'.'.'.$ext; 

                $config['file_name'] = $new_name;
                //Stored the new name into $config['file_name']
                $this->load->library('upload', $config);
                if (!$this->upload->do_upload('image_path') && !empty($_FILES['image_path']['name'])) {
                    $error = array('error' => $this->upload->display_errors());
                    //echo '<pre>';print_r($error);exit;
                } else {
                    $upload_data = $this->upload->data();
                    //echo '<pre>';print_r($upload_data);exit;
                    $insert_data['image_path'] = 'popupalerts/'.$upload_data['file_name'];
                }
            }
                // echo "<pre>";print_r($imgfile[0]);exit;
               $id = $this->master_db->insertRecord('popupalerts',$insert_data);
                  if(!empty($package)) {
                $pack = $this->master_db->sqlExecute('select c.id from customers c left join customer_package cp on cp.customer_id = c.id where cp.package_id ='.$package.' order by c.id desc limit 1');
                $pid = $pack[0]->id;

                $insert_user = array('popup_id'=>$id,'user_id'=>$pid,'status'=>1,'pid'=>$package);
                        $this->master_db->insertRecord('popup_notify',$insert_user);
                //echo $this->db->last_query();exit;
            }

                if(count($user_id) || !empty($package))
                {
                    foreach($user_id as $u)
                    {
                        $insert_user = array('popup_id'=>$id,'user_id'=>$u,'status'=>1);
                        $this->master_db->insertRecord('popup_notify',$insert_user);
                    }
               $this->session->set_flashdata('message','<div class="alert alert-success alert-dismissable"><button class="close" aria-hidden="true" data-dismiss="alert" type="button">&times;</button> Added Successfully!</div>');
               redirect(base_url().'popupalert');
            }else{
                 $this->session->set_flashdata('message','<div class="alert alert-danger alert-dismissable"><button class="close" aria-hidden="true" data-dismiss="alert" type="button">&times;</button>Popupalert already exists.</div>');
                redirect(base_url().'popupalert');
        
            }
        }
    }
}

    public function setPopupalertStatus(){
        $det = $this->data['detail'];
        $id = trim($this->input->post('id'));
        $status = trim($this->input->post('status'));

        $where_data = array(
            'status'=>$status,
            'updated_at'=>date('Y-m-d H:i:s'),
            'updated_by'=>$det[0]->id
        );
        $this->master_db->updateRecord('popupalerts',$where_data,array('id'=>$id));
        echo 1;
    }
	
	
	function getUsers(){
        
		$state_id = trim($this->input->post('state_id'));
        $district_id = trim($this->input->post('district_id'));
		$taluk_id = trim($this->input->post('taluk_id'));
		
		
        $list = $this->web_db->getCustomers($state_id,$district_id,$taluk_id);
        $result = array('status'=>'success','data'=>$list);
        echo json_encode($result);
    }
	
	public function urls() {
        echo app_asset_url();
    }
	
}
?>