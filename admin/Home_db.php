<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Home_db extends CI_Model{
    
    
     function compress_image($source_url, $destination_url, $quality)
    {
       $info = getimagesize($source_url);
       //print_r(getimagesize($source_url));exit;
       
       if ($info['mime'] == 'image/jpeg')
           $image = imagecreatefromjpeg($source_url);
           
           elseif ($info['mime'] == 'image/gif')
           $image = imagecreatefromgif($source_url);
           
           elseif ($info['mime'] == 'image/png')
           $image = imagecreatefrompng($source_url);
           elseif ($info['mime'] == 'image/jpg')
           $image = imagecreatefrompng($source_url);
           elseif ($info['mime'] == 'image/ico')
           $image = imagecreatefrompng($source_url);
           
          $ret = imagejpeg($image, $destination_url, $quality);
          return $destination_url;
    }
    
    
    public function resizeImage($filename,$width, $height){
		$this->load->library('image_lib');
		$config['image_library'] = 'gd2';
		$config['source_image'] = $_SERVER['DOCUMENT_ROOT'].'/divecha/'.$filename;
		$config['create_thumb'] = FALSE;
		$config['maintain_ratio'] = FALSE;
		$config['width'] = $width;
		$config['height'] = $height;
		$config['new_image'] = $_SERVER['DOCUMENT_ROOT'].'/divecha/'.$filename;
		$this->image_lib->initialize($config);
		if(!$this->image_lib->resize())
		{
			return $this->image_lib->display_errors();
		}
		else{
			return 1;
		}
		$this->image_lib->clear();
	
	}
	
	function getencryptPass($pass, $encrypt=1){
	    require_once 'includes/PkcsKeyGenerator.php';
	    require_once 'includes/DesEncryptor.php';
	    require_once 'includes/PbeWithMd5AndDes.php';
	    
	    $salt ='A99BC8325634E303';
	    
	    // Iteration count
	    $iterations = 19;
	    $segments = 1;
	    $password = $pass;
	    
	    //secret key
	    $keystring = 'LIFEONPLUS';
	    if($encrypt){
	        //encrypt the user entered password
	        return $crypt = PbeWithMd5AndDes::encrypt(
	            $password, $keystring,
	            $salt, $iterations, $segments
	            );
	        
	    }
	    else{
	        //encrypt the user entered password
	        return $decrypt = PbeWithMd5AndDes::decrypt(
	            $password, $keystring,
	            $salt, $iterations, $segments
	            );
	    }
	}
	
	function getlogin($db=array(), $check){
	    //try {
	    //$username = $this->db->escape($db['username']);
	    $wdb = array("status != "=> -1, "phone"=>$db['phone']);
	    $pass = "";
	    if($check){
	        $wdb["password"] = $this->getencryptPass($db['password']);
        }	    
        $this->db->select("id, phone, password, status, user_id")
                 ->from('user_creation')
                 ->where($wdb);
		$q = $this->db->get();
		return $q !== FALSE ? $q->result() : array();
	}
	
	function updatelogin($db =array(),$id,$login)
	{
	    $this->db->where('user_id',$id);
	    $this->db->where('login_datetime',$login);
	    $q=$this->db->update('admin_login_report',$db);
	    $total = $this->db->affected_rows();
	    if($total>0){ return 1; }
	    else{ return 0; }
	}
	
	function get_client_ip() {
        if (!empty($_SERVER['HTTP_CLIENT_IP'])) {   //check ip from share internet
            $ip = $_SERVER['HTTP_CLIENT_IP'];
        } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {   //to check ip is pass from proxy
            $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
        } else {
            $ip = $_SERVER['REMOTE_ADDR'];
        }
        return $ip;
    }

    
	 function getnumberformat_outcomma($num){
    	return str_replace(".00", "", (string)number_format((float)$num, 0, '.', ''));
    }
	
	function getnumberformat($num){
    	return str_replace(".00", "", (string)number_format((float)$num, 0, '.', ','));
    }
    
    //update 02-04-2021
    function strtourl($string){
        $slug = trim($string); // trim the string
        $slug= preg_replace('/[^a-zA-Z0-9 -]/','',$slug ); // only take alphanumerical characters, but keep the spaces and dashes too...
        $slug= str_replace(' ','-', $slug); // replace spaces by dashes
        $slug= strtolower($slug);  // make it lowercase
        return $slug;
	}

	function randomPassword() {
		$alphabet = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890';
		$pass = array(); //remember to declare $pass as an array
		$alphaLength = strlen($alphabet) - 1; //put the length -1 in cache
		for ($i = 0; $i < 6; $i++) {
			$n = rand(0, $alphaLength);
			$pass[] = $alphabet[$n];
		}
		return implode($pass); //turn the array into a string
	}

	function convert_number($number)
    {
        if (($number < 0) || ($number > 999999999))
        {
            throw new Exception("Number is out of range");
        }

        $Gn = floor($number / 100000);  /* Millions (giga) */
        $number -= $Gn * 100000;
        $kn = floor($number / 1000);     /* Thousands (kilo) */
        $number -= $kn * 1000;
        $Hn = floor($number / 100);      /* Hundreds (hecto) */
        $number -= $Hn * 100;
        $Dn = floor($number / 10);       /* Tens (deca) */
        $n = $number % 10;               /* Ones */

        $res = "";

        if ($Gn)
        {
            $res .= $this->convert_number($Gn) . " Lakh";
        }

        if ($kn)
        {
            $res .= (empty($res) ? "" : " ") .
            $this->convert_number($kn) . " Thousand";
        }

        if ($Hn)
        {
            $res .= (empty($res) ? "" : " ") .
            $this->convert_number($Hn) . " Hundred";
        }

        $ones = array("", "One", "Two", "Three", "Four", "Five", "Six",
            "Seven", "Eight", "Nine", "Ten", "Eleven", "Twelve", "Thirteen",
            "Fourteen", "Fifteen", "Sixteen", "Seventeen", "Eighteen",
            "Nineteen");
        $tens = array("", "", "Twenty", "Thirty", "Fourty", "Fifty", "Sixty",
            "Seventy", "Eigthy", "Ninety");

        if ($Dn || $n)
        {
            if (!empty($res))
            {
                $res .= " and ";
            }

            if ($Dn < 2)
            {
                $res .= $ones[$Dn * 10 + $n];
            }
            else
            {
                $res .= $tens[$Dn];

                if ($n)
                {
                    $res .= " " . $ones[$n];
                }
            }
        }

        if (empty($res))
        {
            $res = "zero";
        }

        return $res;
    }

    function getCardno($prefix,$len = 8){
        $status = true;
        $code = '';
        while($status){
            $code = getOtp($len);
            $code = $prefix.$code;
            $conditon = "card_no = '".$code."' ";
            $checkCode = $this->master_db->getRecords('customer_package',$conditon,'id');
            if(count($checkCode) ){
                $status = true;
            }else{
                $status = false;
            }
            if( $status == false ){break;}
        }
        //echo $code;exit;
        return $code;
    }
    
    
}

?>