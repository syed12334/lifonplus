<?php
if(count($user)){
    ?>
    <div id="accordion">
	
	
        <div class="card">
            <div class="card-header" id="headingOne">
                <h5 class="mb-0">
                    <button class="btn btn-link" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                        End User Details
                    </button>
                </h5>
            </div>
            <div id="collapseOne" class="collapse show" aria-labelledby="headingOne" data-parent="#accordion">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                           
                            <label>Code : <?=$user[0]->code;?></label>
                        </div>
                        <div class="col-md-6">
                            <label> Name : <?=$user[0]->name?></label>
                        </div>
                        <div class="col-md-6">
                            <label>Mobile No : <?=$user[0]->mobileno?></label>
                        </div>
                        <div class="col-md-6">
                            <label>Email ID : <?=$user[0]->email_id?></label>
                        </div>
						
						 <div class="col-md-6">
                            <label>DOB : <?=$user[0]->dob?></label>
                        </div>
						
						 <div class="col-md-6">
                            <label>Blood Group : <?=$user[0]->blood_group?></label>
                        </div>
						
						 <div class="col-md-6">
                            <label>Address : <?=$user[0]->address?></label>
                        </div>
						 <div class="col-md-6">
                            <label>Gender : <?=$user[0]->gender?></label>
                        </div>
						
						<div class="col-md-6">
                            <label>Referral Code : <?=$user[0]->referral_code?></label>
                        </div>
						
						<div class="col-md-6">
                            <label>Country : <?=$user[0]->country_name?></label>
                        </div>
						
						<div class="col-md-6">
                            <label>State : <?=$user[0]->state_name?></label>
                        </div>
						
						<div class="col-md-6">
                            <label>District : <?=$user[0]->dist_name?></label>
                        </div>
						
						<div class="col-md-6">
                            <label>Taluk : <?=$user[0]->city_name?></label>
                        </div>
						<div class="col-md-6">
						   <?php if($user[0]->photo !=""){?>
                            <label>Photo : <?php if($user[0]->photo !=""){?><img src="<?=app_asset_url().$user[0]->photo?>" width="80px" height="80px"><?php }?></label>
						   <?php }else{?>
						   <label>Photo : <?php if($user[0]->photo !=""){?><img src="<?=app_asset_url().'profile.png'?>" width="80px" height="80px"><?php }?></label>

						   <?php }?>
                        </div>
						
                                               
                    </div>
                </div>
            </div>
        </div>
		
		
       <div class="card">
            <div class="card-header" id="headingTwo">
                <h5 class="mb-0">
                    <button class="btn btn-link collapsed" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                       Points History
                    </button>
                </h5>
            </div>
            <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordion">
                <div class="card-body">
                    <div class="row">
                        <?php
                       
                        $points_his = $this->master_db->getRecords('cust_point_history',array('customer_id'=>$user[0]->id,'status'=>1),'id,points,type,referred_by');
                       
                        ?>
                        <div class="col-md-6">
                            <label>Current Points : Rs.<?=$user[0]->total;?></label>
                        </div>
						
						<table class="table table-borded">
						
						  <thead>
						   <tr>
						    <th>SL.No</th>
						    <th>Type</th>
						    <th>Points</th>
						    <th>Referred By</th>
						   </tr>
						  </thead>
						  <tbody>
						  <?php 
						  $ptype=array("","Welcome Point","Referral Point");
						  $i=1;
						  if(count($points_his)){
							  foreach($points_his as $h){
								  $referred_by = "";
								  if(!empty($h->referred_by))
								  {
								    $referList = $this->master_db->getRecords('customers',array('customer_id'=>$h->referred_by,'status'=>1),'name');
								    $referred_by = $referList[0]->name;
								  }
								  ?>
						   <tr>
						     <td><?=$i;?></td>
							 <td><?=$ptype[$h->type];?></td>
							 <td>Rs.<?=$h->points;?></td>
							 <td><?=$referred_by;?></td>
						   </tr>
						   <?php
                               $i++;						   
							  }
						  }
						  ?>
						  </tbody>
						  
						</table>
                                              
                    </div>
                </div>
            </div>
        </div>
		
		
       <div class="card">
            <div class="card-header" id="headingThree">
                <h5 class="mb-0">
                    <button class="btn btn-link collapsed" data-toggle="collapse" data-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                        Documents
                    </button>
                </h5>
            </div>
            <div id="collapseThree" class="collapse" aria-labelledby="headingThree" data-parent="#accordion">
               
                <div class="card-body">
                    <div class="row">
                       <table class="table table-borded">
						
						  <thead>
						   <tr>
						    <th>SL.No</th>
						    <th>Title</th>
						    <th>Speciality</th>
						    <th>Date</th>
							<th>Note</th>
							<th>Doc</th>
						   </tr>
						  </thead>
						  <tbody id="docid">
						  <?php 
						  
						  $i=1;
						  if(count($documents)){
							  foreach($documents as $d){
								 $doclist = $this->web_db->getCustomerDoc($d->id);
								  ?>
						   <tr>
						     <td><?=$i;?></td>
							 <td><?=$d->title;?></td>
							 <td><?=$d->speciality;?></td>
							 <td><?=$d->date;?></td>
							 <td><?=$d->notes;?></td>
							 <td>
							  <?php 
							  if(count($doclist))
							  {
							  ?>
							  <ul>
							   <?php
								 foreach($doclist as $d)
								 {
							    ?>
							     <li><a target="_blank" href="<?php echo app_asset_url().$d->image;?>">Click here to view</a></li>
							   <?php			   
							     }
								?>
							  </ul>
							 <?php
						      }
						     ?>
						     </td>
							
						   </tr>
						   <?php
                               $i++;						   
							  }
						  }
						  ?>
						  </tbody>
						  
						</table>
                    </div>
                </div>
            </div>
        </div>
		
		 
		
		
		 <div class="card">
            <div class="card-header" id="headingFive">
                <h5 class="mb-0">
                    <button class="btn btn-link collapsed" data-toggle="collapse" data-target="#collapseFive" aria-expanded="false" aria-controls="collapseFive" onclick="loadservicedata_post('<?=$user[0]->id;?>');">
                        Tracked Measurements

                    </button>
                </h5>
            </div>
            <div id="collapseFive" class="collapse" aria-labelledby="headingFive" data-parent="#accordion">
               
                <div class="card-body">
                    <div class="row" id="emgid">
                       
                    </div>
                </div>
            </div>
        </div>
		
		
		 <div class="card">
            <div class="card-header" id="headingFour">
                <h5 class="mb-0">
                    <button class="btn btn-link collapsed" data-toggle="collapse" data-target="#collapseFour" aria-expanded="false" aria-controls="collapseFour" onclick="loademergency_post('<?=$user[0]->id;?>');">
                        Emergency Contact Number
                    </button>
                </h5>
            </div>
            <div id="collapseFour" class="collapse" aria-labelledby="headingFour" data-parent="#accordion">
               
                <div class="card-body">
                    <div class="row">
                       <table class="table table-borded">
						
						  <thead>
						   <tr>
						    <th>SL.No</th>
						    <th>Name</th>
						    <th>Phone</th>
						    <th>Relationship</th>
							<th>Sms</th>
							<th>Location</th>
						   </tr>
						  </thead>
						  <tbody id="emgid">
						  
						  </tbody>
						  
						</table>
                    </div>
                </div>
            </div>
        </div>
		
		
		<div class="card">
            <div class="card-header" id="heading20">
                <h5 class="mb-0">
                    <button class="btn btn-link collapsed" data-toggle="collapse" data-target="#collapse20" aria-expanded="false" aria-controls="collapse20" onclick="loadMedicalVisit_post('<?=$user[0]->id;?>');">
                     Medical Visits 
                    </button>
                </h5>
            </div>
			
			
            <div id="collapse20" class="collapse" aria-labelledby="heading20" data-parent="#accordion">
               
                <div class="card-body">
                    <div class="row">
                       <table class="table table-borded">
						
						   <thead>
							  <tr>
								<th>SL.No</th>
								<th>Date</th>
								<th>Visit Type</th>
								<th>Consulted Doctor</th>
								<th>Reason</th>
							  </tr>
		                   </thead>
				           <tbody id="visitid">
						  
						   </tbody>
						  
						</table>
                    </div>
                </div>
            </div>
        </div>
		
			<div class="card">
            <div class="card-header" id="heading19">
                <h5 class="mb-0">
                    <button class="btn btn-link collapsed" data-toggle="collapse" data-target="#collapse19" aria-expanded="false" aria-controls="collapse19" onclick="loadPreference_post('<?=$user[0]->id;?>');">
                      Hospital Preference 
                    </button>
                </h5>
            </div>
			
			
            <div id="collapse19" class="collapse" aria-labelledby="heading18" data-parent="#accordion">
               
                <div class="card-body">
                    <div class="row">
                       <table class="table table-borded">
						
						   <thead>
							  <tr>
								<th>SL.No</th>
								<th>Hospital Preference</th>
								<th>Medical Note</th>
								<th>Last Admitted On</th>
								
							  </tr>
		                   </thead>
				           <tbody id="prefid">
						  
						   </tbody>
						  
						</table>
                    </div>
                </div>
            </div>
        </div>
		
		
		
		<div class="card">
            <div class="card-header" id="heading18">
                <h5 class="mb-0">
                    <button class="btn btn-link collapsed" data-toggle="collapse" data-target="#collapse18" aria-expanded="false" aria-controls="collapse18" onclick="loadVaccine_post('<?=$user[0]->id;?>');">
                     Vaccine 
                    </button>
                </h5>
            </div>
			
			
            <div id="collapse18" class="collapse" aria-labelledby="heading18" data-parent="#accordion">
               
                <div class="card-body">
                    <div class="row">
                       <table class="table table-borded">
						
						   <thead>
							  <tr>
								<th>SL.No</th>
								<th>Date</th>
								<th>Vaccine</th>
								<th>Dose</th>
								<th>Note</th>
								
							  </tr>
		                   </thead>
				           <tbody id="vaccineid">
						  
						   </tbody>
						  
						</table>
                    </div>
                </div>
            </div>
        </div>
		
		
		<div class="card">
            <div class="card-header" id="heading17">
                <h5 class="mb-0">
                    <button class="btn btn-link collapsed" data-toggle="collapse" data-target="#collapse17" aria-expanded="false" aria-controls="collapse17" onclick="loadAllergy_post('<?=$user[0]->id;?>');">
                     Allergy 
                    </button>
                </h5>
            </div>
			
			
            <div id="collapse17" class="collapse" aria-labelledby="heading17" data-parent="#accordion">
               
                <div class="card-body">
                    <div class="row">
                       <table class="table table-borded">
						
						   <thead>
							  <tr>
								<th>SL.No</th>
								<th>Allergy Name</th>
								<th>Date</th>
								<th>Note</th>
								
							  </tr>
		                   </thead>
				           <tbody id="allergyid">
						  
						   </tbody>
						  
						</table>
                    </div>
                </div>
            </div>
        </div>
		
		
		<div class="card">
            <div class="card-header" id="heading16">
                <h5 class="mb-0">
                    <button class="btn btn-link collapsed" data-toggle="collapse" data-target="#collapse16" aria-expanded="false" aria-controls="collapse16" onclick="loadexam_post('<?=$user[0]->id;?>');">
                      Examination 
                    </button>
                </h5>
            </div>
			
			
            <div id="collapse16" class="collapse" aria-labelledby="heading16" data-parent="#accordion">
               
                <div class="card-body">
                    <div class="row">
                       <table class="table table-borded">
						
						   <thead>
							  <tr>
								<th>SL.No</th>
								<th>Temperature</th>
								<th>Weight</th>
								<th>Height</th>
								<th>Doctor</th>
								<th>Symptoms</th>
								<th>Diagnosis</th>
								<th>Note</th>
								<th>Date</th>
								
							  </tr>
		                   </thead>
				           <tbody id="examid">
						  
						   </tbody>
						  
						</table>
                    </div>
                </div>
            </div>
        </div>
		
		
		<div class="card">
            <div class="card-header" id="heading15">
                <h5 class="mb-0">
                    <button class="btn btn-link collapsed" data-toggle="collapse" data-target="#collapse15" aria-expanded="false" aria-controls="collapse15" onclick="loadprescrid_post('<?=$user[0]->id;?>');">
                       Prescription 
                    </button>
                </h5>
            </div>
			
			
            <div id="collapse15" class="collapse" aria-labelledby="heading15" data-parent="#accordion">
               
                <div class="card-body">
                    <div class="row">
                       <table class="table table-borded">
						
						   <thead>
							  <tr>
								<th>SL.No</th>
								<th>Doctor</th>
								<th>Message</th>
								<th>Date</th>
								<th>Image</th>
								
							  </tr>
		                   </thead>
				           <tbody id="prescrid">
						  
						   </tbody>
						  
						</table>
                    </div>
                </div>
            </div>
        </div>
		
		
		
			<div class="card">
            <div class="card-header" id="heading13">
                <h5 class="mb-0">
                    <button class="btn btn-link collapsed" data-toggle="collapse" data-target="#collapse13" aria-expanded="false" aria-controls="collapse13" onclick="loadlabtest_post('<?=$user[0]->id;?>');">
                       Lab Test 
                    </button>
                </h5>
            </div>
			
			
            <div id="collapse13" class="collapse" aria-labelledby="heading13" data-parent="#accordion">
               
                <div class="card-body">
                    <div class="row">
                       <table class="table table-borded">
						
						   <thead>
							  <tr>
								<th>SL.No</th>
								<th>Test Name</th>
								<th>Test Result</th>
								<th>Note</th>
								<th>Image</th>
								<th>Date</th>
							  </tr>
		                   </thead>
				           <tbody id="labtestid">
						  
						   </tbody>
						  
						</table>
                    </div>
                </div>
            </div>
        </div>
		
		
		
		<div class="card">
            <div class="card-header" id="headingSix">
                <h5 class="mb-0">
                    <button class="btn btn-link collapsed" data-toggle="collapse" data-target="#collapseSix" aria-expanded="false" aria-controls="collapseSix" onclick="loadconsult_post('<?=$user[0]->id;?>');">
                        Consulted Doctor 

                    </button>
                </h5>
            </div>
            <div id="collapseSix" class="collapse" aria-labelledby="headingSix" data-parent="#accordion">
               
                <div class="card-body">
                    <div class="row">
                       <table class="table table-borded">
						
						   <thead>
						   <tr>
						    <th>SL.No</th>
						    <th>Doctor Name</th>
						    <th>Specialty</th>
						    <th>Phone</th>
							<th>Experience</th>
							<th>Consulted On</th>
							<th>Comments</th>
						   </tr>
						  </thead>
						  <tbody id="consultid">
						  
						  </tbody>
						  
						</table>
                    </div>
                </div>
            </div>
        </div>
		
		
		
		
		<div class="card">
            <div class="card-header" id="headingEight">
                <h5 class="mb-0">
                    <button class="btn btn-link collapsed" data-toggle="collapse" data-target="#collapseEight" aria-expanded="false" aria-controls="collapseEight" onclick="loadDiagnosis_post('<?=$user[0]->id;?>');">
                       Diagnosis 

                    </button>
                </h5>
            </div>
            <div id="collapseEight" class="collapse" aria-labelledby="headingEight" data-parent="#accordion">
               
                <div class="card-body">
                    <div class="row">
                       <table class="table table-borded">
						
						   <thead>
						   <tr>
						    <th>SL.No</th>
						    <th>Medical Diagnosis</th>
						    <th>Note</th>
						    <th>Special Diagnosis</th>
							<th>Special Note</th>
							<th>Conducted On</th>
						   </tr>
						  </thead>
						  <tbody id="diagid">
						  
						  </tbody>
						  
						</table>
                    </div>
                </div>
            </div>
        </div>
		
		
		<div class="card">
            <div class="card-header" id="headingNine">
                <h5 class="mb-0">
                    <button class="btn btn-link collapsed" data-toggle="collapse" data-target="#collapseNine" aria-expanded="false" aria-controls="collapseNine" onclick="loadInsurance_post('<?=$user[0]->id;?>');">
                       Insurance 

                    </button>
                </h5>
            </div>
			
			
            <div id="collapseNine" class="collapse" aria-labelledby="headingNine" data-parent="#accordion">
               
                <div class="card-body">
                    <div class="row">
                       <table class="table table-borded">
						
						   <thead>
							  <tr>
								<th>SL.No</th>
								<th>Insurance Name</th>
								<th>Policy Number</th>
								<th>Plan Created Date</th>
								<th>Plan Expiry Date</th>
								<th>Amount</th>
							  </tr>
		                   </thead>
				           <tbody id="insuranceid">
						  
						   </tbody>
						  
						</table>
                    </div>
                </div>
            </div>
        </div>
		
		
		<div class="card">
            <div class="card-header" id="heading14">
                <h5 class="mb-0">
                    <button class="btn btn-link collapsed" data-toggle="collapse" data-target="#collapse14" aria-expanded="false" aria-controls="collapse14" onclick="loadBills_post('<?=$user[0]->id;?>');">
                     Bills 
                    </button>
                </h5>
            </div>
			
			
            <div id="collapse14" class="collapse" aria-labelledby="heading14" data-parent="#accordion">
               
                <div class="card-body">
                    <div class="row">
                       <table class="table table-borded">
						
						   <thead>
							  <tr>
								<th>SL.No</th>
								<th>Title</th>
								<th>Note</th>
								<th>Date</th>
								<th>Image</th>
								
							  </tr>
		                   </thead>
				           <tbody id="billid">
						  
						   </tbody>
						  
						</table>
                    </div>
                </div>
            </div>
        </div>
		
		
		
		<div class="card">
            <div class="card-header" id="headingTen">
                <h5 class="mb-0">
                    <button class="btn btn-link collapsed" data-toggle="collapse" data-target="#collapseTen" aria-expanded="false" aria-controls="collapseTen" onclick="loadSurgery_post('<?=$user[0]->id;?>');">
                       Surgery 
                    </button>
                </h5>
            </div>
			
			
            <div id="collapseTen" class="collapse" aria-labelledby="headingTen" data-parent="#accordion">
               
                <div class="card-body">
                    <div class="row">
                       <table class="table table-borded">
						
						   <thead>
							  <tr>
								<th>SL.No</th>
								<th>Procedure Name</th>
								<th>Procedure Comment</th>
								<th>Special Procedure</th>
								<th>Special Comment</th>
								<th>Conducted On</th>
							  </tr>
		                   </thead>
				           <tbody id="surgeryid">
						  
						   </tbody>
						  
						</table>
                    </div>
                </div>
            </div>
        </div>
		
		
		
		<div class="card">
            <div class="card-header" id="headingEleven">
                <h5 class="mb-0">
                    <button class="btn btn-link collapsed" data-toggle="collapse" data-target="#collapseEleven" aria-expanded="false" aria-controls="collapseEleven" onclick="loadRadiology_post('<?=$user[0]->id;?>');">
                       Radiology 
                    </button>
                </h5>
            </div>
			
			
            <div id="collapseEleven" class="collapse" aria-labelledby="headingEleven" data-parent="#accordion">
               
                <div class="card-body">
                    <div class="row">
                       <table class="table table-borded">
						
						   <thead>
							  <tr>
								<th>SL.No</th>
								<th>Title</th>
								<th>Result</th>
								<th>doctor</th>
								<th>Date</th>
								<th>Image</th>
							  </tr>
		                   </thead>
				           <tbody id="radiologyid">
						  
						   </tbody>
						  
						</table>
                    </div>
                </div>
            </div>
        </div>
		
		
		
		<div class="card">
            <div class="card-header" id="headingTwelve">
                <h5 class="mb-0">
                    <button class="btn btn-link collapsed" data-toggle="collapse" data-target="#collapseTwelve" aria-expanded="false" aria-controls="collapseTwelve" onclick="loadPathology_post('<?=$user[0]->id;?>');">
                      Pathology 
                    </button>
                </h5>
            </div>
			
			
            <div id="collapseTwelve" class="collapse" aria-labelledby="headingTwelve" data-parent="#accordion">
               
                <div class="card-body">
                    <div class="row">
                       <table class="table table-borded">
						
						   <thead>
							  <tr>
								<th>SL.No</th>
								<th>Title</th>
								<th>Result</th>
								<th>doctor</th>
								<th>Date</th>
								<th>Image</th>
							  </tr>
		                   </thead>
				           <tbody id="pathologyid">
						  
						   </tbody>
						  
						</table>
                    </div>
                </div>
            </div>
        </div>
		
		
		
		
		
		<div class="card">
            <div class="card-header" id="heading21">
                <h5 class="mb-0">
                    <button class="btn btn-link collapsed" data-toggle="collapse" data-target="#collapse21" aria-expanded="false" aria-controls="collapse21" onclick="loadVitals_post('<?=$user[0]->id;?>');">
                      Vitals 
                    </button>
                </h5>
            </div>
			
			
            <div id="collapse21" class="collapse" aria-labelledby="heading21" data-parent="#accordion">
               
                <div class="card-body">
                    <div class="row">
                       <table class="table table-borded table-responsive" >
						
						   <thead>
							  <tr>
								<th>SL.No</th>
								<th>Height</th>
								<th>Weight</th>
								<th>BMI</th>
								<th>SPO2</th>
								<th>Pulse</th>
								<th>BP</th>
								<th>Sugar Level</th>
								<th>ECG</th>
								<th>Hemoglobin</th>
								<th>TDS</th>
								<th>MAC</th>
								<th>Distance Test</th>
								<th>Near Vision Test</th>
								<th>Astigmatism</th>
								<th>CVD Test</th>
								<th>Cholesterol</th>
								<th>Astigmatism</th>
								<th>CVD Test</th>
								<th>Vascular Age</th>
								<th>Skin Carotenoid</th>
								<th>Capillary Shape</th>
								<th>Heart Rate</th>
								<th>Report Date</th>
							  </tr>
		                   </thead>
				           <tbody id="vitalsid">
						  
						   </tbody>
						  
						</table>
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
 