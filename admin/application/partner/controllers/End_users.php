<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
//error_reporting(E_ALL);ini_set('display_errors', '1');
class End_users extends CI_Controller {   

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
        //echo "<pre>";print_r($this->data['detail']);exit;
        $this->end_users();
    }


    //update 13-07-2021
    public function end_users(){
        //echo "<pre>";print_r($this->data['detail']);exit;
        $this->load->view('end_users/end_users_view',$this->data);
    }

    public function usersList(){
        $det = $this->data['detail'];
       //echo "<pre>";print_r($det);exit;
		
        $data_list = $this->web_db->getusersList($det);
       // echo '<pre>';print_r($det);exit;
	  // echo $this->
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

            
            $photo = "";
            if($row->photo !="")
			{				
              $photo = "<img src='".base_url().$row->photo."' width='70px' height='70px'>";
			}

             $card ="";
             if($row->card_img !="")
            {               
              $card = "<a href='".app_url().$row->card_img."' download><img src='".app_url().$row->card_img."' width='100px' height='100px'></a>";
            }
			
            $sub_array[] = $action;
            $sub_array[] = $card;
            $sub_array[] = $row->card_no;
            $sub_array[] = $row->code;
            $sub_array[] = $row->name;
            $sub_array[] = $row->mobileno;
            $sub_array[] = $row->package;
            $sub_array[] = $row->email_id;
            $sub_array[] = $row->country_name;
            $sub_array[] = $row->state_name;
			$sub_array[] = $row->dist_name;
			$sub_array[] = $row->city_name;
			$sub_array[] = $photo;
			$sub_array[] = $row->referral_code;

            $data[] = $sub_array;
            
        }
        $_POST["length"] = -1;
        $members = $this->web_db->getusersList($det);
        
        $total = count($members);
        $output = array(
            "draw"              =>  intval($_POST["draw"]),
            "recordsTotal"      =>  $total,
            "recordsFiltered"   =>  $total,//$this->master_db->get_filtered_data("guards")
            "data"              =>  $data
        );
        echo json_encode($output);
    }

    public function setUserStatus(){
        $det = $this->data['detail'];
        $id = trim($this->input->post('id'));
        $status = trim($this->input->post('status'));
         if($status ==-1) {
                $this->master_db->deleterecord('customers',['id'=>$id]);
                $this->master_db->deleterecord('customer_package',['customer_id'=>$id]);
                $this->master_db->deleterecord('customer_points',['customer_id'=>$id]);
                $this->master_db->deleterecord('cust_point_history',['customer_id'=>$id]);
               echo 1;
        }else {
            $where_data = array(
            'status'=>$status,
            'updated_at'=>date('Y-m-d H:i:s'),
            'updated_by'=>$det[0]->id
        );
        $this->master_db->updateRecord('customers',$where_data,array('id'=>$id));
        echo 1;
        }
    }

   

    public function getuserDetail($id = ''){
        $det = $this->data['detail'];
        if( $id != '' ){
            $this->data['user'] = $check = $this->web_db->getUserDetail($id);
			$this->data['documents'] = $this->web_db->getCustomerDocuments($id);
            echo $this->load->view('end_users/user_detail',$this->data,true);
        }
    }
	
	public function add_user(){
		$this->data['type']=1;
         $this->data['package'] = $this->master_db->getRecords('packages',['status'=>1],'id,name');
        $this->load->view('end_users/user_add',$this->data);
    }
	
	
	
	 function registeruser_post(){
        $det = $this->data['detail'];
        $partid = $det[0]->id;
        $pids = $det[0]->partner_id;
        $mbl = $det[0]->phone;
        //echo '<pre>';print_r($_POST);exit;
		 if( empty($_POST['name']) && empty($_POST['mobile']) ){
            $result = array('status'=>'failure','msg'=>'Required fields are missing.');
		 }
        if( !empty($_POST['name']) && !empty($_POST['mobile']) ){
            
            $name = trim(preg_replace('!\s+!', ' ',html_escape($this->input->post('name', true))));
            $mobile = trim(preg_replace('!\s+!', '',html_escape($this->input->post('mobile', true))));
            $email_id = trim(preg_replace('!\s+!', '',html_escape($this->input->post('email_id', true))));
            $referral_code = trim(preg_replace('!\s+!', '',html_escape($this->input->post('referral_code', true))));
			$gender = trim(preg_replace('!\s+!', ' ',html_escape($this->input->post('gender', true))));
			$country_id = trim(preg_replace('!\s+!', '',html_escape($this->input->post('country', true))));
			$dob = trim(preg_replace('!\s+!', '',html_escape($this->input->post('dob', true))));
			$blood_group = trim(preg_replace('!\s+!', '',html_escape($this->input->post('bloodgroup', true))));
			$address = trim(preg_replace('!\s+!', ' ',html_escape($this->input->post('address', true))));
			$state_id = trim(preg_replace('!\s+!', '',html_escape($this->input->post('state', true))));
			$district_id = trim(preg_replace('!\s+!', '',html_escape($this->input->post('district', true))));
			$taluk_id = trim(preg_replace('!\s+!', '',html_escape($this->input->post('taluk', true))));
            $packageId = trim(preg_replace('!\s+!', '',html_escape($this->input->post('package', true))));
            $getPartnerpins = $this->master_db->sqlExecute('select pp.qty,pp.id,p.id as pid from partner_pins pp left join pins p on p.id = pp.pin_id where pp.partner_id='.$pids.' and pp.qty !=0 and p.package_id ='.$packageId.'');
            //echo $this->db->last_query();exit;
            $getPackageList = $this->master_db->getRecords('packages',['id'=>$packageId],'name');
            

            if(count($getPartnerpins) ==0) {
                $result = array('status'=>'failure','msg'=>'You dont have sufficient PINs to create end users, please get more PINs from the company/dealer');
                echo json_encode($result);exit;
            }
            if( preg_match('/^[0-9]{10}+$/', $mobile) == false) {
                $result = array('status'=>'failure','msg'=>'Invalid mobile number.');
                echo json_encode($result);exit;
            }
            $track['name'] = $name;
            $track['email'] = $email_id;
            $track['phone'] = $mobile;
            $track['tfrom'] = "website";
            $track['added_on'] = date('Y-m-d H:i:s');
            $this->master_db->insertRecord('tracking',$track);
          
            $condition = " mobileno = ".$mobile." and status != -1 ";
            $checkCustomer = $this->master_db->getRecords('customers',$condition,'id');
            if(count($checkCustomer)){
                $result = array('status'=>'failure','msg'=>'Mobile No or Email ID already exits.');
            }else{
                $this->load->library('Mail');
                $this->data['company'] = $this->master_db->getRecords('company_detail',array('id'=>1),'name,address,phone_no,email,logo_link,website_url');
                $web = "https://play.google.com/store/apps/details?id=com.paxykop.lifeonplus";
                $clientphone = "+919986880000";
            
             // $sm= "Thanks for becoming a member of LIFEON+ Global Digital Health Smart Card - {#var#}{#var#}. We welcome you to the Healthy World. Please log on to ".$web." for products and Services to view and update your profile. Any clarification please contact ".$clientphone." Team LIFEON+.";
           
             //       $this->data['messagebody'] = str_replace("- {#var#}{#var#}","",$sm);
                $mailbody = $this->load->view('end_users/end_user_mail',$this->data,true);
                $this->mail->send_sparkpost_attach($mailbody,array($email_id,'info@lifeonplus.com'),"End User");

                 $this->load->library('SMS');
                 $mobiless = $mobile.","."9986880000";
                  // $sms= "Thanks for becoming a member of LIFEON+ Global Digital Health Smart Card - {#var#}{#var#}. We welcome you to the Healthy World. Please log on to ".$web." for products and Services to view and update your profile. Any clarification please contact ".$clientphone." Team LIFEON+.";
                // $sms = "Dear Member, Thanks for "."lifeonplus"." subscription.Your account is activated.Download App https://play.google.com/store/apps/detailsid=com.paxykop.lifeonplus. Regards, Team Lifeonplus";
                 $sms = "Dear Member, Thanks for lifeonplus subscription. Your account is activated. Download App https://play.google.com/store/apps/details?id=com.paxykop.lifeonplus. Regards, Team Lifeonplus - Paxykop Technologies";
                 
                 
                   // $smstxt = str_replace("- {#var#}{#var#}","",$sms);
                    //$sms = str_replace('{#var#}','',$smstxt);
                     $this->sms->sendSmsToUser($sms,$mobiless);
                $code = $this->master_db->getRecords('system_codes','id=1','id,prefix,cust_prefix,cust_no,card_prefix');
                $slno = ($code[0]->cust_no+1);
                $slno = sprintf('%04d', $slno);
                $ccode = $code[0]->prefix.$code[0]->cust_prefix.$slno;
                 
                $insert = array(
                    'code'          =>  $ccode,
                    'partner_id'    =>  $partid,
                    'name'          =>  $name,
                    'mobileno'      =>  $mobile,
                    'email'         =>  $email_id,
					'dob'           =>  $dob,
					'bloodgroup'    =>  $blood_group,
					'address'       =>  $address,
					'gender'        =>  $gender,
                    'referral_code' =>  $referral_code,
                    'status'        =>  1,
                    'created_at'    =>  date('Y-m-d H:i:s'),
					'country_id'    =>  $country_id,
					'state_id'      =>  $state_id,
					'district_id'   =>  $district_id,
					'taluk_id'      =>  $taluk_id,
                    'package'       => $packageId
                    
                );
				 if( !empty($_FILES['photo']['name']) ){
                    $config2 = array();
                    $config2['upload_path'] = './../app_assets/customer_photo/';  
                    $config2['allowed_types'] = 'jpeg|jpg|png';
                    $config2['max_size'] = 0;    
                    // I have chosen max size no limit 
                    //$new_name = $code.'_'. $_FILES["photo"]['name']; 
                    $ext = pathinfo($_FILES["photo"]['name'], PATHINFO_EXTENSION);
                    $new_name = $ccode.'.'.$ext; 
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
                        $insert['photo'] = 'customer_photo/'.$upload_data['file_name'];
                        //print_r($upload_data);exit;
                    }
                }
				
				 $customer_id = $this->master_db->insertRecord('customers',$insert);
				
                if(count($customer_id) >0){

                        if(count($getPartnerpins) >0) {
                            $update['qty'] = $getPartnerpins[0]->qty - 1;
                            $this->master_db->updateRecord('partner_pins', $update,array('partner_id'=>$pids,'pin_id'=>$getPartnerpins[0]->pid));
                        }
                        $pinMinus = $getPartnerpins[0]->qty - 1;
                    $this->master_db->updateRecord('system_codes',array('cust_no'=>$slno),array('id'=>1));
                    $smsRetailer = "Acct ".$ccode." debited with ".$getPackageList[0]->name." LIFEON+ Pins by transfer to End User Available Bal Pins ".$pinMinus." Nos. Contact us on ".$clientphone.". Regards, Team LIFEON+.";
                   // $this->sms->sendSmsToUser($smsRetailer,$mbl);
                    $package = $this->master_db->getRecords('packages',['status'=>1,'id'=>$packageId],'id,validity');
                  // echo $this->db->last_query();exit;
                    if(count($package) >0){
                        $card_no = $this->home_db->getCardno($code[0]->card_prefix);
                       // $card_no = $code[0]->card_prefix;
                        //echo "<pre>";print_r($card_no);exit;
                        $insert = array(
                            'customer_id'   =>  $customer_id,
                            'package_id'    =>  $packageId,
                            'card_no'       =>  $card_no,
                            'valid_from'    =>  date('Y-m-d'),
                            'valid_to'      =>  date('Y-m-d',strtotime('+'.$package[0]->validity.' days')),
                            'expiry_date'   =>date('Y-m-d',strtotime('+'.$package[0]->validity.' days')),
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

                                 $condition = " c.id = ".$customer_id." and c.status = 1 ";
            $checkDetails = $this->app_db->getCustomerDetail($condition);
            //echo $this->db->last_query();exit;
            if(count($checkDetails)){
                if( $checkDetails[0]->blood_group == '' ){
                    $result = array('status'=>'failure','msg'=>'Profile not updated.');    
                }else{
                   $this->load->library('m_pdf');
                    if(empty($checkDetails[0]->qrcode) ){
                        $this->load->library('phpqrcode/qrlib');
                        $SERVERFILEPATH = './../app_assets/qrcode/';
                        $text = "https://www.lifeonplus.com/admin/v1/emergency_reports?user_id=".$checkDetails[0]->user_id;
                        //echo $text;exit;
                        $text1= substr($text, 0,9);                    
                        $folder = $SERVERFILEPATH;
                        $file_name1 = $checkDetails[0]->code."_".time().".png";
                        $file_name = $folder.$file_name1;
                        QRcode::png($text,$file_name);
                        $this->master_db->updateRecord('customer_package',array('qrcode'=>'qrcode/'.$file_name1),array('customer_id'=>$customer_id));
                        //echo $this->db->last_query();exit;
                    }

                   // echo '<pre>';print_r($checkDetails);exit;
                  
                    $checkDetails[0]->photo = app_asset_url().$checkDetails[0]->photo;
                     $checkDetails[0]->qrcode = app_asset_url().$checkDetails[0]->qrcode;
                    $this->data['customer'] = $checkDetails[0];
                    $html = $this->load->view('card_view',$this->data,true);
                    //echo $html;exit;
                    $pdf_name = $checkDetails[0]->user_id.'_'.time().'.pdf';
                    $file_name = './../app_assets/card_image/'.$pdf_name;
                     $mpdf = new mPDF();
                     $mpdf->AddPage('P');
                    $mpdf->WriteHTML($html);
                   $file = $mpdf->Output($file_name, "F");
                    
                    $image_name = './../app_assets/card_image/'.$checkDetails[0]->user_id.'source.png';
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
                    $config['width'] = 500;
                    $config['height'] =350;   
                    $img_name = $checkDetails[0]->user_id.'_'.time().'.png';
                    $new_name = './../app_assets/card_image/'.$img_name;
                    $config['new_image'] = $new_name;
                    $this->load->library('image_lib', $config);
                    //$this->image_lib->crop();
                    
                    $this->image_lib->initialize($config); 
                    if (!$this->image_lib->crop()){
                        //echo $this->image_lib->display_errors();
                    }
                    unlink($image_name);
                    unlink($file_name);
                    $new_name = str_replace('./../','',$new_name);
                    $update = array('card_img'=>$new_name,'updated_at'=>date('Y-m-d H:i:s'));
                    $where = array('customer_id'=>$checkDetails[0]->user_id,'pstatus'=>1);
                    $this->master_db->updateRecord('customer_package',$update,$where);

                    }
                }
                }
                $result = array('status'=>'success','msg'=>'Registered successfully.','user_id'=>$customer_id);
            }
        }
        echo json_encode($result);
    }

public function demouser() {
    echo app_asset_url();
}
  
	
}
?>