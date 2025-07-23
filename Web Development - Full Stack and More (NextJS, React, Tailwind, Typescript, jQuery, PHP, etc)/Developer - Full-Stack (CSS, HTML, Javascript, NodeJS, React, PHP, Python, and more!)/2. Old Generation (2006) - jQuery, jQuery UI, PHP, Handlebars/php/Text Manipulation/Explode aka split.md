$text = "";
$text = file_get_contents("data-suggestions/data.txt", $text);
$arr = explode("\n", $text); // Note: Explode reading TOKEN from TEXT.
for($i = 0; $i<count($arr); $i++) {
  $line = $arr[$i];
  echo "$line<br>";
}