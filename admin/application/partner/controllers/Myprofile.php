<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Myprofile extends CI_Controller {   
	
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
        $details=$this->data['detail'];	
        $this->data['partner'] = $this->master_db->getRecords('partner_personal',array('partner_id'=>$details[0]->partner_id),'*');    
        $this->data['company'] = $this->master_db->getRecords('partners',array('id'=>$details[0]->partner_id),'*');    
        $this->data['payment'] = $this->master_db->getRecords('partner_payment',array('partner_id'=>$details[0]->partner_id),'*');    
        $this->data['bank'] = $this->master_db->getRecords('partner_bank',array('partner_id'=>$details[0]->partner_id),'*');
		$this->load->view('myprofile_view',$this->data);       
    } 
	
	public function edit_profile()
    {
        $details=$this->data['detail'];
        if($_SERVER['REQUEST_METHOD'] != 'POST'){
            $this->load->view('profile_edit',$this->data);
        }else if($_SERVER['REQUEST_METHOD']=='POST'){
            $new_password=trim(preg_replace('!\s+!', '',$this->input->post('new_password')));
            $password = trim(preg_replace('!\s+!', '',$this->input->post('password')));
            $password=$this->home_db->getencryptPass($password);
            if($password == $details[0]->password ){
                if($new_password != ""){ // pwd updated
                    $new_password=$this->home_db->getencryptPass($new_password);
                }

                $db = array(
                    "password" =>$new_password,
                    "pwd_modify_date" => date("Y-m-d H:i:s"),
                );
                $res=$this->master_db->updateRecord('partner_login',$db,array("id"=>$details[0]->id));
                $db['phone']=$details[0]->phone;
                $details = $this->home_db->getlogin($db, 0);
                $savesession = $details[0]->phone."~".$details[0]->password;

                //send mail
                $partner = $this->master_db->getRecords('partner_personal',array('partner_id'=>$details[0]->partner_id),'contactno,fullname,emailid');    
                $template = $this->master_db->getRecords('templates',array('type'=>3),'id,sms_template,mail_template,label');
                $this->load->library('Mail');
                $message = $template[0]->mail_template;
                $message = str_replace('{#name#}',$partner[0]->fullname,$message);
                $message = str_replace('{#phone#}',$partner[0]->contactno,$message);
                $message = str_replace('{#pass#}',$new_password.' ',$message);
                $this->data['company'] = $this->master_db->getRecords('company_detail',array('id'=>1),'name,address,phone_no,email,logo_link,website_url');
                $this->data['messagebody'] = $message;
                $body = $this->load->view('mail_template',$this->data,true);
                //echo $body;exit;
                $this->mail->send_sparkpost_attach($body,array($partner[0]->emailid),$template[0]->label);
                //end
                
                $this->session->set_userdata(ADMIN_SESSION, $savesession);
                $this->session->set_flashdata('message','<div class="alert alert-success alert-dismissable"><button class="close" aria-hidden="true" data-dismiss="alert" type="button">&times;</button>Password updated successfully!</div>');
                echo 1;
            }else{
                echo '<div class="alert alert-danger alert-dismissable"><button class="close" aria-hidden="true" data-dismiss="alert" type="button">&times;</button>Password Doesnt Match!</div>';
            }
        }
    }
    
    function getBankForm(){
        $det = $this->data['detail'];
        $this->data['bank'] = $this->master_db->getRecords('partner_bank',array('partner_id'=>$det[0]->partner_id),'*');
        echo $this->load->view('bank_form',$this->data,true);
    }

    function saveBankForm(){
        $det = $this->data['detail'];
        //echo '<pre>';print_r($det);exit;
        if( !empty($_POST['bname']) && !empty($_POST['account_no']) && !empty($_POST['ifsc']) && !empty($_POST['branch']) ){
            $bname = trim(preg_replace('!\s+!', ' ',html_escape($this->input->post('bname', true))));
            $account_no = trim(preg_replace('!\s+!', ' ',html_escape($this->input->post('account_no', true))));
            $ifsc = trim(preg_replace('!\s+!', ' ',html_escape($this->input->post('ifsc', true))));
            $branch = trim(preg_replace('!\s+!', ' ',html_escape($this->input->post('branch', true))));

            $check = $this->master_db->getRecords('partner_bank',array('partner_id'=>$det[0]->partner_id),'id');
            if(count($check)){
                $update = array(
                    'bank_name'     =>  $bname,
                    'account_no'    =>  $account_no,
                    'ifsc_code'     =>  $ifsc,
                    'branch_name'   =>  $branch
                );
                $this->master_db->updateRecord('partner_bank',$update,array('id'=>$check[0]->id));
            }else{
                $insert = array(
                    'partner_id'    =>  $det[0]->partner_id,
                    'bank_name'     =>  $bname,
                    'account_no'    =>  $account_no,
                    'ifsc_code'     =>  $ifsc,
                    'branch_name'   =>  $branch
                );
                $this->master_db->insertRecord('partner_bank',$insert);
            }
            echo 1;
        }else{
            echo 0;
        }
        //echo '<pre>';print_r($_POST);exit;
    }
}
?>