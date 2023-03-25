<?php defined('BASEPATH') OR exit('No direct script access allowed');

class SMS {
    var $serverURL = 'http://bulksms.abhinavinfo.com/sendSMS';
    var $username = 'LIFEON';
    var $sendername = 'LIFEON';
    var $smstype = 'TRANS';
    var $apikey = 'c84478cf-54c7-442c-9a1e-4f1198e31e5a';
    
    function sendSmsToUser( $content='', $to=''){

		if( $content!='' ){	
            $content = htmlentities($content,ENT_COMPAT);
            $data = sprintf('username=%s&message=%s&sendername=%s&smstype=%s&numbers=%s&apikey=%s',$this->username,str_replace("%250A","%0A",urlencode($content)),$this->sendername,$this->smstype,$to,$this->apikey);
            $str_request = $this->serverURL.'?'.$data;
            //echo $str_request;exit;
            $str_response = $this->postdata($str_request); 
            //echo $str_response;exit;
            if ($str_response==""){
                $str_response = "REQUEST FAILED \t";
            }
           
            if( $fp=fopen('smsmessagesResponse.txt','a+') ){	
                fwrite($fp, $str_response . "\t" . date ("l dS of F Y h:i:s A")."\n".$str_request."\n" );
                fclose($fp);
            }
            /*	RECORDING OF THE MESSAGE EVENT FINISHED	*/
            return $str_response;
		}else{
			return '';
		}
    }
    
    function postdata($url){
        //The function uses CURL for posting data to server
        $objURL = curl_init($url);
        curl_setopt($objURL, CURLOPT_RETURNTRANSFER, 1);
        $retval = trim(curl_exec($objURL));
        curl_close($objURL);
        return $retval;
    }

}