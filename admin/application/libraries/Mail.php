<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Mail {
    function send_sparkpost_attach($body, $toemail, $subject, $pdfFilePath='', $pdf_name=''){
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
           //print $e;
        }        
        $mail->close();
        //return $res;
    }

}