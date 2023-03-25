<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
//error_reporting(E_ALL);ini_set('display_errors', '1');
class Pin extends CI_Controller {   

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
        $this->load->model('pin_db');
        
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
        $det = $this->data['detail'];
        $this->data['category'] = $this->master_db->getRecords('category',array('status!='=>-1),'id,name,is_package,type');
        $this->load->view('pins/pins',$this->data);
    }

    public function pinList(){
        $det = $this->data['detail'];
        $data_list = $this->pin_db->getPinList($det);
        //echo $this->db->last_query();echo '<pre>';print_r($data_list);exit;
        $data = array();
        $i = $_POST["start"]+1;
        
        foreach($data_list as $row)
        {   
            $name = '';
            switch($row->type){
                case 1: $name = $row->package;break;
                case 2: $name = $row->service;break;
                case 3: $name = $row->item;break;
                default:$name = '';
            }
            $sub_array = array();
            $sub_array[] = $i++;
            $action = '<button type="button" title="View Transactions" name="update" onclick="viewDetail('.$row->id.');" class="btn btn-primary btn-sm"><i class="fas fa-eye"></i></button>&nbsp;';
            $sub_array[] = $action;
            $sub_array[] = $row->pintype;
            $sub_array[] = $name;            
            $sub_array[] = $row->qty;
            $data[] = $sub_array;
            
        }
        $_POST["length"] = -1;
        $members = $this->pin_db->getPinList($det);
        
        $total = count($members);
        $output = array(
            "draw"              =>  intval($_POST["draw"]),
            "recordsTotal"      =>  $total,
            "recordsFiltered"   =>  $total,//$this->master_db->get_filtered_data("guards")
            "data"              =>  $data
        );
        echo json_encode($output);
    }

    public function savepin(){
        $det = $this->data['detail'];
        if( $_SERVER['REQUEST_METHOD'] == 'GET' ){
            $this->data['category'] = $this->master_db->getRecords('category',array('status!='=>-1),'id,name,is_package,type');
            $this->load->view('pins/save_pin',$this->data);
        }else if($_SERVER['REQUEST_METHOD'] == 'POST' && !empty($_POST['type'])){
            $type = trim(preg_replace('!\s+!', ' ',html_escape($this->input->post('type', true))));
            $insert = array('type'=>$type);
            if( intval($type) == 1 ){
                $package_id = trim(preg_replace('!\s+!', ' ',html_escape($this->input->post('package_id', true))));
                $qty = trim(preg_replace('!\s+!', ' ',html_escape($this->input->post('qty', true))));
                $condition = "type = 1 and package_id=".$package_id." and status = 1";
                $check = $this->master_db->getRecords('pins',$condition,'id,qty');
                $pin_id = 0;

                $package = $this->master_db->getRecords('packages',"id=".$package_id,'id,cat_id');
                if(count($check)){
                    $pin_id = $check[0]->id;
                    $update = array(
                        'qty'           =>  ( intval($check[0]->qty) + intval($qty)),
                        'updated_by'    =>  $det[0]->id,
                        'updated_at'    =>  date('Y-m-d H:i:s')
                    );
                    $this->master_db->updateRecord('pins',$update,array('id'=>$pin_id));
                }else{
                    $insert = array(
                        'cat_id'        =>  $package[0]->cat_id,
                        'type'          =>  $type,
                        'package_id'    =>  $package_id,
                        'qty'           =>  $qty,
                        'status'        =>  1,
                        'created_by'    =>  $det[0]->id,
                        'created_at'    =>  date('Y-m-d H:i:s')
                    );
                    $pin_id = $this->master_db->insertRecord('pins',$insert);
                }

                $insert = array(
                    'pin_id'    =>  $pin_id,
                    'action'    =>  1,
                    'qty'       =>  $qty,
                    'created_by'=>  $det[0]->id,
                    'created_at'=>  date('Y-m-d H:i:s')
                );
                $this->master_db->insertRecord('pin_history',$insert);
                echo 1;
            }else if( intval($type) == 2 ){
                //echo '<pre>';print_r($_POST);exit;
                $cat_id = trim(preg_replace('!\s+!', ' ',html_escape($this->input->post('cat_id', true))));
                $subcat_id = trim(preg_replace('!\s+!', ' ',html_escape($this->input->post('subcat_id', true))));
                $service_id = trim(preg_replace('!\s+!', ' ',html_escape($this->input->post('service_id', true))));
                $qty = trim(preg_replace('!\s+!', ' ',html_escape($this->input->post('qty', true))));
                $condition = "type = 1 and cat_id=".$cat_id." and subcat_id=".$subcat_id." and service_id=".$service_id." and status = 1";
                $check =$this->master_db->getRecords('pins',$condition,'id,qty');
                $pin_id = 0;
                if(count($check)){
                    $pin_id = $check[0]->id;
                    $update = array(
                        'qty'           =>  ( intval($check[0]->qty) + intval($qty)),
                        'updated_by'    =>  $det[0]->id,
                        'updated_at'    =>  date('Y-m-d H:i:s')
                    );
                    $this->master_db->updateRecord('pins',$update,array('id'=>$pin_id));
                }else{
                    $insert = array(
                        'type'          =>  $type,
                        'cat_id'        =>  $cat_id,
                        'subcat_id'     =>  $subcat_id,
                        'service_id'    =>  $service_id,
                        'qty'           =>  $qty,
                        'status'        =>  1,
                        'created_by'    =>  $det[0]->id,
                        'created_at'    =>  date('Y-m-d H:i:s')
                    );
                    $pin_id = $this->master_db->insertRecord('pins',$insert);
                }
                $insert = array(
                    'pin_id'    =>  $pin_id,
                    'action'    =>  1,
                    'qty'       =>  $qty,
                    'created_by'=>  $det[0]->id,
                    'created_at'=>  date('Y-m-d H:i:s')
                );
                $this->master_db->insertRecord('pin_history',$insert);
                echo 1;
            }else if( intval($type) == 3 ){
                //echo '<pre>';print_r($_POST);exit;
                $cat_id = trim(preg_replace('!\s+!', ' ',html_escape($this->input->post('cat_id', true))));
                $subcat_id = trim(preg_replace('!\s+!', ' ',html_escape($this->input->post('subcat_id', true))));
                $item_id = trim(preg_replace('!\s+!', ' ',html_escape($this->input->post('item_id', true))));
                $qty = trim(preg_replace('!\s+!', ' ',html_escape($this->input->post('qty', true))));
                $condition = "type = 1 and cat_id=".$cat_id." and subcat_id=".$subcat_id." and item_id=".$item_id." and status = 1";
                $check =$this->master_db->getRecords('pins',$condition,'id,qty');
                $pin_id = 0;
                if(count($check)){
                    $pin_id = $check[0]->id;
                    $update = array(
                        'qty'           =>  ( intval($check[0]->qty) + intval($qty)),
                        'updated_by'    =>  $det[0]->id,
                        'updated_at'    =>  date('Y-m-d H:i:s')
                    );
                    $this->master_db->updateRecord('pins',$update,array('id'=>$pin_id));
                }else{
                    $insert = array(
                        'type'          =>  $type,
                        'cat_id'        =>  $cat_id,
                        'subcat_id'     =>  $subcat_id,
                        'item_id'       =>  $item_id,
                        'qty'           =>  $qty,
                        'status'        =>  1,
                        'created_by'    =>  $det[0]->id,
                        'created_at'    =>  date('Y-m-d H:i:s')
                    );
                    $pin_id = $this->master_db->insertRecord('pins',$insert);
                }
                $insert = array(
                    'pin_id'    =>  $pin_id,
                    'action'    =>  1,
                    'qty'       =>  $qty,
                    'created_by'=>  $det[0]->id,
                    'created_at'=>  date('Y-m-d H:i:s')
                );
                $this->master_db->insertRecord('pin_history',$insert);
                echo 1;
            }else{
                echo -1;
            }
        }else{
            echo 0;
        }        
    }

    public function getPackages(){
        //$data = $this->master_db->getRecords('packages',"status=1",'id,name');
        $data = $this->pin_db->getPackages();
        echo json_encode($data);
    }

    public function getPackagesPins(){
        $data = $this->pin_db->getPackagesPins();
        echo json_encode($data);
    }

    public function getServices(){
        $det = $this->data['detail'];
        $cat_id = trim(preg_replace('!\s+!', ' ',html_escape($this->input->post('cat_id', true))));
        $subcat_id = trim(preg_replace('!\s+!', ' ',html_escape($this->input->post('subcat_id', true))));
        if( $cat_id != '' && $subcat_id != '' ){
            $where = array(
                'cat_id'    =>  $cat_id,
                'subcat_id' =>  $subcat_id,
                'status'    =>  1
            );
            $check = $this->master_db->getRecords('services',$where,'id,name');
            if( count($check) == 0 ){
                echo json_encode(array('status'=>'fail'));
            }else{
                echo json_encode(array('status'=>'success','data'=>$check));
            }
        }
    }

    public function getItems(){
        $det = $this->data['detail'];
        $cat_id = trim(preg_replace('!\s+!', ' ',html_escape($this->input->post('cat_id', true))));
        $subcat_id = trim(preg_replace('!\s+!', ' ',html_escape($this->input->post('subcat_id', true))));
        if( $cat_id != '' && $subcat_id != '' ){
            $where = array(
                'cat_id'    =>  $cat_id,
                'subcat_id' =>  $subcat_id,
                'status'    =>  1
            );
            $check = $this->master_db->getRecords('items',$where,'id,name');
            if( count($check) == 0 ){
                echo json_encode(array('status'=>'fail'));
            }else{
                echo json_encode(array('status'=>'success','data'=>$check));
            }
        }
    }

    public function viewPinHistory(){
        $det = $this->data['detail'];
        $pin_id = 0;
        if( !empty($_POST['pin_id'])){
            $pin_id = trim(preg_replace('!\s+!', ' ',html_escape($this->input->post('pin_id', true))));
            $this->data['pin'] = $this->pin_db->getPin($pin_id);            
            $this->data['history'] = $this->pin_db->getPinHistory($pin_id);
            //echo $this->db->last_query();exit;
            //echo '<pre>';print_r($this->data['pin']);
            $this->load->view('pins/pin_history',$this->data);
        }else{
            echo 0;
        }
    }

    public function transfer(){
        $det = $this->data['detail'];
        $this->data['category'] = $this->master_db->getRecords('category',array('status!='=>-1),'id,name,is_package,type');
        $condition = "";
        $this->data['partners'] = $this->pin_db->getPartner($condition);
        $this->load->view('pins/pin_transfer',$this->data);
    }

    public function transfer_pin(){
        $det = $this->data['detail'];
        $condition = "";
        $this->data['partners'] = $this->pin_db->getPartner($condition);
        $this->data['category'] = $this->master_db->getRecords('category',array('status!='=>-1),'id,name,is_package,type');
        $this->load->view('pins/transfer_pin',$this->data);
    }

    public function pinTransferList(){
        $det = $this->data['detail'];
        $data_list = $this->pin_db->getTransferList($det);
        $data = array();
        $i = $_POST["start"]+1;
        
        foreach($data_list as $row){   
            $name = '';
            switch($row->type){
                case 1: $name = $row->package;break;
                case 2: $name = $row->service;break;
                case 3: $name = $row->item;break;
                default:$name = '';
            }
            $sub_array = array();
            $sub_array[] = $i++;
            $action = '<button type="button" title="View Invoice" name="update" onclick="viewInvoice('.$row->id.',1);" class="btn btn-primary btn-sm"><i class="fas fa-print"></i></button>&nbsp;';
            //$action .= '<button type="button" title="View Invoice" name="update" onclick="viewInvoice('.$row->id.',2);" class="btn btn-primary btn-sm"><i class="fas fa-file-pdf"></i></button>&nbsp;';
            $sub_array[] = $action;
            $sub_array[] = $row->txn_no;
            $sub_array[] = $row->partner_type;
            $sub_array[] = $row->code;
            $sub_array[] = $row->company_name;
            $sub_array[] = $row->pintype;
            $sub_array[] = $name;            
            $sub_array[] = $row->qty;
            $sub_array[] = $row->pin_amt;
            $sub_array[] = $row->total_amt;
            $sub_array[] = $row->created_at;
            $data[] = $sub_array;
            
        }
        $_POST["length"] = -1;
        $members = $this->pin_db->getTransferList($det);
        
        $total = count($members);
        $output = array(
            "draw"              =>  intval($_POST["draw"]),
            "recordsTotal"      =>  $total,
            "recordsFiltered"   =>  $total,//$this->master_db->get_filtered_data("guards")
            "data"              =>  $data
        );
        echo json_encode($output);
    }

    public function getPartners(){
        $det = $this->data['detail'];
        $partner_type = trim(preg_replace('!\s+!', ' ',html_escape($this->input->post('partner_type', true))));
        if( $partner_type != '' ){
            
            $condition = "p.type = ".$partner_type;
            $partners = $this->pin_db->getPartner($condition);
            //echo $this->db->last_query();exit;
            if( count($condition) == 0 ){
                echo json_encode(array('status'=>'fail'));
            }else{
                echo json_encode(array('status'=>'success','data'=>$partners));
            }
        }
    }

    public function getServicePins(){
        $det = $this->data['detail'];
        $cat_id = trim(preg_replace('!\s+!', ' ',html_escape($this->input->post('cat_id', true))));
        $subcat_id = trim(preg_replace('!\s+!', ' ',html_escape($this->input->post('subcat_id', true))));
        if( $cat_id != '' && $subcat_id != '' ){
            $condition = "";
            $check = $this->pin_db->getServicePins($condition);
            if( count($check) == 0 ){
                echo json_encode(array('status'=>'fail'));
            }else{
                echo json_encode(array('status'=>'success','data'=>$check));
            }
        }
    }

    public function getItemPins(){
        $det = $this->data['detail'];
        $cat_id = trim(preg_replace('!\s+!', ' ',html_escape($this->input->post('cat_id', true))));
        $subcat_id = trim(preg_replace('!\s+!', ' ',html_escape($this->input->post('subcat_id', true))));
        if( $cat_id != '' && $subcat_id != '' ){
            $condition = "";
            $check = $this->pin_db->getItemPins($condition);
            if( count($check) == 0 ){
                echo json_encode(array('status'=>'fail'));
            }else{
                echo json_encode(array('status'=>'success','data'=>$check));
            }
        }
    }

    public function savetransfer(){
        $det = $this->data['detail'];
        //echo '<pre>';print_r($_POST);exit;
        if($_SERVER['REQUEST_METHOD'] == 'POST' && !empty($_POST['type']) && !empty($_POST['partner_type']) 
            && !empty($_POST['partner_id']) && !empty($_POST['qty']) ){

            $type = trim(preg_replace('!\s+!', ' ',html_escape($this->input->post('type', true))));
            $partner_type = trim(preg_replace('!\s+!', ' ',html_escape($this->input->post('partner_type', true))));
            $partner_id = trim(preg_replace('!\s+!', ' ',html_escape($this->input->post('partner_id', true))));
            $qty = trim(preg_replace('!\s+!', ' ',html_escape($this->input->post('qty', true))));
            $package_id = trim(preg_replace('!\s+!', ' ',html_escape($this->input->post('package_id', true))));
            $service_id = trim(preg_replace('!\s+!', ' ',html_escape($this->input->post('service_id', true))));
            $item_id = trim(preg_replace('!\s+!', ' ',html_escape($this->input->post('item_id', true))));

            //echo '<pre>';print_r($_POST);exit;
            $partner_detail = $this->pin_db->getPartner("p.id=".$partner_id);
            $partner = $this->master_db->getRecords('partner_personal',array('partner_id'=>$partner_id),'contactno,fullname,emailid');
            $partnerCode = $this->master_db->getRecords('partners',array('id'=>$partner_id),'code');
            $package = $this->master_db->getRecords('packages',array('id'=>$package_id),'name'); 
            $template = $this->master_db->getRecords('templates',array('type'=>10),'id,sms_template,mail_template,label');
                //send sms
            $phone = "+91-9986880000";
            $mobileno = $partner[0]->contactno.","."9986880000";
                $this->load->library('SMS');
                $message = $template[0]->sms_template;
                $message = str_replace('{#no#}', $partnerCode[0]->code,$message);
                $message = str_replace('{#package#}',$package[0]->name,$message);
                $message = str_replace('{#date#}',date('d/m/Y'),$message);
                $message = str_replace('{#pins#}',$qty,$message);
                $message = str_replace('{#phone#}',$phone,$message);
                $message = str_replace('{#cpartner#}',"admin",$message);
                $this->sms->sendSmsToUser($message,$mobileno);

                 $this->load->library('Mail');
                // $message = $template[0]->mail_template;
                // $message = str_replace('{#no#}',rand(1234,9999),$message);
                // $message = str_replace('{#package#}',$package[0]->name,$message);
                // $message = str_replace('{#date#}',date('d/m/Y'),$message);
                // $message = str_replace('{#pins#}',$qty,$message);
                // $message = str_replace('{#phone#}',$phone,$message);
                 $messages = "Acct ".$partnerCode[0]->code." credited with ".$package[0]->name." LIFEON+ Pins from admin Available Bal Pins ".$qty." Nos. Contact us on ".$phone.". Regards, Team LIFEON+.";
                $this->data['company'] = $this->master_db->getRecords('company_detail',array('id'=>1),'name,address,phone_no,email,logo_link,website_url');
                $this->data['messagebody'] = $messages;
                $mailbody = $this->load->view('pin_mail_template',$this->data,true);
                $this->mail->send_sparkpost_attach($mailbody,array($partner[0]->emailid,'info@lifonplus.com'),$template[0]->label);
            if(count($partner_detail) == 0 ){ echo -3;exit; }

            $partner_location = $this->pin_db->getPartnerLocation("p.id=".$partner_id);
            if(count($partner_location) == 0 ){ echo -3;exit; }
            //echo '<pre>';print_r($partner_location);exit;
            $tax = $this->master_db->getRecords('tax',"id=1",'id,gst');

            $pin_amt = 0;
            $condition = "status = 1";
            if( intval($type) == 1 ){
                $condition .= " and package_id = ".$package_id;
                $package = $this->master_db->getRecords('packages',"id=".$package_id,'id,price');
                if(count($package)){ $pin_amt = $package[0]->price; }                
            }else if( intval($type) == 2 ){
                $condition .= " and service_id = ".$service_id;
                $services = $this->master_db->getRecords('services',"id=".$service_id,'id,price');
                if(count($services)){ $pin_amt = $services[0]->price; }
            }else if( intval($type) == 3 ){
                $condition .= " and item_id = ".$item_id;
                $item = $this->master_db->getRecords('items',"id=".$item_id,'id,price');
                if(count($item)){ $pin_amt = $item[0]->price; }
            }
            //echo $type.' - '.$pin_amt;exit;

            $checkPin = $this->master_db->getRecords('pins',$condition,'id,qty');
            if( count($checkPin) ){
                $tax_amt = 0;
                $txn_no = '';
                $code = $this->master_db->getRecords('system_codes',"id=1","id,prefix,ct_prefix,ct_no");
                $txn_no = $code[0]->prefix.$code[0]->ct_prefix;
                $txn_no .= sprintf('%02d', $code[0]->ct_no);
                $total_amt = ((int)$qty * (float)$pin_amt);
                $tax_amt = (($total_amt/100)*$tax[0]->gst);
                $grand_total = $total_amt + $tax_amt;
                $insert = array(
                    'txn_no'        =>  $txn_no,
                    'pin_id'        =>  $checkPin[0]->id,
                    'partner_id'    =>  $partner_id,
                    'qty'           =>  $qty,
                    'pin_amt'       =>  $pin_amt,
                    'gst'           =>  $tax_amt,
                    'gst_per'       =>  $tax[0]->gst,
                    'gst_type'      =>  $partner_location[0]->tax_type,
                    'total_amt'     =>  $total_amt,
                    'grand_total'   =>  $grand_total,
                    'status'        =>  1,
                    'created_by'    =>  $det[0]->id,
                    'created_at'    =>  date('Y-m-d H:i:s')
                );
                $txn_id = 0;
                //echo '<pre>';print_r($insert);exit;
                $txn_id = $this->master_db->insertRecord('company_transfers',$insert);

                $code[0]->ct_no = intval($code[0]->ct_no)+1;
                $this->master_db->updateRecord('system_codes',array('ct_no'=>$code[0]->ct_no,'id'=>1),array('id'=>1));

                $pin_history = array(
                    'pin_id'    =>  $checkPin[0]->id,
                    'action'    =>  2,
                    'qty'       =>  $qty,
                    'txn_id'    =>  $txn_id,
                    'created_by'=>  $det[0]->id,
                    'created_at'=>  date('Y-m-d H:i:s')
                );
                $this->master_db->insertRecord('pin_history',$pin_history);

                $update_pin = array(
                    'qty'       =>  ((int)$checkPin[0]->qty - (int)$qty),
                    'updated_by'=>  $det[0]->id,
                    'updated_at'=>  date('Y-m-d H:i:s')
                );
                $this->master_db->updateRecord('pins',$update_pin,array('id'=>$checkPin[0]->id));

                //move pin to partner account
                $condition = "partner_id = $partner_id and pin_id = ".$checkPin[0]->id." and status = 1";
                $checkpp = $this->master_db->getRecords('partner_pins',$condition,"id,pin_amt,total_amt,qty");
                $partner_pin_id = 0;
                if(count($checkpp)){
                    $partner_pin_id = $checkpp[0]->id;
                    $updateppin = array(
                        'pin_amt'   =>  $pin_amt,
                        'total_amt' =>  (float)$checkpp[0]->total_amt + $total_amt,
                        'qty'       =>  (int)$qty + (int)$checkpp[0]->qty,
                        'updated_by'=>  $det[0]->id,
                        'updated_at'=>  date('Y-m-d H:i:s')
                    );
                    $this->master_db->updateRecord('partner_pins',$updateppin,array('id'=>$partner_pin_id));
                }else{
                    $insert = array(
                        'partner_id'    =>  $partner_id,
                        'pin_id'        =>  $checkPin[0]->id,
                        'pin_amt'       =>  $pin_amt,
                        'total_amt'     =>  $total_amt,
                        'qty'           =>  $qty,
                        'status'        =>  1,
                        'created_by'    =>  $det[0]->id,
                        'created_at'    =>  date('Y-m-d H:i:s')
                    );
                    $partner_pin_id = $this->master_db->insertRecord('partner_pins',$insert);
                }

                $partner_history = array(
                    'txn_id'    =>  $txn_id,
                    'type'      =>  1,
                    'ttype'     =>  1,
                    'pin_id'    =>  $checkPin[0]->id,
                    'pin_amt'   =>  $pin_amt,
                    'gst'       =>  $tax_amt,
                    'gst_type'  =>  $partner_location[0]->tax_type,
                    'total_amt' =>  $total_amt,
                    'grand_total'   =>  $grand_total,
                    'qty'       =>  $qty,
                    'partner_id'=>  $partner_id,
                    'to_partner'=>  $partner_id,
                    'status'    =>  1,
                    'created_by'=>  $det[0]->id,
                    'created_at'=>  date('Y-m-d H:i:s')
                );
                //echo '<pre>';print_r($partner_history);exit;
                $this->master_db->insertRecord('partner_pin_transaction',$partner_history);
                //end pin moved to partnet account 
                echo 1;
            }else{
                echo -2;
            }
        }else{
            echo -1;
        }
    }

    public function view_transfer($id=''){
        $det = $this->data['detail'];
        if( $id != ''){
            $check = $this->master_db->getRecords('company_transfers',array('id'=>$id,'status'=>1),'id,pin_id,txn_no,partner_id,qty,pin_amt,gst,gst_per,gst_type,total_amt,grand_total,status,created_at');
            if(count($check)){
                $this->data['transfer'] = $check[0];
                $this->data['pin_detail'] = $pin_detail = $this->master_db->getRecords('pin_history',array('txn_id'=>$check[0]->id),'id,pin_id,action,qty,txn_id');
                $this->data['pin'] = $pin = $this->pin_db->getPin($pin_detail[0]->pin_id);
                $this->data['company'] = $company = $this->master_db->getRecords('company_detail',array('id'=>1),'*');
                $this->data['partner'] = $this->pin_db->getPartner("p.id=".$check[0]->partner_id);
                //echo '<pre>';print_r($pin);print_r($pin_detail);print_r($check);exit;
                $this->load->view('pins/pin_invoice',$this->data);                
            }else{
                $this->session->set_flashdata('message','<div class="alert alert-danger alert-dismissable"><button class="close" aria-hidden="true" data-dismiss="alert" type="button">&times;</button>No data found.</div>');
                redirect(base_url()."pin/transfer");
            }
            
        }
    }
    public function discountprice() {
        $dis = trim(preg_replace('!\s+!', ' ',html_escape($this->input->post('dis', true))));
        $tid = trim(preg_replace('!\s+!', ' ',html_escape($this->input->post('tid', true))));
         $check = $this->master_db->getRecords('company_transfers',array('id'=>$tid,'status'=>1),'id,pin_id,txn_no,partner_id,qty,pin_amt,gst,gst_per,gst_type,total_amt,grand_total,status,created_at');
         //echo "<pre>";print_r($check);exit;
         if(count($check)>0) {
                $this->data['discount'] = $dis;
                $this->data['transfer'] = $check[0];
                $dat = $this->load->view('pins/pin_discount_view',$this->data,true);
                echo json_encode(['status'=>true,'ddata'=>$dat]);
         }else {
            echo json_encode(['status'=>false,'ddata'=>'No data found']);
         }
         
    }
}
?>