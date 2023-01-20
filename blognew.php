<?php

include('session.php');

function fetch() { 
include ('config.php');
include('session.php');
//$loop = "0";
$next = $_POST["loop"];
$ten = "10";
$offset = "0";
if($next>0) {
        $offset = $next * $ten;
      }
        $sqls = "SELECT * FROM bcont WHERE touser = '$login_session' LIMIT 10 OFFSET $offset";
if($result = mysqli_query($db, $sqls)) {
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $fromuser = $row[user];
        $caption = $row[contfrblg];
        $picaddress = $row[picaddress];
                if($caption!="null" && $picaddress!="null") {           
    $piclink = "http://cagblogs.atspace.eu/" . $row[picaddress];
            echo "<h3>From:" . $row[user] . "</h3>";
            echo "<p>Caption:" . $row[contfrblg] . "</p>";
            echo "<img src='$piclink' alt='$caption' class='rounded'width='100%'>";
            echo "<hr>";
}
        if($caption=="null" && $picaddess!="null") {                
            $piclink = "http://cagblogs.atspace.eu/" . $row[picaddress];
            echo "<h3>From:" . $row[user] . "</h3>";
            echo "<img src='$piclink' alt='$caption' class='rounded'width='100%'>";
            echo "<hr>";
}
        if($caption!="null" && $picaddress=="null") {                
            echo "<h3>From:" . $row[user] . "</h3>";
            echo "<p>Caption:" . $row[contfrblg] . "</p>";
}
}
}
else {
    echo "<p>No One Has Sent You Anything!.</p>";
}
}
else {
echo "<p>An Error Occured. Please Try Again.</p>";
}
}

function post() {
$cag="";
include('session.php');
if (!empty($_FILES["fileToUpload"]["name"])) {
$target_dir = "blog/upload/";
$rand = rand();
$target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
$uploadOk = 1;
$extn = $_FILES['fileToUpload']['name'];
$imageFileType = pathinfo($extn,PATHINFO_EXTENSION);
$imageFileType = strtolower($imageFileType);
if ($_FILES["fileToUpload"]["size"] > 500000000) {
    echo "Sorry, your file is too large.";
    $uploadOk = 0;
}
if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif" ) {
    echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
    $uploadOk = 0;
}
if ($uploadOk == 0) {
    echo "Sorry, there was an error. please check the file you selected is an image";
}
 else {
    $uploadOk = 1;
                $cag = $target_dir . $rand.'.' . $imageFileType;
    if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $cag)) {
        $uploadOk = 1;
    } else {
       echo "Sorry, there was an error uploading your file.";
    }
}
}
else {
    $cag = "";
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
                                        echo "Success!";
                                        //echo "<script>window.location.href = 'http://cagblogs.atspace.eu/index.php';</script>";
                                        }
                                        else {
                                        echo "Error: " . $sqls . "<br>" . mysqli_error($db);
                                        }
                                        mysqli_close($db);
                                        exit();                                        
}
else {
        echo"you need to fill to user and select a pic or write a caption";
        echo $_POST['touser'];
}
}

if($_SERVER['REQUEST_METHOD'] == "POST") {
if(isset($_POST["loop"])) {
  fetch();
} else {
  post();
}
}

?>