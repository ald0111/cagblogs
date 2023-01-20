<?php
  $nameErr = $emailErr = $unameErr = $lnameErr = $passwordErr = $cpassword = $date = "";
  $name = $email = $uname = $lname = $password = $cpasswordErr = "";
  $date = date("y-m-d H:m:s");
if ($_SERVER["REQUEST_METHOD"] == "POST") {
                        if (empty($_POST["name"])) {
                        $nameErr = "Name is required";
                        }
                        else {
                        $name = $_POST["name"];
                        if (!preg_match("/^[a-zA-Z ]*$/",$name)) {
                        $nameErr = "Only letters and white space allowed"; 
                        }
                        }
      if (empty($_POST["lname"])) {
      $lnameErr = "Last Name is required";
      }
      else {
      $lname = $_POST["lname"];
      if (!preg_match("/^[a-zA-Z ]*$/",$lname)) {
      $lnameErr = "Only letters and white space allowed"; 
      }
      }
              if (empty($_POST["uname"])) {
              $unameErr = "UserName is required";
              }
              else {
              $uname = $_POST["uname"];
              if (!preg_match("/^[a-zA-Z1-9 ]*$/",$uname)) {
              $unameErr = "Only letters and white space allowed"; 
              }
              }
    if (empty($_POST["email"])) {
    $emailErr = "Email is required";
    } 
    else {
    $email = $_POST["email"];
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $emailErr = "Invalid email format"; 
    }
    }
          if (empty($_POST["cpassword"])) {
          $cpasswordErr = "You Must Confirm Your Password";
          if (empty($_POST["Password"])) {
          $passwordErr = "Password is required";
          }
          }
          else {
          $password = $_POST["password"];
          $cpassword = $_POST["cpassword"];
          if ($password != $cpassword) {
          $cpasswordErr = "Your Password Did't Match"; 
         }
        }
$bl = "";
if ($nameErr == $bl && $lnameErr == $bl && $unameErr == $bl && $emailErr == $bl && $passwordErr == $bl && $cpasswordErr == $bl) {
   include("../config.php");
   //session_start();      
      //$myusername = mysqli_real_escape_string($db,$_POST['username']);
      //$mypassword = mysqli_real_escape_string($db,$_POST['password']); 
      $sql = "SELECT username FROM uidpid WHERE username = '$uname'";
      $result = mysqli_query($db,$sql);
      $row = mysqli_fetch_array($result,MYSQLI_ASSOC);
      $active = $row['username'];
      $count = mysqli_num_rows($result);
      
      $sql2 = "SELECT email FROM uidpid WHERE email = '$email'";
      $result2 = mysqli_query($db,$sql2);
      $row2 = mysqli_fetch_array($result,MYSQLI_ASSOC);
      $active2 = $row2['email'];
      $count2 = mysqli_num_rows($result);
    
      if($count == 0) {
        
      }
      else {
         $unameErr = "UserName Is Not Available";
      }
      
      if($count2 == 0) {
        
      }
      else{
        $emailErr = "This Email Is Not Available";
      }
    }
   
                                      if ($nameErr == $bl && $lnameErr == $bl && $unameErr == $bl && $emailErr == $bl && $passwordErr == $bl && $cpasswordErr == $bl) {
                                        $sqls = "INSERT INTO uidpid (firstname, lastname, username, password, email, Date)
                                        VALUES ('$name', '$lname', '$uname', '$password', '$email', '$date')";
                                        if (mysqli_query($db, $sqls)) {
                                        echo "<script>window.location.href = 'http://cagblogs.atspace.eu/index.php';</script>";
                                        }
                                        else {
                                        echo "Error: " . $sqls . "<br>" . mysqli_error($conn);
                                        }
                                        mysqli_close($db);
                                        exit();
          }                                       
}
?>

<!DOCTYPE HTML>  
<html>
<link rel="stylesheet" type="text/css" href="SC_css3.css">
<style>
.error{color: #FF0000;}
</style>
<body>
<div id="signindiv">
<div id="border">
          <h1>Sign Up</h1>
  <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
<input type="text" name="name" placeholder="Frist Name" class="formclass" /><span class="error"><?php echo $nameErr;?></span><br><br>
<input type="text" name="lname" placeholder="Last Name" class="formclass" /><span class="error"><?php echo $lnameErr;?></span><br><br>
<input type="text" name="email" placeholder="Email" class="formclass" /><span class="error"><?php echo $emailErr;?></span><br><br>
<input type="text" name="uname" placeholder="Username" class="formclass" /><span class="error"><?php echo $unameErr;?></span><br><br>
<input type="password" name="password" placeholder="Password" class="formclass" /><span class="error"><?php echo $passwordErr;?></span><br><br>
<input type="password" name="cpassword" placeholder="Confirm Password" class="formclass" /><span class="error"><?php echo $cpasswordErr;?></span><br><br>
<input type="submit"  value="Submit" >
  </form><br><br>
</div>
</div>
</body>
</html>