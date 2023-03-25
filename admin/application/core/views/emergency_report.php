<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>Emergency Report</title>
    </head>
    <body> 
        <style>
            @import url('https://fonts.googleapis.com/css?family=Noto+Serif:400,700');
        </style>

        <table style="width:100%; font-family: 'Noto Serif', serif; font-size:12px;" cellpadding="0" cellspacing="0">
            <thead>
                <tr>    
                    <td colspan="27" style="text-align:center; padding:1px; text-align:center;">
                        <div style="display:inline-block; vertical-align:top;">
                            <img src="<?=asset_url().EREPORT_LOGO?>" style="width:220px; display: inline-block;"/>
                            <h3 style="font-size:24px; color:#f04feb;">Emergency Report </h3>
                        </div>
                    </td>
                </tr>                
            </thead>
            <tbody>
                <tr>    
                    <td width="33%" align="left">
                        <div style="display:inline-block; vertical-align:top;">
                            <h4 style="font-size:14px; margin:2px 0 0 0;">Card No: <?=$cdata[0]->card_no?> </h3>
                            <h4 style="font-size:14px; margin:2px 0 0 0;">Name: <?=$cdata[0]->name?></h4>
                            <h4 style="font-size:14px; margin:2px 0 0 0;">Phone: <?=$cdata[0]->mobileno?></h4>      
                            <h4 style="font-size:14px; margin:2px 0 0 0;">Email Id: <?=$cdata[0]->email_id?></h4>
                            <h4 style="font-size:14px; margin:2px 0 0 0;">DOB: <?=$cdata[0]->dob?></h4>
                            <h4 style="font-size:14px; margin:2px 0 0 0;">Blood Group: <?=$cdata[0]->blood_group?></h4>
                        </div>
                    </td>
                    <td width="10%" align="center"></td>
                    <td width="53%" align="right">
                        <img src="<?=app_asset_url().$cdata[0]->photo?>" style="width:85px; display: inline-block;"/>
                    </td>
                </tr>
            </tbody>            
        </table>
        <br><br><br>
              
        <table style="width:100%; font-family: 'Noto Serif', serif; font-size:12px; margin:5px 0 0 0;" cellpadding="0" cellspacing="0">
            <tr>
                <td colspan="2" style="padding:5px; text-align:left; width:80px; color:#42ab38;"><strong>Emergency Contact Number </strong> </td>
                <td style="padding:5px; text-align:left;">  </td>
                <td colspan="10" style="padding:5px; text-align:left; width:80px; text-transform:uppercase;"> </td>
            </tr>    
        </table>
          
        <table style="width:100%; margin:2px 0; font-size: 13px;border: 1px solid;" width="0" border="0" cellpadding="0" cellspacing="0">   
            <tr>              
                <td width="10%" valign="top" style="padding:5px;" align="left"> <strong> Name </strong> </td>
                <td width="10%" valign="top" style="padding:5px;" align="left"> <strong> Phone </strong> </td>
                <td width="10%" valign="top" style="padding:5px;" align="left"> <strong> Relationship </strong> </td> 
            </tr>             
            <?php
            foreach($elist as $row){
                ?>
                <tr style="border:1px solid #ccc;">
                    <td valign="top" style="padding:5px;" align="left"><?=$row->name?></td>
                    <td valign="top" style="padding:5px;" align="left"><?=$row->phone?></td>               
                    <td valign="top" style="padding:5px;" align="left"><?=$row->relation?></td> 
                </tr>
                <?php
            }
            ?>
        </table>    
              
        <table style="width:100%; font-family: 'Noto Serif', serif; font-size:12px; margin:5px 0 0 0;" cellpadding="0" cellspacing="0">
            <tr>
                <td colspan="2" style="padding:5px; text-align:left; width:80px; color:#42ab38;"><strong>Hospital Preference </strong> </td>
                <td style="padding:5px; text-align:left;">  </td>
                <td colspan="10" style="padding:5px; text-align:left; width:80px; text-transform:uppercase;"> </td>            
            </tr>
        </table>    
                
        <table style="width:100%; margin:8px 0; font-size: 13px;" width="0" border="0" cellpadding="0" cellspacing="0"> 
            <tr>  
                <td valign="top" style="padding:5px;" align="left"> Hospital Preference: <?php if(count($hospital)){ echo $hospital[0]->hospital; } ?></td>
                <td valign="top" style="padding:5px;" align="left"> </td>
 				<td valign="top" style="padding:5px;" align="left"> </td>
            </tr>  
            <tr>
                <td valign="top" style="padding:5px;" align="left"> Last admitted on: <?php if(count($hospital)){ echo $hospital[0]->admit_date; } ?></td>
                <td valign="top" style="padding:5px;" align="left"> </td>
 				<td valign="top" style="padding:5px;" align="left"> </td> 
            </tr>
            <tr>              
                <td valign="top" style="padding:5px;" align="left"> Medical Note: <?php if(count($hospital)){ echo $hospital[0]->medical_note; } ?></td>
                <td valign="top" style="padding:5px;" align="left"> </td>
 				<td valign="top" style="padding:5px;" align="left"> </td> 
            </tr>    
        </table>              
              
        <table style="width:100%; font-family: 'Noto Serif', serif; font-size:12px; margin:5px 0 0 0;" cellpadding="0" cellspacing="0">
            <tr>
                <td colspan="2" style="padding:5px; text-align:left; width:80px; color:#42ab38;"><strong>Vitals </strong> </td>            
                <td style="padding:5px; text-align:left;">  </td>            
                <td colspan="10" style="padding:5px; text-align:left; width:80px; text-transform:uppercase;"> </td>            
            </tr>    
        </table>          
           
        <table style="width:100%; margin:2px 0; font-size: 13px;border: 1px solid;" width="0" border="0" cellpadding="0" cellspacing="0">   
            <tr>
                <td width="10%" valign="top" style="padding:5px;" align="left"> <strong> Name </strong> </td>
                <td width="10%" valign="top" style="padding:5px;" align="left"> <strong> Value </strong> </td>
                <td width="10%" valign="top" style="padding:5px;" align="left"> <strong> Date </strong> </td>             
            </tr>  
            <?php
            foreach($vital as $row){
                ?>
                <tr>
                    <td valign="top" style="padding:5px;" align="left">BP</td>
                    <td valign="top" style="padding:5px;" align="left"><?=$row->bp?></td>               
                    <td valign="top" style="padding:5px;" align="left"><?=$row->report_date?></td> 
                </tr>
                <tr>
                    <td valign="top" style="padding:5px;" align="left">Spo2</td>
                    <td valign="top" style="padding:5px;" align="left"><?=$row->spo2?></td>               
                    <td valign="top" style="padding:5px;" align="left"><?=$row->report_date?></td> 
                </tr>
                <tr>
                    <td valign="top" style="padding:5px;" align="left">HR</td>
                    <td valign="top" style="padding:5px;" align="left"><?=$row->heart_rate?></td>               
                    <td valign="top" style="padding:5px;" align="left"><?=$row->report_date?></td> 
                </tr>
                <?php
            }
            ?>
        </table>    
        
        <!-- SPO2 report start -->
        <?php
        if( count($spo2_report) > 1 ){
        ?>
        <table style="width:100%; font-family: 'Noto Serif', serif; font-size:12px; margin:5px 0 0 0;page-break-after: always;" cellpadding="0" cellspacing="0">
            <tr>
                <td colspan="2" style="padding:5px; text-align:left; width:80px; color:#42ab38;"><strong>Spo2 </strong> </td>                
                <td style="padding:5px; text-align:left;">  </td>                
                <td colspan="10" style="padding:5px; text-align:left; width:80px; text-transform:uppercase;"> </td>            
            </tr>
            <tr>
                <td colspan="13">
                    <img src="<?=base_url()?>v1/app/graph?user_id=<?=$customer[0]->id?>&type=1" style="width:100%;"/>
                </td>
            </tr>
        </table>
        <!-- SPO2 report end -->
        <?php
        }
        ?>

        <?php
        if( count($hr_report) > 1 ){
        ?>
        <!-- Heart Rate report start -->
        <table style="width:100%; font-family: 'Noto Serif', serif; font-size:12px; margin:5px 0 0 0;" cellpadding="0" cellspacing="0">
            <tr>
                <td colspan="2" style="padding:5px; text-align:left; width:80px; color:#42ab38;"><strong>Pulse </strong> </td>                
                <td style="padding:5px; text-align:left;">  </td>                
                <td colspan="10" style="padding:5px; text-align:left; width:80px; text-transform:uppercase;"> </td>            
            </tr>
            <tr>
                <td colspan="13">
                    <img src="<?=base_url()?>v1/app/graph?user_id=<?=$customer[0]->id?>&type=2" style="width:100%;"/>
                </td>
            </tr>
        </table>
        <!-- Heart Rate report end -->
        <?php
        }
        ?>

        <table style="width:100%; font-family: 'Noto Serif', serif; font-size:12px; margin:2px 0 0 0;" cellpadding="0" cellspacing="0">
            <tr>
                <td colspan="2" style="padding:5px; text-align:left; width:80px; color:#42ab38;"><strong>Medical Visits </strong> </td>            
                <td style="padding:5px; text-align:left;">  </td>            
                <td colspan="10" style="padding:5px; text-align:left; width:80px; text-transform:uppercase;"> </td>            
            </tr>
        </table>  
                   
        <table style="width:100%; margin:8px 0; font-size: 13px;border: 1px solid;" width="0" border="0" cellpadding="0" cellspacing="0"> 
            <tr>
                <td width="10%" valign="top" style="padding:5px;" align="left"> <strong> Type </strong> </td>
                <td width="10%" valign="top" style="padding:5px;" align="left"> <strong> Doctor </strong> </td>
                <td width="10%" valign="top" style="padding:5px;" align="left"> <strong> Reason </strong> </td> 
                <td width="10%" valign="top" style="padding:5px;" align="left"> <strong> Date </strong> </td> 
            </tr>
            <?php
            foreach($visit as $row){
                ?>
                <tr>
                    <td valign="top" style="padding:5px;" align="left"><?=$row->type?></td>
                    <td valign="top" style="padding:5px;" align="left"><?=$row->doctor?></td>               
                    <td valign="top" style="padding:5px;" align="left"><?=$row->reason?></td> 
                    <td valign="top" style="padding:5px;" align="left"><?=$row->visit_date?></td> 
                </tr>
                <?php
            }
            ?>
        </table>
          
        <table style="width:100%; font-family: 'Noto Serif', serif; font-size:12px; margin:2px 0 0 0;" cellpadding="0" cellspacing="0">
            <tr>
                <td colspan="2" style="padding:5px; text-align:left; width:80px; color:#42ab38;"><strong>Vaccine </strong> </td>            
                <td style="padding:5px; text-align:left;">  </td>            
                <td colspan="10" style="padding:5px; text-align:left; width:80px; text-transform:uppercase;"> </td>            
            </tr>
        </table>          
           
        <table style="width:100%; margin:8px 0; font-size: 13px;border: 1px solid;" width="0" border="0" cellpadding="0" cellspacing="0"> 
            <tr>
                <td width="10%" valign="top" style="padding:5px;" align="left"> <strong> Vaccine </strong> </td>
                <td width="10%" valign="top" style="padding:5px;" align="left"> <strong> Dose </strong> </td>
                <td width="10%" valign="top" style="padding:5px;" align="left"> <strong> Date </strong> </td> 
            </tr>
            <?php
            foreach($vaccine as $row){
                ?>
                <tr>
                    <td valign="top" style="padding:5px;" align="left"><?=$row->vaccine_name?></td>
                    <td valign="top" style="padding:5px;" align="left"><?=$row->dose?></td>               
                    <td valign="top" style="padding:5px;" align="left"><?=$row->date?></td> 
                </tr>
                <?php
            }
            ?>
        </table>
              
        <table style="width:100%; font-family: 'Noto Serif', serif; font-size:12px; margin:5px 0 0 0;" cellpadding="0" cellspacing="0">
            <tr>
                <td colspan="2" style="padding:5px; text-align:left; width:80px; color:#42ab38;"><strong>Allergy </strong> </td>
                <td style="padding:5px; text-align:left;">  </td>
                <td colspan="10" style="padding:5px; text-align:left; width:80px; text-transform:uppercase;"> </td>
            </tr>
        </table>
                
        <table style="width:100%; margin:8px 0; font-size: 13px;border: 1px solid;" width="0" border="0" cellpadding="0" cellspacing="0"> 
            <?php
            foreach($allergy as $row){
                ?>
                <tr>
                    <td valign="top" style="padding:5px;" align="left"><?=$row->allergy_name?></td>
                    <td valign="top" style="padding:5px;" align="left"></td>               
                    <td valign="top" style="padding:5px;" align="left"></td> 
                </tr>
                <?php
            }
            ?>
        </table>              
              
        <table style="width:100%; font-family: 'Noto Serif', serif; font-size:12px; margin:5px 0 0 0;" cellpadding="0" cellspacing="0">
            <tr>
                <td colspan="2" style="padding:5px; text-align:left; width:80px; color:#42ab38;"><strong>Diagnosis</strong> </td>      
                <td style="padding:5px; text-align:left;">  </td>      
                <td colspan="10" style="padding:5px; text-align:left; width:80px; text-transform:uppercase;"> </td>      
            </tr>
        </table>
              
        <table style="width:100%; margin:8px 0; font-size: 13px;border: 1px solid;" width="0" border="0" cellpadding="0" cellspacing="0"> 
            <?php
            foreach($diagnosis as $row){
                ?>
                <tr>
                    <td valign="top" style="padding:5px;" align="left"><?=$row->medical_diagnosis?></td>
                    <td valign="top" style="padding:5px;" align="left"></td>               
                    <td valign="top" style="padding:5px;" align="left"></td> 
                </tr>
                <?php
            }
            ?>
        </table>                         
              
        <table style="width:100%; font-family: 'Noto Serif', serif; font-size:12px; margin:5px 0 0 0;" cellpadding="0" cellspacing="0">
            <tr>
                <td colspan="2" style="padding:5px; text-align:left; width:80px;color:#42ab38;"><strong>Medicine </strong> </td>            
                <td style="padding:5px; text-align:left;">  </td>            
                <td colspan="10" style="padding:5px; text-align:left; width:80px; text-transform:uppercase;"> </td>            
            </tr>
        </table>
          
        <table style="width:100%; margin:8px 0; font-size: 13px;border: 1px solid;" width="0" border="0" cellpadding="0" cellspacing="0"> 
            <tr>              
                <td width="10%" valign="top" style="padding:5px;" align="left"> <strong> Name </strong> </td>
                <td width="10%" valign="top" style="padding:5px;" align="left"> <strong> Strength </strong> </td>
                <td width="10%" valign="top" style="padding:5px;" align="left"> <strong> How often taken </strong> </td> 
            </tr>  
            <?php
            foreach($medicine as $row){
                ?>
                <tr>
                    <td valign="top" style="padding:5px;" align="left"><?=$row->medicine_name?></td>
                    <td valign="top" style="padding:5px;" align="left"><?=$row->medicine_strength?></td>               
                    <td valign="top" style="padding:5px;" align="left"><?=$row->how_often?></td> 
                </tr>
                <?php
            }
            ?>    
        </table>

        <table style="width:100%; font-family: 'Noto Serif', serif; font-size:12px; margin:5px 0 0 0;" cellpadding="0" cellspacing="0">
            <tr>
                <td colspan="2" style="padding:5px; text-align:left; width:80px;color:#42ab38;"><strong>Surgeries </strong> </td>            
                <td style="padding:5px; text-align:left;">  </td>            
                <td colspan="10" style="padding:5px; text-align:left; width:80px; text-transform:uppercase;"> </td>            
            </tr>
        </table>
          
        <table style="width:100%; margin:8px 0; font-size: 13px;border: 1px solid;" width="0" border="0" cellpadding="0" cellspacing="0"> 
            <?php
            foreach($surgery as $row){
                ?>
                <tr>
                    <td valign="top" style="padding:5px;" align="left"><?=$row->procedure_name?></td>
                </tr>
                <?php
            }
            ?>    
        </table>  

        <table style="width:100%; font-family: 'Noto Serif', serif; font-size:12px; margin:2px 0 0 0;" cellpadding="0" cellspacing="0">
            <tr>
                <td colspan="2" style="padding:5px; text-align:left; width:80px; color:#42ab38;"><strong>Insurance </strong> </td>            
                <td style="padding:5px; text-align:left;">  </td>            
                <td colspan="10" style="padding:5px; text-align:left; width:80px; text-transform:uppercase;"> </td>            
            </tr>
        </table>          
           
        <table style="width:100%; margin:8px 0; font-size: 13px;border: 1px solid;" width="0" border="0" cellpadding="0" cellspacing="0"> 
            <tr>
                <td width="10%" valign="top" style="padding:5px;" align="left"> <strong> Name </strong> </td>
                <td width="10%" valign="top" style="padding:5px;" align="left"> <strong> Policy No </strong> </td>
                <td width="10%" valign="top" style="padding:5px;" align="left"> <strong> Expiry Date </strong> </td> 
            </tr>
            <?php
            foreach($insurance as $row){
                ?>
                <tr>
                    <td valign="top" style="padding:5px;" align="left"><?=$row->insurance_name?></td>
                    <td valign="top" style="padding:5px;" align="left"><?=$row->policy_number?></td>               
                    <td valign="top" style="padding:5px;" align="left"><?=$row->expiry_date?></td>
                </tr>
                <?php
            }
            ?>
        </table>
    </body>
</html>
