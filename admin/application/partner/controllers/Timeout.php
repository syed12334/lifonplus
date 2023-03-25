<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Timeout extends CI_Controller {

    /**
     * Index Page for this controller.
     *
     * Maps to the following URL
     *         http://example.com/index.php/pthome
     *    - or -  
     *         http://example.com/index.php/blueadmin/index
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
    public function __construct(){
        parent::__construct();
        $this->load->helper('utility_helper');
        no_cache();
        $this->load->model('home_db');
		$this->data['detail'] = '';
		$this->data['session'] = ADMIN_SESSION;
    }
    
    public function getSession(){
    	
        if(!$this->session->userdata($this->data['session'])){    
            echo 1;//logout
        }else{
	        $sessionval = $this->session->userdata($this->data['session']);
	        $exp = explode("~", $sessionval);
	        if(count($exp) == 2){
	        	$db['username']=$exp[0];
            	$db['password']=$exp[1];
		        $details = $this->home_db->getlogin($db, 0);
		        //print_r($details);exit;
		        if(count($details) && $details[0]->password == $exp[1]){      
	            	if($details[0]->status == 1){
			        	echo 0;  
	            	}else{
	            		$this->session->set_flashdata('message','<div class="alert alert-danger alert-dismissable"><button class="close" aria-hidden="true" data-dismiss="alert" type="button">×</button>Your account has been deactivated. Please contact Administrator.</div>');
	            		echo 1;
	            	}
		        }else{
		        	$this->session->set_flashdata('message','<div class="alert alert-danger alert-dismissable"><button class="close" aria-hidden="true" data-dismiss="alert" type="button">×</button>Invalid Credentials.</div>');
		        	echo 1;
		        }
	        }else{
	        	$this->session->set_flashdata('message','<div class="alert alert-danger alert-dismissable"><button class="close" aria-hidden="true" data-dismiss="alert" type="button">×</button>Invalid Credentials.</div>');
	        	echo 1;
	        }
        }
    }

    
}
?>
    