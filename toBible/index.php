<html>
<body>
<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
      <input type="text" placeholder="book number" name="book" /><br><br>
      <input type="text" placeholder="chapter number" name="chap" /><br><br>
      <input type="submit" name="login" value="get"><br><br>
</form>
</body>
</html>


<?php
if($_SERVER["REQUEST_METHOD"] == "POST") {
	$book = $_POST['book'];
	$chap = $_POST['chap'];
	switch ($book) {
    	case "1":
        $opt = "Genesis";
        break;
    	case "2":
        $opt = "Exodus";
        break;
    	case "3":
        $opt = "Leviticus";
        break;
        case "4":
        $opt = "Numbers";
        break;
        case "5":
        $opt = "Deuteronomy";
        break;
        case "6":
        $opt = "Joshua";
        break;
        case "7":
        $opt = "Judges";
        break;
        case "8":
        $opt = "Ruth";
        break;
        case "9":
        $opt = "I_Samuel";
        break;
        case "10":
        $opt = "II_Samuel";
        break;
        case "11":
        $opt = "I_Kings";
        break;
        case "12":
        $opt = "II_Kings";
        break;
        case "13":
        $opt = "I_Chronicles";
        break;
        case "14":
        $opt = "II_Chronicles";
        break;
        case "15":
        $opt = "Ezra";
        break;
        case "16":
        $opt = "Nehemiah";
        break;
        case "17":
        $opt = "Esther";
        break;
        case "18":
        $opt = "Job";
        break;
        case "19":
        $opt = "Psalms";
        break;
        case "20":
        $opt = "Proverbs";
        break;
        case "21":
        $opt = "Ecclesiastes";
        break;
        case "22":
        $opt = "Song_of_Solomon";
        break;
        case "23":
        $opt = "Isaiah";
        break;
        case "24":
        $opt = "Jeremiah";
        break;
        case "25":
        $opt = "Lamentations";
        break;
        case "26":
        $opt = "Ezekiel";
        break;
        case "27":
        $opt = "Daniel";
        break;
        case "28":
        $opt = "Hosea";
        break;
        case "29":
        $opt = "Joel";
        break;
        case "30":
        $opt = "Amos";
        break;
        case "31":
        $opt = "Obadiah";
        $chap = "&Verse=&Kjv=0";
        break;
        case "32":
        $opt = "Jonah";
        break;
        case "33":
        $opt = "Micah";
        break;
        case "34":
        $opt = "Nahum";
        break;
        case "35":
        $opt = "Habakkuk";
        break;
        case "36":
        $opt = "Zephaniah";
        break;
        case "37":
        $opt = "Haggai";
        break;
        case "38":
        $opt = "Zechariah";
        break;
        case "39":
        $opt = "Malachi";
        break;
        case "40":
        $opt = "Matthew";
        break;
        case "41":
        $opt = "Mark";
        break;
        case "42":
        $opt = "Luke";
        break;
        case "43":
        $opt = "John";
        break;
        case "44":
        $opt = "Acts";
        break;
        case "45":
        $opt = "Romans";
        break;
        case "46":
        $opt = "I_Corinthians";
        break;
        case "47":
        $opt = "II_Corinthians";
        break;
        case "48":
        $opt = "Galatians";
        break;
        case "49":
        $opt = "Ephesians";
        break;
        case "50":
        $opt = "Philippians";
        break;
        case "51":
        $opt = "Colossians";
        break;
        case "52":
        $opt = "I_Thessalonians";
        break;
        case "53":
        $opt = "II_Thessalonians";
        break;
        case "54":
        $opt = "I_Timothy";
        break;
        case "55":
        $opt = "II_Timothy";
        break;
        case "56":
        $opt = "Titus";
        break;
        case "57":
        $opt = "Philemon";
        $chap = "&Verse=&Kjv=0";
        break;
        case "58":
        $opt = "Hebrews";
        break;
        case "59":
        $opt = "James";
        break;
        case "60":
        $opt = "I_Peter";
        break;
        case "61":
        $opt = "II_Peter";
        break;
        case "62":
        $opt = "I_John";
        break;
        case "63":
        $opt = "II+John";
        $chap = "&Verse=&Kjv=0";
        break;
        case "64":
        $opt = "III+John";
        $chap = "&Verse=&Kjv=0";
        break;
        case "65":
        $opt = "Jude";
        $chap = "&Verse=&Kjv=0";
        break;
        case "66":
        $opt = "Revelation";
        break;
    default:
        $opt = "something went wrong";
}
       $link = "http://www.tamil-bible.com/lookup.php?Book=".$opt."&Chapter=".$chap;
       echo "<script>window.location.href = '$link';</script>";
}
?>