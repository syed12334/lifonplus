<!DOCTYPE html>
<html dir="ltr" lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <!-- Tell the browser to be responsive to screen width -->
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="description" content="">
        <meta name="author" content="">
        <!-- Favicon icon -->
        <?php echo $style;?>
        <title><?php echo title;?></title>
        <!-- This page plugin CSS -->
        <link href="<?php echo asset_url()?>js/extra-libs/css-chart/css-chart.css" rel="stylesheet">
        <link href="<?=asset_url()?>css/style.min.css" rel="stylesheet">
        <?php echo $updatelogin?>
    </head>
    <body>
        <div class="preloader">
            <div class="lds-ripple">
                <div class="lds-pos"></div>
                <div class="lds-pos"></div>
            </div>
        </div>
        <div id="main-wrapper">
            <?=$header?>
            <?=$leftmain?>
            <div class="page-wrapper">
                <div class="row page-titles">
                    <div class="col-md-5 col-12 align-self-center">
                        <h3 class="text-themecolor mb-0">My Profile</h3>
                        <ol class="breadcrumb mb-0 p-0 bg-transparent">
                            <li class="breadcrumb-item"><a href="<?=base_url()?>">Dashboard</a></li>
                            <li class="breadcrumb-item active">My Profile</li>
                        </ol>
                    </div>
                </div>
                <div class="container-fluid">                
                    <div class="card card-body">
                        <div class="row">
                            <!-- Column -->
                            <div class="col-lg-4 col-xlg-3 col-md-5">
                                <div class="card">
                                    <div class="card-body">
                                        <center class="mt-4"> <img src="<?=app_asset_url().$partner[0]->photo?>" class="rounded-circle" width="150" />
                                            <h4 class="card-title mt-2"><?=$partner[0]->fullname?></h4>
                                            <h6 class="card-subtitle"><?=$company[0]->company_name?></h6>
                                        </center>
                                    </div>
                                    <div>
                                        <hr> </div>
                                    <div class="card-body"> 
                                        <small class="text-muted">Channel Partner Code </small>
                                        <h6><?=$company[0]->code?></h6>
                                        <small class="text-muted">Email address </small>
                                        <h6><?=$partner[0]->emailid?></h6> <small class="text-muted pt-4 db">Phone</small>
                                        <h6><?=$partner[0]->contactno?></h6> <small class="text-muted pt-4 db">Address</small>
                                        <h6><?=$partner[0]->address?></h6>
                                        <button class="btn btn-circle btn-secondary" title="Change Password" onclick="modifyRow('<?=$detail[0]->id?>')"><i class="fa fa-lock"></i></button>
                                    </div>
                                </div>
                            </div>
                            <!-- Column -->
                            <!-- Column -->
                            <div class="col-lg-8 col-xlg-9 col-md-7">
                                <div class="card">
                                    <!-- Tabs -->
                                    <ul class="nav nav-pills custom-pills" id="pills-tab" role="tablist">
                                        <li class="nav-item active">
                                            <a class="nav-link" id="pills-profile-tab" data-toggle="pill" href="#last-month" role="tab" aria-controls="pills-profile" aria-selected="false">Company</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" id="pills-setting-tab" data-toggle="pill" href="#previous-month" role="tab" aria-controls="pills-setting" aria-selected="false">Personal Details</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" id="pills-setting-tab" data-toggle="pill" href="#payment" role="tab" aria-controls="pills-setting" aria-selected="false">Payment Details</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" id="bank_detail_tab" data-toggle="pill" href="#bank" role="tab" aria-controls="pills-setting" aria-selected="false">Bank Details</a>
                                        </li>
                                    </ul>
                                    <!-- Tabs -->
                                    <div class="tab-content" id="pills-tabContent">
                                        <div class="tab-pane fade show active" id="last-month" role="tabpanel" aria-labelledby="pills-profile-tab">
                                            <div class="card-body">
                                                <div class="row">
                                                <?php
                                                    $type = '';
                                                    switch(intval($company[0]->type)){
                                                        case 1:$type = 'COUNTRY PARTNER';break;
                                                        case 2:$type = 'STOCKIST';break;
                                                        case 3:$type = 'STATE C&F';break;
                                                        case 4:$type = 'DISTRIBUTOR';break;
                                                        case 5:$type = 'DEALER';break;
                                                        case 6:$type = 'RETAILER';break;
                                                        default:$type = '';break;                
                                                    }

                                                    $com_type = '';
                                                    switch(intval($company[0]->company_type)){
                                                        case 1:$com_type = 'PRIVATE LIMITED';break;
                                                        case 2:$com_type = 'LIMITED';break;
                                                        case 3:$com_type = 'PARTNERSHIP';break;
                                                        case 4:$com_type = 'PROPRITOR';break;
                                                        case 5:$com_type = 'LLP';break;
                                                        default:$com_type = '';break;                
                                                    }

                                                    $doc_type = '';
                                                    switch(intval($company[0]->doc_type)){
                                                        case 1:$doc_type = 'Incorporation';break;
                                                        case 2:$doc_type = 'Partnership Details';break;
                                                        default:$doc_type = '';break;                
                                                    }
                                                ?>
                                                    <div class="col-md-3 col-xs-6 b-r"> <strong>Channel Partner Type</strong>
                                                        <br>
                                                        <p class="text-muted"><?=$type?></p>
                                                    </div>
                                                    <div class="col-md-3 col-xs-6 b-r"> <strong>Company Name</strong>
                                                        <br>
                                                        <p class="text-muted"><?=$company[0]->company_name?></p>
                                                    </div>
                                                    <div class="col-md-3 col-xs-6 b-r"> <strong>Company Type</strong>
                                                        <br>
                                                        <p class="text-muted"><?=$com_type?></p>
                                                    </div>
                                                    <div class="col-md-3 col-xs-6"> <strong>GST No</strong>
                                                        <br>
                                                        <p class="text-muted"><?=$company[0]->gst_no?></p>
                                                    </div>
                                                    <div class="col-md-3 col-xs-6"> <strong>Company Document</strong>
                                                        <br>
                                                        <p class="text-muted"><?=$doc_type?></p>
                                                    </div>
                                                    <div class="col-md-3 col-xs-6"> <strong>Document</strong>
                                                        <br>
                                                        <p class="text-muted">
                                                            <a target="_blank" href="<?=app_asset_url().$company[0]->company_doc?>">Click here</a>
                                                        </p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="tab-pane fade" id="previous-month" role="tabpanel" aria-labelledby="pills-setting-tab">
                                            <div class="card-body">
                                                <form class="form-horizontal form-material">

                                                    <?php
                                                    $cname = $sname = $dname = $tname = '';
                                                    $country = $this->master_db->getRecords('countries',array('id'=>$partner[0]->country_id),'name');
                                                    if( count($country) ){ $cname = $country[0]->name; }

                                                    $state = $this->master_db->getRecords('states',array('id'=>$partner[0]->state_id),'name');
                                                    if( count($state) ){ $sname = $state[0]->name; }

                                                    $district = $this->master_db->getRecords('districts',array('id'=>$partner[0]->district_id),'name');
                                                    if( count($district) ){ $dname = $district[0]->name; }

                                                    $taluk = $this->master_db->getRecords('cities',array('id'=>$partner[0]->taluk_id),'name');
                                                    if( count($taluk) ){ $tname = $taluk[0]->name; }

                                                    $kyc_type = '';
                                                    switch(intval($partner[0]->kyc_type)){
                                                        case 1:$kyc_type = 'AADHAAR CARD';break;
                                                        case 2:$kyc_type = 'PAN CARD';break;
                                                        case 3:$kyc_type = 'VOTER ID';break;
                                                        case 4:$kyc_type = 'PASSPORT';break;
                                                        default:$kyc_type = '';break;                
                                                    }
                                                    ?>
                                                    <div class="row">
                                                        <div class="col-md-3 col-xs-6 b-r mt-3"> <strong>Full Name</strong>
                                                            <br><p class="text-muted"><?=$partner[0]->fullname?></p>
                                                        </div>
                                                        <div class="col-md-3 col-xs-6 b-r mt-3"> <strong>Mobile Number</strong>
                                                            <br><p class="text-muted"><?=$partner[0]->contactno?></p>
                                                        </div>
                                                        <div class="col-md-3 col-xs-6 b-r mt-3"> <strong>Email</strong>
                                                            <br><p class="text-muted"><?=$partner[0]->emailid?></p>
                                                        </div>
                                                        <div class="col-md-3 col-xs-6 b-r mt-3"> <strong>Date of Birth</strong>
                                                            <br><p class="text-muted"><?=$partner[0]->dob?></p>
                                                        </div>
                                                        <div class="col-md-3 col-xs-6 b-r mt-3"> <strong>Bloodgroup</strong>
                                                            <br><p class="text-muted"><?=$partner[0]->bloodgroup?></p>
                                                        </div>
                                                        <div class="col-md-3 col-xs-6 b-r mt-3"> <strong>Address</strong>
                                                            <br><p class="text-muted"><?=$partner[0]->address?></p>
                                                        </div>
                                                        <div class="col-md-3 col-xs-6 b-r mt-3"> <strong>Country</strong>
                                                            <br><p class="text-muted"><?=$cname?></p>
                                                        </div>
                                                        <div class="col-md-3 col-xs-6 b-r mt-3"> <strong>State</strong>
                                                            <br><p class="text-muted"><?=$sname?></p>
                                                        </div>
                                                        <div class="col-md-3 col-xs-6 b-r mt-3"> <strong>District</strong>
                                                            <br><p class="text-muted"><?=$dname?></p>
                                                        </div>
                                                        <div class="col-md-3 col-xs-6 b-r mt-3"> <strong>Taluk</strong>
                                                            <br><p class="text-muted"><?=$tname?></p>
                                                        </div>
                                                        <div class="col-md-3 col-xs-6 b-r mt-3"> <strong>Pincode</strong>
                                                            <br><p class="text-muted"><?=$partner[0]->pincode?></p>
                                                        </div>
                                                        <div class="col-md-3 col-xs-6 b-r mt-3"> <strong>Individual Photo</strong>
                                                            <br><a target="_blank" href="<?=app_asset_url().$partner[0]->photo?>">Click here</a>
                                                        </div>
                                                        <div class="col-md-3 col-xs-6 b-r mt-3"> <strong>KYC Document</strong>
                                                            <br><p class="text-muted"><?=$kyc_type?></p>
                                                            <a target="_blank" href="<?=app_asset_url().$partner[0]->kyc_doc?>">Click here</a>
                                                        </div>     
                                                    </div>                                               
                                                </form>
                                            </div>
                                        </div>
                                        <div class="tab-pane fade" id="payment" role="tabpanel" aria-labelledby="pills-setting-tab">
                                            <div class="card-body">
                                                <?php
                                                $payment_mode = '';
                                                switch(intval($payment[0]->payment_id)){
                                                    case 1:$payment_mode = 'Cheque';break;
                                                    case 2:$payment_mode = 'Cash';break;
                                                    case 3:$payment_mode = 'RTGS';break;
                                                    case 4:$payment_mode = 'Already paid to C&F/Distributor/Dealer ';break;
                                                    default:$payment_mode = '';break;                
                                                }
                                                ?>
                                                <div class="row">
                                                    <div class="col-md-3 col-xs-6 b-r mt-3"> <strong>Payment Mode</strong>
                                                        <br><p class="text-muted"><?=$payment_mode?></p>
                                                    </div>
                                                    <?php
                                                    if( intval($payment[0]->payment_id) == 1 ){
                                                        ?>

                                                        <div class="col-md-3 col-xs-6 b-r mt-3"> <strong>Cheque No</strong>
                                                            <br><p class="text-muted"><?=$payment[0]->cheque_no?></p>
                                                        </div>

                                                        <div class="col-md-3 col-xs-6 b-r mt-3"> <strong>Cheque Date</strong>
                                                            <br><p class="text-muted"><?=$payment[0]->cheque_date?></p>
                                                        </div>

                                                        <div class="col-md-3 col-xs-6 b-r mt-3"> <strong>Bank Name</strong>
                                                            <br><p class="text-muted"><?=$payment[0]->bank_name?></p>
                                                        </div>

                                                        <div class="col-md-3 col-xs-6 b-r mt-3"> <strong>Branch</strong>
                                                            <br><p class="text-muted"><?=$payment[0]->branch_name?></p>
                                                        </div>
                                                        <?php
                                                    }else if( intval($payment[0]->payment_id) == 3 ){
                                                        ?>
                                                        <div class="col-md-3 col-xs-6 b-r mt-3"> <strong>Branch</strong>
                                                            <br><p class="text-muted"><?=$payment[0]->utr_no?></p>
                                                        </div>
                                                        <?php
                                                    }
                                                    ?>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="tab-pane fade" id="bank" role="tabpanel" aria-labelledby="bank_detail_tab">
                                            <?php
                                            $bank_name = $account_no = $ifsc = $branch = 'Not Updated';
                                            if( count($bank) ){
                                                $bank_name = $bank[0]->bank_name;
                                                $account_no = $bank[0]->account_no;
                                                $ifsc = $bank[0]->ifsc_code;
                                                $branch = $bank[0]->branch_name;
                                            }
                                            ?>
                                            <div class="card-body">
                                                <div class="row">
                                                    <div class="col-md-3 col-xs-6 b-r mt-3"> <strong>Bank Name</strong>
                                                        <br><p class="text-muted"><?=$bank_name?></p>
                                                    </div>

                                                    <div class="col-md-3 col-xs-6 b-r mt-3"> <strong>Account No</strong>
                                                        <br><p class="text-muted"><?=$account_no?></p>
                                                    </div>

                                                    <div class="col-md-3 col-xs-6 b-r mt-3"> <strong>IFSC Code</strong>
                                                        <br><p class="text-muted"><?=$ifsc?></p>
                                                    </div>

                                                    <div class="col-md-3 col-xs-6 b-r mt-3"> <strong>Branch Name</strong>
                                                        <br><p class="text-muted"><?=$branch?></p>
                                                    </div>

                                                    <div class="col-md-6 col-xs-6 b-r mt-3"> 
                                                        <button class="btn btn-info" onclick="getBankDetail();" ><i class="fa fa-edit"></i> Update</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- Column -->
                        </div>
                    </div>
                </div>
                <!-- End Container fluid  -->
                <!-- footer -->
                <?=$footer?>
                <!-- End footer -->
            </div>
            <!-- End Page wrapper  -->
        </div>
        <!-- End Wrapper -->

        <div class="chat-windows"></div>
        <?=$jsfile?>
        <script>
            function modifyRow(id){
                var base_url = '<?php echo base_url();?>';
                document.location.href =base_url+"myprofile/edit_profile";
            }

            function getBankDetail(){
                Swal.fire({
                    allowOutsideClick: false,
                    html : '<i class="fas fa-spinner fa-spin"></i> Loading please wait...',
                    buttons: false,
                    showConfirmButton: false,
                });

                $.ajax({
                    url: "<?=base_url().'myprofile/getBankForm'?>",
                    type: "get",
                    dataType : 'html',
                    success: function (response) {
                        //console.log(response);
                        Swal.close();
                        $('#bankmodal .modal-body').html(response);
                        $('#bankmodal .modal-title').html('Bank Details');
                        $('#bankmodal').modal('show');                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        Swal.fire({
                            type: 'error',
                            text: 'Something went wrong!',
                        })
                    }
                });
                
            }
        </script>
        <div class="modal fade" id="bankmodal" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Large modal</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                    </div>
                    <div class="modal-body">
                        ...
                    </div>
                </div><!-- /.modal-content -->
            </div><!-- /.modal-dialog -->
        </div><!-- /.modal -->
    </body>
</html>