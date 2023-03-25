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
                        <h3 class="text-themecolor mb-0">End Users</h3>
                        <ol class="breadcrumb mb-0 p-0 bg-transparent">
                            <li class="breadcrumb-item"><a href="<?=base_url()?>">Dashboard</a></li>
							 <li class="breadcrumb-item active">End Users</li>
                           
							<li class="breadcrumb-item active"><?php if($type == 1){?>Add<?php }else{?>Edit<?php }?> End User</li>
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
                            <h4 class="card-title">Add End User</h4>
                            <div class="card-tools"></div><hr> 
                            <form id="category_form" method="post" onsubmit="return validateForm();" enctype="multipart/form-data" action="<?php echo base_url();?>master/save_partner">
                                <input type="hidden" name="id" id="id" value="0" />
                                

								 <h3>Personal <span> Details </span> </h3>
								 
								 
								<div class="form-group row">
                                    <label class="col-sm-2 text-right control-label col-form-label">Enter Fullname</label>
                                    <div class="col-sm-4">
                                          <input type="text" name="name" id="name" class="form-control" required data-error="Please enter your Full Name" placeholder="Full name">
                                    </div>
									
									 <label class="col-sm-2 text-right control-label col-form-label">Enter Mobile Number</label>
                                    <div class="col-sm-4">
                                          <input class="form-control onlynumbers" type="text" maxlength="10" minlength="10" name="mobile" id="mobile" placeholder="Mobile Number">
                                    </div>
									
                                </div>
								
								<div class="form-group row">
                                    <label class="col-sm-2 text-right control-label col-form-label">Enter Email</label>
                                    <div class="col-sm-4">
                                        <input type="email" name="email_id" id="email_id" class="form-control" required data-error="Please enter email" placeholder="Email Address">
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
                                            <option value="NA">NA</option>
                                          </select>
                                    </div>
									
									
									 <label class="col-sm-2 text-right control-label col-form-label">Select Gender</label>
                                    <div class="col-sm-4">
										<select class="form-control" id="gender" name="gender">
											<option value=""> --- Select Gender --- </option>
											<option value="1">Male</option>
											<option value="0">Female</option>
											<option value="2">Transgender</option>
										   
										</select>
                                    </div>
									
									 
									
                                </div>
								
								
								<div class="form-group row">
                                   
									<label class="col-sm-2 text-right control-label col-form-label">Enter Address</label>
                                    <div class="col-sm-4">
                                       <textarea type="text" class="form-control clear_data" name="address" id="address" title="Enter Address" placeholder="Enter Address"></textarea>
                                    </div>
									
									
									 <label class="col-sm-2 text-right control-label col-form-label">Upload Individual Photo</label>
                                    <div class="col-sm-4">
                                      <input type="file" name="photo" id="photo" class="form-control" placeholder="Individual PHOTO: " accept=",.jpeg,.jpg">
                                            <span class="upload">UPLOAD JPG (100KB) </span>
                                    </div>
									
                                </div>
								
								<div class="form-group row">
								     
								    <label class="col-sm-2 text-right control-label col-form-label">Enter Referral Code</label>
                                    <div class="col-sm-4">
                                          <input type="text" name="referral_code" id="referral_code" class="form-control"  placeholder="Referral Code" maxlength="50">
                                    </div>
								
                                    <label class="col-sm-2 text-right control-label col-form-label">Select Country</label>
                                    <div class="col-sm-4">
                                        <select class="form-control" id="country" name="country">
                                                <option value="">--- Select Country --- </option>
                                            </select>     
                                    </div>
									
									
                                </div>
								
								<div class="form-group row">
								
								     <label class="col-sm-2 text-right control-label col-form-label state">Select State</label>
                                    <div class="col-sm-4 state">
                                        <select class="form-control" id="state" name="state">
                                              <option value=""> --- Select State --- </option>
                                         </select>  
                                    </div>
									
                                    <label class="col-sm-2 text-right control-label col-form-label district">Select District</label>
                                    <div class="col-sm-4 district">
                                        <select class="form-control" id="district" name="district">
                                            <option value="">--- Select District --- </option>
                                        </select>
                                    </div>
									
									
                                </div>
								
								
								<div class="form-group row">
								
								   <label class="col-sm-2 text-right control-label col-form-label taluk">Select Taluk</label>
                                    <div class="col-sm-4 taluk">
                                         <select class="form-control" id="taluk" name="taluk">
                                                <option value="">--- Select Taluk--- </option>
                                            </select>
                                    </div>
								
                                </div>
                                   <div class="form-group row">
                                
                                   <label class="col-sm-2 text-right control-label col-form-label package">Select Package</label>
                                    <div class="col-sm-4 package">
                                         <select class="form-control" id="package" name="package">
                                                <option value="">--- Select Package </option>
                                                <?php
                                                    foreach ($package as $key => $value) {
                                                        ?>
                                                        <option value="<?php echo $value->id; ?>"><?php echo $value->name; ?></option>
                                                        <?php
                                                    }
                                                ?>
                                            </select>
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
		
            $(document).ready(function(){

             

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
                        if( size > 100 ){
                            Swal.fire('Individual photo size cannot be greater than 100KB.');
                            $(this).val(null);
                            return false;
                        }
                    }
                });

                loadCountry();
                loadStates();

                $('#country').change(function(){
                    if( this.value != '' ){
                        
                        var data = "country="+this.value;
                        loadStates(this);
                    }else{
                        $('#state').html("<option>--Select State--</option>");
                    }
                });

               
                $('#state').change(function(){
                    if( this.value != '' ){
                        
                        var country = $.trim($('#country').val());
                        if( country == '' ){
                            Swal.fire('Select country');
                            return false;
                        }

                      
                        loadDistricts(this);
                    }else{
                        $('#district').html("<option>--Select District/Town/City--</option>");
                    }
                });

                $('#district').change(function(){
                    if( this.value != '' ){

                       
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

                        var data ="country="+country+"&state="+state+"&district="+this.value;
                        loadTaluks(this);
                    }else{
                        $('#taluk').html("<option>--Select Taluk--</option>");
                    }
                });

                $('#taluk').change(function(){
                    if( this.value != '' ){
                       
                        
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

                       
                        var data = "country="+country+"&state="+state+"&district="+district+"&taluk="+this.value;
                          
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
                $.get("<?=admin_url();?>app/countries", "", function(data){
                    //console.log(data);
                    data = JSON.parse(data);
                    var output = "<option value=''>--Select Country--</option>";
                    $(data.data).each(function(){
                        output += "<option value='"+this.id+"'>"+this.name+"</option>";
                    });
                    $('#country').html(output);
                   
                });
            }

           

            function loadStates(){
                $.get("<?=admin_url()?>app/states", "country_id=1", function(data){
                    //console.log(data);
                    data = JSON.parse(data);
                    var output = "<option value=''>--Select State--</option>";
                    $(data.data).each(function(){
                        output += "<option value='"+this.id+"'>"+this.name+"</option>";
                    });
                    $('#state').html(output);
                   
                });
            }

            function loadDistricts(ele){
                var output = "<option value=''>--Select District--</option>";
                $.get("<?=admin_url()?>app/districts", "state_id="+ele.value, function(data){
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
                $.get("<?=admin_url()?>app/taluks", "district_id="+ele.value, function(data){
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

                var name = $.trim($('#name').val());
                if( name == '' ){
                    Swal.fire('Enter full name');
                    return false;    
                }
                formData.append('name',name);

                var mobile = $.trim($('#mobile').val());
                if( mobile == '' ){
                    Swal.fire('Enter phone');
                    return false;    
                }
                formData.append('mobile',mobile);

                var email_id = $.trim($('#email_id').val());
                // if( email_id == '' ){
                //     Swal.fire('Enter email');
                //     return false;    
                // }

                // if( validateEmail(email_id) == false ){
                //     Swal.fire('Enter valid email');
                //     return false;    
                // }

                formData.append('email_id',email_id);

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
				
				var package = $.trim($('#package').val());
                if( package == '' ){
                    Swal.fire('Enter package name');
                    return false;    
                }
                formData.append('package',package);

                var address = $.trim($('#address').val());
                if( address == '' ){
                    Swal.fire('Enter company address');
                    return false;    
                }
                formData.append('address',address);
				
				
				 var photo = $.trim($('#photo').val());
                // if( photo == '' ){
                //     Swal.fire('Upload photo');
                //     return false;    
                // }
                formData.append('photo',$('#photo')[0].files[0]);

                var country = $.trim($('#country').val());
                if( country == '' ){
                    Swal.fire('Select country');
                    return false;    
                }
                formData.append('country',country);

                
                
				var state = $.trim($('#state').val());
				if( state == '' ){
					Swal.fire('Select state');
					return false;    
				}
				formData.append('state',state);
                

                
				var district = $.trim($('#district').val());
				if( district == '' ){
					Swal.fire('Select district');
					return false;    
				}
				formData.append('district',district);
                

               
				var taluk = $.trim($('#taluk').val());
				if( taluk == '' ){
					Swal.fire('Select taluk');
					return false;    
				}
				formData.append('taluk',taluk);
                
                var gender = $.trim($('#gender').val());
               
                formData.append('gender',gender);

                var referral_code = $.trim($('#referral_code').val());
               
                formData.append('referral_code',referral_code);
               /* if( $('#terms').is(':checked') == false ){
                    Swal.fire('Agree terms & conditions.');
                    return false;    
                }*/
                               
                Swal.fire({
                    allowOutsideClick: false,
                    html : '<i class="fas fa-spinner fa-spin"></i> Saving please wait...',
                    buttons: false,
                    showConfirmButton: false,
                });
                console.log(formData);//return false;
                $.ajax({
                    url : "<?=base_url()?>end_users/registeruser_post",
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
                                    window.location.href="<?php echo base_url();?>end_users";
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