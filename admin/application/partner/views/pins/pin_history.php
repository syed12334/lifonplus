<div class="row">
    <div class="col-sm-12">
        <label>Pin Type : <?=$pin[0]->pintype?></label><br>
        <?php
        if( intval($pin[0]->type) == 1 ){
            ?>
            <label>Package Name : <?=$pin[0]->package?></label><br>
            <?php
        }else if( intval($pin[0]->type) == 2 ){
            ?>
            <label>Category : <?=$pin[0]->category?></label><br>
            <label>Subcategory : <?=$pin[0]->subcategory?></label><br>
            <label>Equipment/Item : <?=$pin[0]->item?></label><br>
            <?php
        }else if( intval($pin[0]->type) == 3 ){
            ?>
            <label>Category : <?=$pin[0]->category?></label><br>
            <label>Subcategory : <?=$pin[0]->subcategory?></label><br>
            <label>Service : <?=$pin[0]->service?></label><br>
            <?php
        }
        ?>
        <label>Qty : <?=$pin[0]->qty?></label><br>        
    </div>
</div>
<div class="row">
    <div class="col-sm-12">
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Sl.No.</th>
                    <th>Type</th>
                    <th>QTY</th>
                    <th>Date Time</th>
                    <th>TXN ID</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $i = 1;
                foreach($history as $row){
                ?>
                <tr>
                    <td><?=$i?></td>
                    <td>
                        <?php
                        if( $row->action == 1 ){ echo "Pin Added";}
                        else if( $row->action == 2 ){ echo "Pin Transfered";}
                        ?>
                    </td>
                    <td><?=$row->qty?></td>
                    <td><?=$row->created_at?></td>
                    <td>
                        <?php 
                        if( intval($row->txn_id) == 0 ){
                            echo '---';
                        }else{
                            echo '---';
                        }
                        ?>
                    </td>
                </tr>
                <?php
                $i++;
                }   
                ?>
            </tbody>
        </table>
    </div>
</div>