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
                                    <a href='<?php if($company[0]->website_url!=''){ echo $company[0]->website_url; } else echo "#"; ?>'><img style="width: 100px;" src='https://www.lifeonplus.com/assets/img/logo/logo.png'/></a>
                                </td>
                            </tr>
                            <tr>
                                <td colspan='2' style="border-bottom: 1px solid #dadada;padding:20px 3% 20px 3%;">
                                    <?php echo $messagebody ?>
                                    <br></br><br></br>Regards,<br></br> <?php echo $company[0]->name; ?>
                                </td>
                            </tr>
                            <tr style="text-align: center;">
                                <td style="color: #939393;font-weight: 600;text-decoration: none;">Reach out to us at Email - info@lifeonplus.com | PH - +91-9986-88-0000</td>
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


