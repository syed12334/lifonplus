<!DOCTYPE html>
<html class="skin-blue" style="">
    <head>
        <meta charset="UTF-8">
        <title><?php echo title;?></title>
        <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
        <link rel="icon" type="image/png" href="<?php echo asset_url();?>images/myfevicon.png" />
        <!-- bootstrap 3.0.2 -->
        <link href="<?php echo asset_url();?>css/bootstrap.min.css" rel="stylesheet" type="text/css" />
        <!-- font Awesome -->
        <link href="<?php echo asset_url();?>css/font-awesome.min.css" rel="stylesheet" type="text/css" />
        <!-- Theme style -->
        <link href="<?php echo asset_url();?>css/AdminLTE.css" rel="stylesheet" type="text/css" />
        <link href="<?php echo asset_url();?>css/login.css" rel="stylesheet" type="text/css" />

        <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
          <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
          <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
        <![endif]-->
       <style type="text/css">
        .skin-blue{
        	background-color: #D0D0D0  !important;
        }
        .form-box1{
	        margin: 36px auto 0;
	        width: 360px;
        }
		.login_img {
			background-color: rgba(255,255,255,0.9);
			padding: 20px 0;
			border-radius: 135px;
			margin-bottom: 35px;
			box-shadow: 1px 1px 21px 1px rgba(255,255,255,0.9);
		}
		
		.right-footer-power {
			position: fixed;
			bottom: 20px;
			right: 55px;
			color: #fff;
			font-size: 12px;
		}
		
		
		
		.right-footer-power img {
			width: 22px;
			float: left;
			margin: -4px 10px 0 0;
		}
		
		
		.bgloj img {
			width: 150px;
		}
		.bgloj {
			background-color: rgba(0,0,0,0.4);
			margin-bottom: 35px;
			padding: 25px;
		
		}
		.eschool {
			text-align: right;
		}
		
		.form-box .header {
			background-color: transparent;
			box-shadow: none;
			padding: 10px 0 0 0;
			text-transform: uppercase;
			font-weight: 600;
			font-size: 24px;
		}
        </style>
   </head>
   
   <body class="skin-blue" >
		
        <div class="form-box" id="login-box">
        <div align="center" class="bgloj">
        	<img class="img-responsive" src="<?php echo asset_url()?>images/logo.png">
        	<div class="header">National Public School</div>
            <div class="eschool"><span class="text-orange">e</span><span class="text-blue">School</span></div>
       	</div>
        <!--<div class="header">Divecha Center for Climate Change</div>-->
       	<div id="login">
            
            <form action="<?php echo base_url();?>" method="post" class="form-element" onsubmit="return login();">
            
                <div class="body">
                <div id="lmsgbox"><?php echo $this->session->flashdata('message'); ?></div>
			<div class="progress hidden"  id="login-progress">
		        <div id="login-progress-text" class="progress-bar progress-bar-warning progress-bar-striped active" role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" style="width: 100%">
		           Please wait...
		        </div>
		    </div>
                    <div class="form-group rrd">
                    <i class="fa fa-user" aria-hidden="true"></i>
                        <input type="text" class="form-control" placeholder="Username" name="username" id="username" required/>
                    </div>
                    <div class="form-group rrd">
                    	<i class="fa fa-lock" aria-hidden="true"></i>
                        <input type="password" class="form-control" placeholder="Password" name="password" id="password" required/>
                    </div>          
                    
                </div>
                <div class="footer">                                                               
                    <button type="submit" class="btn bg-blue btn-block">Sign me in</button>  
                    
                    <p class="text-right"><a href="javascript:void(0)" class="get_password">Forgot Password?</a></p>
                </div>
            </form>
           
            </div>
            <br/><br/>
           <!-- <div><p class="text-right" style="color:#fff;">Powered by Acadamis</p></div>-->

            <div id="forgot" style="display: none;">
            <!--<div class="header">Forgot Password</div>-->
            <form action="<?php echo base_url();?>" method="post" class="form-element" onsubmit="return forgotpass();">
            
                <div class="body">
                <div id="fmsgbox"></div>
			<div class="progress hidden"  id="forgot-progress">
		        <div class="progress-bar progress-bar-warning progress-bar-striped active" role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" style="width: 100%">
		           Please wait...
		        </div>
		    </div>
                    <?php /*?><div class="form-group">
                        <input type="email" placeholder="Email ID" class="form-control popupvalues" name="femail" id="femail"  />
                    </div>*/?>
                    <p class="contact"><strong>Please Contact</strong> <br/> <i class="fa fa-envelope" aria-hidden="true"></i> forgotpassword@nps.com </p>
                    
                </div>
                <div class="footer">                                                               
                   <?php /*?> <button type="submit" class="btn bg-olive btn-block">Get Password</button>  */?>
                    
                    <p class="text-center"><a href="javascript:void(0);" class="color-white get_login"><i class="fa fa-long-arrow-left" aria-hidden="true"></i> Click Here to Login</a></p>
                </div>
            </form>
            </div>

            
        </div>
        <div id="msgbox" class="form-box1" ></div>
        
        <!--<span class="right-footer-power"><img src="<?php echo asset_url()?>/images/logo_sm.png"> Powered by NPS</span>-->
		<span class="right-footer-power"><img src="<?php echo asset_url()?>/images/logo_sm.png"> Powered by <span class="text-blue">NPS</span> - <span class="text-orange">e</span><span class="text-blue">School</span>  </span>
        
        <!-- jQuery 2.0.2 -->
        <script src="<?php echo asset_url();?>js/jquery.min.js" type="text/javascript"></script>
        <!-- Bootstrap -->
        <script src="<?php echo asset_url();?>js/bootstrap.min.js" type="text/javascript"></script>   
        
        <script type="text/javascript">
    var emailReg = /^([\w-\.]+@([\w-]+\.)+[\w-]{2,4})?$/; 
    $(document).ready(function(){
 	   $('.get_password').click(function(e){			
 			$('#login,#login-progress,#forgot-progress').hide();
 			$('#forgot').show();
 			$(".popupvalues").val('');
 			$('#fmsgbox, #lmsgbox').html('');
 		});

 	   $('.get_login').click(function(e){
 		   $('#forgot,#login-progress,#forgot-progress').hide();
 		  	$('#login').show();			
 			$(".popupvalues").val('');
 			$('#fmsgbox, #lmsgbox').html('');
 		});
    });


    function login(){
		var email = $("#username").val();
		var password = $("#password").val();		 
		$("#login-progress").removeClass("hidden").show();
		$("#lmsgbox").html('');
		//alert(email);alert(password);
		//.removeClass().addClass("progress-bar-success");
		//$("#lmsgbox").html('<div class="alert alert-warning alert-dismissable"><button class="close" aria-hidden="true" data-dismiss="alert" type="button">×</button>Please wait...</div>');
		if($.trim(email) == ""){
			//$("#lmsgbox").html('<div class="alert alert-danger alert-dismissable"><button class="close" aria-hidden="true" data-dismiss="alert" type="button">×</button>Enter Email ID.</div>');
		}
		else if($.trim(password) == ""){
			//$("#lmsgbox").html('<div class="alert alert-danger alert-dismissable"><button class="close" aria-hidden="true" data-dismiss="alert" type="button">×</button>Enter Password.</div>');			
		}
		else{
			//alert();
			 $.post('<?php echo base_url();?>login/checklogin',{username:email,password:password},function(data) {			        	 
		               // alert(data);
		                if(data == 1)
		                {
		                    //$("#lmsgbox").html('<div class="alert alert-success alert-dismissable"><button class="close" aria-hidden="true" data-dismiss="alert" type="button">×</button>Login successful. Redirecting...</div>');
		                    $("#login-progress-text").removeClass("progress-bar-warning").addClass("progress-bar-success").html("Log in...");
		                    location.reload();     
		                    
		                }
		                else{
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
    </script>     

    </body>
</html>