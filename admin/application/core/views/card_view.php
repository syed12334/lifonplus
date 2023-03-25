<!DOCTYPE html>
<html>

<head>

    <title>Paxykop</title>
    <style>
       
    </style>

</head>

<body style="margin:0 0 0 0px!important; padding:0px!important; width:100%;">





    <table  style="width: 100%; margin:0; font-family:Arial, Helvetica, sans-serif; background-image: url(<?=card_asset_url().'img/background.jpg';?>);background-size:cover; border-radius: 30px;position:relative; background-repeat: no-repeat; background-position: top left; "  border="0" cellpadding="0" cellspacing="0" >

        
        <tr>
            <td style="height:1000px;" valign="top">
                  

                    <table border="0" cellpadding="0" cellspacing="0" width="100%" style="margin-top:35px; ">
                        <tr>
                            <td>

                                <table style="width:100%; margin-right:5px; margin-top: 50px; position: relative;" border="0" cellpadding="0"
                                    cellspacing="0">
                                    
                                    <tr>
                                        <td
                                            style="padding-left:39px;  color: #fff;">
                                            <span style="line-height: 34px;font-weight: 600;padding-left: 55px;font-size: 16px; display: inline-block;">Global Digital Health Smart Card</span>&nbsp;&nbsp; <span style="font-size: 22px;line-height: 28px;font-weight: 600;text-transform: uppercase;display: inline-block; margin-left:15px;"><?=$customer->package?></span></td>
                                    </tr>
                                    <tr>
                                        <td
                                            style="width: 100%;
                                            float: left;
                                            position: relative;
                                            padding-left: 59px;
                                            background-size: 14px; padding-top:20px">

                                            <h2  style="display: inline-block;  color: #000; font-size: 2rem; font-weight: 600; line-height: 2rem;  padding:35px 15px 8px 15px;">
                                                 <?php
                                                    $cardno = str_split($customer->card_no,4);
                                                    echo implode(' ',$cardno);
                                                    //echo $customer->card_no;
                                                    ?>  </h2>  
                                            
                                            <table
                                                style="width: 100%;   color: #fff; font-size: 18px; line-height: 20px;   margin-top:20px; position:relative;z-index: 9">
                                                 <tr>
                                                    <td>
                                                <label style="width: 90px; display: inline-block;">Name </label> <span
                                                    style="width: 20px; text-align: center; display: inline-block;">:</span>
                                                <span
                                                    style="text-transform: uppercase; font-size: 17px; font-weight: 700;"><?=$customer->name?></span><br />
                                                <label style="width: 90px; display: inline-block;">Blood Group </label>
                                                <span
                                                    style="width: 20px; text-align: center; display: inline-block;">:</span>
                                                <?=$customer->blood_group?><br />
                                                <label style="width: 90px; display: inline-block;">Mobile No </label>
                                                <span
                                                    style="width: 20px; text-align: center; display: inline-block;">:</span>
                                               <?=$customer->mobileno?><br />

                                           </td>
                                       </tr>
                                            </table>
                                            <table
                                                style="width: 100%; float: left;margin-top: 10px; font-size: 0.8rem; line-height: 1.2rem; color: #fff;">
                                                <tr>
                                                <td style="padding-right:75px; width: 150px; ">
                                                    Valid From<br />
                                                    <b
                                                        style="font-size: 1rem;"><?=date('d/m/Y',strtotime($customer->valid_from))?></b>
                                                </td>
                                                <td>
                                                    Expires<br />
                                                    <b
                                                        style="font-size: 1rem;"> <?=date('d/m/Y',strtotime($customer->valid_to))?></b>
                                                </td>
                                            </tr>
                                            </table>
                                             

                                        </td>
                                    </tr>
                                </table>
                            </td>

                            <td valign='top'>
                                <table
                                    style="width: 150px; margin-top:35px; margin-right: 65px; "
                                    border="0" cellpadding="0" cellspacing="0">
                                     
                                    <tr>
                                        <td style="height:164px;">
                                            <img style="width: 131px; height:164px; margin-top: 5px; margin-bottom: 10px; border-radius: 10px; position:relative;object-fit: cover"
                                                src="<?=$customer->photo?>"></td>
                                    </tr>
                                    <tr>
                                        <td  style="height:131px;"><img style="width: 131px;padding: 2px; background: #fff; box-sizing: border-box;"
                                                src="<?=$customer->qrcode?>"></td>
                                    </tr>
                                </table>

                            </td>
                        </tr>
                    </table>

            </td>
        </tr>
    </table>
</body>

</html>