<style>
#custom {
  /* Not required only for visualizing */
  border-collapse: collapse;
  width: 100%;
}

#custom thead tr th {
  /* Important */
  background-color: #7fa855;
  position: sticky;
  z-index: 100;
  top: 0;
  color:white;
}
</style>
<form id="moduleForm" onsubmit="return validateForm();">
    <input type="hidden" name="package_id" id="package_id" value="<?=$package_id?>" />
    <div class="row">
        <div class="col-sm-12">
            <?php
            $modules = $this->master_db->getRecords('app_modules','status=1','id,name,status','order_no asc');
            if( count($modules) ){
                ?>
                <table class="table table-bordered" id="custom">
                    <thead>
                        <tr>
                            <th>Sl.No.</th>
                            <th>Module</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $i = 1;
                        foreach($modules as $row){
                            $submodules = $this->master_db->getRecords('app_submodules','status=1 and module_id='.$row->id,'id,name,status','order_no asc');
                            $condition = 'package_id='.$package_id.' and module_id = '.$row->id;
                            $checkmod = $this->master_db->getRecords('package_module',$condition,'id,status');
                            $action = 0;
                            if(count($checkmod) && $checkmod[0]->status){
                                $action = 1;
                            }
                            ?>
                            <tr>
                                <td><?=$i?></td>
                                <td>
                                    <?php
                                    echo $row->name;
                                    if(count($submodules)){
                                        ?>
                                        <ol>
                                            <?php
                                            if(count($submodules) ){
                                                ?>
                                                <table>
                                                        <thead>
                                                            <th>Sl.No</th>
                                                            <th>Sub Module</th>
                                                            <th>Action</th>
                                                        </thead>
                                                        <tbody>
                                                            <?php
                                                            $j = 1;
                                                            foreach($submodules as $sub){
                                                                $condition = 'package_id='.$package_id.' and module_id = '.$row->id.' and submodule_id = '.$sub->id;
                                                                $checksub = $this->master_db->getRecords('package_submodule',$condition,'id,status');
                                                                $subaction = 0;
                                                                if(count($checksub) && $checksub[0]->status ){
                                                                    $subaction = 1;
                                                                }
                                                                ?>
                                                                <tr>
                                                                    <td><?=$j?></td>
                                                                    <td>
                                                                        <?=$sub->name?>
                                                                        <input type="hidden" name="submodule_<?=$row->id?>[]" value="<?=$sub->id?>" />
                                                                    </td>
                                                                    <td>
                                                                        <label><input type="radio" name="action_<?=$row->id?>_<?=$sub->id?>" value="1" <?php if( $subaction == 1 ){ echo 'checked'; }?> /> YES</label>&emsp;
                                                                        <label><input type="radio" name="action_<?=$row->id?>_<?=$sub->id?>" value="0" <?php if( $subaction == 0 ){ echo 'checked'; }?> /> NO</label>
                                                                    </td>
                                                                </tr>
                                                                <?php
                                                                $j++;
                                                            }
                                                            ?>
                                                        </tbody>
                                                    </table>
                                                <?php
                                            }
                                            
                                        ?>
                                        </ol>
                                        <?php
                                    }
                                    ?>
                                </td>
                                <td>
                                    <input type="hidden" name="module_id[]" value="<?=$row->id?>" />
                                    <label><input type="radio" name="action_<?=$row->id?>" value="1" <?php if( $action == 1 ){ echo 'checked'; }?> /> YES</label>&emsp;
                                    <label><input type="radio" name="action_<?=$row->id?>" value="0" <?php if( $action == 0 ){ echo 'checked'; }?> /> NO</label>
                                </td>
                            </tr>
                            <?php
                            $i++;
                        }
                        ?>
                    </tbody>
                </table>
                <?php
            }
            ?>
        </div>
        <div class="col-sm-12 text-center">
            <button type="submit" class="btn btn-success"><i class="fa fa-check"></i> Submit</button>
        </div>
    </div>
</form>
<script>
function validateForm(){

    Swal.fire({
        text: 'Are you sure want to submit?',
        type: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Submit'
    }).then((result) => {
        if (result.value) {
            //window.location.href = "<?=base_url().'master/editpackage?id='?>"+id;
            Swal.fire({
                allowOutsideClick: false,
                html : '<i class="fas fa-spinner fa-spin"></i> Loading please wait...',
                buttons: false,
                showConfirmButton: false,
            });
            $.ajax({                
                url: "<?=base_url().'master/savePackageModules'?>",
                type: "post",
                data:  $('#moduleForm').serialize() ,
                dataType : 'html',
                success: function (response) {
                    console.log(response);
                    if( response == '1' ){
                        Swal.fire('Saved successfully').then((result) => { $('#viewModal').modal('hide'); });
                    }
					else if( response == '-1' ){
                        Swal.fire('Package not found');
                    }else if( response == '1' ){
                        Swal.fire('Required fields are missing');
                    }
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    Swal.fire({
                        type: 'error',
                        title: '',
                        text: 'Something went wrong!',
                    })
                }
            });
        }
    });

    return false;
}
</script>