<?php
if(count($partner)){
    ?>
    <div id="accordion">
        <div class="card">
            <div class="card-header" id="headingOne">
                <h5 class="mb-0">
                    <button class="btn btn-link" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                        Company Details
                    </button>
                </h5>
            </div>
            <div id="collapseOne" class="collapse show" aria-labelledby="headingOne" data-parent="#accordion">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <?php

                            $type = '';
                            switch(intval($partner[0]->type)){
                                case 1:$type = 'COUNTRY PARTNER';break;
                                case 2:$type = 'STOCKIST';break;
                                case 3:$type = 'STATE C&F';break;
                                case 4:$type = 'DISTRIBUTOR';break;
                                case 5:$type = 'DEALER';break;
                                case 6:$type = 'RETAILER';break;
                                default:$type = '';break;                
                            }

                            $com_type = '';
                            switch(intval($partner[0]->company_type)){
                                case 1:$com_type = 'PRIVATE LIMITED';break;
                                case 2:$com_type = 'LIMITED';break;
                                case 3:$com_type = 'PARTNERSHIP';break;
                                case 4:$com_type = 'PROPRITOR';break;
                                case 5:$com_type = 'LLP';break;
                                default:$com_type = '';break;                
                            }

                            $doc_type = '';
                            switch(intval($partner[0]->doc_type)){
                                case 1:$doc_type = 'Incorporation';break;
                                case 2:$doc_type = 'Partnership Details';break;
                                default:$doc_type = '';break;                
                            }
                            ?>
                            <label>Channel Partner Type : <?=$type?></label>
                        </div>
                        <div class="col-md-6">
                            <label>Company Name : <?=$partner[0]->company_name?></label>
                        </div>
                        <div class="col-md-6">
                            <label>Company Type : <?=$com_type?></label>
                        </div>
                        <div class="col-md-6">
                            <label>GST No : <?=$partner[0]->gst_no?></label>
                        </div>
                        <div class="col-md-12">
                            <label>Company Document : <?=$doc_type?></label><br>
                            <a target="_blank" href="<?=app_asset_url().$partner[0]->company_doc?>">Click here to view document</a>
                        </div>                        
                    </div>
                </div>
            </div>
        </div>
        <div class="card">
            <div class="card-header" id="headingTwo">
                <h5 class="mb-0">
                    <button class="btn btn-link collapsed" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                        Personal Details
                    </button>
                </h5>
            </div>
            <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordion">
                <div class="card-body">
                    <div class="row">
                        <?php
                        $cname = $sname = $dname = $tname = 'NA';
                        $country = $this->master_db->getRecords('countries',array('id'=>$partner[0]->country_id),'name');
                        if( count($country) ){ $cname = $country[0]->name; }

                        $state = $this->master_db->getRecords('states',array('id'=>$partner[0]->state_id),'name');
                        if( count($state) ){ $sname = $state[0]->name; }

                        $district = $this->master_db->getRecords('districts',array('id'=>$partner[0]->district_id),'name');
                        if( count($district) ){ $dname = $district[0]->name; }

                        $taluk = $this->master_db->getRecords('cities',array('id'=>$partner[0]->taluk_id),'name');
                        if( count($taluk) ){ $tname = $taluk[0]->name; }

                        $kyc_type = '';
                        switch(intval($partner[0]->kyc_type)){
                            case 1:$kyc_type = 'AADHAAR CARD';break;
                            case 2:$kyc_type = 'PAN CARD';break;
                            case 3:$kyc_type = 'VOTER ID';break;
                            case 4:$kyc_type = 'PASSPORT';break;
                            default:$kyc_type = '';break;                
                        }
                        ?>
                        <div class="col-md-6">
                            <label>Full Name : <?=$partner[0]->fullname?></label>
                        </div>
                        <div class="col-md-6">
                            <label>Mobile Number : <?=$partner[0]->contactno?></label>
                        </div>
                        <div class="col-md-6">
                            <label>Email : <?=$partner[0]->emailid?></label>
                        </div>
                        <div class="col-md-6">
                            <label>Date of Birth : <?=$partner[0]->dob?></label>
                        </div>
                        <div class="col-md-6">
                            <label>Bloodgroup : <?=$partner[0]->bloodgroup?></label>
                        </div>
                        <div class="col-md-6">
                            <label>Address : <?=$partner[0]->address?></label>
                        </div>
                        <div class="col-md-6">
                            <label>Country : <?=$cname?></label>
                        </div>
                        <div class="col-md-6">
                            <label>State : <?=$sname?></label>
                        </div>
                        <div class="col-md-6">
                            <label>District : <?=$dname?></label>
                        </div>
                        <div class="col-md-6">
                            <label>Taluk : <?=$tname?></label>
                        </div>
                        <div class="col-md-6">
                            <label>Pincode : <?=$partner[0]->pincode?></label>
                        </div>
                        <div class="col-md-6">
                            <label>Individual Photo : <a target="_blank" href="<?=app_asset_url().$partner[0]->photo?>">Click here</a></label>
                        </div> 

                        <div class="col-md-6">
                            <label>KYC Document : <?=$kyc_type?></label><br>
                            <a target="_blank" href="<?=app_asset_url().$partner[0]->kyc_doc?>">Click here</a>
                        </div>                       
                    </div>
                </div>
            </div>
        </div>
        <div class="card">
            <div class="card-header" id="headingThree">
                <h5 class="mb-0">
                    <button class="btn btn-link collapsed" data-toggle="collapse" data-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                        Payment Details
                    </button>
                </h5>
            </div>
            <div id="collapseThree" class="collapse" aria-labelledby="headingThree" data-parent="#accordion">
                <?php
                $payment_mode = '';
                switch(intval($partner[0]->payment_id)){
                    case 1:$payment_mode = 'Cheque';break;
                    case 2:$payment_mode = 'Cash';break;
                    case 3:$payment_mode = 'RTGS';break;
                    case 4:$payment_mode = 'Already paid to C&F/Distributor/Dealer ';break;
                    default:$payment_mode = '';break;                
                }
                ?>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <label>Payment Mode : <?=$payment_mode?></label>
                        </div>
                        <?php
                        if( intval($partner[0]->payment_id) == 1 ){
                            ?>
                            <div class="col-md-6">
                                <label>Cheque No : <?=$partner[0]->cheque_no?></label>
                            </div>
                            <div class="col-md-6">
                                <label>Cheque Date : <?=$partner[0]->cheque_date?></label>
                            </div>
                            <div class="col-md-6">
                                <label>Bank Name : <?=$partner[0]->bank_name?></label>
                            </div>
                            <div class="col-md-6">
                                <label>Branch : <?=$partner[0]->branch_name?></label>
                            </div>
                            <?php
                        }else if( intval($partner[0]->payment_id) == 3 ){
                            ?>
                            <div class="col-md-6">
                                <label>UTR No : <?=$partner[0]->utr_no?></label>
                            </div>
                            <?php
                        }
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php
    //echo '<pre>';print_r($partner);
}else{
    ?>
    <div class="row">
        <div class="col-md-12 text-center">
            <h4>No data found</h4>
        </div>
    </div>
    <?php
}
?>