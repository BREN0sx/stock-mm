<?php
require '../../includes/_db.php';

$output = '';

if(isset($_POST["query"])) {
 
 $search = $_POST["query"];

 $query = "SELECT * FROM history_log WHERE 
    (
    JSON_UNQUOTE(JSON_EXTRACT(event_log, '$.nN')) LIKE '%$search%'
    OR JSON_UNQUOTE(JSON_EXTRACT(event_log, '$.nA')) LIKE '%$search%'
    OR JSON_UNQUOTE(JSON_EXTRACT(event_log, '$.nCI')) LIKE '%$search%'
    OR JSON_UNQUOTE(JSON_EXTRACT(event_log, '$.nPC')) LIKE '%$search%'
    OR JSON_UNQUOTE(JSON_EXTRACT(event_log, '$.nG')) LIKE '%$search%'
    OR JSON_UNQUOTE(JSON_EXTRACT(event_log, '$.nS')) LIKE '%$search%'
    OR JSON_UNQUOTE(JSON_EXTRACT(event_log, '$.nPL')) LIKE '%$search%'
    OR JSON_UNQUOTE(JSON_EXTRACT(event_log, '$.nCA')) LIKE '%$search%'
    OR JSON_UNQUOTE(JSON_EXTRACT(event_log, '$.aN')) LIKE '%$search%'
    OR JSON_UNQUOTE(JSON_EXTRACT(event_log, '$.aA')) LIKE '%$search%'
    OR JSON_UNQUOTE(JSON_EXTRACT(event_log, '$.aCI')) LIKE '%$search%'
    OR JSON_UNQUOTE(JSON_EXTRACT(event_log, '$.aPC')) LIKE '%$search%'
    OR JSON_UNQUOTE(JSON_EXTRACT(event_log, '$.aG')) LIKE '%$search%'
    OR JSON_UNQUOTE(JSON_EXTRACT(event_log, '$.aS')) LIKE '%$search%'
    OR JSON_UNQUOTE(JSON_EXTRACT(event_log, '$.aPL')) LIKE '%$search%'
    OR JSON_UNQUOTE(JSON_EXTRACT(event_log, '$.aCA')) LIKE '%$search'
    OR DATE_FORMAT(time_log, '%d/%m/%Y às %H:%i:%s') LIKE '%$search%'
    OR id_user IN (SELECT id_user FROM users WHERE name_user LIKE '%$search%')
    OR type_log = CASE
        WHEN 'Deletado' LIKE CONCAT('$search', '%') THEN 3
        WHEN 'Atualizado' LIKE CONCAT('$search', '%') THEN 2
        WHEN 'Adicionado' LIKE CONCAT('$search', '%') THEN 1
    END
) ORDER BY type_log DESC";

} else {
   $query = "SELECT * FROM history_log ORDER BY id_log DESC";
}
$result = mysqli_query($db, $query);

echo "<script>document.getElementById('item-counter').innerText = '(" . mysqli_num_rows($result) . ")';</script>";

function strChanges($antiga, $nova) {
    if ($antiga != $nova) {
        $resultado = "<s>" . $antiga . "</s>" . $nova;
    } else {
        $resultado = $nova;
    }
    
    return $resultado;
};

if(mysqli_num_rows($result) > 0) {
 $output .= '
 <table class="table-history">
     <thead>
         <tr>
             <th style="width: 40%;">Ação</th>
             <th style="width: 15%;">Autor</th>
             <th style="width: 20%;">Data</th>
             <th style="width: 15%;"></th>
         </tr>
 ';
 while($row = mysqli_fetch_array($result)) {
    $item_id = $row['id_item'];
    $itemQuery = "SELECT * FROM item WHERE id_item = '$item_id'";
    $itemResult = mysqli_query($db, $itemQuery);
    $itemData = mysqli_fetch_array($itemResult);
    $itemName = $itemResult->num_rows > 0 ? $itemData['name_item'] : '';
    $itemPlace = $itemResult->num_rows > 0 ? $itemData['id_place'] : '';

    $resp_id = $row['id_user'];
    $respQuery = "SELECT r.name_user FROM history_log p INNER JOIN users r ON p.id_user = r.id_user WHERE p.id_user = $resp_id";
    $respData = mysqli_query($db, $respQuery);
    $respName = ($respData->num_rows > 0) ? $respData->fetch_assoc()['name_user'] : '';

    $action_log = $row['event_log'];
    $action = json_decode($action_log, true);

    $Nname_item = $action['nN'];
    $Nabout_item = $action['nA'];
    $Nci_item = $action['nCI'];
    $Nprice_item = $action['nPC'];
    $Ngot_item = $action['nG'];
    $Nid_status = $action['nS'];
    $Nid_place = $action['nPL'];
    $Nid_category = $action['nCA'];

    $Aname_item = $action['aN'];
    $Aabout_item = $action['aA'];
    $Aci_item = $action['aCI'];
    $Aprice_item = $action['aPC'];
    $Agot_item = $action['aG'];
    $Aid_status = $action['aS'];
    $Aid_place = $action['aPL'];
    $Aid_category = $action['aCA'];

    $type_log = $row["type_log"];

    $NcategoryData = mysqli_query($db, "SELECT * FROM categories WHERE id_category = '$Nid_category'");
    $NcategoryName = ($NcategoryData->num_rows > 0) ? $NcategoryData->fetch_assoc()['name_category'] : '';
    
    $AcategoryData = mysqli_query($db, "SELECT * FROM categories WHERE id_category = '$Aid_category'");
    $AcategoryName = ($AcategoryData->num_rows > 0) ? $AcategoryData->fetch_assoc()['name_category'] : '';

    $NplaceData = mysqli_query($db, "SELECT * FROM places WHERE id_place = '$Nid_place'");
    $NplaceName = ($NplaceData->num_rows > 0) ? $NplaceData->fetch_assoc()['name_place'] : '';

    $AplaceData = mysqli_query($db, "SELECT * FROM places WHERE id_place = '$Aid_place'");
    $AplaceName = ($AplaceData->num_rows > 0) ? $AplaceData->fetch_assoc()['name_place'] : '';

    if ($Nid_status !== '') {
        $NstatusData = mysqli_query($db, "SELECT * FROM status WHERE id_status = '$Nid_status'");
        $NstatusName = ($NstatusData->num_rows > 0) ? $NstatusData->fetch_assoc()['name_status'] : '';
    } else {
        $NstatusName = '';
    }

    if ($Aid_status !== '') {
        $AstatusData = mysqli_query($db, "SELECT * FROM status WHERE id_status = '$Aid_status'");
        $AstatusName = ($AstatusData->num_rows > 0) ? $AstatusData->fetch_assoc()['name_status'] : '';
    } else {
        $AstatusName = '';
    }
    
    $nameLinkItem = '<a style="color:#434343">'.$Nname_item.'</a>';

    if ($type_log == 3) {
        $nameLinkItem = '<a style="color:#434343">'.$Aname_item.'</a>';
    }

    if ($itemResult->num_rows > 0) {
        $nameLinkItem = '<a href="../../views/stock?room='.$itemPlace.'&item='.$item_id.'">'.$itemName.'</a>';
    }

    $types = array(
        1 => ['Adicionado', 'status_nice', 'add'],
        2 => ['Atualizado', 'status_good', 'sync'],
        3 => ['Deletado', 'status_danger', 'remove']
    );

    $output .= '
    <tr id="log_'.$row['id_log'].'">
        <td><div class="desktop-text"><b id="'.$types[$row["type_log"]][1].'">'.$types[$row["type_log"]][0].'</b>'.$nameLinkItem.'</div><div class="mobile-text"><b class="mobile-icon" id="'.$types[$row["type_log"]][1].'"><span class="material-symbols-outlined">'.$types[$row["type_log"]][2].'</span></b>'.$nameLinkItem.'</div></td>
        <td> <a href="?user='.$resp_id.'">'.$respName.'</a></td>
        <td>'.date('d/m/Y \à\s H:i', strtotime($row["time_log"])).'</td>
        <td class="expand-history">Detalhes<span class="material-symbols-outlined">expand_more</span></td>
    </tr>
    <tr class="fold_history">
        <td colspan="7">
            <div class="fold-content">
            <div class="fold-section">
                <div class="viewer-text">
                    <div class="title-text">Tombamento:</div>
                    <div class="info-text">'.strChanges($Aci_item, $Nci_item).'</div>
                </div>
                <div class="viewer-text">
                    <div class="title-text">Nome:</div>
                    <div class="info-text">'.strChanges($Aname_item, $Nname_item).'</div>
                </div>
                <div class="viewer-text">
                    <div class="title-text">Descrição:</div>
                    <div class="info-text">'.strChanges($Aabout_item, $Nabout_item).'</div>
                </div>
                </div>
                <div class="fold-section">
                <div class="viewer-text">
                    <div class="title-text">Ano de Compra:</div>
                    <div class="info-text">'.strChanges($Agot_item, $Ngot_item).'</div>
                </div>
                
                <div class="viewer-text">
                    <div class="title-text">Preço:</div>
                    <div class="info-text">'.strChanges($Aprice_item, $Nprice_item).'</div>
                </div>
                <div class="viewer-text">
                    <div class="title-text">Status:</div>
                    <div class="info-text">'.strChanges($AstatusName, $NstatusName).'</div>
                </div>
                </div>
                <div class="fold-section">
                <div class="viewer-text">
                    <div class="title-text">Categoria:</div>
                    <div class="info-text">'.strChanges($AcategoryName, $NcategoryName).'</div>
                </div>
                <div class="viewer-text">
                    <div class="title-text">Localização:</div>
                    <div class="info-text">'.strChanges($AplaceName, $NplaceName).'</div>
                </div>
                </div>
            </div>
        </td>
    </tr>
';

 }
 echo $output;
}
else {
 echo '<div class="empty-product">Sem registros</div>';
}
?>