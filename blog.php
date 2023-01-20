<?php
   include('session.php');
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <title>CAGBLOGS</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/js/bootstrap.min.js"></script>
  <style>
    /* Remove the navbar's default margin-bottom and rounded borders */ 
    .navbar {
      margin-bottom: 0;
      border-radius: 0;
    }
    
    /* Set height of the grid so .sidenav can be 100% (adjust as needed) */
    .row.content {height: 100%}
    
    /* Set gray background color and 100% height */
    .sidenav {
      padding-top: 20px;
      background-color: #f1f1f1;
      height: 100%;
    }
    
    /* Set black background color, white text and some padding */
    footer {
      background-color: #555;
      color: white;
      padding: 15px;
    }
    .progress{
    position: relative;
    background-color: #000000;
    border-radius: 0;
    }
    .progress-bar{
    position: absolute;
    width: 0%;
    left: 0;
    top: 0;
    heigth: 1px;
    background-color: #ffffff;
    transition: width 2s;
    }
    #loading{
    height: 20px;
    width: 20px;
    }
    /* On small screens, set height to 'auto' for sidenav and grid */
    @media screen and (max-width: 767px) {
      .sidenav {
        height: auto;
        padding: 15px;
      }
      .row.content {height:auto;} 
    }
  </style>

<script>
$(document).ready(function(){
    var pageno = "0";
    retrive();
    
    $("#nextpage").click(function() {
    pageno = pageno + 1;
    $("result").empty();
    retrive();
    });
    
    function retrive() {
    var pagedata = "loop="+pageno;
    var url = $("form").attr('action');
    $.ajax({
      type: "POST",
      url: url,
      data: pagedata,
      cache: false,
      success: function(result){
        $("#result").html(result)
      }
      });
      }
      
      $("#fileToUpload").change(function(){
        var allowedTypes = ['image/jpeg', 'image/png', 'image/jpg', 'image/gif'];
        var file = this.files[0];
        var fileType = file.type;
        if(!allowedTypes.includes(fileType)){
            alert('Please select a valid file (JPEG/JPG/PNG/GIF).');
            $("#fileToUpload").val('');
            return false;
        }
    });

    $("form").submit(function(event){
      event.preventDefault();
      var mode = $(this).attr('id');
      var url = $("form").attr('action');
      var ajaxdata = new FormData(this);
      $.ajax({
            xhr: function() {
                var xhr = new window.XMLHttpRequest();
                xhr.upload.addEventListener("progress", function(evt) {
                    if (evt.lengthComputable) {
                        var percentComplete = ((evt.loaded / evt.total) * 100);
                        $(".progress-bar").width(percentComplete + '%');
                        $(".progress-bar").html(percentComplete+'%');
                    }
                }, false);
                return xhr;
            },
            type: "POST",
            enctype: 'multipart/form-data',
            url: url,
            data: ajaxdata,
            processData: false,
            contentType: false,
            cache: false,
            timeout: 600000,
            beforeSend: function(){
                $(".progress-bar").width('0%');
                $('#loading').html('<img src="/loading.gif"/>');
            },
            success: function (data) {
                $("#status").text(data);
                $('#loading').empty();
            },
            error: function (e) {
                $("#status").text(e.responseText);
                console.log("ERROR : ", e);
            }
        });
    });
});
</script>

</head>
<body>
      <h1 class="text-center">Welcome <?php echo $login_session; ?><br>
      <a href = "/logout.php">Logout</a><br>
      Hi <?php echo $login_session; ?>, here you can send pictures with caption to your friends. Write down your friend's username in the to user box and also
      select a pic or write a caption. </h1>
<nav class="navbar navbar-inverse">
  <div class="container-fluid">
    <div class="navbar-header">
      <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>                        
      </button>
      <a class="navbar-brand" href="#"><span class="glyphicon">CAGBLOGS</span></a>
    </div>
    <div class="collapse navbar-collapse" id="myNavbar">
      <ul class="nav navbar-nav">
        <li class="active"><a href="#">Home</a></li>
        <li><a href="#">About</a></li>
        <li><a href="#">Projects</a></li>
        <li><a href="#">Contact</a></li>
      </ul>
      <ul class="nav navbar-nav navbar-right">
        <li><a href="/register/">Register New</a></li>
        <li><a href="/logout.php"><span class="glyphicon glyphicon-log-out"></span> Logout</a></li>
      </ul>
    </div>
    
  </div>
</nav>
  <div class="progress">
    <div class="progress-bar"></div>
    </div>
<div class="container-fluid text-left">    
  <div class="row content">
    <div class="col-sm-2 sidenav">
      <form id="postform" method="post" action="/blognew.php" enctype="multipart/form-data">
        <input type="file" name="fileToUpload" value="image" id="fileToUpload"><br>
        <textarea name="bcontent" id="textarea" rows="" cols="" placeholder= "Type here"></textarea><br>
        <input type="text" name="touser" id="touser" placeholder="to user">
        <input type="submit" value="Submit">
        <div id="status"><div id="loading"></div></div>
      </form>
    </div>

    <div class="col-sm-8 text-left"> 
        <h1 id="zoomout"></h1>
        <h2 id="showimg"></h2>
      <div id="result"></div>
      <button id="nextpage" name="nextpage">Next</button>
    </div>
    <div class="col-sm-2 sidenav">
      <div class="well">
        <p>ADS</p>
      </div>
      <div class="well">
        <p>ADS</p>
      </div>
    </div>
  </div>
</div>

<footer class="container-fluid text-center">
  <p>Footer Text</p>
</footer>

</body>
</html>
