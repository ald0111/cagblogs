<?php
   include('config.php');
   session_start();
   
   $user_check = $_SESSION['login_user'];
   
   $ses_sql = mysqli_query($db,"select username from uidpid where username = '$user_check' ");
   
   $row = mysqli_fetch_array($ses_sql,MYSQLI_ASSOC);
   
   $login_session = $row['username'];
   
   if(isset($_SESSION['login_user'])){
      header("location:blog.php");
   }
?>
<?php
   // include("config.php");
   // session_start();
   
   if($_SERVER["REQUEST_METHOD"] == "POST") {
      // username and password sent from form 
   
      $myusername = mysqli_real_escape_string($db,$_POST['username']);
      $mypassword = mysqli_real_escape_string($db,$_POST['password']); 
   $scm = "1002";
   $scmpass = "123456";
   if($myusername == $scm AND $mypassword == $scmpass) {
      $_SESSION['login_user'] = $myusername;
    

      header("Location: songs/");
   }
      else{
      $sql = "SELECT username FROM uidpid WHERE username = '$myusername' and password = '$mypassword'";
      $result = mysqli_query($db,$sql);
      $row = mysqli_fetch_array($result,MYSQLI_ASSOC);
      $active = $row['username'];
      
      $count = mysqli_num_rows($result);
      
      // If result matched $myusername and $mypassword, table row must be 1 row
		
      if($count != 0) {
         //session_register("myusername");
         $_SESSION['login_user'] = $myusername;
         header("location: blog.php");
      }else {
         $error = "Your UserName or Password is invalid \n";
      }
   }
   }
?>
<html>
<head>
<meta name="google-site-verification" content="qPFZ88nxXMzpioW_rUC9MgM_9NcBD86Kx8_cI58uhqw" />
<meta name="blogs" content="blogs,page,cag,blogs">
<link rel="stylesheet" type="text/css" href="index.css">
</head>

<body>
<div id="logindiv">
<div id="border">
          <h1>Sign In</h1>
<h4><span class="error"><?php echo $error;?></span></h4>
<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
      <input type="text" placeholder="username" name="username" class="formclass"/><br /><br />
      <input type="password" placeholder="Password" name="password" class="formclass"/><br /><br />
      <input type="submit" name="login" value="Sign In" /><br /><br />
      <p><a href="/register/">Register</a>  If You Dont Have An Account</p>
</form>
</div>
</div>
</body>
</html>
