<?php
if($_SERVER['REQUEST_METHOD'] == "POST") {
        $file = fopen("list.txt", "w");
        foreach($_POST['list'] as $listvalue) {
                $write = $listvalue . "\n";
                fwrite($file, $write);
        }
        fclose($file);
        echo '<a id="link" href="list.txt" download></a><script>var a = document.getElementById("link");a.click();</script><a href="list.php"><h1>BACK</h1></a>';
}
if($_SERVER['REQUEST_METHOD'] == "GET") {
?>
<html>
<head>
<title>LIST</title>
</head>
<body>
<form method="post" action="list.php">
<span style="font-size:35px;">
<input type="checkbox" name="list[]" value="list1">l1<br>
<input type="checkbox" name="list[]" value="list2">l2<br>
<input type="checkbox" name="list[]" value="list3">l3<br>
<input type="checkbox" name="list[]" value="list4">l4<br>
<input type="checkbox" name="list[]" value="list5">l5<br>
<input type="checkbox" name="list[]" value="list6">l6<br>
<input type="checkbox" name="list[]" value="list7">l7<br>
<input type="checkbox" name="list[]" value="list8">l8<br>
<input type="checkbox" name="list[]" value="list9">l9<br>
<input type="checkbox" name="list[]" value="list10">l10<br>
<input type="checkbox" name="list[]" value="list11">l11<br>
<input type="checkbox" name="list[]" value="list12">l12<br>
<input type="checkbox" name="list[]" value="list13">l13<br>
<input type="checkbox" name="list[]" value="list13">l14<br>
<input type="checkbox" name="list[]" value="list15">l15<br>
<input type="checkbox" name="list[]" value="list16">l16<br>
<input type="checkbox" name="list[]" value="list17">l17<br>
<input type="checkbox" name="list[]" value="list18">l18<br>
<input type="checkbox" name="list[]" value="list19">l19<br>
<input type="checkbox" name="list[]" value="list20">l20<br>
<input type="submit" value="submit">
</span>
</from>
</body>
</html>
<?php
}
?>