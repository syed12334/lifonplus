<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
error_reporting(E_ALL);ini_set('display_errors', '1');
class Master extends CI_Controller {   

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

    public function index(){
        $this->category();
    }

    public function category(){
        $this->load->view('masters/category',$this->data);
    }

    public function categoryList(){
        $det = $this->data['detail'];
        $data_list = $this->master_db->getCategoryList($det);
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
            $sub_array[] = $row->type;
            $sub_array[] = $status;
            $data[] = $sub_array;
            
        }
        $_POST["length"] = -1;
        $members = $this->master_db->getCategoryList($det);
        
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
        if( !empty($_POST['name']) && !empty($_POST['cat_id']) && !empty($_POST['type']) ){
            $id = trim(preg_replace('!\s+!', ' ',html_escape($this->input->post('cat_id', true))));
            $name = trim(preg_replace('!\s+!', ' ',html_escape($this->input->post('name', true))));
            $type = trim(preg_replace('!\s+!', ' ',html_escape($this->input->post('type', true))));
            $where = array(
                'id != '    =>  $id,        
                'name'      =>  $name,
                'type'      =>  $type,
                'status != '=>  -1
            );
            $check = $this->master_db->getRecords('category',$where,'id');
            if( count($check) == 0 ){
                $update_data = array(
                    'name'          =>  $name,
                    'type'          =>  $type,
                    'updated_at'    =>  date('Y-m-d H:i:s'),
                    'updated_by'    =>  $det[0]->id
                );
                $this->master_db->updateRecord('category',$update_data,array('id'=>$id));
                echo 1;
            }else{
                echo "Category already exists.";
            }
        }else if( !empty($_POST['name']) && !empty($_POST['type']) ){
            $name = trim(preg_replace('!\s+!', ' ',html_escape($this->input->post('name', true))));
            $type = trim(preg_replace('!\s+!', ' ',html_escape($this->input->post('type', true))));
            $where = array(
                'name'      =>  $name,
                'type'      =>  $type,
                'status != '=>  -1
            );
            $check = $this->master_db->getRecords('category',$where,'id');
            if( count($check) == 0 ){
                $insert_data = array(
                    'name'          =>  $name,
                    'type'          =>  $type,
                    'created_at'    =>  date('Y-m-d H:i:s'),
                    'created_by'    =>  $det[0]->id,
                    'status'        =>  1,
                );
                $id = $this->master_db->insertRecord('category',$insert_data);
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
        $this->master_db->updateRecord('category',$where_data,array('id'=>$id));
        echo 1;
    }

    public function getCategory($id = ''){
        $det = $this->data['detail'];
        if( $id != '' ){
            $where = array(
                'id'        =>  $id,
                'status != '=>  -1
            );
            $check = $this->master_db->getRecords('category',$where,'id,name,type');
            if( count($check) == 0 ){
                echo json_encode(array('status'=>'fail'));
            }else{
                echo json_encode(array('status'=>'success','data'=>$check[0]));
            }
        }
    }

    public function subcategory(){
        $this->data['category'] = $this->master_db->getRecords('category',array('status!='=>-1,'is_package'=>0),'id,name');
        $this->load->view('masters/subcategory',$this->data);
    }

    public function subCategoryList(){
        $det = $this->data['detail'];
        $data_list = $this->master_db->getSubCategoryList($det);
        
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
            $sub_array[] = $row->category;
            $sub_array[] = $row->name;
            $sub_array[] = $status;
            $data[] = $sub_array;
            
        }
        $_POST["length"] = -1;
        $members = $this->master_db->getSubCategoryList($det);
        
        $total = count($members);
        $output = array(
            "draw"              =>  intval($_POST["draw"]),
            "recordsTotal"      =>  $total,
            "recordsFiltered"   =>  $total,//$this->master_db->get_filtered_data("guards")
            "data"              =>  $data
        );
        echo json_encode($output);
    }

    public function saveSubCategory(){
        $det = $this->data['detail'];
        if( !empty($_POST['name']) && !empty($_POST['cat_id']) && !empty($_POST['scat_id']) ){
            $cat_id = trim(preg_replace('!\s+!', ' ',html_escape($this->input->post('cat_id', true))));
            $id = trim(preg_replace('!\s+!', ' ',html_escape($this->input->post('scat_id', true))));
            $name = trim(preg_replace('!\s+!', ' ',html_escape($this->input->post('name', true))));
            $where = array(
                'id != '    =>  $id,   
                'cat_id'    =>  $cat_id,     
                'name'      =>  $name,
                'status != '=>  -1
            );
            $check = $this->master_db->getRecords('subcategory',$where,'id');
			//echo $this->db->last_query();exit;
            if( count($check) == 0 ){
                $page_url = $this->home_db->strtourl($name);
                $update_data = array(
                    'cat_id'        =>  $cat_id,
                    'name'          =>  $name,
                    'updated_at'    =>  date('Y-m-d H:i:s'),
                    'updated_by'    =>  $det[0]->id
                );
                $this->master_db->updateRecord('subcategory',$update_data,array('id'=>$id));
                echo 1;
            }else{
                echo "Sub-Category already exists.";
            }
        }else if( !empty($_POST['name']) && !empty($_POST['cat_id']) ){
            $name = trim(preg_replace('!\s+!', ' ',html_escape($this->input->post('name', true))));
            $cat_id = trim(preg_replace('!\s+!', ' ',html_escape($this->input->post('cat_id', true))));
            $where = array(
                'name'      =>  $name,
                'cat_id'    =>  $cat_id,
                'status != '=>  -1
            );
            $check = $this->master_db->getRecords('subcategory',$where,'id');
            if( count($check) == 0 ){
                $page_url = $this->home_db->strtourl($name);
                $insert_data = array(
                    'cat_id'        =>  $cat_id,
                    'name'          =>  $name,
                    'created_at'    =>  date('Y-m-d H:i:s'),
                    'created_by'    =>  $det[0]->id,
                    'status'        =>  1,
                );
                $this->master_db->insertRecord('subcategory',$insert_data);
                echo 1;
            }else{
                echo "Sub-Category already exists.";
            }
        }
    }
    
    public function setSubCategoryStatus(){

        $det = $this->data['detail'];
        $id = trim($this->input->post('id'));
        $status = trim($this->input->post('status'));

        $where_data = array(
            'status'=>$status,
            'updated_at'=>date('Y-m-d H:i:s'),
            'updated_by'=>$det[0]->id
        );
        $this->master_db->updateRecord('subcategory',$where_data,array('id'=>$id));
        echo 1;
    }

    public function getSubCategory($id = '',$cat_id = ''){
        $det = $this->data['detail'];
        if( $id != '' || $cat_id != '' ){
            $where = array(
                'status != '=>  -1
            );

            if( $id != '' && intval($id) != 0 ){
                $where['id'] = $id;
            }

            if( $cat_id != '' ){
                $where['cat_id'] = $cat_id;
            }
            $check = $this->master_db->getRecords('subcategory',$where,'id,cat_id,name');
            //echo $this->db->last_query();print_r($check);exit;
            if( count($check) == 0 ){
                echo json_encode(array('status'=>'fail'));
            }else{
                echo json_encode(array('status'=>'success','data'=>$check[0]));
            }
        }
    }

    public function getSubCategoryList(){
        $det = $this->data['detail'];
        if( !empty($_POST['category']) ){
            $where = array(
                'cat_id'        =>  $_POST['category'],
                'status != '    =>  -1
            );
            $check = $this->master_db->getRecords('subcategory',$where,'id,cat_id,name');
            echo json_encode(array('status'=>'success','data'=>$check));
        }
    }

    public function services(){
        $this->data['category'] = $this->master_db->getRecords('category',array('status!='=>-1,'is_package'=>0),'id,name');
        $this->load->view('masters/services',$this->data);
    }

    public function serviceList(){
        $det = $this->data['detail'];
        $data_list = $this->master_db->getServiceList($det);
        //echo '<pre>';print_r($data_list);exit;
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
            $sub_array[] = $row->category;
            $sub_array[] = $row->subcategory;
            $sub_array[] = $row->name;
            $sub_array[] = $row->price;
            $sub_array[] = $status;
            $data[] = $sub_array;
            
        }
        $_POST["length"] = -1;
        $members = $this->master_db->getServiceList($det);
        
        $total = count($members);
        $output = array(
            "draw"              =>  intval($_POST["draw"]),
            "recordsTotal"      =>  $total,
            "recordsFiltered"   =>  $total,//$this->master_db->get_filtered_data("guards")
            "data"              =>  $data
        );
        echo json_encode($output);
    }

    public function saveService(){
        $det = $this->data['detail'];
        
        if( !empty($_POST['cat_id']) && !empty($_POST['subcat_id']) && !empty($_POST['name']) 
            && !empty($_POST['price']) && !empty($_POST['descr']) && !empty($_POST['id'])){
            
            //echo '<pre>';print_r($_POST);exit;
            $id = trim(preg_replace('!\s+!', ' ',html_escape($this->input->post('id', true))));
            $cat_id = trim(preg_replace('!\s+!', ' ',html_escape($this->input->post('cat_id', true))));
            $subcat_id = trim(preg_replace('!\s+!', ' ',html_escape($this->input->post('subcat_id', true))));
            $name = trim(preg_replace('!\s+!', ' ',html_escape($this->input->post('name', true))));
            $price = trim(preg_replace('!\s+!', ' ',html_escape($this->input->post('price', true))));
            $descr = trim(preg_replace('!\s+!', ' ',html_escape($this->input->post('descr', true))));
            $where = array(
                'id != '    =>  $id,     
                'cat_id'    =>  $cat_id,
                'subcat_id' =>  $subcat_id,   
                'name'      =>  $name,
                'status != '=>  -1
            );
            $check = $this->master_db->getRecords('services',$where,'id');
            if( count($check) == 0 ){
                $update_data = array(
                    'cat_id'    =>  $cat_id,
                    'subcat_id' =>  $subcat_id, 
                    'name'      =>  $name,
                    'descr'     =>  $descr,
                    'price'     =>  $price,
                    'updated_at' =>  date('Y-m-d H:i:s'),
                    'updated_by'   =>  $det[0]->id
                );
                $this->master_db->updateRecord('services',$update_data,array('id'=>$id));
                echo 1;
            }else{
                echo "Service already exists.";
            }
        }else if( !empty($_POST['cat_id']) && !empty($_POST['subcat_id']) && !empty($_POST['name']) 
            && !empty($_POST['price']) && !empty($_POST['descr']) ){
            
            $cat_id = trim(preg_replace('!\s+!', ' ',html_escape($this->input->post('cat_id', true))));
            $subcat_id = trim(preg_replace('!\s+!', ' ',html_escape($this->input->post('subcat_id', true))));
            $name = trim(preg_replace('!\s+!', ' ',html_escape($this->input->post('name', true))));
            $price = trim(preg_replace('!\s+!', ' ',html_escape($this->input->post('price', true))));
            $descr = trim(preg_replace('!\s+!', ' ',html_escape($this->input->post('descr', true))));
            $where = array(
                'name'      =>  $name,
                'cat_id'    =>  $cat_id,
                'subcat_id' =>  $subcat_id,
                'status != '=>  -1
            );
            $check = $this->master_db->getRecords('services',$where,'id');
            if( count($check) == 0 ){
                $insert_data = array(
                    'cat_id'    =>  $cat_id,
                    'subcat_id' =>  $subcat_id,
                    'name'      =>  $name,
                    'descr'     =>  $descr,
                    'price'     =>  $price,
                    'created_at'  =>  date('Y-m-d H:i:s'),
                    'created_by'       =>  $det[0]->id,
                    'status'        =>  1,
                );
                $this->master_db->insertRecord('services',$insert_data);
                echo 1;
            }else{
                echo "Service already exists.";
            }
        }
    }

    public function getService($id = ''){
        $det = $this->data['detail'];
        if( $id != '' ){
            $where = array(
                'id'        =>  $id,
                'status != '=>  -1
            );
            $check = $this->master_db->getRecords('services',$where,'id,cat_id,subcat_id,name,descr,price');
            if( count($check) == 0 ){
                echo json_encode(array('status'=>'fail'));
            }else{
                $subcat = $this->master_db->getRecords('subcategory',array('cat_id'=>$check[0]->cat_id,'status !='=>-1),'id,name'); 
                echo json_encode(array('status'=>'success','data'=>$check[0],'subcat'=>$subcat));
            }
        }
    }

    public function setServiceStatus(){
        $det = $this->data['detail'];
        $id = trim($this->input->post('id'));
        $status = trim($this->input->post('status'));
        $where_data = array(
            'status'=>$status,
            'updated_at'=>date('Y-m-d H:i:s'),
            'updated_by'=>$det[0]->id
        );
        $this->master_db->updateRecord('services',$where_data,array('id'=>$id));
        echo 1;
    }
    
    public function packages(){
        $this->data['category'] = $this->master_db->getRecords('category',array('status!='=>-1,'is_package'=>0),'id,name');
        $this->load->view('masters/packages',$this->data);
    }

    public function addpackage(){
        $this->data['category'] = $this->master_db->getRecords('category',array('status!='=>-1,'is_package'=>1),'id,name');
        $this->data['pcategory'] = $this->master_db->getRecords('category',array('status!='=>-1,'is_package'=>0),'id,name');
        $this->load->view('masters/addpackage',$this->data);
    }

    public function getServiceList(){
        $det = $this->data['detail'];
        if( !empty($_POST['category']) && !empty($_POST['subcat']) ){

            $category = trim(preg_replace('!\s+!', ' ',html_escape($this->input->post('category', true))));
            $subcat = trim(preg_replace('!\s+!', ' ',html_escape($this->input->post('subcat', true))));
            $where = array(
                'cat_id'        =>  $category,
                'subcat_id'     =>  $subcat,
                'status != '    =>  -1
            );
            $data = $this->master_db->getRecords('services',$where,'id,cat_id,name');
            echo json_encode(array('status'=>'success','data'=>$data));
        }
    }

    public function savePackage(){
        $det = $this->data['detail'];

        if( !empty($_POST['cat_id']) && !empty($_POST['color'])  && !empty($_POST['card_type']) && !empty($_POST['name'])
            && !empty($_POST['validity']) && !empty($_POST['price']) && !empty($_POST['descr']) && count($_POST['services']) ){

            $cat_id = trim(preg_replace('!\s+!', ' ',html_escape($this->input->post('cat_id', true))));
            $color = trim(preg_replace('!\s+!', ' ',html_escape($this->input->post('color', true))));
            $card_type = trim(preg_replace('!\s+!', ' ',html_escape($this->input->post('card_type', true))));
            $name = trim(preg_replace('!\s+!', ' ',html_escape($this->input->post('name', true))));
            $validity = trim(preg_replace('!\s+!', ' ',html_escape($this->input->post('validity', true))));
            $price = trim(preg_replace('!\s+!', ' ',html_escape($this->input->post('price', true))));
            $descr = trim(preg_replace('!\s+!', ' ',html_escape($this->input->post('descr', true))));
            $services = $this->input->post('services', true);

            $check = $this->master_db->getRecords('packages',array('name'=>$name,'cat_id'=>$cat_id,'status !='=>-1),'id');
            if(count($check)){
                echo -1;exit;
            }else{
                $insert_data = array(
                    'cat_id'    =>  $cat_id,
                    'color'     =>  $color,
                    'card_type' =>  $card_type,
                    'name'      =>  $name,
                    'descr'     =>  $descr,
                    'price'     =>  $price,
                    'validity'  =>  $validity,
                    'status'    =>  1,
                    'created_by'=>  $det[0]->id,
                    'created_at'=>  date('Y-m-d H:i:s')
                );
                $id = $this->master_db->insertRecord('packages',$insert_data);
                if( count($services) ){
                    foreach($services as $item){
                        $insert = array(
                            'package_id'    =>  $id,
                            'service_id'    =>  $item,
                            'status'        =>  1,
                            'created_by'    =>  $det[0]->id,
                            'created_at'    =>  date('Y-m-d H:i:s')
                        );
                        $this->master_db->insertRecord('package_service',$insert);
                    }
                }
                echo 1;exit;
            } 
        }else{
            echo -2;exit;
        }
        //print_r($_POST);
    }

    public function packageList(){
        $det = $this->data['detail'];
        $data_list = $this->master_db->getPackageList($det);
        //echo '<pre>';print_r($data_list);exit;
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

            if( intval($row->card_type) == 1 ){ $row->card_type = 'Instant Digital Card'; }
            else if( intval($row->card_type) == 2 ){ $row->card_type = 'Physical Card'; }
            $sub_array[] = $action;
            $sub_array[] = $row->package;
            $sub_array[] = $row->category;            
            $sub_array[] = $row->card_type;
            $sub_array[] = $row->price;
            $sub_array[] = $row->validity;
            $sub_array[] = $status;
            $data[] = $sub_array;
            
        }
        $_POST["length"] = -1;
        $members = $this->master_db->getPackageList($det);
        
        $total = count($members);
        $output = array(
            "draw"              =>  intval($_POST["draw"]),
            "recordsTotal"      =>  $total,
            "recordsFiltered"   =>  $total,//$this->master_db->get_filtered_data("guards")
            "data"              =>  $data
        );
        echo json_encode($output);
    }

    public function setPackageStatus(){
        $det = $this->data['detail'];
        $id = trim($this->input->post('id'));
        $status = trim($this->input->post('status'));
        $where_data = array(
            'status'=>$status,
            'updated_at'=>date('Y-m-d H:i:s'),
            'updated_by'=>$det[0]->id
        );
        $this->master_db->updateRecord('packages',$where_data,array('id'=>$id));
        echo 1;
    }

    public function editpackage(){
        $det = $this->data['detail'];
        if( !empty($_GET['id']) ){
            $id = trim(preg_replace('!\s+!', ' ',html_escape($this->input->get('id', true))));
            $this->data['package'] = $this->master_db->getPackageDetail($id)[0];
            $this->data['category'] = $this->master_db->getRecords('category',array('status!='=>-1,'is_package'=>1),'id,name');
            $this->data['pcategory'] = $this->master_db->getRecords('category',array('status!='=>-1,'is_package'=>0),'id,name');
            $this->load->view('masters/editpackage',$this->data);
        }else if( !empty($_POST['package_id']) && !empty($_POST['cat_id']) && !empty($_POST['color'])  && !empty($_POST['card_type'])
                && !empty($_POST['name']) && !empty($_POST['validity']) && !empty($_POST['price']) && !empty($_POST['descr']) 
                && count($_POST['services']) ){
            
            $package_id = trim(preg_replace('!\s+!', ' ',html_escape($this->input->post('package_id', true))));
            $cat_id = trim(preg_replace('!\s+!', ' ',html_escape($this->input->post('cat_id', true))));
            $color = trim(preg_replace('!\s+!', ' ',html_escape($this->input->post('color', true))));
            $card_type = trim(preg_replace('!\s+!', ' ',html_escape($this->input->post('card_type', true))));
            $name = trim(preg_replace('!\s+!', ' ',html_escape($this->input->post('name', true))));
            $validity = trim(preg_replace('!\s+!', ' ',html_escape($this->input->post('validity', true))));
            $price = trim(preg_replace('!\s+!', ' ',html_escape($this->input->post('price', true))));
            $descr = trim(preg_replace('!\s+!', ' ',html_escape($this->input->post('descr', true))));
            $services = $this->input->post('services', true);
                
            $where = array('name'=>$name,'cat_id'=>$cat_id,'status !='=>-1,'id !='=>$package_id);
            $check = $this->master_db->getRecords('packages',$where,'id');
            if(count($check)){
                echo -1;exit;
            }else{
                $update_data = array(
                    'cat_id'    =>  $cat_id,
                    'color'     =>  $color,
                    'card_type' =>  $card_type,
                    'name'      =>  $name,
                    'descr'     =>  $descr,
                    'price'     =>  $price,
                    'validity'  =>  $validity,
                    'updated_by'=>  $det[0]->id,
                    'updated_at'=>  date('Y-m-d H:i:s')
                );
                $this->master_db->updateRecord('packages',array('id'=>$package_id),$update_data);
                
                if( count($services) ){
                    foreach($services as $item){
                        $condition = "package_id = ".$package_id." and service_id = ".$item." and status = 1 ";
                        $checkService = $this->master_db->getRecords('package_service',$condition,'id');
                        if( count($checkService) ){
                            continue;
                        }else{
                            $insert = array(
                                'package_id'    =>  $package_id,
                                'service_id'    =>  $item,
                                'status'        =>  1,
                                'created_by'    =>  $det[0]->id,
                                'created_at'    =>  date('Y-m-d H:i:s')
                            );
                            $this->master_db->insertRecord('package_service',$insert);
                        }                            
                    }
                    
                    $condition = "package_id = ".$package_id." and service_id not in (".implode(',',$services).") ";
                    //$serviceList = $this->master_db->getRecords('package_service',$condition,'id,package_id,service_id');
                    //echo '<pre>';print_r($serviceList);exit;
                    $update = array('status'=>0,'updated_by'=>$det[0]->id,'updated_at'=>date('Y-m-d H:i:s'));
                    $this->master_db->updateRecord('package_service',$update,$condition);
                    //echo $this->db->last_query();exit;
                }
                echo 1;exit;
            } 
        
        }
    }

    //update 13-07-2021
    public function partners(){
        $this->load->view('masters/partners',$this->data);
    }

    public function partnerList(){
        $det = $this->data['detail'];
        $data_list = $this->master_db->getPartnerList($det);
        //echo '<pre>';print_r($data_list);exit;
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
            $action = '';
            //$action = '<button type="button" title="Edit" name="update" onclick="modifyRow('.$row->id.');" class="btn btn-primary btn-sm"><i class="fas fa-edit"></i></button>&nbsp;';

            if( intval($row->verified) == 0 ){  
                $action .='<button type="button" title="Verify" onclick="verifyPartner('.$row->id.');" class="btn btn-success btn-sm"><i class="fas fa-check-circle"></i></button>&nbsp;';
            }
            
            $action .= '<button type="button" title="View Details" name="View" onclick="viewRow('.$row->id.');" class="btn btn-primary btn-sm"><i class="fas fa-eye"></i></button>&nbsp;';
            $status='';
            if( (int)$row->status == 1 ){
                $status = "<span class='text-success'><i class='fas fa-check'></i> Active</span>";
                $action .= "<button title='Deactive' onclick='updateStatus(".$row->id.", 0)' class='btn btn-warning btn-sm'><i class='fas fa-times-circle'></i></button>&nbsp;";
            }else{
                $status = "<span class='text-warning'><i class='fas fa-times-circle'></i> In-Active</span>";
                $action .= "<button title='Activate' onclick='updateStatus(".$row->id.", 1)' class='btn btn-success btn-sm'><i class='fas fa-check'></i></button>&nbsp;";
            }
            $action .= "<button title='Delete' onclick='updateStatus(".$row->id.", -1)' class='btn btn-danger btn-sm'><i class='fas fa-trash'></i></button>&nbsp;";

            if( intval($row->login_access) == 0 ){
                $action .= "<button title='Generate Login Credentials' onclick='createLogin(".$row->id.")' class='btn btn-info btn-sm'><i class='fas fa-save'></i></button>&nbsp;";
            }

            $type = '';
            switch(intval($row->type)){
                case 1:$type = 'COUNTRY PARTNER';break;
                case 2:$type = 'STOCKIST';break;
                case 3:$type = 'STATE C&F';break;
                case 4:$type = 'DISTRIBUTOR';break;
                case 5:$type = 'DEALER';break;
                case 6:$type = 'RETAILER';break;
                default:$type = '';break;                
            }

            $company_type = '';
            switch(intval($row->company_type)){
                case 1:$company_type = 'PRIVATE LIMITED';break;
                case 2:$company_type = 'LIMITED';break;
                case 3:$company_type = 'PARTNERSHIP';break;
                case 4:$company_type = 'PROPRITOR';break;
                case 5:$company_type = 'LLP';break;
                default:$company_type = '';break;                
            }

            $sub_array[] = $action;
            $sub_array[] = $type;
            $sub_array[] = $row->code;
            $sub_array[] = $row->company_name;
            $sub_array[] = $company_type;
            $sub_array[] = $row->gst_no;
            $sub_array[] = $row->fullname;
            $sub_array[] = $row->contactno;
            $sub_array[] = $status;

            if( intval($row->verified) == 1 ){
                $sub_array[] = "<span class='text-success'><i class='fas fa-check-circle'></i> Verified</span>";
            }else{
                $sub_array[] = "<span class='text-danger'>Pending</span>";
            }

            if( intval($row->login_access) == 1 ){
                $sub_array[] = "<span class='text-success'><i class='fas fa-check-circle'></i> Sent</span>";
            }else{
                $sub_array[] = "<span class='text-danger'>Pending</span>";
            }

            $data[] = $sub_array;
            
        }
        $_POST["length"] = -1;
        $members = $this->master_db->getPartnerList($det);
        
        $total = count($members);
        $output = array(
            "draw"              =>  intval($_POST["draw"]),
            "recordsTotal"      =>  $total,
            "recordsFiltered"   =>  $total,//$this->master_db->get_filtered_data("guards")
            "data"              =>  $data
        );
        echo json_encode($output);
    }

    public function setPartnerStatus(){
        $det = $this->data['detail'];
        $id = trim($this->input->post('id'));
        $status = trim($this->input->post('status'));
        $where_data = array(
            'status'=>$status,
            'updated_at'=>date('Y-m-d H:i:s'),
            'updated_by'=>$det[0]->id
        );
        $this->master_db->updateRecord('partners',$where_data,array('id'=>$id));
        echo 1;
    }

    public function verifyPartner(){
        $det = $this->data['detail'];
        $id = trim($this->input->post('id'));
        $check = $this->master_db->getRecords('partners',array('id'=>$id,'verified'=>0),'id,verified');
        //echo '<pre>';print_r($check);exit;
        if(count($check)){
            $where_data = array(
                'verified'=>1,
                'verified_at'=>date('Y-m-d H:i:s'),
                'verified_by'=>$det[0]->id
            );
            $this->master_db->updateRecord('partners',$where_data,array('id'=>$id));
            echo 1;
        }else{
            echo 0;
        }
    }

    public function generateLogin(){
        $det = $this->data['detail'];
        $id = trim(preg_replace('!\s+!', ' ',html_escape($this->input->post('id', true))));
        $check = $this->master_db->getRecords('partners',array('id'=>$id,'login_access'=>0),'id,login_access,verified');
        //echo '<pre>';print_r($check);exit;
        if(count($check)){
            if( intval($check[0]->verified) == 0){
                echo -1;exit;
            }

            $partner = $this->master_db->getRecords('partner_personal',array('partner_id'=>$id),'contactno,fullname,emailid');    
            //echo '<pre>';print_r($partner);exit;
            if( count($partner) ){
                $password = $this->home_db->randomPassword();
                //echo $password;exit;
                
                $insert = array(
                    'partner_id'    =>  $check[0]->id,
                    'phone'         =>  $partner[0]->contactno,
                    'password'      =>  $this->home_db->getencryptPass($password,1),
                    'status'        =>  1,
                    'created_at'    =>  date('Y-m-d H:i:s'),
                    'created_by'    =>  $det[0]->id
                );
                //echo '<pre>';print_r($insert);exit;
                $this->master_db->insertRecord('partner_login',$insert);
                
                $template = $this->master_db->getRecords('templates',array('type'=>1),'id,sms_template,mail_template,label');
                //send sms
                $this->load->library('SMS');
                $message = $template[0]->sms_template;
                $message = str_replace('{#name#}',$partner[0]->fullname,$message);
                $message = str_replace('{#phone#}',$partner[0]->contactno,$message);
                $message = str_replace('{#pass#}',$password.' ',$message);
                $message = str_replace('{#login_url#}',app_url().' ',$message);
                $this->sms->sendSmsToUser($message,$partner[0]->contactno);
                //echo $message;exit;
                //end

                //send mail
                $this->load->library('Mail');
                $message = $template[0]->mail_template;
                $message = str_replace('{#name#}',$partner[0]->fullname,$message);
                $message = str_replace('{#phone#}',$partner[0]->contactno,$message);
                $message = str_replace('{#pass#}',$password.' ',$message);
                $message = str_replace('{#login_url#}',app_url().' ',$message);
                $this->data['company'] = $this->master_db->getRecords('company_detail',array('id'=>1),'name,address,phone_no,email,logo_link,website_url');
                $this->data['messagebody'] = $message;
                $body = $this->load->view('mail_template',$this->data,true);
                $this->mail->send_sparkpost_attach($body,array($partner[0]->emailid),$template[0]->label);
                //end
            }

            $where_data = array(
                'login_access'=>1,
                'login_at'=>date('Y-m-d H:i:s'),
                'login_by'=>$det[0]->id
            );
            $this->master_db->updateRecord('partners',$where_data,array('id'=>$id));            
            echo 1;
        }else{
            echo 0;
        }
    }

    function saveLogin($id){
        $det = $this->data['detail'];
        $check = $this->master_db->getRecords('partners',array('id'=>$id,'login_access'=>0,'verified'=>1),'id,login_access,verified');
        //echo '<pre>';print_r($check);exit;
        if(count($check)){
            $partner = $this->master_db->getRecords('partner_personal',array('partner_id'=>$id),'fullname,contactno');    
            //echo '<pre>';print_r($partner);exit;
            if( count($partner) ){
                $password = $this->home_db->randomPassword();
                $insert = array(
                    'partner_id'    =>  $check[0]->id,
                    'phone'         =>  $partner[0]->contactno,
                    'password'      =>  $this->home_db->getencryptPass($password,1),
                    'status'        =>  1,
                    'created_at'    =>  date('Y-m-d H:i:s'),
                    'created_by'    =>  $det[0]->id
                );
                //echo '<pre>';print_r($insert);exit;
                $this->master_db->insertRecord('partner_login',$insert);

                /*
                //send sms
                $this->load->library('SMS');
                $template = $this->master_db->getRecords('sms_templates',array('type'=>1),'id,template');
                $message = $template[0]->template;
                $message = str_replace('{#name#}',$otp,$partner[0]->fullname);
                $message = str_replace('{#phone#}',$otp,$partner[0]->contactno);
                $message = str_replace('{#pass#}',$otp,$partner[0]->password);
                $message = str_replace('{#login_url#}',$otp,app_url());
                echo $message;
                */
                //end
            }
        }
    }

    public function getPartnerDetail($id = ''){
        $det = $this->data['detail'];
        if( $id != '' ){
            $this->data['partner'] = $check = $this->master_db->getParterDetail($id);
            echo $this->load->view('masters/partner_detail',$this->data,true);
        }
    }

    /*
    function sendRegisterSMS(){
        $this->load->library('SMS');
        $template = $this->master_db->getRecords('sms_templates',array('type'=>2),'id,template');
        if(count($template)){
            $to = '9066055521';
            $otp = '1234';
            $message = str_replace('{#otp#}',$otp,$template[0]->template);
            //echo $message;
            $this->sms->sendSmsToUser($message,$to);
        }
    }
    */

    function sendMail(){
        $this->load->library('Mail');
        $this->data['company'] = $this->master_db->getRecords('company_detail',array('id'=>1),'name,address,phone_no,email,logo_link,website_url');
        $this->data['messagebody'] = 'Test';
        $body = $this->load->view('mail_template',$this->data,true);
        //echo $body;exit;
        $this->mail->send_sparkpost_attach($body,array('shashi@savithru.com'),'Hi');
        //$this->mail->send_sparkpost_attach('Test',array('shashi@savithru.com'),'Hi');
    }
}
?>