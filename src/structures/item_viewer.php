<?php
    if (isset($_GET['by'])) require '../../src/includes/_db.php';
    else require '../../src/includes/_db.php';

    if (isset($_COOKIE['token'])) {
        $admin_user = json_decode(base64_decode(explode('.', $_COOKIE['token'])[1]))->data->admin_user;
    }
    
    $item_id = "";
    if(isset($_GET['item'])) {
        $item_id = $_GET['item'];
        $place_id = $_GET['room'];
        
        if ($_GET['tab'] != 1 && $_GET['tab'] != "") return;

        $item_query = "SELECT * FROM item WHERE id_item = $item_id";
        $item_result = mysqli_query($db, $item_query);
        $item = mysqli_fetch_assoc($item_result);

        $session_id = $item['id_category'];
        $sessionQuery = "SELECT s.name_category FROM categories s INNER JOIN item p ON s.id_category = p.id_category WHERE p.id_category = $session_id";
        $sessionData = mysqli_query($db, $sessionQuery);
        $sessionName = ($sessionData->num_rows > 0) ? $sessionData->fetch_assoc()['name_category'] : '';

        $placeQuery = "SELECT * FROM places s INNER JOIN item p ON s.id_place = p.id_place WHERE p.id_item = $item_id";
        $placeData = mysqli_query($db, $placeQuery);
        $placeName = ($placeData->num_rows > 0) ? $placeData->fetch_assoc()['name_place'] : '';
        $placeFloor = 'Térreo';
        
        if ($item['id_place'] >= 25) {
            $placeFloor = '1° Andar';
        }

        $status_id = intval($item['id_status']);
        $statusQuery = "SELECT r.name_status FROM item p INNER JOIN status r ON p.id_status = r.id_status WHERE p.id_status = $status_id";
        $statusData = mysqli_query($db, $statusQuery);
        $statusName = ($statusData->num_rows > 0) ? $statusData->fetch_assoc()['name_status'] : 'REGULAR';
    }
?>

<div class="add-modal" id="modal_view" style="display: <?php echo $item_id == "" ? "none": "flex";?>;">

<div class="add-section">
    <div class="add-container">
        <div class="add-label">
            <h1><?php echo $item['name_item']?></h1>
            <span class="material-symbols-rounded _modal_view_close">close</span>
        </div>
        <div class="viewer-about"><?php echo $item['about_item'];?></div>

        <div class="viewer-container">
            <div class="viewer-image">
                <?php
                    $imageData = $item['image_item'];

                    if ($imageData == "") {
                        $imageUrl = 'src="../../src/assets/ImageNotFound.png"';
                    } else if (filter_var($imageData, FILTER_VALIDATE_URL)) {
                        $imageUrl = 'src="' . $imageData . '"';
                    } else {
                        $imageUrl = 'src="data:image;base64,' . base64_encode($imageData) . '"';
                    }

                ?>
                <img class="viewer-product_image" <?php echo $imageUrl; ?> alt="<?php echo $item['name_item']?>">
            </div>
            <div class="viewer-text-container">
                <div class="viewer-section">
                    <div class="viewer-text">
                        <div class="title-text">Código Tombamento</div>
                        <div class="info-text"><?php echo $item['ci_item'] == "" ? "Sem Tombamento" : $item['ci_item'];?></div>
                    </div>
                    <div class="viewer-text">
                        <div class="title-text">Localização ( <?php echo $placeFloor;?> )</div>
                        <div class="info-text"><?php echo $placeName;?> </div>
                    </div>
                    <div class="viewer-text">
                        <div class="title-text">Categoria</div>
                        <div class="info-text"><?php echo $sessionName;?></div>
                    </div>
                    <div class="viewer-text">
                        <div class="title-text">Ultima modificação</div>
                        <div class="info-text"><?php echo date("d/m/Y", strtotime($item['date_item']));?></div>
                    </div>
                </div>
                <div class="viewer-section">
                    <div class="viewer-text">
                        <div class="title-text">Status</div>
                        <div class="info-text"><?php echo $statusName;?></div>
                    </div>
                    <div class="viewer-text">
                        <div class="title-text">Ano de Compra</div>
                        <div class="info-text"><?php echo ($item["got_item"] == null ? "Não definido" : $item["got_item"]);?></div>
                    </div>
                    <div class="viewer-text">
                        <div class="title-text">Preço</div>
                        <div class="info-text"><?php echo $item['price_item'] == "" ? "Não definido" : "R$ ".number_format($item['price_item'], 2, ',', '.');?></div>
                    </div>
                </div>
            </div>
        </div> 
        
        <?php 
            if ($admin_user == 1) {
        ?>
        <div class="viewer-actions">
            <div class="actions-itens">
                    <a class="_modal_edit_open" id="type_tab_2"><span class="material-icons">mode_edit</span></a>
                    <a class="_modal_delete_open" id="type_tab_3"><span class="material-icons">delete</span></a>
            </div>
        </div>
        <?php } ?>
    </div>
</div>
</form>
</div>