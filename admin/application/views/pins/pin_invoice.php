<?php //echo "<pre>";print_r($transfer);exit; ?>
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
        <title><?php echo $company[0]->name;?></title>
        <!-- This page plugin CSS -->
        <link href="<?=asset_url()?>css/dataTables.bootstrap4.css" rel="stylesheet">
        <!-- Custom CSS -->
        <link href="<?=asset_url()?>css/style.min.css" rel="stylesheet">
        <link rel="stylesheet" type="text/css" href="<?=asset_url()?>select2/dist/css/select2.min.css">
    </head>
    <body> 
    <body>
        <div align="center">
            <button type="button" class="btn btn-success" onclick="PrintDiv();" ><i class="fa fa-save"></i> Print </button>&nbsp;&nbsp;
            <button type="button" class="btn btn-danger pull-right" onclick="window.location.href='<?php echo base_url() ?>pin/transfer'"><i class="fa fa-save"></i> Go back </button>
        </div><br><br>
	    <div id="divToPrint">
            <table style="width:100%; border:2px solid #18306c; padding:2px; font-family: 'Times New Roman', cursive;" cellspacing="0" cellpadding="0">
                <tbody>
                    <tr>
                        <td style="padding:2px;" valign="top">
                            <table style="width:100%; text-align:center;" cellspacing="0" cellpadding="0">
                                <tbody>
                                    <tr>
                                        <td style="padding:2px;text-align: left;" width="20%" valign="top">
                                            <h2 style="margin:4px 0;  font-size:14px; color:black;text-align: left;">PAN: <?=$company[0]->pan_no?> </h2>
                                        </td>
                                        <td style="padding:2px;text-align: center;" width="35%" valign="top">                
                                            <h2 style="margin:4px 0;  font-size:20px; color:black;"><u>INVOICE </u></h2>
                                            <br />
                                             <img src="<?=asset_url()?>images/logo.png" id="logoimg" alt=" Logo">
                                        </td>
                                        <td style="padding:2px;text-align: right;" width="20%" valign="top">
                                            <h4 style="margin:4px 0;  font-size:14px; color:black;position: relative;">Ph: 9986880000 </h4>                                    
                                        </td>                
                                    </tr>
                                </tbody>
                            </table><br>

                            <table style="width:100%; text-align:center;" cellspacing="0" cellpadding="0">
                                <tbody>
                                    <tr>
                                        <td style="padding:2px;" width="40%" valign="top">                        
                                            <h1 style="margin:4px 0;  font-size:20px; color:black;"><?=strtoupper($company[0]->name)?></h1>
                                            <h4 style="margin:2px 0;  font-size:14px; color:black;"><?=$company[0]->address?></h4>
                                            <h2 style="margin:2px 0;  font-size:14px; color:black;"><?=$company[0]->email?></h2>           
                                            <h4 style="margin:2px 0;  font-size:14px; color:black; font-weight: bolder;">GSTIN: <?=$company[0]->gst_no?></h4>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>

                            <table style="width:100%;" cellspacing="0" cellpadding="0">
                                <tbody>
                                    <tr>
                                        <td style="padding:2px;float: left;" width="45%" valign="top">
                                            <span style="font-size: 12px;">To,</span>
                                            <h2 style="margin:4px 0;  font-size:15px; color:black;"><?=$partner[0]->company_name?> </h2>
                                            <h4 style="margin:4px 0;  font-size:14px; color:black;font-weight: normal;"><?=$partner[0]->address?></h4>
                                            <h4 style="margin:4px 0;  font-size:14px; color:black;font-weight: normal;">Code - <?=$partner[0]->code?></h4>
                                            <h4 style="margin:2px 0;  font-size:12px; color:black;font-weight: normal;">GST: <?=$partner[0]->gst_no?></h4>
                                        </td>
                                        <td style="text-align: right;" width="28%" valign="top">
                                            <h2 style="margin:4px 0;  font-size:15px; color:black;text-align: left;">Invoice No: <?=$transfer->txn_no?> </h2>
                                            <h4 style="margin:4px 0;  font-size:14px; color:black;text-align: left;">Date: <?=date('d-m-Y',strtotime($transfer->created_at))?></h4>
                                        </td>
                                    </tr>
                                </tbody>
                            </table><br><br>
                                <div style="float: right;margin-bottom: 20px">
                                    <input type="text" name="discount" placeholder="Enter Discount" id="discount" style="padding:8px 12px;border-radius: 5px">
                                    <input type="hidden" name="tid" id="tid" value="<?= $transfer->id;?>">
                                </div> 

                            <table style="width:100%; margin:2px 0; border-top:1px solid #333; border-left:1px solid #333; font-size:14px;margin-top: -10px;margin-bottom: 1px;" width="0" cellspacing="0" cellpadding="0" border="0">
                                <tbody>
                                    <tr>
                                        <td style="padding:3px; border-bottom:1px solid #333; border-right:1px solid #333; font-size:14px; background-color:#bfbfbf;" width="5%" align="center"><strong> Sl.No. </strong> </td>
                                        <td style="padding:3px; border-bottom:1px solid #333; border-right:1px solid #333; font-size:14px; background-color:#bfbfbf;text-align: center;" width="32%"><strong> PIN</strong> </td>
                                        <td style="padding:3px; border-bottom:1px solid #333; border-right:1px solid #333; font-size:14px; background-color:#bfbfbf;" width="8%" align="center"><strong> Qty </strong> </td>
                                        <td style="padding:3px; border-bottom:1px solid #333; border-right:1px solid #333; font-size:14px; background-color:#bfbfbf;" width="5%" align="center"><strong> GST </strong> </td>
                                        <td style="padding:3px; border-bottom:1px solid #333; border-right:1px solid #333; font-size:14px; background-color:#bfbfbf;" width="5%" align="center"><strong> Rate </strong> </td>                                        
                                        <td style="padding:3px; border-bottom:1px solid #333; border-right:1px solid #333; font-size:14px; background-color:#bfbfbf;" width="5%" align="center"><strong> Amount</strong> </td>
                                    </tr>
                                    <tr>
                                        <td style="padding:3px; border-bottom:1px solid #333; border-right:1px solid #333;" align="center">1 </td>
                                        <td style="padding:10px; border-bottom:1px solid #333; border-right:1px solid #333;" align="center"> 
                                            <b><?=$pin[0]->pintype?> - 
                                            <?php
                                            if( $pin[0]->type == 1 ){
                                                echo $pin[0]->package;
                                            }else if( $pin[0]->type == 2 ){
                                                echo $pin[0]->service;
                                            }else if( $pin[0]->type == 3 ){
                                                echo $pin[0]->item;
                                            }
                                            ?></b>
                                        </td>
                                        <td style="padding:3px; border-bottom:1px solid #333; border-right:1px solid #333;" align="center"> <?=$pin_detail[0]->qty?></td>
                                        <td style="padding:3px; border-bottom:1px solid #333; border-right:1px solid #333;" align="center"> <?=$transfer->gst_per?></td>
                                        <td style="padding:3px; border-bottom:1px solid #333; border-right:1px solid #333;" align="center"> <?=$transfer->pin_amt?></td>                                        
                                        <td style="padding:3px; border-bottom:1px solid #333; border-right:1px solid #333;" align="center"> <?=$transfer->total_amt?></td>
                                    </tr>
                                </tbody>
                            </table>
                            <?php
                            $cgst = $sgst = $igst = 0;
                            $cgst_per = $sgst_per = $igst_per = 0;
                            if( $transfer->gst_type == 1 ){
                                $cgst = round($transfer->gst/2,2);
                                $sgst = round($transfer->gst/2,2);
                                $cgst_per = round($transfer->gst_per/2,2);
                                $sgst_per = round($transfer->gst_per/2,2);
                            }else if( $transfer->gst_type == 0 ){
                                $igst = $transfer->gst;
                                $igst_per = $transfer->gst_per;
                            }
                            ?>

                            <div id="gstBill">
                            <h2 style="font-weight: normal;float: right;font-size: 14px;">TOTAL: <?=$transfer->total_amt?></h2>
                            <table style="width:100%; margin:0px 0; font-size:14px;" width="0" cellspacing="0" cellpadding="0" border="0">
                                <tbody>
                                    <?php
                                    if( $transfer->gst_type == 1 ){
                                        ?>
                                        <tr>
                                            <td style="padding:4px; font-size:12px;text-align: left;" width="60%" align="center"><strong> &nbsp; </strong> </td>
                                            <td style="padding:4px;font-size:12px; text-align: right;" width="10%" align="center"><strong> CGST </strong> </td>
                                            <td style="padding:4px;font-size:12px;text-align: right;" width="10%" align="center"><strong> <?=$cgst?> </strong> </td>
                                        </tr>        
                                        <tr>
                                            <td style="padding:4px;font-size:12px;" width="40%" align="center">&nbsp; </td>
                                            <td style="padding:4px; font-size:12px;text-align: right;" width="20%" align="center"><strong> SGST </strong> </td>
                                            <td style="padding:4px; font-size:12px;text-align: right;" width="10%" align="center"><strong> <?=$sgst?> </strong> </td>
                                        </tr>
                                        <?php
                                    }else if( $transfer->gst_type == 0 ){
                                        ?>
                                        <tr>
                                            <td style="padding:4px;font-size:12px;" width="40%" align="center">&nbsp; </td>
                                            <td style="padding:4px; font-size:12px;text-align: right;" width="20%" align="center"><strong> IGST </strong> </td>
                                            <td style="padding:4px; font-size:12px;text-align: right;" width="10%" align="center"><strong> <?=$igst?> </strong> </td>
                                        </tr>
                                        <?php
                                    }
                                    ?>                                        
                                    <tr >
                                        <td style="padding:4px;font-size:14px;text-align: left;" width="40%" align="center">Amount Chargeable (in words)<br><h5 style="margin-top: 3px;font-size: 14px;"><b>Rs. <?=$this->home_db->convert_number($transfer->grand_total)?> Only.</b></h5></td>
                                        <td style="padding:4px; font-size:16px;text-align: right;" width="20%" align="center"><strong> GRAND TOTAL</strong> </td>
                                        <td style="padding:4px; font-size:16px;text-align: right;" width="10%" align="center"><strong> <img src="http://localhost/invoice/assets/images/rupee.png" style="width:11px;height: 11px;"><?=$transfer->grand_total?> </strong> </td>
                                    </tr>
                                </tbody>
                            </table>
                      
                            <table style="width:100%; margin:0px 0;  font-size:14px;" width="0" cellspacing="0" cellpadding="0" border="0">
                                <tbody>
                                    <tr>
                                        <td>
                                            <table style="width:100%; margin:0px 0; border-top:1px solid #333;border-bottom:1px solid #333; font-size:12px;margin-top: 15px;margin-bottom:15px;" width="0" cellspacing="0" cellpadding="0" border="0">
                                                <tbody>
                                                    <?php
                                                    if( $transfer->gst_type == 1 ){
                                                        ?>
                                                        <tr>
                                                            <td rowspan="2" style="padding:4px; font-size:10px;border-left:1px solid #333;border-right:1px solid #333;background-color:#bfbfbf;" align="center"><strong> GST TAXABLE VALUE </strong> </td>
                                                            <td colspan="2" style="padding:4px; font-size:10px;border-right:1px solid #333;border-bottom:1px solid #333;background-color:#bfbfbf;" align="center"><strong> CENTRAL TAX </strong> </td>
                                                            <td colspan="2" style="padding:4px; font-size:10px;border-right:1px solid #333;border-bottom:1px solid #333;background-color:#bfbfbf;" align="center"><strong> STATE TAX</strong> </td>
                                                            <td rowspan="2" style="padding:4px; font-size:10px;border-right:1px solid #333;background-color:#bfbfbf;" align="center"><strong> TOTAL TAX AMOUNT</strong> </td>
                                                        </tr>
                                                        <tr>
                                                            <td style="padding:4px; font-size:10px;border-right:1px solid #333;background-color:#bfbfbf;" align="center"><strong> GST </strong> </td>
                                                            <td style="padding:4px; font-size:10px;border-right:1px solid #333;background-color:#bfbfbf;" align="center"><strong> Tax Amount </strong> </td>
                                                            <td style="padding:4px; font-size:10px;border-right:1px solid #333;background-color:#bfbfbf;" align="center"><strong> GST </strong> </td>
                                                            <td style="padding:4px; font-size:10px;border-right:1px solid #333;background-color:#bfbfbf;" align="center"><strong> Tax Amount </strong> </td>
                                                        </tr>
                                                        <tr>
                                                            <td style="padding:4px; font-size:10px;border-right:1px solid #333;border-top:1px solid #333;border-left:1px solid #333;font-weight: normal;" align="center"> <?=$transfer->total_amt?> </td>
                                                            <td style="padding:4px; font-size:10px;border-right:1px solid #333;border-top:1px solid #333;font-weight: normal;" align="center"> <?=$cgst_per?>%  </td>
                                                            <td style="padding:4px; font-size:10px;border-right:1px solid #333;border-top:1px solid #333;font-weight: normal;" align="center"> <?=$cgst?>  </td>
                                                            <td style="padding:4px; font-size:10px;border-right:1px solid #333;border-top:1px solid #333;font-weight: normal;" align="center"> <?=$sgst_per?>%  </td>
                                                            <td style="padding:4px; font-size:10px;border-right:1px solid #333;border-top:1px solid #333;font-weight: normal;" align="center"> <?=$sgst?>  </td>
                                                            <td style="padding:4px; font-size:10px;border-right:1px solid #333;border-top:1px solid #333;font-weight: normal;" align="center"> <?=$transfer->gst?>  </td>                                                                        
                                                        </tr>                                                            
                                                        <tr>
                                                            <td style="padding:4px; font-size:10px;border-right:1px solid #333;border-top:1px solid #333;border-left:1px solid #333;" align="center"><strong> <?=$transfer->total_amt?> </strong> </td>
                                                            <td style="padding:4px; font-size:10px;border-right:1px solid #333;border-top:1px solid #333;" align="center"><strong> &nbsp; </strong> </td>
                                                            <td style="padding:4px; font-size:10px;border-right:1px solid #333;border-top:1px solid #333;" align="center"><strong> <?=$cgst?> </strong> </td>
                                                            <td style="padding:4px; font-size:10px;border-right:1px solid #333;border-top:1px solid #333;" align="center"><strong> &nbsp;</strong> </td>
                                                            <td style="padding:4px; font-size:10px;border-right:1px solid #333;border-top:1px solid #333;" align="center"><strong> <?=$sgst?> </strong> </td>
                                                            <td style="padding:4px; font-size:10px;border-right:1px solid #333;border-top:1px solid #333;" align="center"><strong> <?=$transfer->gst?> </strong> </td>
                                                        </tr>
                                                        <?php
                                                    }else if( $transfer->gst_type == 0 ){
                                                        ?>
                                                        <tr>
                                                            <td rowspan="2" style="padding:4px; font-size:10px;border-left:1px solid #333;border-right:1px solid #333;background-color:#bfbfbf;" align="center"><strong> GST TAXABLE VALUE </strong> </td>
                                                            <td colspan="2" style="padding:4px; font-size:10px;border-right:1px solid #333;border-bottom:1px solid #333;background-color:#bfbfbf;" align="center"><strong> TAX </strong> </td>
                                                            <td rowspan="2" style="padding:4px; font-size:10px;border-right:1px solid #333;background-color:#bfbfbf;" align="center"><strong> TOTAL TAX AMOUNT</strong> </td>
                                                        </tr>
                                                        <tr>
                                                            <td style="padding:4px; font-size:10px;border-right:1px solid #333;background-color:#bfbfbf;" align="center"><strong> GST </strong> </td>
                                                            <td style="padding:4px; font-size:10px;border-right:1px solid #333;background-color:#bfbfbf;" align="center"><strong> Tax Amount </strong> </td>
                                                        </tr>
                                                        <tr>
                                                            <td style="padding:4px; font-size:10px;border-right:1px solid #333;border-top:1px solid #333;border-left:1px solid #333;font-weight: normal;" align="center"> <?=$transfer->total_amt?> </td>
                                                            <td style="padding:4px; font-size:10px;border-right:1px solid #333;border-top:1px solid #333;font-weight: normal;" align="center"> <?=$transfer->gst_per?>%  </td>
                                                            <td style="padding:4px; font-size:10px;border-right:1px solid #333;border-top:1px solid #333;font-weight: normal;" align="center"> <?=$transfer->gst?>  </td>
                                                            <td style="padding:4px; font-size:10px;border-right:1px solid #333;border-top:1px solid #333;font-weight: normal;" align="center"> <?=$transfer->gst?>  </td>                                                                        
                                                        </tr>                                                            
                                                        <tr>
                                                            <td style="padding:4px; font-size:10px;border-right:1px solid #333;border-top:1px solid #333;border-left:1px solid #333;" align="center"><strong> <?=$transfer->total_amt?> </strong> </td>
                                                            <td style="padding:4px; font-size:10px;border-right:1px solid #333;border-top:1px solid #333;" align="center"><strong> &nbsp; </strong> </td>
                                                            <td style="padding:4px; font-size:10px;border-right:1px solid #333;border-top:1px solid #333;" align="center"><strong> <?=$transfer->gst?> </strong> </td>
                                                            <td style="padding:4px; font-size:10px;border-right:1px solid #333;border-top:1px solid #333;" align="center"><strong> <?=$transfer->gst?> </strong> </td>
                                                        </tr>
                                                        <?php
                                                    }
                                                    ?>
                                                    
                                                </tbody>
                                            </table>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>

                            <h2 style="margin:4px 0;  font-size:16px; color:black;" align="left"><u>Bank Details</u> </h2>
                            <table style="width:100%; text-align:center;" cellspacing="0" cellpadding="0">
                                <tbody>
                                    <tr>
                                        <td style="text-align: left;" width="5%" valign="top">                    
                                            <h2 style="margin:4px 0;  font-size:14px; color:black;"><span style="font-weight: lighter;">Bank:</span> <?=$company[0]->bank_name?></h2>
                                            <h2 style="margin:4px 0;  font-size:14px; color:black;">A/c Name: Paxykop Technologies India Pvt Ltd</h2>
                                            <h2 style="margin:4px 0;  font-size:14px; color:black;"><span style="font-weight: lighter;">A/c No:</span> 10053693395 </h2>

                                            <h2 style="margin:4px 0;  font-size:14px; color:black;"><span style="font-weight: lighter;">IFSC Code:</span> IDFB0080169</h2>
                                            <h2 style="margin:4px 0;  font-size:14px; color:black;"><span style="font-weight: lighter;">Branch:</span> Rajajinagar</h2>
                                            <h2 style="margin:4px 0;  font-size:14px; color:black;"><span style="font-weight: lighter;">GST NO:</span> <?=$company[0]->gst_no?></h2>
                                            <h2 style="margin:4px 0;  font-size:14px; color:black;"><span style="font-weight: lighter;">PAN NO:</span> <?=$company[0]->pan_no?></h2>
                                        </td>
                                        <td style="text-align: right;" width="10%" valign="top">                                                        
                                            <h2 style="margin-top: 65px; font-size:15px; color:black;font-weight: normal;margin-right: 18px;">For <br />Paxykop Technologies India Pvt ltd </h2>
                                            <h2 style="margin:4px 0;  font-size:14px; color:black;">&nbsp;</h2>
                                            <h2 style="margin:4px 0;  font-size:14px; color:black;">&nbsp;</h2>
                                            <h2 style="margin:4px 0;  font-size:14px; color:black;">&nbsp;</h2>
                                            <h2 style="margin:4px 0;  font-size:14px; color:black;position: relative;left: -77px;">Authroised Signatory</h2>
                                        </td>

                                    </tr>
                                </tbody>
                            </table>
                        </td>
                    </tr>
                </tbody>
            </table>
            <h2 style="margin:4px 0;  font-size:12px; color:black;font-weight: lighter;" align="center">SUBJECT TO BANGALORE JURISDICTION </h2>
        </div>
         <?=$jsfile?>
    </body>

    <script type="text/javascript">
        function PrintDiv() {    
           var divToPrint = document.getElementById('divToPrint');
           var popupWin = window.open('', '_blank', 'width=600,height=600');
           popupWin.document.open();
           popupWin.document.write('<html><body onload="window.print()">' + divToPrint.innerHTML + '</html>');
            popupWin.document.close();
        }

        $(document).ready(function() {
            $("#discount").on("keyup",function() {
               var dis = $(this).val();
               var tid = $("#tid").val();
               $.ajax({
                    url :"<?= base_url().'pin/discountprice'; ?>",
                    method :"post",
                    dataType :"json",
                    data :{
                        dis :dis,
                        tid :tid
                    },
                    success:function(data) {
                        if(data.status ==true) {
                            $("#gstBill").html(data.ddata);
                        }
                         else if(data.status ==false) {
                            $("#gstBill").html(data.ddata);
                        }
                    }
               });

            });
        });
     </script>
</html>