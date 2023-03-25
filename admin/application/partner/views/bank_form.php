<?php
$bank_name = $account_no = $ifsc = $branch = '';
if( count($bank) ){
    $bank_name = $bank[0]->bank_name;
    $account_no = $bank[0]->account_no;
    $ifsc = $bank[0]->ifsc_code;
    $branch = $bank[0]->branch_name;
}
?>
<form class="form-horizontal" id="bank_form" onsubmit="return validateForm();">
    <div class="card-body">
        <h4 class="card-title">Bank Details Form</h4>
        <div class="form-group row">
            <label for="fname" class="col-sm-3 text-right control-label col-form-label">Bank Name</label>
            <div class="col-sm-6">
                <input type="text" class="form-control" id="bname" name="bname" placeholder="Bank Name Here" maxlength="100" required value="<?=$bank_name?>">
            </div>
        </div>
        <div class="form-group row">
            <label for="lname" class="col-sm-3 text-right control-label col-form-label">Account No</label>
            <div class="col-sm-6">
                <input type="text" class="form-control onlynumbers" id="account_no" name="account_no" placeholder="Account No Here" maxlength="20" required value="<?=$account_no?>">
            </div>
        </div>
        <div class="form-group row">
            <label for="email1" class="col-sm-3 text-right control-label col-form-label">IFSC Code</label>
            <div class="col-sm-6">
                <input type="text" class="form-control" id="ifsc" name="ifsc" maxlength="20" placeholder="IFSC Code Here" required value="<?=$ifsc?>">
            </div>
        </div>
        <div class="form-group row">
            <label for="cono1" class="col-sm-3 text-right control-label col-form-label">Branch Name</label>
            <div class="col-sm-6">
                <input type="text" class="form-control" id="branch" name="branch" placeholder="Branch Name Here" maxlength="100" required value="<?=$branch?>">
            </div>
        </div>
        <hr>
        <div class="form-group row">
            <div class="col-sm-12 text-right">
                <button type="submit" class="btn btn-info waves-effect waves-light"><i class="fa fa-check"></i> Save</button>
                <button type="button" class="btn btn-dark waves-effect waves-light" data-dismiss="modal">Cancel</button>
            </div>
        </div>
    </div>
</form>
<script src="<?php echo asset_url();?>js/jquery.validate.min.js"></script>
<script>
    $('body').on('keyup',"#ifsc", function(event){
        this.value = this.value.replace(/[^[A-Za-z0-9]]*/gi, '');
    });

    $(document).ready(function(){
        var v = $("#bank_form").validate({                
            errorClass: "help-block", 
            errorElement: 'span',
            onkeyup: false,
            onblur: true,
            rules: {},
            messages: {},
            onfocusout: function(element) {$(element).valid()},
            errorElement: 'span',
            highlight: function (element, errorClass, validClass) {
                $(element).parents('.form-group').addClass('has-error');
            },
            unhighlight: function (element, errorClass, validClass) {
                $(element).parents('.form-group').removeClass('has-error');
            }			        		    
        });
    });

    function validateForm(){
        $.ajax({
            url: "<?=base_url().'myprofile/saveBankForm'?>",
            type: "post",
            data:$('#bank_form').serialize(),
            dataType : 'html',
            success: function (response) {
                //console.log(response);
                if( response == '1' ){
                    Swal.fire('Saved successfully');
                    window.location.reload();
                }else if( response == '0' ){
                    Swal.fire({
                        type: 'error',
                        text: 'Required fields are missing',
                    });
                }
            },
            error: function(jqXHR, textStatus, errorThrown) {
                Swal.fire({
                    type: 'error',
                    text: 'Something went wrong!',
                });
            }
        });
        return false;
    }
</script>