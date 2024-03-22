<?php
require '../../includes/_db.php';

if(isset($_POST["query"])) {

 $search = $_POST["query"];
 if (!is_numeric($search)) return;

 $query = "SELECT * FROM item WHERE ci_item = '$search'";

$result = mysqli_query($db, $query);
if(mysqli_num_rows($result) > 0) {

 $output = '';
 while($row = mysqli_fetch_array($result)) {
   if ($row['ci_item'] == "") continue;
    $output = [$row['id_item'], '#map_'.str_pad($row['id_place'], 2, '0', STR_PAD_LEFT), $row['id_place']];
 }
 echo implode(",", $output);
}
 
} else {
   echo "";

}
?>