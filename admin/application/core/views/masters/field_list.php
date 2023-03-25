<hr>
<div class="row">
    <!--
    <div class="col-md-4">
        <label for="card_type">Select Card Type</label>
        <div class="d-flex">
            <select name="type" id="type" class="form-control">
                <option value="">--Select--</option>
                <option value="1">Date</option>
                <option value="2">Time</option>
                <option value="3">Input(Numbers only)</option>
                <option value="4">Textarea</option>
            </select>
            <button class="btn btn-info" type="button" title="Add Field" onclick="addField()"><i class="fa fa-plus"></i></button>
        </div>
    </div>
    -->
    <div class="col-md-12">
        <button class="btn btn-info" type="button" title="Add Field" onclick="addField()"><i class="fa fa-plus"></i> Add Field</button>
        <table class="table table-bordered" id="fieldTable">
            <thead>
                <tr>
                    <th width="10%">Sl.No.</th>
                    <th width="10%">Order No</th>
                    <th width="20%">Field Type</th>
                    <th width="20%">Field Label</th>
                    <th width="10%">Mandatory</th>
                    <th width="20%">Note</th>
                    <th width="10%">Action</th>
                </tr>
            </thead>
            <tbody>
                <?php
                    $i = 1;
                    foreach($fields as $row){
                        ?>
                        <tr id='row_"<?=$row->id?>"' >
                            <td><?=$i?></td>
                            <td>
                                <input type='hidden' name='action[]' value='<?=$row->id?>' />
                                <input type='text' name='order[]' value='<?=$row->order_no?>' class='form-control onlynumbers' maxlength='100' />
                            </td>
                            <td class='text-center'>
                                <select name="fieldtype[]" class="form-control">
                                    <option value="1" <?php if($row->type==1){echo 'selected';} ?> >Date</option>
                                    <option value="2" <?php if($row->type==2){echo 'selected';} ?> >Time</option>
                                    <option value="3" <?php if($row->type==3){echo 'selected';} ?> >Input(Numbers only)</option>
                                    <option value="4" <?php if($row->type==4){echo 'selected';} ?> >Textarea</option>
                                </select>
                            </td>
                            <td><input type='text' name='label[]' value='<?=$row->label?>' class='form-control' maxlength='100' /></td>
                            <td class='text-center'>
                                <select name='req[]' class='form-control' >
                                    <option value='0' <?php if($row->is_required==0){echo 'selected';} ?>>No</option>
                                    <option value='1' <?php if($row->is_required==1){echo 'selected';} ?>>Yes</option>
                                </select>
                            </td>
                            <td><input type='text' name='note[]' value='<?=$row->note?>' class='form-control' maxlength='50' /></td>
                            <td class='text-center'><a class='btn btn-sm btn-warning' onclick='removeField(<?=$row->id?>,1)'><i class='fa fa-trash'></i></a></td>
                        </tr>
                        <?php
                        $i++;
                    }
                ?>
            </tbody>
        </table>
    </div>
    <div class="col-md-12 text-center">
        <button class="btn btn-success" type="button" title="Save Fields" onclick="saveField()"><i class="fa fa-check"></i> Submit</button>
    </div>
</div>
<script>
function addField(){

    var len = $('#fieldTable tbody tr').length+1;
    var output = "";
    output = "<tr id='row_"+len+"' type='new' >";
    output += "<td>"+len+"</td>";
    //output += "<td><input type='hidden' name='fieldtype[]' value='"+$("#type").val()+"' />";
    
    output += "<td>";
    output += "<input type='hidden' name='action[]' value='new' />";
    output += "<input type='text' name='order[]' value='' class='form-control onlynumbers' maxlength='100' /></td>";
    
    //output += "<td class='text-center'>"+$("#type option:selected").text();+"</td>";

    output += "<td class='text-center'>";
    output += "<select name='fieldtype[]' class='form-control'>";
    output += "<option value=''>--Select--</option>";
    output += "<option value='1'>Date</option>";
    output += "<option value='2'>Time</option>";
    output += "<option value='3'>Input(Numbers only)</option>";
    output += "<option value='4'>Textarea</option>";
    output += "</select></td>";
    
    output += "<td><input type='text' name='label[]' value='' class='form-control' maxlength='100' /></td>";
    output += "<td class='text-center'><select name='req[]' class='form-control' ><option value='0'>No</option><option value='1'>Yes</option></select>";
                //"<input type='checkbox' name='req[]' value='1' /></td>";

    output += "<td><input type='text' name='note[]' value='' class='form-control' maxlength='50' /></td>";
    output += "<td class='text-center'><a class='btn btn-sm btn-warning' onclick='removeField("+len+",0)'><i class='fa fa-trash'></i></a></td>";
    output += "</tr>";
    output += "";
    //console.log(output);return false;
    $('#fieldTable tbody').append(output);

}

function removeField(id,type){
    Swal.fire({
        title: '',
        text: 'Are you sure want to remove field?',
        type: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Submit'
    }).then((result) => {
        if( $('#row_'+id).length ){ $('#row_'+id).remove(); }
        if( type ){
            Swal.fire({
                allowOutsideClick: false,
                html : '<i class="fas fa-spinner fa-spin"></i> Deleting please wait...',
                buttons: false,
                showConfirmButton: false,
            });

            $.ajax({
                url: "<?=base_url().'master/setServiceFieldStatus'?>",
                type: "post",
                data:  {field_id:id,service_id:$('#service_id').val()} ,
                dataType : 'html',
                success: function (response) {
                    getServiceFields();
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
}

function refershTable(){
    var i = 1;
    $('#fieldTable tbody tr').each(function(){
        console.log(this.id);
        //$('#row_'+this.id+' td:first-child').html(i);
        i++;
    });
}

function saveField(){
    if( $('#fieldTable tbody tr').length == 0 ){
        Swal.fire('Add fields to proceed');
        return false;
    }

    var data = [];
    var status = true;
    var i = 0;
    $("select[name='fieldtype[]']").each(function(){
        var rowdata = '';
        if( status ){

            var order = $.trim($('input[name="order[]"]:eq('+i+')').val());
            if( order == '' ){
                Swal.fire('Enter order');
                status = false;
                return false;
            }//console.log('Order : '+order);
            //rowdata = 'order='+order;

            var fieldtype = $.trim($('select[name="fieldtype[]"]:eq('+i+')').val());
            if( fieldtype == '' ){
                Swal.fire('Select field type');
                status = false;
                return false;
            }

            var label = $.trim($('input[name="label[]"]:eq('+i+')').val());
            if( label == '' ){
                Swal.fire('Enter field label');
                status = false;
                return false;
            }//console.log('Label : '+label);
            //rowdata += ',label='+label;

            if( $('input[name="req[]"]:eq('+i+')').val() == '' ){
                Swal.fire('Select field mandatory');
                status = false;
                return false;
            }
            //data.push(rowdata);
        }else{
            return false;
        }        
        i++;
    });

    var postdata = $('#category_form').serialize();
    //console.log(postdata);return false;
    if( status ){
        Swal.fire({
            allowOutsideClick: false,
            html : '<i class="fas fa-spinner fa-spin"></i> Saving please wait...',
            buttons: false,
            showConfirmButton: false,
        });

        $.ajax({
            url: "<?=base_url().'master/saveServiceField'?>",
            type: "post",
            data:  postdata ,
            dataType : 'html',
            success: function (response) {
                console.log(response)
                getServiceFields();
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
}
</script>
