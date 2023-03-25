<?php
/*
Created on 16/Mar/2007
Main changes:
1. Uses CURL (Client URL) API for sending Messages
2. The server URL has now been changed to api.whizsms.com
*/
class sendSms
{
//http://203.212.70.200/smpp/sendsms?username=cycouch&password=cycouch145&to=8660712752&from=CYCART&udh=&text= test sms&dlr-m
	//var $serverURL = 'http://www.smsjust.com/blank/sms/user/urlsms.php';
	var $serverURL = 'http://smsalert.dmudra.com/api/smsapi.aspx';
	/* promotional*/
	/* var $uid = '10084_API';	//Your Username provided by Whizsms
	var $pwd = 'cI4tIP35bo';	
	var $cdmaNumber = '919810012345';//Write your Sender ID for CDMA here
    var $gsmSender = 'ABC';  */
    
    var $uid = 'parchfxz';	//Your Username provided by Whizsms
    var $pwd = 'parchf$@3xcv';
    var $cdmaNumber = 'PARCHFx';//Write your Sender ID for CDMA here
    var $gsmSender = 'PARCHFx'; 
    
    function GetSenderID()
    {
        return $this->cdmaNumber;
        
    }
    
    function postdata($url)
    {
    //The function uses CURL for posting data to server
          $objURL = curl_init($url);
          curl_setopt($objURL, CURLOPT_RETURNTRANSFER, 1);
        $retval = trim(curl_exec($objURL));
        curl_close($objURL);
        return $retval;
    }
   
	function sendSmsToUser( $content='', $to='')
    {
		if( $content!='' )
        {
		//username=cycouch&password=cycouch145&to=8660712752&from=CYCART&udh=&text= test sms&dlr-m
            $content = htmlentities($content,ENT_COMPAT);
			$data = sprintf('username=%s&password=%s&from=%s&to=%s&message=%s',$this->uid,htmlentities($this->pwd),$this->GetSenderID(),str_replace("amp%3B","",urlencode($to)),str_replace("amp%3B","",urlencode($content)),"");
	
        	//echo "Full data is ".$data;
           
            $str_request = $this->serverURL.'?'.$data;
			$str_response = $this->postdata($str_request);    
			//echo "Str response-----".$str_request."-----";
             if ($str_response=="")
            {
                $str_response = "REQUEST FAILED \t";
            }
           
                 if( $fp=fopen('smsmessagesResponse.txt','a+') ){	
                    fwrite($fp, $str_response . "\t" . date ("l dS of F Y h:i:s A")."\n".$str_request."\n" );
                    fclose($fp);
                }  
            /*	RECORDING OF THE MESSAGE EVENT FINISHED	*/
            return $str_response;
		}
        else
        {
			return '';
		}
	}
}
?>