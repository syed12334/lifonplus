<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
error_reporting(E_ALL);ini_set('display_errors', '1');
class Testing extends CI_Controller {  
	public function __construct() {
		$this->load->library('phpqrcode/qrlib');
	}
	public function index() {
		$SERVERFILEPATH = '../app_assets/qrcode/';
                        $text = "<a href='https://www.lifeonplus.com/'>https://www.lifeonplus.com</a>";
                        $text1= substr($text, 0,9);                    
                        $folder = $SERVERFILEPATH;
                        $file_name1 = $checkCustomer[0]->code."_".time().".png";
                        $file_name = $folder.$file_name1;
                        QRcode::png($text,$file_name);
	}
}