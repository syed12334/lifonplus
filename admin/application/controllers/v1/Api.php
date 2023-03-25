<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

error_reporting(-1);ini_set('display_errors',1);
require APPPATH . 'libraries/REST_Controller.php';
class Api extends REST_Controller {

	public function __construct() {
		parent::__construct();		
		$this->load->helper('utility_helper');
        $this->load->helper('cookie');
        no_cache();
        $this->load->model('master_db');
        $this->load->model('app_db');
        
    }

    function index_post(){}

    function index_get(){}
	
	
    function terms_get(){        
        $data = '';
        $check = $this->master_db->getRecords('terms_conditions',"id=1",'terms');
        if( count($check) ){
            $data = $check[0]->terms;
        }
        $result = array('status'=>'success','data'=>$data);
        echo json_encode($result);
    }

    function about_get(){        
        $data = '';
        $check = $this->master_db->getRecords('about_us',"id=1",'aboutus');
        if( count($check) ){
            $data = $check[0]->aboutus;
        }
        $result = array('status'=>'success','data'=>$data);
        echo json_encode($result);
    }

    function privacy_get(){        
        $data = '';
        $check = $this->master_db->getRecords('privacy_policy',"id=1",'privacy');
        if( count($check) ){
            $data = $check[0]->privacy;
        }
        $result = array('status'=>'success','data'=>$data);
        echo json_encode($result);
    }

}
?>