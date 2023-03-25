<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
//error_reporting(0);
require APPPATH . 'libraries/REST_Controller.php';
class App extends REST_Controller { 

	public function __construct() {
		parent::__construct();		
		$this->load->helper('utility_helper');
        $this->load->helper('cookie');
        no_cache();
        $this->load->model('master_db');
        $this->load->model('home_db');
        $this->load->model('app_db');
        //$this->data['session'] = ADMIN_SESSION;
    }

    function index_post(){ }

    function index_get(){ }

    function countries_get(){
        $list = $this->master_db->getRecords('countries',array('status'=>1),'id,name');
        $result = array('status'=>'success','data'=>$list);
        echo json_encode($result);
    }

    function regions_get(){
        $country_id = 1;
        if( !empty($_GET['country_id']) ){ $country_id = trim($this->input->get('country_id')); }
        $list = $this->master_db->getRecords('regions',array('status'=>1),'id,name');
        $result = array('status'=>'success','data'=>$list);
        echo json_encode($result);
    }

    function states_get(){
        $country_id = 1;
        if( !empty($_GET['country_id']) ){ $country_id = trim($this->input->get('country_id')); }
        $list = $this->master_db->getRecords('states',array('country_id'=>$country_id,'status'=>1),'id,name','name asc');
        $result = array('status'=>'success','data'=>$list);
        echo json_encode($result);
    }

    function districts_get(){
        $state_id = 0;
        if( !empty($_GET['state_id']) ){ $state_id = trim($this->input->get('state_id')); }
        $list = $this->master_db->getRecords('districts',array('state_id'=>$state_id,'status'=>1),'id,name','name asc');
        $result = array('status'=>'success','data'=>$list);
        echo json_encode($result);
    }

    function taluks_get(){
        $district_id = 0;
        if( !empty($_GET['district_id']) ){ $district_id = trim($this->input->get('district_id')); }
        $list = $this->master_db->getRecords('cities',array('district_id'=>$district_id,'status'=>1),'id,name','name asc');
        $result = array('status'=>'success','data'=>$list);
        echo json_encode($result);
    }

    function checkeligible_get(){
        $result = array('status'=>'failure','msg'=>'Required fields are missing.');
        $type = trim(preg_replace('!\s+!', '',$this->input->get('type', true)));
        $condition = "";
        if($type == 1 ){
            $country = trim(preg_replace('!\s+!', '',$this->input->get('country', true)));
            $condition = "p.type=".$type." and pp.country_id = ".$country." and p.status != -1";
        }else if($type == 2 ){
            $country = trim(preg_replace('!\s+!', '',$this->input->get('country', true)));
            $region = trim(preg_replace('!\s+!', '',$this->input->get('region', true)));
            $condition = "p.type=".$type." and pp.country_id = ".$country." and pp.region_id = ".$region." and p.status != -1";
        }else if($type == 3 ){
            $country = trim(preg_replace('!\s+!', '',$this->input->get('country', true)));
            $state = trim(preg_replace('!\s+!', '',$this->input->get('state', true)));
            $condition = "p.type=".$type." and pp.country_id = ".$country." 
                        and pp.state_id = ".$state." and p.status != -1";
        }else if($type == 4 ){
            $country = trim(preg_replace('!\s+!', '',$this->input->get('country', true)));
            $state = trim(preg_replace('!\s+!', '',$this->input->get('state', true)));
            $district = trim(preg_replace('!\s+!', '',$this->input->get('district', true)));
            $condition = "p.type=".$type." and pp.country_id = ".$country." 
                        and pp.state_id = ".$state." and pp.district_id = ".$district." and p.status != -1";
        }else if( $type == 5 || $type == 6 ){
            $country = trim(preg_replace('!\s+!', '',$this->input->get('country', true)));
            $state = trim(preg_replace('!\s+!', '',$this->input->get('state', true)));
            $district = trim(preg_replace('!\s+!', '',$this->input->get('district', true)));
            $taluk = trim(preg_replace('!\s+!', '',$this->input->get('taluk', true)));
            $condition = "p.type=".$type." and pp.country_id = ".$country." 
                        and pp.state_id = ".$state." and pp.district_id = ".$district." and pp.taluk_id = ".$taluk." and p.status != -1";
        }
        $check = $this->app_db->checkPartner($condition);
        if( count($check) ){ echo 1;}
        else{ echo 0;}
    }

    function register_post(){
        //echo '<pre>';print_r($_POST);print_r($_FILES);exit;
        $result = array('status'=>'failure','msg'=>'Required fields are missing.');
        if( !empty($_POST['type']) && !empty($_POST['company_name']) && !empty($_POST['company_type']) && !empty($_POST['gst_no']) 
            && !empty($_POST['doc_type']) && !empty($_POST['name']) 
            && !empty($_POST['phone']) && !empty($_POST['email']) && !empty($_POST['dob']) && !empty($_POST['bloodgroup'])
            && !empty($_POST['address']) && !empty($_POST['country']) /*&& !empty($_POST['state']) && !empty($_POST['district']) && !empty($_POST['taluk'])*/
            && !empty($_POST['pincode']) && !empty($_POST['kyc_type']) && !empty($_POST['payment_mode']) && !empty($_POST['agree'])
            && !empty($_FILES['document']['name']) && !empty($_FILES['photo']['name']) && !empty($_POST['pcountry']) && !empty($_POST['pstate'])
            && !empty($_FILES['kyc_doc']['name'])
            ){
            
            $type = trim(preg_replace('!\s+!', '',$this->input->post('type', true)));
            $country = trim(preg_replace('!\s+!', '',$this->input->post('country', true)));
            $region = $state = $district = $taluk = 0;
            if( intval($type) == 1 ){
                $check = $this->master_db->getRecords('partners',array('type'=>$type,'status !='=>-1),'id');
                if(count($check)){
                    $result = array('status'=>'failure','msg'=>'Country partner already exists.');
                    echo json_encode($result);exit;
                }
            }

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
            if( count($check) ){ 
                $result = array('status'=>'failure','msg'=>'Channel partner type already exists.');
                echo json_encode($result);exit;
            }
            
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

            /*
            $condition = "company_name = '".$company_name."' and company_type = $company_type and type = $type and status != -1";
            $check = $this->master_db->getRecords('partners',$condition,'id');
            if(count($check)){
                $result = array('status'=>'failure','msg'=>'Company name, type & channel partner already exists.');
                echo json_encode($result);exit;
            }

            $condition = "contactno = $phone";
            $check = $this->master_db->getRecords('partner_personal',$condition,'id');
            if(count($check)){
                $result = array('status'=>'failure','msg'=>'Phone number already exists.');
                echo json_encode($result);exit;
            }

            $condition = "emailid = '".$email."'";
            $check = $this->master_db->getRecords('partner_personal',$condition,'id');
            if(count($check)){
                $result = array('status'=>'failure','msg'=>'Email already exists.');
                echo json_encode($result);exit;
            }
            */

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
                'status'        =>  1,
                'created_at'    =>  date('Y-m-d H:i:s')
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
            $partner_id = $this->master_db->insertRecord('partners',$partners);

            if( $partner_id ){

                $partner_location = array(
                    'partner_id'    =>  $partner_id,
                    'country_id'    =>  $pcountry,
                    'state_id'      =>  $pstate,
                );
                $this->master_db->insertRecord('partner_location',$partner_location);

                $partner_personal = array(
                    'partner_id'    =>  $partner_id,
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
                    'photo'         =>  '',
                    'kyc_type'      =>  $kyc_type,
                    'kyc_doc'       =>  '',
                );

                if( !empty($_FILES['photo']['name']) ){
                    $config2 = array();
                    $config2['upload_path'] = '../app_assets/channel_partner/photo/';  
                    $config2['allowed_types'] = 'jpeg|jpg|png';
                    $config2['max_size'] = 0;    
                    // I have chosen max size no limit 
                    //$new_name = $code.'_'. $_FILES["photo"]['name']; 
                    $ext = pathinfo($_FILES["document"]['name'], PATHINFO_EXTENSION);
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
                    $ext = pathinfo($_FILES["document"]['name'], PATHINFO_EXTENSION);
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
                $this->master_db->insertRecord('partner_personal',$partner_personal);

                $partner_payment = array(
                    'partner_id'    =>  $partner_id,
                    'payment_id'    =>  $payment_mode,
                    'cheque_no'     =>  $cheque_no,
                    'cheque_date'   =>  date('Y-m-d',strtotime($cheque_date)),
                    'bank_name'     =>  $bank_name,
                    'branch_name'   =>  $branch_name,
                    'utr_no'        =>  $utr_no,
                    'created_at'    =>  date('Y-m-d H:i:s')
                );
                $this->master_db->insertRecord('partner_payment',$partner_payment);
                $result = array('status'=>'success','msg'=>'Registered successfully.','partner_id'=>$partner_id);
            }
        }
        //echo "Test";exit;
        echo json_encode($result);
    }

    function getpartner_get(){
        $partner_id = 0;
        if( !empty($_GET['partner_id']) ){ $partner_id = trim($this->input->get('partner_id')); }
        $list = $this->master_db->getRecords('partners',array('id'=>$partner_id,'status'=>1),'id,code,company_name');
        $result = array('status'=>'success','data'=>$list);
        echo json_encode($result);
    }

    function registeruser_post(){
        //echo '<pre>';print_r($_POST);exit;
        $result = array('status'=>'failure','msg'=>'Required fields are missing.');
        if( !empty($_POST['name']) && !empty($_POST['mobile']) && !empty($_POST['email_id']) ){
            
            $name = trim(preg_replace('!\s+!', ' ',html_escape($this->input->post('name', true))));
            $mobile = trim(preg_replace('!\s+!', '',html_escape($this->input->post('mobile', true))));
            $email_id = trim(preg_replace('!\s+!', '',html_escape($this->input->post('email_id', true))));
            $referral_code = '';
            $checkMail = filter_var($email_id, FILTER_VALIDATE_EMAIL);
            if( $checkMail == false ){
                $result = array('status'=>'failure','msg'=>'Invalid email.');
                echo json_encode($result);exit;
            }

            if( preg_match('/^[0-9]{10}+$/', $mobile) == false) {
                $result = array('status'=>'failure','msg'=>'Invalid mobile number.');
                echo json_encode($result);exit;
            }

            //$condition = " (mobileno = '".$mobile."' or email = '".$email_id."') and status != -1 ";
            $condition = " mobileno = ".$mobile." and status != -1 ";
            $checkCustomer = $this->master_db->getRecords('customers',$condition,'id');
            if(count($checkCustomer)){
                $result = array('status'=>'failure','msg'=>'Mobile No or Email ID already exits.');
            }else{
                $code = $this->master_db->getRecords('system_codes','id=1','id,prefix,cust_prefix,cust_no,card_prefix');
                $slno = ($code[0]->cust_no+1);
                $slno = sprintf('%04d', $slno);
                $ccode = $code[0]->prefix.$code[0]->cust_prefix.$slno;
                $insert = array(
                    'code'      =>  $ccode,
                    'name'      =>  $name,
                    'mobileno'  =>  $mobile,
                    'email'     =>  $email_id,
                    'referral_code' =>  $referral_code,
                    'status'    =>  1,
                    'gender'    =>  -1,
                    'created_at'=>  date('Y-m-d H:i:s')
                );
                //echo '<pre>';print_r($insert);exit;
                $customer_id = $this->master_db->insertRecord('customers',$insert);
                if($customer_id){
                    $this->master_db->updateRecord('system_codes',array('cust_no'=>$slno),array('id'=>1));
                    $package = $this->master_db->getRecords('packages','status=1 and default=1','id,validity');
                    if(count($package)){
                        $card_no = $this->home_db->getCardno($code[0]->card_prefix);
                        $insert = array(
                            'customer_id'   =>  $customer_id,
                            'package_id'    =>  $package[0]->id,
                            'card_no'       =>  $card_no,
                            'valid_from'    =>  date('Y-m-d'),
                            'valid_to'      =>  date('Y-m-d',strtotime('+'.$package[0]->validity.' days')),
                            'pstatus'       =>  1,
                            'created_at'    =>  date('Y-m-d H:i:s')
                        );
                        $this->master_db->insertRecord('customer_package',$insert);
                    }

                    $points = $this->master_db->getRecords('points_setting','id=1','signup,referral');
                    $point = $referred_by = 0;
                    $type = 1;
                    if(count($points)){
                        $point = $points[0]->signup;
                    }

                    if( !empty($_POST['referral_code'])){
                        $referral_code = trim(preg_replace('!\s+!', '',html_escape($this->input->post('referral_code', true))));
                        $condition = " code = '".$referral_code."' and status = 1 ";
                        $referred = $this->master_db->getRecords('customers',$condition,'id');
                        if(count($referred)){
                            $point = ( $points[0]->signup + $points[0]->referral );
                            $type = 2;
                            $referred_by = $referred[0]->id;
                        }
                    }

                    $insert_setting = array(
                        'customer_id'   =>  $customer_id,
                        'notification'  =>  1,
                        'health'        =>  1,
                        'flash'         =>  1,
                        'updated_at'    =>  date('Y-m-d H:i:s')
                    );
                    $this->master_db->insertRecord('cust_notify_setting',$insert_setting);

                    $insert_point = array(
                        'customer_id'   =>  $customer_id,
                        'total'         =>  $point
                    );
                    $this->master_db->insertRecord('customer_points',$insert_point);

                    $point_history = array(
                        'customer_id'   =>  $customer_id,
                        'points'        =>  $point,
                        'type'          =>  $type,
                        'referred_by'   =>  $referred_by,
                        'status'        =>  1,
                        'created_at'    =>  date('Y-m-d H:i:s')
                    );
                    $this->master_db->insertRecord('cust_point_history',$point_history);

                    $this->load->library('SMS');
                    $template = $this->master_db->getRecords('templates','type=2','id,sms_template');
                    $otp = getOtp();
                    //$otp = 1234;
                    $sms = str_replace('{#otp#}',$otp,$template[0]->sms_template);
                    $res = $this->sms->sendSmsToUser($sms,$mobile);
                    $this->master_db->updateRecord('customers',array('otp'=>$otp),array('id'=>$customer_id));
                }
                $result = array('status'=>'success','msg'=>'Registered successfully.','user_id'=>$customer_id);
            }
        }
        echo json_encode($result);
    }

    function homepage_post(){
        //echo '<pre>';print_r($_GET);exit;
        $this->data = array();
        $result = array('status'=>'failure','msg'=>'Required fields are missing.');
        if( !empty($_POST['user_id']) ){   
            $user_id = trim(preg_replace('!\s+!', '',html_escape($this->input->post('user_id', true))));
            //echo $user_id;exit;
            $condition = " c.id = ".$user_id." and c.status = 1 and cp.pstatus = 1 ";
            $checkCustomer = $this->app_db->getCustomerDetail($condition);
            //echo '<pre>';print_r($checkCustomer);exit;
            if(count($checkCustomer)){
                $card_image = '';
                if( !empty($checkCustomer[0]->card_img) ){
                    $card_image = app_url().$checkCustomer[0]->card_img;
                }
                $result = array('status'=>'success','card_image'=>$card_image);
            }else{
                $result = array('status'=>'failure','msg'=>'Customer not found.');
            }
        }
        echo json_encode($result);
    }
    
    function card_post(){
        //echo '<pre>';print_r($_GET);exit;
        $this->data = array();
        $result = array('status'=>'failure','msg'=>'Required fields are missing.');
        if( !empty($_POST['user_id']) ){   
            $user_id = trim(preg_replace('!\s+!', '',html_escape($this->input->post('user_id', true))));
            //echo $user_id;exit;
            $condition = " c.id = ".$user_id." and c.status = 1 and cp.pstatus = 1 ";
            $checkCustomer = $this->app_db->getCustomerDetail($condition);
            //echo '<pre>';print_r($checkCustomer);exit;
            if(count($checkCustomer)){
                if( $checkCustomer[0]->blood_group == '' ){
                    $result = array('status'=>'failure','msg'=>'Profile not updated.');    
                }else{

                    if( empty($checkCustomer[0]->qrcode) ){
                        $this->load->library('phpqrcode/qrlib');
                        $SERVERFILEPATH = '../app_assets/qrcode/';
                        $text = $checkCustomer[0]->card_no;
                        $text1= substr($text, 0,9);                    
                        $folder = $SERVERFILEPATH;
                        $file_name1 = $checkCustomer[0]->code."_".time().".png";
                        $file_name = $folder.$file_name1;
                        QRcode::png($text,$file_name);
                        $this->master_db->updateRecord('customer_package',array('qrcode'=>'qrcode/'.$file_name1),array('customer_id'=>$checkCustomer[0]->user_id));
                    }

                    //echo '<pre>';print_r($checkCustomer);exit;
                    $condition = " c.id = ".$user_id." and c.status = 1 and cp.pstatus = 1 ";
                    $checkCustomer = $this->app_db->getCustomerDetail($condition);
                    $checkCustomer[0]->photo = app_asset_url().$checkCustomer[0]->photo;
                    $checkCustomer[0]->qrcode = app_asset_url().$checkCustomer[0]->qrcode;
                    //echo '<pre>';print_r($checkCustomer);exit;
                    $this->data['customer'] = $checkCustomer[0];
                    $html = $this->load->view('card_view',$this->data,true);
                    //echo $html;exit;
                    
                    require_once(APPPATH.'/third_party/html2_pdf_lib/html2pdf.class.php');
                    //$content = ob_get_clean();
                    //ob_clean ();
                    $html2pdf = new HTML2PDF('P', 'A4', 'en');
                    $html2pdf->pdf->SetDisplayMode('fullpage');
                    //$html2pdf->setModeDebug();
                    $html2pdf->setDefaultFont('courier');
                    $html2pdf->writeHTML($html);
                    $pdf_name = $checkCustomer[0]->user_id.'_'.time().'.pdf';
                    $file_name = '../app_assets/card_image/'.$pdf_name;
                    $file = $html2pdf->Output($file_name,'F');
                    
                    //exit;
                    //pdf creation
                    
                    //now magic starts
                    $image_name = '../app_assets/card_image/'.$checkCustomer[0]->user_id.'source.png';
                    $im = new imagick($file_name);
                    $im->setImageFormat( "png" );
                    $img_name = $image_name;
                    $im->setSize(100,100);
                    $im->writeImage($img_name);
                    //header('Content-Type: image/png');
                    //echo $im;
                    $im->clear();
                    $im->destroy();

                    $config['image_library'] = 'imagemagick';
                    $config['library_path'] = '/usr/bin';
                    $config['source_image'] = $img_name;
                    //$config['create_thumb'] = TRUE;
                    $config['maintain_ratio'] = FALSE;
                    //$config['x_axis'] = 100;
                    //$config['y_axis'] = 100;
                    $config['width'] = 650;
                    $config['height'] = 365;   
                    $img_name = $checkCustomer[0]->user_id.'_'.time().'.png';
                    $new_name = '../app_assets/card_image/'.$img_name;
                    $config['new_image'] = $new_name;
                    $this->load->library('image_lib', $config);
                    //$this->image_lib->crop();
                    
                    $this->image_lib->initialize($config); 
                    if (!$this->image_lib->crop()){
                        //echo $this->image_lib->display_errors();
                    }
                    unlink($image_name);
                    unlink($file_name);
                    $new_name = str_replace('../','',$new_name);
                    $update = array('card_img'=>$new_name,'updated_at'=>date('Y-m-d H:i:s'));
                    $where = array('customer_id'=>$checkCustomer[0]->user_id,'pstatus'=>1);
                    $this->master_db->updateRecord('customer_package',$update,$where);
                    $result = array('status'=>'success','msg'=>'Card generated successfully.');
                }                
            }else{
                $result = array('status'=>'failure','msg'=>'Customer not found.');
            }
        }
        echo json_encode($result);
    }

    function login_post(){
        //echo '<pre>';print_r($_POST);exit;
        $result = array('status'=>'failure','msg'=>'Required fields are missing.');
        if( !empty($_POST['mobile']) ){
            $mobile = trim(preg_replace('!\s+!', '',html_escape($this->input->post('mobile', true))));
            $condition = " mobileno = '".$mobile."' and status != -1 ";
            //echo '<pre>';print_r($template);exit;
            $checkCustomer = $this->master_db->getRecords('customers',$condition,'id');
            if(count($checkCustomer)){
                $this->load->library('SMS');
                $template = $this->master_db->getRecords('templates','type=2','id,sms_template');
                $otp = getOtp();
                //$otp = 1234;
                $sms = str_replace('{#otp#}',$otp,$template[0]->sms_template);
                //echo $sms;exit;
                $res = $this->sms->sendSmsToUser($sms,$mobile);
                //echo $res;exit;
                $this->master_db->updateRecord('customers',array('otp'=>$otp),array('id'=>$checkCustomer[0]->id));
                $result = array('status'=>'success','msg'=>'OTP sent.','user_id'=>$checkCustomer[0]->id);
            }else{
                $result = array('status'=>'failure','msg'=>'Mobile not registered.');
            }
        }
        echo json_encode($result);
    }

    function verifyotp_post(){
        //echo '<pre>';print_r($_POST);exit;
        $result = array('status'=>'failure','msg'=>'Required fields are missing.');
        if( !empty($_POST['user_id']) && !empty($_POST['otp']) ){
            $user_id = trim(preg_replace('!\s+!', '',html_escape($this->input->post('user_id', true))));
            $otp = trim(preg_replace('!\s+!', '',html_escape($this->input->post('otp', true))));
            $condition = " id = ".$user_id." and status = 1 ";
            $checkCustomer = $this->master_db->getRecords('customers',$condition,'id,otp');
            if(count($checkCustomer)){

                if( $checkCustomer[0]->otp != $otp ){
                    $result = array('status'=>'failure','msg'=>'Invalid OTP.');
                    echo json_encode($result);exit;
                }
                $db = array(
                    "customer_id"=>$checkCustomer[0]->id,
                    "login_datetime"=>date("Y-m-d H:i:s"),
                    "ipaddress"=>$this->home_db->get_client_ip()
                );

                $this->master_db->insertRecord("customer_login_report", $db);

                $db = array(
                    "login_at"=>	date("Y-m-d H:i:s"),
                );

                if( isset($_POST['gcm_id']) && !empty($_POST['gcm_id']) ){
                    $db['gcm_id']   = trim(preg_replace('!\s+!', '',html_escape($this->input->post('gcm_id', true))));
                    $db['device_id'] = '';
                    $db['device_type'] = 1;
                }
                
                if( isset($_POST['device_id']) && !empty($_POST['device_id']) ){
                    $db['device_id']   = trim(preg_replace('!\s+!', '',html_escape($this->input->post('device_id', true))));
                    $db['gcm_id'] = '';
                    $db['device_type'] = 2;
                }
                $this->master_db->updateRecord("customers", $db, array("id"=>$checkCustomer[0]->id));
                $result = array('status'=>'success','msg'=>'Login success.','user_id'=>$checkCustomer[0]->id);
            }else{
                $result = array('status'=>'failure','msg'=>'Customer not found.');
            }
        }
        echo json_encode($result);
    }

    function about_get(){
        redirect(app_url().'about.php');
    }

    function terms_get(){
        redirect(app_url().'terms.php');
    }

    function privacy_get(){
        redirect(app_url().'privacy.php');
    }
    
    function appversion_get(){
        $version = $this->master_db->getRecords('app_version','id=1','android,ios');
        $result = array('status'=>'failure','version'=>array());
        if(count($version)){
            $result = array('status'=>'success','version'=>$version[0]);
        }        
        echo json_encode($result);
    }

    function packages_post(){
        $result = array('status'=>'failure','msg'=>'Required fields are missing.');
        if( !empty($_POST['user_id']) ){
            $user_id = trim(preg_replace('!\s+!', '',html_escape($this->input->post('user_id', true))));
            $customer = $this->master_db->getRecords('customers','id='.$user_id.' and status = 1','id');
            if(count($customer)){
                $cpackage = $this->master_db->getRecords('customer_package','customer_id='.$user_id.' and pstatus = 1','group_concat(package_id) as pid');
                //echo '<pre>';print_r($cpackage);exit;
                $condition = "status = 1 and publish = 1 and id in (".$cpackage[0]->pid.")";
                $select = 'id,name as package_name,price as amount,DATE_ADD(CURDATE(), INTERVAL validity DAY) as expiry_date';
                $package = $this->master_db->getRecords('packages',$condition,$select);
                $result = array('status'=>'success','data'=>$package);     
            }else{
                $result = array('status'=>'failure','msg'=>'Customer not found.');
            }
        }        
        echo json_encode($result);
    }

    function packages_list_post(){
        $result = array('status'=>'failure','msg'=>'Required fields are missing.');
        if( !empty($_POST['user_id']) ){
            $user_id = trim(preg_replace('!\s+!', '',html_escape($this->input->post('user_id', true))));
            $customer = $this->master_db->getRecords('customers','id='.$user_id.' and status = 1','id');
            if(count($customer)){
                $cpackage = $this->master_db->getRecords('customer_package','customer_id='.$user_id,'group_concat(package_id) as pid');
                //echo '<pre>';print_r($cpackage);exit;
                $condition = "status = 1 and publish = 1 and id not in (".$cpackage[0]->pid.")";
                $select = 'id,name as package_name,price as amount,DATE_ADD(CURDATE(), INTERVAL validity DAY) as expiry_date';
                $package = $this->master_db->getRecords('packages',$condition,$select,'price asc');

                foreach($package as $p){
                    $condition = " package_id = $p->id and status = 1";
                    $p->highlight = $this->master_db->getRecords('package_highlights',$condition,'label');
                }
                //echo $this->db->last_query();echo '<pre>';print_r($package);exit;
                $result = array('status'=>'success','data'=>$package);     
            }else{
                $result = array('status'=>'failure','msg'=>'Customer not found.');
            }
        }        
        echo json_encode($result);
    }

    function speciality_post(){
        $condition = "status=1";
        $result = array('status'=>'failure','msg'=>'Required fields are missing.');
        if( !empty($_POST['user_id']) ){
            $user_id = trim(preg_replace('!\s+!', '',html_escape($this->input->post('user_id', true))));
            $customer = $this->master_db->getRecords('customers','id='.$user_id.' and status = 1','id');
            if(count($customer)){
                $list = $this->master_db->getRecords('speciality_master',$condition,'id,name','name asc');
                $result = array('status'=>'success','data'=>$list);     
            }else{
                $result = array('status'=>'failure','msg'=>'Customer not found.');
            }
        }        
        echo json_encode($result);
    }

    //Document functions
    function documents_post(){
        $result = array('status'=>'failure','msg'=>'Required fields are missing.');
        if( !empty($_POST['user_id']) && isset($_POST['len']) ){        
            $len = 10;    
            $start = 0;
            if( !empty($_POST['len']) ){
                $start = trim(preg_replace('!\s+!', '',html_escape($this->input->post('len', true))));
            }
            $user_id = trim(preg_replace('!\s+!', '',html_escape($this->input->post('user_id', true))));
            $customer = $this->master_db->getRecords('customers','id='.$user_id.' and status = 1','id');
            if(count($customer)){
                $condition = "c.id = $user_id and d.status = 1";
                $list = $this->app_db->getCustomerDocument($condition,$start,$len);
                foreach($list as $item){
                    $item->image = $this->master_db->getRecords('cust_doc_images','doc_id='.$item->id.' and status = 1',"concat('".app_asset_url()."',image) as image");
                }
                //echo '<pre>';print_r($list);exit;
                $result = array('status'=>'success','data'=>$list);     
            }else{
                $result = array('status'=>'failure','msg'=>'Customer not found.');
            }
        }        
        echo json_encode($result);
    }

    function save_document_post(){
        $result = array('status'=>'failure','msg'=>'Required fields are missing.');
        //echo '<pre>';print_r($_POST);print_r($_FILES);exit;
        
        if( !empty($_POST['user_id']) && !empty($_POST['id']) && !empty($_POST['title']) 
                && !empty($_POST['speciality_id']) && !empty($_POST['date']) ){

            $user_id = trim(preg_replace('!\s+!', '',html_escape($this->input->post('user_id', true))));
            $id = trim(preg_replace('!\s+!', '',html_escape($this->input->post('id', true))));
            $title = trim(html_escape($this->input->post('title', true)));
            $specialty = trim(preg_replace('!\s+!', '',html_escape($this->input->post('speciality_id', true))));
            $date = trim(preg_replace('!\s+!', '',html_escape($this->input->post('date', true))));
            $notes = '';
            if( !empty($_POST['notes']) ){ $notes = trim(html_escape($this->input->post('notes', true))); }

            $check = $this->master_db->getRecords('speciality_master','id='.$specialty.' and status = 1','id');
            if(count($check) == 0 ){
                $result = array('status'=>'failure','msg'=>'Specialty not found.');
                echo json_encode($result);exit;
            }

            $customer = $this->master_db->getRecords('customers','id='.$user_id.' and status = 1','id');
            if(count($customer)){

                $condition = 'id = '.$id.' and customer_id='.$user_id.' and status = 1';
                $checkDocument = $this->master_db->getRecords('cust_documents',$condition,'id');
                if(count($checkDocument) == 0){
                    $result = array('status'=>'failure','msg'=>'Customer document not found.');
                    echo json_encode($result);exit;
                }
                
                $update = array(
                    'title'         =>  $title,
                    'speciality_id' =>  $specialty,
                    'ddate'         =>  date('Y-m-d H:i:s',strtotime($date)),
                    'notes'         =>  $notes,
                    'status'        =>  1,
                    'updated_at'    =>  date("Y-m-d H:i:s"),
                    'updated_by'    =>  $user_id
                );
                //echo '<pre>';print_r($insert);exit;
                $doc_id = 0;
                $doc_id = $this->master_db->updateRecord('cust_documents',$update,array('id'=>$id));
                $result = array('status'=>'success','msg'=>'Document saved successfully.');     
            }else{
                $result = array('status'=>'failure','msg'=>'Customer not found.');
            }
        }else if( !empty($_POST['user_id']) && !empty($_POST['title']) && !empty($_POST['speciality_id']) 
            && !empty($_POST['date']) && ( isset($_FILES['image']) && count($_FILES['image']) ) ){

            $user_id = trim(preg_replace('!\s+!', '',html_escape($this->input->post('user_id', true))));
            $title = trim(html_escape($this->input->post('title', true)));
            $specialty = trim(preg_replace('!\s+!', '',html_escape($this->input->post('speciality_id', true))));
            $date = trim(preg_replace('!\s+!', '',html_escape($this->input->post('date', true))));
            $notes = '';
            if( !empty($_POST['notes']) ){ $notes = trim(html_escape($this->input->post('notes', true))); }
            
            $check = $this->master_db->getRecords('speciality_master','id='.$specialty.' and status = 1','id');
            if(count($check) == 0 ){
                $result = array('status'=>'failure','msg'=>'Specialty not found.');
                echo json_encode($result);exit;
            }

            $customer = $this->master_db->getRecords('customers','id='.$user_id.' and status = 1','id');
            if(count($customer)){
                
                $insert = array(
                    'customer_id'   =>  $user_id,
                    'title'         =>  $title,
                    'speciality_id' =>  $specialty,
                    'ddate'         =>  date('Y-m-d H:i:s',strtotime($date)),
                    'notes'         =>  $notes,
                    'status'        =>  1,
                    'created_at'    =>  date("Y-m-d H:i:s"),
                    'created_by'    =>  $user_id
                );
                //echo '<pre>';print_r($insert);exit;
                $doc_id = 0;
                $doc_id = $this->master_db->insertRecord('cust_documents',$insert);
                $i = 0;
                foreach($_FILES['image']['name'] as $item){
                    if( !empty($item) ){
                        $config = array();
                        $config['upload_path'] = '../app_assets/documents/';  
                        $config['allowed_types'] = 'jpeg|jpg|png';
                        $config['max_size'] = 0;    
                        // I have chosen max size no limit 

                        $_FILES['file']['name'] = $item;
                        $_FILES['file']['type'] = $_FILES['image']['type'][$i];
                        $_FILES['file']['tmp_name'] = $_FILES['image']['tmp_name'][$i];
                        $_FILES['file']['error'] = $_FILES['image']['error'][$i];
                        $_FILES['file']['size'] = $_FILES['image']['size'][$i];

                        //$new_name = $code.'_'. $_FILES["kyc_doc"]['name']; 
                        $ext = pathinfo($item, PATHINFO_EXTENSION);
                        $new_name = $doc_id.'_'.time().'.'.$ext; 
                        $config['file_name'] = $new_name;
                        //Stored the new name into $config['file_name']
                        $this->load->library('upload', $config);
                        $this->upload->initialize($config);
                        if ( !$this->upload->do_upload('file') ) {
                            $error = array('error' => $this->upload->display_errors());
                            //echo '<pre>';print_r($error);exit;
                        } else {
                            $upload_data = $this->upload->data();
                            $insert_doc = array(
                                'doc_id'    =>  $doc_id,
                                'image'     =>  'documents/'.$upload_data['file_name'],
                                'status'    =>  1
                            );
                            $this->master_db->insertRecord('cust_doc_images',$insert_doc);
                        }
                    }
                    $i++;
                }
                $result = array('status'=>'success','msg'=>'Document saved successfully.');     
            }else{
                $result = array('status'=>'failure','msg'=>'Customer not found.');
            }
        }        
        echo json_encode($result);
    }

    function delete_document_post(){
        $result = array('status'=>'failure','msg'=>'Required fields are missing.');
        if( !empty($_POST['user_id']) && isset($_POST['doc_id']) ){        
            $doc_id = trim(preg_replace('!\s+!', '',html_escape($this->input->post('doc_id', true))));
            $user_id = trim(preg_replace('!\s+!', '',html_escape($this->input->post('user_id', true))));
            $customer = $this->master_db->getRecords('customers','id='.$user_id.' and status = 1','id');
            if(count($customer)){
                $condition = "c.id = $user_id and d.status = 1 and d.id = ".$doc_id;
                $list = $this->app_db->getCustomerDocument($condition);
                if(count($list)){
                    $this->master_db->updateRecord('cust_documents',array('status'=>-1),array('id'=>$doc_id));
                    $result = array('status'=>'success','msg'=>'Deleted successfully');     
                }else{
                    $result = array('status'=>'failure','msg'=>'Document not found.');
                }                
            }else{
                $result = array('status'=>'failure','msg'=>'Customer not found.');
            }
        }        
        echo json_encode($result);
    }

    //profile functions
    function countries_post(){
        //echo '<pre>';print_r($_POST);exit;
        $result = array('status'=>'failure','msg'=>'Required fields are missing.');
        if( !empty($_POST['user_id']) ){
            $user_id = trim(preg_replace('!\s+!', '',html_escape($this->input->post('user_id', true))));
            $condition = " id = $user_id and status = 1 ";
            //echo '<pre>';print_r($template);exit;
            $checkCustomer = $this->master_db->getRecords('customers',$condition,'id');
            if(count($checkCustomer)){
                $list  = $this->master_db->getRecords('countries',"status=1",'id,name','id asc');
                $result = array('status'=>'success','list'=>$list);
            }else{
                $result = array('status'=>'failure','msg'=>'Customer not found.');
            }
        }
        echo json_encode($result);
    }

    function states_post(){
        //echo '<pre>';print_r($_POST);exit;
        $result = array('status'=>'failure','msg'=>'Required fields are missing.');
        if( !empty($_POST['user_id']) && !empty($_POST['country_id']) ){
            $user_id = trim(preg_replace('!\s+!', '',html_escape($this->input->post('user_id', true))));
            $country_id = trim(preg_replace('!\s+!', '',html_escape($this->input->post('country_id', true))));
            $condition = " id = $country_id and status = 1 ";
            //echo '<pre>';print_r($template);exit;
            $checkCustomer = $this->master_db->getRecords('customers',$condition,'id');
            if(count($checkCustomer)){
                $list  = $this->master_db->getRecords('states',"status=1 and country_id=$country_id",'id,name','name asc');
                $result = array('status'=>'success','list'=>$list);
            }else{
                $result = array('status'=>'failure','msg'=>'Customer not found.');
            }
        }
        echo json_encode($result);
    }

    function districs_post(){
        //echo '<pre>';print_r($_POST);exit;
        $result = array('status'=>'failure','msg'=>'Required fields are missing.');
        if( !empty($_POST['user_id']) && !empty($_POST['country_id']) && !empty($_POST['state_id']) ){
            $user_id = trim(preg_replace('!\s+!', '',html_escape($this->input->post('user_id', true))));
            $country_id = trim(preg_replace('!\s+!', '',html_escape($this->input->post('country_id', true))));
            $state_id = trim(preg_replace('!\s+!', '',html_escape($this->input->post('state_id', true))));
            $condition = " id = $user_id and status = 1 ";
            //echo '<pre>';print_r($template);exit;
            $checkCustomer = $this->master_db->getRecords('customers',$condition,'id');
            if(count($checkCustomer)){
                $condition = " c.id = $country_id and s.id = $state_id and 
                                d.status = 1 and c.status = 1 and s.status = 1 ";
                $list  = $this->app_db->getDistricts($condition);
                $result = array('status'=>'success','list'=>$list);
            }else{
                $result = array('status'=>'failure','msg'=>'Customer not found.');
            }
        }
        echo json_encode($result);
    }

    function taluks_post(){
        //echo '<pre>';print_r($_POST);exit;
        $result = array('status'=>'failure','msg'=>'Required fields are missing.');
        if( !empty($_POST['user_id']) && !empty($_POST['country_id']) && !empty($_POST['state_id'])
            && !empty($_POST['dist_id']) ){
            $user_id = trim(preg_replace('!\s+!', '',html_escape($this->input->post('user_id', true))));
            $country_id = trim(preg_replace('!\s+!', '',html_escape($this->input->post('country_id', true))));
            $state_id = trim(preg_replace('!\s+!', '',html_escape($this->input->post('state_id', true))));
            $dist_id = trim(preg_replace('!\s+!', '',html_escape($this->input->post('dist_id', true))));
            $condition = " id = $user_id and status = 1 ";
            //echo '<pre>';print_r($template);exit;
            $checkCustomer = $this->master_db->getRecords('customers',$condition,'id');
            if(count($checkCustomer)){
                $condition = " d.id = $dist_id and c.id = $country_id and s.id = $state_id and 
                                d.status = 1 and c.status = 1 and s.status = 1 ";
                $list  = $this->app_db->getTaluks($condition);
                $result = array('status'=>'success','list'=>$list);
            }else{
                $result = array('status'=>'failure','msg'=>'Customer not found.');
            }
        }
        echo json_encode($result);
    }

    function userprofile_post($type = ''){
        //echo $type;echo '<pre>';print_r($_POST);exit;
        $result = array('status'=>'failure','msg'=>'Required fields are missing.');
        if( $type == 'view' && !empty($_POST['user_id']) ){
            $user_id = trim(preg_replace('!\s+!', '',html_escape($this->input->post('user_id', true))));
            $condition = " id = $user_id and status = 1 ";
            //echo '<pre>';print_r($template);exit;
            $checkCustomer = $this->master_db->getRecords('customers',$condition,'id');
            if(count($checkCustomer)){
                $select = "c.id as user_id,c.name,c.email as email_id,DATE_FORMAT(c.dob,'%d-%m-%Y') as dob,c.bloodgroup as blood_group,
                    c.address,
                    CASE
                        WHEN c.gender = 1 THEN 'Male'
                        WHEN c.gender = 0 THEN 'Female'
                        WHEN c.gender = 2 THEN 'Trans Gender'
                        ELSE null
                    END AS gender,ct.id as country_id,ct.name as country_name,
                    st.id as state_id,st.name as state_name,dt.id as dist_id,dt.name as dist_name,t.id as city_id,
                    t.name as city_name,c.code as referral_code,c.photo,c.mobileno,cp.card_img";
                $condition = "c.id = $user_id and c.status = 1 and cp.pstatus = 1";
                $list  = $this->app_db->getCustomerDetail($condition,$select);
                if( !empty($list[0]->card_img) ){ $list[0]->card_img = app_url().$list[0]->card_img; }
                if( !empty($list[0]->photo) ){ $list[0]->photo = app_asset_url().$list[0]->photo; }

                if( count($list) ){
                    $points = $this->master_db->getRecords('customer_points',"customer_id=$user_id",'id,total');
                    if( count($points) ){ $list[0]->points = $points[0]->total; }
                    else{ $list[0]->points = 0; }
                    //echo '<pre>';print_r($points);exit;
                }
                //echo '<pre>';print_r($list);exit;
                $result = array('status'=>'success','list'=>$list);
            }else{
                $result = array('status'=>'failure','msg'=>'Customer not found.');
            }
        }

        if( $type == 'update' && !empty($_POST['user_id']) ){
            if( empty($_POST['name']) ){
                $result = array('status'=>'failure','msg'=>'Name is required');
                echo json_encode($result);exit;
            }

            if( empty($_POST['email_id']) ){
                $result = array('status'=>'failure','msg'=>'Email Id is required');
                echo json_encode($result);exit;
            }

            if( empty($_POST['dob']) ){
                $result = array('status'=>'failure','msg'=>'DOB is required');
                echo json_encode($result);exit;
            }

            if( empty($_POST['blood_group']) ){
                $result = array('status'=>'failure','msg'=>'Blood group is required');
                echo json_encode($result);exit;
            }

            if( isset($_POST['gender']) && trim($_POST['gender']) == '' ){
                $result = array('status'=>'failure','msg'=>'Gender is required');
                echo json_encode($result);exit;
            }

            if( empty($_POST['country_id']) ){
                $result = array('status'=>'failure','msg'=>'Country is required');
                echo json_encode($result);exit;
            }

            if( empty($_POST['state_id']) ){
                $result = array('status'=>'failure','msg'=>'State is required');
                echo json_encode($result);exit;
            }

            if( empty($_POST['dist_id']) ){
                $result = array('status'=>'failure','msg'=>'District is required');
                echo json_encode($result);exit;
            }

            if( empty($_POST['city_id']) ){
                $result = array('status'=>'failure','msg'=>'City is required');
                echo json_encode($result);exit;
            }

            $user_id = trim(preg_replace('!\s+!', '',html_escape($this->input->post('user_id', true))));
            $name = trim(html_escape($this->input->post('name', true)));
            $email_id = trim(preg_replace('!\s+!', '',html_escape($this->input->post('email_id', true))));
            $dob = trim(preg_replace('!\s+!', '',html_escape($this->input->post('dob', true))));
            $blood_group = trim(preg_replace('!\s+!', '',html_escape($this->input->post('blood_group', true))));
            $address = trim(html_escape($this->input->post('address', true)));
            $gender = trim(preg_replace('!\s+!', '',html_escape($this->input->post('gender', true))));
            $country_id = trim(preg_replace('!\s+!', '',html_escape($this->input->post('country_id', true))));
            $state_id = trim(preg_replace('!\s+!', '',html_escape($this->input->post('state_id', true))));
            $dist_id = trim(preg_replace('!\s+!', '',html_escape($this->input->post('dist_id', true))));
            $city_id = trim(preg_replace('!\s+!', '',html_escape($this->input->post('city_id', true))));

            $condition = " c.id = ".$user_id." and c.status = 1 and cp.pstatus = 1 ";
            $checkCustomer = $this->app_db->getCustomerDetail($condition);
            //echo '<pre>';print_r($checkCustomer);exit;
            if(count($checkCustomer)){
                
                $update = array(
                    'name'      =>  $name,
                    'email'     =>  $email_id,
                    'dob'       =>  date('Y-m-d',strtotime($dob)),
                    'bloodgroup'=>  $blood_group,
                    'address'   =>  $address,
                    'gender'    =>  $gender,
                    'country_id'=>  $country_id,
                    'state_id'  =>  $state_id,
                    'district_id'=> $dist_id,
                    'taluk_id'  =>  $city_id,  
                    'updated_at'=>  date('Y-m-d H:i:s')
                );

                /*
                if( empty($checkCustomer[0]->qrcode) ){
                    $this->load->library('phpqrcode/qrlib');
                    $SERVERFILEPATH = '../app_assets/qrcode/';
                    $text = $checkCustomer[0]->card_no;
                    $text1= substr($text, 0,9);                    
                    $folder = $SERVERFILEPATH;
                    $file_name1 = $checkCustomer[0]->code."_".time().".png";
                    $file_name = $folder.$file_name1;
                    QRcode::png($text,$file_name);
                    $this->master_db->updateRecord('customer_package',array('card_img'=>'qrcode/'.$file_name1),array('customer_id'=>$checkCustomer[0]->id));
                }
                */

                if( empty($checkCustomer[0]->photo) && empty($_FILES['photo']['name']) ){
                    $result = array('status'=>'failure','msg'=>'Upload photo to proceed.');
                    echo json_encode($result);exit;
                }

                if( !empty($_FILES['photo']['name']) ){

                    $new_name = $checkCustomer[0]->code.'_'.time(); 
                    $ext = pathinfo($_FILES["photo"]['name'], PATHINFO_EXTENSION);
                    $new_name = $new_name.'.'.$ext; 

                    if( !in_array($ext,array('jpeg','jpg','png')) ){
                        $result = array('status'=>'failure','msg'=>'The filetype you are attempting to upload is not allowed.');
                        echo json_encode($result);exit;
                    }
                    
                    $config = array();
                    $config['upload_path'] = '../app_assets/customer_photo/';  
                    $config['allowed_types'] = 'jpeg|jpg|png';
                    $config['max_size'] = 0;    
                    // I have chosen max size no limit 
                    

                    $config['file_name'] = $new_name;
                    //Stored the new name into $config['file_name']
                    $this->load->library('upload', $config);
                    if (!$this->upload->do_upload('photo') && !empty($_FILES['photo']['name'])) {
                        $error = array('error' => $this->upload->display_errors());
                        //echo '<pre>';print_r($error);exit;
                        $result = array('status'=>'failure','msg'=>'Something went wrong!');
                        echo json_encode($result);exit;
                    } else {
                        $upload_data = $this->upload->data();
                        //echo '<pre>';print_r($upload_data);exit;                        
                        $update['photo'] =  'customer_photo/'.$upload_data['file_name'];
                    }
                }
                //echo '<pre>';print_r($update);exit;
                $this->master_db->updateRecord('customers',$update,array('id'=>$user_id));
                $result = array('status'=>'success','msg'=>'Profile updated successfully.');
            }else{
                $result = array('status'=>'failure','msg'=>'Customer not found.');
            }

        }
        echo json_encode($result);
    }

    //Customer Emergency functions
    function cust_emergency_post(){
        $result = array('status'=>'failure','msg'=>'Required fields are missing.');
        if( !empty($_POST['user_id']) ){        
            $user_id = trim(preg_replace('!\s+!', '',html_escape($this->input->post('user_id', true))));
            $customer = $this->master_db->getRecords('customers','id='.$user_id.' and status = 1','id');
            if(count($customer)){
                $condition = "customer_id = $user_id and status = 1";
                $list = $this->master_db->getRecords('cust_emergency',$condition,'id as emergency_id,name,phone,relation,sms,location');
                $result = array('status'=>'success','data'=>$list);     
            }else{
                $result = array('status'=>'failure','msg'=>'Customer not found.');
            }
        }        
        echo json_encode($result);
    }

    function save_emergency_post(){
        $result = array('status'=>'failure','msg'=>'Required fields are missing.');
        //echo '<pre>';print_r($_POST);print_r($_FILES);exit;        
        if( !empty($_POST['user_id']) && !empty($_POST['name']) && !empty($_POST['phone']) 
            && !empty($_POST['relation']) && !empty($_POST['sms']) && !empty($_POST['location'])
            && !empty($_POST['emergency_id']) ){

            $user_id = trim(preg_replace('!\s+!', '',html_escape($this->input->post('user_id', true))));
            $name = trim(html_escape($this->input->post('name', true)));
            $phone = trim(preg_replace('!\s+!', '',html_escape($this->input->post('phone', true))));
            $relation = trim(html_escape($this->input->post('relation', true)));
            $sms = trim(preg_replace('!\s+!', '',html_escape($this->input->post('sms', true))));
            $sms = strtolower($sms);
            $location = trim(preg_replace('!\s+!', '',html_escape($this->input->post('location', true))));
            $location = strtolower($location);
            $id = trim(preg_replace('!\s+!', '',html_escape($this->input->post('emergency_id', true))));

            $condition = "phone=$phone and status = 1 and id != $id and customer_id = ".$user_id;
            $check = $this->master_db->getRecords('cust_emergency',$condition,'id');
            if(count($check)){
                $result = array('status'=>'failure','msg'=>'Emergency phone no already exists.');
                echo json_encode($result);exit;
            }

            $customer = $this->master_db->getRecords('customers','id='.$user_id.' and status = 1','id');
            if(count($customer)){  
                
                if( $sms == 'yes' ){ $sms = 1; }
                else if( $sms == 'no' ){ $sms = 0; }

                if( $location == 'yes' ){ $location = 1; }
                else if( $location == 'no' ){ $location = 0; }

                $update = array(
                    'name'          =>  $name,
                    'phone'         =>  $phone,
                    'relation'      =>  $relation,
                    'sms'           =>  $sms,
                    'location'      =>  $location,
                    'updated_at'    =>  date("Y-m-d H:i:s")
                );
                $doc_id = $this->master_db->updateRecord('cust_emergency',$update,array('id'=>$id));
                $result = array('status'=>'success','msg'=>'Saved successfully.');     
            }else{
                $result = array('status'=>'failure','msg'=>'Customer not found.');
            }
        }else if( !empty($_POST['user_id']) && !empty($_POST['name']) && !empty($_POST['phone']) 
            && !empty($_POST['relation']) && !empty($_POST['sms']) && !empty($_POST['location']) ){

            $user_id = trim(preg_replace('!\s+!', '',html_escape($this->input->post('user_id', true))));
            $name = trim(html_escape($this->input->post('name', true)));
            $phone = trim(preg_replace('!\s+!', '',html_escape($this->input->post('phone', true))));
            $relation = trim(html_escape($this->input->post('relation', true)));
            $sms = trim(preg_replace('!\s+!', '',html_escape($this->input->post('sms', true))));
            $sms = strtolower($sms);
            $location = trim(preg_replace('!\s+!', '',html_escape($this->input->post('location', true))));
            $location = strtolower($location);
            
            $condition = "phone = $phone and status = 1 and customer_id = ".$user_id;
            $check = $this->master_db->getRecords('cust_emergency',$condition,'id');
            if(count($check)){
                $result = array('status'=>'failure','msg'=>'Emergency phone no already exists.');
                echo json_encode($result);exit;
            }

            $customer = $this->master_db->getRecords('customers','id='.$user_id.' and status = 1','id');
            if(count($customer)){                
                if( $sms == 'yes' ){ $sms = 1; }
                else if( $sms == 'no' ){ $sms = 0; }

                if( $location == 'yes' ){ $location = 1; }
                else if( $location == 'no' ){ $location = 0; }

                $insert = array(
                    'customer_id'   =>  $user_id,
                    'name'          =>  $name,
                    'phone'         =>  $phone,
                    'relation'      =>  $relation,
                    'sms'           =>  $sms,
                    'location'      =>  $location,
                    'status'        =>  1,
                    'created_at'    =>  date("Y-m-d H:i:s")
                );
                //echo '<pre>';print_r($insert);exit;
                $id = $this->master_db->insertRecord('cust_emergency',$insert);
                $result = array('status'=>'success','msg'=>'Added successfully.');     
            }else{
                $result = array('status'=>'failure','msg'=>'Customer not found.');
            }
        }
        echo json_encode($result);
    }

    function delete_emergency_post(){
        $result = array('status'=>'failure','msg'=>'Required fields are missing.');
        if( !empty($_POST['user_id']) && isset($_POST['emergency_id']) ){        
            $user_id = trim(preg_replace('!\s+!', '',html_escape($this->input->post('user_id', true))));
            $emergency_id = trim(preg_replace('!\s+!', '',html_escape($this->input->post('emergency_id', true))));
            $customer = $this->master_db->getRecords('customers','id='.$user_id.' and status = 1','id');
            if(count($customer)){
                $condition = "customer_id = $user_id and id = $emergency_id and status = 1";
                $list = $this->master_db->getRecords('cust_emergency',$condition,'id');
                if(count($list)){
                    $this->master_db->updateRecord('cust_emergency',array('status'=>-1),array('id'=>$emergency_id));
                    $result = array('status'=>'success','msg'=>'Deleted successfully');     
                }else{
                    $result = array('status'=>'failure','msg'=>'No data found.');
                }                
            }else{
                $result = array('status'=>'failure','msg'=>'Customer not found.');
            }
        }        
        echo json_encode($result);
    }

    //Medical Records functions
    function medical_visit_post(){
        $result = array('status'=>'failure','msg'=>'Required fields are missing.');
        if( !empty($_POST['user_id']) ){        
            $user_id = trim(preg_replace('!\s+!', '',html_escape($this->input->post('user_id', true))));
            $customer = $this->master_db->getRecords('customers','id='.$user_id.' and status = 1','id');
            if(count($customer)){
                $condition = "customer_id = $user_id and status = 1";
                $select = "id as visit_id,visit_date,
                            CASE
                                WHEN type = 1 THEN 'New'
                                WHEN type = 2 THEN 'Follow Up'
                                ELSE ''
                            END as visit_type,
                            consulted_doctor,reason";
                $list = $this->master_db->getRecords('cust_medical_visits',$condition,$select);
                $result = array('status'=>'success','data'=>$list);     
            }else{
                $result = array('status'=>'failure','msg'=>'Customer not found.');
            }
        }        
        echo json_encode($result);
    }

    function save_medical_post(){
        $result = array('status'=>'failure','msg'=>'Required fields are missing.');
        //echo '<pre>';print_r($_POST);print_r($_FILES);exit;        
        if( !empty($_POST['user_id']) && !empty($_POST['date']) && !empty($_POST['visit_type']) 
            && !empty($_POST['consulted_doctor']) && !empty($_POST['reason']) && !empty($_POST['visit_id']) ){

            $user_id = trim(preg_replace('!\s+!', '',html_escape($this->input->post('user_id', true))));
            $date = trim(preg_replace('!\s+!', '',html_escape($this->input->post('date', true))));
            $visit_type = trim(preg_replace('!\s+!', '',html_escape($this->input->post('visit_type', true))));
            $consulted_doctor = trim(html_escape($this->input->post('consulted_doctor', true)));
            $reason = trim(html_escape($this->input->post('reason', true)));
            $visit_id = trim(preg_replace('!\s+!', '',html_escape($this->input->post('visit_id', true))));

            $customer = $this->master_db->getRecords('customers','id='.$user_id.' and status = 1','id');
            if(count($customer)){  

                $update = array(
                    'visit_date'    =>  date("Y-m-d",strtotime($date)),
                    'type'          =>  $visit_type,
                    'consulted_doctor' =>  $consulted_doctor,
                    'reason'        =>  $reason,
                    'updated_at'    =>  date("Y-m-d H:i:s")
                );
                $doc_id = $this->master_db->updateRecord('cust_medical_visits',$update,array('id'=>$visit_id));
                $result = array('status'=>'success','msg'=>'Saved successfully.');     
            }else{
                $result = array('status'=>'failure','msg'=>'Customer not found.');
            }
        }else if( !empty($_POST['user_id']) && !empty($_POST['date']) && !empty($_POST['visit_type']) 
            && !empty($_POST['consulted_doctor']) && !empty($_POST['reason']) ){

            $user_id = trim(preg_replace('!\s+!', '',html_escape($this->input->post('user_id', true))));
            $date = trim(preg_replace('!\s+!', '',html_escape($this->input->post('date', true))));
            $visit_type = trim(preg_replace('!\s+!', '',html_escape($this->input->post('visit_type', true))));
            $consulted_doctor = trim(html_escape($this->input->post('consulted_doctor', true)));
            $reason = trim(html_escape($this->input->post('reason', true)));

            $customer = $this->master_db->getRecords('customers','id='.$user_id.' and status = 1','id');
            if(count($customer)){                

                $insert = array(
                    'customer_id'   =>  $user_id,
                    'visit_date'    =>  date("Y-m-d",strtotime($date)),
                    'type'          =>  $visit_type,
                    'consulted_doctor' =>  $consulted_doctor,
                    'reason'        =>  $reason,
                    'status'        =>  1,
                    'created_at'    =>  date("Y-m-d H:i:s")
                );
                //echo '<pre>';print_r($insert);exit;
                $id = $this->master_db->insertRecord('cust_medical_visits',$insert);
                $result = array('status'=>'success','msg'=>'Added successfully.');     
            }else{
                $result = array('status'=>'failure','msg'=>'Customer not found.');
            }
        }
        echo json_encode($result);
    }

    function delete_medical_post(){
        $result = array('status'=>'failure','msg'=>'Required fields are missing.');
        if( !empty($_POST['user_id']) && isset($_POST['visit_id']) ){        
            $user_id = trim(preg_replace('!\s+!', '',html_escape($this->input->post('user_id', true))));
            $visit_id = trim(preg_replace('!\s+!', '',html_escape($this->input->post('visit_id', true))));
            $customer = $this->master_db->getRecords('customers','id='.$user_id.' and status = 1','id');
            if(count($customer)){
                $condition = "customer_id = $user_id and id = $visit_id and status = 1";
                $list = $this->master_db->getRecords('cust_medical_visits',$condition,'id');
                if(count($list)){
                    $this->master_db->updateRecord('cust_medical_visits',array('status'=>-1),array('id'=>$visit_id));
                    $result = array('status'=>'success','msg'=>'Deleted successfully');     
                }else{
                    $result = array('status'=>'failure','msg'=>'No data found.');
                }                
            }else{
                $result = array('status'=>'failure','msg'=>'Customer not found.');
            }
        }        
        echo json_encode($result);
    }

    //Hospital functions
    function hospital_post(){
        $result = array('status'=>'failure','msg'=>'Required fields are missing.');
        if( !empty($_POST['user_id']) ){        
            $user_id = trim(preg_replace('!\s+!', '',html_escape($this->input->post('user_id', true))));
            $customer = $this->master_db->getRecords('customers','id='.$user_id.' and status = 1','id');
            if(count($customer)){
                $condition = "customer_id = $user_id and status = 1";
                $select = "id as hospital_id,hospital,medical_note,DATE_FORMAT(admit_date,'%d-%m-%Y') as admit_date";
                $list = $this->master_db->getRecords('cust_hospitals',$condition,$select);
                $result = array('status'=>'success','data'=>$list);     
            }else{
                $result = array('status'=>'failure','msg'=>'Customer not found.');
            }
        }        
        echo json_encode($result);
    }

    function save_hospital_post(){
        $result = array('status'=>'failure','msg'=>'Required fields are missing.');
        //echo '<pre>';print_r($_POST);print_r($_FILES);exit;        
        if( !empty($_POST['user_id']) && !empty($_POST['admit_date']) && !empty($_POST['hospital']) 
            && !empty($_POST['medical_note']) && !empty($_POST['hospital_id']) ){

            $user_id = trim(preg_replace('!\s+!', '',html_escape($this->input->post('user_id', true))));
            $admit_date = trim(preg_replace('!\s+!', '',html_escape($this->input->post('admit_date', true))));
            $hospital = trim(html_escape($this->input->post('hospital', true)));
            $medical_note = trim(html_escape($this->input->post('medical_note', true)));
            $hospital_id = trim(preg_replace('!\s+!', '',html_escape($this->input->post('hospital_id', true))));

            $customer = $this->master_db->getRecords('customers','id='.$user_id.' and status = 1','id');
            if(count($customer)){  

                $update = array(
                    'hospital'      =>  $hospital,
                    'medical_note'  =>  $medical_note,
                    'admit_date'    =>  date("Y-m-d",strtotime($admit_date)),
                    'updated_at'    =>  date("Y-m-d H:i:s")
                );
                $doc_id = $this->master_db->updateRecord('cust_hospitals',$update,array('id'=>$hospital_id));
                $result = array('status'=>'success','msg'=>'Saved successfully.');     
            }else{
                $result = array('status'=>'failure','msg'=>'Customer not found.');
            }
        }else if( !empty($_POST['user_id']) && !empty($_POST['admit_date']) && !empty($_POST['hospital']) 
                && !empty($_POST['medical_note']) ){

            $user_id = trim(preg_replace('!\s+!', '',html_escape($this->input->post('user_id', true))));
            $admit_date = trim(preg_replace('!\s+!', '',html_escape($this->input->post('admit_date', true))));
            $hospital = trim(html_escape($this->input->post('hospital', true)));
            $medical_note = trim(html_escape($this->input->post('medical_note', true)));

            $customer = $this->master_db->getRecords('customers','id='.$user_id.' and status = 1','id');
            if(count($customer)){                

                $insert = array(
                    'customer_id'   =>  $user_id,
                    'hospital'      =>  $hospital,
                    'medical_note'  =>  $medical_note,
                    'admit_date'    =>  date("Y-m-d",strtotime($admit_date)),
                    'status'        =>  1,
                    'created_at'    =>  date("Y-m-d H:i:s")
                );
                //echo '<pre>';print_r($insert);exit;
                $id = $this->master_db->insertRecord('cust_hospitals',$insert);
                $result = array('status'=>'success','msg'=>'Added successfully.');     
            }else{
                $result = array('status'=>'failure','msg'=>'Customer not found.');
            }
        }
        echo json_encode($result);
    }

    function delete_hospital_post(){
        $result = array('status'=>'failure','msg'=>'Required fields are missing.');
        if( !empty($_POST['user_id']) && isset($_POST['hospital_id']) ){        
            $user_id = trim(preg_replace('!\s+!', '',html_escape($this->input->post('user_id', true))));
            $hospital_id = trim(preg_replace('!\s+!', '',html_escape($this->input->post('hospital_id', true))));
            $customer = $this->master_db->getRecords('customers','id='.$user_id.' and status = 1','id');
            if(count($customer)){
                $condition = "customer_id = $user_id and id = $hospital_id and status = 1";
                $list = $this->master_db->getRecords('cust_hospitals',$condition,'id');
                if(count($list)){
                    $this->master_db->updateRecord('cust_hospitals',array('status'=>-1),array('id'=>$hospital_id));
                    $result = array('status'=>'success','msg'=>'Deleted successfully');     
                }else{
                    $result = array('status'=>'failure','msg'=>'No data found.');
                }                
            }else{
                $result = array('status'=>'failure','msg'=>'Customer not found.');
            }
        }        
        echo json_encode($result);
    }

    //Vaccine functions
    function vaccine_post(){
        $result = array('status'=>'failure','msg'=>'Required fields are missing.');
        if( !empty($_POST['user_id']) ){        
            $user_id = trim(preg_replace('!\s+!', '',html_escape($this->input->post('user_id', true))));
            $customer = $this->master_db->getRecords('customers','id='.$user_id.' and status = 1','id');
            if(count($customer)){
                $condition = "customer_id = $user_id and status = 1";
                $select = "id as vaccine_id,vaccine_name,dose,DATE_FORMAT(date,'%d-%m-%Y') as date,note";
                $list = $this->master_db->getRecords('cust_vaccines',$condition,$select);
                $result = array('status'=>'success','data'=>$list);     
            }else{
                $result = array('status'=>'failure','msg'=>'Customer not found.');
            }
        }        
        echo json_encode($result);
    }

    function save_vaccine_post(){
        $result = array('status'=>'failure','msg'=>'Required fields are missing.');
        //echo '<pre>';print_r($_POST);print_r($_FILES);exit;        
        if( !empty($_POST['user_id']) && !empty($_POST['vaccine_name']) && !empty($_POST['dose']) 
            && !empty($_POST['date']) && !empty($_POST['vaccine_id']) ){

            $user_id = trim(preg_replace('!\s+!', '',html_escape($this->input->post('user_id', true))));
            $vaccine_name = trim(html_escape($this->input->post('vaccine_name', true)));
            $dose = trim(html_escape($this->input->post('dose', true)));
            $date = trim(preg_replace('!\s+!', '',html_escape($this->input->post('date', true))));
            $note = '';
            if( !empty($_POST['note']) ){
                $note = trim(html_escape($this->input->post('note', true)));
            }
            $vaccine_id = trim(preg_replace('!\s+!', '',html_escape($this->input->post('vaccine_id', true))));

            $customer = $this->master_db->getRecords('customers','id='.$user_id.' and status = 1','id');
            if(count($customer)){  
                $update = array(
                    'vaccine_name'  =>  $vaccine_name,
                    'dose'          =>  $dose,
                    'date'          =>  date("Y-m-d",strtotime($date)),
                    'note'          =>  $note,
                    'updated_at'    =>  date("Y-m-d H:i:s")
                );
                $doc_id = $this->master_db->updateRecord('cust_vaccines',$update,array('id'=>$vaccine_id));
                $result = array('status'=>'success','msg'=>'Saved successfully.');     
            }else{
                $result = array('status'=>'failure','msg'=>'Customer not found.');
            }
        }else if( !empty($_POST['user_id']) && !empty($_POST['vaccine_name']) && !empty($_POST['dose']) 
                    && !empty($_POST['date']) ){

            $user_id = trim(preg_replace('!\s+!', '',html_escape($this->input->post('user_id', true))));
            $vaccine_name = trim(html_escape($this->input->post('vaccine_name', true)));
            $dose = trim(html_escape($this->input->post('dose', true)));
            $date = trim(preg_replace('!\s+!', '',html_escape($this->input->post('date', true))));
            $note = '';
            if( !empty($_POST['note']) ){
                $note = trim(html_escape($this->input->post('note', true)));
            }

            $customer = $this->master_db->getRecords('customers','id='.$user_id.' and status = 1','id');
            if(count($customer)){                

                $insert = array(
                    'customer_id'   =>  $user_id,
                    'vaccine_name'  =>  $vaccine_name,
                    'dose'          =>  $dose,
                    'date'          =>  date("Y-m-d",strtotime($date)),
                    'note'          =>  $note,
                    'status'        =>  1,
                    'created_at'    =>  date("Y-m-d H:i:s")
                );
                //echo '<pre>';print_r($insert);exit;
                $id = $this->master_db->insertRecord('cust_vaccines',$insert);
                $result = array('status'=>'success','msg'=>'Added successfully.');     
            }else{
                $result = array('status'=>'failure','msg'=>'Customer not found.');
            }
        }
        echo json_encode($result);
    }

    function delete_vaccine_post(){
        $result = array('status'=>'failure','msg'=>'Required fields are missing.');
        if( !empty($_POST['user_id']) && isset($_POST['vaccine_id']) ){        
            $user_id = trim(preg_replace('!\s+!', '',html_escape($this->input->post('user_id', true))));
            $vaccine_id = trim(preg_replace('!\s+!', '',html_escape($this->input->post('vaccine_id', true))));
            $customer = $this->master_db->getRecords('customers','id='.$user_id.' and status = 1','id');
            if(count($customer)){
                $condition = "customer_id = $user_id and id = $vaccine_id and status = 1";
                $list = $this->master_db->getRecords('cust_vaccines',$condition,'id');
                if(count($list)){
                    $this->master_db->updateRecord('cust_vaccines',array('status'=>-1),array('id'=>$vaccine_id));
                    $result = array('status'=>'success','msg'=>'Deleted successfully');     
                }else{
                    $result = array('status'=>'failure','msg'=>'No data found.');
                }                
            }else{
                $result = array('status'=>'failure','msg'=>'Customer not found.');
            }
        }        
        echo json_encode($result);
    }

    //Allergy functions
    function allergy_post(){
        $result = array('status'=>'failure','msg'=>'Required fields are missing.');
        if( !empty($_POST['user_id']) ){        
            $user_id = trim(preg_replace('!\s+!', '',html_escape($this->input->post('user_id', true))));
            $customer = $this->master_db->getRecords('customers','id='.$user_id.' and status = 1','id');
            if(count($customer)){
                $condition = "customer_id = $user_id and status = 1";
                $select = "id as allergy_id,allergy_name,DATE_FORMAT(date,'%d-%m-%Y') as date,note";
                $list = $this->master_db->getRecords('cust_allergy',$condition,$select);
                $result = array('status'=>'success','data'=>$list);     
            }else{
                $result = array('status'=>'failure','msg'=>'Customer not found.');
            }
        }        
        echo json_encode($result);
    }

    function save_allergy_post(){
        $result = array('status'=>'failure','msg'=>'Required fields are missing.');
        //echo '<pre>';print_r($_POST);print_r($_FILES);exit;        
        if( !empty($_POST['user_id']) && !empty($_POST['allergy_name']) && !empty($_POST['date']) 
            && !empty($_POST['allergy_id']) ){

            $user_id = trim(preg_replace('!\s+!', '',html_escape($this->input->post('user_id', true))));
            $allergy_name = trim(html_escape($this->input->post('allergy_name', true)));
            $date = trim(preg_replace('!\s+!', '',html_escape($this->input->post('date', true))));
            $note = '';
            if( !empty($_POST['note']) ){
                $note = trim(html_escape($this->input->post('note', true)));
            }
            $allergy_id = trim(preg_replace('!\s+!', '',html_escape($this->input->post('allergy_id', true))));

            $customer = $this->master_db->getRecords('customers','id='.$user_id.' and status = 1','id');
            if(count($customer)){  
                $update = array(
                    'allergy_name'  =>  $allergy_name,
                    'date'          =>  date("Y-m-d",strtotime($date)),
                    'note'          =>  $note,
                    'updated_at'    =>  date("Y-m-d H:i:s")
                );
                $doc_id = $this->master_db->updateRecord('cust_allergy',$update,array('id'=>$allergy_id));
                $result = array('status'=>'success','msg'=>'Saved successfully.');     
            }else{
                $result = array('status'=>'failure','msg'=>'Customer not found.');
            }
        }else if( !empty($_POST['user_id']) && !empty($_POST['allergy_name']) && !empty($_POST['date']) ){

            $user_id = trim(preg_replace('!\s+!', '',html_escape($this->input->post('user_id', true))));
            $allergy_name = trim(html_escape($this->input->post('allergy_name', true)));
            $date = trim(preg_replace('!\s+!', '',html_escape($this->input->post('date', true))));
            $note = '';
            if( !empty($_POST['note']) ){
                $note = trim(html_escape($this->input->post('note', true)));
            }

            $customer = $this->master_db->getRecords('customers','id='.$user_id.' and status = 1','id');
            if(count($customer)){                

                $insert = array(
                    'customer_id'   =>  $user_id,
                    'allergy_name'  =>  $allergy_name,
                    'date'          =>  date("Y-m-d",strtotime($date)),
                    'note'          =>  $note,
                    'status'        =>  1,
                    'created_at'    =>  date("Y-m-d H:i:s")
                );
                //echo '<pre>';print_r($insert);exit;
                $id = $this->master_db->insertRecord('cust_allergy',$insert);
                $result = array('status'=>'success','msg'=>'Added successfully.');     
            }else{
                $result = array('status'=>'failure','msg'=>'Customer not found.');
            }
        }
        echo json_encode($result);
    }

    function delete_allergy_post(){
        $result = array('status'=>'failure','msg'=>'Required fields are missing.');
        if( !empty($_POST['user_id']) && isset($_POST['allergy_id']) ){        
            $user_id = trim(preg_replace('!\s+!', '',html_escape($this->input->post('user_id', true))));
            $allergy_id = trim(preg_replace('!\s+!', '',html_escape($this->input->post('allergy_id', true))));
            $customer = $this->master_db->getRecords('customers','id='.$user_id.' and status = 1','id');
            if(count($customer)){
                $condition = "customer_id = $user_id and id = $allergy_id and status = 1";
                $list = $this->master_db->getRecords('cust_allergy',$condition,'id');
                if(count($list)){
                    $this->master_db->updateRecord('cust_allergy',array('status'=>-1),array('id'=>$allergy_id));
                    $result = array('status'=>'success','msg'=>'Deleted successfully');     
                }else{
                    $result = array('status'=>'failure','msg'=>'No data found.');
                }                
            }else{
                $result = array('status'=>'failure','msg'=>'Customer not found.');
            }
        }        
        echo json_encode($result);
    }

    //Exam functions
    function exam_post(){
        $result = array('status'=>'failure','msg'=>'Required fields are missing.');
        if( !empty($_POST['user_id']) ){        
            $user_id = trim(preg_replace('!\s+!', '',html_escape($this->input->post('user_id', true))));
            $customer = $this->master_db->getRecords('customers','id='.$user_id.' and status = 1','id');
            if(count($customer)){
                $condition = "customer_id = $user_id and status = 1";
                $select = "id as exam_id,temp,
                            CASE 
                                WHEN temp_unit = 1 THEN 'Celsius'
                                WHEN temp_unit = 2 THEN 'Fahrenheit'
                            END as temp_unit,
                            weight,
                            CASE 
                                WHEN weight_unit = 1 THEN 'KG'
                                WHEN weight_unit = 2 THEN 'LB'
                            END as weight_unit,
                            height,
                            CASE 
                                WHEN height_unit = 1 THEN 'CM'
                                WHEN height_unit = 2 THEN 'Inches'
                                WHEN height_unit = 3 THEN 'Feet'
                            END as height_unit,symptoms,diagnosis,note,doctor
                        ,DATE_FORMAT(date,'%d-%m-%Y') as date,note,status";
                $list = $this->master_db->getRecords('cust_examination',$condition,$select);
                $result = array('status'=>'success','data'=>$list);     
            }else{
                $result = array('status'=>'failure','msg'=>'Customer not found.');
            }
        }        
        echo json_encode($result);
    }

    function save_exam_post(){
        $result = array('status'=>'failure','msg'=>'Required fields are missing.');
        //echo '<pre>';print_r($_POST);exit;        
        if( !empty($_POST['user_id']) && !empty($_POST['temp']) && !empty($_POST['temp_unit'])
            && !empty($_POST['weight']) && !empty($_POST['weight_unit']) && !empty($_POST['height'])
            && !empty($_POST['height_unit']) && !empty($_POST['symptoms']) && !empty($_POST['diagnosis'])
            && !empty($_POST['doctor']) && !empty($_POST['date'])
            && !empty($_POST['exam_id']) ){

            $user_id = trim(preg_replace('!\s+!', '',html_escape($this->input->post('user_id', true))));
            $temp = trim(preg_replace('!\s+!', '',html_escape($this->input->post('temp', true))));
            $temp_unit = trim(preg_replace('!\s+!', '',html_escape($this->input->post('temp_unit', true))));
            $weight = trim(preg_replace('!\s+!', '',html_escape($this->input->post('weight', true))));
            $weight_unit = trim(preg_replace('!\s+!', '',html_escape($this->input->post('weight_unit', true))));
            $height = trim(preg_replace('!\s+!', '',html_escape($this->input->post('height', true))));
            $height_unit = trim(preg_replace('!\s+!', '',html_escape($this->input->post('height_unit', true))));
            $symptoms = trim(preg_replace('!\s+!', '',html_escape($this->input->post('symptoms', true))));
            $diagnosis = trim(preg_replace('!\s+!', '',html_escape($this->input->post('diagnosis', true))));
            $doctor = trim(preg_replace('!\s+!', '',html_escape($this->input->post('doctor', true))));
            $date = trim(preg_replace('!\s+!', '',html_escape($this->input->post('date', true))));
            $exam_id = trim(preg_replace('!\s+!', '',html_escape($this->input->post('exam_id', true))));
            
            $note = '';
            if( !empty($_POST['note']) ){
                $note = trim(html_escape($this->input->post('note', true)));
            }

            $customer = $this->master_db->getRecords('customers','id='.$user_id.' and status = 1','id');
            if(count($customer)){  
                $update = array(
                    'temp'          =>  $temp,
                    'temp_unit'     =>  $temp_unit,
                    'weight'        =>  $weight,
                    'weight_unit'   =>  $weight_unit,
                    'height'        =>  $height,
                    'height_unit'   =>  $height_unit,
                    'symptoms'      =>  $symptoms,
                    'diagnosis'     =>  $diagnosis,
                    'doctor'        =>  $doctor,
                    'date'          =>  date("Y-m-d",strtotime($date)),
                    'note'          =>  $note,
                    'updated_at'    =>  date("Y-m-d H:i:s")
                );
                $doc_id = $this->master_db->updateRecord('cust_examination',$update,array('id'=>$exam_id));
                $result = array('status'=>'success','msg'=>'Saved successfully.');     
            }else{
                $result = array('status'=>'failure','msg'=>'Customer not found.');
            }
        }else if( !empty($_POST['user_id']) && !empty($_POST['temp']) && !empty($_POST['temp_unit'])
                && !empty($_POST['weight']) && !empty($_POST['weight_unit']) && !empty($_POST['height'])
                && !empty($_POST['height_unit']) && !empty($_POST['symptoms']) && !empty($_POST['diagnosis'])
                && !empty($_POST['doctor']) && !empty($_POST['date']) ){

            $user_id = trim(preg_replace('!\s+!', '',html_escape($this->input->post('user_id', true))));
            $temp = trim(preg_replace('!\s+!', '',html_escape($this->input->post('temp', true))));
            $temp_unit = trim(preg_replace('!\s+!', '',html_escape($this->input->post('temp_unit', true))));
            $weight = trim(preg_replace('!\s+!', '',html_escape($this->input->post('weight', true))));
            $weight_unit = trim(preg_replace('!\s+!', '',html_escape($this->input->post('weight_unit', true))));
            $height = trim(preg_replace('!\s+!', '',html_escape($this->input->post('height', true))));
            $height_unit = trim(preg_replace('!\s+!', '',html_escape($this->input->post('height_unit', true))));
            $symptoms = trim(preg_replace('!\s+!', '',html_escape($this->input->post('symptoms', true))));
            $diagnosis = trim(preg_replace('!\s+!', '',html_escape($this->input->post('diagnosis', true))));
            $doctor = trim(preg_replace('!\s+!', '',html_escape($this->input->post('doctor', true))));
            $date = trim(preg_replace('!\s+!', '',html_escape($this->input->post('date', true))));

            $note = '';
            if( !empty($_POST['note']) ){
                $note = trim(html_escape($this->input->post('note', true)));
            }

            $customer = $this->master_db->getRecords('customers','id='.$user_id.' and status = 1','id');
            if(count($customer)){   
                $insert = array(
                    'customer_id'   =>  $user_id,
                    'temp'          =>  $temp,
                    'temp_unit'     =>  $temp_unit,
                    'weight'        =>  $weight,
                    'weight_unit'   =>  $weight_unit,
                    'height'        =>  $height,
                    'height_unit'   =>  $height_unit,
                    'symptoms'      =>  $symptoms,
                    'diagnosis'     =>  $diagnosis,
                    'doctor'        =>  $doctor,
                    'date'          =>  date("Y-m-d",strtotime($date)),
                    'note'          =>  $note,
                    'status'        =>  1,
                    'created_at'    =>  date("Y-m-d H:i:s")
                );
                //echo '<pre>';print_r($insert);exit;
                $id = $this->master_db->insertRecord('cust_examination',$insert);
                $result = array('status'=>'success','msg'=>'Added successfully.');     
            }else{
                $result = array('status'=>'failure','msg'=>'Customer not found.');
            }
        }
        echo json_encode($result);
    }

    function delete_exam_post(){
        $result = array('status'=>'failure','msg'=>'Required fields are missing.');
        if( !empty($_POST['user_id']) && isset($_POST['exam_id']) ){        
            $user_id = trim(preg_replace('!\s+!', '',html_escape($this->input->post('user_id', true))));
            $exam_id = trim(preg_replace('!\s+!', '',html_escape($this->input->post('exam_id', true))));
            $customer = $this->master_db->getRecords('customers','id='.$user_id.' and status = 1','id');
            if(count($customer)){
                $condition = "customer_id = $user_id and id = $exam_id and status = 1";
                $list = $this->master_db->getRecords('cust_examination',$condition,'id');
                if(count($list)){
                    $this->master_db->updateRecord('cust_examination',array('status'=>-1),array('id'=>$exam_id));
                    $result = array('status'=>'success','msg'=>'Deleted successfully');     
                }else{
                    $result = array('status'=>'failure','msg'=>'No data found.');
                }                
            }else{
                $result = array('status'=>'failure','msg'=>'Customer not found.');
            }
        }        
        echo json_encode($result);
    }

    //Prescription functions
    function prescription_post(){
        $result = array('status'=>'failure','msg'=>'Required fields are missing.');
        if( !empty($_POST['user_id']) ){
            $user_id = trim(preg_replace('!\s+!', '',html_escape($this->input->post('user_id', true))));
            $customer = $this->master_db->getRecords('customers','id='.$user_id.' and status = 1','id');
            if(count($customer)){
                $condition = "customer_id = $user_id and status = 1";
                $list = $this->master_db->getRecords('cust_prescription',$condition,'id as prescript_id,doctor,message,date,concat("'.app_asset_url().'",image) as image');
                $result = array('status'=>'success','data'=>$list);     
            }else{
                $result = array('status'=>'failure','msg'=>'Customer not found.');
            }
        }        
        echo json_encode($result);
    }

    function save_prescription_post(){
        $result = array('status'=>'failure','msg'=>'Required fields are missing.');
        //echo '<pre>';print_r($_POST);print_r($_FILES);exit;
        if( !empty($_POST['user_id']) && !empty($_POST['doctor']) && !empty($_POST['message']) 
            && !empty($_POST['date']) && !empty($_POST['prescript_id'])  ){

            $user_id = trim(preg_replace('!\s+!', '',html_escape($this->input->post('user_id', true))));
            $prescript_id = trim(preg_replace('!\s+!', '',html_escape($this->input->post('prescript_id', true))));
            $doctor = trim(html_escape($this->input->post('doctor', true)));
            $message = trim(html_escape($this->input->post('message', true)));
            $date = trim(preg_replace('!\s+!', '',html_escape($this->input->post('date', true))));
            
            $customer = $this->master_db->getRecords('customers','id='.$user_id.' and status = 1','id');
            if(count($customer)){                
                $update = array(
                    'doctor'        =>  $doctor,
                    'message'       =>  $message,
                    'date'          =>  date('Y-m-d H:i:s',strtotime($date)),
                    'updated_at'    =>  date("Y-m-d H:i:s")
                );
                //echo '<pre>';print_r($insert);exit;
                $this->master_db->updateRecord('cust_prescription',$update,array('id'=>$prescript_id));
                if( !empty($_FILES['image']['name']) ){
                    $config = array();
                    $config['upload_path'] = '../app_assets/prescription/';  
                    $config['allowed_types'] = 'jpeg|jpg|png';
                    $config['max_size'] = 0;    
                    // I have chosen max size no limit 

                    $ext = pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION);
                    $new_name = $prescript_id.'_'.time().'.'.$ext; 
                    $config['file_name'] = $new_name;
                    //Stored the new name into $config['file_name']
                    $this->load->library('upload', $config);
                    $this->upload->initialize($config);
                    if ( !$this->upload->do_upload('image') ) {
                        $error = array('error' => $this->upload->display_errors());
                        //echo '<pre>';print_r($error);exit;
                    } else {
                        $upload_data = $this->upload->data();
                        $update = array('image'=>'prescription/'.$upload_data['file_name']);
                        $this->master_db->updateRecord('cust_prescription',$update,array('id'=>$prescript_id));
                    }
                }
                $result = array('status'=>'success','msg'=>'Prescription saved successfully.');     
            }else{
                $result = array('status'=>'failure','msg'=>'Customer not found.');
            }
        }elseif( !empty($_POST['user_id']) && !empty($_POST['doctor']) && !empty($_POST['message']) 
                && !empty($_POST['date']) ){

            $user_id = trim(preg_replace('!\s+!', '',html_escape($this->input->post('user_id', true))));
            $doctor = trim(html_escape($this->input->post('doctor', true)));
            $message = trim(html_escape($this->input->post('message', true)));
            $date = trim(preg_replace('!\s+!', '',html_escape($this->input->post('date', true))));
            
            $customer = $this->master_db->getRecords('customers','id='.$user_id.' and status = 1','id');
            if(count($customer)){                
                $insert = array(
                    'customer_id'   =>  $user_id,
                    'doctor'        =>  $doctor,
                    'message'       =>  $message,
                    'date'          =>  date('Y-m-d H:i:s',strtotime($date)),
                    'status'        =>  1,
                    'created_at'    =>  date("Y-m-d H:i:s")
                );
                //echo '<pre>';print_r($insert);exit;
                $id = $this->master_db->insertRecord('cust_prescription',$insert);
                if( !empty($_FILES['image']['name']) ){
                    $config = array();
                    $config['upload_path'] = '../app_assets/prescription/';  
                    $config['allowed_types'] = 'jpeg|jpg|png';
                    $config['max_size'] = 0;    
                    // I have chosen max size no limit 

                    $ext = pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION);
                    $new_name = $id.'_'.time().'.'.$ext; 
                    $config['file_name'] = $new_name;
                    //Stored the new name into $config['file_name']
                    $this->load->library('upload', $config);
                    $this->upload->initialize($config);
                    if ( !$this->upload->do_upload('image') ) {
                        $error = array('error' => $this->upload->display_errors());
                        //echo '<pre>';print_r($error);exit;
                    } else {
                        $upload_data = $this->upload->data();
                        $update = array('image'=>'prescription/'.$upload_data['file_name']);
                        $this->master_db->updateRecord('cust_prescription',$update,array('id'=>$id));
                    }
                }
                $result = array('status'=>'success','msg'=>'Prescription saved successfully.');     
            }else{
                $result = array('status'=>'failure','msg'=>'Customer not found.');
            }
        }    
        echo json_encode($result);
    }

    function delete_prescription_post(){
        $result = array('status'=>'failure','msg'=>'Required fields are missing.');
        if( !empty($_POST['user_id']) && isset($_POST['prescript_id']) ){        
            $prescript_id = trim(preg_replace('!\s+!', '',html_escape($this->input->post('prescript_id', true))));
            $user_id = trim(preg_replace('!\s+!', '',html_escape($this->input->post('user_id', true))));
            $customer = $this->master_db->getRecords('customers','id='.$user_id.' and status = 1','id');
            if(count($customer)){
                $condition = "customer_id = $user_id and status = 1 and id = ".$prescript_id;
                $list = $this->master_db->getRecords('cust_prescription',$condition,'id');
                if(count($list)){
                    $this->master_db->updateRecord('cust_prescription',array('status'=>-1),array('id'=>$prescript_id));
                    $result = array('status'=>'success','msg'=>'Deleted successfully');     
                }else{
                    $result = array('status'=>'failure','msg'=>'Document not found.');
                }                
            }else{
                $result = array('status'=>'failure','msg'=>'Customer not found.');
            }
        }        
        echo json_encode($result);
    }

    //Tracked Measurements
    function tracklist_post(){
        $result = array('status'=>'failure','msg'=>'Required fields are missing.');
        if( !empty($_POST['user_id']) ){
            $user_id = trim(preg_replace('!\s+!', '',html_escape($this->input->post('user_id', true))));
            $customer = $this->master_db->getRecords('customers','id='.$user_id.' and status = 1','id');
            if(count($customer)){
                $condition = "c.status = 1 and s.status = 1 and c.is_service = 1";
                $list = $this->app_db->getServiceCategory($condition);
                $result = array('status'=>'success','data'=>$list);     
            }else{
                $result = array('status'=>'failure','msg'=>'Customer not found.');
            }
        }        
        echo json_encode($result);
    }

    function servicelist_post(){
        $result = array('status'=>'failure','msg'=>'Required fields are missing.');
        if( !empty($_POST['user_id']) && !empty($_POST['cat_id']) ){
            $user_id = trim(preg_replace('!\s+!', '',html_escape($this->input->post('user_id', true))));
            $cat_id = trim(preg_replace('!\s+!', '',html_escape($this->input->post('cat_id', true))));
            $customer = $this->master_db->getRecords('customers','id='.$user_id.' and status = 1','id');
            if(count($customer)){
                $condition = "c.id = $user_id and ps.status = 1 and s.status = 1 and s.subcat_id = ".$cat_id;
                $list = $this->app_db->getServiceList($condition);
                if(count($list)){
                    $result = array('status'=>'success','data'=>$list);     
                }else{
                    $result = array('status'=>'failure','msg'=>'Service not found.');
                }
            }else{
                $result = array('status'=>'failure','msg'=>'Customer not found.');
            }
        }        
        echo json_encode($result);
    }

    function servicefields_post(){
        $result = array('status'=>'failure','msg'=>'Required fields are missing.');
        if( !empty($_POST['user_id']) && !empty($_POST['service_id']) ){
            $user_id = trim(preg_replace('!\s+!', '',html_escape($this->input->post('user_id', true))));
            $service_id = trim(preg_replace('!\s+!', '',html_escape($this->input->post('service_id', true))));
            $customer = $this->master_db->getRecords('customers','id='.$user_id.' and status = 1','id');
            if(count($customer)){
                $condition = "c.id = $user_id and ps.status = 1 and s.status = 1 and s.id = ".$service_id;
                $service = $this->app_db->getServiceList($condition);
                if(count($service) == 0 ){
                    $result = array('status'=>'failure','msg'=>'Service not found.');
                    echo json_encode($result);exit;
                }else{
                    $condition = "s.status = 1 and sf.status = 1 and s.id = ".$service_id;
                    $data = $this->app_db->getServiceFields($condition);
                    $result = array('status'=>'success','data'=>$data);     
                }
            }else{
                $result = array('status'=>'failure','msg'=>'Customer not found.');
            }
        }        
        echo json_encode($result);
    }

    function save_tracked_post(){
        $data = json_decode(file_get_contents('php://input'), true);
        $result = array('status'=>'failure','msg'=>'Required fields are missing.');
        //echo '<pre>';print_r($data);exit;
        if( !empty($data['user_id']) && !empty($data['measurement_id']) && !empty($data['service_id']) && count($data['fields']) ){

            //echo '<pre>';print_r($data);exit;
            $user_id = trim(preg_replace('!\s+!', '',html_escape($data['user_id'])));
            $measurement_id = trim(preg_replace('!\s+!', '',html_escape($data['measurement_id'])));
            $service_id = trim(preg_replace('!\s+!', '',html_escape($data['service_id'])));

            $fields = $data['fields'];
            
            $customer = $this->master_db->getRecords('customers','id='.$user_id.' and status = 1','id');
            if(count($customer)){
                $condition = "customer_id=".$user_id." and status = 1 and id = $measurement_id ";
                $checkTracked = $this->master_db->getRecords('cust_service',$condition,'id');
                if( count($checkTracked) ){
                    //echo '<pre>';print_r($checkTracked);exit;                    
                    $update = array(
                        'updated_at'    =>  date("Y-m-d H:i:s")
                    );
                    //echo '<pre>';print_r($insert);exit;
                    $this->master_db->updateRecord('cust_service',$update,array('id'=>$measurement_id));
                    $i = 0;
                    foreach($fields as $row){
                        $update = array(
                            'data'      =>  $row['value'],
                            'updated_at'=>  date("Y-m-d H:i:s")
                        );
                        $where = array(
                            'main_id'   =>  $measurement_id,
                            'field_id'  =>  $row['field_id']
                        );
                        //echo '<pre>';print_r($where);exit;
                        $this->master_db->updateRecord('cust_service_field',$update,$where);
                        $i++;
                    }
                    $result = array('status'=>'success','msg'=>'Saved successfully.'); 
                }else{
                    $result = array('status'=>'failure','msg'=>'Service not found.');
                }
            }else{
                $result = array('status'=>'failure','msg'=>'Customer not found.');
            }
        }else if( !empty($data['user_id']) && !empty($data['service_id']) && count($data['fields']) ){

            $user_id = trim(preg_replace('!\s+!', '',html_escape($data['user_id'])));
            $service_id = trim(preg_replace('!\s+!', '',html_escape($data['service_id'])));

            $fields = $data['fields'];
            
            $customer = $this->master_db->getRecords('customers','id='.$user_id.' and status = 1','id');
            if(count($customer)){
                $condition = "c.id = $user_id and ps.status = 1 and s.status = 1 and s.id = ".$service_id;
                $list = $this->app_db->getServiceList($condition);
                //echo '<pre>';print_r($list);exit;
                if(count($list)){

                    $insert = array(
                        'customer_id'   =>  $user_id,
                        'service_id'    =>  $service_id,
                        'status'        =>  1,
                        'created_at'    =>  date("Y-m-d H:i:s")
                    );
                    //echo '<pre>';print_r($insert);exit;
                    $id = 0;
                    $id = $this->master_db->insertRecord('cust_service',$insert);
                    $i = 0;
                    foreach($fields as $row){
                        $insertField = array(
                            'main_id'   =>  $id,
                            'field_id'  =>  $row['field_id'],
                            'data'      =>  $row['value'],
                            'status'    =>  1,
                            'created_at'=>  date("Y-m-d H:i:s")
                        );
                        //echo '<pre>';print_r($insertField);exit; 
                        $this->master_db->insertRecord('cust_service_field',$insertField);
                        $i++;
                    }
                    $result = array('status'=>'success','msg'=>'Saved successfully.'); 
                }else{
                    $result = array('status'=>'failure','msg'=>'Service not found.');
                }                    
            }else{
                $result = array('status'=>'failure','msg'=>'Customer not found.');
            }
        }    
        echo json_encode($result);
    }

    function servicedlist_post(){
        $result = array('status'=>'failure','msg'=>'Required fields are missing.');
        if( !empty($_POST['user_id']) && !empty($_POST['service_id']) ){
            $user_id = trim(preg_replace('!\s+!', '',html_escape($this->input->post('user_id', true))));
            $service_id = trim(preg_replace('!\s+!', '',html_escape($this->input->post('service_id', true))));
            $customer = $this->master_db->getRecords('customers','id='.$user_id.' and status = 1','id');
            if(count($customer)){

                $condition = "c.id = $user_id and ps.status = 1 and s.status = 1 and s.id = ".$service_id;
                $services = $this->app_db->getServiceList($condition);
                if(count($services) == 0){
                    $result = array('status'=>'failure','msg'=>'Service not found.');
                    echo json_encode($result);
                }
                //echo '<pre>';print_r($services);exit;
                $condition = "customer_id = $user_id and service_id = ".$services[0]->id." and status = 1 ";
                $cdata = $this->master_db->getRecords('cust_service',$condition,'id,customer_id,service_id','id desc');
                //echo '<pre>';print_r($cdata);exit;
                $service_list['service_id'] = $services[0]->id;
                $service_list['name'] = $services[0]->name;
                $service_list['data'] = array();
                $fields = $this->master_db->getRecords('service_fields',"service_id=".$services[0]->id." and status = 1",'id,order_no,label,note','order_no asc'); 
                foreach($cdata as $c){

                    $sdata = array();
                    $fields = $this->master_db->getRecords('service_fields',"service_id=".$services[0]->id." and status = 1",'id,order_no,label,note','order_no asc'); 
                    //echo '<pre>';print_r($cdata);print_r($fields);exit;
                    $sdata['measurement_id'] = $c->id;
                    foreach($fields as $f){
                        $value = '';
                        $condition = "main_id = ".$c->id." and field_id = $f->id and status = 1 ";
                        $fielddata = $this->master_db->getRecords('cust_service_field',$condition,'id,data','id desc');
                        if(count($fielddata)){
                            $value = $fielddata[0]->data;
                        }
                        $sdata['fields'][] = array(
                            'order' =>  $f->order_no,
                            'label' =>  $f->label,
                            'note'  =>  $f->note,
                            'value' =>  $value
                        );
                        
                    }
                    $service_list['data'][] = $sdata;
                }
                //echo '<pre>';print_r($service_list);exit;    
                $result = array('status'=>'success','data'=>$service_list);     
            }else{
                $result = array('status'=>'failure','msg'=>'Customer not found.');
            }
        }        
        echo json_encode($result);
    }

    function servicedata_post(){
        $result = array('status'=>'failure','msg'=>'Required fields are missing.');
        if( !empty($_POST['user_id']) ){
            $user_id = trim(preg_replace('!\s+!', '',html_escape($this->input->post('user_id', true))));
            $service_id = trim(preg_replace('!\s+!', '',html_escape($this->input->post('service_id', true))));
            $customer = $this->master_db->getRecords('customers','id='.$user_id.' and status = 1','id');
            if(count($customer)){
                $data = array();
                $condition = "c.status = 1 and s.status = 1 and c.is_service = 1";
                $list = $this->app_db->getServiceCategory($condition);
                //echo '<pre>';print_r($list);exit;
                foreach($list as $item){
                    $row = array(
                        'cat_id'    =>  $item->id,
                        'title'     =>  $item->title,
                        'service'   =>  array()
                    );
                    $condition = "c.id = $user_id and ps.status = 1 and s.status = 1 and s.subcat_id = ".$item->id;
                    $services = $this->app_db->getServiceList($condition);
                    //echo '<pre>';print_r($services);exit;    
                    $service_list = array();
                    foreach($services as $se){

                        $condition = "customer_id = $user_id and service_id = $se->id and status = 1 ";
                        $cdata = $this->master_db->getRecords('cust_service',$condition,'id,customer_id,service_id','id desc');
                        //echo '<pre>';print_r($cdata);continue;

                        $sdata = array();
                        if(count($cdata)){
                            $sdata = array(
                                'service_id'    =>  $se->id,
                                'title'         =>  $se->name,
                                'fields'        =>  array(),
                                'measurement_id'=>  0
                            );

                            $fields = $this->master_db->getRecords('service_fields',"service_id=$se->id and status = 1",'id,order_no,label,note','order_no asc'); 
                            //echo '<pre>';print_r($cdata);print_r($fields);exit;
                            foreach($fields as $f){
                                $value = '';
                                $condition = "main_id = ".$cdata[0]->id." and field_id = $f->id and status = 1 ";
                                $fielddata = $this->master_db->getRecords('cust_service_field',$condition,'id,data','id desc');
                                if(count($fielddata)){
                                    $value = $fielddata[0]->data;
                                }

                                $sdata['fields'][] = array(
                                    'order' =>  $f->order_no,
                                    'label' =>  $f->label,
                                    'note'  =>  $f->note,
                                    'value' =>  $value
                                );
                                $sdata['measurement_id'] = $cdata[0]->id;
                            }
                            //echo '<pre>';print_r($service_data);exit;
                        }else{
                            $sdata = array(
                                'service_id'    =>  $se->id,
                                'title'         =>  $se->name,
                                'fields'        =>  array(),
                                'measurement_id'=>  0
                            );
                        }
                        $service_list[] =  $sdata;
                    }                    
                    $row['service'] = $service_list;
                    //echo '<pre>';print_r($services);exit;    
                    $data[] = $row;
                }
                //echo '<pre>';print_r($data);exit;
                $result = array('status'=>'success','data'=>$data);     
            }else{
                $result = array('status'=>'failure','msg'=>'Customer not found.');
            }
        }        
        echo json_encode($result);
    }

    function delete_tracked_post(){
        $result = array('status'=>'failure','msg'=>'Required fields are missing.');
        if( !empty($_POST['user_id']) && isset($_POST['measurement_id']) ){        
            $measurement_id = trim(preg_replace('!\s+!', '',html_escape($this->input->post('measurement_id', true))));
            $user_id = trim(preg_replace('!\s+!', '',html_escape($this->input->post('user_id', true))));
            $customer = $this->master_db->getRecords('customers','id='.$user_id.' and status = 1','id');
            if(count($customer)){
                $condition = "customer_id = $user_id and status = 1 and id = ".$measurement_id;
                $list = $this->master_db->getRecords('cust_service',$condition,'id');
                if(count($list)){
                    $this->master_db->updateRecord('cust_service',array('status'=>-1),array('id'=>$measurement_id));
                    $result = array('status'=>'success','msg'=>'Deleted successfully');     
                }else{
                    $result = array('status'=>'failure','msg'=>'Measurement not found.');
                }                
            }else{
                $result = array('status'=>'failure','msg'=>'Customer not found.');
            }
        }        
        echo json_encode($result);
    }

    //Bills functions
    function bill_post(){
        $result = array('status'=>'failure','msg'=>'Required fields are missing.');
        if( !empty($_POST['user_id']) ){
            $user_id = trim(preg_replace('!\s+!', '',html_escape($this->input->post('user_id', true))));
            $customer = $this->master_db->getRecords('customers','id='.$user_id.' and status = 1','id');
            if(count($customer)){
                $condition = "customer_id = $user_id and status = 1";
                $list = $this->master_db->getRecords('cust_bills',$condition,'id as bill_id,title,note,date,date,concat("'.app_asset_url().'",image) as image');
                $result = array('status'=>'success','data'=>$list);     
            }else{
                $result = array('status'=>'failure','msg'=>'Customer not found.');
            }
        }        
        echo json_encode($result);
    }

    function save_bill_post(){
        $result = array('status'=>'failure','msg'=>'Required fields are missing.');
        //echo '<pre>';print_r($_POST);print_r($_FILES);exit;
        if( !empty($_POST['user_id']) && !empty($_POST['title']) && !empty($_POST['date']) && !empty($_POST['bill_id'])  ){

            $user_id = trim(preg_replace('!\s+!', '',html_escape($this->input->post('user_id', true))));
            $bill_id = trim(preg_replace('!\s+!', '',html_escape($this->input->post('bill_id', true))));
            $title = trim(html_escape($this->input->post('title', true)));
            $date = trim(preg_replace('!\s+!', '',html_escape($this->input->post('date', true))));
            
            $note = '';
            if ( !empty($_POST['note']) ){
                $note = trim(html_escape($this->input->post('note', true)));
            }

            $customer = $this->master_db->getRecords('customers','id='.$user_id.' and status = 1','id');
            if(count($customer)){     
                $condition = 'customer_id='.$user_id.' and id = '.$bill_id.' and status = 1';
                $checkBill = $this->master_db->getRecords('cust_bills',$condition,'id');
                if(count($checkBill) == 0){
                    $result = array('status'=>'failure','msg'=>'Bill not found.');
                    echo json_encode($result);exit;
                }
                $update = array(
                    'title'         =>  $title,
                    'note'          =>  $note,
                    'date'          =>  date('Y-m-d H:i:s',strtotime($date)),
                    'updated_at'    =>  date("Y-m-d H:i:s")
                );
                //echo '<pre>';print_r($insert);exit;
                $this->master_db->updateRecord('cust_bills',$update,array('id'=>$bill_id));
                if( !empty($_FILES['image']['name']) ){
                    $config = array();
                    $config['upload_path'] = '../app_assets/bills/';  
                    $config['allowed_types'] = 'jpeg|jpg|png';
                    $config['max_size'] = 0;    
                    // I have chosen max size no limit 

                    $ext = pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION);
                    $new_name = $bill_id.'_'.time().'.'.$ext; 
                    $config['file_name'] = $new_name;
                    //Stored the new name into $config['file_name']
                    $this->load->library('upload', $config);
                    $this->upload->initialize($config);
                    if ( !$this->upload->do_upload('image') ) {
                        $error = array('error' => $this->upload->display_errors());
                        //echo '<pre>';print_r($error);exit;
                    } else {
                        $upload_data = $this->upload->data();
                        $update = array('image'=>'bills/'.$upload_data['file_name']);
                        $this->master_db->updateRecord('cust_bills',$update,array('id'=>$bill_id));
                    }
                }
                $result = array('status'=>'success','msg'=>'Bill saved successfully.');     
            }else{
                $result = array('status'=>'failure','msg'=>'Customer not found.');
            }
        }elseif( !empty($_POST['user_id']) && !empty($_POST['title']) && !empty($_POST['date']) ){

            $user_id = trim(preg_replace('!\s+!', '',html_escape($this->input->post('user_id', true))));
            $title = trim(html_escape($this->input->post('title', true)));
            $date = trim(preg_replace('!\s+!', '',html_escape($this->input->post('date', true))));

            $note = '';
            if ( !empty($_POST['note']) ){
                $note = trim(html_escape($this->input->post('note', true)));
            }
            
            $customer = $this->master_db->getRecords('customers','id='.$user_id.' and status = 1','id');
            if(count($customer)){                
                $insert = array(
                    'customer_id'   =>  $user_id,
                    'title'         =>  $title,
                    'note'          =>  $note,
                    'date'          =>  date('Y-m-d H:i:s',strtotime($date)),
                    'status'        =>  1,
                    'created_at'    =>  date("Y-m-d H:i:s")
                );
                //echo '<pre>';print_r($insert);exit;
                $id = $this->master_db->insertRecord('cust_bills',$insert);
                if( !empty($_FILES['image']['name']) ){
                    $config = array();
                    $config['upload_path'] = '../app_assets/bills/';  
                    $config['allowed_types'] = 'jpeg|jpg|png';
                    $config['max_size'] = 0;    
                    // I have chosen max size no limit 

                    $ext = pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION);
                    $new_name = $id.'_'.time().'.'.$ext; 
                    $config['file_name'] = $new_name;
                    //Stored the new name into $config['file_name']
                    $this->load->library('upload', $config);
                    $this->upload->initialize($config);
                    if ( !$this->upload->do_upload('image') ) {
                        $error = array('error' => $this->upload->display_errors());
                        //echo '<pre>';print_r($error);exit;
                    } else {
                        $upload_data = $this->upload->data();
                        $update = array('image'=>'bills/'.$upload_data['file_name']);
                        $this->master_db->updateRecord('cust_bills',$update,array('id'=>$id));
                    }
                }
                $result = array('status'=>'success','msg'=>'Bill saved successfully.');     
            }else{
                $result = array('status'=>'failure','msg'=>'Customer not found.');
            }
        }    
        echo json_encode($result);
    }

    function delete_bill_post(){
        $result = array('status'=>'failure','msg'=>'Required fields are missing.');
        if( !empty($_POST['user_id']) && isset($_POST['bill_id']) ){        
            $bill_id = trim(preg_replace('!\s+!', '',html_escape($this->input->post('bill_id', true))));
            $user_id = trim(preg_replace('!\s+!', '',html_escape($this->input->post('user_id', true))));
            $customer = $this->master_db->getRecords('customers','id='.$user_id.' and status = 1','id');
            if(count($customer)){
                $condition = "customer_id = $user_id and status = 1 and id = ".$bill_id;
                $list = $this->master_db->getRecords('cust_bills',$condition,'id');
                if(count($list)){
                    $this->master_db->updateRecord('cust_bills',array('status'=>-1),array('id'=>$bill_id));
                    $result = array('status'=>'success','msg'=>'Deleted successfully');     
                }else{
                    $result = array('status'=>'failure','msg'=>'Document not found.');
                }                
            }else{
                $result = array('status'=>'failure','msg'=>'Customer not found.');
            }
        }        
        echo json_encode($result);
    }

    //Lab test functions
    function labtest_post(){
        $result = array('status'=>'failure','msg'=>'Required fields are missing.');
        if( !empty($_POST['user_id']) ){
            $user_id = trim(preg_replace('!\s+!', '',html_escape($this->input->post('user_id', true))));
            $customer = $this->master_db->getRecords('customers','id='.$user_id.' and status = 1','id');
            if(count($customer)){
                $condition = "customer_id = $user_id and status = 1";
                $list = $this->master_db->getRecords('cust_labtests',$condition,'id as lab_id,test_name,test_result,note,date,concat("'.app_asset_url().'",image) as image');
                $result = array('status'=>'success','data'=>$list);     
            }else{
                $result = array('status'=>'failure','msg'=>'Customer not found.');
            }
        }        
        echo json_encode($result);
    }

    function save_labtest_post(){
        $result = array('status'=>'failure','msg'=>'Required fields are missing.');
        //echo '<pre>';print_r($_POST);print_r($_FILES);exit;
        if( !empty($_POST['user_id']) && !empty($_POST['test_name']) && !empty($_POST['test_result']) 
            && !empty($_POST['date']) && !empty($_POST['lab_id'])  ){

            $user_id = trim(preg_replace('!\s+!', '',html_escape($this->input->post('user_id', true))));
            $test_name = trim(html_escape($this->input->post('test_name', true)));
            $test_result = trim(html_escape($this->input->post('test_result', true)));
            $date = trim(preg_replace('!\s+!', '',html_escape($this->input->post('date', true))));
            $lab_id = trim(preg_replace('!\s+!', '',html_escape($this->input->post('lab_id', true))));
            
            $note = '';
            if ( !empty($_POST['note']) ){
                $note = trim(html_escape($this->input->post('note', true)));
            }

            $customer = $this->master_db->getRecords('customers','id='.$user_id.' and status = 1','id');
            if(count($customer)){     
                $condition = 'customer_id='.$user_id.' and id = '.$lab_id.' and status = 1';
                $checkBill = $this->master_db->getRecords('cust_labtests',$condition,'id');
                if(count($checkBill) == 0){
                    $result = array('status'=>'failure','msg'=>'Bill not found.');
                    echo json_encode($result);exit;
                }
                $update = array(
                    'test_name'     =>  $test_name,
                    'test_result'   =>  $test_result,
                    'note'          =>  $note,
                    'date'          =>  date('Y-m-d H:i:s',strtotime($date)),
                    'updated_at'    =>  date("Y-m-d H:i:s")
                );
                //echo '<pre>';print_r($insert);exit;
                $this->master_db->updateRecord('cust_labtests',$update,array('id'=>$lab_id));
                if( !empty($_FILES['image']['name']) ){
                    $config = array();
                    $config['upload_path'] = '../app_assets/labtests/';  
                    $config['allowed_types'] = 'jpeg|jpg|png';
                    $config['max_size'] = 0;    
                    // I have chosen max size no limit 

                    $ext = pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION);
                    $new_name = $lab_id.'_'.time().'.'.$ext; 
                    $config['file_name'] = $new_name;
                    //Stored the new name into $config['file_name']
                    $this->load->library('upload', $config);
                    $this->upload->initialize($config);
                    if ( !$this->upload->do_upload('image') ) {
                        $error = array('error' => $this->upload->display_errors());
                        //echo '<pre>';print_r($error);exit;
                    } else {
                        $upload_data = $this->upload->data();
                        $update = array('image'=>'labtests/'.$upload_data['file_name']);
                        $this->master_db->updateRecord('cust_labtests',$update,array('id'=>$lab_id));
                    }
                }
                $result = array('status'=>'success','msg'=>'Lab test saved successfully.');     
            }else{
                $result = array('status'=>'failure','msg'=>'Customer not found.');
            }
        }elseif( !empty($_POST['user_id']) && !empty($_POST['test_name']) && !empty($_POST['test_result']) 
                && !empty($_POST['date']) && !empty($_FILES['image']['name']) ){
                
            $user_id = trim(preg_replace('!\s+!', '',html_escape($this->input->post('user_id', true))));
            $test_name = trim(html_escape($this->input->post('test_name', true)));
            $test_result = trim(html_escape($this->input->post('test_result', true)));
            $date = trim(preg_replace('!\s+!', '',html_escape($this->input->post('date', true))));

            $note = '';
            if ( !empty($_POST['note']) ){
                $note = trim(html_escape($this->input->post('note', true)));
            }
            
            $customer = $this->master_db->getRecords('customers','id='.$user_id.' and status = 1','id');
            if(count($customer)){                
                $insert = array(
                    'customer_id'   =>  $user_id,
                    'test_name'     =>  $test_name,
                    'test_result'   =>  $test_result,
                    'note'          =>  $note,
                    'date'          =>  date('Y-m-d H:i:s',strtotime($date)),
                    'status'        =>  1,
                    'created_at'    =>  date("Y-m-d H:i:s")
                );
                //echo '<pre>';print_r($insert);exit;
                $id = $this->master_db->insertRecord('cust_labtests',$insert);
                if( !empty($_FILES['image']['name']) ){
                    $config = array();
                    $config['upload_path'] = '../app_assets/labtests/';  
                    $config['allowed_types'] = 'jpeg|jpg|png';
                    $config['max_size'] = 0;    
                    // I have chosen max size no limit 

                    $ext = pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION);
                    $new_name = $id.'_'.time().'.'.$ext; 
                    $config['file_name'] = $new_name;
                    //Stored the new name into $config['file_name']
                    $this->load->library('upload', $config);
                    $this->upload->initialize($config);
                    if ( !$this->upload->do_upload('image') ) {
                        $error = array('error' => $this->upload->display_errors());
                        //echo '<pre>';print_r($error);exit;
                    } else {
                        $upload_data = $this->upload->data();
                        $update = array('image'=>'labtests/'.$upload_data['file_name']);
                        $this->master_db->updateRecord('cust_labtests',$update,array('id'=>$id));
                    }
                }
                $result = array('status'=>'success','msg'=>'Lab test saved successfully.');     
            }else{
                $result = array('status'=>'failure','msg'=>'Customer not found.');
            }
        }    
        echo json_encode($result);
    }

    function delete_labtest_post(){
        $result = array('status'=>'failure','msg'=>'Required fields are missing.');
        if( !empty($_POST['user_id']) && isset($_POST['lab_id']) ){        
            $lab_id = trim(preg_replace('!\s+!', '',html_escape($this->input->post('lab_id', true))));
            $user_id = trim(preg_replace('!\s+!', '',html_escape($this->input->post('user_id', true))));
            $customer = $this->master_db->getRecords('customers','id='.$user_id.' and status = 1','id');
            if(count($customer)){
                $condition = "customer_id = $user_id and status = 1 and id = ".$lab_id;
                $list = $this->master_db->getRecords('cust_labtests',$condition,'id');
                if(count($list)){
                    $this->master_db->updateRecord('cust_labtests',array('status'=>-1),array('id'=>$lab_id));
                    $result = array('status'=>'success','msg'=>'Deleted successfully');     
                }else{
                    $result = array('status'=>'failure','msg'=>'Document not found.');
                }                
            }else{
                $result = array('status'=>'failure','msg'=>'Customer not found.');
            }
        }        
        echo json_encode($result);
    }

    //Doctor consult functions
    function doctor_consult_post(){
        $result = array('status'=>'failure','msg'=>'Required fields are missing.');
        if( !empty($_POST['user_id']) ){
            $user_id = trim(preg_replace('!\s+!', '',html_escape($this->input->post('user_id', true))));
            $customer = $this->master_db->getRecords('customers','id='.$user_id.' and status = 1','id');
            if(count($customer)){
                $condition = "customer_id = $user_id and status = 1";
                $select = "id as consult_id,doctor as doctor_name,specialty,phone,experience,consulted_on,comments";
                $list = $this->master_db->getRecords('cust_consults',$condition,$select);
                $result = array('status'=>'success','data'=>$list);     
            }else{
                $result = array('status'=>'failure','msg'=>'Customer not found.');
            }
        }        
        echo json_encode($result);
    }

    function save_doctor_consult_post(){
        $result = array('status'=>'failure','msg'=>'Required fields are missing.');
        //echo '<pre>';print_r($_POST);print_r($_FILES);exit;
        if( !empty($_POST['user_id']) && !empty($_POST['doctor_name']) && !empty($_POST['specialty']) 
            && !empty($_POST['phone']) && !empty($_POST['experience']) && !empty($_POST['consulted_on'])
            && !empty($_POST['consult_id'])  ){

            $user_id = trim(preg_replace('!\s+!', '',html_escape($this->input->post('user_id', true))));
            $doctor_name = trim(html_escape($this->input->post('doctor_name', true)));
            $specialty = trim(html_escape($this->input->post('specialty', true)));
            $phone = trim(preg_replace('!\s+!', '',html_escape($this->input->post('phone', true))));
            $experience = trim(html_escape($this->input->post('experience', true)));
            $consulted_on = trim(preg_replace('!\s+!', '',html_escape($this->input->post('consulted_on', true))));            
            $consult_id = trim(preg_replace('!\s+!', '',html_escape($this->input->post('consult_id', true))));            

            $comments = '';
            if ( !empty($_POST['comments']) ){
                $comments = trim(html_escape($this->input->post('comments', true)));
            }

            $customer = $this->master_db->getRecords('customers','id='.$user_id.' and status = 1','id');
            if(count($customer)){     
                $condition = 'customer_id='.$user_id.' and id = '.$consult_id.' and status = 1';
                $checkBill = $this->master_db->getRecords('cust_consults',$condition,'id');
                if(count($checkBill) == 0){
                    $result = array('status'=>'failure','msg'=>'Consult not found.');
                    echo json_encode($result);exit;
                }
                $update = array(
                    'doctor'        =>  $doctor_name,
                    'specialty'     =>  $specialty,
                    'phone'         =>  $phone,
                    'experience'    =>  $experience,
                    'consulted_on'  =>  date('Y-m-d',strtotime($consulted_on)),
                    'comments'      =>  $comments,
                    'updated_at'    =>  date("Y-m-d H:i:s")
                );
                //echo '<pre>';print_r($insert);exit;
                $this->master_db->updateRecord('cust_consults',$update,array('id'=>$consult_id));
                $result = array('status'=>'success','msg'=>'Consult saved successfully.');     
            }else{
                $result = array('status'=>'failure','msg'=>'Customer not found.');
            }
        }elseif( !empty($_POST['user_id']) && !empty($_POST['doctor_name']) && !empty($_POST['specialty']) 
                && !empty($_POST['phone']) && !empty($_POST['experience']) && !empty($_POST['consulted_on']) ){
                
            $user_id = trim(preg_replace('!\s+!', '',html_escape($this->input->post('user_id', true))));
            $doctor_name = trim(html_escape($this->input->post('doctor_name', true)));
            $specialty = trim(html_escape($this->input->post('specialty', true)));
            $phone = trim(preg_replace('!\s+!', '',html_escape($this->input->post('phone', true))));
            $experience = trim(html_escape($this->input->post('experience', true)));
            $consulted_on = trim(preg_replace('!\s+!', '',html_escape($this->input->post('consulted_on', true))));            

            $comments = '';
            if ( !empty($_POST['comments']) ){
                $comments = trim(html_escape($this->input->post('comments', true)));
            }
            
            $customer = $this->master_db->getRecords('customers','id='.$user_id.' and status = 1','id');
            if(count($customer)){                
                $insert = array(
                    'customer_id'   =>  $user_id,
                    'doctor'        =>  $doctor_name,
                    'specialty'     =>  $specialty,
                    'phone'         =>  $phone,
                    'experience'    =>  $experience,
                    'consulted_on'  =>  date('Y-m-d',strtotime($consulted_on)),
                    'comments'      =>  $comments,
                    'status'        =>  1,
                    'created_at'    =>  date("Y-m-d H:i:s")
                );
                //echo '<pre>';print_r($insert);exit;
                $id = $this->master_db->insertRecord('cust_consults',$insert);
                $result = array('status'=>'success','msg'=>'Consult saved successfully.');     
            }else{
                $result = array('status'=>'failure','msg'=>'Customer not found.');
            }
        }    
        echo json_encode($result);
    }

    function delete_doctor_consult_post(){
        $result = array('status'=>'failure','msg'=>'Required fields are missing.');
        if( !empty($_POST['user_id']) && isset($_POST['consult_id']) ){        
            $consult_id = trim(preg_replace('!\s+!', '',html_escape($this->input->post('consult_id', true))));
            $user_id = trim(preg_replace('!\s+!', '',html_escape($this->input->post('user_id', true))));
            $customer = $this->master_db->getRecords('customers','id='.$user_id.' and status = 1','id');
            if(count($customer)){
                $condition = "customer_id = $user_id and status = 1 and id = ".$consult_id;
                $list = $this->master_db->getRecords('cust_consults',$condition,'id');
                if(count($list)){
                    $this->master_db->updateRecord('cust_consults',array('status'=>-1),array('id'=>$consult_id));
                    $result = array('status'=>'success','msg'=>'Deleted successfully');     
                }else{
                    $result = array('status'=>'failure','msg'=>'Consult not found.');
                }                
            }else{
                $result = array('status'=>'failure','msg'=>'Customer not found.');
            }
        }        
        echo json_encode($result);
    }

    //Diagnosis functions
    function diagnosis_post(){
        $result = array('status'=>'failure','msg'=>'Required fields are missing.');
        if( !empty($_POST['user_id']) ){
            $user_id = trim(preg_replace('!\s+!', '',html_escape($this->input->post('user_id', true))));
            $customer = $this->master_db->getRecords('customers','id='.$user_id.' and status = 1','id');
            if(count($customer)){
                $condition = "customer_id = $user_id and status = 1";
                $select = "id as did,medical_diagnosis,note,special_diagnosis,special_note,conducted_on";
                $list = $this->master_db->getRecords('cust_diagnosis',$condition,$select);
                $result = array('status'=>'success','data'=>$list);     
            }else{
                $result = array('status'=>'failure','msg'=>'Customer not found.');
            }
        }        
        echo json_encode($result);
    }

    function save_diagnosis_post(){
        $result = array('status'=>'failure','msg'=>'Required fields are missing.');
        //echo '<pre>';print_r($_POST);print_r($_FILES);exit;
        if( !empty($_POST['user_id']) && !empty($_POST['medical_diagnosis']) && !empty($_POST['special_diagnosis']) 
            && !empty($_POST['conducted_on']) && !empty($_POST['did'])  ){

            $user_id = trim(preg_replace('!\s+!', '',html_escape($this->input->post('user_id', true))));
            $medical_diagnosis = trim(html_escape($this->input->post('medical_diagnosis', true)));
            $special_diagnosis = trim(html_escape($this->input->post('special_diagnosis', true)));
            $conducted_on = trim(preg_replace('!\s+!', '',html_escape($this->input->post('conducted_on', true))));            
            $did = trim(preg_replace('!\s+!', '',html_escape($this->input->post('did', true))));            

            $note = '';
            if ( !empty($_POST['note']) ){
                $note = trim(html_escape($this->input->post('note', true)));
            }

            $special_note = '';
            if ( !empty($_POST['special_note']) ){
                $special_note = trim(html_escape($this->input->post('special_note', true)));
            }

            $customer = $this->master_db->getRecords('customers','id='.$user_id.' and status = 1','id');
            if(count($customer)){     
                $condition = 'customer_id='.$user_id.' and id = '.$did.' and status = 1';
                $checkBill = $this->master_db->getRecords('cust_diagnosis',$condition,'id');
                if(count($checkBill) == 0){
                    $result = array('status'=>'failure','msg'=>'Diagnosis not found.');
                    echo json_encode($result);exit;
                }
                $update = array(
                    'medical_diagnosis' =>  $medical_diagnosis,
                    'special_diagnosis' =>  $special_diagnosis,
                    'special_note'      =>  $special_note,
                    'note'              =>  $note,
                    'conducted_on'      =>  date('Y-m-d',strtotime($conducted_on)),
                    'updated_at'        =>  date("Y-m-d H:i:s")
                );
                //echo '<pre>';print_r($insert);exit;
                $this->master_db->updateRecord('cust_diagnosis',$update,array('id'=>$did));
                $result = array('status'=>'success','msg'=>'Diagnosis saved successfully.');     
            }else{
                $result = array('status'=>'failure','msg'=>'Customer not found.');
            }
        }elseif( !empty($_POST['user_id']) && !empty($_POST['medical_diagnosis']) && !empty($_POST['special_diagnosis']) 
                && !empty($_POST['conducted_on']) ){
                
            $user_id = trim(preg_replace('!\s+!', '',html_escape($this->input->post('user_id', true))));
            $medical_diagnosis = trim(html_escape($this->input->post('medical_diagnosis', true)));
            $special_diagnosis = trim(html_escape($this->input->post('special_diagnosis', true)));
            $conducted_on = trim(preg_replace('!\s+!', '',html_escape($this->input->post('conducted_on', true))));            

            $note = '';
            if ( !empty($_POST['note']) ){
                $note = trim(html_escape($this->input->post('note', true)));
            }

            $special_note = '';
            if ( !empty($_POST['special_note']) ){
                $special_note = trim(html_escape($this->input->post('special_note', true)));
            }
            
            $customer = $this->master_db->getRecords('customers','id='.$user_id.' and status = 1','id');
            if(count($customer)){                
                $insert = array(
                    'customer_id'       =>  $user_id,
                    'medical_diagnosis' =>  $medical_diagnosis,
                    'special_diagnosis' =>  $special_diagnosis,
                    'special_note'      =>  $special_note,
                    'note'              =>  $note,
                    'conducted_on'      =>  date('Y-m-d',strtotime($conducted_on)),
                    'status'            =>  1,
                    'created_at'        =>  date("Y-m-d H:i:s")
                );
                //echo '<pre>';print_r($insert);exit;
                $id = $this->master_db->insertRecord('cust_diagnosis',$insert);
                $result = array('status'=>'success','msg'=>'Diagnosis saved successfully.');     
            }else{
                $result = array('status'=>'failure','msg'=>'Customer not found.');
            }
        }    
        echo json_encode($result);
    }

    function delete_diagnosis_post(){
        $result = array('status'=>'failure','msg'=>'Required fields are missing.');
        if( !empty($_POST['user_id']) && isset($_POST['did']) ){        
            $did = trim(preg_replace('!\s+!', '',html_escape($this->input->post('did', true))));
            $user_id = trim(preg_replace('!\s+!', '',html_escape($this->input->post('user_id', true))));
            $customer = $this->master_db->getRecords('customers','id='.$user_id.' and status = 1','id');
            if(count($customer)){
                $condition = "customer_id = $user_id and status = 1 and id = ".$did;
                $list = $this->master_db->getRecords('cust_diagnosis',$condition,'id');
                if(count($list)){
                    $this->master_db->updateRecord('cust_diagnosis',array('status'=>-1),array('id'=>$did));
                    $result = array('status'=>'success','msg'=>'Deleted successfully');     
                }else{
                    $result = array('status'=>'failure','msg'=>'Diagnosis not found.');
                }                
            }else{
                $result = array('status'=>'failure','msg'=>'Customer not found.');
            }
        }        
        echo json_encode($result);
    }    

    //insurance functions
    function insurance_post(){
        $result = array('status'=>'failure','msg'=>'Required fields are missing.');
        if( !empty($_POST['user_id']) ){
            $user_id = trim(preg_replace('!\s+!', '',html_escape($this->input->post('user_id', true))));
            $customer = $this->master_db->getRecords('customers','id='.$user_id.' and status = 1','id');
            if(count($customer)){
                $condition = "customer_id = $user_id and status = 1";
                $select = "id as iid,insurance_name,policy_number,plan_date,expiry_date,amount";
                $list = $this->master_db->getRecords('cust_insurance',$condition,$select);
                $result = array('status'=>'success','data'=>$list);     
            }else{
                $result = array('status'=>'failure','msg'=>'Customer not found.');
            }
        }        
        echo json_encode($result);
    }

    function save_insurance_post(){
        $result = array('status'=>'failure','msg'=>'Required fields are missing.');
        //echo '<pre>';print_r($_POST);print_r($_FILES);exit;
        if( !empty($_POST['user_id']) && !empty($_POST['insurance_name']) && !empty($_POST['policy_number']) 
            && !empty($_POST['plan_date']) && !empty($_POST['expiry_date']) && !empty($_POST['amount']) 
            && !empty($_POST['iid'])  ){

            $user_id = trim(preg_replace('!\s+!', '',html_escape($this->input->post('user_id', true))));
            $insurance_name = trim(html_escape($this->input->post('insurance_name', true)));
            $policy_number = trim(preg_replace('!\s+!', '',html_escape($this->input->post('policy_number', true))));            
            $plan_date = trim(preg_replace('!\s+!', '',html_escape($this->input->post('plan_date', true))));            
            $expiry_date = trim(preg_replace('!\s+!', '',html_escape($this->input->post('expiry_date', true))));            
            $amount = trim(preg_replace('!\s+!', '',html_escape($this->input->post('amount', true))));            
            $iid = trim(preg_replace('!\s+!', '',html_escape($this->input->post('iid', true))));            

            $customer = $this->master_db->getRecords('customers','id='.$user_id.' and status = 1','id');
            if(count($customer)){     
                $condition = 'customer_id='.$user_id.' and id = '.$iid.' and status = 1';
                $checkBill = $this->master_db->getRecords('cust_insurance',$condition,'id');
                if(count($checkBill) == 0){
                    $result = array('status'=>'failure','msg'=>'Insurance not found.');
                    echo json_encode($result);exit;
                }
                $update = array(
                    'insurance_name'    =>  $insurance_name,
                    'policy_number'     =>  $policy_number,
                    'plan_date'         =>  date('Y-m-d',strtotime($plan_date)),
                    'expiry_date'       =>  date('Y-m-d',strtotime($expiry_date)),
                    'amount'            =>  $amount,
                    'updated_at'        =>  date("Y-m-d H:i:s")
                );
                //echo '<pre>';print_r($insert);exit;
                $this->master_db->updateRecord('cust_insurance',$update,array('id'=>$iid));
                $result = array('status'=>'success','msg'=>'Insurance saved successfully.');     
            }else{
                $result = array('status'=>'failure','msg'=>'Customer not found.');
            }
        }elseif( !empty($_POST['user_id']) && !empty($_POST['insurance_name']) && !empty($_POST['policy_number']) 
                && !empty($_POST['plan_date']) && !empty($_POST['expiry_date']) && !empty($_POST['amount']) ){
                
            $user_id = trim(preg_replace('!\s+!', '',html_escape($this->input->post('user_id', true))));
            $insurance_name = trim(html_escape($this->input->post('insurance_name', true)));
            $policy_number = trim(preg_replace('!\s+!', '',html_escape($this->input->post('policy_number', true))));            
            $plan_date = trim(preg_replace('!\s+!', '',html_escape($this->input->post('plan_date', true))));            
            $expiry_date = trim(preg_replace('!\s+!', '',html_escape($this->input->post('expiry_date', true))));            
            $amount = trim(preg_replace('!\s+!', '',html_escape($this->input->post('amount', true))));            
            
            $customer = $this->master_db->getRecords('customers','id='.$user_id.' and status = 1','id');
            if(count($customer)){                
                $insert = array(
                    'customer_id'       =>  $user_id,
                    'insurance_name'    =>  $insurance_name,
                    'policy_number'     =>  $policy_number,
                    'plan_date'         =>  date('Y-m-d',strtotime($plan_date)),
                    'expiry_date'       =>  date('Y-m-d',strtotime($expiry_date)),
                    'amount'            =>  $amount,
                    'status'            =>  1,
                    'created_at'        =>  date("Y-m-d H:i:s")
                );
                //echo '<pre>';print_r($insert);exit;
                $id = $this->master_db->insertRecord('cust_insurance',$insert);
                $result = array('status'=>'success','msg'=>'Insurance saved successfully.');     
            }else{
                $result = array('status'=>'failure','msg'=>'Customer not found.');
            }
        }    
        echo json_encode($result);
    }

    function delete_insurance_post(){
        $result = array('status'=>'failure','msg'=>'Required fields are missing.');
        if( !empty($_POST['user_id']) && isset($_POST['iid']) ){        
            $iid = trim(preg_replace('!\s+!', '',html_escape($this->input->post('iid', true))));
            $user_id = trim(preg_replace('!\s+!', '',html_escape($this->input->post('user_id', true))));
            $customer = $this->master_db->getRecords('customers','id='.$user_id.' and status = 1','id');
            if(count($customer)){
                $condition = "customer_id = $user_id and status = 1 and id = ".$iid;
                $list = $this->master_db->getRecords('cust_insurance',$condition,'id');
                if(count($list)){
                    $this->master_db->updateRecord('cust_insurance',array('status'=>-1),array('id'=>$iid));
                    $result = array('status'=>'success','msg'=>'Deleted successfully');     
                }else{
                    $result = array('status'=>'failure','msg'=>'Insurance not found.');
                }                
            }else{
                $result = array('status'=>'failure','msg'=>'Customer not found.');
            }
        }        
        echo json_encode($result);
    }    

    //medicine functions
    function medicine_post(){
        $result = array('status'=>'failure','msg'=>'Required fields are missing.');
        if( !empty($_POST['user_id']) ){
            $user_id = trim(preg_replace('!\s+!', '',html_escape($this->input->post('user_id', true))));
            $customer = $this->master_db->getRecords('customers','id='.$user_id.' and status = 1','id');
            if(count($customer)){
                $condition = "customer_id = $user_id and status = 1";
                $select = "id as mid,medicine_name,medicine_strength,how_often,pdate as prescription_date,reason";
                $list = $this->master_db->getRecords('cust_medicine',$condition,$select);
                $result = array('status'=>'success','data'=>$list);     
            }else{
                $result = array('status'=>'failure','msg'=>'Customer not found.');
            }
        }        
        echo json_encode($result);
    }

    function save_medicine_post(){
        $result = array('status'=>'failure','msg'=>'Required fields are missing.');
        //echo '<pre>';print_r($_POST);print_r($_FILES);exit;
        if( !empty($_POST['user_id']) && !empty($_POST['medicine_name']) && !empty($_POST['medicine_strength']) 
            && !empty($_POST['how_often']) && !empty($_POST['prescription_date']) && !empty($_POST['reason']) 
            && !empty($_POST['mid'])  ){

            $user_id = trim(preg_replace('!\s+!', '',html_escape($this->input->post('user_id', true))));
            $medicine_name = trim(html_escape($this->input->post('medicine_name', true)));
            $medicine_strength = trim(preg_replace('!\s+!', '',html_escape($this->input->post('medicine_strength', true))));            
            $how_often = trim(html_escape($this->input->post('how_often', true)));
            $prescription_date = trim(preg_replace('!\s+!', '',html_escape($this->input->post('prescription_date', true))));            
            $reason = trim(html_escape($this->input->post('reason', true)));
            $mid = trim(preg_replace('!\s+!', '',html_escape($this->input->post('mid', true))));            

            $customer = $this->master_db->getRecords('customers','id='.$user_id.' and status = 1','id');
            if(count($customer)){     
                $condition = 'customer_id='.$user_id.' and id = '.$mid.' and status = 1';
                $checkBill = $this->master_db->getRecords('cust_medicine',$condition,'id');
                if(count($checkBill) == 0){
                    $result = array('status'=>'failure','msg'=>'Medicine not found.');
                    echo json_encode($result);exit;
                }
                $update = array(
                    'medicine_name'     =>  $medicine_name,
                    'medicine_strength' =>  $medicine_strength,
                    'how_often'         =>  $how_often,
                    'pdate'             =>  date('Y-m-d',strtotime($prescription_date)),
                    'reason'            =>  $reason,
                    'updated_at'        =>  date("Y-m-d H:i:s")
                );
                //echo '<pre>';print_r($insert);exit;
                $this->master_db->updateRecord('cust_medicine',$update,array('id'=>$mid));
                $result = array('status'=>'success','msg'=>'Medicine saved successfully.');     
            }else{
                $result = array('status'=>'failure','msg'=>'Customer not found.');
            }
        }elseif( !empty($_POST['user_id']) && !empty($_POST['medicine_name']) && !empty($_POST['medicine_strength']) 
                && !empty($_POST['how_often']) && !empty($_POST['prescription_date']) && !empty($_POST['reason'])  ){
                
            $user_id = trim(preg_replace('!\s+!', '',html_escape($this->input->post('user_id', true))));
            $medicine_name = trim(html_escape($this->input->post('medicine_name', true)));
            $medicine_strength = trim(preg_replace('!\s+!', '',html_escape($this->input->post('medicine_strength', true))));            
            $how_often = trim(html_escape($this->input->post('how_often', true)));
            $prescription_date = trim(preg_replace('!\s+!', '',html_escape($this->input->post('prescription_date', true))));            
            $reason = trim(html_escape($this->input->post('reason', true)));            
            
            $customer = $this->master_db->getRecords('customers','id='.$user_id.' and status = 1','id');
            if(count($customer)){                
                $insert = array(
                    'customer_id'       =>  $user_id,
                    'medicine_name'     =>  $medicine_name,
                    'medicine_strength' =>  $medicine_strength,
                    'how_often'         =>  $how_often,
                    'pdate'             =>  date('Y-m-d',strtotime($prescription_date)),
                    'reason'            =>  $reason,
                    'status'            =>  1,
                    'created_at'        =>  date("Y-m-d H:i:s")
                );
                //echo '<pre>';print_r($insert);exit;
                $id = $this->master_db->insertRecord('cust_medicine',$insert);
                $result = array('status'=>'success','msg'=>'Medicine saved successfully.');     
            }else{
                $result = array('status'=>'failure','msg'=>'Customer not found.');
            }
        }    
        echo json_encode($result);
    }

    function delete_medicine_post(){
        $result = array('status'=>'failure','msg'=>'Required fields are missing.');
        if( !empty($_POST['user_id']) && isset($_POST['mid']) ){        
            $mid = trim(preg_replace('!\s+!', '',html_escape($this->input->post('mid', true))));
            $user_id = trim(preg_replace('!\s+!', '',html_escape($this->input->post('user_id', true))));
            $customer = $this->master_db->getRecords('customers','id='.$user_id.' and status = 1','id');
            if(count($customer)){
                $condition = "customer_id = $user_id and status = 1 and id = ".$mid;
                $list = $this->master_db->getRecords('cust_medicine',$condition,'id');
                if(count($list)){
                    $this->master_db->updateRecord('cust_medicine',array('status'=>-1),array('id'=>$mid));
                    $result = array('status'=>'success','msg'=>'Deleted successfully');     
                }else{
                    $result = array('status'=>'failure','msg'=>'Medicine not found.');
                }                
            }else{
                $result = array('status'=>'failure','msg'=>'Customer not found.');
            }
        }        
        echo json_encode($result);
    }
    
    //surgery functions
    function surgery_post(){
        $result = array('status'=>'failure','msg'=>'Required fields are missing.');
        if( !empty($_POST['user_id']) ){
            $user_id = trim(preg_replace('!\s+!', '',html_escape($this->input->post('user_id', true))));
            $customer = $this->master_db->getRecords('customers','id='.$user_id.' and status = 1','id');
            if(count($customer)){
                $condition = "customer_id = $user_id and status = 1";
                $select = "id as sid,procedure_name,procedure_comment,special_procedure,special_comment,conducted_on";
                $list = $this->master_db->getRecords('cust_surgery',$condition,$select);
                $result = array('status'=>'success','data'=>$list);     
            }else{
                $result = array('status'=>'failure','msg'=>'Customer not found.');
            }
        }        
        echo json_encode($result);
    }

    function save_surgery_post(){
        $result = array('status'=>'failure','msg'=>'Required fields are missing.');
        //echo '<pre>';print_r($_POST);print_r($_FILES);exit;
        if( !empty($_POST['user_id']) && !empty($_POST['procedure_name']) && !empty($_POST['procedure_comment']) 
            && !empty($_POST['conducted_on']) && !empty($_POST['sid'])  ){

            $user_id = trim(preg_replace('!\s+!', '',html_escape($this->input->post('user_id', true))));
            $procedure_name = trim(html_escape($this->input->post('procedure_name', true)));
            $procedure_comment = trim(html_escape($this->input->post('procedure_comment', true)));
            $special_procedure = trim(html_escape($this->input->post('special_procedure', true)));
            $special_comment = trim(html_escape($this->input->post('special_comment', true)));
            $reason = trim(html_escape($this->input->post('reason', true)));
            $conducted_on = trim(preg_replace('!\s+!', '',html_escape($this->input->post('conducted_on', true))));            
            $sid = trim(preg_replace('!\s+!', '',html_escape($this->input->post('sid', true))));            

            $customer = $this->master_db->getRecords('customers','id='.$user_id.' and status = 1','id');
            if(count($customer)){     
                $condition = 'customer_id='.$user_id.' and id = '.$sid.' and status = 1';
                $checkBill = $this->master_db->getRecords('cust_surgery',$condition,'id');
                if(count($checkBill) == 0){
                    $result = array('status'=>'failure','msg'=>'Surgery not found.');
                    echo json_encode($result);exit;
                }
                $update = array(
                    'procedure_name'    =>  $procedure_name,
                    'procedure_comment' =>  $procedure_comment,
                    'special_procedure' =>  $special_procedure,
                    'special_comment'   =>  $special_comment,
                    'conducted_on'      =>  date('Y-m-d',strtotime($conducted_on)),
                    'updated_at'        =>  date("Y-m-d H:i:s")
                );
                //echo '<pre>';print_r($insert);exit;
                $this->master_db->updateRecord('cust_surgery',$update,array('id'=>$sid));
                $result = array('status'=>'success','msg'=>'Surgery saved successfully.');     
            }else{
                $result = array('status'=>'failure','msg'=>'Customer not found.');
            }
        }elseif( !empty($_POST['user_id']) && !empty($_POST['procedure_name']) && !empty($_POST['procedure_comment']) 
                && !empty($_POST['conducted_on'])  ){
                
            $user_id = trim(preg_replace('!\s+!', '',html_escape($this->input->post('user_id', true))));
            $procedure_name = trim(html_escape($this->input->post('procedure_name', true)));
            $procedure_comment = trim(html_escape($this->input->post('procedure_comment', true)));
            $special_procedure = trim(html_escape($this->input->post('special_procedure', true)));
            $special_comment = trim(html_escape($this->input->post('special_comment', true)));
            $conducted_on = trim(preg_replace('!\s+!', '',html_escape($this->input->post('conducted_on', true))));                
            
            $customer = $this->master_db->getRecords('customers','id='.$user_id.' and status = 1','id');
            if(count($customer)){                
                $insert = array(
                    'customer_id'       =>  $user_id,
                    'procedure_name'    =>  $procedure_name,
                    'procedure_comment' =>  $procedure_comment,
                    'special_procedure' =>  $special_procedure,
                    'special_comment'   =>  $special_comment,
                    'conducted_on'      =>  date('Y-m-d',strtotime($conducted_on)),
                    'status'            =>  1,
                    'created_at'        =>  date("Y-m-d H:i:s")
                );
                //echo '<pre>';print_r($insert);exit;
                $id = $this->master_db->insertRecord('cust_surgery',$insert);
                $result = array('status'=>'success','msg'=>'Surgery saved successfully.');     
            }else{
                $result = array('status'=>'failure','msg'=>'Customer not found.');
            }
        }    
        echo json_encode($result);
    }

    function delete_surgery_post(){
        $result = array('status'=>'failure','msg'=>'Required fields are missing.');
        if( !empty($_POST['user_id']) && isset($_POST['sid']) ){        
            $sid = trim(preg_replace('!\s+!', '',html_escape($this->input->post('sid', true))));
            $user_id = trim(preg_replace('!\s+!', '',html_escape($this->input->post('user_id', true))));
            $customer = $this->master_db->getRecords('customers','id='.$user_id.' and status = 1','id');
            if(count($customer)){
                $condition = "customer_id = $user_id and status = 1 and id = ".$sid;
                $list = $this->master_db->getRecords('cust_surgery',$condition,'id');
                if(count($list)){
                    $this->master_db->updateRecord('cust_surgery',array('status'=>-1),array('id'=>$sid));
                    $result = array('status'=>'success','msg'=>'Deleted successfully');     
                }else{
                    $result = array('status'=>'failure','msg'=>'Surgery not found.');
                }                
            }else{
                $result = array('status'=>'failure','msg'=>'Customer not found.');
            }
        }        
        echo json_encode($result);
    }

    //Radiology functions
    function radiology_post(){
        //echo '<pre>';print_r($_POST);exit;
        $result = array('status'=>'failure','msg'=>'Required fields are missing.');
        if( !empty($_POST['user_id']) ){
            $user_id = trim(preg_replace('!\s+!', '',html_escape($this->input->post('user_id', true))));
            $customer = $this->master_db->getRecords('customers','id='.$user_id.' and status = 1','id');
            if(count($customer)){
                $condition = "customer_id = $user_id and status = 1";
                $select = "id as rid,title,result,doctor,date,concat('".app_asset_url()."',image) as image";
                $list = $this->master_db->getRecords('cust_radiology',$condition,$select);
                $result = array('status'=>'success','data'=>$list);     
            }else{
                $result = array('status'=>'failure','msg'=>'Customer not found.');
            }
        }        
        echo json_encode($result);
    }

    function save_radiology_post(){
        $result = array('status'=>'failure','msg'=>'Required fields are missing.');
        //echo '<pre>';print_r($_POST);print_r($_FILES);exit;
        if( !empty($_POST['user_id']) && !empty($_POST['title']) && !empty($_POST['result']) 
            && !empty($_POST['doctor']) && !empty($_POST['date']) && !empty($_POST['rid']) ){

            $user_id = trim(preg_replace('!\s+!', '',html_escape($this->input->post('user_id', true))));
            $title = trim(html_escape($this->input->post('title', true)));
            $result = trim(html_escape($this->input->post('result', true)));
            $doctor = trim(html_escape($this->input->post('doctor', true)));
            $date = trim(preg_replace('!\s+!', '',html_escape($this->input->post('date', true))));            
            $rid = trim(preg_replace('!\s+!', '',html_escape($this->input->post('rid', true))));            

            $customer = $this->master_db->getRecords('customers','id='.$user_id.' and status = 1','id');
            if(count($customer)){     
                $condition = 'customer_id='.$user_id.' and id = '.$rid.' and status = 1';
                $checkBill = $this->master_db->getRecords('cust_radiology',$condition,'id');
                if(count($checkBill) == 0){
                    $result = array('status'=>'failure','msg'=>'Radiology not found.');
                    echo json_encode($result);exit;
                }
                $update = array(
                    'title'             =>  $title,
                    'result'            =>  $result,
                    'doctor'            =>  $doctor,
                    'date'              =>  date('Y-m-d',strtotime($date)),
                    'updated_at'        =>  date("Y-m-d H:i:s")
                );

                if( !empty($_FILES['image']['name']) ){
                    $config = array();
                    $config['upload_path'] = '../app_assets/radiology/';  
                    $config['allowed_types'] = 'pdf|jpeg|jpg|png';
                    $config['max_size'] = 0;    
                    // I have chosen max size no limit 
                    //$new_name = $code.'_'. $_FILES["document"]['name']; 
                    $ext = pathinfo($_FILES["image"]['name'], PATHINFO_EXTENSION);
                    $new_name = $rid.'_'.time().'.'.$ext; 
    
                    $config['file_name'] = $new_name;
                    //Stored the new name into $config['file_name']
                    $this->load->library('upload', $config);
                    if (!$this->upload->do_upload('image') && !empty($_FILES['image']['name'])) {
                        $error = array('error' => $this->upload->display_errors());
                        //echo '<pre>';print_r($error);exit;
                    } else {
                        $upload_data = $this->upload->data();
                        //echo '<pre>';print_r($upload_data);exit;
                        $update['image'] = 'radiology/'.$upload_data['file_name'];
                    }
                }

                //echo '<pre>';print_r($insert);exit;
                $this->master_db->updateRecord('cust_radiology',$update,array('id'=>$rid));
                $result = array('status'=>'success','msg'=>'Radiology saved successfully.');     
            }else{
                $result = array('status'=>'failure','msg'=>'Customer not found.');
            }
        }elseif( !empty($_POST['user_id']) && !empty($_POST['title']) && !empty($_POST['result']) 
                && !empty($_POST['doctor']) && !empty($_POST['date']) ){
                
            $user_id = trim(preg_replace('!\s+!', '',html_escape($this->input->post('user_id', true))));
            $title = trim(html_escape($this->input->post('title', true)));
            $result = trim(html_escape($this->input->post('result', true)));
            $doctor = trim(html_escape($this->input->post('doctor', true)));
            $date = trim(preg_replace('!\s+!', '',html_escape($this->input->post('date', true))));                  
            
            $customer = $this->master_db->getRecords('customers','id='.$user_id.' and status = 1','id');
            if(count($customer)){                
                $insert = array(
                    'customer_id'       =>  $user_id,
                    'title'             =>  $title,
                    'result'            =>  $result,
                    'doctor'            =>  $doctor,
                    'date'              =>  date('Y-m-d',strtotime($date)),
                    'status'            =>  1,
                    'created_at'        =>  date("Y-m-d H:i:s")
                );
                //echo '<pre>';print_r($insert);exit;
                $rid = $this->master_db->insertRecord('cust_radiology',$insert);

                if( !empty($_FILES['image']['name']) ){
                    $config = array();
                    $config['upload_path'] = '../app_assets/radiology/';  
                    $config['allowed_types'] = 'pdf|jpeg|jpg|png';
                    $config['max_size'] = 0;    
                    // I have chosen max size no limit 
                    //$new_name = $code.'_'. $_FILES["document"]['name']; 
                    $ext = pathinfo($_FILES["image"]['name'], PATHINFO_EXTENSION);
                    $new_name = $rid.'_'.time().'.'.$ext; 
    
                    $config['file_name'] = $new_name;
                    //Stored the new name into $config['file_name']
                    $this->load->library('upload', $config);
                    if (!$this->upload->do_upload('image') && !empty($_FILES['image']['name'])) {
                        $error = array('error' => $this->upload->display_errors());
                        //echo '<pre>';print_r($error);exit;
                    } else {
                        $upload_data = $this->upload->data();
                        //echo '<pre>';print_r($upload_data);exit;
                        $update['image'] = 'radiology/'.$upload_data['file_name'];
                        $this->master_db->updateRecord('cust_radiology',$update,array('id'=>$rid));
                    }
                }

                $result = array('status'=>'success','msg'=>'Radiology saved successfully.');     
            }else{
                $result = array('status'=>'failure','msg'=>'Customer not found.');
            }
        }    
        echo json_encode($result);
    }

    function delete_radiology_post(){
        $result = array('status'=>'failure','msg'=>'Required fields are missing.');
        if( !empty($_POST['user_id']) && isset($_POST['rid']) ){        
            $rid = trim(preg_replace('!\s+!', '',html_escape($this->input->post('rid', true))));
            $user_id = trim(preg_replace('!\s+!', '',html_escape($this->input->post('user_id', true))));
            $customer = $this->master_db->getRecords('customers','id='.$user_id.' and status = 1','id');
            if(count($customer)){
                $condition = "customer_id = $user_id and status = 1 and id = ".$rid;
                $list = $this->master_db->getRecords('cust_radiology',$condition,'id');
                if(count($list)){
                    $this->master_db->updateRecord('cust_radiology',array('status'=>-1),array('id'=>$rid));
                    $result = array('status'=>'success','msg'=>'Deleted successfully');     
                }else{
                    $result = array('status'=>'failure','msg'=>'Radiology not found.');
                }                
            }else{
                $result = array('status'=>'failure','msg'=>'Customer not found.');
            }
        }        
        echo json_encode($result);
    }

    //Pathology functions
    function pathology_post(){
        //echo '<pre>';print_r($_POST);exit;
        $result = array('status'=>'failure','msg'=>'Required fields are missing.');
        if( !empty($_POST['user_id']) ){
            $user_id = trim(preg_replace('!\s+!', '',html_escape($this->input->post('user_id', true))));
            $customer = $this->master_db->getRecords('customers','id='.$user_id.' and status = 1','id');
            if(count($customer)){
                $condition = "customer_id = $user_id and status = 1";
                $select = "id as pid,title,result,doctor,date,concat('".app_asset_url()."',image) as image";
                $list = $this->master_db->getRecords('cust_pathology',$condition,$select);
                $result = array('status'=>'success','data'=>$list);     
            }else{
                $result = array('status'=>'failure','msg'=>'Customer not found.');
            }
        }        
        echo json_encode($result);
    }

    function save_pathology_post(){
        $result = array('status'=>'failure','msg'=>'Required fields are missing.');
        //echo '<pre>';print_r($_POST);print_r($_FILES);exit;
        if( !empty($_POST['user_id']) && !empty($_POST['title']) && !empty($_POST['result']) 
            && !empty($_POST['doctor']) && !empty($_POST['pid']) && !empty($_POST['date'])  ){

            $user_id = trim(preg_replace('!\s+!', '',html_escape($this->input->post('user_id', true))));
            $title = trim(html_escape($this->input->post('title', true)));
            $result = trim(html_escape($this->input->post('result', true)));
            $doctor = trim(html_escape($this->input->post('doctor', true)));
            $date = trim(preg_replace('!\s+!', '',html_escape($this->input->post('date', true))));            
            $pid = trim(preg_replace('!\s+!', '',html_escape($this->input->post('pid', true))));            

            $customer = $this->master_db->getRecords('customers','id='.$user_id.' and status = 1','id');
            if(count($customer)){     
                $condition = 'customer_id='.$user_id.' and id = '.$pid.' and status = 1';
                $checkBill = $this->master_db->getRecords('cust_pathology',$condition,'id');
                if(count($checkBill) == 0){
                    $result = array('status'=>'failure','msg'=>'Pathology not found.');
                    echo json_encode($result);exit;
                }
                $update = array(
                    'title'             =>  $title,
                    'result'            =>  $result,
                    'doctor'            =>  $doctor,
                    'date'              =>  date('Y-m-d',strtotime($date)),
                    'updated_at'        =>  date("Y-m-d H:i:s")
                );

                if( !empty($_FILES['image']['name']) ){
                    $config = array();
                    $config['upload_path'] = '../app_assets/pathology/';  
                    $config['allowed_types'] = 'pdf|jpeg|jpg|png';
                    $config['max_size'] = 0;    
                    // I have chosen max size no limit 
                    //$new_name = $code.'_'. $_FILES["document"]['name']; 
                    $ext = pathinfo($_FILES["image"]['name'], PATHINFO_EXTENSION);
                    $new_name = $pid.'_'.time().'.'.$ext; 
    
                    $config['file_name'] = $new_name;
                    //Stored the new name into $config['file_name']
                    $this->load->library('upload', $config);
                    if (!$this->upload->do_upload('image') && !empty($_FILES['image']['name'])) {
                        $error = array('error' => $this->upload->display_errors());
                        //echo '<pre>';print_r($error);exit;
                    } else {
                        $upload_data = $this->upload->data();
                        //echo '<pre>';print_r($upload_data);exit;
                        $update['image'] = 'pathology/'.$upload_data['file_name'];
                    }
                }

                //echo '<pre>';print_r($insert);exit;
                $this->master_db->updateRecord('cust_pathology',$update,array('id'=>$pid));
                $result = array('status'=>'success','msg'=>'Pathology saved successfully.');     
            }else{
                $result = array('status'=>'failure','msg'=>'Customer not found.');
            }
        }elseif( !empty($_POST['user_id']) && !empty($_POST['title']) && !empty($_POST['result']) 
                && !empty($_POST['doctor']) && !empty($_POST['date']) && !empty($_FILES['image']['name']) ){
                
            $user_id = trim(preg_replace('!\s+!', '',html_escape($this->input->post('user_id', true))));
            $title = trim(html_escape($this->input->post('title', true)));
            $result = trim(html_escape($this->input->post('result', true)));
            $doctor = trim(html_escape($this->input->post('doctor', true)));
            $date = trim(preg_replace('!\s+!', '',html_escape($this->input->post('date', true))));                  
            
            $customer = $this->master_db->getRecords('customers','id='.$user_id.' and status = 1','id');
            if(count($customer)){                
                $insert = array(
                    'customer_id'       =>  $user_id,
                    'title'             =>  $title,
                    'result'            =>  $result,
                    'doctor'            =>  $doctor,
                    'date'              =>  date('Y-m-d',strtotime($date)),
                    'status'            =>  1,
                    'created_at'        =>  date("Y-m-d H:i:s")
                );
                //echo '<pre>';print_r($insert);exit;
                $pid = $this->master_db->insertRecord('cust_pathology',$insert);

                if( !empty($_FILES['image']['name']) ){
                    $config = array();
                    $config['upload_path'] = '../app_assets/pathology/';  
                    $config['allowed_types'] = 'pdf|jpeg|jpg|png';
                    $config['max_size'] = 0;    
                    // I have chosen max size no limit 
                    //$new_name = $code.'_'. $_FILES["document"]['name']; 
                    $ext = pathinfo($_FILES["image"]['name'], PATHINFO_EXTENSION);
                    $new_name = $pid.'_'.time().'.'.$ext; 
    
                    $config['file_name'] = $new_name;
                    //Stored the new name into $config['file_name']
                    $this->load->library('upload', $config);
                    if (!$this->upload->do_upload('image') && !empty($_FILES['image']['name'])) {
                        $error = array('error' => $this->upload->display_errors());
                        //echo '<pre>';print_r($error);exit;
                    } else {
                        $upload_data = $this->upload->data();
                        //echo '<pre>';print_r($upload_data);exit;
                        $update['image'] = 'pathology/'.$upload_data['file_name'];
                        $this->master_db->updateRecord('cust_pathology',$update,array('id'=>$pid));
                    }
                }
                $result = array('status'=>'success','msg'=>'Pathology saved successfully.');     
            }else{
                $result = array('status'=>'failure','msg'=>'Customer not found.');
            }
        }    
        echo json_encode($result);
    }

    function delete_pathology_post(){
        $result = array('status'=>'failure','msg'=>'Required fields are missing.');
        if( !empty($_POST['user_id']) && isset($_POST['pid']) ){        
            $pid = trim(preg_replace('!\s+!', '',html_escape($this->input->post('pid', true))));
            $user_id = trim(preg_replace('!\s+!', '',html_escape($this->input->post('user_id', true))));
            $customer = $this->master_db->getRecords('customers','id='.$user_id.' and status = 1','id');
            if(count($customer)){
                $condition = "customer_id = $user_id and status = 1 and id = ".$pid;
                $list = $this->master_db->getRecords('cust_pathology',$condition,'id');
                if(count($list)){
                    $this->master_db->updateRecord('cust_pathology',array('status'=>-1),array('id'=>$pid));
                    $result = array('status'=>'success','msg'=>'Deleted successfully');     
                }else{
                    $result = array('status'=>'failure','msg'=>'Pathology not found.');
                }                
            }else{
                $result = array('status'=>'failure','msg'=>'Customer not found.');
            }
        }        
        echo json_encode($result);
    }

    //Services - Package Benefits
    function package_services_post(){
        //echo '<pre>';print_r($_POST);exit;
        $result = array('status'=>'failure','msg'=>'Required fields are missing.');
        if( !empty($_POST['user_id']) ){
            $user_id = trim(preg_replace('!\s+!', '',html_escape($this->input->post('user_id', true))));
            $service_id = trim(preg_replace('!\s+!', '',html_escape($this->input->post('service_id', true))));
            $customer = $this->master_db->getRecords('customers','id='.$user_id.' and status = 1','id');
            if(count($customer)){
                $data = array();
                $condition = "c.status = 1 and s.status = 1 and c.is_service = 1";
                $list = $this->app_db->getServiceCategory($condition);
                foreach($list as $item){
                    $row = array(
                        'cat_id'    =>  $item->id,
                        'title'     =>  $item->title,
                        'service'   =>  array()
                    );
                    $condition = "c.id = $user_id and ps.status = 1 and s.status = 1 and s.subcat_id = ".$item->id;
                    $services = $this->app_db->getServiceList($condition);
                    //echo '<pre>';print_r($services);exit;
                    $row['service']  = $services;
                    $data[] = $row;
                }
                //echo '<pre>';print_r($data);exit;
                $result = array('status'=>'success','data'=>$data);     
            }else{
                $result = array('status'=>'failure','msg'=>'Customer not found.');
            }
        }         
        echo json_encode($result);
    }

    //Health Tips functions
    function healthtips_post(){
        //echo '<pre>';print_r($_POST);exit;
        $result = array('status'=>'failure','msg'=>'Required fields are missing.');
        if( !empty($_POST['user_id']) ){
            $len = 10;    
            $start = 0;
            if( !empty($_POST['len']) ){
                $start = trim(preg_replace('!\s+!', '',html_escape($this->input->post('len', true))));
            }

            $user_id = trim(preg_replace('!\s+!', '',html_escape($this->input->post('user_id', true))));
            $customer = $this->master_db->getRecords('customers','id='.$user_id.' and status = 1','id');
            if(count($customer)){
                $condition = "hn.user_id= $user_id and hn.status = 1 and h.status = 1";
                $data = $this->app_db->gethealthtips($condition,$start,$len);
                //echo $this->db->last_query();echo '<pre>';print_r($data);exit;
                $result = array('status'=>'success','data'=>$data);     
            }else{
                $result = array('status'=>'failure','msg'=>'Customer not found.');
            }
        }         
        echo json_encode($result);
    }

    function view_healthtip_get(){
        $result = array('status'=>'failure','msg'=>'Required fields are missing.');
        if( !empty($_GET['user_id']) && !empty($_GET['hid']) ){
            //echo '<pre>';print_r($_GET);exit;
            $user_id = trim(preg_replace('!\s+!', '',html_escape($this->input->get('user_id', true))));
            $id = trim(preg_replace('!\s+!', '',html_escape($this->input->get('hid', true))));
            $customer = $this->master_db->getRecords('customers','id='.$user_id.' and status = 1','id');
            //echo '<pre>';print_r($customer);exit;
            if(count($customer)){
                $condition = "hn.user_id= $user_id and hn.status = 1 and h.status = 1 and h.id = $id";
                $this->data['tip'] = $this->app_db->gethealthtips($condition,0,1);
                //echo $this->db->last_query();exit;
                $this->load->view('healthtip_view',$this->data);
            }else{
                echo 'Customer not found.';
            }
        }else{
            echo "No data found.";
        }
    }

    //flashnews functions
    function flashnews_post(){
        //echo '<pre>';print_r($_POST);exit;
        $result = array('status'=>'failure','msg'=>'Required fields are missing.');
        if( !empty($_POST['user_id']) ){
            $len = 1;    
            $start = 0;
            if( !empty($_POST['len']) ){
                $start = trim(preg_replace('!\s+!', '',html_escape($this->input->post('len', true))));
            }

            $user_id = trim(preg_replace('!\s+!', '',html_escape($this->input->post('user_id', true))));
            $customer = $this->master_db->getRecords('customers','id='.$user_id.' and status = 1','id');
            if(count($customer)){
                $condition = "fn.user_id= $user_id and fn.status = 1 and f.status = 1";
                $data = $this->app_db->getflashnews($condition,$start,$len);
                //echo $this->db->last_query();echo '<pre>';print_r($data);exit;
                $result = array('status'=>'success','data'=>$data);     
            }else{
                $result = array('status'=>'failure','msg'=>'Customer not found.');
            }
        }         
        echo json_encode($result);
    }
    
    function view_flashnews_get(){
        $result = array('status'=>'failure','msg'=>'Required fields are missing.');
        if( !empty($_GET['user_id']) && !empty($_GET['fid']) ){
            $user_id = trim(preg_replace('!\s+!', '',html_escape($this->input->get('user_id', true))));
            $id = trim(preg_replace('!\s+!', '',html_escape($this->input->get('fid', true))));
            $customer = $this->master_db->getRecords('customers','id='.$user_id.' and status = 1','id');
            if(count($customer)){
                $condition = "fn.user_id= $user_id and fn.status = 1 and f.status = 1 and f.id = $id";
                $this->data['flash'] = $this->app_db->getflashnews($condition,0,1);
                //echo '<pre>';print_r($this->data['flash']);exit;
                //echo $this->db->last_query();exit;
                $this->load->view('flashnews_view',$this->data);
            }else{
                echo 'Customer not found.';
            }
        }else{
            echo "No data found.";
        }
    }

    //notifications functions
    function notifications_post(){
        //echo '<pre>';print_r($_POST);exit;
        $result = array('status'=>'failure','msg'=>'Required fields are missing.');
        if( !empty($_POST['user_id']) ){
            $len = 1;    
            $start = 0;
            if( !empty($_POST['len']) ){
                $start = trim(preg_replace('!\s+!', '',html_escape($this->input->post('len', true))));
            }

            $user_id = trim(preg_replace('!\s+!', '',html_escape($this->input->post('user_id', true))));
            $customer = $this->master_db->getRecords('customers','id='.$user_id.' and status = 1','id');
            if(count($customer)){
                $condition = "rn.user_id= $user_id and rn.status = 1 and n.status = 1";
                $data = $this->app_db->getnotifications($condition,$start,$len);
                //echo $this->db->last_query();echo '<pre>';print_r($data);exit;
                $result = array('status'=>'success','data'=>$data);     
            }else{
                $result = array('status'=>'failure','msg'=>'Customer not found.');
            }
        }         
        echo json_encode($result);
    }
    
    function view_notification_get(){
        $result = array('status'=>'failure','msg'=>'Required fields are missing.');
        if( !empty($_GET['user_id']) && !empty($_GET['nid']) ){
            $user_id = trim(preg_replace('!\s+!', '',html_escape($this->input->get('user_id', true))));
            $id = trim(preg_replace('!\s+!', '',html_escape($this->input->get('nid', true))));
            $customer = $this->master_db->getRecords('customers','id='.$user_id.' and status = 1','id');
            if(count($customer)){
                $condition = "rn.user_id= $user_id and rn.status = 1 and n.status = 1 and n.id = $id";
                $this->data['notify'] = $this->app_db->getnotifications($condition,0,1);
                //echo $this->db->last_query();echo '<pre>';print_r($this->data['notify']);exit;
                $this->load->view('notification_view',$this->data);
            }else{
                echo 'Customer not found.';
            }
        }else{
            echo "No data found.";
        }
    }

    //Vital functions
    function vital_post(){
        //echo '<pre>';print_r($_POST);exit;
        $result = array('status'=>'failure','msg'=>'Required fields are missing.');
        if( !empty($_POST['user_id']) ){
            $user_id = trim(preg_replace('!\s+!', '',html_escape($this->input->post('user_id', true))));
            $customer = $this->master_db->getRecords('customers','id='.$user_id.' and status = 1','id');
            if(count($customer)){
                $condition = "customer_id = $user_id and status = 1";
                $select = "id as vid,height,weight,bmi,spo2,pulse,bp,sugar_level,ecg,hemoglobin,tds,mac,distance_test,
                            near_vision_test,astigmatism,cvd_test,cholesterol,vascular_age,skin_carotenoid,capillary_shape,
                            heart_rate,report_date";
                $list = $this->master_db->getRecords('cust_vitals',$condition,$select);
                $result = array('status'=>'success','data'=>$list);     
            }else{
                $result = array('status'=>'failure','msg'=>'Customer not found.');
            }
        }        
        echo json_encode($result);
    }

    function save_vital_post(){
        $result = array('status'=>'failure','msg'=>'Required fields are missing.');
        //echo '<pre>';print_r($_POST);exit;
        if( !empty($_POST['user_id']) && !empty($_POST['vid']) && !empty($_POST['report_date'])  ){

            $user_id = trim(preg_replace('!\s+!', '',html_escape($this->input->post('user_id', true))));
            $vid = trim(preg_replace('!\s+!', '',html_escape($this->input->post('vid', true))));
            $height = trim(html_escape($this->input->post('height', true)));
            $weight = trim(html_escape($this->input->post('weight', true)));
            $bmi = trim(html_escape($this->input->post('bmi', true)));
            $spo2 = trim(html_escape($this->input->post('spo2', true)));
            $pulse = trim(html_escape($this->input->post('pulse', true)));
            $bp = trim(html_escape($this->input->post('bp', true)));
            $sugar_level = trim(html_escape($this->input->post('sugar_level', true)));
            $ecg = trim(html_escape($this->input->post('ecg', true)));
            $hemoglobin = trim(html_escape($this->input->post('hemoglobin', true)));
            $tds = trim(html_escape($this->input->post('tds', true)));
            $mac = trim(html_escape($this->input->post('mac', true)));
            $distance_test = trim(html_escape($this->input->post('distance_test', true)));
            $near_vision_test = trim(html_escape($this->input->post('near_vision_test', true)));
            $astigmatism = trim(html_escape($this->input->post('astigmatism', true)));
            $cvd_test = trim(html_escape($this->input->post('cvd_test', true)));
            $cholesterol = trim(html_escape($this->input->post('cholesterol', true)));
            $vascular_age = trim(html_escape($this->input->post('vascular_age', true)));
            $skin_carotenoid = trim(html_escape($this->input->post('skin_carotenoid', true)));
            $capillary_shape = trim(html_escape($this->input->post('capillary_shape', true)));
            $heart_rate = trim(html_escape($this->input->post('heart_rate', true)));
            $report_date = date('Y-m-d',strtotime(trim(html_escape($this->input->post('report_date', true)))));            

            $customer = $this->master_db->getRecords('customers','id='.$user_id.' and status = 1','id');
            if(count($customer)){     
                $condition = 'customer_id='.$user_id.' and id = '.$vid.' and status = 1';
                $checkBill = $this->master_db->getRecords('cust_vitals',$condition,'id');
                if(count($checkBill) == 0){
                    $result = array('status'=>'failure','msg'=>'Vital not found.');
                    echo json_encode($result);exit;
                }
                $update = array(
                    'height'            =>  $height,
                    'weight'            =>  $weight,
                    'bmi'               =>  $bmi,
                    'spo2'              =>  $spo2,
                    'pulse'             =>  $pulse,
                    'bp'                =>  $bp,
                    'sugar_level'       =>  $sugar_level,
                    'ecg'               =>  $ecg,
                    'hemoglobin'        =>  $hemoglobin,
                    'tds'               =>  $tds,
                    'mac'               =>  $mac,
                    'distance_test'     =>  $distance_test,
                    'near_vision_test'  =>  $near_vision_test,
                    'astigmatism'       =>  $astigmatism,
                    'cvd_test'          =>  $cvd_test,
                    'cholesterol'       =>  $cholesterol,
                    'vascular_age'      =>  $vascular_age,
                    'skin_carotenoid'   =>  $skin_carotenoid,
                    'capillary_shape'   =>  $capillary_shape,
                    'heart_rate'        =>  $heart_rate,
                    'report_date'       =>  $report_date,
                    'updated_at'        =>  date("Y-m-d H:i:s")
                );
                //echo '<pre>';print_r($insert);exit;
                $this->master_db->updateRecord('cust_vitals',$update,array('id'=>$vid));
                $result = array('status'=>'success','msg'=>'Vital saved successfully.');     
            }else{
                $result = array('status'=>'failure','msg'=>'Customer not found.');
            }
        }elseif( !empty($_POST['user_id']) && !empty($_POST['report_date']) ){
            $user_id = trim(preg_replace('!\s+!', '',html_escape($this->input->post('user_id', true))));
            $height = trim(html_escape($this->input->post('height', true)));
            $weight = trim(html_escape($this->input->post('weight', true)));
            $bmi = trim(html_escape($this->input->post('bmi', true)));
            $spo2 = trim(html_escape($this->input->post('spo2', true)));
            $pulse = trim(html_escape($this->input->post('pulse', true)));
            $bp = trim(html_escape($this->input->post('bp', true)));
            $sugar_level = trim(html_escape($this->input->post('sugar_level', true)));
            $ecg = trim(html_escape($this->input->post('ecg', true)));
            $hemoglobin = trim(html_escape($this->input->post('hemoglobin', true)));
            $tds = trim(html_escape($this->input->post('tds', true)));
            $mac = trim(html_escape($this->input->post('mac', true)));
            $distance_test = trim(html_escape($this->input->post('distance_test', true)));
            $near_vision_test = trim(html_escape($this->input->post('near_vision_test', true)));
            $astigmatism = trim(html_escape($this->input->post('astigmatism', true)));
            $cvd_test = trim(html_escape($this->input->post('cvd_test', true)));
            $cholesterol = trim(html_escape($this->input->post('cholesterol', true)));
            $vascular_age = trim(html_escape($this->input->post('vascular_age', true)));
            $skin_carotenoid = trim(html_escape($this->input->post('skin_carotenoid', true)));
            $capillary_shape = trim(html_escape($this->input->post('capillary_shape', true)));
            $heart_rate = trim(html_escape($this->input->post('heart_rate', true)));
            $report_date = date('Y-m-d',strtotime(trim(html_escape($this->input->post('report_date', true)))));     
            
            $customer = $this->master_db->getRecords('customers','id='.$user_id.' and status = 1','id');
            if(count($customer)){                
                $insert = array(
                    'customer_id'       =>  $user_id,
                    'height'            =>  $height,
                    'weight'            =>  $weight,
                    'bmi'               =>  $bmi,
                    'spo2'              =>  $spo2,
                    'pulse'             =>  $pulse,
                    'bp'                =>  $bp,
                    'sugar_level'       =>  $sugar_level,
                    'ecg'               =>  $ecg,
                    'hemoglobin'        =>  $hemoglobin,
                    'tds'               =>  $tds,
                    'mac'               =>  $mac,
                    'distance_test'     =>  $distance_test,
                    'near_vision_test'  =>  $near_vision_test,
                    'astigmatism'       =>  $astigmatism,
                    'cvd_test'          =>  $cvd_test,
                    'cholesterol'       =>  $cholesterol,
                    'vascular_age'      =>  $vascular_age,
                    'skin_carotenoid'   =>  $skin_carotenoid,
                    'capillary_shape'   =>  $capillary_shape,
                    'heart_rate'        =>  $heart_rate,
                    'report_date'       =>  $report_date,
                    'status'            =>  1,
                    'created_at'        =>  date("Y-m-d H:i:s")
                );
                //echo '<pre>';print_r($insert);exit;
                $vid = $this->master_db->insertRecord('cust_vitals',$insert);
                $result = array('status'=>'success','msg'=>'Vital saved successfully.');     
            }else{
                $result = array('status'=>'failure','msg'=>'Customer not found.');
            }
        }    
        echo json_encode($result);
    }

    function delete_vital_post(){
        $result = array('status'=>'failure','msg'=>'Required fields are missing.');
        if( !empty($_POST['user_id']) && isset($_POST['vid']) ){        
            $vid = trim(preg_replace('!\s+!', '',html_escape($this->input->post('vid', true))));
            $user_id = trim(preg_replace('!\s+!', '',html_escape($this->input->post('user_id', true))));
            $customer = $this->master_db->getRecords('customers','id='.$user_id.' and status = 1','id');
            if(count($customer)){
                $condition = "customer_id = $user_id and status = 1 and id = ".$vid;
                $list = $this->master_db->getRecords('cust_vitals',$condition,'id');
                if(count($list)){
                    $this->master_db->updateRecord('cust_vitals',array('status'=>-1),array('id'=>$vid));
                    $result = array('status'=>'success','msg'=>'Deleted successfully');     
                }else{
                    $result = array('status'=>'failure','msg'=>'Vital not found.');
                }                
            }else{
                $result = array('status'=>'failure','msg'=>'Customer not found.');
            }
        }        
        echo json_encode($result);
    }

    //Panic emergency function
    function publish_panic_post(){
        $result = array('status'=>'failure','msg'=>'Required fields are missing.');
        //echo '<pre>';print_r($_POST);exit;
        if( !empty($_POST['user_id']) && !empty($_POST['type'])  ){

            $user_id = trim(preg_replace('!\s+!', '',html_escape($this->input->post('user_id', true))));
            $type = trim(preg_replace('!\s+!', '',html_escape($this->input->post('type', true))));
            $customer = $this->master_db->getRecords('customers','id='.$user_id.' and status = 1','id,name,mobileno');
            //echo '<pre>';print_r($customer);exit;
            if(count($customer)){   
                $latitude = $longitude = '';
                $location = "";
                if( ( !empty($_POST['latitude']) && !empty($_POST['longitude']) ) ){
                    $latitude = trim(preg_replace('!\s+!', '',$this->input->post('latitude', true)));
                    $longitude = trim(preg_replace('!\s+!', '',$this->input->post('longitude', true)));
                    $location = "https://www.google.com/maps/dir/".$latitude.",".$longitude;
                }

                /*
                if( intval($type) == 3 && ( empty($_POST['latitude']) || empty($_POST['longitude']) ) ){
                    $result = array('status'=>'failure','msg'=>'latitude & longitude is required.');     
                    echo json_encode($result);exit;
                }

                if( intval($type) == 3 ){
                    $latitude = trim(preg_replace('!\s+!', '',$this->input->post('latitude', true)));
                    $longitude = trim(preg_replace('!\s+!', '',$this->input->post('longitude', true)));
                }

                $condition = 'customer_id='.$user_id.' and status = 1 and sms = 1 ';
                if( intval($type) == 3 ){
                    $condition .= ' and location = 1';
                }
                */
                $condition = 'customer_id='.$user_id.' and status = 1 and sms = 1 ';
                $persons = $this->master_db->getRecords('cust_emergency',$condition,'*');
                //echo '<pre>';print_r($persons);exit;

                $this->load->library('SMS');
                $stype = 0;
                if( intval($type) == 1 ){ $stype = 4; }
                else if( intval($type) == 2 ){ $stype = 5; }
                else if( intval($type) == 3 ){ $stype = 6; }
                $template = $this->master_db->getRecords('templates','type='.$stype,'id,sms_template');
                $msg = '';
                if(count($template) && !empty($template[0]->sms_template)){
                    $msg = $template[0]->sms_template;
                    $msg = str_replace('%name%',$customer[0]->name,$msg);
                    $msg = str_replace('%other%',$customer[0]->mobileno.' %url% ',$msg);
                    /*
                    if( intval($type) == 3 ){
                        $url = "https://www.google.com/maps/dir/".$latitude.",".$longitude;
                        $msg = str_replace('%other%',$url,$msg);
                    }else{
                        $msg = str_replace('%other%','',$msg);
                    }
                    */
                    $insert = array(
                        'cust_id'   =>  $user_id,
                        'type'      =>  $type,
                        //'msg'       =>  $msg,
                        'created_at'=>  date('Y-m-d H:i:s'),
                        'status'    =>  1
                    );
                    //$pid = $this->master_db->insertRecord('cust_panic',$insert);
                    
                    $pid = 1;//echo $msg;exit;
                    foreach($persons as $item){
                        $message = $msg;
                        if( intval($item->location) == 1 ){
                            $message = str_replace('%url%',$location,$message);
                        }else{
                            $message = str_replace('%url%',' ',$message);
                        }
                        //echo '<pre>';print_r($item);exit;
                        //echo $message;exit;
                        $pinsert = array(
                            'master_id' =>  $pid,
                            'person_id' =>  $item->id,
                            'status'    =>  1,
                            'msg'       =>  $message
                        );
                        $this->master_db->insertRecord('cust_panic_receipent',$pinsert);
                        $res = $this->sms->sendSmsToUser($message,$item->phone);
                    }
                }
                //echo '<pre>';print_r($insert);exit;
                $result = array('status'=>'success','msg'=>'Message sent successfully.');     
            }else{
                $result = array('status'=>'failure','msg'=>'Customer not found.');
            }
        }  
        echo json_encode($result);
    }

    //Referrals list function
    function referral_list_post(){
        //echo '<pre>';print_r($_POST);exit;
        $result = array('status'=>'failure','msg'=>'Required fields are missing.');
        if( !empty($_POST['user_id']) ){
            $user_id = trim(preg_replace('!\s+!', '',html_escape($this->input->post('user_id', true))));
            $customer = $this->master_db->getRecords('customers','id='.$user_id.' and status = 1','id,code');
            if(count($customer)){
                $today = date('Y-m-d');
                $condition = " referral_code = '".$customer[0]->code."' and status = 1 ";
                $list = $this->master_db->getRecords('customers',$condition,'id,name,mobileno');
                //echo $this->db->last_query();exit;
                $result = array('status'=>'success','data'=>$list);     
            }else{
                $result = array('status'=>'failure','msg'=>'Customer not found.');
            }
        }        
        echo json_encode($result);
    }

    //Coupons list function
    function coupons_list_post(){
        //echo '<pre>';print_r($_POST);exit;
        $result = array('status'=>'failure','msg'=>'Required fields are missing.');
        if( !empty($_POST['user_id']) ){
            $user_id = trim(preg_replace('!\s+!', '',html_escape($this->input->post('user_id', true))));
            $customer = $this->master_db->getRecords('customers','id='.$user_id.' and status = 1','id,code');
            if(count($customer)){
                $today = date('Y-m-d');
                $condition = " ('".$today."'  between from_date and to_date) and status = 1 and no_of_users > uses";
                $list = $this->master_db->getRecords('coupons',$condition,'id,coupon_code,coupon_title,discount_type,amount');
                //echo $this->db->last_query();exit;
                $result = array('status'=>'success','data'=>$list);     
            }else{
                $result = array('status'=>'failure','msg'=>'Customer not found.');
            }
        }        
        echo json_encode($result);
    }

    //Modules list function
    function modules_list_post(){
        //echo '<pre>';print_r($_POST);exit;
        $result = array('status'=>'failure','msg'=>'Required fields are missing.');
        if( !empty($_POST['user_id']) ){
            $user_id = trim(preg_replace('!\s+!', '',html_escape($this->input->post('user_id', true))));
            $customer = $this->master_db->getRecords('customers','id='.$user_id.' and status = 1','id,code');
            if(count($customer)){
                $condition = "customer_id = ".$user_id." and pstatus = 1 ";
                $cpackage = $this->master_db->getRecords('customer_package',$condition,'id,package_id');
                //echo '<pre>';print_r($cpackage);exit;
                $condition = "m.status = 1 and pm.package_id = ".$cpackage[0]->package_id;
                $list = $this->app_db->getpackagemodules($condition);
                $data = array();
                foreach($list as $item){
                    $mdata = array(
                        'id'    =>  $item->id,
                        'name'  =>  $item->name,
                        'status'=>  $item->status
                    );
                    $mdata['submodule'] = array();
                    if( intval($item->health_tip) == 1 || intval($item->flashnews) == 1 ){
                        $condition = "sm.status = 1 and ps.package_id = ".$cpackage[0]->package_id." and ps.module_id = ".$item->id;
                        $mdata['submodule'] = $this->app_db->getpackagesubmodules($condition);
                    }
                    $data[] = $mdata;
                }
                $result = array('status'=>'success','data'=>$data);     
            }else{
                $result = array('status'=>'failure','msg'=>'Customer not found.');
            }
        }        
        echo json_encode($result);
    }

    //Points detail function
    function points_detail_post(){
        //echo '<pre>';print_r($_POST);exit;
        $result = array('status'=>'failure','msg'=>'Required fields are missing.');
        if( !empty($_POST['user_id']) ){
            $user_id = trim(preg_replace('!\s+!', '',html_escape($this->input->post('user_id', true))));
            $customer = $this->master_db->getRecords('customers','id='.$user_id.' and status = 1','id,code');
            if(count($customer)){
                $today = date('Y-m-d');
                $list = $this->master_db->getRecords('points_setting',"id=1",'signup,referral');
                $result = array('status'=>'success','data'=>$list[0]);     
            }else{
                $result = array('status'=>'failure','msg'=>'Customer not found.');
            }
        }        
        echo json_encode($result);
    }

    //Notification Settings list function
    function settings_post(){
        //echo '<pre>';print_r($_POST);exit;
        $result = array('status'=>'failure','msg'=>'Required fields are missing.');
        if( !empty($_POST['user_id']) && !empty($_POST['notify']) && !empty($_POST['health']) && !empty($_POST['flashnews']) ){
            $user_id = trim(preg_replace('!\s+!', '',html_escape($this->input->post('user_id', true))));            
            $notify = strtoupper(trim(preg_replace('!\s+!', '',html_escape($this->input->post('notify', true)))));            
            $health = strtoupper(trim(preg_replace('!\s+!', '',html_escape($this->input->post('health', true)))));            
            $flashnews = strtoupper(trim(preg_replace('!\s+!', '',html_escape($this->input->post('flashnews', true)))));            
            
            if( $notify == 'YES' ){$notify = 1;}
            else{ $notify = 0; }

            if( $health == 'YES' ){$health = 1;}
            else{ $health = 0; }

            if( $flashnews == 'YES' ){$flashnews = 1;}
            else{ $flashnews = 0; }

            $customer = $this->master_db->getRecords('customers','id='.$user_id.' and status = 1','id,code');
            if(count($customer)){
                $select = "id,if(notification=1,'yes','no') as notification,if(health=1,'yes','no') as health,if(flash=1,'yes','no') as flash";
                $setting = $this->master_db->getRecords('cust_notify_setting','customer_id='.$user_id,$select);
                if(count($setting) == 0){
                    $insert_setting = array(
                        'customer_id'   =>  $user_id,
                        'notification'  =>  $notify,
                        'health'        =>  $health,
                        'flash'         =>  $flashnews,
                        'updated_at'    =>  date('Y-m-d H:i:s')
                    );
                    $this->master_db->insertRecord('cust_notify_setting',$insert_setting);
                }else{
                    $update = array(
                        'notification'  =>  $notify,
                        'health'        =>  $health,
                        'flash'         =>  $flashnews,
                        'updated_at'    =>  date('Y-m-d H:i:s')
                    );
                    $this->master_db->updateRecord('cust_notify_setting',$update,array('customer_id'=>$user_id));
                }    
                $result = array('status'=>'success','msg'=>'Saved successfully');
            }else{
                $result = array('status'=>'failure','msg'=>'Customer not found.');
            }
        }else if( !empty($_POST['user_id']) ){
            $user_id = trim(preg_replace('!\s+!', '',html_escape($this->input->post('user_id', true))));            
            $customer = $this->master_db->getRecords('customers','id='.$user_id.' and status = 1','id,code');
            if(count($customer)){
                $select = "id,if(notification=1,'yes','no') as notification,if(health=1,'yes','no') as health,if(flash=1,'yes','no') as flash";
                $setting = $this->master_db->getRecords('cust_notify_setting','customer_id='.$user_id,$select);
                if(count($setting) == 0){
                    $insert_setting = array(
                        'customer_id'   =>  $user_id,
                        'notification'  =>  1,
                        'health'        =>  1,
                        'flash'         =>  1,
                        'updated_at'    =>  date('Y-m-d H:i:s')
                    );
                    $this->master_db->insertRecord('cust_notify_setting',$insert_setting);
                    $setting = $this->master_db->getRecords('cust_notify_setting','customer_id='.$user_id,$select);
                }    
                $result = array('status'=>'success','data'=>$setting[0]);
            }else{
                $result = array('status'=>'failure','msg'=>'Customer not found.');
            }
        }        
        echo json_encode($result);
    }

    //Package Highlights list function
    function package_highlight_post(){
        //echo '<pre>';print_r($_POST);exit;
        $result = array('status'=>'failure','msg'=>'Required fields are missing.');
        if( !empty($_POST['user_id']) && !empty($_POST['package_id']) ){
            $user_id = trim(preg_replace('!\s+!', '',html_escape($this->input->post('user_id', true))));
            $package_id = trim(preg_replace('!\s+!', '',html_escape($this->input->post('package_id', true))));
            $customer = $this->master_db->getRecords('customers','id='.$user_id.' and status = 1','id,code');
            if(count($customer)){
                $today = date('Y-m-d');
                $condition = " package_id = $package_id and status = 1";
                $list = $this->master_db->getRecords('package_highlights',$condition,'label');
                //echo $this->db->last_query();exit;
                $result = array('status'=>'success','data'=>$list);     
            }else{
                $result = array('status'=>'failure','msg'=>'Customer not found.');
            }
        }        
        echo json_encode($result);
    }

    function graph_get(){
        require_once (APPPATH.'third_party/jpgraph/src/jpgraph.php');
        require_once (APPPATH.'third_party/jpgraph/src/jpgraph_line.php');
        $result = array('status'=>'failure','msg'=>'Required fields are missing.');
        if( !empty($_GET['user_id']) && !empty($_GET['type']) ){
            $user_id = trim(preg_replace('!\s+!', '',html_escape($this->input->get('user_id', true))));
            $type = trim(preg_replace('!\s+!', '',html_escape($this->input->get('type', true))));            
            $customer = $this->master_db->getRecords('customers','id='.$user_id.' and status = 1','id,code');
            if(count($customer)){
                if( intval($type) == 1 ){
                    //$condition = " customer_id = ".$user_id." and status = 1 and spo2 != '' ";
                    //$this->data['spo2_report'] = $this->master_db->getRecords('cust_vitals',$condition,'spo2,report_date','report_date asc','',0,10);

                    $condition = "cs.customer_id = $user_id and cs.service_id = 8 and sf.type = 3 and csf.data != '' and cs.status = 1 ";
                    $this->data['spo2_report'] = $this->app_db->getservicedata($condition);

                    //echo '<pre>';print_r($this->data['spo2_report']);exit;
                    if(count($this->data['spo2_report']) > 1){
                        $data = json_decode(json_encode($this->data['spo2_report']), true);
                        $dates = array_column($data,'date');
                        $datay1 = array_column($data,'data');

                        // Setup the graph
                        $graph = new Graph(1000,500);
                        $graph->SetScale("textlin");

                        $theme_class=new UniversalTheme;

                        $graph->SetTheme($theme_class);
                        $graph->img->SetAntiAliasing(false);
                        //$graph->title->Set('PSO2');
                        $graph->SetBox(false);

                        $graph->SetMargin(40,40,60,80,100);

                        //$graph->img->SetAntiAliasing();

                        $graph->yaxis->HideZeroLabel();
                        $graph->yaxis->HideLine(false);
                        $graph->yaxis->HideTicks(false,false);

                        $graph->xgrid->Show();
                        $graph->xgrid->SetLineStyle("solid");
                        $graph->xaxis->SetTickLabels($dates);
                        $graph->xgrid->SetColor('#E3E3E3');

                        // Create the first line
                        $p1 = new LinePlot($datay1);
                        $graph->Add($p1);
                        $p1->SetColor("#6495ED");
                        //$p1->SetLegend('Line 1');

                        $graph->legend->SetFrameWeight(1);

                        // Output line
                        $graph->Stroke();
                        //echo '<pre>';print_r($datay1);exit;
                    }else{
                        echo "No records found.";
                    }
                }else if(intval($type) == 2){
                    //$condition = " customer_id = ".$user_id." and status = 1 and heart_rate != '' ";
                    //$this->data['hr_report'] = $this->master_db->getRecords('cust_vitals',$condition,'heart_rate,report_date','report_date asc','',0,10);

                    $condition = "cs.customer_id = $user_id and cs.service_id = 7 and sf.type = 3 and csf.data != '' and cs.status = 1 ";
                    $this->data['hr_report'] = $this->app_db->getservicedata($condition);
                    if(count($this->data['hr_report']) > 1){
                        $data = json_decode(json_encode($this->data['hr_report']), true);
                        $dates = array_column($data,'date');
                        $datay1 = array_column($data,'data');

                        // Setup the graph
                        $graph = new Graph(1000,500);
                        $graph->SetScale("textlin");

                        $theme_class=new UniversalTheme;

                        $graph->SetTheme($theme_class);
                        $graph->img->SetAntiAliasing(false);
                        //$graph->title->Set('Pulse');
                        $graph->SetBox(false);

                        $graph->SetMargin(40,40,60,80,100);

                        //$graph->img->SetAntiAliasing();

                        $graph->yaxis->HideZeroLabel();
                        $graph->yaxis->HideLine(false);
                        $graph->yaxis->HideTicks(false,false);

                        $graph->xgrid->Show();
                        $graph->xgrid->SetLineStyle("solid");
                        $graph->xaxis->SetTickLabels($dates);
                        $graph->xgrid->SetColor('#E3E3E3');

                        // Create the first line
                        $p1 = new LinePlot($datay1);
                        $graph->Add($p1);
                        $p1->SetColor("#6495ED");
                        //$p1->SetLegend('Line 1');

                        $graph->legend->SetFrameWeight(1);

                        // Output line
                        $graph->Stroke();
                        //echo '<pre>';print_r($datay1);exit;
                    }else{
                        echo "No records found.";
                    }
                }                    
            }
        }
    }

    //Emergency report
    function ereportpdf_get(){
        $result = array('status'=>'failure','msg'=>'Required fields are missing.');
        if( !empty($_GET['user_id']) ){
            $user_id = trim(preg_replace('!\s+!', '',html_escape($this->input->get('user_id', true))));
            $this->data['customer'] = $customer = $this->master_db->getRecords('customers','id='.$user_id.' and status = 1','id,code');
            //echo '<pre>';print_r($customer);exit;
            if(count($customer)){
                $condition = " c.id = ".$user_id." and c.status = 1 and cp.pstatus = 1 ";
                $this->data['cdata'] = $this->app_db->getCustomerDetail($condition);

                $condition = " customer_id = ".$user_id." and status = 1 ";
                $this->data['elist'] = $this->master_db->getRecords('cust_emergency',$condition,'name,phone,relation','id asc','',0,3);
                //echo '<pre>';print_r($this->data['elist']);exit;

                $condition = " customer_id = ".$user_id." and status = 1 ";
                $this->data['hospital'] = $this->master_db->getRecords('cust_hospitals',$condition,'hospital,medical_note,admit_date','id desc');

                $condition = " customer_id = ".$user_id." and status = 1 ";
                $this->data['vital'] = $this->master_db->getRecords('cust_vitals',$condition,'*','id desc','',0,1);

                /*
                $condition = " customer_id = ".$user_id." and status = 1 and spo2 != '' ";
                $this->data['spo2_report'] = $this->master_db->getRecords('cust_vitals',$condition,'*','report_date asc','',0,10);

                $condition = " customer_id = ".$user_id." and status = 1 and heart_rate != '' ";
                $this->data['hr_report'] = $this->master_db->getRecords('cust_vitals',$condition,'*','report_date asc','',0,10);
                //echo '<pre>';print_r($this->data['hr_report']);exit;
                */

                $condition = "cs.customer_id = $user_id and cs.service_id = 8 and sf.type = 3 and csf.data != '' and cs.status = 1 ";
                $this->data['spo2_report'] = $this->app_db->getservicedata($condition);

                $condition = "cs.customer_id = $user_id and cs.service_id = 7 and sf.type = 3 and csf.data != '' and cs.status = 1 ";
                $this->data['hr_report'] = $this->app_db->getservicedata($condition);

                $condition = " customer_id = ".$user_id." and status = 1 ";
                $this->data['vaccine'] = $this->master_db->getRecords('cust_vaccines',$condition,'vaccine_name,dose,date,note','id desc','',0,3);

                $condition = " customer_id = ".$user_id." and status = 1 ";
                $this->data['allergy'] = $this->master_db->getRecords('cust_allergy',$condition,'allergy_name,date,note','id desc','',0,3);

                $condition = " customer_id = ".$user_id." and status = 1 ";
                $select = 'medical_diagnosis,special_diagnosis,special_note,conducted_on,note';
                $this->data['diagnosis'] = $this->master_db->getRecords('cust_diagnosis',$condition,$select,'id desc','',0,1);

                $condition = " customer_id = ".$user_id." and status = 1 ";
                $select = "medicine_name,medicine_strength,how_often,pdate,reason";
                $this->data['medicine'] = $this->master_db->getRecords('cust_medicine',$condition,$select,'id desc','',0,3);
                //echo $this->db->last_query();echo '<pre>';print_r($this->data['medicine']);exit;

                $condition = " customer_id = ".$user_id." and status = 1 ";
                $select = "procedure_name,procedure_comment,special_procedure,special_comment,conducted_on";
                $this->data['surgery'] = $this->master_db->getRecords('cust_surgery',$condition,$select,'id desc','',0,1);
                //echo '<pre>';print_r($this->data['cdata']);exit;

                $condition = " customer_id = ".$user_id." and status = 1 ";
                $select = "DATE_FORMAT(visit_date,'%d-%m-%Y') as visit_date,if(type=1,'New','Follow Up') as type,consulted_doctor as doctor,reason";
                $this->data['visit'] = $this->master_db->getRecords('cust_medical_visits',$condition,$select,'id desc','',0,3);

                $condition = " customer_id = ".$user_id." and status = 1 ";
                $select = "insurance_name,policy_number,DATE_FORMAT(plan_date,'%d-%m-%Y') as plan_date,DATE_FORMAT(expiry_date,'%d-%m-%Y') as expiry_date,amount";
                $this->data['insurance'] = $this->master_db->getRecords('cust_insurance',$condition,$select,'id desc','',0,3);

                $html = $this->load->view('emergency_report',$this->data,true);
                //echo $html;exit;

                $this->load->library('m_pdf');
                $pdf_name = time().".pdf";
                $filepath = app_url()."app_assets/ereport/".$pdf_name;
                $filename = "../app_assets/ereport/".time().".pdf";
                $mpdf = new mPDF();
                $mpdf->AddPage('P');
                $mpdf->WriteHTML($html);
                $mpdf->Output($filename, "F");
                $result = array('status'=>'success','file'=>$filepath);
            }else{
                $result = array('status'=>'failure','msg'=>'Customer not found.');
            }
        }        
        echo json_encode($result);
    }

    function ereport_post(){
        $result = array('status'=>'failure','msg'=>'Required fields are missing.');
        if( !empty($_POST['user_id']) ){
            $data = array();
            $user_id = trim(preg_replace('!\s+!', '',html_escape($this->input->post('user_id', true))));
            $this->data['customer'] = $customer = $this->master_db->getRecords('customers','id='.$user_id.' and status = 1','id,code');
            //echo '<pre>';print_r($customer);exit;
            if(count($customer)){
                $condition = " c.id = ".$user_id." and c.status = 1 and cp.pstatus = 1 ";
                $data['user_detail'] = $this->app_db->getCustomerDetail($condition)[0];

                if( !empty($data['user_detail']->photo) ){
                    $data['user_detail']->photo = app_asset_url().$data['user_detail']->photo;
                }

                if( !empty($data['user_detail']->card_img) ){
                    $data['user_detail']->card_img = app_asset_url().$data['user_detail']->card_img;
                }

                if( !empty($data['user_detail']->qrcode) ){
                    $data['user_detail']->qrcode = app_asset_url().$data['user_detail']->qrcode;
                }
                //echo '<pre>';print_r($data['user_detail']);exit;

                $condition = " customer_id = ".$user_id." and status = 1 ";
                $data['cust_emergency'] = $this->master_db->getRecords('cust_emergency',$condition,'name,phone,relation','id asc','',0,3);
                //echo '<pre>';print_r($this->data['elist']);exit;

                $condition = " customer_id = ".$user_id." and status = 1 ";
                $data['hospital'] = $this->master_db->getRecords('cust_hospitals',$condition,'hospital,medical_note,admit_date','id desc');

                $condition = " customer_id = ".$user_id." and status = 1 ";
                $data['vital'] = $this->master_db->getRecords('cust_vitals',$condition,'*','id desc','',0,1);

                $condition = "cs.customer_id = $user_id and cs.service_id = 8 and sf.type = 3 and csf.data != '' and cs.status = 1 ";
                $data['spo2_report'] = $this->app_db->getservicedata($condition);

                $condition = "cs.customer_id = $user_id and cs.service_id = 7 and sf.type = 3 and csf.data != '' and cs.status = 1 ";
                $data['hr_report'] = $this->app_db->getservicedata($condition);

                /*
                $condition = " customer_id = ".$user_id." and status = 1 and spo2 != '' ";
                $data['spo2_report'] = $this->master_db->getRecords('cust_vitals',$condition,'*','report_date asc','',0,10);
                //echo $this->db->last_query();echo '<pre>';print_r($data['spo2_report']);exit;
                $condition = " customer_id = ".$user_id." and status = 1 and heart_rate != '' ";
                $data['hr_report'] = $this->master_db->getRecords('cust_vitals',$condition,'*','report_date asc','',0,10);
                //echo '<pre>';print_r($this->data['hr_report']);exit;
                */

                $condition = " customer_id = ".$user_id." and status = 1 ";
                $data['vaccine'] = $this->master_db->getRecords('cust_vaccines',$condition,'vaccine_name,dose,date,note','id desc','',0,3);

                $condition = " customer_id = ".$user_id." and status = 1 ";
                $data['allergy'] = $this->master_db->getRecords('cust_allergy',$condition,'allergy_name,date,note','id desc','',0,3);

                $condition = " customer_id = ".$user_id." and status = 1 ";
                $select = 'medical_diagnosis,special_diagnosis,special_note,conducted_on,note';
                $data['diagnosis'] = $this->master_db->getRecords('cust_diagnosis',$condition,$select,'id desc','',0,1);

                $condition = " customer_id = ".$user_id." and status = 1 ";
                $select = "medicine_name,medicine_strength,how_often,pdate,reason";
                $data['medicine'] = $this->master_db->getRecords('cust_medicine',$condition,$select,'id desc','',0,3);
                //echo $this->db->last_query();echo '<pre>';print_r($this->data['medicine']);exit;

                $condition = " customer_id = ".$user_id." and status = 1 ";
                $select = "procedure_name,procedure_comment,special_procedure,special_comment,conducted_on";
                $data['surgery'] = $this->master_db->getRecords('cust_surgery',$condition,$select,'id desc','',0,1);


                $condition = " customer_id = ".$user_id." and status = 1 ";
                $select = "DATE_FORMAT(visit_date,'%d-%m-%Y') as visit_date,if(type=1,'New','Follow Up') as type,consulted_doctor as doctor,reason";
                $data['visit'] = $this->master_db->getRecords('cust_medical_visits',$condition,$select,'id desc','',0,3);

                $condition = " customer_id = ".$user_id." and status = 1 ";
                $select = "insurance_name,policy_number,DATE_FORMAT(plan_date,'%d-%m-%Y') as plan_date,DATE_FORMAT(expiry_date,'%d-%m-%Y') as expiry_date,amount";
                $data['insurance'] = $this->master_db->getRecords('cust_insurance',$condition,$select,'id desc','',0,3);
                //echo '<pre>';print_r($data);exit;
                $result = array('status'=>'success','data'=>$data);
            }else{
                $result = array('status'=>'failure','msg'=>'Customer not found.');
            }
        }        
        echo json_encode($result);
    }

    //Upgrade & renew API
    function package_upgrade_post(){
        $result = array('status'=>'failure','msg'=>'Required fields are missing.');
        if( !empty($_POST['user_id']) && !empty($_POST['package_id']) && !empty($_POST['package_amont'])
            && !empty($_POST['total_amount']) && isset($_POST['coupon_amount']) && isset($_POST['razor_pay_amount'])
            && !empty($_POST['expiry_date']) && !empty($_POST['type']) && isset($_POST['coupon_id']) ){

            //echo '<pre>';print_r($_POST);exit;
            $user_id = trim(preg_replace('!\s+!', '',html_escape($this->input->post('user_id', true))));
            $package_id = trim(preg_replace('!\s+!', '',html_escape($this->input->post('package_id', true))));
            $package_amount = trim(preg_replace('!\s+!', '',html_escape($this->input->post('package_amont', true))));
            $total_amount = trim(preg_replace('!\s+!', '',html_escape($this->input->post('total_amount', true))));
            $coupon_amount = trim(preg_replace('!\s+!', '',html_escape($this->input->post('coupon_amount', true))));
            $razor_pay_amount = trim(preg_replace('!\s+!', '',html_escape($this->input->post('razor_pay_amount', true))));
            $expiry_date = trim(preg_replace('!\s+!', '',html_escape($this->input->post('expiry_date', true))));
            $type = trim(preg_replace('!\s+!', '',html_escape($this->input->post('type', true))));
            $coupon_id = trim(preg_replace('!\s+!', '',html_escape($this->input->post('coupon_id', true))));

            $customer = $this->master_db->getRecords('customers','id='.$user_id.' and status = 1','id,code');
            if(count($customer)){
                $checkcoupon = array();
                if( !empty($coupon_id) ){
                    $condition = 'id='.$coupon_id.' and status = 1 and no_of_users > uses ';
                    $checkcoupon = $this->master_db->getRecords('coupons',$condition,'id,uses');
                    if( count($checkcoupon) == 0 ){
                        $result = array('status'=>'failure','msg'=>'Coupon not found.');
                        echo json_encode($result);exit;
                    }
                    //echo '<pre>';print_r($checkcoupon);exit;
                }

                $condition = 'id='.$package_id.' and status = 1 and publish = 1 ';
                $checkpackage = $this->master_db->getRecords('packages',$condition,'id,price');
                //echo $this->db->last_query();echo '<pre>';print_r($checkpackage);exit;
                if( count($checkpackage) == 0 ){
                    $result = array('status'=>'failure','msg'=>'Package not found.');
                    echo json_encode($result);exit;
                }

                if( floatval($checkpackage[0]->price) != floatval($package_amount) ){
                    $result = array('status'=>'failure','msg'=>'Package amount not matching.');
                    echo json_encode($result);exit;
                }
                //echo $checkpackage[0]->price.' - '.$package_amount;exit;
                $checkcp = $this->master_db->getRecords('customer_package','customer_id='.$user_id.' and pstatus = 1','id');
                //echo $this->db->last_query();echo '<pre>';print_r($checkcp);exit;
                if(count($checkcp)){
                    if( $type == 'upgrade' ){
                        $this->master_db->updateRecord('customer_package',array('pstatus'=>2),array('id'=>$checkcp[0]->id));
                        $code = $this->master_db->getRecords('system_codes','id=1','id,prefix,cust_prefix,cust_no,card_prefix');
                        $card_no = $this->home_db->getCardno($code[0]->card_prefix);
                        $insert = array(
                            'customer_id'   =>  $user_id,
                            'package_id'    =>  $package_id,
                            'card_no'       =>  $card_no,
                            'valid_from'    =>  date('Y-m-d'),
                            'valid_to'      =>  date('Y-m-d',strtotime($expiry_date)),
                            'pstatus'       =>  1,
                            'created_at'    =>  date('Y-m-d H:i:s')
                        );
                        $this->master_db->insertRecord('customer_package',$insert);

                        $insert = array(
                            'customer_id'   =>  $user_id,
                            'package_id'    =>  $package_id,
                            'type'          =>  1,
                            'package_amount'=>  $package_amount,
                            'total_amount'  =>  $total_amount,
                            'coupon_amount' =>  $coupon_amount,
                            'razor_amount'  =>  $razor_pay_amount,
                            'expiry_date'   =>  date('Y-m-d',strtotime($expiry_date)),
                            'coupon_id'     =>  $coupon_id,
                            'status'        =>  1,
                            'created_at'    =>  date('Y-m-d H:i:s')
                        );
                        $this->master_db->insertRecord('cust_payments',$insert);

                        if( count($checkcoupon) ){
                            $uses = $checkcoupon[0]->uses + 1;
                            $this->master_db->updateRecord('coupons',array('uses'=>$uses),array('id'=>$checkcoupon[0]->id));
                            $insert = array(
                                'coupon_id'     =>  $checkcoupon[0]->id,
                                'customer_id'   =>  $user_id,
                                'used_at'       =>  date('Y-m-d H:i:s')
                            );
                            $this->master_db->insertRecord('coupon_history',$insert);
                        }
                        $result = array('status'=>'success','msg'=>'Package upgraded successfully');     
                    }else if( $type == 'renew' ){

                        $condition = "customer_id = $user_id and package_id = $package_id and pstatus = 1 ";
                        $cp = $this->master_db->getRecords('customer_package',$condition,'*');

                        $this->master_db->updateRecord('customer_package',array('pstatus'=>2),array('id'=>$checkcp[0]->id));
                        
                        $insert = array(
                            'customer_id'   =>  $user_id,
                            'package_id'    =>  $package_id,
                            'card_no'       =>  $cp[0]->card_no,
                            'card_img'      =>  $cp[0]->card_img,
                            'qrcode'        =>  $cp[0]->qrcode,
                            'valid_from'    =>  date('Y-m-d'),
                            'valid_to'      =>  date('Y-m-d',strtotime($expiry_date)),
                            'pstatus'       =>  1,
                            'created_at'    =>  date('Y-m-d H:i:s')
                        );
                        $this->master_db->insertRecord('customer_package',$insert);

                        $insert = array(
                            'customer_id'   =>  $user_id,
                            'package_id'    =>  $package_id,
                            'type'          =>  2,
                            'package_amount'=>  $package_amount,
                            'total_amount'  =>  $total_amount,
                            'coupon_amount' =>  $coupon_amount,
                            'razor_amount'  =>  $razor_pay_amount,
                            'expiry_date'   =>  date('Y-m-d',strtotime($expiry_date)),
                            'coupon_id'     =>  $coupon_id,
                            'status'        =>  1,
                            'created_at'    =>  date('Y-m-d H:i:s')
                        );
                        $this->master_db->insertRecord('cust_payments',$insert);

                        if( count($checkcoupon) ){
                            $uses = $checkcoupon[0]->uses + 1;
                            $this->master_db->updateRecord('coupons',array('uses'=>$uses),array('id'=>$checkcoupon[0]->id));
                            $insert = array(
                                'coupon_id'     =>  $checkcoupon[0]->id,
                                'customer_id'   =>  $user_id,
                                'used_at'       =>  date('Y-m-d H:i:s')
                            );
                            $this->master_db->insertRecord('coupon_history',$insert);
                        }
                        $result = array('status'=>'success','msg'=>'Package renewed successfully');     
                    }
                }else{
                    $result = array('status'=>'failure','msg'=>'No package is found.');
                }
            }else{
                $result = array('status'=>'failure','msg'=>'Customer not found.');
            }
        }        
        echo json_encode($result);
    }

    //update 02-09-2021
    function carddisplay_get(){
        //echo '<pre>';print_r($_GET);exit;
        $this->data = array();
        $result = array('status'=>'failure','msg'=>'Required fields are missing.');
        if( !empty($_GET['user_id']) ){   
            $user_id = trim(preg_replace('!\s+!', '',html_escape($this->input->get('user_id', true))));
            //echo $user_id;exit;
            $condition = " c.id = ".$user_id." and c.status = 1 and cp.pstatus = 1 ";
            $checkCustomer = $this->app_db->getCustomerDetail($condition);
            //echo '<pre>';print_r($checkCustomer);exit;
            if(count($checkCustomer)){
                if( $checkCustomer[0]->blood_group == '' ){
                    $result = array('status'=>'failure','msg'=>'Profile not updated.');    
                }else{
                    //echo '<pre>';print_r($checkCustomer);exit;
                    $condition = " c.id = ".$user_id." and c.status = 1 and cp.pstatus = 1 ";
                    $checkCustomer = $this->app_db->getCustomerDetail($condition);
                    $checkCustomer[0]->photo = app_asset_url().$checkCustomer[0]->photo;
                    $checkCustomer[0]->qrcode = app_asset_url().$checkCustomer[0]->qrcode;
                    //echo '<pre>';print_r($checkCustomer);exit;
                    $this->data['customer'] = $checkCustomer[0];
                    $html = $this->load->view('card_view',$this->data,true);
                    //echo $html;exit;
                    
                    require_once(APPPATH.'/third_party/html2_pdf_lib/html2pdf.class.php');
                    //$content = ob_get_clean();
                    //ob_clean ();
                    $html2pdf = new HTML2PDF('P', 'A4', 'en');
                    $html2pdf->pdf->SetDisplayMode('fullpage');
                    //$html2pdf->setModeDebug();
                    $html2pdf->setDefaultFont('courier');
                    $html2pdf->setTestTdInOnePage(false);
                    $html2pdf->writeHTML($html);
                    $pdf_name = $checkCustomer[0]->user_id.'_'.time().'.pdf';
                    $file_name = '../app_assets/card_image/'.$pdf_name;
                    $file = $html2pdf->Output($file_name,'F');
                    //$file = $html2pdf->Output($file_name,'D');exit;
                    
                    //exit;
                    //pdf creation
                    
                    //now magic starts
                    $image_name = '../app_assets/card_image/'.$checkCustomer[0]->user_id.'source.png';
                    $im = new imagick($file_name);
                    $im->setResolution(500, 500);
                    $im->setImageFormat( "png" );
                    $img_name = $image_name;
                    $im->setSize(100,100);
                    $im->writeImage($img_name);
                    header('Content-Type: image/png');
                    echo $im;exit;
                    $im->clear();
                    $im->destroy();

                    $config['image_library'] = 'imagemagick';
                    $config['library_path'] = '/usr/bin';
                    $config['source_image'] = $img_name;
                    //$config['create_thumb'] = TRUE;
                    $config['maintain_ratio'] = FALSE;
                    //$config['x_axis'] = 100;
                    //$config['y_axis'] = 100;
                    $config['width'] = 650;
                    $config['height'] = 385;   
                    $img_name = $checkCustomer[0]->user_id.'_'.time().'.png';
                    $new_name = '../app_assets/card_image/'.$img_name;
                    $config['new_image'] = $new_name;
                    $this->load->library('image_lib', $config);
                    //$this->image_lib->crop();
                    
                    $this->image_lib->initialize($config); 
                    if (!$this->image_lib->crop()){
                        //echo $this->image_lib->display_errors();
                    }
                    echo $new_name;exit;
                    unlink($image_name);
                    unlink($file_name);
                    /*
                    $new_name = str_replace('../','',$new_name);
                    $update = array('card_img'=>$new_name,'updated_at'=>date('Y-m-d H:i:s'));
                    $where = array('customer_id'=>$checkCustomer[0]->user_id,'pstatus'=>1);
                    $this->master_db->updateRecord('customer_package',$update,$where);
                    $result = array('status'=>'success','msg'=>'Card generated successfully.');
                    */
                }                
            }else{
                $result = array('status'=>'failure','msg'=>'Customer not found.');
            }
        }
        echo json_encode($result);
    }
}   
?>