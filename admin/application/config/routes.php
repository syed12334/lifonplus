<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
| -------------------------------------------------------------------------
| URI ROUTING
| -------------------------------------------------------------------------
| This file lets you re-map URI requests to specific controller functions.
|
| Typically there is a one-to-one relationship between a URL string
| and its corresponding controller class/method. The segments in a
| URL normally follow this pattern:
|
|	example.com/class/method/id/
|
| In some instances, however, you may want to remap this relationship
| so that a different class/function is called than the one
| corresponding to the URL.
|
| Please see the user guide for complete details:
|
|	https://codeigniter.com/user_guide/general/routing.html
|
| -------------------------------------------------------------------------
| RESERVED ROUTES
| -------------------------------------------------------------------------
|
| There are three reserved routes:
|
|	$route['default_controller'] = 'welcome';
|
| This route indicates which controller class should be loaded if the
| URI contains no data. In the above example, the "welcome" class
| would be loaded.
|
|	$route['404_override'] = 'errors/page_missing';
|
| This route will tell the Router which controller/method to use if those
| provided in the URL cannot be matched to a valid route.
|
|	$route['translate_uri_dashes'] = FALSE;
|
| This is not exactly a route, but allows you to automatically route
| controller and method names that contain dashes. '-' isn't a valid
| class or method name character, so it requires translation.
| When you set this option to TRUE, it will replace ALL dashes in the
| controller and method URI segments.
|
| Examples:	my-controller/index	-> my_controller/index
|		my-controller/my-method	-> my_controller/my_method
*/
$route['default_controller'] = 'Login';
$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;

//Version 1
$route['v1/registeruser'] = 'v1/app/registeruser';
$route['v1/customerlogin'] = 'v1/app/login';
$route['v1/verify'] = 'v1/app/verifyotp';
$route['v1/terms'] = 'v1/app/terms';
$route['v1/about'] = 'v1/app/about';
$route['v1/privacy'] = 'v1/app/privacy';
$route['v1/version'] = 'v1/app/appversion';
$route['v1/package'] = 'v1/app/packages';
$route['v1/packagelist'] = 'v1/app/packages_list';
$route['v1/customercard'] = 'v1/app/card';

//Documents routes
$route['v1/speciality'] = 'v1/app/speciality';
$route['v1/documents'] = 'v1/app/documents';
$route['v1/savedocument'] = 'v1/app/save_document';
$route['v1/deletedocument'] = 'v1/app/delete_document';

//Profile routes
$route['v1/country'] = 'v1/app/countries';
$route['v1/state'] = 'v1/app/states';
$route['v1/district'] = 'v1/app/districs';
$route['v1/taluk'] = 'v1/app/taluks';
$route['v1/profile'] = 'v1/app/userprofile/view';
$route['v1/updateprofile'] = 'v1/app/userprofile/update';

//Customer emergency routes
$route['v1/emergency'] = 'v1/app/cust_emergency';
$route['v1/saveemergency'] = 'v1/app/save_emergency';
$route['v1/deleteemergency'] = 'v1/app/delete_emergency';

//Customer medical visits routes
$route['v1/medical'] = 'v1/app/medical_visit';
$route['v1/savemedical'] = 'v1/app/save_medical';
$route['v1/deletemedical'] = 'v1/app/delete_medical';

//Customer Hosital routes
$route['v1/hospital'] = 'v1/app/hospital';
$route['v1/savehospital'] = 'v1/app/save_hospital';
$route['v1/deletehospital'] = 'v1/app/delete_hospital';

//Customer Vaccine routes
$route['v1/vaccine'] = 'v1/app/vaccine';
$route['v1/savevaccine'] = 'v1/app/save_vaccine';
$route['v1/deletevaccine'] = 'v1/app/delete_vaccine';

//Customer Allergy routes
$route['v1/allergy'] = 'v1/app/allergy';
$route['v1/saveallergy'] = 'v1/app/save_allergy';
$route['v1/deleteallergy'] = 'v1/app/delete_allergy';

//Customer Examination routes
$route['v1/exam'] = 'v1/app/exam';
$route['v1/saveexam'] = 'v1/app/save_exam';
$route['v1/deleteexam'] = 'v1/app/delete_exam';

//Customer Prescription routes
$route['v1/prescription'] = 'v1/app/prescription';
$route['v1/saveprescription'] = 'v1/app/save_prescription';
$route['v1/deleteprescription'] = 'v1/app/delete_prescription';

//Customer Tracker measurements routes
$route['v1/tracklist'] = 'v1/app/tracklist';
$route['v1/tracking'] = 'v1/app/mobtracking';
$route['v1/servicelist'] = 'v1/app/servicelist';
$route['v1/servicedata'] = 'v1/app/servicefields';
$route['v1/savetracked'] = 'v1/app/save_tracked';
$route['v1/servicedatalist'] = 'v1/app/servicedata';
$route['v1/service'] = 'v1/app/servicedlist';
$route['v1/deletetracked'] = 'v1/app/delete_tracked';

//Customer Bills routes
$route['v1/bill'] = 'v1/app/bill';
$route['v1/savebill'] = 'v1/app/save_bill';
$route['v1/deletebill'] = 'v1/app/delete_bill';

//Customer Lab test routes
$route['v1/labtest'] = 'v1/app/labtest';
$route['v1/savelabtest'] = 'v1/app/save_labtest';
$route['v1/deletelabtest'] = 'v1/app/delete_labtest';

//Customer Lab test routes
$route['v1/consult'] = 'v1/app/doctor_consult';
$route['v1/saveconsult'] = 'v1/app/save_doctor_consult';
$route['v1/deleteconsult'] = 'v1/app/delete_doctor_consult';

//Diagnosis routes
$route['v1/diagnosis'] = 'v1/app/diagnosis';
$route['v1/savediagnosis'] = 'v1/app/save_diagnosis';
$route['v1/deletediagnosis'] = 'v1/app/delete_diagnosis';

//Insurance routes
$route['v1/insurance'] = 'v1/app/insurance';
$route['v1/saveinsurance'] = 'v1/app/save_insurance';
$route['v1/deleteinsurance'] = 'v1/app/delete_insurance';

//Medicine routes
$route['v1/medicine'] = 'v1/app/medicine';
$route['v1/savemedicine'] = 'v1/app/save_medicine';
$route['v1/deletemedicine'] = 'v1/app/delete_medicine';

//Surgery routes
$route['v1/surgery'] = 'v1/app/surgery';
$route['v1/savesurgery'] = 'v1/app/save_surgery';
$route['v1/deletesurgery'] = 'v1/app/delete_surgery';

//Radiology routes
$route['v1/radiology'] = 'v1/app/radiology';
$route['v1/saveradiology'] = 'v1/app/save_radiology';
$route['v1/deleteradiology'] = 'v1/app/delete_radiology';

//Pathology routes
$route['v1/pathology'] = 'v1/app/pathology';
$route['v1/savepathology'] = 'v1/app/save_pathology';
$route['v1/deletepathology'] = 'v1/app/delete_pathology';

//Notification functions
$route['v1/benefits'] = 'v1/app/package_services';
$route['v1/healthtips'] = 'v1/app/healthtips';
$route['v1/viewhealthtip'] = 'v1/app/view_healthtip';

$route['v1/flashnews'] = 'v1/app/flashnews';
$route['v1/viewflashnews'] = 'v1/app/view_flashnews';
$route['v1/viewpopupalerts'] = 'v1/app/view_popupalerts';

$route['v1/notifications'] = 'v1/app/notifications';
$route['v1/viewnotification'] = 'v1/app/view_notification';

//Vitals routes
$route['v1/vitals'] = 'v1/app/vital';
$route['v1/savevital'] = 'v1/app/save_vital';
$route['v1/deletevital'] = 'v1/app/delete_vital';

//Panic routes
$route['v1/sendpanic'] = 'v1/app/publish_panic';

//Referral routes
$route['v1/referrals'] = 'v1/app/referral_list';

//Coupon routes
$route['v1/coupons'] = 'v1/app/coupons_list';

//App modules routes
$route['v1/modules'] = 'v1/app/modules_list';
$route['v1/homepage'] = 'v1/app/homepage';

$route['v1/points'] = 'v1/app/points_detail';
$route['v1/settings'] = 'v1/app/settings';

$route['v1/highlights'] = 'v1/app/package_highlight';
$route['v1/emergency_pdf'] = 'v1/app/ereportpdf';
$route['v1/emergency_report'] = 'v1/app/ereport';
$route['v1/emergency_reports'] = 'v1/app/emergencyreport';

//Upgrade & renew package
$route['v1/packageupdate'] = 'v1/app/package_upgrade';
$route['v1/customerdetails'] = 'v1/app/customergetdetails';
$route['v1/popupalerts'] = 'v1/app/popupalerts';
$route['v1/tests'] = 'v1/app/tests';
$route['v1/checkups'] = 'v1/app/checkups';
$route['v1/timeslot'] = 'v1/app/timeslot';
$route['v1/booktests'] = 'v1/app/booktests';
$route['v1/razorpayResponse'] = 'v1/app/razorpayResponse';
$route['v1/orders'] = 'v1/app/fetchOrders';
$route['v1/orderDetails'] = 'v1/app/orderDetails';
$route['v1/countries'] = 'v1/app/country';
$route['v1/states'] = 'v1/app/state';
$route['v1/cities'] = 'v1/app/city';
$route['v1/districts'] = 'v1/app/district';
$route['v1/videoapi'] = 'v1/app/videoapi';
$route['v1/vitalreport'] = 'v1/app/vitalReports';
$route['v1/vitalreportslist'] = 'v1/app/viewReports';
$route['v1/diagnostic'] = 'v1/app/diagnostic';
$route['v1/packagewithpayment'] = 'v1/app/packagewithpayment';
$route['v1/packagerazorpayResponse'] = 'v1/app/packagerazorpayResponse';
