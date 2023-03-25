<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
//error_reporting(E_ALL);ini_set('display_errors', '1');
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
               // echo "<pre>";print_r($this->data['detail']);exit;

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
            $action .= '<button type="button" title="Edit Service Fields" name="update" onclick="modifyFields('.$row->id.');" class="btn btn-primary btn-sm"><i class="fas fa-book"></i></button>&nbsp;';
            
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
            $expiry_date = date("Y-m-d",strtotime("+$validity days"));

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
                    'expiry_date'  =>$expiry_date,
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
       // echo '<pre>';print_r($data_list);exit;
        $data = array();
        $i = $_POST["start"]+1;
        
        foreach($data_list as $row)
        {
            $sub_array = array();
            $sub_array[] = $i++;
            $action = '<button type="button" title="Edit" name="update" onclick="modifyRow('.$row->id.');" class="btn btn-primary btn-sm"><i class="fas fa-edit"></i></button>&nbsp;';
            $publish = "";
            if( (int)$row->status == 1 ){
                $status = "<span class='text-success'><i class='fas fa-check'></i> Active</span>";
                $action .= "<button title='Deactive' onclick='updateStatus(".$row->id.", 0)' class='btn btn-warning btn-sm'><i class='fas fa-times-circle'></i></button>&nbsp;";
            }else{
                $status = "<span class='text-warning'><i class='fas fa-times-circle'></i> In-Active</span>";
                $action .= "<button title='Activate' onclick='updateStatus(".$row->id.", 1)' class='btn btn-success btn-sm'><i class='fas fa-check'></i></button>&nbsp;";
            }
			
			
			
			
            $action .= "<button title='Delete' onclick='updateStatus(".$row->id.", -1)' class='btn btn-danger btn-sm'><i class='fas fa-trash'></i></button>&nbsp;";
            $action .= "<button title='App Modules' onclick='apppermission(".$row->id.")' class='btn btn-info btn-sm'><i class='fas fa-info-circle'></i></button>&nbsp;";
            if( (int)$row->publish == 1 ){
               // $status = "<span class='text-success'><i class='fas fa-check'></i> Publish</span>";
                $action .= "<button title='Unpublish' onclick='updatePublishStatus(".$row->id.", 0)' class='btn btn-success btn-sm'><i class='fa fa-arrow-up'></i></button>&nbsp;";
            }else{
               // $status = "<span class='text-warning'><i class='fas fa-times-circle'></i> Unpublish</span>";
                $action .= "<button title='Publish' onclick='updatePublishStatus(".$row->id.", 1)' class='btn btn-warning btn-sm'><i class='fa fa-arrow-down'></i></button>&nbsp;";
            }
			
			
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
	
	  public function setPublishStatus(){
        $det = $this->data['detail'];
        $id = trim($this->input->post('id'));
        $status = trim($this->input->post('status'));
		$condition = "package_id=$id  and status=1";
		$checkModule = $this->master_db->getRecords('package_module',$condition,'id,status');
		if(count($checkModule) == 0){
			echo 2;exit;
		}
		
		$condition = "package_id=$id and status=1";
		$checkHighlights = $this->master_db->getRecords('package_highlights',$condition,'id,status');
		if(count($checkHighlights) == 0){
			echo 3;exit;
		}
		
		
        $where_data = array(
            'publish'=>$status,
            'updated_at'=>date('Y-m-d H:i:s'),
            'updated_by'=>$det[0]->id
        );
        $this->master_db->updateRecord('packages',$where_data,array('id'=>$id));
        echo 1;
    }

    public function editpackage(){
        $det = $this->data['detail'];
        //echo "<pre>";print_r($_POST);exit;
        if( !empty($_GET['id']) ){
            $id = trim(preg_replace('!\s+!', ' ',html_escape($this->input->get('id', true))));
            $this->data['package'] = $this->master_db->getPackageDetail($id)[0];
            $this->data['category'] = $this->master_db->getRecords('category',array('status!='=>-1,'is_package'=>1),'id,name');
            $this->data['pcategory'] = $this->master_db->getRecords('category',array('status!='=>-1,'is_package'=>0),'id,name');
            $this->load->view('masters/editpackage',$this->data);
        }else if( $_SERVER['REQUEST_METHOD'] =="POST"){
            //echo "<pre>";print_r($_POST);exit;
            
            $package_id = trim(preg_replace('!\s+!', ' ',html_escape($this->input->post('package_id', true))));
            $cat_id = trim(preg_replace('!\s+!', ' ',html_escape($this->input->post('cat_id', true))));
            $color = trim(preg_replace('!\s+!', ' ',html_escape($this->input->post('color', true))));
            $card_type = trim(preg_replace('!\s+!', ' ',html_escape($this->input->post('card_type', true))));
            $name = trim(preg_replace('!\s+!', ' ',html_escape($this->input->post('name', true))));
            $validity = trim(preg_replace('!\s+!', ' ',html_escape($this->input->post('validity', true))));
            $price = trim(preg_replace('!\s+!', ' ',html_escape($this->input->post('price', true))));
            $descr = trim(preg_replace('!\s+!', ' ',html_escape($this->input->post('descr', true))));
            $services = $this->input->post('services', true);
            $expiry_date = date("Y-m-d",strtotime("+$validity days"));
                
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
                    'expiry_date'  =>$expiry_date,
                    'updated_by'=>  $det[0]->id,
                    'updated_at'=>  date('Y-m-d H:i:s')
                );
                //echo '<pre>';print_r($update_data);exit;
                $this->master_db->updateRecord('packages',$update_data,array('id'=>$package_id));
                
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

    public function getPackageAppModules($id=''){
        $det = $this->data['detail'];
        if( !empty($_POST['package_id']) ){
            $this->data['package_id'] = $package_id = trim(preg_replace('!\s+!', ' ',html_escape($this->input->post('package_id', true))));
            $this->load->view('masters/package_modules',$this->data);
        }else{
            echo 0;
        }
    }

    public function savePackageModules(){
        $det = $this->data['detail'];
        if( !empty($_POST['package_id']) ){
            $package_id = trim(preg_replace('!\s+!', ' ',html_escape($this->input->post('package_id', true))));

           
            $where = array('id'=>$package_id,'status !='=>-1);
            $check = $this->master_db->getRecords('packages',$where,'id');
            if(count($check)){
                $modules = $this->input->post('module_id');
                foreach($modules as $mod){
                    $condition = "package_id=$package_id and module_id = $mod";
                    $checkmod = $this->master_db->getRecords('package_module',$condition,'id,status');
                    if(count($checkmod)){
                        $update = array(
                            'status'    =>  trim(preg_replace('!\s+!', ' ',html_escape($this->input->post('action_'.$mod, true)))),
                            'updated_by'=>  $det[0]->id,
                            'updated_at'=>  date('Y-m-d H:i:s')
                        );
                        $this->master_db->updateRecord('package_module',$update,array('id'=>$checkmod[0]->id));
                    }else{
                        $insert = array(
                            'package_id'=>  $package_id,
                            'module_id' =>  $mod,
                            'status'    =>  trim(preg_replace('!\s+!', ' ',html_escape($this->input->post('action_'.$mod, true)))),
                            'created_by'=>  $det[0]->id,
                            'created_at'=>  date('Y-m-d H:i:s')
                        );
                        $this->master_db->insertRecord('package_module',$insert);
                    }

                    if( isset($_POST['submodule_'.$mod])){
                        $submodules = $this->input->post('submodule_'.$mod);
                        //echo '<pre>';print_r($submodules);exit;
                        foreach($submodules as $smod){
                            $condition = "package_id=$package_id and module_id = $mod and submodule_id = ".$smod;
                            $checksmod = $this->master_db->getRecords('package_submodule',$condition,'id,status');
                            //echo '<pre>';print_r($checksmod);exit;
                            if(count($checksmod)){
                                $update = array(
                                    'status'    =>  trim(preg_replace('!\s+!', ' ',html_escape($this->input->post('action_'.$mod.'_'.$smod, true)))),
                                    'updated_by'=>  $det[0]->id,
                                    'updated_at'=>  date('Y-m-d H:i:s')
                                );
                                //echo '<pre>';print_r($update);exit;
                                $this->master_db->updateRecord('package_submodule',$update,array('id'=>$checksmod[0]->id));
                            }else{
                                $insert = array(
                                    'package_id'=>  $package_id,
                                    'module_id' =>  $mod,
                                    'submodule_id' => $smod,
                                    'status'    =>  trim(preg_replace('!\s+!', ' ',html_escape($this->input->post('action_'.$mod.'_'.$smod, true)))),
                                    'created_by'=>  $det[0]->id,
                                    'created_at'=>  date('Y-m-d H:i:s')
                                );
                                $this->master_db->insertRecord('package_submodule',$insert);
                            }
                        }                        
                    }
                }
                echo 1;
            }else{
                echo -1;
            }
        }else{
            echo 0;
        }
        //echo '<pre>';print_r($_POST);exit;
    }

    //update 13-07-2021
    public function partners(){
        $this->load->view('masters/partners',$this->data);
    }

    public function partnerList(){
        $det = $this->data['detail'];
        $data_list = $this->master_db->getPartnerList($det);
        //echo $this->db->last_query();exit;
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
            $state = $row->state_id;
            $district = $row->district_id;
            $taluk = $row->taluk_id;
            $sub_array[] = $i++;
            $action = '';
           $states = $this->master_db->getRecords('states',array("id"=>$state),"name,state_code");
            $districts = $this->master_db->getRecords('districts',array("id"=>$district),"name");
            $taluks = $this->master_db->getRecords('cities',array("id"=>$taluk),"name");
            
            $sta ="";$dist="";$tal ="";
            foreach ($states as $key => $value) {
                $sta .= $value->name." - ".$value->state_code;            
            }

         foreach ($districts as $key => $value) {
            $dist .= $value->name;            
        }

         foreach ($taluks as $key => $value) {
            $tal .= $value->name;            
        }
            //$action = '<button type="button" title="Edit" name="update" onclick="modifyRow('.$row->id.');" class="btn btn-primary btn-sm"><i class="fas fa-edit"></i></button>&nbsp;';

            if( intval($row->verified) == 0 ){  
                $action .='<button type="button" title="Verify" onclick="verifyPartner('.$row->id.');" class="btn btn-success btn-sm"><i class="fas fa-check-circle"></i></button>&nbsp;';
            }
            
            $action .= '<a type="button" title="View Details" name="View" href="'.base_url().'master/editpartner?id='.$row->id.'" class="btn btn-primary btn-sm"><i class="fas fa-edit"></i></a>&nbsp;';
             $action .= '<button type="button" title="View Details" name="View" onclick="viewRow('.$row->id.');" class="btn btn-primary btn-sm"><i class="fas fa-eye"></i></button>&nbsp;';
            $status='';
            if( (int)$row->status == 1 ){
                                $status = "<span class='text-warning'><i class='fas fa-times-circle'></i> In-Active</span>";
$action .= "<button title='Deactive' onclick='updateStatus(".$row->id.", 1)' class='btn btn-warning btn-sm'><i class='fas fa-check'></i></button>&nbsp;";
                
            }else{
                                $status = "<span class='text-success'><i class='fas fa-check'></i> Active</span>";

                
                $action .= "<button title='Active' onclick='updateStatus(".$row->id.", 0)' class='btn btn-success btn-sm'><i class='fas fa-times-circle'></i></button>&nbsp;";
            }
            $action .= "<button title='Delete' onclick='updateStatus(".$row->id.", -1)' class='btn btn-danger btn-sm'><i class='fas fa-trash'></i></button>&nbsp;";

            if( intval($row->login_access) == 0 && intval($row->verified) == 1){
                $action .= "<button title='Generate Login Credentials' onclick='createLogin(".$row->id.")' class='btn btn-info btn-sm'><i class='fas fa-save'></i></button>&nbsp;";
            }
            $login = "";
            if($row->login_access ==0) {
                $login .="In-active";
            }else {
                $login .="Active";
            }

             $verifiedid = "";
            if($row->verified ==0) {
                $verifiedid .="Pending";
            }else {
                $verifiedid .="Verified";
            }

            $type = '';
            switch(intval($row->type)){
                case 1:$type = 'COUNTRY PARTNER';break;
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
            $sub_array[] = "<a href='https://www.lifeonplus.com/app_assets/".$row->company_doc."' download><img src='https://www.lifeonplus.com/app_assets/".$row->company_doc."' style='width:80px;height:80px;object-fit:cover'/></a>";
             $sub_array[] = "<a href='https://www.lifeonplus.com/app_assets/".$row->photo."' download><img src='https://www.lifeonplus.com/app_assets/".$row->photo."' style='width:80px;height:80px;object-fit:cover'/></a>";
              $sub_array[] = "<a href='https://www.lifeonplus.com/app_assets/".$row->kyc_doc."' download><img src='https://www.lifeonplus.com/app_assets/".$row->kyc_doc."' style='width:80px;height:80px;object-fit:cover'/></a>";
            $sub_array[] = $type;
            $sub_array[] = $row->code;
            $sub_array[] = $row->company_name;
            $sub_array[] = $row->emailid;
            $sub_array[] = $company_type;
            $sub_array[] = "India";
            $sub_array[] = $sta;
            $sub_array[] = $dist;
            $sub_array[] = $tal;
            $sub_array[] = $row->gst_no;
            $sub_array[] = $row->fullname;
            $sub_array[] = $row->contactno;
            $sub_array[] = $row->pay_id;
            $sub_array[] = $row->status;
            $sub_array[] = $status;
            $sub_array[] = $verifiedid;
            $sub_array[] = $login;

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

        if($status ==-1) {
            $this->master_db->deleterecord('partners',['id'=>$id]);
            $this->master_db->deleterecord('partner_personal',['partner_id'=>$id]);
            $this->master_db->deleterecord('partner_payment',['partner_id'=>$id]);
            $this->master_db->deleterecord('partner_login',['partner_id'=>$id]);
        }
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
        $getdata = $this->master_db->partnerLoginList($id);
        //echo $this->db->last_query();exit;
        //echo "<pre>";print_r($_POST);exit;
        $check = $this->master_db->getRecords('partners',array('id'=>$id,'login_access'=>0),'id,login_access,verified,type');
        //echo '<pre>';print_r($check);exit;
        if(count($check)){
            if( intval($check[0]->verified) == 0){
                echo -1;exit;
            }

            $partner = $this->master_db->getRecords('partner_personal',array('partner_id'=>$id),'contactno,fullname,emailid,country_id,state_id,district_id,taluk_id'); 
            //echo $this->db->last_query();exit;

            $getcountry = $this->master_db->getRecords('countries',['id'=>$partner[0]->country_id],'id,name');  
            
            $getstate = $this->master_db->getRecords('states',['id'=>$partner[0]->state_id],'id,name');  

            $getdistrict = $this->master_db->getRecords('districts',['id'=>$partner[0]->district_id],'id,name'); 

            $gettaluk = $this->master_db->getRecords('cities',['id'=>$partner[0]->taluk_id],'id,name');   
             //echo $this->db->last_query();exit;
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
                $this->data['country'] = $getcountry[0]->name;
                  $this->data['type'] = $check[0]->type;
                  if(is_array($getstate) && !empty($getstate)) {
                    $this->data['state'] = $getstate[0]->name;
                }else {
                    $this->data['state'] ="";
                }
                
                if(is_array($getdistrict) && !empty($getdistrict)) {
                    $this->data['disctrict'] = $getdistrict[0]->name;
                }else {
                    $this->data['disctrict'] ="";
                }

                if(is_array($gettaluk) && !empty($gettaluk)) {
                    $this->data['taluk'] = $gettaluk[0]->name;
                }else {
                    $this->data['taluk'] = "";
                }
                
                
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

    //test mail function
    function sendMail(){
        $this->load->library('Mail');
        $this->data['company'] = $this->master_db->getRecords('company_detail',array('id'=>1),'name,address,phone_no,email,logo_link,website_url');
        $this->data['messagebody'] = 'Test';
        $body = $this->load->view('mail_template',$this->data,true);
        //echo $body;exit;
        $this->mail->send_sparkpost_attach($body,array('shashi@savithru.com'),'Hi');
        //$this->mail->send_sparkpost_attach('Test',array('shashi@savithru.com'),'Hi');
    }

    //service fields functions
    //dynamic service field
    public function service_field_save($id = ''){
        $det = $this->data['detail'];
        $this->data['service'] = array();
        $this->data['subcategory'] = array();
        $this->data['services'] = array();
        if( $id != '' ){
            $check = $this->master_db->getRecords('services',array('id'=>$id,'status'=>1),'id,cat_id,subcat_id');
            if(count($check) == 0 ){
                $this->session->set_flashdata('message','<div class="alert alert-danger alert-dismissable"><button class="close" aria-hidden="true" data-dismiss="alert" type="button">&times;</button>Service not found.</div>');
                redirect(base_url()."master/services");
            }
            $this->data['service'] = $check[0];
            $this->data['subcategory'] = $this->master_db->getRecords('subcategory',array('status!='=>-1,'id'=>$check[0]->subcat_id),'id,name');
            $this->data['services'] = $this->master_db->getRecords('services',array('status'=>1,'cat_id'=>$check[0]->cat_id,'subcat_id'=>$check[0]->subcat_id),'id,name');
            $this->data['type'] = 'edit';
        }else{
            $this->data['type'] = 'add';
        }
        $this->data['category'] = $this->master_db->getRecords('category',array('status!='=>-1,'is_package'=>0),'id,name');
        $this->load->view('masters/service_field_save',$this->data);
    }

    public function getFieldList(){
        $det = $this->data['detail'];
        $cat_id = $subcat_id = $service_id = 0;
        if( count($_POST) ){
            if( !empty($_POST['service_id']) ){
                $service_id = trim(preg_replace('!\s+!', ' ',html_escape($this->input->post('service_id', true))));
            }
        }
        $where = array('service_id'=>$service_id,'status'=>1);
        $this->data['fields'] = $this->master_db->getRecords('service_fields',$where,'*');
        $this->load->view('masters/field_list',$this->data);
    }

    public function saveServiceField(){
        $det = $this->data['detail'];
        //echo '<pre>';print_r($_POST);exit;
        if( !empty($_POST['service_id']) && count($_POST['fieldtype']) && count($_POST['action']) && count($_POST['order']) 
            && count($_POST['label']) && count($_POST['req']) && count($_POST['note']) ){
            
            $service_id = trim(preg_replace('!\s+!', ' ',html_escape($this->input->post('service_id', true))));
            $fieldtype = $this->input->post('fieldtype');
            $action = $this->input->post('action');
            $order = $this->input->post('order');
            $label = $this->input->post('label');
            $req = $this->input->post('req');
            $note = $this->input->post('note');

            $i = 0;
            foreach($action as $val){
                if( $val == 'new' ){
                    $insert = array(
                        'service_id'    =>  $service_id,
                        'order_no'      =>  $order[$i],
                        'type'          =>  $fieldtype[$i],
                        'label'         =>  $label[$i],
                        'is_required'   =>  $req[$i],
                        'note'          =>  $note[$i],
                        'status'        =>  1,
                        'created_at'    =>  date('Y-m-s H:i:s'),
                        'created_by'    =>  $det[0]->id
                    );
                    $this->master_db->insertRecord('service_fields',$insert);
                }else{
                    $update = array(
                        'order_no'      =>  $order[$i],
                        'type'          =>  $fieldtype[$i],
                        'label'         =>  $label[$i],
                        'is_required'   =>  $req[$i],
                        'note'          =>  $note[$i],
                        'updated_at'    =>  date('Y-m-s H:i:s'),
                        'updated_by'    =>  $det[0]->id
                    );
                    $this->master_db->updateRecord('service_fields',$update,array('id'=>$val,'service_id'=>$service_id));
                }
                $i++;
            }
            echo 1;
        }
    }

    public function setServiceFieldStatus(){
        $det = $this->data['detail'];
        $service_id = trim($this->input->post('service_id'));
        $field_id = trim($this->input->post('field_id'));
        $status  = -1;
        $update = array(
            'status'=>$status,
            'updated_at'=>date('Y-m-d H:i:s'),
            'updated_by'=>$det[0]->id
        );
        $this->master_db->updateRecord('service_fields',$update,array('service_id'=>$service_id,'id'=>$field_id));
        echo 1;
    }

    public function getServiceField($id = ''){
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
    //end

    //Items / Equipment
    public function items(){
        $condition = "status != -1 and is_package = 0 and type = 2";
        $this->data['category'] = $this->master_db->getRecords('category',$condition,'id,name');
        $this->load->view('masters/item',$this->data);
    }

    public function itemList(){
        $det = $this->data['detail'];
        $data_list = $this->master_db->getItemList($det);
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
            $sub_array[] = $row->category;
            $sub_array[] = $row->subcategory;
            $sub_array[] = $row->name;
            $sub_array[] = $status;
            $data[] = $sub_array;
            
        }
        $_POST["length"] = -1;
        $members = $this->master_db->getItemList($det);        
        $total = count($members);
        $output = array(
            "draw"              =>  intval($_POST["draw"]),
            "recordsTotal"      =>  $total,
            "recordsFiltered"   =>  $total,//$this->master_db->get_filtered_data("guards")
            "data"              =>  $data
        );
        echo json_encode($output);
    }

    public function saveItem(){
        $det = $this->data['detail'];
        if( !empty($_POST['item_id']) && !empty($_POST['cat_id']) && !empty($_POST['subcat_id']) && !empty($_POST['name']) ){
            $item_id = trim(preg_replace('!\s+!', ' ',html_escape($this->input->post('item_id', true))));
            $cat_id = trim(preg_replace('!\s+!', ' ',html_escape($this->input->post('cat_id', true))));
            $subcat_id = trim(preg_replace('!\s+!', ' ',html_escape($this->input->post('subcat_id', true))));
            $name = trim(preg_replace('!\s+!', ' ',html_escape($this->input->post('name', true))));
            $descr = trim($this->input->post('descr')); 
            $where = array(
                'id != '    =>  $item_id,        
                'cat_id'    =>  $cat_id,
                'subcat_id' =>  $subcat_id,
                'name'      =>  $name,
                'status != '=>  -1
            );
            $check = $this->master_db->getRecords('items',$where,'id');
            if( count($check) == 0 ){
                $update_data = array(
                    'cat_id'        =>  $cat_id,
                    'subcat_id'     =>  $subcat_id,
                    'name'          =>  $name,
                    'descr'         =>  $descr,
                    'updated_at'    =>  date('Y-m-d H:i:s'),
                    'updated_by'    =>  $det[0]->id
                );
                $this->master_db->updateRecord('items',$update_data,array('id'=>$item_id));
                echo 1;
            }else{
                echo "Item already exists.";
            }
        }else if( !empty($_POST['cat_id']) && !empty($_POST['subcat_id']) && !empty($_POST['name']) ){
            $cat_id = trim(preg_replace('!\s+!', ' ',html_escape($this->input->post('cat_id', true))));
            $subcat_id = trim(preg_replace('!\s+!', ' ',html_escape($this->input->post('subcat_id', true))));
            $name = trim(preg_replace('!\s+!', ' ',html_escape($this->input->post('name', true))));
            $descr = trim($this->input->post('descr')); 
            $where = array(
                'cat_id'    =>  $cat_id,
                'subcat_id' =>  $subcat_id,
                'name'      =>  $name,
                'status != '=>  -1
            );
            $check = $this->master_db->getRecords('items',$where,'id');
            if( count($check) == 0 ){
                $insert_data = array(
                    'cat_id'        =>  $cat_id,
                    'subcat_id'     =>  $subcat_id,
                    'name'          =>  $name,
                    'descr'         =>  $descr,
                    'created_at'    =>  date('Y-m-d H:i:s'),
                    'created_by'    =>  $det[0]->id,
                    'status'        =>  1,
                );
                $id = $this->master_db->insertRecord('items',$insert_data);
                echo 1;
            }else{
                echo "Equipment/Item already exists.";
            }
        }
    }

    public function setItemStatus(){
        $det = $this->data['detail'];
        $id = trim($this->input->post('id'));
        $status = trim($this->input->post('status'));

        $where_data = array(
            'status'=>$status,
            'updated_at'=>date('Y-m-d H:i:s'),
            'updated_by'=>$det[0]->id
        );
        $this->master_db->updateRecord('items',$where_data,array('id'=>$id));
        echo 1;
    }

    public function getItem($id = ''){
        $det = $this->data['detail'];
        if( $id != '' ){
            $where = array(
                'id'        =>  $id,
                'status != '=>  -1
            );
            $check = $this->master_db->getRecords('items',$where,'id,cat_id,subcat_id,name,descr');
            if( count($check) == 0 ){
                echo json_encode(array('status'=>'fail'));
            }else{
                $condition = "cat_id=".$check[0]->cat_id." and status != -1";
                $subcategory = $this->master_db->getRecords('subcategory',$condition,'id,name');
                echo json_encode(array('status'=>'success','data'=>$check[0],'subcategory'=>$subcategory));
            }
        }
    }
    //end
	
	//Speciality
	
	public function speciality(){
        $this->load->view('masters/speciality_view',$this->data);
    }

    public function specialityList(){
        $det = $this->data['detail'];
        $data_list = $this->master_db->getSpecialityList($det);
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
        $members = $this->master_db->getSpecialityList($det);
        
        $total = count($members);
        $output = array(
            "draw"              =>  intval($_POST["draw"]),
            "recordsTotal"      =>  $total,
            "recordsFiltered"   =>  $total,//$this->master_db->get_filtered_data("guards")
            "data"              =>  $data
        );
        echo json_encode($output);
    }

    public function saveSpeciality(){
        $det = $this->data['detail'];
        if( !empty($_POST['name']) && !empty($_POST['id']) ){
            $id = trim(preg_replace('!\s+!', ' ',html_escape($this->input->post('id', true))));
            $name = trim(preg_replace('!\s+!', ' ',html_escape($this->input->post('name', true))));
           
            $where = array(
                'id != '    =>  $id,        
                'name'      =>  $name,
                'status != '=>  -1
            );
            $check = $this->master_db->getRecords('speciality_master',$where,'id');
            if( count($check) == 0 ){
                $update_data = array(
                    'name'          =>  $name,
                    'updated_at'    =>  date('Y-m-d H:i:s'),
                    'updated_by'    =>  $det[0]->id
                );
                $this->master_db->updateRecord('speciality_master',$update_data,array('id'=>$id));
                echo 1;
            }else{
                echo "Speciality already exists.";
            }
        }else if( !empty($_POST['name'])){
            $name = trim(preg_replace('!\s+!', ' ',html_escape($this->input->post('name', true))));
           
            $where = array(
                'name'      =>  $name,
                'status != '=>  -1
            );
            $check = $this->master_db->getRecords('speciality_master',$where,'id');
            if( count($check) == 0 ){
                $insert_data = array(
                    'name'          =>  $name,
                    'created_at'    =>  date('Y-m-d H:i:s'),
                    'created_by'    =>  $det[0]->id,
                    'status'        =>  1,
                );
                $id = $this->master_db->insertRecord('speciality_master',$insert_data);
                echo 1;
            }else{
                echo "Speciality already exists.";
            }
        }
    }

    public function setSpecialityStatus(){
        $det = $this->data['detail'];
        $id = trim($this->input->post('id'));
        $status = trim($this->input->post('status'));

        $where_data = array(
            'status'=>$status,
            'updated_at'=>date('Y-m-d H:i:s'),
            'updated_by'=>$det[0]->id
        );
        $this->master_db->updateRecord('speciality_master',$where_data,array('id'=>$id));
        echo 1;
    }

    public function getSpeciality($id = ''){
        $det = $this->data['detail'];
        if( $id != '' ){
            $where = array(
                'id'        =>  $id,
                'status != '=>  -1
            );
            $check = $this->master_db->getRecords('speciality_master',$where,'id,name');
            if( count($check) == 0 ){
                echo json_encode(array('status'=>'fail'));
            }else{
                echo json_encode(array('status'=>'success','data'=>$check[0]));
            }
        }
    }
	
	
	public function add_partner(){
		$this->data['type']=1;
        $this->load->view('masters/partner_add',$this->data);
    }
	
	
	 public function modules(){
        $this->load->view('masters/modules',$this->data);
    }
	
	 public function moduleList(){
        $det = $this->data['detail'];
        $data_list = $this->master_db->getModuleList($det);
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
			$sub_array[] = $row->order_no;
            $sub_array[] = $row->name;
           
            $sub_array[] = $status;
            $data[] = $sub_array;
            
        }
        $_POST["length"] = -1;
        $members = $this->master_db->getModuleList($det);
        
        $total = count($members);
        $output = array(
            "draw"              =>  intval($_POST["draw"]),
            "recordsTotal"      =>  $total,
            "recordsFiltered"   =>  $total,//$this->master_db->get_filtered_data("guards")
            "data"              =>  $data
        );
        echo json_encode($output);
    }
	
	
	  public function setModuleStatus(){
        $det = $this->data['detail'];
        $id = trim($this->input->post('id'));
        $status = trim($this->input->post('status'));

        $where_data = array(
            'status'=>$status,
            'updated_at'=>date('Y-m-d H:i:s'),
            'updated_by'=>$det[0]->id
        );
        $this->master_db->updateRecord('app_modules',$where_data,array('id'=>$id));
        echo 1;
    }

    public function getModule($id = ''){
        $det = $this->data['detail'];
        if( $id != '' ){
            $wherem = array(
                'id'        =>  $id,
                'status != '=>  -1
            );
			
			$wheres = array(
                'module_id'        =>  $id,
                'status != '=>  -1
            );
            $check = $this->master_db->getRecords('app_modules',$wherem,'id,name,status,order_no');
			$subcheck = $this->master_db->getRecords('app_submodules',$wheres,'id,name,status,order_no');
			
            if( count($check) == 0 ){
                echo json_encode(array('status'=>'fail'));
            }else{
                echo json_encode(array('status'=>'success','data'=>$check[0],'subdata'=>$subcheck));
            }
        }
    }
	
	  public function saveModule(){
        $det = $this->data['detail'];
        if( !empty($_POST['module_name']) && !empty($_POST['id']) && !empty($_POST['morder_no']) ){
            $id = trim(preg_replace('!\s+!', ' ',html_escape($this->input->post('id', true))));
            $morder_no = trim(preg_replace('!\s+!', ' ',html_escape($this->input->post('morder_no', true))));
            $module_name = trim(preg_replace('!\s+!', ' ',html_escape($this->input->post('module_name', true))));
			
			$order_no = $this->input->post('order_no');
			$name = $this->input->post('name');
			$subid = $this->input->post('subid');
			
            $where = array(
                'id != '    =>  $id,        
                'name' =>  $module_name,
                'status != '=>  -1
            );
            $check = $this->master_db->getRecords('app_modules',$where,'id');
            if( count($check) == 0 ){
                $update_data = array(
                    'name'          =>  $module_name,
                    'order_no'      =>  $morder_no,
                    'updated_at'    =>  date('Y-m-d H:i:s'),
                    'updated_by'    =>  $det[0]->id
                );
                $this->master_db->updateRecord('app_modules',$update_data,array('id'=>$id));
				
				if(count($subid))
				{
				   $this->master_db->updateRecord('app_submodules',array('status'=>-1),array('module_id'=>$id));
				   foreach($subid as $s)
				   {
					    $order_no1 = $this->input->post('order_no'.$s);
			            $name1 = $this->input->post('name'.$s);
						$update_data = array(
							'name'          =>  $name1,
							'order_no'      =>  $order_no1,
							'updated_at'    =>  date('Y-m-d H:i:s'),
							'updated_by'    =>  $det[0]->id,
							'status'        =>  1,
						);
						
						$this->master_db->updateRecord('app_submodules',$update_data,array('id'=>$s));
				   }
			    }
				
				if(count($order_no))
				{
				   foreach($order_no as $i=>$val)
				   {
						$insert_subdata = array(
						    'module_id'     =>  $id,
							'name'          =>  $name[$i],
							'order_no'      =>  $order_no[$i],
							'created_at'    =>  date('Y-m-d H:i:s'),
							'created_by'    =>  $det[0]->id,
							'status'        =>  1,
						);
						$this->master_db->insertRecord('app_submodules',$insert_subdata);
				   }
			    }
				
                echo 1;
            }else{
                echo "Module already exists.";
            }
        }else if( !empty($_POST['module_name']) && !empty($_POST['morder_no']) ){
            $module_name = trim(preg_replace('!\s+!', ' ',html_escape($this->input->post('module_name', true))));
            $morder_no = trim(preg_replace('!\s+!', ' ',html_escape($this->input->post('morder_no', true))));
			
			$order_no = $this->input->post('order_no');
			$name = $this->input->post('name');
			
            $where = array(
                'name'      =>  $module_name,
                'status != '=>  -1
            );
            $check = $this->master_db->getRecords('app_modules',$where,'id');
            if( count($check) == 0 ){
                $insert_data = array(
                    'name'          =>  $name,
                    'order_no'      =>  $morder_no,
                    'created_at'    =>  date('Y-m-d H:i:s'),
                    'created_by'    =>  $det[0]->id,
                    'status'        =>  1,
                );
                $id = $this->master_db->insertRecord('app_modules',$insert_data);
				
				if(count($order_no))
				{
				   foreach($order_no as $i=>$val)
				   {
						$insert_subdata = array(
						    'module_id'     =>  $id,
							'name'          =>  $name[$i],
							'order_no'      =>  $order_no[$i],
							'created_at'    =>  date('Y-m-d H:i:s'),
							'created_by'    =>  $det[0]->id,
							'status'        =>  1,
						);
						
						$this->master_db->insertRecord('app_submodules',$insert_subdata);
				   }
			    }
                echo 1;
            }else{
                echo "Module already exists.";
            }
        }
    }
   
   
   
    public function highlights(){
        $this->load->view('masters/highlights',$this->data);
    }
	
	 public function highlightList(){
        $det = $this->data['detail'];
        $data_list = $this->master_db->getHighlightList($det);
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
			$sub_array[] = $row->package_name;
            $sub_array[] = $row->label;
           
            $sub_array[] = $status;
            $data[] = $sub_array;
            
        }
        $_POST["length"] = -1;
        $members = $this->master_db->getHighlightList($det);
        
        $total = count($members);
        $output = array(
            "draw"              =>  intval($_POST["draw"]),
            "recordsTotal"      =>  $total,
            "recordsFiltered"   =>  $total,//$this->master_db->get_filtered_data("guards")
            "data"              =>  $data
        );
        echo json_encode($output);
    }
	
	
	  public function setHighlightStatus(){
        $det = $this->data['detail'];
        $id = trim($this->input->post('id'));
        $status = trim($this->input->post('status'));

        $where_data = array(
            'status'=>$status,
            'updated_at'=>date('Y-m-d H:i:s'),
            'updated_by'=>$det[0]->id
        );
        $this->master_db->updateRecord('package_highlights',$where_data,array('id'=>$id));
        echo 1;
    }

    public function getHighlight($id = ''){
        $det = $this->data['detail'];
        if( $id != '' ){
            $wherem = array(
                'id'        =>  $id,
                'status != '=>  -1
            );
			
			$wheres = array(
                'status != '=> 1
            );
            $check = $this->master_db->getRecords('package_highlights',$wherem,'id,package_id,label,status');
			$packages = $this->master_db->getRecords('packages',$wheres,'id,name');
			
            if( count($check) == 0 ){
                echo json_encode(array('status'=>'fail'));
            }else{
                echo json_encode(array('status'=>'success','data'=>$check[0],'packages'=>$packages));
            }
        }
    }
	
	  public function saveHighlight(){
        $det = $this->data['detail'];
        if( !empty($_POST['package_id']) && !empty($_POST['id']) && !empty($_POST['label']) ){
            $id = trim(preg_replace('!\s+!', ' ',html_escape($this->input->post('id', true))));
            $package_id = trim(preg_replace('!\s+!', ' ',html_escape($this->input->post('package_id', true))));
            $label = trim(preg_replace('!\s+!', ' ',html_escape($this->input->post('label', true))));
            $where = array(
                'id != '    =>  $id,        
                'label' =>  $label,
                'status != '=>  -1
            );
            $check = $this->master_db->getRecords('package_highlights',$where,'id');
            if( count($check) == 0 ){
                $update_data = array(
                    'package_id'    =>  $package_id,
                    'label'         =>  $label,
                    'updated_at'    =>  date('Y-m-d H:i:s'),
                    'updated_by'    =>  $det[0]->id
                );
                $this->master_db->updateRecord('package_highlights',$update_data,array('id'=>$id));
				
                echo 1;
            }else{
                echo "Package Highlight already exists.";
            }
        }else if( !empty($_POST['label']) && !empty($_POST['package_id']) ){
            $package_id = trim(preg_replace('!\s+!', ' ',html_escape($this->input->post('package_id', true))));
            $label = $this->input->post('label');
				if(count($label))
				{
				   foreach($label as $i=>$val)
				   {
					   $where = array(
							'package_id' =>  $package_id,
							'label'      =>  $label[$i],
							'status != ' =>  -1
						);
						$check = $this->master_db->getRecords('package_highlights',$where,'id');
						if( count($check) == 0 )
						{
							$insert_subdata = array(
								'package_id'     =>  $package_id,
								'label'          =>  $label[$i],
								'created_at'     =>  date('Y-m-d H:i:s'),
								'created_by'     =>  $det[0]->id,
								'status'         =>  1,
							);
							$this->master_db->insertRecord('package_highlights',$insert_subdata);
						}
				   }
				   
			    }
                echo 1;
        }
    }
	public function country() {
        $this->load->view('masters/country',$this->data);
    }

    public function getCountryList() {
        $where = " where status !=2";
            if(isset($_POST["search"]["value"]) && !empty($_POST["search"]["value"]) )
            { 
                $val    = trim($_POST["search"]["value"]);
                $where .= " and (name like '%$val%') ";
            }
            $order_by_arr[] = "name";
            $order_by_arr[] = "";
            $order_by_arr[] = "id";
            $order_by_def   = " order by name asc";
            $query = "select * from countries ".$where."";           
            $fetchdata = $this->master_db->rows_by_paginations($query,$order_by_def,$order_by_arr);
       // echo $this->db->last_query();exit;
            $data = array();
            $i = $_POST["start"]+1;
            foreach ($fetchdata as $r) {
                $sub_array = array();
            $sub_array[] = $i++;
            $action = '<button type="button" title="Edit" name="update" onclick="modifyRow('.$r->id.');" class="btn btn-primary btn-sm"><i class="fas fa-edit"></i></button>&nbsp;';
            
            if( (int)$r->status == 1 ){
                $status = "<span class='text-success'><i class='fas fa-check'></i> Active</span>";
                $action .= "<button title='Deactive' onclick='updateStatus(".$r->id.", 0)' class='btn btn-warning btn-sm'><i class='fas fa-times-circle'></i></button>&nbsp;";
            }else{
                $status = "<span class='text-warning'><i class='fas fa-times-circle'></i> In-Active</span>";
                $action .= "<button title='Activate' onclick='updateStatus(".$r->id.", 1)' class='btn btn-success btn-sm'><i class='fas fa-check'></i></button>&nbsp;";
            }
            $action .= "<button title='Delete' onclick='updateStatus(".$r->id.", -1)' class='btn btn-danger btn-sm'><i class='fas fa-trash'></i></button>&nbsp;";
            $sub_array[] = $action;
            $sub_array[] = $r->name;
            $sub_array[] = $status;
            $data[] = $sub_array;
            }

            $res    = $this->master_db->run_manual_query_result($query);
        $total  = count($res);
        $output = array(
            "draw"              =>  intval($_POST["draw"]),
             "recordsTotal"          => $total,  
                "recordsFiltered"     => $total,  
            "data"              =>  $data
        );
        echo json_encode($output);
    }
	
	public function saveCountry() {
         $cname = trim(preg_replace('!\s+!', ' ',html_escape($this->input->post('cname', true))));
         $id = trim(preg_replace('!\s+!', ' ',html_escape($this->input->post('cat_id', true))));

         if(!empty($id)) {
                  $update_data = array(
                    'name'          =>  $cname,
                   
                );
                $this->master_db->updateRecord('countries',$update_data,array('id'=>$id));
                echo 1;
         }else {
                //echo "<pre>";print_r($_POST);exit;
          $where = array(
                'name'      =>  $cname,
                
            );
         $check = $this->master_db->getRecords('countries',$where,'id');
            if( count($check) == 0 ){
                $insert_data = array(
                    'name'          =>  $cname,
                    'status'        =>  1,
                );
                $id = $this->master_db->insertRecord('countries',$insert_data);
                echo 1;
            }else{
                echo "Category already exists.";
            }
         }
        
    }
	
	public function setCoutryStatus() {
        $det = $this->data['detail'];
        $id = trim($this->input->post('id'));
        $status = trim($this->input->post('status'));

        $where_data = array(
            'status'=>$status,
            
        );
        $this->master_db->updateRecord('countries',$where_data,array('id'=>$id));
        echo 1;
    }

     public function getCountry($id = ''){
        $det = $this->data['detail'];
        if( $id != '' ){
            $where = array(
                'id'        =>  $id,
                'status != '=>  -1
            );
            $check = $this->master_db->getRecords('countries',$where,'id,name');
            if( count($check) == 0 ){
                echo json_encode(array('status'=>'fail'));
            }else{
                echo json_encode(array('status'=>'success','data'=>$check[0]));
            }
        }
    }
/**** Tests *******/
	    public function tests() {
            $this->data['category'] = $this->master_db->getRecords('diagnostic_category',['status'=>1],'id,name','id desc');
	        $this->load->view('test_modules',$this->data);
	    }
        public function testList(){
        $det = $this->data['detail'];
        $where = "where tm.status !=-1";
			if(isset($_POST["search"]["value"]) && !empty($_POST["search"]["value"]) )
			{ 
				$val    = trim($_POST["search"]["value"]);
				$where .= " and (tm.test_name like '%$val%') ";
				$where .= " or (tm.mrp like '%$val%') ";
				$where .= " or (tm.price like '%$val%')  ";
			}
			$order_by_arr[] = "tm.test_name";
			$order_by_arr[] = "";
			$order_by_arr[] = "tm.id";
			$order_by_def   = " order by tm.id desc";
			$query = "select tm.id, tm.test_name,tm.mrp,tm.price,tm.special_note,tm.status,dc.name from test_modules tm left join diagnostic_category dc on dc.id=tm.did $where";			
			$data_list = $this->master_db->rows_by_paginations($query,$order_by_def,$order_by_arr);
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
            $sub_array[] = $row->test_name;
            $sub_array[] = $row->mrp;
            $sub_array[] = $row->price;
            $sub_array[] = $row->special_note;
            $sub_array[] = $status;
            $data[] = $sub_array;
        }
        $_POST["length"] = -1;
        $members = $this->master_db->run_manual_query_result($query);
        $total = count($members);
        $output = array(
            "draw"              =>  intval($_POST["draw"]),
            "recordsTotal"      =>  $total,
            "recordsFiltered"   =>  $total,//$this->master_db->get_filtered_data("guards")
            "data"              =>  $data
        );
        echo json_encode($output);
    }
    	  public function saveTests(){
    	  	//echo "<pre>";print_r($_POST);exit;
        $det = $this->data['detail'];
        if( !empty($_POST['test_name']) && !empty($_POST['id']) && !empty($_POST['mrp']) && !empty($_POST['price']) ){
            //echo "<pre>";print_r($_POST);exit;
            $id = trim(preg_replace('!\s+!', ' ',html_escape($this->input->post('id', true))));
            $test_name = trim(preg_replace('!\s+!', ' ',html_escape($this->input->post('test_name', true))));
            $mrp = trim(preg_replace('!\s+!', ' ',html_escape($this->input->post('mrp', true))));
            $price = trim(preg_replace('!\s+!', ' ',html_escape($this->input->post('price', true))));
            $time = trim(preg_replace('!\s+!', ' ',html_escape($this->input->post('time', true))));
            $specialnote = trim(preg_replace('!\s+!', ' ',html_escape($this->input->post('specialnote', true))));
			$subid = $this->input->post('subid');
            $name = $this->input->post('name');
            $dcategory = $this->input->post('dcategory');
             $pp = $this->master_db->getRecords('test_includes',['tid'=>$id],'id');

         //echo $this->db->last_query();exit;
         $ppid=array(); 
         foreach ($pp as $key => $value) {
             $ppid[] = $value->id;
         }
			$name = $this->input->post('name');
            $where = array(
                'id != '    =>  $id,        
                'test_name' =>  $test_name,
                'status != '=>  -1
            );
                $update_data = array(
                    'test_name'          =>  $test_name,
                    'mrp'      =>  $mrp,
                    'price'      =>  $price,
                    'report_time'      =>  $time,
                    'special_note'      =>  $specialnote,
                    'did'               =>$dcategory,
                    'updated_by'    =>  date('Y-m-d H:i:s'),
                );
                $this->master_db->updateRecord('test_modules',$update_data,array('id'=>$id));
                  if(count($name))
                    {
                           foreach($name as $key => $s)
                           {
                            if(isset($subid[$key])) {
                                    $name1= $this->input->post('name')[$key];
                                $update_data = array(
                                    'title'          =>  $name1,
                                    'tid'            =>  $id,
                                );
                                $this->master_db->updateRecord('test_includes',$update_data,array('id'=>$subid[$key])); 
                            }else {
                                $name1= $this->input->post('name')[$key];
                                $insert_subdata = array(
                            'title'          =>  $name1,
                            'tid'      =>  $id,
                            'created_at'    =>  date('Y-m-d H:i:s'),
                            
                        );
                        
                        $this->master_db->insertRecord('test_includes',$insert_subdata);
                            }
                                  
                           }
                     }
                    // exit;
                echo 1;
        }else if( !empty($_POST['test_name']) && !empty($_POST['mrp']) &&!empty($_POST['price']) ){
            $test_name = trim(preg_replace('!\s+!', ' ',html_escape($this->input->post('test_name', true))));
            $mrp = trim(preg_replace('!\s+!', ' ',html_escape($this->input->post('mrp', true))));
            $price = trim(preg_replace('!\s+!', ' ',html_escape($this->input->post('price', true))));
            $time = trim(preg_replace('!\s+!', ' ',html_escape($this->input->post('time', true))));
            $specialnote =  trim(preg_replace('!\s+!', ' ',html_escape($this->input->post('specialnote', true))));
			$name = $this->input->post('name');
            $dcategory = $this->input->post('dcategory');
            $where = array(
                'test_name'      =>  $test_name,
                'status != '=>  -1
            );
                $insert_data = array(
                    'test_name'          =>  $test_name,
                    'mrp'      =>  $mrp,
                    'price'      =>  $price,
                    'report_time'      =>  $time,
                    'special_note'      =>  $specialnote,
                    'did'               =>$dcategory,
                    'created_at'    =>  date('Y-m-d H:i:s'),
                    'status'        =>  1,
                );
                $id = $this->master_db->insertRecord('test_modules',$insert_data);
				if(count($name))
				{
				   foreach($name as $i=>$val)
				   {
						$insert_subdata = array(
							'title'          =>  $val,
							'tid'      =>  $id,
							'created_at'    =>  date('Y-m-d H:i:s'),
							
						);
						
						$this->master_db->insertRecord('test_includes',$insert_subdata);
				   }
			    }
                echo 1;
        }
    }
	  public function setTestsStatus(){
        $det = $this->data['detail'];
        $id = trim($this->input->post('id'));
        $status = trim($this->input->post('status'));
        $where_data = array(
            'status'=>$status,
            'updated_by'=>date('Y-m-d H:i:s'),
        );
        $this->master_db->updateRecord('test_modules',$where_data,array('id'=>$id));
        echo 1;
    }
        public function getTests($id = ''){
        $det = $this->data['detail'];
        if( $id != '' ){
            $wherem = array(
                'id'        =>  $id,
                'status != '=>  -1
            );
			$wheres = array(
                'tid'        =>  $id,
            );
            $check = $this->master_db->getRecords('test_modules',$wherem,'id,test_name,mrp,price,special_note,report_time,status');
			$subcheck = $this->master_db->getRecords('test_includes',$wheres,'id,title');
			
            if( count($check) == 0 ){
                echo json_encode(array('status'=>'fail'));
            }else{
                echo json_encode(array('status'=>'success','data'=>$check[0],'subdata'=>$subcheck));
            }
        }
    }

    public function deleteTests() {
        $id = $this->input->post('id');
        $del = $this->master_db->deleterecord('test_includes',['id'=>$id]);
        if($del) {
            echo json_encode(['status'=>'success','msg'=>'Deleted successfully']);
        }else {
            echo json_encode(['status'=>'failure','msg'=>'Error in Deleted']);
        }
    }

/******* Checkups ****/
	public function checkups() {
        $this->data['category'] = $this->master_db->getRecords('diagnostic_category',['status'=>1],'id,name','id desc');
         $this->load->view('checkup_module',$this->data);
    }
   	public function checkupList(){
        $det = $this->data['detail'];
        $where = "where cm.status !=-1";
		if(isset($_POST["search"]["value"]) && !empty($_POST["search"]["value"]) )
			{ 
				$val    = trim($_POST["search"]["value"]);
				$where .= " and (cm.test_name like '%$val%') ";
				$where .= " or (cm.mrp like '%$val%') ";
				$where .= " or (cm.price like '%$val%')  ";
			}
			$order_by_arr[] = "cm.test_name";
			$order_by_arr[] = "";
			$order_by_arr[] = "cm.id";
			$order_by_def   = " order by cm.id desc";
			$query = "select cm.id, cm.test_name,cm.mrp,cm.price,cm.special_note,cm.status,dc.name from checkup_modules cm left join diagnostic_category dc on dc.id=cm.did $where";			
			$data_list = $this->master_db->rows_by_paginations($query,$order_by_def,$order_by_arr);
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
            $sub_array[] = $row->test_name;
            $sub_array[] = $row->mrp;
            $sub_array[] = $row->price;
            $sub_array[] = $row->special_note;
            $sub_array[] = $status;
            $data[] = $sub_array;
        }
        $_POST["length"] = -1;
        $members = $this->master_db->run_manual_query_result($query);
        
        $total = count($members);
        $output = array(
            "draw"              =>  intval($_POST["draw"]),
            "recordsTotal"      =>  $total,
            "recordsFiltered"   =>  $total,//$this->master_db->get_filtered_data("guards")
            "data"              =>  $data
        );
        echo json_encode($output);
    }
    	public function saveCheckups(){
    	  	//echo "<pre>";print_r($_POST);exit;
        	$det = $this->data['detail'];
        	if( !empty($_POST['test_name']) && !empty($_POST['id']) && !empty($_POST['mrp']) && !empty($_POST['price']) ){
            $id = trim(preg_replace('!\s+!', ' ',html_escape($this->input->post('id', true))));
            $test_name = trim(preg_replace('!\s+!', ' ',html_escape($this->input->post('test_name', true))));
            $mrp = trim(preg_replace('!\s+!', ' ',html_escape($this->input->post('mrp', true))));
            $price = trim(preg_replace('!\s+!', ' ',html_escape($this->input->post('price', true))));
            $time = trim(preg_replace('!\s+!', ' ',html_escape($this->input->post('time', true))));
            $specialnote = trim(preg_replace('!\s+!', ' ',html_escape($this->input->post('specialnote', true))));
			$subid = $this->input->post('subid');
			$name = $this->input->post('name');
            $dcategory = $this->input->post('dcategory');
			$where = array(
                'id != '    =>  $id,        
                'test_name' =>  $test_name,
                'status != '=>  -1
            );
                $update_data = array(
                    'test_name'          =>  $test_name,
                    'mrp'      =>  $mrp,
                    'price'      =>  $price,
                    'report_datetime'      =>  $time,
                    'special_note'      =>  $specialnote,
                    'did'      =>  $dcategory,
                    'updated_by'    =>  date('Y-m-d H:i:s'),
                );
                $this->master_db->updateRecord('checkup_modules',$update_data,array('id'=>$id));
				        if(count($name))
                    {
                           foreach($name as $key => $s)
                           {
                            if(isset($subid[$key])) {
                                    $name1= $this->input->post('name')[$key];
                                $update_data = array(
                                    'title'          =>  $name1,
                                    'cid'            =>  $id,
                                );
                                $this->master_db->updateRecord('checkup_includes',$update_data,array('id'=>$subid[$key])); 
                            }else {
                                $name1= $this->input->post('name')[$key];
                                $insert_subdata = array(
                            'title'          =>  $name1,
                            'cid'      =>  $id,
                            'created_at'    =>  date('Y-m-d H:i:s'),
                        );
                        $this->master_db->insertRecord('checkup_includes',$insert_subdata);
                            }
                           }
                     }
                echo 1;
           
        }else if( !empty($_POST['test_name']) && !empty($_POST['mrp']) &&!empty($_POST['price']) ){
            $test_name = trim(preg_replace('!\s+!', ' ',html_escape($this->input->post('test_name', true))));
            $mrp = trim(preg_replace('!\s+!', ' ',html_escape($this->input->post('mrp', true))));
            $price = trim(preg_replace('!\s+!', ' ',html_escape($this->input->post('price', true))));
            $time = trim(preg_replace('!\s+!', ' ',html_escape($this->input->post('time', true))));
            $specialnote =  trim(preg_replace('!\s+!', ' ',html_escape($this->input->post('specialnote', true))));
			$name = $this->input->post('name');
            $dcategory = $this->input->post('dcategory');
            $where = array(
                'test_name'      =>  $test_name,
                'status != '=>  -1
            );
                $insert_data = array(
                    'test_name'          =>  $test_name,
                    'mrp'      =>  $mrp,
                    'price'      =>  $price,
                    'report_datetime'      =>  $time,
                    'special_note'      =>  $specialnote,
                    'did'      =>  $dcategory,
                    'created_at'    =>  date('Y-m-d H:i:s'),
                    'status'        =>  1,
                );
                $id = $this->master_db->insertRecord('checkup_modules',$insert_data);
				if(count($name))
				{
				   foreach($name as $i=>$val)
				   {
						$insert_subdata = array(
							'title'          =>  $val,
							'cid'      =>  $id,
							'created_at'    =>  date('Y-m-d H:i:s'),
						);
						$this->master_db->insertRecord('checkup_includes',$insert_subdata);
				   }
			    }
                echo 1;
        }
    }
	  public function setCheckupsStatus(){
        $det = $this->data['detail'];
        $id = trim($this->input->post('id'));
        $status = trim($this->input->post('status'));
        $where_data = array(
            'status'=>$status,
            'updated_by'=>date('Y-m-d H:i:s'),
        );
        $this->master_db->updateRecord('checkup_modules',$where_data,array('id'=>$id));
        echo 1;
    }
        public function getCheckups($id = ''){
        $det = $this->data['detail'];
        if( $id != '' ){
            $wherem = array(
                'id'        =>  $id,
                'status != '=>  -1
            );
			$wheres = array(
                'cid'        =>  $id,
            );
            $check = $this->master_db->getRecords('checkup_modules',$wherem,'id,test_name,mrp,price,special_note,report_datetime,status');
			$subcheck = $this->master_db->getRecords('checkup_includes',$wheres,'id,title');
			
            if( count($check) == 0 ){
                echo json_encode(array('status'=>'fail'));
            }else{
                echo json_encode(array('status'=>'success','data'=>$check[0],'subdata'=>$subcheck));
            }
        }
    }
     public function deleteCheckups() {
        $id = $this->input->post('id');
        $del = $this->master_db->deleterecord('checkup_includes',['id'=>$id]);
        if($del) {
            echo json_encode(['status'=>'success','msg'=>'Deleted successfully']);
        }else {
            echo json_encode(['status'=>'failure','msg'=>'Error in Deleted']);
        }
    }
    /******* Time slot ****/
    public function timeslot() {
         $this->load->view('timeslot',$this->data);
    }
    public function timeslotList(){
        $det = $this->data['detail'];
        $where = "where status !=-1";
        if(isset($_POST["search"]["value"]) && !empty($_POST["search"]["value"]) )
            { 
                $val    = trim($_POST["search"]["value"]);
                $where .= " and (days like '%$val%') ";
                $where .= " or (wdays like '%$val%') ";
            }
            $order_by_arr[] = "days";
            $order_by_arr[] = "";
            $order_by_arr[] = "id";
            $order_by_def   = " order by id desc";
            $query = "select * from timeslot  $where";           
            $data_list = $this->master_db->rows_by_paginations($query,$order_by_def,$order_by_arr);
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

            $days = "";$wday = "";
            if($row->days ==1) {
                $days = "Monday";
            }else if($row->days ==2) {
                $days = "Tuesday";
            }
            else if($row->days ==3) {
                $days = "Wednesday";
            }
            else if($row->days ==4) {
                $days = "Thursday";
            }
            else if($row->days ==5) {
                $days = "Friday";
            }
            else if($row->days ==6) {
                $days = "Saturday";
            }
            else if($row->days ==7) {
                $days = "Sunday";
            }
            if($row->wday ==1) {
                $wday = "Morning";
            }else if($row->wday ==2) {
                $wday = "Afternoon";
            }
            else if($row->wday ==3) {
                $wday = "Evening";
            }
            $sub_array[] = $action;
            $sub_array[] = $days;
            $sub_array[] = $wday;
            $sub_array[] = $row->timings;
            $sub_array[] = $status;
            $data[] = $sub_array;
        }
        $_POST["length"] = -1;
        $members = $this->master_db->run_manual_query_result($query);
        
        $total = count($members);
        $output = array(
            "draw"              =>  intval($_POST["draw"]),
            "recordsTotal"      =>  $total,
            "recordsFiltered"   =>  $total,//$this->master_db->get_filtered_data("guards")
            "data"              =>  $data
        );
        echo json_encode($output);
    }
          public function saveTimeslot(){
            //echo "<pre>";print_r($_POST);exit;
            $det = $this->data['detail'];
            if( !empty($_POST['days']) && !empty($_POST['id']) ){
            $id = trim(preg_replace('!\s+!', ' ',html_escape($this->input->post('id', true))));
            $days = trim(preg_replace('!\s+!', ' ',html_escape($this->input->post('days', true))));
            $wdays = trim(preg_replace('!\s+!', ' ',html_escape($this->input->post('wday', true))));
            $timings = trim(preg_replace('!\s+!', ' ',html_escape($this->input->post('timings', true))));
            $update_data = array(
                    'days'          =>  $days,
                    'wday'      =>  $wdays,
                    'timings'      =>  $timings,
                    'updated_at'    =>  date('Y-m-d H:i:s'),
            );
            $this->master_db->updateRecord('timeslot',$update_data,array('id'=>$id));
            echo 1;
        }else if( !empty($_POST['days']) && !empty($_POST['wday']) &&!empty($_POST['timings']) ){
            $days = trim(preg_replace('!\s+!', ' ',html_escape($this->input->post('days', true))));
            $wdays = trim(preg_replace('!\s+!', ' ',html_escape($this->input->post('wday', true))));
            $timings = trim(preg_replace('!\s+!', ' ',html_escape($this->input->post('timings', true))));
            $insert_data = array(
                     'days'          =>  $days,
                    'wday'      =>  $wdays,
                    'timings'      =>  $timings,
                    'created_at'    =>  date('Y-m-d H:i:s'),
                    'status'        =>  1,
            );
            $id = $this->master_db->insertRecord('timeslot',$insert_data);
            echo 1;
        }
    }
      public function setTimeslotStatus(){
        $det = $this->data['detail'];
        $id = trim($this->input->post('id'));
        $status = trim($this->input->post('status'));
        $where_data = array(
            'status'=>$status,
            'updated_at'=>date('Y-m-d H:i:s'),
        );
        $this->master_db->updateRecord('timeslot',$where_data,array('id'=>$id));
        echo 1;
    }
        public function getTimeslot($id = ''){
        $det = $this->data['detail'];
        if( $id != '' ){
            $wherem = array(
                'id'        =>  $id,
                'status != '=>  -1
            );
            $check = $this->master_db->getRecords('timeslot',$wherem,'id,days,wday,timings,status');
            
            if( count($check) == 0 ){
                echo json_encode(array('status'=>'fail'));
            }else{
                echo json_encode(array('status'=>'success','data'=>$check[0]));
            }
        }
    }
	/******* Checkups ****/
    public function videocall() {
         $this->load->view('video',$this->data);
    }
    public function videoList(){
        $det = $this->data['detail'];
        $where = "where status !=-1";
        if(isset($_POST["search"]["value"]) && !empty($_POST["search"]["value"]) )
            { 
                $val    = trim($_POST["search"]["value"]);
                $where .= " and (name like '%$val%') ";
                $where .= " or (email like '%$val%') ";
                $where .= " or (mobile like '%$val%')  ";
            }
            $order_by_arr[] = "name";
            $order_by_arr[] = "";
            $order_by_arr[] = "id";
            $order_by_def   = " order by id desc";
            $query = "select * from videoapi  $where";           
            $data_list = $this->master_db->rows_by_paginations($query,$order_by_def,$order_by_arr);
        //file_put_contents($file, $log , FILE_APPEND | LOCK_EX);
        $data = array();
        $i = $_POST["start"]+1;
        foreach($data_list as $row)
        {
            $sub_array = array();
            $sub_array[] = $i++;
            $action = '<a href="'.base_url().'master/videoview/'.$row->id.'" target="_blank" class="btn btn-primary btn-sm"><i class="fas fa-video" ></i> Join</a>';
            $link = base_url().'master/videoview/'.$row->id;
            $sub_array[] = $action;
            $sub_array[] = $link;
            $sub_array[] = $row->name;
            $sub_array[] = $row->email;
            $sub_array[] = $row->mobile;
            $data[] = $sub_array;
        }
        $_POST["length"] = -1;
        $members = $this->master_db->run_manual_query_result($query);
        $total = count($members);
        $output = array(
            "draw"              =>  intval($_POST["draw"]),
            "recordsTotal"      =>  $total,
            "recordsFiltered"   =>  $total,//$this->master_db->get_filtered_data("guards")
            "data"              =>  $data
        );
        echo json_encode($output);
    }
    public function videoview() {
        $id = $this->uri->segment(3);
        $this->data['gettokens'] = $this->master_db->getRecords('videoapi',['id'=>$id],'webtoken,appid,wuid,channelname');
        $this->load->view('videoview',$this->data);
    }
    public function orders() {
        $this->load->view('orders',$this->data);
    }
    public function ordersList(){
        $det = $this->data['detail'];
        $where = "where status !=-1";
        if(isset($_POST["search"]["value"]) && !empty($_POST["search"]["value"]) )
            { 
                $val    = trim($_POST["search"]["value"]);
                $where .= " and (name like '%$val%') ";
                $where .= " or (mobile like '%$val%')  ";
            }
            $order_by_arr[] = "name";
            $order_by_arr[] = "";
            $order_by_arr[] = "id";
            $order_by_def   = " order by id desc";
            $query = "select * from orders  $where";           
            $data_list = $this->master_db->rows_by_paginations($query,$order_by_def,$order_by_arr);
        //file_put_contents($file, $log , FILE_APPEND | LOCK_EX);
        $data = array();
        $i = $_POST["start"]+1;
        foreach($data_list as $row)
        {
            $sub_array = array();
            $address ="";
            $addr = json_decode($row->address,true);
            if(is_array($addr) && !empty($addr)) {
                $address .= "#".$addr['address']." ".$addr['city']." ".$addr['district']." ".$addr['state']." ".$addr['country'];
            }else {
                $address .= "";
            }
            
            //echo "<pre>";print_r($addr);exit;
            $sub_array[] = $i++;
              $action = '<a href="'.base_url().'master/viewOrders/'.$row->id.'" target="_blank" class="btn btn-primary btn-sm"><i class="fas fa-eye" ></i></a>';
              $link = base_url().'master/videoview/'.$row->id;
            // $sub_array[] = $action;
            $sub_array[] = $row->orderno;
            $sub_array[] = $row->name;
            $sub_array[] = $row->mobile;
            $sub_array[] = $row->gender;
            $sub_array[] = $row->age;
            $sub_array[] = $row->total_amount;
            $sub_array[] = $row->coupon_amount;
            $sub_array[] = $row->paymode;
            $sub_array[] = $address;
            $data[] = $sub_array;
        }
        $_POST["length"] = -1;
        $members = $this->master_db->run_manual_query_result($query);
        
        $total = count($members);
        $output = array(
            "draw"              =>  intval($_POST["draw"]),
            "recordsTotal"      =>  $total,
            "recordsFiltered"   =>  $total,//$this->master_db->get_filtered_data("guards")
            "data"              =>  $data
        );
        echo json_encode($output);
    }
    public function editpartner() {
        $id = $_GET['id'];
          $this->data['state'] = $this->master_db->getRecords('states',array('status'=>1),"id,name,state_code",'name asc');
        $this->data['district'] = $this->master_db->getRecords('districts',array('status'=>1),"id,name",'name asc');
        $this->data['taluk'] = $this->master_db->getRecords('cities',array('status'=>1),"id,name",'name asc');
        $this->data['countries'] = $this->master_db->getRecords('countries',array('status'=>1),"id,name",'name asc');
        $this->data['partners'] = $this->master_db->getRecords('partners',['id'=>$id],'id,type,company_name,company_type,gst_no,doc_type,company_doc');
        $this->data['partnerpersonal'] = $this->master_db->getRecords('partner_personal',['partner_id'=>$id],'id,fullname,contactno,emailid,dob,bloodgroup,address,country_id,region_id,state_id,district_id,taluk_id,city_id,pincode,photo,kyc_type,kyc_doc');
        $this->data['partnerpay'] = $this->master_db->getRecords('partner_payment',['partner_id'=>$id],'payment_id,cheque_no,bank_name,branch_name');
        $this->load->view('masters/edit_partner',$this->data);

    }
    public function savePartners() {
       //echo "<pre>";print_r($_POST);print_r($_FILES);exit;
      
                $result = array('status'=>'failure','msg'=>'Required fields are missing.');
        if( !empty($_POST['type']) && !empty($_POST['company_name']) && !empty($_POST['company_type']) 
            && !empty($_POST['doc_type']) && !empty($_POST['name']) 
            && !empty($_POST['phone']) && !empty($_POST['email']) && !empty($_POST['dob']) && !empty($_POST['bloodgroup'])
            && !empty($_POST['address']) && !empty($_POST['country']) /*&& !empty($_POST['state']) && !empty($_POST['district']) && !empty($_POST['taluk'])*/
            && !empty($_POST['pincode']) && !empty($_POST['kyc_type']) && !empty($_POST['payment_mode']) && !empty($_POST['agree'])
             && !empty($_POST['pcountry']) && !empty($_POST['pstate'])
            
            ){
              $pid = $this->input->post('pid');
             $phones = trim(preg_replace('!\s+!', '',$this->input->post('phone', true)));
            
            $type = trim(preg_replace('!\s+!', '',$this->input->post('type', true)));
            $country = trim(preg_replace('!\s+!', '',$this->input->post('country', true)));
            $region = $state = $district = $taluk = 0;
            // if( intval($type) == 1 ){
            //     $check = $this->master_db->getRecords('partners',array('type'=>$type,'status !='=>-1),'id');
            //     if(count($check)){
            //         $result = array('status'=>'failure','msg'=>'Country partner already exists.');
            //         echo json_encode($result);exit;
            //     }
            // }

            if($type == 1 ){
                $condition = "p.type=".$type." and pp.country_id = ".$country." and p.status != -1";
            }else if($type == 2 ){
                $region = trim(preg_replace('!\s+!', '',$this->input->post('region', true)));
                $condition = "p.type=".$type." and pp.country_id = ".$country." and pp.region_id = ".$region." and p.status != -1";
            }else if($type == 3 ){
                $state = trim(preg_replace('!\s+!', '',$this->input->post('state', true)));
                $condition = "p.type=".$type." and pp.country_id = ".$country." 
                            and pp.state_id = ".$state." and p.status != -1";
            }else if($type == 4 ){
                $state = trim(preg_replace('!\s+!', '',$this->input->post('state', true)));
                $district = trim(preg_replace('!\s+!', '',$this->input->post('district', true)));
                $condition = "p.type=".$type." and pp.country_id = ".$country." 
                            and pp.state_id = ".$state." and pp.district_id = ".$district." and p.status != -1";
            }else if( $type == 5 || $type == 6 ){
                $state = trim(preg_replace('!\s+!', '',$this->input->post('state', true)));
                $district = trim(preg_replace('!\s+!', '',$this->input->post('district', true)));
                $taluk = trim(preg_replace('!\s+!', '',$this->input->post('taluk', true)));
                $condition = "p.type=".$type." and pp.country_id = ".$country." 
                            and pp.state_id = ".$state." and pp.district_id = ".$district." and pp.taluk_id = ".$taluk." and p.status != -1";
            }
            $check = $this->app_db->checkPartner($condition);
            $mob = $this->master_db->getRecords('partner_personal',['contactno'=>$phones],'*');
            // if( count($check) ){ 
            //     $result = array('status'=>'failure','msg'=>'Channel partner type already exists.');
            //     echo json_encode($result);exit;
            // }

            //  if( count($mob) ){ 
            //     $result = array('status'=>'failure','msg'=>'Mobile number already exists.');
            //     echo json_encode($result);exit;
            // }
            
            $company_name = trim($this->input->post('company_name'));
            $company_type = trim(preg_replace('!\s+!', '',$this->input->post('company_type', true)));
            $gst_no = trim(preg_replace('!\s+!', '',$this->input->post('gst_no', true)));
            $doc_type = trim(preg_replace('!\s+!', '',$this->input->post('doc_type', true)));
            $name = trim($this->input->post('name'));
            $phone = trim(preg_replace('!\s+!', '',$this->input->post('phone', true)));
            $email = trim(preg_replace('!\s+!', '',$this->input->post('email', true)));
            $dob = trim(preg_replace('!\s+!', '',$this->input->post('dob', true)));
            $bloodgroup = trim(preg_replace('!\s+!', '',$this->input->post('bloodgroup', true)));
            $address = trim(html_escape($this->input->post('address', true)));
            
            $district = trim(preg_replace('!\s+!', '',$this->input->post('district', true)));
            $taluk = trim(preg_replace('!\s+!', '',$this->input->post('taluk', true)));
            $pincode = trim(preg_replace('!\s+!', '',$this->input->post('pincode', true)));
            $kyc_type = trim(preg_replace('!\s+!', '',$this->input->post('kyc_type', true)));
            $payment_mode = trim(preg_replace('!\s+!', '',$this->input->post('payment_mode', true)));
            $agree = trim(preg_replace('!\s+!', '',$this->input->post('agree', true)));

            $pcountry = trim(preg_replace('!\s+!', '',$this->input->post('pcountry', true)));
            $pstate = trim(preg_replace('!\s+!', '',$this->input->post('pstate', true)));
            
            $cheque_no = $cheque_date = $bank_name = $branch_name = $utr_no = '';
            if( intval($payment_mode) == 1 && ( empty($_POST['cheque_no']) || empty($_POST['cheque_date'])
                || empty($_POST['bank_name']) || empty($_POST['branch_name']) ) ){
                echo json_encode($result);exit;
            }else{
                $cheque_no = trim(preg_replace('!\s+!', '',$this->input->post('cheque_no', true)));
                $cheque_date = trim(preg_replace('!\s+!', '',$this->input->post('cheque_date', true)));
                $bank_name = trim(preg_replace('!\s+!', '',$this->input->post('bank_name', true)));
                $branch_name = trim(preg_replace('!\s+!', '',$this->input->post('branch_name', true)));
            }

            if( intval($payment_mode) == 3 && empty($_POST['utr_no']) ){
                echo json_encode($result);exit;
            }else{
                $utr_no = trim(preg_replace('!\s+!', '',$this->input->post('utr_no', true)));
            }

            if( intval($type) > 6 ){
                $result = array('status'=>'failure','msg'=>'Invalid channel partner.');
                echo json_encode($result);exit;
            }
            
            $checkCode = $this->master_db->getRecords('partners',"status != -2",'count(id) as id');
            $code = CODE_PREFIX;
            switch(intval($type)){
                case 1: $code = $code.'CP'.sprintf('%02d', $checkCode[0]->id+1);break;
                case 2: $code = $code.'ST'.sprintf('%02d', $checkCode[0]->id+1);break;
                case 3: $code = $code.'CF'.sprintf('%02d', $checkCode[0]->id+1);break;
                case 4: $code = $code.'DIS'.sprintf('%02d', $checkCode[0]->id+1);break;
                case 5: $code = $code.'DE'.sprintf('%02d', $checkCode[0]->id+1);break;
                case 6: $code = $code.'RE'.sprintf('%02d', $checkCode[0]->id+1);break;
                default: break;
            }

            $partners = array(
                'type'  =>  $type,
                'code'  =>  $code,
                'company_name'  =>  $company_name,
                'company_type'  =>  $company_type,
                'gst_no'        =>  $gst_no,
                'doc_type'      =>  $doc_type,
                'updated_at'    =>  date('Y-m-d H:i:s')
            );
            //echo '<pre>';print_r($partners);exit;
            if( !empty($_FILES['document']['name']) ){
                $config = array();
                $config['upload_path'] = '../app_assets/channel_partner/company_doc/';  
                $config['allowed_types'] = 'pdf|jpeg|jpg|png';
                $config['max_size'] = 0;    
                // I have chosen max size no limit 
                //$new_name = $code.'_'. $_FILES["document"]['name']; 
                $ext = pathinfo($_FILES["document"]['name'], PATHINFO_EXTENSION);
                $new_name = $code.'.'.$ext; 

                $config['file_name'] = $new_name;
                //Stored the new name into $config['file_name']
                $this->load->library('upload', $config);
                if (!$this->upload->do_upload('document') && !empty($_FILES['document']['name'])) {
                    $error = array('error' => $this->upload->display_errors());
                    //echo '<pre>';print_r($error);exit;
                } else {
                    $upload_data = $this->upload->data();
                    //echo '<pre>';print_r($upload_data);exit;
                    $partners['company_doc'] = 'channel_partner/company_doc/'.$upload_data['file_name'];
                }
            }
            //echo '<pre>';print_r($partners);exit;
            $partner_id = $this->master_db->updateRecord('partners',$partners,['id'=>$pid]);

            $partner_location = array(
                    'country_id'    =>  $pcountry,
                    'state_id'      =>  $pstate,
                );
                $this->master_db->updateRecord('partner_location',$partner_location,['partner_id'=>$pid]);

                $partner_personal = array(
                    'fullname'      =>  $name,
                    'contactno'     =>  $phone,
                    'emailid'       =>  $email,
                    'dob'           =>  date('Y-m-d',strtotime($dob)),
                    'bloodgroup'    =>  $bloodgroup,
                    'address'       =>  $address,
                    //'city_id'       =>  $district,
                    'pincode'       =>  $pincode,
                    'state_id'      =>  $state,
                    'district_id'   =>  $district,
                    'taluk_id'      =>  $taluk,
                    'country_id'    =>  $country,
                    'kyc_type'      =>  $kyc_type,
                );

                if( !empty($_FILES['photo']['name']) ){
                    $config2 = array();
                    $config2['upload_path'] = '../app_assets/channel_partner/photo/';  
                    $config2['allowed_types'] = 'jpeg|jpg|png';
                    $config2['max_size'] = 100;    
                    // I have chosen max size no limit 
                    //$new_name = $code.'_'. $_FILES["photo"]['name']; 
                    $ext = pathinfo($_FILES["photo"]['name'], PATHINFO_EXTENSION);
                    $new_name = $code.'.'.$ext; 
                    $config2['file_name'] = $new_name;
                    
                    //Stored the new name into $config['file_name']
                    $this->load->library('upload', $config2);
                    // Alternately you can set
                    $this->upload->initialize($config2);
                    if (!$this->upload->do_upload('photo') && !empty($_FILES['photo']['name'])) {
                        $error = array('error' => $this->upload->display_errors());
                        //print_r($error);exit;
                    } else {
                        $upload_data = $this->upload->data();
                        $partner_personal['photo'] = 'channel_partner/photo/'.$upload_data['file_name'];
                        //print_r($upload_data);exit;
                    }
                }

                if( !empty($_FILES['kyc_doc']['name']) ){
                    $config3 = array();
                    $config3['upload_path'] = '../app_assets/channel_partner/kyc/';  
                    $config3['allowed_types'] = 'jpeg|jpg|png';
                    $config3['max_size'] = 0;    
                    // I have chosen max size no limit 
                    //$new_name = $code.'_'. $_FILES["kyc_doc"]['name']; 
                    $ext = pathinfo($_FILES["kyc_doc"]['name'], PATHINFO_EXTENSION);
                    $new_name = $code.'.'.$ext; 
                    $config3['file_name'] = $new_name;
                    //Stored the new name into $config['file_name']
                    $this->load->library('upload', $config3);
                    $this->upload->initialize($config3);
                    if (!$this->upload->do_upload('kyc_doc') && !empty($_FILES['kyc_doc']['name'])) {
                        //$error = array('error' => $this->upload->display_errors());
                    } else {
                        $upload_data = $this->upload->data();
                        $partner_personal['kyc_doc'] = 'channel_partner/kyc/'.$upload_data['file_name'];
                    }
                }
                //echo '<pre>';print_r($partner_personal);exit;
                $this->master_db->updateRecord('partner_personal',$partner_personal,['partner_id'=>$pid]);

                $partner_payment = array(
                    'payment_id'    =>  $payment_mode,
                    'cheque_no'     =>  $cheque_no,
                    'cheque_date'   =>  date('Y-m-d',strtotime($cheque_date)),
                    'bank_name'     =>  $bank_name,
                    'branch_name'   =>  $branch_name,
                    'utr_no'        =>  $utr_no,
                );
                $this->master_db->updateRecord('partner_payment',$partner_payment,['partner_id'=>$pid]);
                $result = array('status'=>'success','msg'=>'Updated successfully.','partner_id'=>$partner_id);
        }
        //echo "Test";exit;
        echo json_encode($result);
    }
        public function diagnostic() {
        $this->load->view('masters/diagnostic',$this->data);
    }
    public function diagnosticList(){
        $det = $this->data['detail'];
        $data_list = $this->master_db->getDiagnosticList($det);
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
        $members = $this->master_db->getDiagnosticList($det);
        
        $total = count($members);
        $output = array(
            "draw"              =>  intval($_POST["draw"]),
            "recordsTotal"      =>  $total,
            "recordsFiltered"   =>  $total,//$this->master_db->get_filtered_data("guards")
            "data"              =>  $data
        );
        echo json_encode($output);
    }
        public function saveDiagnostic(){
        $det = $this->data['detail'];
        if( !empty($_POST['name']) && !empty($_POST['cat_id']) ){
            $id = trim(preg_replace('!\s+!', ' ',html_escape($this->input->post('cat_id', true))));
            $name = trim(preg_replace('!\s+!', ' ',html_escape($this->input->post('name', true))));
            $where = array(
                'id != '    =>  $id,        
                'name'      =>  $name,
                'status != '=>  -1
            );
            $check = $this->master_db->getRecords('diagnostic_category',$where,'id');
            if( count($check) == 0 ){
                $update_data = array(
                    'name'          =>  $name,
                    'modified_at'    =>  date('Y-m-d H:i:s'),
                );
                $this->master_db->updateRecord('diagnostic_category',$update_data,array('id'=>$id));
                echo 1;
            }else{
                echo "Diagnostic category already exists.";
            }
        }else if( !empty($_POST['name']) ){
            $name = trim(preg_replace('!\s+!', ' ',html_escape($this->input->post('name', true))));
            $where = array(
                'name'      =>  $name,
                'status != '=>  -1
            );
            $check = $this->master_db->getRecords('diagnostic_category',$where,'id');
            if( count($check) == 0 ){
                $insert_data = array(
                    'name'          =>  $name,
                    'created_at'    =>  date('Y-m-d H:i:s'),
                    'status'        =>  1,
                );
                $id = $this->master_db->insertRecord('diagnostic_category',$insert_data);
                echo 1;
            }else{
                echo "Diagnostic categor already exists.";
            }
        }
    }
     public function setDiagnosticStatus(){
        $det = $this->data['detail'];
        $id = trim($this->input->post('id'));
        $status = trim($this->input->post('status'));
        if($status ==-1) {
            $this->master_db->deleterecord('diagnostic_category',['id'=>$id]);
        }
        $where_data = array(
            'status'=>$status,
            'modified_at'=>date('Y-m-d H:i:s'),
        );
        $this->master_db->updateRecord('diagnostic_category',$where_data,array('id'=>$id));
        echo 1;
    }
     public function getDiagnosticCategory($id = ''){
        $det = $this->data['detail'];
        if( $id != '' ){
            $where = array(
                'id'        =>  $id,
                'status != '=>  -1
            );
            $check = $this->master_db->getRecords('diagnostic_category',$where,'id,name');
            if( count($check) == 0 ){
                echo json_encode(array('status'=>'fail'));
            }else{
                echo json_encode(array('status'=>'success','data'=>$check[0]));
            }
        }
    }
}
?>