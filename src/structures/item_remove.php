<?php
    require '../../src/includes/_db.php';

    if ($_GET['tab'] != 3) return;

    if (isset($_COOKIE['token'])) {
        $user_decoder = json_decode(base64_decode(explode('.', $_COOKIE['token'])[1]));
        $id_user = $user_decoder->data->id_user;
        $admin_user = $user_decoder->data->admin_user;
        if ($admin_user != 1) return;
    } else {
        return;
    }

    $item_id = "";
    if(isset($_GET['item'])) {
        $item_id = $_GET['item'];
        $place_id = $_GET['room'];
        
        if ($_GET['tab'] != 3) return;

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

<?php if (!isset($_GET['by'])) { ?><div class="add-modal" id="modal_delete" style="display: <?php echo $item_id == "" ? "none": "flex";?>;"><?php } ?>

<form action="../../src/includes/_functions.php" method="POST"  enctype="multipart/form-data">

<div class="add-section">
    <div class="add-container">

    <div class="add-top">
            <div class="add-label">
                <h1 style="color:#cb1b1b;"><?php echo $item['name_item']?></h1>
                <div style="display:flex;"><span class="material-symbols-rounded _modal_delete_close">close</span><br><c style="font-size: 8pt;position: absolute;margin-top: 1.6rem;margin-left: 1px;user-select:none;">ESC</c></div>
            </div>
            <div class="viewer-about"><?php echo $item['about_item'];?></div>
        </div>

        <div class="viewer-container" style="user-select: none;">
        <div class="viewer-image" style="border-color: #ff9b9b; background: radial-gradient(transparent, #ff545454);">
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
                <img class="viewer-product_image" style="opacity: 0.5; filter: grayscale(1); z-index: -1;" <?php echo $imageUrl; ?> alt="<?php echo $item['name_item']?>">
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
            <div class="viewer-actions">
            <div class="actions-itens">
                    <a class="_modal_edit_open" ><span class="material-icons">mode_edit</span></a>
                    <a class="_modal_delete_open"><span class="material-icons">delete</span></a>
            </div>
            </div>
        </div>
            <div class="confirm-del-container">
            <div class="confirm-del">
            <h1 style="margin-top: 20rem;">Remover item</h1>

            <div class="viewer-about" style="color: #616161; margin-bottom: 2rem;">Confirma a exclusão do item selecionado?</div>
        <input type="hidden" name="action" value="item_remove">
        <input type="hidden" name="id_user" value="<?php echo $id_user; ?>">
        <input type="hidden" name="id" value="<?php echo $item_id;?>">
        <input type="hidden" name="place_id" value="<?php echo $place_id;?>">
        <div class="btn-section">
            <button type="submit" class="form-btn trash btn btn-success pDel"><span class="material-symbols-rounded">check</span>Deletar</button>
            <div class="form-btn btn btn-secondary pCancel" id="type_tab_1">Cancelar</div>
        </div>
        </div>
    </div>
</div>
</form>
</div>