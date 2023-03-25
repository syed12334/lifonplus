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
                                    <a href='<?php if($company[0]->website_url!=''){ echo $company[0]->website_url; } else echo "#"; ?>'><img style="width: 100px;" src='<?php echo base_url().$company[0]->logo_link; ?>'/></a>
                                </td>
                            </tr>
                            <tr>
                                <td colspan='2' style="border-bottom: 1px solid #dadada;padding:20px 3% 20px 3%;">
                                    <h4><b>Dear Client,</b></h4>
                                    <p>We welcome to the world’s most Advanced Medical & Digital Health Technology</p>
                                    <?php
                                        if($type ==1) {
                                            ?>
                                             <!-- <p>Thanks for choosing Country Partner  <?php echo $country;?>  for LIFEONPLUS products.</p> -->
                                             <p>Thanks for choosing LIFEON+ products & services. You as a Channel Partner for COUNTRY PARTNER .</p>
                                            <?php
                                        }else if($type ==3) {
                                             ?>
                                             <p>Thanks for choosing LIFEON+ products & services. You as a Channel Partner for STATE C&F  .</p>
                                            <?php
                                        }
                                        else if($type ==4) {
                                             ?>
                                              <p>Thanks for choosing LIFEON+ products & services. You as a Channel Partner for DISTRIBUTOR  .</p>
                                            <?php
                                        }
                                        else if($type ==5) {
                                             ?>
                                              <p>Thanks for choosing LIFEON+ products & services. You as a Channel Partner for DEALER .</p>
                                            <?php
                                        }
                                        else if($type ==6) {
                                             ?>
                                             <p>Thanks for choosing LIFEON+ products & services. You as a Channel Partner for RETAILER .</p>
                                            <?php
                                        }
                                    ?>
                                    <?php echo $messagebody ?>
                                    
                                </td>
                            </tr>
                          <!--  <tr>
                               <h5> Download Lifeonplus Android App:  <a href="https://play.google.com/store/apps/details?id=com.paxykop.lifeonplus" target="_blank">https://play.google.com/store/apps/details?id=com.paxykop.lifeonplus</a></h5>
                            </tr> -->
                            <tr>
                               <h5> Click here to login <a href="https://www.lifeonplus.com/partner/">www.lifeonplus.com</a></h5>
                            </tr>
                            <!--<tr>
                                We once again thank you for becoming a Channel Partner 
                            </tr> -->
                            <tr style="text-align: center;">
                                <td style="color: #939393;font-weight: 600;text-decoration: none;">Any clarification on technical issue contact us on email  - info@lifeonplus.com</td>
                            </tr>
                            <tr>
                                <td>We once again thank you for becoming a Channel Partner</td>
                            </tr>
                            <td><br></br><br></br>Regards,<br></br> <?php echo $company[0]->name; ?></td>
                            <tr>
                                
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


