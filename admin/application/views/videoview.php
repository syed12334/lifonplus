

<?php //echo "<pre>";print_r($gettokens);
?><!DOCTYPE html>
<html>
<head>
    <meta charset='utf-8'>
    <meta http-equiv='X-UA-Compatible' content='IE=edge'>
    <title>Lifeonplus Video Streaming</title>
    <meta name='viewport' content='width=device-width, initial-scale=1'>
            <link href="<?=asset_url()?>css/style.min.css" rel="stylesheet">

    <style type="text/css">
 
*{
    font-family: sans-serif;
}
h1,h4{
    text-align: center;
}
#me{
    position: relative;
    width: 100%;
    margin: 0 auto;
    display: block;
}
#me video{
    position: relative !important;
}
#remote-container{
    display: flex;
}
#remote-container video{
    height: auto;
    position: relative !important;
}
    </style>
</head>
<body>

<h1>
     <div class="container">
         <div class="row" style="margin-top:100px">
             <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                 <div id="me"></div>
             </div>
             <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                   <div id="remote-container">
    </div>
             </div>
             <div class="clearfix"></div>
             <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                 <button type="button" id="leave" class="btn btn-danger" style="margin-top:40px">Leave</button>
             </div>
             <div class="clearfix"></div>
         </div>
     </div>

  
        <script src="<?=asset_url()?>js/jquery.min.js"></script>
<script src="https://cdn.agora.io/sdk/release/AgoraRTCSDK-3.6.10.js"></script>
    <script type="text/javascript">

let handleError = function(err){
        console.log("Error: ", err);
};

// Query the container to which the remote stream belong.
let remoteContainer = document.getElementById("remote-container");

// Add video streams to the container.
function addVideoStream(elementId){
        // Creates a new div for every stream
        let streamDiv = document.createElement("div");
        // Assigns the elementId to the div.
        streamDiv.id = elementId;
        // Takes care of the lateral inversion
        streamDiv.style.transform = "rotateY(180deg)";
        // Adds the div to the container.
        remoteContainer.appendChild(streamDiv);
};

// Remove the video stream from the container.
function removeVideoStream(elementId) {
        let remoteDiv = document.getElementById(elementId);
        if (remoteDiv) remoteDiv.parentNode.removeChild(remoteDiv);
};

let client = AgoraRTC.createClient({
    mode: "rtc",
    codec: "vp8",
});

client.init("<?php echo $gettokens[0]->appid; ?>", function() {
    console.log("client initialized");
}, function(err) {
    console.log("client init failed ", err);
});

// Join a channel
client.join("<?php echo $gettokens[0]->webtoken;?>", "<?php echo $gettokens[0]->channelname; ?>", <?php echo $gettokens[0]->wuid; ?>, (uid)=>{
  // Create a local stream
}, handleError);


let localStream = AgoraRTC.createStream({
    audio: true,
    video: true,
});
// Initialize the local stream
localStream.init(()=>{
    // Play the local stream
    localStream.play("me");
    // Publish the local stream
    client.publish(localStream, handleError);
}, handleError);

// Subscribe to the remote stream when it is published
client.on("stream-added", function(evt){
    client.subscribe(evt.stream, handleError);
});
// Play the remote stream when it is subsribed
client.on("stream-subscribed", function(evt){
    let stream = evt.stream;
    let streamId = String(stream.getId());
    addVideoStream(streamId);
    stream.play(streamId);
});


// Remove the corresponding view when a remote user unpublishes.
client.on("stream-removed", function(evt){
    let stream = evt.stream;
    let streamId = String(stream.getId());
    stream.close();
    removeVideoStream(streamId);
});
$(document).on('click','#leave',function(e) {
    e.preventDefault();
    // Remove the corresponding view when a remote user leaves the channel.
leave();
});

function leave() {
  // for (trackName in localTracks) {
  //   var track = localTracks[trackName];
  //   if(track) {
  //     track.stop();
  //     track.close();
  //     localTracks[trackName] = undefined;
  //   }
  // }

  // Remove remote users and player views.
  remoteUsers = {};
  $("#remote-playerlist").html("");

  // leave the channel
  client.leave();
  console.log("client leaves channel success");

}

    </script>
</body>

</html>