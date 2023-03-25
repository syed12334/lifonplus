<script type="text/javascript">
	var interval = 60*1000 ; // set refresh interval to 1 minute
	interval = interval*10;// set refresh interval to 15 minute
	var ajax_call = function() {
		$.get("<?php echo base_url()?>timeout/getSession", function(data){
				if(data == 1){
					window.location.href="<?php echo base_url()?>login/logout";
				}
			});
		
		var strURL="<?php echo base_url()?>login/updatelogin";
		if (window.XMLHttpRequest)
	  	{// code for IE7+, Firefox, Chrome, Opera, Safari
	 		 req=new XMLHttpRequest();
	 	}
		else
	  	{// code for IE6, IE5
	  		req=new ActiveXObject("Microsoft.XMLHTTP");
	 	}
		
	  req.open("GET", strURL, false); //third parameter is set to false here
	  req.send(null);
	};

	
	var myintr = setInterval(ajax_call, interval);//handler

	</script>
	
	<style>
	
	.skin-blue .sidebar > .sidebar-menu > li > a:hover, .skin-blue .sidebar > .sidebar-menu > li.active > a {
	    color: #000;
	    background: #f9f9f9;
	}
	body > .header .navbar .sidebar-toggle{
		background-color: #648f45;
	}
	
	.skin-blue .logo:hover {
	  background: rgba(17, 160, 169, 0.09);
	}
	
	.skin-blue .navbar .navbar-right > .nav, .skin-blue .left-side {
	    background-color: #648f45;
	}
	.skin-blue .logo {
	    background-color: rgba(17, 160, 169, 0.09);
	    color: #f9f9f9;
	}
	.skin-blue .navbar {	
	    background-color: rgba(17, 160, 169, 0.09);
	}
	
	
		.textAlignLeft{
			text-align: left !important;
		}
		
		.textAlignRight{
			text-align: right !important;
		}
		
		.textAlign{
			text-align: center !important;
		}

        .select2.select2-container.select2-container--default.select2-container--below.select2-container--open.select2-container--focus, 
		.select2.select2-container.select2-container--default{
		  width:100% !important;
		}
		
		.select2-container--default .select2-selection--single, .select2-selection .select2-selection--single{
		  padding: 12px 3px;
		}
		
		.select2-container--default .select2-selection--single{
		  border-radius: inherit;
		}
		
		.select2-container .select2-selection--single{
		    height: 42px;
		}
		
		.select2-container--default .select2-selection--single .select2-selection__rendered{
		    line-height: 21px;
		}
        </style>