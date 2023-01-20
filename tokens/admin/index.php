<?php
session_start();
if ((isset($_SESSION['admin']))&&($_SESSION['admin'])) {
  if ($_SERVER['REQUEST_METHOD']=="POST") {
    if (((isset($_POST['attr']))&&(isset($_POST['date'])))&&(($_POST['attr']=="ON")||($_POST['attr']=="OF"))) {
      include('config.php');
      $date = $_POST['date'];
      if ($_POST['attr']=="ON") {
        $sql = "UPDATE tokenEvents SET type='active' WHERE `date`='$date'";
        $result = mysqli_query($db,$sql);
        if ($result) {
          echo "Turned On";
        }
      } elseif ($_POST['attr']=="OF") {
        $sql = "UPDATE tokenEvents SET type='deactivated' WHERE `date`='$date'";
        $result = mysqli_query($db,$sql);
        if ($result) {
          echo "Turned Off";
        }
      }
    } else {
      echo "All fileds are required.";
    }
  } elseif ($_SERVER['REQUEST_METHOD']=="GET") {
?>
    <html>
    <head>
      <title>Admin</title>
    </head>
    <body>
      <h1>Select</h1>
      <form class="change" action="index.php" method="post">
        <label for="date">Date:</label>
        <input id="date" type="date" name="date" required><br>
        <input type="radio" name="attr" value="ON">ON<br>
        <input type="radio" name="attr" value="OF">OF<br>
        <button type="submit">Change</button>
      </form>
      <a href="logout.php">logout</a>
    </body>
    </html>
<?php
  }
} else {
    if ($_SERVER['REQUEST_METHOD']=="POST") {
      if ((isset($_POST['username'])=="nesaradmin")&&($_POST['password'])=="12345nesar") {
        $_SESSION['admin'] = TRUE;
        echo"<script>window.location.href = 'index.php';</script>";
      } else {
        echo "Incorrect credentials";
      }
    } elseif ($_SERVER['REQUEST_METHOD']=="GET") {
?>
    <html>
    <head>
      <title>Admin</title>
    </head>
    <body>
      <h1>Login</h1>
      <form class="login" action="index.php" method="post">
        <input type="text" name="username" placeholder="Username" required><br><br>
        <input type="password" name="password" placeholder="Password" required><br><br>
        <button type="submit">Login</button>
      </form>
    </body>
    </html>
<?php
    }
  }
?>
