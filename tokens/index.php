<?php
$name = $phone = $seat1 = $seat2 = '';
function test_input($data) {
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  return $data;
}
include('config.php');
$sqle = "SELECT * FROM tokenEvents WHERE `type`='active'";
$resulte = mysqli_query($db, $sqle);
if (mysqli_num_rows($resulte) > 0) {
  $fetcheddatae = mysqli_fetch_array($resulte, MYSQLI_ASSOC);
  $sp = explode('-', $fetcheddatae['date']);
  $date = $sp[2].'-'.$sp[1].'-'.$sp[0];
  if(($_SERVER['REQUEST_METHOD']=="POST") && (isset($_POST['cphone']))){
    $cphone = $_POST['cphone'];
    $sql = "SELECT * FROM users WHERE `phone`='$cphone'";
    $result = mysqli_query($db, $sql);
    if (mysqli_num_rows($result) > 0) {
      $fetcheddata = mysqli_fetch_array($result, MYSQLI_ASSOC);
      if (($fetcheddata['seat1']=="Male") || ($fetcheddata['seat1']=="Female")) {
        if ($fetcheddata['seat2'] == "null") {
          echo $fetcheddata['seat1']."-".$fetcheddata['name'];
          return;
        } else {
        echo "exists";
        return;
        }
      }
    } else {
      echo "new";
      return;
    }
  }
  if ($_SERVER['REQUEST_METHOD'] == "POST") {
    if (isset($_POST['phone']) && isset($_POST['name']) && isset($_POST['seat1'])) {
      $name = test_input($_POST['name']);
      $phone = test_input($_POST['phone']);
      $seat1 = test_input($_POST['seat1']);
      if((!ctype_space($name)) && (!ctype_space($phone)) && (!ctype_space($seat1))) {
        if (preg_match("/^[a-zA-Z ]*$/",$name)) {
          if(preg_match("/^[0-9]{10}$/", $phone)) {
            if(($seat1 == "Male")||($seat1 == "Female")) {
              if(isset($_POST['seat2'])) {
                $seat2 = $_POST['seat2'];
                $sql = "SELECT * FROM users WHERE `phone`='$phone'";
                $result = mysqli_query($db, $sql);
      	        if (mysqli_num_rows($result) > 0) {
      		        $fetcheddata = mysqli_fetch_array($result, MYSQLI_ASSOC);
                  if (($fetcheddata['seat1'] == "Male") || ($fetcheddata['seat1'] == "Female")) {
                    if ($fetcheddata['seat2'] == "null") {
                        if ($fetcheddatae[$seat2] > 0) {
                          $t = 't'.strtolower($seat2);
                          $a = $fetcheddatae[$t];
                          $b = $a - $fetcheddatae[$seat2] + 1;
                          $c = substr($seat2,0,1);
                          $d = $c.$b;
                          $rem = $fetcheddatae[$seat2] - 1;
                          $sql = "UPDATE users SET seat2='$seat2',token2='$d' WHERE `phone`='$phone'";
                          $sql2 = "UPDATE tokenEvents SET $seat2='$rem' WHERE `type`='active'";
                          if ($db->multi_query($sql) === TRUE) {
                            if ($db->multi_query($sql2) === TRUE) {
                              //success
                              echo "You have registered your second Token successfully!";
                            } else {
                              echo "Error!";
                            }
                          } else {
                              echo "Error!!";
                          }
                        } else {
                          echo "All tokens for " . $seat2 . "s are booked.";
                        }
                    } else {
                      echo "You have already booked both Tokens.";
                    }
                  }
                } else {
                  if (($seat1 == "Female") && ($seat2 == "Male")) {
                    if (($fetcheddatae[$seat1] > 0) && ($fetcheddatae[$seat2] > 0)) {
                      $t = 't'.strtolower($seat1);
                      $a = $fetcheddatae[$t];
                      $b = $a - $fetcheddatae[$seat1] + 1;
                      $c = substr($seat1,0,1);
                      $d = $c.$b;
                      $t2 = 't'.strtolower($seat2);
                      $a2 = $fetcheddatae[$t2];
                      $b2 = $a2 - $fetcheddatae[$seat2] + 1;
                      $c2 = substr($seat2,0,1);
                      $d2 = $c2.$b2;
                      $remf = $fetcheddatae[$seat1] - 1;
                      $rem = $fetcheddatae[$seat2] - 1;
                      $sql2 = "UPDATE tokenEvents SET $seat1='$remf',$seat2='$rem' WHERE type='active'";
                    } else {
                      if ($fetcheddatae[$seat1] > 0) {
                        echo "All seats for Males are booked";
                        return;
                      } else {
                        echo "All seats for Females are booked";
                        return;
                      }
                    }
                  } elseif (($seat1 == "Male") && ($seat2 == "Female")) {
                    if (($fetcheddatae[$seat1] > 0) && ($fetcheddatae[$seat2] > 0)) {
                      $t = 't'.strtolower($seat1);
                      $a = $fetcheddatae[$t];
                      $b = $a - $fetcheddatae[$seat1] + 1;
                      $c = substr($seat1,0,1);
                      $d = $c.$b;
                      $t2 = 't'.strtolower($seat2);
                      $a2 = $fetcheddatae[$t2];
                      $b2 = $a2 - $fetcheddatae[$seat2] + 1;
                      $c2 = substr($seat2,0,1);
                      $d2 = $c2.$b2;
                      $remf = $fetcheddatae[$seat1] - 1;
                      $rem = $fetcheddatae[$seat2] - 1;
                      $sql2 = "UPDATE tokenEvents SET $seat1='$remf',$seat2='$rem' WHERE type='active'";
                    } else {
                      if ($fetcheddatae[$seat1] > 0) {
                        echo "All seats for Females are booked";
                        return;
                      } else {
                        echo "All seats for Males are booked";
                        return;
                      }
                    }
                  } elseif (($seat1 == "Male") && ($seat2 == "Male")) {
                    if ($fetcheddatae[$seat1] > 1) {
                      $t = 't'.strtolower($seat1);
                      $a = $fetcheddatae[$t];
                      $b = $a - $fetcheddatae[$seat1] + 1;
                      $b2 = $b+1;
                      $c = substr($seat1,0,1);
                      $d = $c.$b;
                      $d2 = $c.$b2;
                      $rem = $fetcheddatae[$seat1] - 2;
                      $sql2 = "UPDATE tokenEvents SET Male='$rem' WHERE type='active'";
                    } elseif ($fetcheddatae[$seat1] > 0) {
                      echo "No tokens are available for two ".$seat1."s. Only one is available";
                      return;
                    } else {
                      echo "No tokens are available for ".$seat1."s.";
                      return;
                    }
                  } elseif (($seat1 == "Female") && ($seat2 == "Female")) {
                    if ($fetcheddatae[$seat1] > 1) {
                      $t = 't'.strtolower($seat1);
                      $a = $fetcheddatae[$t];
                      $b = $a - $fetcheddatae[$seat1] + 1;
                      $b2 = $b+1;
                      $c = substr($seat1,0,1);
                      $d = $c.$b;
                      $d2 = $c.$b2;
                      $rem = $fetcheddatae[$seat1] - 2;
                      $sql2 = "UPDATE tokenEvents SET Female='$rem' WHERE type='active'";
                    } elseif ($fetcheddatae[$seat1] > 0) {
                      echo "No tokens are available for two ".$seat1."s. Only one is available";
                      return;
                    } else {
                      echo "No tokens are available for ".$seat1."s.";
                      return;
                    }
                  }
                  $sql = "INSERT INTO users (name,phone,seat1,token1,seat2,token2) VALUES ('$name','$phone','$seat1','$d','$seat2','$d2')";
                  if ($db->query($sql) === TRUE) {
                    if ($db->query($sql2) === TRUE) {
                      echo "You have registered two tokens successfully!!";
                    }
                  }
                }
              } else {
                $d2 = "null";
                $sql = "SELECT * FROM users WHERE `phone`='$phone'";
                $result = mysqli_query($db, $sql);
                if (mysqli_num_rows($result) > 0) {
                  $fetcheddata = mysqli_fetch_array($result, MYSQLI_ASSOC);
                  if ((($fetcheddata['seat1'] == "Male") || ($fetcheddata['seat1'] == "Female")) && ($fetcheddata['seat2'] != "null")) {
                    echo "You have already booked both Tokens.";
                  } elseif ((($fetcheddata['seat1'] == "Male") || ($fetcheddata['seat1'] == "Female")) && ($fetcheddata['seat2'] == "null")) {
                  echo "First token has been booked and cannot be chaned.";
                  }
                } else {
                  if ($seat1 == "Female") {
                    if ($fetcheddatae[$seat1] > 0) {
                      $t = 't'.strtolower($seat1);
                      $a = $fetcheddatae[$t];
                      $b = $a - $fetcheddatae[$seat1] + 1;
                      $c = substr($seat1,0,1);
                      $d = $c.$b;
                      $remf = $fetcheddatae[$seat1] - 1;
                      $sql2 = "UPDATE tokenEvents SET Female='$remf' WHERE type='active'";
                    } else {
                      echo "No tokens are available";
                      return;
                    }
                  } elseif ($seat1 == "Male") {
                    if ($fetcheddatae[$seat1] > 0) {
                      $t = 't'.strtolower($seat1);
                      $a = $fetcheddatae[$t];
                      $b = $a - $fetcheddatae[$seat1] + 1;
                      $c = substr($seat1,0,1);
                      $d = $c.$b;
                      $rem = $fetcheddatae[$seat1] - 1;
                      $sql2 = "UPDATE tokenEvents SET Male='$rem' WHERE type='active'";
                    } else {
                      echo "No tokens are available";
                      return;
                    }
                  }
                  $s2 = "null";
                  $sql = "INSERT INTO users (name,phone,seat1,token1,seat2,token2) VALUES ('$name','$phone','$seat1','$d','$s2','$d2')";
                  if ($db->query($sql) === TRUE) {
                    if ($db->query($sql2) === TRUE) {
                      echo "You have registered a token successfully!";
                    } else {
                      echo "Error";
                    }
                  } else {
                    echo "Error";
                  }
                }
              }
            } else {
              echo "You have to select atleast one token to continue!";
            }
          } else {
            echo "Enter a valid Mobile number.";
          }
        } else {
          echo "Enter a valid name.";
        }
      } else {
        echo "Fileds cannot be white spaces.";
      }
    } else {
      echo "Your name, your mobile number and a token is necessary.";
    }
  } else { ?>
    <!DOCTYPE html>
    <html lang="en">
      <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Token Allotment</title>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
        <script src="ajax.js"></script>
        <style media="screen">
        html,body {
          width: 100%;
          margin: 0;
          box-sizing: border-box;
          padding: 0;
        }
        h1 {
          font-size: 34px;
          margin-bottom: 0;
        }
        h2 {
          margin-top: 1vh;
          font-size: 20px;
        }
        .heading {
          background-color: black;
          color: white;
          font-size: 30px;
          margin: 0;
          padding: 2vh 0;
        }
        #centered {
          position: absolute;
          left: 50%;
          top: 50%;
          transform: translate(-50%,-50%);
          display: flex;
          flex-wrap: wrap;
          width: 45%;
          justify-content: space-between;
          align-items: flex-start;
        }
        #id {
          text-align: center;
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
        p {
          font-size: 20px;
          margin-top: 0;
          margin-bottom: 2vh;
        }
        .token form {
          padding: 0 1vw 2vh 1vw;
          text-align: left;
        }
        #dsee {
          padding: 0 1vw 2vw 1vw;
        }
        form * {
          margin-top: 2vh;
        }
        form input {
          border-radius: 0;
          height: 4vh;
          border-style: solid;
          width: 100%;
          border-color: black;
          margin-top: 0;
        }
        form button, #bsee {
          width: 100%;
          background-color: #000000;
          color: white;
          height: 6vh;
          border: unset;
        }
        @media only screen and (max-width: 768px) {
          #centered {
            width: 90%;
            padding: 2vw;
          }
          .token {
            flex-basis: 100%;
            margin-top: 4vh;
          }
        }
        </style>
      </head>
      <body>
        <main id="centered">
          <section id="tput" class="token">
          <h1>Get Your Token</h1>
          <h2><?php echo $date; ?></h2>
          <form id="put" action="index.php" method="post">
            <label for="phone">Mobile number:</label><br>
            <input type="tel" id="phone" name="phone" placeholder="10 digit" maxlength="10" pattern="[0-9]{10}" required><br>
            <div id="frnew">
            <label id="lname" for="name">Place:</label><br>
            <input type="text" id="name" maxlength="32" placeholder="Location" name="name" required><br>
            <label for="seat1">Token 1:</label>
            <select id="slot1" name="seat1" required>
              <option id="opt1" selected disabled hidden>
                Select an Option
              </option>
              <option id="opt2" value="Male">Male</option>
              <option id="opt3" value="Female">Female</option>
            </select><br>
            <label for="seat2">Token 2:</label>
            <select name="seat2">
              <option selected disabled hidden>
                Select an Option
              </option>
              <option value="Male">Male</option>
              <option value="Female">Female</option>
            </select><br>
          </div>
          <div id="frslot2">
          <label for="seat2">Token 2:</label>
          <select id="slot2" name="seat2">
            <option selected disabled hidden>
              Select an Option
            </option>
            <option value="Male">Male</option>
            <option value="Female">Female</option>
          </select><br>
        </div>
            <button id="db" type="submit" name="submit">Get Token</button>
          </form>
          <div id="dsee">
            <p>OR</p>
            <button id="bsee" type="submit">See Token</button>
          </div>
          <div id="loading" style="display:none">
            <span>Please wait...</span>
            <img src="2.gif" alt="loading">
          </div>
          <div id="status"></div>
        </section>
        <section id="tget" class="token">
          <h1>See Your Token</h1>
          <h2><?php echo $date; ?></h2>
          <form id="get" action="token.php" method="post">
            <label for="phonet">Enter your number:</label><br>
            <input type="tel" id="phonet" name="phonet" maxlength="10" placeholder="10 digit" pattern="[0-9]{10}" required><br>
            <button type="submit">See Token</button>
          </form>
        </section>
      </main>
      </body>
    </html>
  <?php  }
} else {
  echo "<h1 style='text-align:center'>Online Token Closed</h1>";
}
?>
