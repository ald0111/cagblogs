<?php

if($_SERVER['REQUEST_METHOD'] == "POST") {

if((isset($_POST['username'])) && (isset($_POST['password']))) {
        $uname = $_POST['username'];
        $password = $_POST['password'];
        if(($uname == "tweteen") && ($password == "20182018")) {
                $obj = array(valid=> "true");
                echo json_encode($obj);
        } else {
                $obj = array(valid=> "false");
                echo json_encode($obj);
        }
} else {

$myObj = array(
    name => "John",
    age => 30,
    city => "New York"
);
    $myJSON = json_encode($myObj);

    echo $myJSON;
}
} else {

    echo "you entered get method";

}
?>