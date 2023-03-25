<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
error_reporting(-1);ini_set('display_errors',1);
class Login extends CI_Controller {

    /**
	 * __construct function.
	 * 
	 * @access public
	 * @return void
	 */
	public function __construct() {
		
		parent::__construct();
		
		$this->load->helper('utility_helper');
        $this->load->helper('cookie');
        no_cache();
        $this->load->model('home_db');
        $this->load->model('master_db');   
        $this->data['session'] = ADMIN_SESSION;
	}
    
	public function index(){	
//echo "partner";    exit;
	    if($this->session->userdata($this->data['session'])){
	        redirect('dashboard');
	    }else{
	        if(!$this->session->userdata('Encodekey')){
	            $this->session->userdata('Encodekey', rand());
	        }
	        $this->load->view('login_view',$this->data);
	    }
	}
	
	function checklogin(){
	    $phone = trim(preg_replace('!\s+!', '',$this->input->post('phone', true)));
	    $password = trim(preg_replace('!\s+!', '',$this->input->post('password', true)));
	    //echo '<pre>';print_r($_POST);exit;	
	    if($_SERVER['REQUEST_METHOD']==='POST' && $phone != "" && $password != "")
	    {
			$org = base64_decode($password);
			$exp = explode(" ",$org);
			if(count($exp) == 2 && $this->session->userdata('Encodekey') == $exp[0]){
				$db['phone'] = $phone;
				$db['password'] = $exp[1];
				//print_r($exp);exit;
				$details = $this->home_db->getlogin($db, 1);
				//echo $this->db->last_query();echo '<pre>';print_r($details);exit;	
				if(count($details)){ // login check					
					if($details[0]->status == 1){
						$db = array(
							"user_id"=>$details[0]->id,
							"login_datetime"=>date("Y-m-d H:i:s"),
							"ipaddress"=>$this->home_db->get_client_ip()
						);
						$this->master_db->insertRecord("partner_login_report", $db);
						
						$db = array(
							"login_datetime"=>	date("Y-m-d H:i:s"),
						);
						$this->master_db->updateRecord("partner_login", $db, array("id"=>$details[0]->id));
						$savesession = $details[0]->phone."~".$details[0]->password;
						$this->session->set_userdata(ADMIN_SESSION, $savesession);
						$this->session->unset_userdata("Encodekey");
						echo 1;exit;
					}else{
						echo "Your account has been deactivated. Please contact Administrator.";exit;
					}					
				}else{
					echo "Invalid Credentials.";exit;
				}
			}else{
	            echo "Invalid Credentials.";exit;
	        }
	    }
	    echo "Invalid Credentials.";
	}
	
	public function logout()
	{
	    $this->updatelogin();
	    $this->session->unset_userdata($this->data['session']);
	    redirect(base_url());
	}

	public function updatelogin(){
	    $cookie=$this->data['detail'];
	    if(!empty($cookie))
	    {
	        $id=$cookie[0]->id;
	        $last_login=$cookie[0]->last_login;
	        $db = array(
	            'logout_time'=> date('Y-m-d H:i:s')
	        );
	        $this->home_db->updatelogin($db,$id,$last_login);
	    }
	}
	
	public function getPassword($password = ''){
		//$password = '4vaCv799vbk=';
		//echo $this->home_db->getencryptPass($password,1);
		echo $this->home_db->getencryptPass("gAX2AW+Spd4=",0);
	}

	function forgotPass(){
		$phone = trim(preg_replace('!\s+!', '',$this->input->post('phone', true)));
		$details = $this->home_db->getlogin(array('phone'=>$phone), 0);
		//print_r($details);exit;
		if(count($details)){
			$partner = $this->master_db->getRecords('partner_personal',array('partner_id'=>$details[0]->partner_id),'contactno,fullname,emailid');    
			//send mail
			$this->load->library('Mail');
			$template = $this->master_db->getRecords('templates',array('type'=>1),'id,sms_template,mail_template,label');
			$message = $template[0]->mail_template;
		
			$message = str_replace('{#name#}',$partner[0]->fullname,$message);
			$message = str_replace('{#phone#}',$details[0]->phone,$message);
			$message = str_replace('{#pass#}',$this->home_db->getencryptPass($details[0]->password,0).' ',$message);
			$message = str_replace('{#login_url#}',"<a href='".base_url().' '."' target='_blank'>Click here to login</a>",$message);
			$this->data['company'] = $this->master_db->getRecords('company_detail',array('id'=>1),'name,address,phone_no,email,logo_link,website_url');
			$this->data['messagebody'] = $message;
			$body = $this->load->view('mail_template',$this->data,true);
			//echo $body;exit;
			$this->mail->send_sparkpost_attach($body,array($partner[0]->emailid),$template[0]->label);
			//end
			echo 1;
		}else{
			echo 0;
		}
	}
    
}

/* End of file groclogin.php */
/* Location: ./application/controllers/hmAdmin.php */