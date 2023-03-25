<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Myprofile extends CI_Controller {   
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
    
    public function index()
    {    	
		$this->load->view('myprofile_view',$this->data);       
    } 
	
	public function edit_profile()
    {
        $details=$this->data['detail'];
        if($_SERVER['REQUEST_METHOD'] != 'POST')
        {
            $this->load->view('profile_edit',$this->data);
        }
        else if($_SERVER['REQUEST_METHOD']=='POST')
        {
        $new_password=trim(preg_replace('!\s+!', '',$this->input->post('new_password')));
    	$password = trim(preg_replace('!\s+!', '',$this->input->post('password')));
    	$password=$this->home_db->getencryptPass($password);
    	if($password == $details[0]->password )
    	{
    		if($new_password != "")
    		{ // pwd updated
    			$new_password=$this->home_db->getencryptPass($new_password);
    		}
    		$db = array(
    			"password" =>$new_password,
    			"pwd_modify_date" => date("Y-m-d H:i:s"),
    		);
    		$res=$this->master_db->updateRecord('admin',$db,array("id"=>$details[0]->id));
    		$db['username']=$details[0]->username;
    		$details = $this->home_db->getlogin($db, 0);
			$savesession = $details[0]->username."~".$details[0]->password;
	        $this->session->set_userdata(ADMIN_SESSION, $savesession);
			//echo '<div class="alert alert-success alert-dismissable"><button class="close" aria-hidden="true" data-dismiss="alert" type="button">&times;</button>Password updated successfully!</div>';
    		$this->session->set_flashdata('message','<div class="alert alert-success alert-dismissable"><button class="close" aria-hidden="true" data-dismiss="alert" type="button">&times;</button>Password updated successfully!</div>');
    		/* redirect(base_url()."myprofile"); */
    		echo 1;
    	}
    	else
    	{
			echo '<div class="alert alert-danger alert-dismissable"><button class="close" aria-hidden="true" data-dismiss="alert" type="button">&times;</button>Password Doesnt Match!</div>';
    		/* $this->session->set_flashdata('message','<div class="alert alert-danger alert-dismissable"><button class="close" aria-hidden="true" data-dismiss="alert" type="button">&times;</button>Old Password Doesnt Match!</div>');
    		redirect(base_url()."myprofile"); */
    	    //echo "Old Password Doesnt Match!";
    	}
        }
    }
    
}
?>