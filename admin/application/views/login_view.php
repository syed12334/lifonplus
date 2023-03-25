<!DOCTYPE html>
<html dir="ltr">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <!-- Tell the browser to be responsive to screen width -->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <!-- Favicon icon -->
    <link rel="icon" type="image/png" sizes="16x16" href="<?=asset_url()?>images/favicon.png">
    <title><?php echo title;?></title>
	
    <!-- Custom CSS -->
    <link href="<?=asset_url()?>css/style.min.css" rel="stylesheet">
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries <link rel="canonical" href="https://www.wrappixel.com/templates/monsteradmin/" />-->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
<![endif]-->
<style type="text/css">

.hidden{
    display: none;
}

.rounded {
    border-radius:0!important;
    margin-top: 85px;
}

.btn-block {
    display: inline-block;
    width: 100px;
}

.bg-white {
    background-color: #fff !important;
    opacity: 0.8;
}

.auth-wrapper .auth-box {
    box-shadow: 1px 0 20px rgba(0,0,0,.08);
    margin: 0% 0;
    max-width: 400px;
    width: 90%;
    border: 1px solid #bcbcd3;
    opacity: 1;
}


.form-control {
    
    font-weight: 600;
}

.form-control  {
    background-image: linear-gradient(#1e88e5,#1e88e5),linear-gradient(#bcbcd3,#bcbcd3)!important;
}


body { 
    background-size: cover;
	background-position: center top;
    background-image: url(<?=asset_url()?>images/bg.png);
}

body {
    padding-top: 20px;
    padding-bottom: 40px;
}

.hl{
    margin: 20px 0 0 0;
    font-size: 16px;
    font-weight: 600;
    color: #e23d42;
}

.name{
    font-size: 20px;
    margin: 8px 0 0 0;
    font-weight: 600;
    color: #225929;
}

.auth-wrapper .auth-box {
    border-radius: 12px!important;
}

h3.name{
    font-size: 16px;
}

</style>
</head>

<body>
    <div class="main-wrapper">
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
        <!-- Preloader - style you can find in spinners.css -->
        <!-- ============================================================== -->
        <!-- ============================================================== -->
        <!-- Login box.scss -->
        <!-- ============================================================== -->
        <div class="auth-wrapper d-flex no-block justify-content-center align-items-center"<?php /*?> style="background:url(<?=asset_url()?>/images/background/weatherbg.jpg) no-repeat center center; background-size: cover;"<?php */?>>
            <div class="auth-box p-4 bg-white rounded">
                <div id="loginform">
                <div class="text-center">
                    <img src="<?=asset_url()?>images/logo.png" id="logoimg" alt=" Logo">
                    <h1 class="name"><?=title?></h1>
                    <!--<h3 class="name">Superadmin</h3>-->
                </div>
                    <!-- Form -->
                    <div class="row">
                        <div class="col-12">
                            <form class="form-horizontal mt-3 form-material" id="loginform" action="<?=base_url()?>" method="post" onsubmit="return login();" autocomplete="off">
                                <div class="form-group mb-3">
                                    <div class="">
                                        <input class="form-control onlynumbers" type="text" maxlength="10" name="phone" id="phone" placeholder="Phone No"> </div>
                                        <input type="hidden" name="key" id="key" value="<?php echo $this->session->userdata('Encodekey');?>" />
                                </div>

                                <div class="input-group mb-4">
                                    <input type="hidden" id="h_password" />
                                    <input type="password" class="form-control" name="password" id="password" placeholder="Password" aria-label="Password" aria-describedby="basic-addon2">
                                    <div class="input-group-append">
                                        <span class="input-group-text" id="show"><i class="fa fa-eye-slash"></i></span>
                                    </div>
                                </div>
                               
                                
                                <div id="lmsgbox"><?php echo $this->session->flashdata('message'); ?></div>
                                <div class="progress hidden progress-lg"  id="login-progress">
                                    <div id="login-progress-text" class="progress-bar bg-warning progress-bar-striped progress-bar-animated" role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" style="width: 100%">
                                    Please wait...
                                    </div>
                                </div>

                                <div class="form-group text-center mt-4">
                                    <div class="col-xs-12">
                                        <button class="btn btn-info btn-lg btn-block text-uppercase waves-effect waves-light" type="submit">Log In</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- ============================================================== -->
        <!-- Login box.scss -->
        <!-- ============================================================== -->
        <!-- ============================================================== -->
        <!-- Page wrapper scss in scafholding.scss -->
        <!-- ============================================================== -->
        <!-- ============================================================== -->
        <!-- Page wrapper scss in scafholding.scss -->
        <!-- ============================================================== -->
        <!-- ============================================================== -->
        <!-- Right Sidebar -->
        <!-- ============================================================== -->
        <!-- ============================================================== -->
        <!-- Right Sidebar -->
        <!-- ============================================================== -->
    </div>
    <!-- ============================================================== -->
    <!-- All Required js -->
    <!-- ============================================================== -->
    <script src="<?=asset_url()?>js/jquery.min.js"></script>
    <!-- Bootstrap tether Core JavaScript -->
    <script src="<?=asset_url()?>js/popper.min.js"></script>
    <script src="<?=asset_url()?>js/bootstrap.min.js"></script>
    <script src="<?php echo asset_url(); ?>js/base64-utf8.module.js" type="text/javascript"></script>
    <!--
    <script src="https://www.google.com/recaptcha/api.js?render=6LdH1tMZAAAAAJbeGswkOenXLAT-ap1gQw_nIOt6"></script>
    -->
    <!-- ============================================================== -->
    <!-- This page plugin js -->
    <!-- ============================================================== -->
    <script>
    $(document).ready(function() {
		
        $('[data-toggle="tooltip"]').tooltip();
        $(".preloader").fadeOut();
        // ============================================================== 
        // Login and Recover Password 
        // ============================================================== 
        $('#to-recover').on("click", function() {
            $("#loginform").slideUp();
            $("#recoverform").fadeIn();
        });
    
    });

    $('body').on('keyup',".onlynumbers", function(event){
	    this.value = this.value.replace(/[^[0-9]]*/gi, '');
	});

    function login(){
		var phone = $("#phone").val();
		var password = $("#password").val();		 
		var key = $("#key").val().replace(/\s+/g, '');
        	 
		$("#lmsgbox").html('');
		//alert(email);alert(password);
		//.removeClass().addClass("progress-bar-success");

		if($.trim(phone) == ""){
			$("#lmsgbox").html('<div class="alert alert-danger alert-dismissable"><button class="close" aria-hidden="true" data-dismiss="alert" type="button">×</button>Enter Phone No.</div>');
		}else if($.trim(password) == ""){
			$("#lmsgbox").html('<div class="alert alert-danger alert-dismissable"><button class="close" aria-hidden="true" data-dismiss="alert" type="button">×</button>Enter Password.</div>');			
		}else{
            $("#login-progress").removeClass("hidden").show();
			//alert();
			$("#h_password").val(password);
			password = btoa(key+" "+password);
			$("#password").val(password);
            var post_data = {phone:phone,password:password};
            
		    $.post('<?php echo base_url();?>login/checklogin',post_data,function(data) {			        	 
		        // alert(data);
		        if(data == 1){
		            //$("#lmsgbox").html('<div class="alert alert-success alert-dismissable"><button class="close" aria-hidden="true" data-dismiss="alert" type="button">×</button>Login successful. Redirecting...</div>');
	                $("#login-progress-text").removeClass("progress-bar-warning").addClass("progress-bar-success").html("Log in...");
		            location.reload();     
		        }else{
		            $("#password").val($("#h_password").val());
		        	$("#login-progress").addClass("hidden");
	            	$("#lmsgbox").html('<div class="alert alert-danger alert-dismissable"><button class="close" aria-hidden="true" data-dismiss="alert" type="button">&times;</button>'+data+'</div>');
	            }
		    });
		}
		return false;
	}
    

    function forgotpass(){
		var email = $("#femail").val();
		$("#forgot-progress").removeClass("hidden");
		//$("#fmsgbox").html('<div class="alert alert-warning alert-dismissable"><button class="close" aria-hidden="true" data-dismiss="alert" type="button">×</button>Please wait...</div>');
		$("#fmsgbox").html("");
		if($.trim(email) == ""){
			$("#fmsgbox").html('<div class="alert alert-danger alert-dismissable"><button class="close" aria-hidden="true" data-dismiss="alert" type="button">×</button>Enter Email ID.</div>');
		}
		else if(!emailReg.test(email)){
			 $("#forgot-progress").addClass("hidden");
			$("#fmsgbox").html('<div class="alert alert-danger alert-dismissable"><button class="close" aria-hidden="true" data-dismiss="alert" type="button">&times;</button>Enter Valid Email ID.</div>');
		}
		else{
			 $.post('<?php echo base_url();?>wllogin/forgotPass',{email:email},function(data) {			        	 
				 $("#forgot-progress").addClass("hidden");
					if(parseInt(data) == 1)
					{
	                    
	                    $("#fmsgbox").html('<div class="alert alert-success alert-dismissable"><button class="close" aria-hidden="true" data-dismiss="alert" type="button">&times</button>Check your Email for the credentials.</div>');
	                	$("#femail").val('');
	                    
	                }
	                else{
	                	$("#fmsgbox").html('<div class="alert alert-danger alert-dismissable"><button class="close" aria-hidden="true" data-dismiss="alert" type="button">&times;</button>Invalid Email ID.</div>');
	                }
		     });
		}
		return false;
	}

    $(function(){
        $('#show').click(function(){
            if( $('#password').attr('type') == 'password' ){
                $('#password').attr('type','text');
                $('#show').html('<i class="fa fa-eye"></i>');
            }else if( $('#password').attr('type') == 'text' ){
                $('#password').attr('type','password');
                $('#show').html('<i class="fa fa-eye-slash"></i>');
            }
        });
    });

    /*
    function loadRecaptacha(){
        grecaptcha.ready(function() {
                grecaptcha.execute('6LdH1tMZAAAAAJbeGswkOenXLAT-ap1gQw_nIOt6', {action: 'submit'}).then(function(token) {
                    // Add your logic to submit to your backend server here.
                    console.log(token)
                    $('#token').val(token); 
                });
            });
    }
    */

    </script>
</body>

</html>