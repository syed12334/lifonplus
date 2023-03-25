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
                //echo '<pre>';print_r($details);exit;
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
       //echo "<pre>";print_r($det);exit;
        $this->data['category'] = $this->master_db->getRecords('category',array('status!='=>-1),'id,name,is_package,type');
        $this->load->view('pins/pins',$this->data);
    }

    public function pinList(){
        $det = $this->data['detail'];
        $data_list = $this->pin_db->getPinList($det);
      //echo $this->db->last_query();exit;
        $data = array();
        $i = $_POST["start"]+1;
        
        foreach($data_list as $row){   
            $getFrom = $this->master_db->getRecords('partners',['id'=>$row->from_partner],'code,company_name');
            $name = '';
            switch($row->type){
                case 1: $name = $row->package;break;
                case 2: $name = $row->service;break;
                case 3: $name = $row->item;break;
                default:$name = '';
            }
            $action = '<button type="button" title="View Transactions" name="update" onclick="viewDetail('.$row->id.');" class="btn btn-primary btn-sm"><i class="fas fa-eye"></i></button>&nbsp;';
            $sub_array = array();
            $sub_array[] = $i++;
            $sub_array[] = $action;
            $sub_array[] = $row->pintype;
            $sub_array[] = $name;            
            $sub_array[] = $row->qty;
            $sub_array[] = $row->pin_amt;
            $sub_array[] = $row->total_amt;
            if(is_array($getFrom) && !empty($getFrom)) {
                $sub_array[] = $getFrom[0]->code ." - ".$getFrom[0]->company_name;
            }else {
                $sub_array[] = "";
            }
            $sub_array[] = $row->code ." - ".$row->company_name;
            $sub_array[] = date('d-m-Y h:i A',strtotime($row->created_at));
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

    public function getPackages(){
        //$data = $this->master_db->getRecords('packages',"status=1",'id,name');
        $data = $this->pin_db->getPackages();
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
        $type = intval($det[0]->type)+1;
        $condition = "p.type > $type";
        $this->data['partners'] = $this->pin_db->getPartner($condition);
        $this->load->view('pins/pin_transfer',$this->data);
    }

    public function transfer_pin(){
        $det = $this->data['detail'];
       // echo "<pre>";print_r($det);exit;
        $type = intval($det[0]->type)+1;
        $condition = "p.type > $type";
        $this->data['partners'] = $this->pin_db->getPartner($condition);
        $this->data['category'] = $this->master_db->getRecords('category',array('status!='=>-1),'id,name,is_package,type');
        $this->data['packages'] = $this->pin_db->getPackagePin("pa.id=".$det[0]->partner_id);   
        //echo $this->db->last_query();exit;     
        $this->data['items'] = $this->pin_db->getItemPin("pa.id=".$det[0]->partner_id);
        $this->data['services'] = $this->pin_db->getServicePin("pa.id=".$det[0]->partner_id);
        //echo '<pre>';print_r($this->data['packages']);exit;
        //print_r($this->data['items']);print_r($this->data['services']);exit;
        $this->load->view('pins/transfer_pin',$this->data);
    }

    public function pinTransferList(){
        $det = $this->data['detail'];
        $data_list = $this->pin_db->getTransferList($det);
        //echo $this->db->last_query();echo '<pre>';print_r($det);exit;
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
            $action = '<button type="button" title="View Invoice" name="update" onclick="viewInvoice('.$row->id.');" class="btn btn-primary btn-sm"><i class="fas fa-print"></i></button>';
            $sub_array[] = $action;
            $sub_array[] = $row->txn_no;
            $sub_array[] = $row->pintype;
            $sub_array[] = $name;
            $sub_array[] = $row->ttype;                        
            $sub_array[] = $row->qty;
            $sub_array[] = $row->pin_amt;
            $sub_array[] = $row->total_amt;
            $sub_array[] = $row->created_at;

            $company = ' --- ';
            if( $row->transfer_type == 2 ){ $company = $row->code.' - '.$row->company_name; }
            $sub_array[] = $company;
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
        //echo "<pre>";print_r($det);exit;
        $state = $det[0]->state_id;
        
        
        $district = $det[0]->district_id;
        $taluk = $det[0]->taluk_id;
        $partner_type = trim(preg_replace('!\s+!', ' ',html_escape($this->input->post('partner_type', true))));
        if( $partner_type != '' ){
            $type = "";
            if($partner_type ==1) {
                $type .= 1;
            }
            else if($partner_type ==3) {
                $type .= 3;
            }
            else if($partner_type ==4) {
                $type .=4;
            }
            else if($partner_type ==5) {
                $type .= 5;
            }
            //echo $type;exit;
        if($det[0]->type ==1) {
            $condition = ["p.type" =>$partner_type];
        }else {
            $condition = ["p.type" =>$partner_type,'pp.state_id'=>$state];
        }
            $partners = $this->pin_db->getPartnerListdata($condition);
           // echo $this->db->last_query();exit;
            if( count($condition) == 0 ){
                echo json_encode(array('status'=>'fail'));
            }else{
                echo json_encode(array('status'=>'success','data'=>$partners));
            }
        }else{
            echo json_encode(array('status'=>'fail','data'=>array()));
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
        $pid = $det[0]->pid;
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

            $partner_detail = $this->pin_db->getPartner("p.id=".$partner_id);
            $partner = $this->master_db->getRecords('partner_personal',array('partner_id'=>$pid),'contactno,fullname,emailid');
            $partnercredit = $this->master_db->getRecords('partner_personal',array('partner_id'=>$partner_id),'contactno,fullname,emailid');
            $partnerCode = $this->master_db->getRecords('partners',array('id'=>$pid),'code');
            $partnerCodecredit = $this->master_db->getRecords('partners',array('id'=>$partner_id),'code');
            $package = $this->master_db->getRecords('packages',array('id'=>$package_id),'name'); 
            $template = $this->master_db->getRecords('templates',array('type'=>11),'id,sms_template,mail_template,label');
            $partner_pin_transaction = $this->master_db->getRecords('partner_pin_transaction',array('partner_id'=>$partner_id),'qty');
           // echo $this->db->last_query();exit;
            $pptransaction = [];
            foreach ($partner_pin_transaction as $key => $value) {
                $pptransaction[] = $value->qty;
            }
            $admintransfer = $this->pin_db->getPackagePin("pa.id=".$det[0]->partner_id);
            //echo $this->db->last_query();exit;
            $transferadmin = [];
            foreach($admintransfer as $row){
                $transferadmin[] = $row->qty;
            }
            $admintransferpins = array_sum($transferadmin)-$qty;
            //echo "<pre>";print_r($pptransaction);exit;
            $totalpins = array_sum($pptransaction)+$qty;
            $templatecredit = $this->master_db->getRecords('templates',array('type'=>10),'id,sms_template,mail_template,label');
           // echo $this->db->last_query();exit;
                //send sms
            $phone = "+91-9986880000";
            $mobileno = $partner[0]->contactno;
            $mobilenos = $partnercredit[0]->contactno;
                $this->load->library('SMS');
                // $message = $template[0]->sms_template;
                // $message = str_replace('{#no#}',$partnerCode[0]->code,$message);
                // $message = str_replace('{#package#}',$package[0]->name,$message);
                // $message = str_replace('{#transfer#}',$partnercredit[0]->fullname,$message);
                // $message = str_replace('{#pins#}',$totalpins,$message);
                // $message = str_replace('{#phone#}',$phone,$message);
                // $this->sms->sendSmsToUser($message,$mobileno);
                //echo $message;exit;


                // $messages  = "Acct ".$partnerCodecredit[0]->code." credited with ".$package[0]->name." LIFEON+ Pins from ".$partner[0]->fullname." Available Bal Pins ".$totalpins." Nos. Contact us on ".$phone.". Regards, Team LIFEON+.";
                $messages = "Acct ".$partnerCodecredit[0]->code." credited with ".$qty." ".ucfirst($package[0]->name)." LIFEON+ Pins from Rajanikant Torgal Available Bal Pins ".$totalpins." Nos. Contact us on +91-9986880000. Regards, Team LIFEON+.";
                //echo $messages;exit;
                $adminmessage = "Acct ".$partnerCode[0]->code." debited with ".$package[0]->name." LIFEON+ Pins by transfer to ".$partnercredit[0]->fullname." Available Bal Pins ".$admintransferpins." Nos. Contact us on ".$phone.". Regards, Team LIFEON+.";
                //echo $adminmessage;exit;
                $this->sms->sendSmsToUser($messages,$mobilenos);
                $this->sms->sendSmsToUser($adminmessage,$partner[0]->contactno);

                 $this->load->library('Mail');
                $message = $template[0]->mail_template;
                $message = str_replace('{#no#}',$partnerCode[0]->code,$message);
                $message = str_replace('{#package#}',$package[0]->name,$message);
                $message = str_replace('{#date#}',date('d/m/Y'),$message);
                $message = str_replace('{#pins#}',$totalpins,$message);
                $message = str_replace('{#phone#}',$phone,$message);
                $this->data['company'] = $this->master_db->getRecords('company_detail',array('id'=>1),'name,address,phone_no,email,logo_link,website_url');
                $this->data['messagebody'] = $messages;
                $mailbody = $this->load->view('pin_mail_template',$this->data,true);
                $this->mail->send_sparkpost_attach($mailbody,array($partnercredit[0]->emailid,'info@lifonplus.com'),$template[0]->label);
            //if(count($partner_detail) == 0 ){ echo -3;exit; }

            // $partner_location = $this->pin_db->getPartnerLocation("p.id=".$partner_id);
            // if(count($partner_location) == 0 ){ echo -3;exit; }
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
            $checkPin = $this->master_db->getRecords('pins',$condition,'id,qty');
             $tax = $this->master_db->getRecords('tax',"id=1",'id,gst');
            //echo $this->db->last_query();echo '<pre>';print_r($checkPin);exit;
            if( count($checkPin) ){

                $condition = "partner_id=".$det[0]->partner_id." and pin_id = ".$checkPin[0]->id;
                $checkPPin = $this->master_db->getRecords('partner_pins',$condition,'id,qty,pin_amt');
                //echo $this->db->last_query();echo '<pre>';print_r($checkPPin);exit;
                if( count($checkPPin) == 0 ){ echo -2;exit; }
                else{
                    $pin_amt = $checkPPin[0]->pin_amt;
                }

                $tax_amt = 0;
                $txn_no = '';
                $code = $this->master_db->getRecords('system_codes',"id=1","id,prefix,pt_prefix,pt_code");
                $txn_no = $code[0]->prefix.$code[0]->pt_prefix;
                $txn_no .= sprintf('%02d', $code[0]->pt_code);
                $total_amt = ((int)$qty * (float)$pin_amt);
                $tax_amt = (($total_amt/100)*$tax[0]->gst);
                $grand_total = $total_amt + $tax_amt;

                $nqty = intval($checkPPin[0]->qty) - intval($qty);
                $update = array(
                    'qty'           =>  $nqty,
                    'total_amt'     =>  ($nqty * $pin_amt),
                    'updated_by'    =>  $det[0]->id,
                    'updated_at'    =>  date('Y-m-d H:i:s')
                );
                $this->master_db->updateRecord('partner_pins',$update,array('id'=>$checkPPin[0]->id));

                $partner_history = array(
                    'txn_no'    =>  $txn_no,
                    'type'      =>  2,
                    'ttype'     =>  2,
                    'pin_id'    =>  $checkPin[0]->id,
                    'pin_amt'   =>  $pin_amt,
                    'gst'       =>  $tax_amt,
                    'gst_per'   =>  $tax[0]->gst,
                    // 'gst_type'  =>  $partner_location[0]->tax_type,
                    'total_amt' =>  $total_amt,
                    'grand_total' =>    $grand_total,
                    'qty'       =>  $qty,
                    'status'    =>  1,
                    'partner_id'=>  $det[0]->partner_id,
                    'from_partner'  =>  $det[0]->partner_id,
                    'to_partner'=>  $partner_id,
                    'created_by'=>  $det[0]->id,
                    'created_at'=>  date('Y-m-d H:i:s')
                );
                 $insert = array(
                    'txn_no'        =>  $txn_no,
                    'pin_id'        =>  $checkPin[0]->id,
                    'partner_id'    =>  $partner_id,
                    'qty'           =>  $qty,
                    'pin_amt'       =>  $pin_amt,
                    'gst'           =>  $tax_amt,
                    'gst_per'       =>  $tax[0]->gst,
                    // 'gst_type'      =>  $partner_location[0]->tax_type,
                    'total_amt'     =>  $total_amt,
                    'grand_total'   =>  $grand_total,
                    'status'        =>  1,
                    'created_by'    =>  $det[0]->id,
                    'created_at'    =>  date('Y-m-d H:i:s')
                );
                $txn_id = 0;
                //echo '<pre>';print_r($insert);exit;
                $txn_id = $this->master_db->insertRecord('company_transfers',$insert);

                //echo '<pre>';print_r($partner_history);exit; 
                $this->master_db->insertRecord('partner_pin_transaction',$partner_history);

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

                $code[0]->pt_code = intval($code[0]->pt_code)+1;
                $this->master_db->updateRecord('system_codes',array('pt_code'=>$code[0]->pt_code,'id'=>1),array('id'=>1));

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
                        'total_amt'     =>  $grand_total,
                        'qty'           =>  $qty,
                        'status'        =>  1,
                        'created_by'    =>  $det[0]->id,
                        'created_at'    =>  date('Y-m-d H:i:s')
                    );
                    $partner_pin_id = $this->master_db->insertRecord('partner_pins',$insert);
                }

                $partner_history = array(
                    'txn_no'    =>  $txn_no,
                    'type'      =>  2,
                    'ttype'     =>  1,
                    'pin_id'    =>  $checkPin[0]->id,
                    'pin_amt'   =>  $pin_amt,
                    'total_amt' =>  $total_amt,
                    'qty'       =>  $qty,
                    'status'    =>  1,
                    'partner_id'=>  $partner_id,
                    'from_partner'  =>  $det[0]->partner_id,
                    'to_partner'=>  $partner_id,
                    'created_by'=>  $det[0]->id,
                    'created_at'=>  date('Y-m-d H:i:s')
                );
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
        //echo '<pre>';print_r($det);exit;
        if( $id != ''){
            $select = 'id,pin_id,txn_id,txn_no,partner_id,to_partner,from_partner,qty,pin_amt,gst,gst_per,gst_type,
                        total_amt,grand_total,status,created_at,ttype';
            $transaction = $this->master_db->getRecords('partner_pin_transaction',array('id'=>$id,'status'=>1),$select);
            if(count($transaction) && intval($transaction[0]->txn_id) ){
                $check = $this->master_db->getRecords('company_transfers',array('id'=>$transaction[0]->txn_id),'id,pin_id,txn_no,partner_id,qty,pin_amt,gst,gst_per,gst_type,total_amt,grand_total,status,created_at');
                $this->data['transfer'] = $check[0];
                $this->data['pin_detail'] = $pin_detail = $this->master_db->getRecords('pin_history',array('txn_id'=>$check[0]->id),'id,pin_id,action,qty,txn_id');
                $this->data['pin'] = $pin = $this->pin_db->getPin($pin_detail[0]->pin_id);
                $this->data['company'] = $company = $this->master_db->getRecords('company_detail',array('id'=>1),'*');
                $this->data['partner'] = $partner = $this->pin_db->getPartner("p.id=".$check[0]->partner_id);
                //echo '<pre>';print_r($partner);exit;
                $this->load->view('pins/company_invoice',$this->data);                
            }else if(count($transaction) && intval($transaction[0]->txn_id) == 0 ){
                //echo '<pre>';print_r($transaction);exit;
                $this->data['transfer'] = $transaction[0];
                $this->data['pin'] = $pin = $this->pin_db->getPin($transaction[0]->pin_id);
                $this->data['company'] = $company = $this->pin_db->getPartner("p.id=".$transaction[0]->from_partner);
                $this->data['partner'] = $partner = $this->pin_db->getPartner("p.id=".$transaction[0]->to_partner);
                $this->data['bank'] = $bank = $this->master_db->getRecords('partner_bank',array('partner_id'=>$transaction[0]->from_partner),'bank_name,account_no,ifsc_code,branch_name');
                //echo $this->db->last_query();echo '<pre>';print_r($bank);exit;
                $this->load->view('pins/pin_invoice',$this->data);                
            }else{
                $this->session->set_flashdata('message','<div class="alert alert-danger alert-dismissable"><button class="close" aria-hidden="true" data-dismiss="alert" type="button">&times;</button>No data found.</div>');
                redirect(base_url()."pin/transfer");
            }
            
        }
    }

    public function demouser() {
            $template = $this->master_db->getRecords('templates',array('type'=>10),'id,sms_template,mail_template,label');
               // echo $template[0]->sms_template;exit;
                $phone = "+919986880000";
                $mobileno = "9986571768";
                $this->load->library('SMS');
                $message = $template[0]->sms_template;
                $message = str_replace('{#no#}',rand(1234,9999),$message);
                $message = str_replace('{#package#}',"dnd",$message);
                $message = str_replace('{#pins#}',20,$message);
                $message = str_replace('{#date#}',1000,$message);
                $message = str_replace('{#cpartner#}',1000,$message);
                $message = str_replace('{#phone#}',9986571768,$message);

               // echo $message;exit;
                $this->sms->sendSmsToUser($message,$mobileno);
                if($this->sms->sendSmsToUser($message,$mobileno)) {
                    echo "Mobile done";
                }else {
                    echo "Mobile not done";
                }
    }
}
?>