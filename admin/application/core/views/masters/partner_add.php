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
        <link href="<?=asset_url()?>css/dataTables.bootstrap4.css" rel="stylesheet">
        <!-- Custom CSS -->
        <link href="<?=asset_url()?>css/style.min.css" rel="stylesheet">
        <link rel="stylesheet" type="text/css" href="<?=asset_url()?>select2/dist/css/select2.min.css">
    </head>
    <body>
        <!-- ============================================================== -->
        <!-- Preloader - style you can find in spinners.css -->
        <!-- ============================================================== -->
        <div class="preloader">
            <div class="lds-ripple">
                <div class="lds-pos"></div>
                <div class="lds-pos"></div>
            </div>
        </div>
        <!-- ============================================================== -->
        <!-- Main wrapper - style you can find in pages.scss -->
        <!-- ============================================================== -->
        <div id="main-wrapper">
            <?=$header?>
            <?=$leftmain?>
            <!-- Page wrapper  -->
            <!-- ============================================================== -->
            <div class="page-wrapper">
                <!-- ============================================================== -->
                <!-- Bread crumb and right sidebar toggle -->
                <!-- ============================================================== -->
                <div class="row page-titles">
                    <div class="col-md-5 col-12 align-self-center">
                        <h3 class="text-themecolor mb-0">Channel Partners</h3>
                        <ol class="breadcrumb mb-0 p-0 bg-transparent">
                            <li class="breadcrumb-item"><a href="<?=base_url()?>">Dashboard</a></li>
							 <li class="breadcrumb-item active">Master</li>
                            <li class="breadcrumb-item active">Channel Partners</li>
							<li class="breadcrumb-item active"><?php if($type == 1){?>Add<?php }else{?>Edit<?php }?>Channel Partners</li>
                        </ol>
                    </div>
                </div>
                <!-- Container fluid  -->
                <!-- ============================================================== -->
                <div class="container-fluid">
                    <!-- ============================================================== -->
                    <!-- Start Page Content -->
                    <!-- ============================================================== -->          
                    <?php
                    if( $this->session->flashdata('message') != null )
                        echo $this->session->flashdata('message');
                    ?>
					<?php if($type ==1){?>
                    <div class="card">
                        <div class="card-body">
                            <h4 class="card-title">Add Channel Partners</h4>
                            <div class="card-tools"></div><hr> 
                            <form id="category_form" method="post" onsubmit="return validateForm();" enctype="multipart/form-data" action="<?php echo base_url();?>master/save_partner">
                                <input type="hidden" name="id" id="id" value="0" />
                                

							   <div class="form-group row">
									<label class="col-sm-2 text-right control-label col-form-label">Select Channel Partner</label>
									<div class="col-sm-4">
										<select class="form-control" id="type" name="type">
                                                <option value="">--- Select Channel Partner --- </option>
                                                <option value="1">COUNTRY PARTNER </option>
                                                
                                                <option value="3">STATE C&F </option>
                                                <option value="4">DISTRIBUTOR </option>
                                                <option value="5">DEALER </option>
                                                <option value="6">RETAILER </option>
                                            </select>   
									</div>
									
									
									<label class="col-sm-2 text-right control-label col-form-label">Enter Company Name</label>
									<div class="col-sm-4">
										 <input type="text" name="company_name" id="company_name" class="form-control" required data-error="Please enter your Company Name" placeholder="Company Name"> 
									</div>
								</div>
                                

                                
                                <div class="form-group row">
                                    <label class="col-sm-2 text-right control-label col-form-label">Select Company Type</label>
                                    <div class="col-sm-4">
                                         <select class="form-control" id="company_type" name="company_type">
                                                <option value=""> --- Select Company Type --- </option>
                                                <option value="1">PRIVATE LIMITED</option>
                                                <option value="2">LIMITED </option>
                                                <option value="3">PARTNERSHIP</option>
                                                <option value="4">PROPRITOR</option>
                                                <option value="5">LLP</option>
                                            </select>      
                                    </div>
									
									
									 <label class="col-sm-2 text-right control-label col-form-label">Select Country</label>
                                      <div class="col-sm-4">
                                        <select class="form-control" id="country" name="country">
                                                <option value="">--- Select Country --- </option>
                                            </select>     
                                    </div>
                                </div>
								
								
								<div class="form-group row">
                                    <label class="col-sm-2 text-right control-label col-form-label region">Select Region</label>
                                    <div class="col-sm-4 region">
                                        <select class="form-control" id="region" name="region">
                                                <option value="">--- Select Region --- </option>
                                         </select>
                                    </div>
									
									 <label class="col-sm-2 text-right control-label col-form-label state">Select State</label>
                                    <div class="col-sm-4 state">
                                        <select class="form-control" id="state" name="state">
                                                <option value=""> --- Select State --- </option>
                                         </select>  
                                    </div>
                                </div>
								
								<div class="form-group row">
                                    <label class="col-sm-2 text-right control-label col-form-label district">Select District</label>
                                    <div class="col-sm-4 district">
                                        <select class="form-control" id="district" name="district">
                                                <option value="">--- Select District --- </option>
                                            </select>
                                    </div>
									
									 <label class="col-sm-2 text-right control-label col-form-label taluk">Select Taluk</label>
                                    <div class="col-sm-4 taluk">
                                         <select class="form-control" id="taluk" name="taluk">
                                                <option value="">--- Select Taluk--- </option>
                                            </select>
                                    </div>
                                </div>
								
								
								<div class="form-group row">
                                    <label class="col-sm-2 text-right control-label col-form-label">Enter GST No</label>
                                    <div class="col-sm-4">
                                          <input type="text" name="gst_no" id="gst_no" class="form-control" maxlength="15" data-error="Please enter your gst no" placeholder="GST No">
                                    </div>
									
									 <label class="col-sm-2 text-right control-label col-form-label">Select Company Document</label>
                                    <div class="col-sm-4 ">
                                          <select class="form-control" id="doc_type" name="doc_type">
                                                <option value=""> --- Select Company Docs --- </option>
                                                <option value="1">Incorporation </option>
                                                <option value="2">Partnership Details </option>
                                          </select>
                                    </div>
                                </div>
								
								
								
							   <div class="form-group row">
                                    <label class="col-sm-2 text-right control-label col-form-label">Upload Company Document</label>
                                    <div class="col-sm-4">
                                          <input type="file" name="document" id="document" class="form-control" placeholder="Document" accept=".pdf,.jpeg,.jpg">
                                            <span class="upload">UPLOAD PDF, JPG (250KB) </span>
                                    </div>
									
									 
                                </div>
								 <h3>Personal <span> Details </span> </h3>
								 
								 
								<div class="form-group row">
                                    <label class="col-sm-2 text-right control-label col-form-label">Enter Fullname</label>
                                    <div class="col-sm-4">
                                          <input type="text" name="name" id="name" class="form-control" required data-error="Please enter your Full Name" placeholder="Full name">
                                    </div>
									
									 <label class="col-sm-2 text-right control-label col-form-label">Enter Mobile Number</label>
                                    <div class="col-sm-4">
                                          <input class="form-control onlynumbers" type="text" maxlength="10" minlength="10" name="phone" id="phone" placeholder="Mobile Number">
                                    </div>
									
                                </div>
								
								<div class="form-group row">
                                    <label class="col-sm-2 text-right control-label col-form-label">Enter Email</label>
                                    <div class="col-sm-4">
                                        <input type="email" name="email" id="email" class="form-control" required data-error="Please enter email" placeholder="Email Address">
                                    </div>
									
									 <label class="col-sm-2 text-right control-label col-form-label">Enter Date of Birth</label>
                                    <div class="col-sm-4">
                                        <input placeholder="Date of Birth" name="dob" id="dob" type="date" class="form-control">
                                    </div>
									
                                </div>
								
								
								<div class="form-group row">
                                    <label class="col-sm-2 text-right control-label col-form-label">Select Bloodgroup</label>
                                    <div class="col-sm-4">
                                        <select class="form-control" id="bloodgroup" name="bloodgroup">
                                                <option value=""> --- Select Blood Group --- </option>
                                                <option value="A-">A-</option>
                                                <option value="A+">A+</option>
                                                <option value="B-">B-</option>
                                                <option value="B+">B+</option>
                                                <option value="AB-">AB-</option>
                                                <option value="AB+">AB+</option>
                                                <option value="O+">O+</option>
                                                <option value="O-">O-</option>
                                          </select>
                                    </div>
									
									 <label class="col-sm-2 text-right control-label col-form-label">Enter Address</label>
                                    <div class="col-sm-4">
                                       <textarea type="text" class="form-control clear_data" name="address" id="address" title="Enter Address" placeholder="Company Address"></textarea>
                                    </div>
									
                                </div>
								
								
								<div class="form-group row">
                                   
									 <label class="col-sm-2 text-right control-label col-form-label">Enter Pincode</label>
                                    <div class="col-sm-4">
                                      <input type="text" name="pincode" id="pincode" class="form-control onlynumbers" maxlength="6" required data-error="Please enter your Pincode" placeholder="Pincode">
                                    </div>
									
									
									 <label class="col-sm-2 text-right control-label col-form-label">Upload Individual Photo</label>
                                    <div class="col-sm-4">
                                      <input type="file" name="photo" id="photo" class="form-control" placeholder="Individual PHOTO: " accept=",.jpeg,.jpg">
                                            <span class="upload">UPLOAD JPG (100KB) </span>
                                    </div>
									
                                </div>
								
								
								<div class="form-group row">
                                   
									 <label class="col-sm-2 text-right control-label col-form-label">Select Country</label>
                                    <div class="col-sm-4">
                                        <select class="form-control" id="pcountry" name="pcountry">
                                                <option value="">--- Select Country --- </option>
                                        </select>
                                    </div>
									
									 <label class="col-sm-2 text-right control-label col-form-label">Select State</label>
                                    <div class="col-sm-4">
                                       <select class="form-control" id="pstate" name="pstate">
                                         <option value=""> --- Select State --- </option>
                                       </select>  
                                    </div>
									
                                </div>
								
								
								
								
								<div class="form-group row">
                                   <label class="col-sm-2 text-right control-label col-form-label">Select KYC Document</label>
								   <div class="col-sm-4 ">
									 <select class="form-control" id="kyc_type" name="kyc_type">
										<option value=""> --- Select KYC Document --- </option>
										<option value="1">AADHAAR CARD</option>
										<option value="2">PAN CARD</option>
										<option value="3">VOTER ID</option>
										<option value="4">PASSPORT</option>
									 </select>
									</div>
									
									 <label class="col-sm-2 text-right control-label col-form-label kyc_doc">Upload KYC Document</label>
                                    <div class="col-sm-4 kyc_doc">
									 <input type="file" name="kyc_doc" id="kyc_doc" class="form-control" placeholder="KYC UPLOAD" accept=".pdf,.jpeg,.jpg">
                                      <span class="upload">UPLOAD PDF,JPG (250KB) </span>
									</div>
                                </div>
								
								
								
								<div class="form-group row">
                                   
									 <label class="col-sm-2 text-right control-label col-form-label">Select Payment Mode</label>
                                    <div class="col-sm-4">
                                       <select class="form-control" id="payment_mode" name="payment_mode">
                                                <option value=""> --- Select Payment Mode --- </option>
                                                <option value="1">Cheque </option>
                                                <option value="2">Cash </option>
                                                <option value="3">RTGS </option>
                                                <option value="4">Already paid to C&F/Distributor/Dealer </option>
                                            </select>  
                                    </div>
									
									
									 <label class="col-sm-2 text-right control-label col-form-label rtgsinput">Enter UTR No</label>
                                    <div class="col-sm-4 rtgsinput">
									   <input type="text" name="utr_no" id="utr_no" class="form-control" required placeholder="UTR NO">
									</div>
                                </div>
								
								
								<div class="form-group row chequeinput">
                                   
									 <label class="col-sm-2 text-right control-label col-form-label">Enter Cheque Number</label>
                                    <div class="col-sm-4">
                                       <input type="text" name="cheque_no" id="cheque_no" class="form-control" required placeholder="Cheque Number">
                                    </div>
									
									
									 <label class="col-sm-2 text-right control-label col-form-label">Enter Cheque Date</label>
                                    <div class="col-sm-4">
									    <input type="date" placeholder="Cheque Date" name="cheque_date" id="cheque_date" class="form-control" required placeholder="Date">
									</div>
                                </div>
								
								<div class="form-group row chequeinput">
                                   
									 <label class="col-sm-2 text-right control-label col-form-label">Enter Bank Name</label>
                                    <div class="col-sm-4">
                                       <input type="text" name="cheque_no" id="cheque_no" class="form-control" required placeholder="Cheque Number">
                                    </div>
									
									
									 <label class="col-sm-2 text-right control-label col-form-label">Enter Branch Name</label>
                                    <div class="col-sm-4">
									    <input type="date" placeholder="Cheque Date" name="cheque_date" id="cheque_date" class="form-control" required placeholder="Date">
									</div>
                                </div>

                                <div class="form-group row">
                                    <div class="col-md-12 text-center">
                                        <button type="button" onclick="validateForm();" class="btn btn-success"><i class="fa fa-check"></i> Submit</button>
                                        <a href="<?=base_url().'master/partners'?>" class="btn btn-danger"><i class="fa fa-times"></i> Cancel</a>
                                    </div>
                                </div>            

                                <div class="pagecontent"></div>               
                            </form>
                            
                        </div>
                    </div>
					
					<?php }?>
					
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
        <script src="<?php echo asset_url();?>js/jquery.validate.min.js"></script>
		
        <script>
		
		   function checkEligible(data = ''){

                if( data == '' ){
                    var type = $.trim($('#type').val());
                    var country = $.trim($('#country').val());
                    var region = $.trim($('#region').val());
                    var state = $.trim($('#state').val());
                    var district = $.trim($('#district').val());
                    var taluk = $.trim($('#taluk').val());
                    data = "type="+type+"&country="+country+"&region="+region+"&state="+state+"&district="+district+"&taluk="+taluk;
                }
                console.log(data);

                Swal.fire({
                    allowOutsideClick: false,
                    html : '<i class="fas fa-spinner fa-spin"></i> Checking please wait...',
                    buttons: false,
                    showConfirmButton: false,
                });

                $.ajax({
                    url : "<?=base_url()?>app/checkeligible",
                    type: 'get',
                    dataType: 'html',
                    data: data,
                    crossDomain: true,
                    contentType: false,
                    processData: false,
                    success: (response, textStatus, jQxhr) => {
                        //console.log(response);
                        if( response == '1' ){
                            eligible = 1;
                            Swal.fire($("#type option:selected").text()+ "already exists.");
                        }else{
                            eligible = 0;
                            Swal.close();
                        }
                    },
                    error: (jQxhr, textStatus, errorThrown) => {
                        Swal.fire('Something went wrong...');
                    }
                });
            }

            $(document).ready(function(){

                $('#gst_no').bind('keyup paste', function(){
                    this.value = this.value.toUpperCase();
                    if( this.value.length > 15 ){ this.value = this.value.substring(0, 15); }
                    this.value = this.value.replace(/[^0-9A-Z]/g, '');
                });

                $('#document').bind('change', function() {
                    if( this.value != '' ){
                        var type = this.value.split('.');
                        if( type.length > 2 ){
                            Swal.fire('No special characters are allowed in file name.');
                            $(this).val(null);
                            return false;
                        }

                        if( type[1] != 'pdf' && type[1] != 'jpeg' && type[1] != 'jpg' ){
                            Swal.fire('Invalid file');
                            return false;
                        }
                        var size = this.files[0].size/1024;
                        if( size > 250 ){
                            Swal.fire('Document size cannot be greater than 250KB.');
                            $(this).val(null);
                            return false;
                        }
                    }
                });

                $('#photo').bind('change', function() {
                    if( this.value != '' ){
                        var type = this.value.split('.');
                        if( type.length > 2 ){
                            Swal.fire('No special characters are allowed in file name.');
                            $(this).val(null);
                            return false;
                        }

                        if( type[1] != 'jpeg' && type[1] != 'jpg' && type[1] != 'png' ){
                            Swal.fire('Invalid file');
                            return false;
                        }
                        var size = this.files[0].size/1024;
                        if( size > 110 ){
                            Swal.fire('Individual photo size cannot be greater than 100KB.');
                            $(this).val(null);
                            return false;
                        }
                    }
                });

                $('#kyc_doc').bind('change', function() {
                    if( this.value != '' ){
                        var type = this.value.split('.');
                        if( type.length > 2 ){
                            Swal.fire('No special characters are allowed in file name.');
                            $(this).val(null);
                            return false;
                        }

                        if( type[1] != 'jpeg' && type[1] != 'jpg' && type[1] != 'png' ){
                            Swal.fire('Invalid file');
                            return false;
                        }
                        var size = this.files[0].size/1024;
                        if( size > 250 ){
                            Swal.fire('KYC Document cannot be greater than 250KB.');
                            $(this).val(null);
                            return false;
                        }
                    }
                });

                loadCountry();
                loadStates();

                $('#country').change(function(){
                    if( this.value != '' ){
                        var type = $.trim($('#type').val());
                        console.log(type);
                        if( type == '' ){
                            Swal.fire('Select channel partner type');
                            return false;
                        }else if( type == 1 ){
                            var data = "type="+type+"&country="+this.value;
                            checkEligible(data);
                        }                        
                        loadRegion(this);
                    }else{
                        $('#region').html("<option>--Select Region--</option>");
                    }
                });

                $('#region').change(function(){
                    if( this.value != '' ){
                        var type = $.trim($('#type').val());
                        if( type == '' ){
                            Swal.fire('Select channel partner type');
                            return false;
                        }

                        var country = $.trim($('#country').val());
                        if( country == '' ){
                            Swal.fire('Select country');
                            return false;
                        }
                        
                        if( type == 2 ){
                            var data = "type="+type+"&country="+country+"&region="+this.value;
                            checkEligible(data);
                        }  
                    }  
                });

                $('#state').change(function(){
                    if( this.value != '' ){
                        var type = $.trim($('#type').val());
                        if( type == '' ){
                            Swal.fire('Select channel partner type');
                            return false;
                        }
                        
                        var country = $.trim($('#country').val());
                        if( country == '' ){
                            Swal.fire('Select country');
                            return false;
                        }

                        if( type == 3 ){
                            var data = "type="+type+"&country="+country+"&state="+this.value;
                            checkEligible(data);
                        }    

                        loadDistricts(this);
                    }else{
                        $('#district').html("<option>--Select District/Town/City--</option>");
                    }
                });

                $('#district').change(function(){
                    if( this.value != '' ){

                        var type = $.trim($('#type').val());
                        if( type == '' ){
                            Swal.fire('Select channel partner type');
                            return false;
                        }
                        
                        var country = $.trim($('#country').val());
                        if( country == '' ){
                            Swal.fire('Select country');
                            return false;
                        }

                        var state = $.trim($('#state').val());
                        if( state == '' ){
                            Swal.fire('Select state');
                            return false;
                        }

                        if( type == 4 ){
                            var data = "type="+type+"&country="+country+"&state="+state+"&district="+this.value;
                            checkEligible(data);
                        }    

                        loadTaluks(this);
                    }else{
                        $('#taluk').html("<option>--Select Taluk--</option>");
                    }
                });

                $('#taluk').change(function(){
                    if( this.value != '' ){
                        var type = $.trim($('#type').val());
                        if( type == '' ){
                            Swal.fire('Select channel partner type');
                            return false;
                        }
                        
                        var country = $.trim($('#country').val());
                        if( country == '' ){
                            Swal.fire('Select country');
                            return false;
                        }

                        var state = $.trim($('#state').val());
                        if( state == '' ){
                            Swal.fire('Select state');
                            return false;
                        }

                        var district = $.trim($('#district').val());
                        if( district == '' ){
                            Swal.fire('Select district');
                            return false;
                        }

                        if( type == 5 || type == 6 ){
                            var data = "type="+type+"&country="+country+"&state="+state+"&district="+district+"&taluk="+this.value;
                            checkEligible(data);
                        }  
                    }  
                });

                $('.rtgsinput').css('display','none');
                $('.chequeinput').css('display','none');
                $('.kyc_doc').css('display','none');

                $('#payment_mode').change(function(){
                    if( this.value == '1' ){ 
                        $('.rtgsinput').css('display','none');
                        $('.chequeinput').css('display','flex');
                    }else if( this.value == '3' ){
                        $('.rtgsinput').css('display','block');
                        $('.chequeinput').css('display','none');
                    }else{
                        $('.rtgsinput').css('display','none');
                        $('.chequeinput').css('display','none');
                    }
                });

                $('#kyc_type').change(function(){
                    if( this.value != '' ){ $('.kyc_doc').css('display','block'); }
                    else{ $('.kyc_doc').css('display','none'); }
                });

                $('#type').change(function(){
                    console.log(this.value);
                    if( this.value == 1 ){
                        $('.region').css('display','none');
                        $('.state').css('display','none');
                        $('.district').css('display','none');
                        $('.taluk').css('display','none');
                    }else if( this.value == 2 ){   
                        $('.region').css('display','block');                     
                        $('.state').css('display','none');
                        $('.district').css('display','none');
                        $('.taluk').css('display','none');
                    }else if( this.value == 3 ){
                        $('.state').css('display','block');
                        $('.region').css('display','none');
                        $('.district').css('display','none');
                        $('.taluk').css('display','none');
                    }else if( this.value == 4 ){   
                        $('.state').css('display','block');
                        $('.district').css('display','block');
                        $('.region').css('display','none');
                        $('.taluk').css('display','none');
                    }else if( this.value == 5 || this.value == 6 ){
                        $('.state').css('display','block');
                        $('.district').css('display','block');
                        $('.region').css('display','block');
                        $('.taluk').css('display','block');
                        $('.region').css('display','none');
                    }else{
                        $('.region').css('display','none');
                        $('.state').css('display','block');
                        $('.district').css('display','block');
                        $('.taluk').css('display','block');
                    }

                });

                $('#email').change(function(){
                    if( validateEmail(this.value) == false ){
                        Swal.fire('Enter valid email');
                        this.value = "";
                    }
                });

                
            });

            function loadCountry(){
                $.get("<?=base_url();?>app/countries", "", function(data){
                    //console.log(data);
                    data = JSON.parse(data);
                    var output = "<option value=''>--Select Country--</option>";
                    $(data.data).each(function(){
                        output += "<option value='"+this.id+"'>"+this.name+"</option>";
                    });
                    $('#country').html(output);
                    $('#pcountry').html(output);
                });
            }

            function loadRegion(){
                $.get("<?=base_url()?>app/regions", "", function(data){
                    //console.log(data);
                    data = JSON.parse(data);
                    var output = "<option value=''>--Select Region--</option>";
                    $(data.data).each(function(){
                        output += "<option value='"+this.id+"'>"+this.name+"</option>";
                    });
                    $('#region').html(output);
                });
            }

            function loadStates(){
                $.get("<?=base_url()?>app/states", "country_id=1", function(data){
                    //console.log(data);
                    data = JSON.parse(data);
                    var output = "<option value=''>--Select State--</option>";
                    $(data.data).each(function(){
                        output += "<option value='"+this.id+"'>"+this.name+"</option>";
                    });
                    $('#state').html(output);
                    $('#pstate').html(output);
                });
            }

            function loadDistricts(ele){
                var output = "<option value=''>--Select District--</option>";
                $.get("<?=base_url()?>app/districts", "state_id="+ele.value, function(data){
                    //console.log(data);
                    data = JSON.parse(data);                    
                    $(data.data).each(function(){
                        output += "<option value='"+this.id+"'>"+this.name+"</option>";
                    });
                    $('#district').html(output);
                });
                $('#district').html(output);
            }

            function loadTaluks(ele){
                var output = "<option value=''>--Select Taluk--</option>";
                $.get("<?=base_url()?>app/taluks", "district_id="+ele.value, function(data){
                    //console.log(data);
                    data = JSON.parse(data);                    
                    $(data.data).each(function(){
                        output += "<option value='"+this.id+"'>"+this.name+"</option>";
                    });
                    $('#taluk').html(output);
                });
                $('#taluk').html(output);
            }      

            function validateEmail(email) {
                const re = /^(([^<>()[\]\\.,;:\s@"]+(\.[^<>()[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
                return re.test(String(email).toLowerCase());
            }

            function validateForm(){

                var formData = new FormData();

                var type = $.trim($('#type').val());
                if( type == '' ){
                    Swal.fire('Select channel partner');
                    return false;    
                }
                formData.append('type',type);

                var company_name = $.trim($('#company_name').val());
                if( company_name == '' ){
                    Swal.fire('Select company name');
                    return false;    
                }
                formData.append('company_name',company_name);

                var company_type = $.trim($('#company_type').val());
                if( company_type == '' ){
                    Swal.fire('Select company type');
                    return false;    
                }
                formData.append('company_type',company_type);

                var gst_no = $.trim($('#gst_no').val());
                if( gst_no == '' ){
                    Swal.fire('Enter GST No');
                    return false;    
                }
                formData.append('gst_no',gst_no);

                var doc_type = $.trim($('#doc_type').val());
                if( doc_type == '' ){
                    Swal.fire('Select company document');
                    return false;    
                }
                formData.append('doc_type',doc_type);

                var document = $.trim($('#document').val());
                if( document == '' ){
                    Swal.fire('Upload company document');
                    return false;    
                }
                formData.append('document',$('#document')[0].files[0]);

                var name = $.trim($('#name').val());
                if( name == '' ){
                    Swal.fire('Enter full name');
                    return false;    
                }
                formData.append('name',name);

                var phone = $.trim($('#phone').val());
                if( phone == '' ){
                    Swal.fire('Enter phone');
                    return false;    
                }
                formData.append('phone',phone);

                var email = $.trim($('#email').val());
                if( email == '' ){
                    Swal.fire('Enter email');
                    return false;    
                }

                if( validateEmail(email) == false ){
                    Swal.fire('Enter valid email');
                    return false;    
                }

                formData.append('email',email);

                var dob = $.trim($('#dob').val());
                if( dob == '' ){
                    Swal.fire('Select date of birth');
                    return false;    
                }
                formData.append('dob',dob);

                var bloodgroup = $.trim($('#bloodgroup').val());
                if( bloodgroup == '' ){
                    Swal.fire('Select blood group');
                    return false;    
                }
                formData.append('bloodgroup',bloodgroup);

                var address = $.trim($('#address').val());
                if( address == '' ){
                    Swal.fire('Enter company address');
                    return false;    
                }
                formData.append('address',address);

                var country = $.trim($('#country').val());
                if( country == '' ){
                    Swal.fire('Select country');
                    return false;    
                }
                formData.append('country',country);

                if( $('.region').css('display') != 'none' ){
                    var region = $.trim($('#region').val());
                    if( region == '' ){
                        Swal.fire('Select region');
                        return false;    
                    }
                    formData.append('region',region);
                }                

                if( $('.state').css('display') != 'none' ){
                    var state = $.trim($('#state').val());
                    if( state == '' ){
                        Swal.fire('Select state');
                        return false;    
                    }
                    formData.append('state',state);
                }

                if( $('.district').css('display') != 'none' ){
                    var district = $.trim($('#district').val());
                    if( district == '' ){
                        Swal.fire('Select district');
                        return false;    
                    }
                    formData.append('district',district);
                }

                if( $('.taluk').css('display') != 'none' ){
                    var taluk = $.trim($('#taluk').val());
                    if( taluk == '' ){
                        Swal.fire('Select taluk');
                        return false;    
                    }
                    formData.append('taluk',taluk);
                }
                
                var pincode = $.trim($('#pincode').val());
                if( pincode == '' ){
                    Swal.fire('Enter pincode');
                    return false;    
                }
                formData.append('pincode',pincode);

                var photo = $.trim($('#photo').val());
                if( photo == '' ){
                    Swal.fire('Upload photo');
                    return false;    
                }
                formData.append('photo',$('#photo')[0].files[0]);

                var pcountry = $.trim($('#pcountry').val());
                if( pcountry == '' ){
                    Swal.fire('Select Country');
                    return false;    
                }
                formData.append('pcountry',pcountry);

                var pstate = $.trim($('#pstate').val());
                if( pstate == '' ){
                    Swal.fire('Select State');
                    return false;    
                }
                formData.append('pstate',pstate);

                var kyc_type = $.trim($('#kyc_type').val());
                if( kyc_type == '' ){
                    Swal.fire('Select SKY document type ');
                    return false;    
                }
                formData.append('kyc_type',kyc_type);

                var kyc_doc = $.trim($('#kyc_doc').val());
                if( kyc_doc == '' ){
                    Swal.fire('Upload KYC document');
                    return false;    
                }
                formData.append('kyc_doc',$('#kyc_doc')[0].files[0]);

                var payment_mode = $.trim($('#payment_mode').val());
                if( payment_mode == '' ){
                    Swal.fire('Select payment mode');
                    return false;    
                }
                formData.append('payment_mode',payment_mode);

                if( payment_mode == '1' ){
                    var cheque_no = $.trim($('#cheque_no').val());
                    if( cheque_no == '' ){
                        Swal.fire('Enter cheque no');
                        return false;    
                    }
                    formData.append('cheque_no',cheque_no);

                    var cheque_date = $.trim($('#cheque_date').val());
                    if( cheque_date == '' ){
                        Swal.fire('Select cheque date');
                        return false;    
                    }
                    formData.append('cheque_date',cheque_date);

                    var bank_name = $.trim($('#bank_name').val());
                    if( bank_name == '' ){
                        Swal.fire('Enter bank name');
                        return false;    
                    }
                    formData.append('bank_name',bank_name);

                    var branch_name = $.trim($('#branch_name').val());
                    if( branch_name == '' ){
                        Swal.fire('Enter branch name');
                        return false;    
                    }
                    formData.append('branch_name',branch_name);
                }

                if( payment_mode == '3' ){
                    var utr_no = $.trim($('#utr_no').val());
                    if( utr_no == '' ){
                        Swal.fire('Enter UTR Number');
                        return false;    
                    }
                    formData.append('utr_no',utr_no);
                }

               /* if( $('#terms').is(':checked') == false ){
                    Swal.fire('Agree terms & conditions.');
                    return false;    
                }*/
                formData.append('agree',1);                    
                Swal.fire({
                    allowOutsideClick: false,
                    html : '<i class="fas fa-spinner fa-spin"></i> Saving please wait...',
                    buttons: false,
                    showConfirmButton: false,
                });
                console.log(formData);//return false;
                $.ajax({
                    url : "<?=base_url()?>app/register",
                    type: 'POST',
                    dataType: 'json',
                    data: formData,
                    crossDomain: true,
                    contentType: false,
                    processData: false,
                    success: (response, textStatus, jQxhr) => {
                        console.log(response);
                        if( response.status == 'failure' ){
                            Swal.fire(response.msg);    
                        }else{
                            if( response.status == 'success' ){                                
                                Swal.fire({
                                    title: response.msg,
                                    confirmButtonText: `Ok`,
                                }).then((result) => {
                                    window.location.href="<?php echo base_url();?>master/partners";
                                });
                            }
                        }
                    },
                    error: (jQxhr, textStatus, errorThrown) => {
                        Swal.fire('Something went wrong...');
                    }
                });
                return false;
            }
          
        </script>
		
    </body>

</html>