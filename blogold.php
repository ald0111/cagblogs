<?php
   include('session.php');
?>
<html>
   
   <head>
      <title>Welcome </title>
      <link rel="stylesheet" type="text/css" href="blog.css">
   </head>
    


<body>

<div id="preheader">
      <h1>Welcome <?php echo $login_session; ?></h1> 
      <h2><a href = "logout.php">Sign Out</a></h2>
      <h1>Hi <?php echo $login_session; ?>, here you can send pictures with caption to your friends. Write down your friend's username in the to user box and also select a pic or write a caption. </h1>
</div>

<div class="sidebar" id="myHeader">
<form enctype="multipart/form-data" method="post" action="/blog.php">
    <input type="file" name="fileToUpload" value="image" id="fileToUpload"><br>
    <textarea name="bcontent" rows="4" cols="30" placeholder= "Type here"></textarea><br>
    <input type="text" name="touser" id="touser" placeholder="to user">
    <input type="submit" value="post" name="submit">
</form>
<h2><a href="http://cagblogs.atspace.eu/blog.php?receive=1" class="btn">Receive</a></h2>
</div>
<div id="mainblog">
<?php
// Check if image file is a actual image or fake image
 
function post() {
include('session.php');
if (!empty($_FILES["fileToUpload"]["name"])) {
$target_dir = "blog/upload/";
$rand = rand();
$target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
$uploadOk = 1;
$extn = $_FILES['fileToUpload']['name'];
$imageFileType = pathinfo($extn,PATHINFO_EXTENSION);
$imageFileType = strtolower($imageFileType);
    /*

    $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
    if($check !== false) {
        //echo "File is an image - " . $check["mime"] . ".";
        $uploadOk = 1;
    } else {
        //echo "File is not an image.";
        $uploadOk = 0;
    }

// Check if file already exists
if (file_exists($target_file)) {
    echo "Sorry, file already exists.";
    $uploadOk = 0;
}*/
// Check file size
if ($_FILES["fileToUpload"]["size"] > 500000000) {
    echo "Sorry, your file is too large.";
    $uploadOk = 0;
}
// Allow certain file formats
if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif" ) {
    echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
    $uploadOk = 0;
}
// Check if $uploadOk is set to 0 by an error
if ($uploadOk == 0) {
    echo "Sorry, there was an error. please check the file you selected is an image";

// if everything is ok, try to upload file
} else {
    $uploadOk = 1;
                $cag = $target_dir . $rand.'.' . $imageFileType;
                //global $cag;
                //echo $cag;
                //echo $imageFileType;
    if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $cag)) {
        //echo "Your post has been posted successfully.";
        //echo "The file ". basename( $_FILES["fileToUpload"]["name"]). " has been uploaded.";
    } else {
       echo "Sorry, there was an error uploading your file.";
    }
}
}
else {
    //echo "no file selected";
}

                         $contn = $_POST["bcontent"];
                         $touser = $_POST["touser"];
                         if ($contn=="") {
                         $contn = "null";
                         }
                         if(ctype_space($contn)) {
                         $contn = "null";
                         }
                         if(ctype_space($touser)) {
                         $touser = "";
                         }
                        /* echo $contn;
                         echo $touser;
                         echo $cag;
                         echo $login_session;
*/
include ('config.php');
            if (($touser!="") && ($contn!="null" || !empty($cag))) {
                        //echo $cag;
                         if ($cag=="") {
                         $cag = "null";
                         }
                         if(ctype_space($cag)) {
                         $cag = "null";
                         }
                                        $sqls = "INSERT INTO bcont (user, contfrblg, picaddress, touser)
                                        VALUES ('$login_session', '$contn', '$cag', '$touser')";
                                        if (mysqli_query($db, $sqls)) {
                                        echo "<script>window.location.href = 'http://cagblogs.atspace.eu/index.php';</script>";
                                        }
                                        else {
                                        echo "Error: " . $sqls . "<br>" . mysqli_error($db);
                                        }
                                        mysqli_close($db);
                                        exit();
                                        
}

else {
        echo"you need to fill to user and select a pic or write a caption";
}

}
function receive(){
include ('config.php');
include('session.php');
$sqls = "SELECT * FROM bcont WHERE touser = '$login_session'";
if($result = mysqli_query($db, $sqls)) {
if ($result->num_rows > 0) {
    // output data of each row
    while($row = $result->fetch_assoc()) {
        $fromuser = $row[user];
        $caption = $row[contfrblg];
        $picaddress = $row[picaddress];
                if($caption!="null" && $picaddress!="null") {           
                
    $piclink = "http://cagblogs.atspace.eu/" . $row[picaddress];
    //$pichperlink = "<a href='$piclink'>picture</a>";
        echo "<br> From:" . $row[user] . "<br><br> Caption:" . $row[contfrblg] . "<br>" . "<img src='$piclink' alt='$caption' width='100%'>" . "<br><hr><br>";

}

        if($caption=="null" && $picaddess!="null") {                
            $piclink = "http://cagblogs.atspace.eu/" . $row[picaddress];
            //$pichperlink = "<a href='$piclink'>picture</a>";
            echo "<br> From:" . $row[user] . "<br><br>" . "<img src='$piclink' alt='picture' width='100%'>" . "<br><hr><br>";
}

        if($caption!="null" && $picaddress=="null") {                
            //$piclink = "http://cagblogs.atspace.eu/" . $row[picaddress];
            //$pichperlink = "<a href='$piclink'>picture</a>";
            echo "<br> From:" . $row[user] . "<br><br> Caption:" . $row[contfrblg] . "<br><hr><br>";
}

}
} else {
    echo "No One Has Sent You Any Pictures.";
}
}
else {
echo "An Error Occured. Please Try Again.";
}
}
  if($_GET['receive'] == "1"){
    receive();
  }
  if(isset($_POST["submit"])) {
        post();
}    
?>
<script>
window.onscroll = function() {myFunction()};

var header = document.getElementById("myHeader");
var sticky = header.offsetTop;

function myFunction() {
  if (window.pageYOffset > sticky) {
    header.classList.add("sticky");
  } else {
    header.classList.remove("sticky");
  }
}
</script>
</div>
</body>
</html>