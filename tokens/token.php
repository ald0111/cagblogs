<?php
function test_input($data) {
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  return $data;
}
if ($_SERVER['REQUEST_METHOD']=="GET") {
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title>Get Token</title>
    <style media="screen">
    html,body {
      width: 100%;
      margin: 0;
      box-sizing: border-box;
      padding: 0;
    }
    .heading {
      background-color: black;
      color: white;
      font-size: 30px;
      margin: 0;
      padding: 2vh 0;
    }
    p {
      font-size: 20px;
    }
    #centered {
      position: absolute;
      left: 50%;
      top: 50%;
      transform: translate(-50%,-50%);
      display: flex;
      flex-wrap: wrap;
      text-align: center;
      width: 45%;
      justify-content: space-between;
    }
    .token {
      box-shadow: 0 8px 16px 0 rgba(0,0,0,0.2);
      width: 40%;
      border: 3px solid black;
      text-align: center;
      font-family: arial;
    }
    .black {
      font-size: 34px;
      margin: 0;
      padding: 2vh 0;
      color: black;
      font-weight: bold;
    }
    @media only screen and (max-width: 768px) {
      #centered {
        width: 90%;
        padding: 2vw;
      }
      #home {
      font-size: 24px;
      }
      .token {
        flex-basis: 100%;
        margin-top: 4vh;
      }
    }
    </style>
  </head>
  <body>
    <?php
  } elseif (($_SERVER['REQUEST_METHOD']=="POST") && (isset($_POST['phonet']))) {
      include('config.php');
      $sqle = "SELECT * FROM tokenEvents WHERE type='active'";
      $resulte = mysqli_query($db,$sqle);
      $fetcheddatae = mysqli_fetch_array($resulte,MYSQLI_ASSOC);
      $sp = explode('-', $fetcheddatae['date']);
      $date = $sp[2].'-'.$sp[1].'-'.$sp[0];
      $phone = $_POST['phonet'];
      $sql = "SELECT * FROM users WHERE phone='$phone'";
      $result = mysqli_query($db, $sql);
      if (mysqli_num_rows($result) > 0) {
        $fetcheddata = mysqli_fetch_array($result,MYSQLI_ASSOC);
        $seat2 = $fetcheddata['seat2'];
        $token1 = $fetcheddata['token1'];
        $token2 = $fetcheddata['token2'];
        if ($seat2 != "null") { ?>
          <div id=centered>
          <section class="token">
            <h1 class="heading">Token</h1>
            <h2 class="black"><?php echo $token1; ?></h2>
            <p><?php echo $date; ?></p>
          </section>
          <section class="token">
            <h1 class="heading">Token</h1>
            <h2 class="black"><?php echo $token2; ?></h2>
            <p><?php echo $date; ?></p>
          </section>
        </div>
        <div id="home" style="font-size:24px;position:absolute;bottom:0;left:50%;transform:translate(-50%,0);text-align:center"><a href="/tokens">Home</a></div>
      <?php  } else { ?>
        <div id="centered">
          <section class="token" style="margin-left:auto;margin-right:auto;">
            <h1 class="heading">Token</h1>
            <h2 class="black"><?php echo $token1; ?></h2>
            <p><?php echo $date; ?></p>
          </section>
        </div>
        <div id="home" style="font-size:24px;position:absolute;bottom:0;left:50%;transform:translate(-50%,0);text-align:center"><a href="/tokens">Home</a></div>
        <?php
      }
    } else {
//      return;
    ?>
  <div id="centered">
    <section class="token" style="margin-left:auto;margin-right:auto;">
      <h1 class="heading">Token</h1>
      <h2 class="black">Not Issued</h2>
      <p><?php echo $date; ?></p>
    </section>
  </div>
  <div id="home" style="font-size:24px;position:absolute;bottom:0;left:50%;transform:translate(-50%,0);text-align:center"><a href="/tokens">Home</a></div>
<?php }
    }
    if ($_SERVER['REQUEST_METHOD']=="GET") {
    ?>
  </body>
</html>
<?php } ?>
