<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Settings extends CI_Controller {   
 /**
     * Index Page for this controller.
     *     * Maps to the following URL
     *         http://example.com/index.php/pthome
     *    - or -  
     *         http://example.com/index.php/blueadmission/index
     *    - or -
     * Since this controller is set as the default controller in 
     * config/routes.php, it's displayed at http://example.com/
     *
     * So any other public methods not prefixed with an underscore will
     * map to /index.php/pthome
     <method_name>
     * @see http://codeigniter.com/user_guide/general/urls.html
     */    
	
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
        echo "Invalid access";
    }

    public function check_out_setting(){
		$this->data['info']=$this->master_db->getRecords('checkout_settings');
        $this->load->view('settings/check_out_setting',$this->data);
    }
	
	public function save_checkout_settings()
	{
        $shipping_address = trim(preg_replace('!\s+!', ' ',html_escape($this->input->post('shipping_address', true))));
        $whatsapp = trim(preg_replace('!\s+!', ' ',html_escape($this->input->post('whatsapp', true))));
        //echo '<pre>';print_r($_POST);exit;
        
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
			$user =	$this->data['user'] = $this->master_db->getRecords("checkout_settings");
			$db = array(
				'shipping_address' => $shipping_address,
				'whatsapp' => $whatsapp,
				'order_msg' => $this->input->post('order_msg'),
				'min_order_amt' => $this->input->post('min_order_amt'),
				'min_order_qty' => $this->input->post('min_order_qty'),
			);
			//print_r($db);exit;
            if(is_array($user)){
                $res = $this->master_db->updateRecord('checkout_settings',$db,array('id'=>1));
            }else{
                $res = $this->master_db->insertRecord('checkout_settings',$db);
            }
			redirect(base_url() . 'settings/check_out_setting');			
		}
	}
	
	public function inventory_setting(){
		$this->data['info']=$this->master_db->getRecords('inventory_settings');
        $this->load->view('settings/inventory_setting_view',$this->data);
    }
    
    public function save_inventory_setting()
	{
        //echo '<pre>';print_r($_POST);exit;
		$show_out_of_stock = trim(preg_replace('!\s+!', ' ',html_escape($this->input->post('show_out_of_stock', true))));
		$order_out_of_stock = trim(preg_replace('!\s+!', ' ',html_escape($this->input->post('order_out_of_stock', true))));
		$track_inventory = trim(preg_replace('!\s+!', ' ',html_escape($this->input->post('track_inventory', true))));
		$auto_reduce = trim(preg_replace('!\s+!', ' ',html_escape($this->input->post('auto_reduce', true))));
		
		if ($_SERVER['REQUEST_METHOD'] == 'POST') {
			$user =	$this->data['user'] = $this->master_db->getRecords("inventory_settings");
			$db = array(
				'show_out_of_stock' => $show_out_of_stock,
				'order_out_of_stock' => $order_out_of_stock,
				'track_inventory' => $track_inventory,
				'auto_reduce' => $auto_reduce,
			);
            
            if(is_array($user)){
                $res = $this->master_db->updateRecord('inventory_settings',$db,array('id'=>1));
            }else{
                $res = $this->master_db->insertRecord('inventory_settings',$db);
            }
			redirect(base_url() . 'settings/inventory_setting');
			
		}
	}
   
	public function tax_master(){
		$this->data['info']=$this->master_db->getRecords('tax_master');
        $this->load->view('settings/tax_master',$this->data);
    }

    public function tax_masterList(){
        $det = $this->data['detail'];
        $data_list = $this->master_db->gettax_masterList($det);
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
            $sub_array[] = $row->type;
            $sub_array[] = $row->percent;
            $sub_array[] = $status;
            $data[] = $sub_array;
            
        }
        $_POST["length"] = -1;
        $members = $this->master_db->gettax_masterList($det);        
        $total = count($members);
        $output = array(
            "draw"              =>  intval($_POST["draw"]),
            "recordsTotal"      =>  $total,
            "recordsFiltered"   =>  $total,//$this->master_db->get_filtered_data("guards")
            "data"              =>  $data
        );
        echo json_encode($output);
    }

    public function savetax_settings(){
        $det = $this->data['detail'];

        if( !empty($_POST['type']) && !empty($_POST['id'])){
            $id = trim(preg_replace('!\s+!', ' ',html_escape($this->input->post('id', true))));
            $percent = trim(preg_replace('!\s+!', ' ',html_escape($this->input->post('percent', true))));
            $default_tax = trim(preg_replace('!\s+!', ' ',html_escape($this->input->post('default_tax', true))));
            $type = trim(preg_replace('!\s+!', ' ',html_escape($this->input->post('type', true))));
            $where = array(
                'id != '    =>  $id,        
                'type'      =>  $type,
                'percent'      =>  $percent,
                'default_tax'      =>  $default_tax,
                'status != '=>  -1
            );
            $check = $this->master_db->getRecords('tax_master',$where,'id');
            if( count($check) == 0 ){
                $update_data = array(
                     'type'      =>  $type,
					'percent'      =>  $percent,
					'default_tax'      =>  $default_tax,
                    'updated_at' =>  date('Y-m-d H:i:s'),
                    'updated_by'   =>  $det[0]->id
                );
                $this->master_db->updateRecord('tax_master',$update_data,array('id'=>$id));
                echo 1;
            }else{
                echo "Tax Master already exists.";
            }
        }else if( !empty($_POST['name'])){
            $name = trim(preg_replace('!\s+!', ' ',html_escape($this->input->post('name', true))));
            $where = array(
				'type'      =>  $type,
                'percent'      =>  $percent,
                'default_tax'      =>  $default_tax,
                'status != '=>  -1
            );
            $check = $this->master_db->getRecords('tax_master',$where,'id');
            if( count($check) == 0 ){
                $insert_data = array(
                    'type'      =>  $type,
					'percent'      =>  $percent,
					'default_tax'      =>  $default_tax,
                    'created_at'  =>  date('Y-m-d H:i:s'),
                    'status'        =>  1,
                );
                $this->master_db->insertRecord('tax_master',$insert_data);
                echo 1;
            }else{
                echo "Tax Master already exists.";
            }
        }
    }

    public function settax_masterStatus(){

        $det = $this->data['detail'];
        $id = trim($this->input->post('id'));
        $status = trim($this->input->post('status'));

        $where_data = array(
            'status'=>$status,
            'updated_at'=>date('Y-m-d H:i:s'),
            'updated_by'=>$det[0]->id
        );
        $this->master_db->updateRecord('tax_master',$where_data,array('id'=>$id));
        echo 1;
    }

    public function gettax_master($id = ''){
        $det = $this->data['detail'];
        if( $id != '' ){
            $where = array(
                'id'        =>  $id,
                'status != '=>  -1
            );
            $check = $this->master_db->getRecords('tax_master',$where,'id,type,percent,default_tax');
            if( count($check) == 0 ){
                echo json_encode(array('status'=>'fail'));
            }else{
                echo json_encode(array('status'=>'success','data'=>$check[0]));
            }
        }
    }
	public function payment_gateway(){
        $this->load->view('settings/payment_gateway_view',$this->data);
    }
	
	 public function payment_gatewayList(){
        $det = $this->data['detail'];
        $data_list = $this->master_db->getpayment_gatewayList($det);
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
           // $action = '<button type="button" title="Edit" name="update" onclick="modifyRow('.$row->id.');" class="btn btn-primary btn-sm"><i class="fas fa-edit"></i></button>&nbsp;';
            $action ="";
            if( (int)$row->status == 1 ){
                $status = "<span class='text-success'><i class='fas fa-check'></i> Allow</span>";
                $action .= "<button title='Deactive' onclick='updateStatus(".$row->id.", 0)' class='btn btn-warning btn-sm'><i class='fas fa-times-circle'></i></button>&nbsp;";
            }else{
                $status = "<span class='text-warning'><i class='fas fa-times-circle'></i> Not Allow</span>";
                $action .= "<button title='Activate' onclick='updateStatus(".$row->id.", 1)' class='btn btn-success btn-sm'><i class='fas fa-check'></i></button>&nbsp;";
            }
            $action .= "<button title='Delete' onclick='updateStatus(".$row->id.", -1)' class='btn btn-danger btn-sm'><i class='fas fa-trash'></i></button>&nbsp;";
            $sub_array[] = $action;
            $sub_array[] = $row->name;
            $sub_array[] = $status;
            $data[] = $sub_array;
            
        }
        $_POST["length"] = -1;
        $members = $this->master_db->getpayment_gatewayList($det);
        
        $total = count($members);
        $output = array(
            "draw"              =>  intval($_POST["draw"]),
            "recordsTotal"      =>  $total,
            "recordsFiltered"   =>  $total,//$this->master_db->get_filtered_data("guards")
            "data"              =>  $data
        );
        echo json_encode($output);
    }
	
	
    public function setpaymentStatus(){

        $det = $this->data['detail'];
        $id = trim($this->input->post('id'));
        $status = trim($this->input->post('status'));

        $where_data = array(
            'status'=>$status,
            'updated_at'=>date('Y-m-d H:i:s'),
            'updated_by'=>$det[0]->id
        );
        $this->master_db->updateRecord('payment_gateway',$where_data,array('id'=>$id));
        echo 1;
    }
	public function company(){
		$this->data['info']=$this->master_db->getRecords('company_detail');
        $this->load->view('settings/company_view',$this->data);
    }
	  public function save_company()
	{
		$name = trim(preg_replace('!\s+!', ' ',html_escape($this->input->post('name', true))));
		$address = trim(preg_replace('!\s+!', ' ',html_escape($this->input->post('address', true))));
		$phone_no = trim(preg_replace('!\s+!', ' ',html_escape($this->input->post('phone_no', true))));
		$email = trim(preg_replace('!\s+!', ' ',html_escape($this->input->post('email', true))));
	
		if ($_SERVER['REQUEST_METHOD'] == 'POST') {
			$user =	$this->data['user'] = $this->master_db->getRecords("company_detail");
			$db = array(
				'name' => $name,
				'address' => $address,
				'phone_no' => $phone_no,
				'email' => $email,
			);
             if(is_array($user)){
                $res = $this->master_db->updateRecord('company_detail',$db,array('id'=>1));
            }
            else{
                $res = $this->master_db->insertRecord('company_detail',$db);
            }
			redirect(base_url() . 'settings/company');
			
		}
	}
}

?>