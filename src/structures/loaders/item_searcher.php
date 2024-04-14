<?php
require '../../includes/_db.php';
$place = $_POST["place"];
$output = '';

if(isset($_POST["query"])) {
 
 $search = $_POST["query"];

 $query = "SELECT * FROM item WHERE 
    ((name_item LIKE '%$search%' OR about_item LIKE '%$search%' OR ci_item LIKE '%$search%' OR got_item LIKE '%$search%') 
    OR id_category IN (SELECT id_category FROM categories WHERE name_category LIKE '%$search%')
    OR id_status IN (SELECT id_status FROM status WHERE name_status LIKE '%$search%')) 
    AND id_place = $place";

 if (strtolower($search) == "s/t") $query = "SELECT * FROM item WHERE (ci_item IS NULL) AND id_place = $place";
 
} else {
   $query = "SELECT * FROM item WHERE id_place = $place ORDER BY id_category";

}
$result = mysqli_query($db, $query);

echo "<script>document.getElementById('item-counter').innerText = '(" . mysqli_num_rows($result) . ")';</script>";

if(mysqli_num_rows($result) > 0) {
 $output .= '
 <table class="table-items">
     <thead>
         <tr>
             <th style="width: 8vw;">Código</th>
             <th style="width: 20vw;">Nome</th>
             <th style="width: 25vw;">Descrição</th>
             <th style="width: 10vw;">Categoria</th>
             <th style="width: 10vw;">Preço</th>
             <th style="width: 5vw;">Compra</th>
             <th style="width: 5vw;">Status</th>
         </tr>
 ';
 while($row = mysqli_fetch_array($result)) {
    
    $imageData = $row['image_item'];
    if (filter_var($imageData, FILTER_VALIDATE_URL)) {
        $imageUrl = 'src="' . $imageData . '"';
    } else {
        $imageUrl = 'src="data:image;base64,' . base64_encode($imageData) . '"';
    }

    $tomb_item = $row["ci_item"];

    if ($tomb_item == null) $tomb_item = "S/T";

    $session_id = $row['id_category'];
    $sessionQuery = "SELECT s.name_category FROM categories s INNER JOIN item p ON s.id_category = p.id_category WHERE p.id_category = $session_id";
    $sessionData = mysqli_query($db, $sessionQuery);
    $sessionName = ($sessionData->num_rows > 0) ? $sessionData->fetch_assoc()['name_category'] : '';
    $sessionTag = substr($sessionName, 0, 1);

    $resp_id = $row['id_user'];
    $respQuery = "SELECT r.name_user FROM item p INNER JOIN users r ON p.id_user = r.id_user WHERE p.id_user = $resp_id";
    $respData = mysqli_query($db, $respQuery);
    $respName = ($respData->num_rows > 0) ? $respData->fetch_assoc()['name_user'] : '';

    $status_id = intval($row['id_status']);
    $statusQuery = "SELECT r.name_status FROM item p INNER JOIN status r ON p.id_status = r.id_status WHERE p.id_status = $status_id";
    $statusData = mysqli_query($db, $statusQuery);
    $statusName = ($statusData->num_rows > 0) ? $statusData->fetch_assoc()['name_status'] : 'REGULAR';
    
    $cores = array(
        0 => 'status_danger',
        1 => 'status_warn',
        2 => 'status_regular',
        3 => 'status_good',
        4 => 'status_nice'
    );

    $output .= '
    <tr id="item_'.$row['id_item'].'">
        <td>'.$tomb_item.'</td>
        <td>'.$row["name_item"].'</td>
        <td>'.$row["about_item"].'</td>
        <td>'.$sessionName.'</td>
        <td>'.($row['price_item'] == null ? "" : "R$ ".number_format($row['price_item'], 2, ',', '.')).'</td>
        <td>'.$row["got_item"].'</td>
        <td id="'.$cores[$status_id].'" title="'.$statusName.'"><span class="material-symbols-outlined">package_2</span></td>
    </tr>
';

 
 }
 echo $output;
}
else {
 echo '<div class="empty-product">Sem registros</div>';
}
?>