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
        <title><?php echo title;?></title>
        <!-- This page plugin CSS -->
        <link href="<?=asset_url()?>css/dataTables.bootstrap4.css" rel="stylesheet">
        <!-- Custom CSS -->
        <link href="<?=asset_url()?>css/style.min.css" rel="stylesheet">
        <link rel="stylesheet" type="text/css" href="<?=asset_url()?>select2/dist/css/select2.min.css">
        <style type="text/css">
            .banner {
  padding: 0;
  background-color: #52575c;
  color: white;
}

.banner-text {
  padding: 8px 20px;
  margin: 0;
}


#join-form {
  margin-top: 10px;
}

.tips {
  font-size: 12px;
  margin-bottom: 2px;
  color: gray;
}

.join-info-text {
  margin-bottom: 2px;
}



.player {
  width: 480px;
  height: 320px;
}

.player-name {
  margin: 8px 0;
}

#success-alert, #success-alert-with-token {
  display: none;
}

@media (max-width: 640px) {
  .player {
    width: 320px;
    height: 240px;
  }
}


#video-streams{
    display:grid;
    grid-template-columns: repeat(auto-fit, minmax(500px, 1fr));
    height: 90vh;
    width: 560px;
    margin:0 auto;

}

.video-container{
    max-height: 100%;
    border: 2px solid black;
    background-color: #203A49;
}

.video-player{
    height: 100%;
    width: 100%;
}

button{
    border:none;
    background-color: cadetblue;
    color:#fff;
    padding:10px 20px;
    font-size:16px;
    margin:2px;
    cursor: pointer;
}

#stream-controls{
    display: none;
    justify-content: center;
    margin-top:0.5em;
}

@media screen and (max-width:1400px){
    #video-streams{
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        width: 95%;
    }
}
        </style>

    </head>
    <body>
        <!-- ============================================================== -->
        <!-- Preloader - style you can find in spinners.css -->
        <!-- ============================================================== -->
        <div class="preloader">
            <div class="lds-ripple">
                <div class="lds-pos"></div>
                <div class="lds-pos"></div>
            </div>
        </div>
        <!-- ============================================================== -->
        <!-- Main wrapper - style you can find in pages.scss -->
        <!-- ============================================================== -->
        <div id="main-wrapper">
            <?=$header?>
            <?=$leftmain?>
            <!-- Page wrapper  -->
            <!-- ============================================================== -->
            <div class="page-wrapper">
                <!-- ============================================================== -->
                <!-- Bread crumb and right sidebar toggle -->
                <!-- ============================================================== -->
                <div class="row page-titles">
                    <div class="col-md-5 col-12 align-self-center">
                        <h3 class="text-themecolor mb-0">Video</h3>
                        <ol class="breadcrumb mb-0 p-0 bg-transparent">
                            <li class="breadcrumb-item"><a href="<?=base_url()?>">Dashboard</a></li>
                            <li class="breadcrumb-item active">Video</li>
                        </ol>
                    </div>
                </div>
                <!-- Container fluid  -->
                <!-- ============================================================== -->
                <div class="container-fluid">
                    <div id="success-alert-with-token" class="alert alert-success alert-dismissible fade show" role="alert">
  <strong>Congratulations!</strong><span> Joined room successfully. </span>
  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
    <span aria-hidden="true">&times;</span>
  </button>
</div>
                    <!-- ============================================================== -->
                    <!-- Start Page Content -->
                    <!-- ============================================================== -->          
                    <?php
                    if( $this->session->flashdata('message') != null )
                        echo $this->session->flashdata('message');
                    ?>
                    <div class="card">
                        <div class="card-body">
                            <h4 class="card-title">Video</h4>
                            <div class="card-tools">
                           
                            </div><hr>
                            
                            <table id="category_table" class="table display table-bordered table-striped no-wrap" style="width:100%;">
                                <thead>
                                    <tr>
                                        <th>Sl. No.</th>
                                        <th>Action</th>
                                        <th>Video Link</th>
                                        <th>Name</th>
                                        <th>Email</th>
                                        <th>Mobile Number</th>
=                                    </tr>
                                </thead>
                                <tbody></tbody>
                            </table>
                            
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xs-12 col-sm-3 col-md-3 col-lg-3"></div>
                        <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
             <div id="video-streams"></div>
 <div id="stream-controls">
            <button id="leave-btn">Leave Stream</button>
      
        </div>
                            
                        </div>
                        <div class="col-xs-12 col-sm-3 col-md-3 col-lg-3"></div>
                        <div class="clearfix"></div>
                    </div>
                </div>
                <!-- End Container fluid  -->
                <!-- footer -->
                <?=$footer?>
                <!-- End footer -->
            </div>
            <!-- End Page wrapper  -->
        </div>
        <!-- End Wrapper -->
    
        <div class="chat-windows"></div>
	<script src="<?=asset_url()?>js/jquery.min.js"></script>
    <!-- Bootstrap tether Core JavaScript -->
    <script src="<?=asset_url()?>js/popper.min.js"></script>
    <script src="<?=asset_url()?>js/bootstrap.min.js"></script>
    <!-- apps -->
    <script src="<?=asset_url()?>js/app.min.js"></script>
    <script src="<?=asset_url()?>js/app.init.mini-sidebar.js"></script>
    <script src="<?=asset_url()?>js/app-style-switcher.js"></script>
    <!-- slimscrollbar scrollbar JavaScript -->
    <script src="<?=asset_url()?>js/perfect-scrollbar/dist/perfect-scrollbar.jquery.min.js"></script>
    <script src="<?=asset_url()?>js/extra-libs/sparkline/sparkline.js"></script>
    <!--Wave Effects -->
    <script src="<?=asset_url()?>js/waves.js"></script>
    <!--Menu sidebar -->
    <script src="<?=asset_url()?>js/sidebarmenu.js"></script>
    <!--Custom JavaScript -->
    <script src="<?=asset_url()?>js/custom.min.js"></script>
        <script src="<?=asset_url()?>js/datatables/media/js/jquery.dataTables.min.js"></script>
        <script src="<?=asset_url()?>js/datatable/custom-datatable.js"></script>
        <script src="<?=asset_url()?>js/datatable/datatable-basic.init.js"></script>
        <script src="<?=asset_url()?>js/AgoraRTC_N-4.7.3.js"></script>
        
        <script>

            var dataTable, edit_data;
            function initialiseData(){
                dataTable = $('#category_table').DataTable({  
                    "processing":true,  
                    "serverSide":true,  
                    "searching": true,
                    "order":[],  
                    "ajax":{  
                        url:"<?=base_url().'master/videoList'?>",  
                        type:"POST",
                        data: function(d){
                            //d.form = $("#searchForm").serializeArray();
                        },
                        error: function(){  // error handling
                            $(".user_data-error").html("");
                            $("#user_data").append('<tbody class="user_data-error"><tr><th colspan="5">No data found in the server</th></tr></tbody>');
                            $("#user_data_processing").css("display","none");
                        }
                    },"columnDefs":[  
                        {  
                            "targets":[2],  
                            "orderable":false,  
                        },  
                    ],'rowCallback': function(row, data, index){
                        //$(row).find('td:eq(3)').css('background-color', data[3]).html("");   
                    }
                }); 
            }
initialiseData();

// $(document).ready(function() {

// 	$("#join").on('click',function(){
//         console.log('Working');
// 	});
// });

$(document).ready(function(){
    $(document).on('click','.joinbtn',function(){
        var uid = $(this).attr('data-uid');
        var appid = $(this).attr('data-appid');
        var webtoken = $(this).attr('data-webtoken');
        var channel = $(this).attr('data-channel');
        



const APP_ID =appid;
const TOKEN =webtoken;
const CHANNEL =channel;

const client = AgoraRTC.createClient({mode:'rtc', codec:'vp8'})

let localTracks = []
let remoteUsers = {}

let joinAndDisplayLocalStream = async () => {

    client.on('user-published', handleUserJoined)
    
    client.on('user-left', handleUserLeft)
    
    let UID = await client.join(appid, channel, webtoken, uid)

    localTracks = await AgoraRTC.createMicrophoneAndCameraTracks() 

    let player = `<div class="video-container" id="user-container-${UID}">
                        <div class="video-player" id="user-${UID}"></div>
                  </div>`
    document.getElementById('video-streams').insertAdjacentHTML('beforeend', player)

    localTracks[1].play(`user-${UID}`)
    
    await client.publish([localTracks[0], localTracks[1]])
}

let joinStream = async () => {
    await joinAndDisplayLocalStream()
    document.getElementById('join-btn').style.display = 'none'
    document.getElementById('stream-controls').style.display = 'flex'
}

let handleUserJoined = async (user, mediaType) => {
    remoteUsers[user.uid] = user 
    await client.subscribe(user, mediaType)

    if (mediaType === 'video'){
        let player = document.getElementById(`user-container-${user.uid}`)
        if (player != null){
            player.remove()
        }

        player = `<div class="video-container" id="user-container-${user.uid}">
                        <div class="video-player" id="user-${user.uid}"></div> 
                 </div>`
        document.getElementById('video-streams').insertAdjacentHTML('beforeend', player)

        user.videoTrack.play(`user-${user.uid}`)
    }

    if (mediaType === 'audio'){
        user.audioTrack.play()
    }
}

let handleUserLeft = async (user) => {
    delete remoteUsers[user.uid]
    document.getElementById(`user-container-${user.uid}`).remove()
}

    


 let leaveAndRemoveLocalStream = async () => {
    for(let i = 0; localTracks.length > i; i++){
        localTracks[i].stop()
        localTracks[i].close()
    }

    await client.leave()
    document.getElementById('join-btn').style.display = 'block'
    document.getElementById('stream-controls').style.display = 'none'
    document.getElementById('video-streams').innerHTML = ''
}
      
document.getElementById('leave-btn').addEventListener('click', leaveAndRemoveLocalStream);

document.getElementById('join-btn').addEventListener('click', joinStream);
    });



});



    //   let leaveAndRemoveLocalStream = async () => {
    // for(let i = 0; localTracks.length > i; i++){
    //     localTracks[i].stop()
    //     localTracks[i].close()
    // }

</script>

      <!--     document.getElementById('join-btn').addEventListener('click', joinStream)
document.getElementById('leave-btn').addEventListener('click', leaveAndRemoveLocalStream)
document.getElementById('mic-btn').addEventListener('click', toggleMic)
document.getElementById('camera-btn').addEventListener('click', toggleCamera)   -->

    </body>
</html>