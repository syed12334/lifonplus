<?php
	$url = base_url().'v1/emergency_pdf?user_id='.$cdata[0]->user_id;
	//echo $url; exit;
	$file = file_get_contents($url);
	$decode = json_decode($file,true);
	//echo "<pre>";print_r($decode['file']);exit;
?>

<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/css/bootstrap.min.css" />

    <title>Lifeonplus</title>

    <style>
        h1 {
            background: #48b74d;
            padding: 15px;
            font-size: 23px;
            color: #fff;
            text-align: center;
            text-transform: uppercase;
            width: 100%;
        }

        h6 {
            text-align: right;
        }

        .header img {
            width: 120px;
        }

        .header h2 {
            display: inline-block;
            margin-left: 15px;
            font-size: 25px;
            color: #48b74d;
            font-weight: 700;
        }

        .header {
            margin-bottom: 35px;
        }

        .profile ul {
            padding: 0;
            list-style: none;
        }

        .profile ul li {
            margin-bottom: 5px;
            font-size: 15px;
        }

        .img {
            border: 1px solid #ccc;
            width: 150px;
            height: 150px;
            overflow: hidden;
            border-radius: 150px;
            float: right;
        }

        .download {
            text-align: right;
            border-top: 1px solid #ccc;
            border-bottom: 1px solid #ccc;
            padding: 19px 0;
            margin: 25px 0;
        }

        .details-row h3 {
            font-size: 17px;
            color: #48b74d;
            font-weight: 600;
        }

        label{
            width:100%;
        }

        .card{
            margin-bottom:25px;
        }
        body{
            background-color: #fff9e2; 
        }
        .container{
            background-color: #fff;
        }

        .card-body{
            padding:10px;
        }

        .btn-info{
            background-color:#fff;
            border:1px #f54d6a dashed;
            color: #f54d6a;
            margin-right:15px;
        }

        .table td, .table th {
            padding: 7px;
        }

        .spot{
            width:35%;
        }

        @media(max-width:768px){
            .header img {
                width: 87px;
            }

            body{ 
                font-size: 11px;
            }

            .header h2 {
                font-size: 20px;
            }

            .img {
                border: 1px solid #ccc;
                width: 100px;
                height: 100px;
            }

            .profile ul li {
                font-size: 12px;
            }

            .details-row h3 {
                font-size: 14px;
            }
        }
        
    </style>
</head>

<body style="margin-right:30px">
    <div class="container ">
        <div class="row"><h1>Report</h1></div>
        <h6><?php echo date("d.m.Y",strtotime($cdata[0]->created_at)); ?></h6>
        <div class="header">
            <img src="https://www.lifeonplus.com/admin/assets/images/logo1.png" alt="">
            <h2>Emergency Report</h2>
        </div>

        <div class="profile row">
            <div class="col-9">
                <ul>
                    <li>Card No : <?=$cdata[0]->card_no?> </li>
                    <li>Name : <?=$cdata[0]->name?></li>
                    <li>Phone : <?=$cdata[0]->mobileno?></li>
                    <li>Email Id : <?=$cdata[0]->email_id?></li>
                    <li>DOB : <?=$cdata[0]->dob?></li>
                    <li>Blood Group :<?=$cdata[0]->blood_group?></li>
                </ul>
            </div>

            <div class="col-3">
                <div class="img"><img src="http://lifeonplus.com/app_assets/<?php echo $cdata[0]->photo?>"
                        alt="" class="img-fluid"></div>
            </div>
        </div>

        <div class="download">
            <a href="<?php echo $decode['file']; ?>" class="btn btn-info" download="download">Download PDF</a> Page No: 1/2
        </div>

        <div class="details-row">
            <h3>Emergency Contact Number</h3>
            <div class="card">
                <div class="card-body">
                <div class="row">
                    <div class="col-4">
                        <label for=""><b>Name</b></label>
                        <label><?=$cdata[0]->name?></label>
                    </div>
                    <div class="col-4">
                        <label for=""><b>Phone</b></label>
                        <label><?=$cdata[0]->mobileno?></label>
                    </div>
                    <div class="col-4">
                       
                    </div>

                    <div class="col-xs-12 col-sm-7 col-md-7 col-lg-7">
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
                    </div>
                    <div class="col-xs-12 col-sm-5 col-md-5 col-lg-5"></div>
                    <div class="clearfix"></div>
                </div>
            </div>
            </div>
        </div>


        <div class="details-row">
            <h3>Hospital Preference</h3>
            <div class="card">
                <div class="card-body">
                <table class="table table-borderless">
                    <tr>
                        <td class="spot">Hospital Preference</td>
                        <td>:</td>
                        <td><?php if(count($hospital)){ echo $hospital[0]->hospital; } ?></td>
                    </tr>
                    <tr>
                        <td>Last admitted on</td>
                        <td>:</td>
                        <td><?php if(count($hospital)){ echo $hospital[0]->admit_date; } ?></td>
                    </tr>
                    <tr>
                        <td>Medical Note</td>
                        <td>:</td>
                        <td><?php if(count($hospital)){ echo $hospital[0]->medical_note; } ?></td>
                    </tr>
                </table>
            </div>
        </div>
        </div>


        <div class="details-row">
            <h3>Vitals</h3>
            <div class="card">
                <div class="card-body">
                <table class="table table-borderless">
                  
                    <tr>
                        <td>Height</td>
                        <td>:</td>
                        <td><?php if(!array_key_exists(0,$vital)) {}else {echo $vital[0]->height; }?></td>
                    </tr>
                    <tr>
                        <td>Weight</td>
                        <td>:</td>
                        <td><?php if(!array_key_exists(0,$vital)) {}else {echo $vital[0]->weight; }?></td>
                    </tr>
                    <tr>
                        <td>BMI</td>
                        <td>:</td>
                        <td><?php if(!array_key_exists(0,$vital)) {}else {echo $vital[0]->bmi; }?></td>
                    </tr>
                    <tr>
                        <td>BP (sys/dia)</td>
                        <td>:</td>
                        <td><?php if(!array_key_exists(0,$vital)) {}else {echo $vital[0]->bp; }?></td>
                    </tr>
                    <tr>
                        <td>Spo2</td>
                        <td>:</td>
                        <td><?php if(!array_key_exists(0,$vital)) {}else {echo $vital[0]->spo2; }?></td>
                    </tr>
                    <tr>
                        <td>HR</td>
                        <td>:</td>
                        <td><?php if(!array_key_exists(0,$vital)) {}else {echo $vital[0]->heart_rate; }?></td>
                    </tr>
                    <tr>
                        <td>Sugar</td>
                        <td>:</td>
                        <td><?php if(!array_key_exists(0,$vital)) {}else {echo $vital[0]->bmi; }?></td>
                    </tr>
                    <tr>
                        <td>Hemoglobin</td>
                        <td>:</td>
                        <td><?php if(!array_key_exists(0,$vital)) {}else {echo $vital[0]->hemoglobin; }?></td>
                    </tr>
                    <tr>
                        <td>Cholesterol</td>
                        <td>:</td>
                        <td><?php if(!array_key_exists(0,$vital)) {}else {echo $vital[0]->cholesterol; }?></td>
                    </tr>
                    <tr>
                        <td>ECG</td>
                        <td>:</td>
                        <td><?php if(!array_key_exists(0,$vital)) {}else {echo $vital[0]->ecg; }?></td>
                    </tr>
                    <tr>
                        <td>TDS</td>
                        <td>:</td>
                        <td><?php if(!array_key_exists(0,$vital)) {}else {echo $vital[0]->tds; }?></td>
                    </tr>
                    <tr>
                        <td>MAC</td>
                        <td>:</td>
                        <td><?php if(!array_key_exists(0,$vital)) {}else {echo $vital[0]->mac; }?></td>
                    </tr>
                    <tr>
                        <td>Distance Test</td>
                        <td>:</td>
                        <td><?php if(!array_key_exists(0,$vital)) {}else {echo $vital[0]->distance_test; }?></td>
                    </tr>
                    <tr>
                        <td>Near Vision Test</td>
                        <td>:</td>
                        <td><?php if(!array_key_exists(0,$vital)) {}else {echo $vital[0]->near_vision_test; }?></td>
                    </tr>
                    <tr>
                        <td>Astigmatism</td>
                        <td>:</td>
                        <td><?php if(!array_key_exists(0,$vital)) {}else {echo $vital[0]->astigmatism; }?></td>
                    </tr>
                    <tr>
                        <td>CVD Test</td>
                        <td>:</td>
                        <td><?php if(!array_key_exists(0,$vital)) {}else {echo $vital[0]->cvd_test; }?></td>
                    </tr>
                    <tr>
                        <td>Vascular Age</td>
                        <td>:</td>
                        <td><?php if(!array_key_exists(0,$vital)) {}else {echo $vital[0]->vascular_age; }?></td>
                    </tr>
                    <tr>
                        <td>Skin Carotenoid</td>
                        <td>:</td>
                        <td><?php if(!array_key_exists(0,$vital)) {}else {echo $vital[0]->skin_carotenoid; }?></td>
                    </tr>
                    <tr>
                        <td>Capillary Shape</td>
                        <td>:</td>
                        <td><?php if(!array_key_exists(0,$vital)) {}else {echo $vital[0]->capillary_shape; }?></td>
                    </tr>
                </table>
            </div>
        </div>
        </div>


        <div class="details-row">

            <div class="row">
                <div class="col-12">
                    <h3>Spo2</h3>
                    <div class="card">
<div class="card-body">
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

        
</div>

                    </div>


                </div>

                <div class="col-12">
                    <h3>Pulse</h3>
                    <div class="card">
                        <div class="card-body">
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
                        </div>

                    </div>


                </div>
            </div>
        </div>



    </div>


  

</body>

</html>