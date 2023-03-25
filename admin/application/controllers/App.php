<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require APPPATH . 'libraries/REST_Controller.php';
class App extends REST_Controller {

	public function __construct() {
		parent::__construct();		
		$this->load->helper('utility_helper');
        $this->load->helper('cookie');
        no_cache();
        $this->load->model('master_db');
        $this->load->model('app_db');
        $this->load->library('Mail');
        $this->load->library('SMS');
        //$this->data['session'] = ADMIN_SESSION;
    }

    function index_post(){}

    function index_get(){}

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
        if( !empty($_POST['type']) && !empty($_POST['company_name']) && !empty($_POST['company_type']) 
            && !empty($_POST['doc_type']) && !empty($_POST['name']) 
            && !empty($_POST['phone']) && !empty($_POST['email']) && !empty($_POST['dob']) && !empty($_POST['bloodgroup'])
            && !empty($_POST['address']) && !empty($_POST['country']) /*&& !empty($_POST['state']) && !empty($_POST['district']) && !empty($_POST['taluk'])*/
            && !empty($_POST['pincode']) && !empty($_POST['kyc_type']) && !empty($_POST['payment_mode']) && !empty($_POST['agree'])
            && !empty($_FILES['document']['name']) && !empty($_FILES['photo']['name']) && !empty($_POST['pcountry']) && !empty($_POST['pstate'])
            && !empty($_FILES['kyc_doc']['name'])
            ){
            $subjects = "Channel Partner";
              $phones = trim(preg_replace('!\s+!', '',$this->input->post('phone', true)));
            $mob = $this->master_db->getRecords("partner_personal",['contactno'=>$phones],'*');


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
            $catypes = "";
            if($type ==1) {
                $catypes .="COUNTRY PARTNER";
            }else if($type ==3) {
                $catypes .="STATE C&F";
            }
            else if($type ==4) {
                $catypes .="DISTRIBUTOR";
            }
            else if($type ==5) {
                $catypes .="DEALER";
            }
            else if($type ==6) {
                $catypes .="RETAILER";
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

            if( count($mob) ){ 
                $result = array('status'=>'failure','msg'=>'Mobile number already exists choose another');
                echo json_encode($result);exit;
            }


            // $message= "Welcome to Paxykop Technologies, Thanks for choosing ".$catypes." for LIFEON+ products. Your Channel Partner ".$_POST['name'].". Any query please contact us on info@lifeonplus.com. Regards, Team LIFEON+";
            $message= "Dear channel partner, your request for the ".$_POST['name']." is being processed, we will get back to you at the earliest after the verification. If any query please write us info@lifeonplus.com";
            $this->sms->sendSmsToUser($message,$_POST['phone']);

            $this->data['types'] = $catypes;
            $body = $this->load->view('admin_channel_mail',$this->data,true);
            $this->mail->send_sparkpost_attach($body,array($_POST['email']),$subjects);
            
            $company_name = trim($this->input->post('company_name'));
            $company_type = trim(preg_replace('!\s+!', '',$this->input->post('company_type', true)));
            $gst_no = trim(preg_replace('!\s+!', '',$this->input->post('gst_no', true)));
            $doc_type = trim(preg_replace('!\s+!', '',$this->input->post('doc_type', true)));
            $name = trim($this->input->post('name'));
            $phone = trim(preg_replace('!\s+!', '',$this->input->post('phone', true)));
            $email = trim(preg_replace('!\s+!', '',$this->input->post('email', true)));
            $dob = trim(preg_replace('!\s+!', '',$this->input->post('dob', true)));
            $bloodgroup = trim(preg_replace('!\s+!', '',$this->input->post('bloodgroup', true)));
            $address = trim($this->input->post('address'));
            
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

            $track['name'] = $name;
            $track['email'] = $email;
            $track['phone'] = $phone;
            $track['tfrom'] = "website";
            $track['added_on'] = date('Y-m-d H:i:s');
            $this->master_db->insertRecord('tracking',$track);

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
                    'emailid'       =>  $email,
                    'dob'           =>  date('Y-m-d',strtotime($dob)),
                    'bloodgroup'    =>  $bloodgroup,
                    'address'       =>  $address,
                    'city_id'       =>  $district,
                    'pincode'       =>  $pincode,
                    'state_id'      =>  $state,
                    'district_id'   =>  $district,
                    'taluk_id'      =>  $taluk,
                    'country_id'    =>  $country,
                    'kyc_type'      =>  $kyc_type,
                );

                if(!empty($mob[0]->contactno)) {

                }else {
                     $partner_personal['contactno'] = $phone;
                }

               

                if( !empty($_FILES['photo']['name']) ){
                    $config2 = array();
                    $config2['upload_path'] = '../app_assets/channel_partner/photo/';  
                    $config2['allowed_types'] = 'jpeg|jpg|png';
                    $config2['max_size'] = 0;    
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
                $this->master_db->insertRecord('partner_personal',$partner_personal);

                $partner_payment = array(
                    'partner_id'    =>  $partner_id,
                    'payment_id'    =>  $payment_mode,
                    'cheque_no'     =>  $cheque_no,
                    'cheque_date'   =>  date('Y-m-d',strtotime($cheque_date)),
                    'bank_name'     =>  $bank_name,
                    'branch_name'   =>  $branch_name,
                    'utr_no'        =>  $utr_no,
                    'status'        =>'Pending',
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
            echo filter_var($email_id, FILTER_SANITIZE_EMAIL);exit;
            echo $name;exit;
            /*
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
            $address = trim($this->input->post('address'));
            
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
                'status'        =>  1,
                'created_at'    =>  date('Y-m-d H:i:s')
            );
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
                    'city_id'       =>  $district,
                    'pincode'       =>  $pincode,
                    'state_id'      =>  $state,
                    'district_id'   =>  $district,
                    'taluk_id'      =>  $taluk,
                    'country_id'    =>  $country,
                    'photo'         =>  '',
                    'kyc_type'      =>  $kyc_type,
                    'kyc_doc'       =>  '',
                );
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
            */
        }
        echo json_encode($result);
    }

    //Updated on 03-09-2022 pincode check 
    function checkPincode_get(){
        $request = (object)$this->input->get();
        // echo json_encode($request->pincode);exit;
        $result = array('status'=>'failed','msg'=>'Required fields are missing.');
        if( !empty($request->pincode) ){
            $condition = " status = 1 and alloted_status = 0 and pincode = '".$request->pincode."'";

            $data = $this->master_db->getRecords('pincodes',$condition,"id,pincode,area,amount,alloted_status");
            $result = array('status'=>'success','data'=>$data);
        }
        echo json_encode($result);
        // $check = $this->app_db->checkPartner($condition);
        // if( count($check) ){ echo 1;}
        // else{ echo 0;}
    }

    //Updated on 04-09-2022
    function registerpin_post(){
        echo '<pre>';print_r($_POST);print_r($_FILES);exit; 
        $result = array('status'=>'failure','msg'=>'Required fields are missing.');

        if( !empty($_POST['type']) && !empty($_POST['name']) && !empty($_POST['phone']) 
            && !empty($_POST['email']) && !empty($_POST['dob']) 
            && !empty($_POST['bloodgroup']) && !empty($_POST['address']) && !empty($_POST['pincode']) && !empty($_POST['pcountry'])
            && !empty($_POST['pstate']) && !empty($_POST['kyc_type']) && !empty($_POST['agree']) 
            && !empty($_FILES['kyc_doc']['name']) && !empty($_FILES['photo']['name'])

            ){
            $subjects = "Channel Partner";
            $phones = trim(preg_replace('!\s+!', '',$this->input->post('phone', true)));
            $mob = $this->master_db->getRecords("partner_personal",['contactno'=>$phones],'*');


            $type = trim(preg_replace('!\s+!', '',$this->input->post('type', true)));
            $country = trim(preg_replace('!\s+!', '',$this->input->post('country', true)));
            $region = $state = $district = $taluk = 0;
            
            $company_name = trim($this->input->post('company_name'));
            $company_type = trim(preg_replace('!\s+!', '',$this->input->post('company_type', true)));
            $gst_no = trim(preg_replace('!\s+!', '',$this->input->post('gst_no', true)));
            $doc_type = trim(preg_replace('!\s+!', '',$this->input->post('doc_type', true)));
            $name = trim($this->input->post('name'));
            $phone = trim(preg_replace('!\s+!', '',$this->input->post('phone', true)));
            $email = trim(preg_replace('!\s+!', '',$this->input->post('email', true)));
            $dob = trim(preg_replace('!\s+!', '',$this->input->post('dob', true)));
            $bloodgroup = trim(preg_replace('!\s+!', '',$this->input->post('bloodgroup', true)));
            $address = trim($this->input->post('address'));
            
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

            $track['name'] = $name;
            $track['email'] = $email;
            $track['phone'] = $phone;
            $track['tfrom'] = "website";
            $track['added_on'] = date('Y-m-d H:i:s');
            $this->master_db->insertRecord('tracking',$track);

            if( intval($type) != 7 ){
                $result = array('status'=>'failure','msg'=>'Invalid channel partner.');
                echo json_encode($result);exit;
            }
            
            $checkCode = $this->master_db->getRecords('partners',"status != -2",'count(id) as id');
            $code = '';
            $code = $code.'PP'.sprintf('%02d', $checkCode[0]->id+1);

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
            // if( !empty($_FILES['document']['name']) ){
            //     $config = array();
            //     $config['upload_path'] = '../app_assets/channel_partner/company_doc/';  
            //     $config['allowed_types'] = 'pdf|jpeg|jpg|png';
            //     $config['max_size'] = 0;    
            //     // I have chosen max size no limit 
            //     //$new_name = $code.'_'. $_FILES["document"]['name']; 
            //     $ext = pathinfo($_FILES["document"]['name'], PATHINFO_EXTENSION);
            //     $new_name = $code.'.'.$ext; 

            //     $config['file_name'] = $new_name;
            //     //Stored the new name into $config['file_name']
            //     $this->load->library('upload', $config);
            //     if (!$this->upload->do_upload('document') && !empty($_FILES['document']['name'])) {
            //         $error = array('error' => $this->upload->display_errors());
            //         //echo '<pre>';print_r($error);exit;
            //     } else {
            //         $upload_data = $this->upload->data();
            //         //echo '<pre>';print_r($upload_data);exit;
            //         $partners['company_doc'] = 'channel_partner/company_doc/'.$upload_data['file_name'];
            //     }
            // }
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
                    'emailid'       =>  $email,
                    'dob'           =>  date('Y-m-d',strtotime($dob)),
                    'bloodgroup'    =>  $bloodgroup,
                    'address'       =>  $address,
                    'city_id'       =>  $district,
                    'pincode'       =>  $pincode,
                    'state_id'      =>  $state,
                    'district_id'   =>  $district,
                    'taluk_id'      =>  $taluk,
                    'country_id'    =>  $country,
                    'kyc_type'      =>  $kyc_type,
                );

                if(!empty($mob[0]->contactno)) {

                }else {
                     $partner_personal['contactno'] = $phone;
                }

               

                // if( !empty($_FILES['photo']['name']) ){
                //     $config2 = array();
                //     $config2['upload_path'] = '../app_assets/channel_partner/photo/';  
                //     $config2['allowed_types'] = 'jpeg|jpg|png';
                //     $config2['max_size'] = 0;    
                //     // I have chosen max size no limit 
                //     //$new_name = $code.'_'. $_FILES["photo"]['name']; 
                //     $ext = pathinfo($_FILES["photo"]['name'], PATHINFO_EXTENSION);
                //     $new_name = $code.'.'.$ext; 
                //     $config2['file_name'] = $new_name;
                    
                //     //Stored the new name into $config['file_name']
                //     $this->load->library('upload', $config2);
                //     // Alternately you can set
                //     $this->upload->initialize($config2);
                //     if (!$this->upload->do_upload('photo') && !empty($_FILES['photo']['name'])) {
                //         $error = array('error' => $this->upload->display_errors());
                //         //print_r($error);exit;
                //     } else {
                //         $upload_data = $this->upload->data();
                //         $partner_personal['photo'] = 'channel_partner/photo/'.$upload_data['file_name'];
                //         //print_r($upload_data);exit;
                //     }
                // }

                // if( !empty($_FILES['kyc_doc']['name']) ){
                //     $config3 = array();
                //     $config3['upload_path'] = '../app_assets/channel_partner/kyc/';  
                //     $config3['allowed_types'] = 'jpeg|jpg|png';
                //     $config3['max_size'] = 0;    
                //     // I have chosen max size no limit 
                //     //$new_name = $code.'_'. $_FILES["kyc_doc"]['name']; 
                //     $ext = pathinfo($_FILES["kyc_doc"]['name'], PATHINFO_EXTENSION);
                //     $new_name = $code.'.'.$ext; 
                //     $config3['file_name'] = $new_name;
                //     //Stored the new name into $config['file_name']
                //     $this->load->library('upload', $config3);
                //     $this->upload->initialize($config3);
                //     if (!$this->upload->do_upload('kyc_doc') && !empty($_FILES['kyc_doc']['name'])) {
                //         //$error = array('error' => $this->upload->display_errors());
                //     } else {
                //         $upload_data = $this->upload->data();
                //         $partner_personal['kyc_doc'] = 'channel_partner/kyc/'.$upload_data['file_name'];
                //     }
                // }
                //echo '<pre>';print_r($partner_personal);exit;
                $this->master_db->insertRecord('partner_personal',$partner_personal);

                // $partner_payment = array(
                //     'partner_id'    =>  $partner_id,
                //     'payment_id'    =>  $payment_mode,
                //     'cheque_no'     =>  $cheque_no,
                //     'cheque_date'   =>  date('Y-m-d',strtotime($cheque_date)),
                //     'bank_name'     =>  $bank_name,
                //     'branch_name'   =>  $branch_name,
                //     'utr_no'        =>  $utr_no,
                //     'status'        =>'Pending',
                //     'created_at'    =>  date('Y-m-d H:i:s')
                // );
                // $this->master_db->insertRecord('partner_payment',$partner_payment);
                $result = array('status'=>'success','msg'=>'Registered successfully.','partner_id'=>$partner_id);
            }
        }
        //echo "Test";exit;
        echo json_encode($result);
    }
}
?>