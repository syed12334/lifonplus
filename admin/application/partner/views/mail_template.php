<!DOCTYPE html PUBLIC '-//W3C//DTD XHTML 1.0 Transitional//EN' 'http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd'>
<html xmlns='http://www.w3.org/1999/xhtml'>
    <head>
        <meta http-equiv='Content-Type' content='text/html; charset=UTF-8' />
    </head>
    <body>
    <?php 
    if(count($company)>0){
    ?>
        <table border="0" cellpadding="0" cellspacing="0" width="100%" style='font-family:Arial,Helvetica,sans-serif;color:#595959;border:20px solid #efefef;background: #efefef;'>
            <tbody>
                <tr>
                    <td>
                        <table border='0' cellpadding='0' cellspacing='0' width='100%' style='font-family:Arial,Helvetica,sans-serif;color:#595959;border:20px solid #efefef;padding:20px;background: white;width: 950px;margin: 0 auto;'>
                            <tr>
                                <td colspan='2' style="text-align: center;">
                                    <a href='<?php if($company[0]->website_url!=''){ echo $company[0]->website_url; } else echo "#"; ?>'><img style="width: 100px;" src='<?php echo admin_url().$company[0]->logo_link; ?>'/></a>
                                </td>
                            </tr>
                            <tr>
                                <td colspan='2' style="border-bottom: 1px solid #dadada;padding:20px 3% 20px 3%;">
                                    <h1 style='font-size:30px;margin-bottom:30px'>Hello ………………..</h1><h2 style='font-size:25px;font-weight:bold;margin-bottom:20px'>Greeting From lifeonplus !</h2><p style='font-size:18px;'>We received a request to reset the password for the ooxiee coin account associated with this e-mail address. If you made this request, please follow the instructions below.</p>
                                    <?php echo $messagebody ?>
                                    <p>If you did not request to have your password reset you can safely ignore this email.</p>
                                    <br></br>
                                    <h1 style='font-size:18px;margin-top:30px;margin-bottom:40px'>Sincerely,<br />Team lifeonplus.<br /><a href='https://www.lifeonplus.com/' target='_blank'>http://lifeonplus.com</a></h1>
                                    <p style='font-size:20px;text-align:center;margin-top:40px'>Copyright © lifeonplus 2021</p>
                                </td>
                            </tr>
                            <tr style="text-align: center;">
                                <td style="color: #939393;font-weight: 600;text-decoration: none;">Reach out to us at Email - <?php echo $company[0]->email; ?> | PH - +91-9986-88-0000</td>
                            </tr>
                        </table>
                    </td>
                </tr>
            </tbody>
        </table>
    <?php 
    }
    ?>
    </body>
</html>


