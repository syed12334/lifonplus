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
                            //Total amount
                            $totalAm = $transfer->total_amt;
                            $totalDis = $discount/100*$totalAm;
                            $totalAmountdis = $totalAm - $totalDis;
                            $disDivide = $discount/2;

                            //Gst discount 
                            $gstPa = $transfer->gst_per;
                            $gstDis = $gstPa/100*$totalAmountdis;
                            $grandTotal = $totalAmountdis +$gstDis;

                            $twoDivide = $gstDis/2 ;
                            ?>
  <h2 style="font-weight: normal;float: right;font-size: 14px;">TOTAL: <?=number_format($totalAmountdis)?></h2>
                            <table style="width:100%; margin:0px 0; font-size:14px;" width="0" cellspacing="0" cellpadding="0" border="0">
                                <tbody>
                                    <?php
                                    if( $transfer->gst_type == 1 ){
                                        ?>
                                        <tr>
                                            <td style="padding:4px; font-size:12px;text-align: left;" width="60%" align="center"><strong> &nbsp; </strong> </td>
                                            <td style="padding:4px;font-size:12px; text-align: right;" width="10%" align="center"><strong> CGST </strong> </td>
                                            <td style="padding:4px;font-size:12px;text-align: right;" width="10%" align="center"><strong> <?=number_format(round($twoDivide,2));?> </strong> </td>
                                        </tr>        
                                        <tr>
                                            <td style="padding:4px;font-size:12px;" width="40%" align="center">&nbsp; </td>
                                            <td style="padding:4px; font-size:12px;text-align: right;" width="20%" align="center"><strong> SGST </strong> </td>
                                            <td style="padding:4px; font-size:12px;text-align: right;" width="10%" align="center"><strong> <?=number_format(round($twoDivide,2))?> </strong> </td>
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
                                        <td style="padding:4px; font-size:16px;text-align: right;" width="10%" align="center"><strong> <img src="http://localhost/invoice/assets/images/rupee.png" style="width:11px;height: 11px;"><?=number_format($totalAmountdis)?> </strong> </td>
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
                                                            <td style="padding:4px; font-size:10px;border-right:1px solid #333;border-top:1px solid #333;border-left:1px solid #333;font-weight: normal;" align="center"> <?=number_format($totalAmountdis)?> </td>
                                                            <td style="padding:4px; font-size:10px;border-right:1px solid #333;border-top:1px solid #333;font-weight: normal;" align="center"> <?=$cgst_per?>%  </td>
                                                            <td style="padding:4px; font-size:10px;border-right:1px solid #333;border-top:1px solid #333;font-weight: normal;" align="center"> <?=number_format(round($twoDivide,2))?>  </td>
                                                            <td style="padding:4px; font-size:10px;border-right:1px solid #333;border-top:1px solid #333;font-weight: normal;" align="center"> <?=$sgst_per?>%  </td>
                                                            <td style="padding:4px; font-size:10px;border-right:1px solid #333;border-top:1px solid #333;font-weight: normal;" align="center"> <?=number_format(round($twoDivide,2))?>  </td>
                                                            <td style="padding:4px; font-size:10px;border-right:1px solid #333;border-top:1px solid #333;font-weight: normal;" align="center"> <?=number_format($gstDis)?>  </td>                                                                        
                                                        </tr>                                                            
                                                        <tr>
                                                            <td style="padding:4px; font-size:10px;border-right:1px solid #333;border-top:1px solid #333;border-left:1px solid #333;" align="center"><strong> <?=number_format($totalAmountdis)?> </strong> </td>
                                                            <td style="padding:4px; font-size:10px;border-right:1px solid #333;border-top:1px solid #333;" align="center"><strong> &nbsp; </strong> </td>
                                                            <td style="padding:4px; font-size:10px;border-right:1px solid #333;border-top:1px solid #333;" align="center"><strong> <?=number_format(round($twoDivide,2))?> </strong> </td>
                                                            <td style="padding:4px; font-size:10px;border-right:1px solid #333;border-top:1px solid #333;" align="center"><strong> &nbsp;</strong> </td>
                                                            <td style="padding:4px; font-size:10px;border-right:1px solid #333;border-top:1px solid #333;" align="center"><strong> <?=number_format(round($twoDivide,2))?> </strong> </td>
                                                            <td style="padding:4px; font-size:10px;border-right:1px solid #333;border-top:1px solid #333;" align="center"><strong> <?=number_format($gstDis)?> </strong> </td>
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
                                                            <td style="padding:4px; font-size:10px;border-right:1px solid #333;border-top:1px solid #333;border-left:1px solid #333;font-weight: normal;" align="center"> <?=number_format($totalAmountdis)?> </td>
                                                            <td style="padding:4px; font-size:10px;border-right:1px solid #333;border-top:1px solid #333;font-weight: normal;" align="center"> <?=$transfer->gst_per?>%  </td>
                                                            <td style="padding:4px; font-size:10px;border-right:1px solid #333;border-top:1px solid #333;font-weight: normal;" align="center"> <?=$gstDis?>  </td>
                                                            <td style="padding:4px; font-size:10px;border-right:1px solid #333;border-top:1px solid #333;font-weight: normal;" align="center"> <?=$gstDis?>  </td>                                                                        
                                                        </tr>                                                            
                                                        <tr>
                                                            <td style="padding:4px; font-size:10px;border-right:1px solid #333;border-top:1px solid #333;border-left:1px solid #333;" align="center"><strong> <?=number_format($totalAmountdis)?> </strong> </td>
                                                            <td style="padding:4px; font-size:10px;border-right:1px solid #333;border-top:1px solid #333;" align="center"><strong> &nbsp; </strong> </td>
                                                            <td style="padding:4px; font-size:10px;border-right:1px solid #333;border-top:1px solid #333;" align="center"><strong> <?=$gstDis?> </strong> </td>
                                                            <td style="padding:4px; font-size:10px;border-right:1px solid #333;border-top:1px solid #333;" align="center"><strong> <?=$gstDis?> </strong> </td>
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