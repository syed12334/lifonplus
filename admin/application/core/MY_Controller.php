<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');


class MY_Feecontroller extends CI_Controller {     
	
    
	protected $data;
    public function __construct()
    {
        parent::__construct();
        $this->load->helper('utility_helper');
        $this->load->model('home_db');
        $this->load->model('master_db');
        $this->load->model('global_db');
        $this->load->model('common_db');
        $this->load->model('grid_db');
    }    
    
    public function index()
    {   
	   echo "Invalid access";		 
    } 
    
    function checkNull($value) 
    {
        if ($value == null) {
            return '';
        } else {
            return $value;
        }
    }
    
    protected function sendNotification($gcm_id, $message,$type)
    {
        #API access key from Google API's Console
        //define( 'API_ACCESS_KEY', 'YOUR-SERVER-API-ACCESS-KEY-GOES-HERE' );
        $registrationIds = $gcm_id;
        
        /** for IOS**/
        //$response = $this->sendNotificationIOS($gcm_id, $message,$type);
        
        #prep the bundle
        //$data = array("to" => "cNf2---6Vs9",
        // "notification" => array( "title" => "Shareurcodes.com", "body" => "A Code Sharing Blog!","icon" => "icon.png", "click_action" => "http://shareurcodes.com"));
        //$fields = array("to" => "<valid-token>", "data" => array("data"=> array( "message"=>"This is some data", "title"=>"This is the title", "is_background"=>false, "payload"=>array("my-data-item"=>"my-data-value"), "timestamp"=>date('Y-m-d G:i:s') ) ) );
        $msg = array
        (
            'message' => array('message'=>$message,'id'=>0,'type'=>$type),
            'title'	=> '',
            'icon'	=> 'myicon',/*Default Icon*/
            'sound' => 'mySound'/*Default sound*/
        );
        //$data = array();
        //$data['data'] = $msg;
        $fields = array
        (
            'registration_ids' => $registrationIds,
            'data'	=> $msg,
            'priority' => 'high'
        );
        //print_r($fields);
        //return json_encode( $fields );exit(0);
        //print_r();
        
        $headers = array
        (
            'Authorization: key=' . API_ACCESS_KEY,
            'Content-Type: application/json'
        );
        
        
        set_time_limit(40);
        #Send Reponse To FireBase Server
        $ch = curl_init();
        curl_setopt( $ch,CURLOPT_URL, 'https://fcm.googleapis.com/fcm/send' );
        curl_setopt( $ch,CURLOPT_POST, true );
        curl_setopt( $ch,CURLOPT_HTTPHEADER, $headers );
        curl_setopt( $ch,CURLOPT_RETURNTRANSFER, true );
        curl_setopt( $ch,CURLOPT_SSL_VERIFYPEER, false );
        curl_setopt( $ch,CURLOPT_POSTFIELDS, json_encode( $fields ) );
        $result = curl_exec($ch );
        //curl_close( $ch );
        #Echo Result Of FireBase Server
        //$result = $result.':::::::::::::'.$response;
        return $result;
    }

    /*
    protected function send_sparkpost_attach($body, $toemail, $subject, $pdfFilePath, $pdf_name){
        include('../sparkpostphpcurl-master/sparkpost-api.php');
        $mail = new sparkPostApi(MAIL_URL,MAIL_KEY);        
        $mail-> from(array('email' => FROM_MAIL,'name' => FROM_NAME));
        $mail-> subject($subject);
        $mail-> html($body);
        $mail-> setTo($toemail);
        $mail->setReplyTo(FROM_MAIL);
        if($pdfFilePath != ""){
            $filePath = $pdfFilePath;
            $fileName = $pdf_name;
            $fileType = mime_content_type($filePath.$fileName);
            $fileData = base64_encode(file_get_contents($filePath.$fileName));
            $arr = array();
            $arr[] = array('name' => $fileName, 'type' => $fileType, 'data' => $fileData);
            $mail->attachments($arr);
        }
        try{
            $res = $mail->send();
            //print_r($res);
            //print "arraytextMessage Sent";
        }catch (Exception $e) {
           // print $e;
        }        
        $mail->close();
        //return $res;
    }
    */
}