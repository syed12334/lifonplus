	<script src="<?=asset_url()?>js/jquery.min.js"></script>
    <!-- Bootstrap tether Core JavaScript -->
    <script src="<?=asset_url()?>js/popper.min.js"></script>
    <script src="<?=asset_url()?>js/bootstrap.min.js"></script>
    <!-- apps -->
    <script src="<?=asset_url()?>js/app.min.js"></script>
    <script src="<?=asset_url()?>js/app.init.mini-sidebar.js"></script>
    <script src="<?=asset_url()?>js/app-style-switcher.js"></script>
    <!-- slimscrollbar scrollbar JavaScript -->
    <script src="<?=asset_url()?>js/perfect-scrollbar/dist/perfect-scrollbar.jquery.min.js"></script>
    <script src="<?=asset_url()?>js/extra-libs/sparkline/sparkline.js"></script>
    <!--Wave Effects -->
    <script src="<?=asset_url()?>js/waves.js"></script>
    <!--Menu sidebar -->
    <script src="<?=asset_url()?>js/sidebarmenu.js"></script>
    <!--Custom JavaScript -->
    <script src="<?=asset_url()?>js/custom.min.js"></script>

    <script src="<?=asset_url()?>js/sweetalert2/dist/sweetalert2.all.min.js"></script>
    <script src="<?=asset_url()?>js/extra-libs/sweetalert2/sweet-alert.init.js"></script>
    <style>
      .error{
        color:red;
      }
    </style>
	<script type="text/javascript">
	   $('body').on('keyup',".onlynumbers", function(event){
	         this.value = this.value.replace(/[^[0-9]]*/gi, '');
	  });
	  $('body').on('keypress',".floatval", function(event){
		 var charCode = (event.which) ? event.which : event.keyCode
		 if(charCode ==8 || charCode ==9){

		 }
		 else if ((charCode != 46 || $(this).val().indexOf('.') != -1) && (charCode < 48 || charCode > 57)) {
			event.preventDefault();
		  }
	  });

    $(document).ready(function(){
      $('form').on('keyup keypress', function(e) {
        var keyCode = e.keyCode || e.which;
        if (keyCode === 13) { 
          e.preventDefault();
          return false;
        }
      });
    });
	</script>