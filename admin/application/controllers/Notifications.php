<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
error_reporting(E_ALL);ini_set('display_errors', '1');
class Notifications extends CI_Controller {   

	protected $data;
    public function __construct()
    {
        parent::__construct();
        $this->load->helper('utility_helper');
        no_cache();
        $this->data['detail'] = '';
        $this->data['session'] = ADMIN_SESSION;
        $this->load->model('home_db');
        $this->load->model('master_db');
        $this->load->model('web_db');
        
        if (!$this->session->userdata($this->data['session'])) {
            redirect('Login', 'refresh');
        }else{
            $sessionval = $this->session->userdata($this->data['session']);
            $exp = explode("~", $sessionval);
            if(count($exp) == 2){
                $db['phone']=$exp[0];
                $db['password']=$exp[1];
                $details = $this->home_db->getlogin($db, 0);
                if(count($details) && $details[0]->password == $exp[1]){  
                    
                    if($details[0]->status == 1){
                        $this->data['detail']=$details;
                    }else{
                        $this->session->set_flashdata('message','<div class="alert alert-danger alert-dismissable"><button class="close" aria-hidden="true" data-dismiss="alert" type="button">&times;</button>Your account has been deactivated. Please contact Administrator.</div>');
                        redirect(base_url()."login/logout");
                    }
                }else{
                    $this->session->set_flashdata('message','<div class="alert alert-danger alert-dismissable"><button class="close" aria-hidden="true" data-dismiss="alert" type="button">&times;</button>Invalid Credentials.</div>');
                    redirect(base_url()."login/logout");
                }
            }else{
                $this->session->set_flashdata('message','<div class="alert alert-danger alert-dismissable"><button class="close" aria-hidden="true" data-dismiss="alert" type="button">&times;</button>Invalid Credentials.</div>');
                redirect(base_url()."login/logout");
            }
        }
        
        $this->data['updatelogin']=$this->load->view('updatelogin', NULL , TRUE);
        $this->data['style']=$this->load->view('style', $this->data , TRUE);
        $this->data['header']=$this->load->view('header', $this->data , TRUE);
        $this->data['footer']=$this->load->view('footer', $this->data , TRUE);
        $this->data['leftmain']=$this->load->view('leftmenudynamic', NULL , TRUE);
        $this->data['jsfile']=$this->load->view('jsfile', NULL , TRUE);
    }    

    public function index(){
        $this->notify();
    }
	
	public function notify(){
        $this->load->view('notifications/notify_view',$this->data);
    }

    public function notifyList(){
        $det = $this->data['detail'];
        $data_list = $this->web_db->getNotifyList($det);
        $log = $this->db->last_query();
        $file = 'sql.txt';
        //$json = "sdsd";
        $log = $log."\r\n";
        //file_put_contents($file, $log , FILE_APPEND | LOCK_EX);
        $data = array();
        $i = $_POST["start"]+1;
        
        foreach($data_list as $row)
        {
            $sub_array = array();
            $sub_array[] = $i++;
            $action = '<button type="button" title="Edit" name="update" onclick="modifyRow('.$row->id.');" class="btn btn-primary btn-sm"><i class="fas fa-edit"></i></button>&nbsp;';
            
            if( (int)$row->status == 1 ){
                $status = "<span class='text-success'><i class='fas fa-check'></i> Active</span>";
                $action .= "<button title='Deactive' onclick='updateStatus(".$row->id.", 0)' class='btn btn-warning btn-sm'><i class='fas fa-times-circle'></i></button>&nbsp;";
            }else{
                $status = "<span class='text-warning'><i class='fas fa-times-circle'></i> In-Active</span>";
                $action .= "<button title='Activate' onclick='updateStatus(".$row->id.", 1)' class='btn btn-success btn-sm'><i class='fas fa-check'></i></button>&nbsp;";
            }
            $action .= "<button title='Delete' onclick='updateStatus(".$row->id.", -1)' class='btn btn-danger btn-sm'><i class='fas fa-trash'></i></button>&nbsp;";
            $image="<img src='".app_asset_url().$row->image_path."' width='100px' height='100px'>";
            $sub_array[] = $action;
            
            $sub_array[] = $row->title;
			$sub_array[] = $image;
			$sub_array[] = $row->datetime;
            $sub_array[] = $status;
            $data[] = $sub_array;
            
        }
        $_POST["length"] = -1;
        $flashnews = $this->web_db->getNotifyList($det);
        
        $total = count($flashnews);
        $output = array(
            "draw"              =>  intval($_POST["draw"]),
            "recordsTotal"      =>  $total,
            "recordsFiltered"   =>  $total,//$this->master_db->get_filtered_data("guards")
            "data"              =>  $data
        );
        echo json_encode($output);
    }

   public function add_notify(){
		$this->data['type'] = 1;
		$this->data['customer'] =  $this->master_db->getRecords('customers',array('status ='=>'1'),'id,name');
        $this->load->view('notifications/notify_add',$this->data);
    }
	
	
	public function edit_notify(){
		$this->data['type'] = 2;
		$id = trim($this->input->get('id'));
		
		$this->data['details'] =  $this->master_db->getRecords('notifications',array('status !='=>'-1','id'=>$id),'id,title,descr,image_path,date_time,notify,state_id,district_id,taluk_id');
		//echo $this->db->last_query();exit;
        $this->load->view('notifications/notify_add',$this->data);
    }
	
	
	
    public function saveNotify(){
        $det = $this->data['detail'];
		$id = trim(preg_replace('!\s+!', ' ',html_escape($this->input->post('id', true))));
		
		$title = trim(preg_replace('!\s+!', ' ',html_escape($this->input->post('title', true))));
		$descr = $this->input->post('descr');
		$date_time = trim(preg_replace('!\s+!', ' ',html_escape($this->input->post('date_time', true))));
		$notify = isset($_POST['notify']) ? '1' : '0';
		$state_id = trim(preg_replace('!\s+!', '',html_escape($this->input->post('state_id', true))));
		$district_id = trim(preg_replace('!\s+!', ' ',html_escape($this->input->post('district_id', true))));
		$taluk_id = trim(preg_replace('!\s+!', ' ',html_escape($this->input->post('taluk_id', true))));
		$user_id = $this->input->post('user_id');
        if(!empty($_POST['title']) && !empty($_POST['descr']) && !empty($_POST['id'])){
            
           
                $update_data = array(
					'title'       =>  $title,
					'descr'       =>  $descr,
					'notify'      =>  $notify,
					'state_id'    =>  $state_id,
					'district_id' =>  $district_id,
					'taluk_id'    =>  $taluk_id,
					//'date_time'   =>  date('Y-m-d H:i:s',strtotime($date_time)),
                    'updated_at'  =>  date('Y-m-d H:i:s'),
                    'updated_by'  =>  $det[0]->id
                );
                $imgfile="";
				//echo '<pre>';print_r($_FILES['image_path']['name']);exit;
				if( !empty($_FILES['image_path']['name']) ){
					$config = array();
					$config['upload_path'] = '../app_assets/notify/';  
					$config['allowed_types'] = 'pdf|jpeg|jpg|png';
					$config['max_size'] = 0;    
					// I have chosen max size no limit 
					//$new_name = $code.'_'. $_FILES["document"]['name']; 
					$ext = pathinfo($_FILES["image_path"]['name'], PATHINFO_EXTENSION);
					$new_name = 'notify'.'.'.$ext; 

					$config['file_name'] = $new_name;
					//Stored the new name into $config['file_name']
					$this->load->library('upload', $config);
					if (!$this->upload->do_upload('image_path') && !empty($_FILES['image_path']['name'])) {
						$error = array('error' => $this->upload->display_errors());
						//echo '<pre>';print_r($error);exit;
					} else {
						$upload_data = $this->upload->data();
						//echo '<pre>';print_r($upload_data);exit;
						$update_data['image_path'] = 'notify/'.$upload_data['file_name'];
						$imgfile .= 'https://www.lifeonplus.com/app_assets/notify/'.$upload_data['file_name'];
					}
				}
				
				
                $this->master_db->updateRecord('notifications',$update_data,array('id'=>$id));
				
				 $gcm_ids =  $igcm_ids  = array();
				 if(count($user_id))
				 {
					$this->master_db->updateRecord('recipient_notify',array('status'=>'-1'),array('notify_id'=>$id));
					foreach($user_id as $u)
					{
						$check = $this->master_db->getRecords('recipient_notify',array('notify_id'=>$id,'user_id'=>$u),'id');
						
						$insert_user = array('notify_id'=>$id,'user_id'=>$u,'status'=>1);
						if(count($check) == 0)
						{
						   $this->master_db->insertRecord('recipient_notify',$insert_user);
						}
						else{
							$this->master_db->updateRecord('recipient_notify',array('status'=>1),array('notify_id'=>$id,'user_id'=>$u));
						}
						
						$custList = $this->master_db->getRecords('customers',array('status'=>1,'id'=>$u),'gcm_id,device_id,device_type');
						
						if(@$custList[0]->device_type==1)
						{
						  $gcm_ids[] =@$custList[0]->gcm_id;
						}	
                        
						if(@$custList[0]->device_type==2)
						{
						  $igcm_ids[] =@$custList[0]->device_id;
						}
					}
				 }
				 		$records = $this->master_db->getRecords('notifications',array('id'=>$id),'image_path');

				 
				$this->load->library('notify');
				if($notify == 1 && count($gcm_ids)>0)
				{
					$regIdChunk=array_chunk($gcm_ids,1000);
					$message_status="";
					for($k=0;$k<count($regIdChunk);$k++)
					{
						$message_status = $this->notify->sendNotification($regIdChunk[$k], $title,"notification","https://www.lifeonplus.com/app_assets/".$records[0]->image_path);
						//echo '________'.$message_status;exit;
					}

				}
				
				if($notify==1 && count($igcm_ids)>0)
                {
                    $regIdChunk=array_chunk($igcm_ids,1000);
                    $message_status="";

                    for($k=0;$k<count($regIdChunk);$k++)
                    {
                        $message_status = $this->notify->sendNotificationIOS($regIdChunk[$k], $title,"notification");
                    }
                }
                $this->session->set_flashdata('message','<div class="alert alert-success alert-dismissable"><button class="close" aria-hidden="true" data-dismiss="alert" type="button">&times;</button> Updated Successfully!</div>');
			    redirect(base_url().'notifications');
            
        }
		else if(!empty($_POST['title']) && !empty($_POST['descr'])){
           
          
                $insert_data = array(
                   // 'cat_id'       =>  $cat_id,
					'title'        =>  $title,
					'descr'        =>  $descr,
					'notify'       =>  $notify,
					'state_id'     =>  $state_id,
					'district_id'  =>  $district_id,
					'taluk_id'     =>  $taluk_id,
					//'date_time'    =>  date('Y-m-d H:i:s',strtotime($date_time)),
                    'created_at'   =>  date('Y-m-d H:i:s'),
                    'created_by'   =>  $det[0]->id,
                    'status'       =>  1,
                );
				//echo '<pre>';print_r($_FILES['image_path']['name']);exit;
				if( !empty($_FILES['image_path']['name']) ){
                $config = array();
                $config['upload_path'] = '../app_assets/notify/';  
                $config['allowed_types'] = 'pdf|jpeg|jpg|png';
                $config['max_size'] = 0;    
                // I have chosen max size no limit 
                //$new_name = $code.'_'. $_FILES["document"]['name']; 
                $ext = pathinfo($_FILES["image_path"]['name'], PATHINFO_EXTENSION);
                $new_name = 'flashnews'.'.'.$ext; 

                $config['file_name'] = $new_name;
                //Stored the new name into $config['file_name']
                $this->load->library('upload', $config);
                if (!$this->upload->do_upload('image_path') && !empty($_FILES['image_path']['name'])) {
                    $error = array('error' => $this->upload->display_errors());
                    //echo '<pre>';print_r($error);exit;
                } else {
                    $upload_data = $this->upload->data();
                    //echo '<pre>';print_r($upload_data);exit;
                    $insert_data['image_path'] = 'notify/'.$upload_data['file_name'];
                }
            }
				
                $id = $this->master_db->insertRecord('notifications',$insert_data);
				
				 $gcm_ids =  $igcm_ids  = array();
				 if(count($user_id))
				 {
					$this->master_db->updateRecord('recipient_notify',array('status'=>'-1'),array('notify_id'=>$id));
					foreach($user_id as $u)
					{
						$check = $this->master_db->getRecords('recipient_notify',array('notify_id'=>$id,'user_id'=>$u),'id');
						
						$insert_user = array('notify_id'=>$id,'user_id'=>$u,'status'=>1);
						if(count($check) == 0)
						{
						   $this->master_db->insertRecord('recipient_notify',$insert_user);
						}
						else{
							$this->master_db->updateRecord('recipient_notify',array('status'=>1),array('notify_id'=>$id,'user_id'=>$u));
						}
					    $custList = $this->master_db->getRecords('customers',array('status'=>1,'id'=>$u),'gcm_id,device_id,device_type');
						
						if(@$custList[0]->device_type==1)
						{
						  $gcm_ids[] =@$custList[0]->gcm_id;
						}	
                        
						if(@$custList[0]->device_type==2)
						{
						  $igcm_ids[] =@$custList[0]->device_id;
						}
					}
				 }
	$records = $this->master_db->getRecords('notifications',array('id'=>$id),'image_path');

				 
				$this->load->library('notify');
				if($notify == 1 && count($gcm_ids)>0)
				{
					$regIdChunk=array_chunk($gcm_ids,1000);
					$message_status="";
					//print_r($gcm_ids);
					for($k=0;$k<count($regIdChunk);$k++)
					{
						$message_status = $this->notify->sendNotification($regIdChunk[$k], $title,"notification","https://www.lifeonplus.com/app_assets/".$records[0]->image_path);
						//echo '________'.$message_status;exit;
					}

				}
				
				if($notify==1 && count($igcm_ids)>0)
                {
                    $regIdChunk=array_chunk($igcm_ids,1000);
                    $message_status="";

                    for($k=0;$k<count($regIdChunk);$k++)
                    {
                        $message_status = $this->notify->sendNotificationIOS($regIdChunk[$k], $title,"notification");
                    }
                }
				
               $this->session->set_flashdata('message','<div class="alert alert-success alert-dismissable"><button class="close" aria-hidden="true" data-dismiss="alert" type="button">&times;</button> Added Successfully!</div>');
			   redirect(base_url().'notifications');
           
        }
    }


    public function setNotifyStatus(){
        $det = $this->data['detail'];
        $id = trim($this->input->post('id'));
        $status = trim($this->input->post('status'));

        $where_data = array(
            'status'=>$status,
            'updated_at'=>date('Y-m-d H:i:s'),
            'updated_by'=>$det[0]->id
        );
        $this->master_db->updateRecord('notifications',$where_data,array('id'=>$id));
        echo 1;
    }
	
	
	function getUsers(){
        
		$state_id = trim($this->input->post('state_id'));
        $district_id = trim($this->input->post('district_id'));
		$taluk_id = trim($this->input->post('taluk_id'));
		
		
        $list = $this->web_db->getCustomers($state_id,$district_id,$taluk_id);
        $result = array('status'=>'success','data'=>$list);
        echo json_encode($result);
    }
	
	
	
	
	
	
	
}
?>