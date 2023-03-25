<?php
    $dtype = "";
    if($type == 1) {
        $dtype .="Country Partner";
    }
    else if($type ==3) {
        $dtype .="State C&F";
    }
    else if($type ==4) {
        $dtype .="Distributor";
    }
    else if($type ==5) {
        $dtype .="Dealer";
    }
    else if($type ==6) {
        $dtype .="Retailer";
    }
   
?>
<!DOCTYPE html PUBLIC '-//W3C//DTD XHTML 1.0 Transitional//EN' 'http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd'>
<html xmlns='http://www.w3.org/1999/xhtml'>
    <head>
        <meta http-equiv='Content-Type' content='text/html; charset=UTF-8' />
    </head>
    <body>
        <table border='0' cellpadding='0' cellspacing='0' width='100%' style='font-family:Arial,Helvetica,sans-serif;color:#595959;border:20px solid #efefef;background: #efefef;'>
            <tbody>
                <tr>
                    <td>
                        <table border='0' cellpadding='0' cellspacing='0' width='100%' style='font-family:Arial,Helvetica,sans-serif;color:#595959;border:20px solid #efefef;padding:20px;background: white;width: 950px;margin: 0 auto;'>
                            <tr>
                                <td colspan='2' style='text-align: center;'>
                                    <a href='<https://www.lifeonplus.com/'><img style='width: 160px;' src='https://www.lifeonplus.com/assets/img/logo/logo.png'/></a>
                                </td>
                            </tr>
                            <tr>
                                <td colspan='2' style='border-bottom: 1px solid #dadada;padding:20px 3% 20px 3%;'>
                                   <p>We welcome to the world’s most Advanced Medical & Digital Health Technology Welcome to Paxykop Technologies, Thanks for choosing LIFEON+ products. Your Channel Partner <?= $dtype;?>. Any query please contact us on info@lifeonplus.com Regards, Team LIFEON+<br/><br /></p>
                                   <br />
                                   Download Lifeonplus Android App:  <a href='https://play.google.com/store/apps/details?id=com.paxykop.lifeonplus'>https://play.google.com/store/apps/details?id=com.paxykop.lifeonplus</a>
                                   <p>
Click here to login <a href='https://www.lifeonplus.com'>www.lifeonplus.com</a>
</p>
<p>Any clarification on technical issue contact us on email – info@lifeonplus.com</p>
<p>We once again thank you for becoming a Channel Partner </p>
                                    <br></br><br></br>Regards,<br></br>Lifeon Plus
                                </td>
                            </tr>
                            <tr style='text-align: center;'>
                                <td style='color: #939393;font-weight: 600;text-decoration: none;'>Reach out to us at Email - info@lifeonplus.com | PH - +91-9986-88-0000</td>
                            </tr>
                        </table>
                    </td>
                </tr>
            </tbody>
        </table>
   
    </body>
</html>