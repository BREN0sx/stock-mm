<?php
if (isset($_GET['by'])) require '../../src/includes/_db.php';
else require '../../src/includes/_db.php';

    $place_id = $_GET['room'];
    $id = $_GET['item'];

    if ($_GET['tab'] != 2) return;

    if (isset($_COOKIE['token'])) {
        $user_decoder = json_decode(base64_decode(explode('.', $_COOKIE['token'])[1]));
        $id_user = $user_decoder->data->id_user;
        $admin_user = $user_decoder->data->admin_user;
        if ($admin_user != 1) return;
    } else {
        return;
    }

    $product_query = "SELECT * FROM item WHERE id_item = '$id'";
    $product_result = mysqli_query($db, $product_query);
    $item = mysqli_fetch_assoc($product_result);
?>


<?php if (!isset($_GET['by'])) { ?><div class="add-modal" id="modal_edit" style="display: <?php echo $id == "" ? "none": "flex";?>;"><?php } ?>

<form action="../../src/includes/_functions.php" method="POST"  enctype="multipart/form-data">


<div class="add-section">
    <div class="add-container">
        <div class="add-label">
            <h1>Editar Item</h1>
            <div style="display:flex;"><span class="material-symbols-rounded _modal_edit_close">close</span><br><c style="font-size: 8pt;position: absolute;margin-top: 1.6rem;margin-left: 1px;user-select:none;">ESC</c></div>
        </div>

<div class="viewer-container">
            <div class="viewer-image drop-zone">
                <span class="drop-zone__prompt">Arraste uma imagem ou faça upload</span>
                <span class="drop-zone__prompt support">JPEG, JPG, PNG, WEBP</span>
                <input type="file" name="image_item" class="drop-zone__input" accept=".png, .jpg, .jpeg, .webp">

                <?php
                    $imageData = $item['image_item'];

                    if (filter_var($imageData, FILTER_VALIDATE_URL)) {
                        $imageUrl = 'src="' . $imageData . '"';
                    } else {
                        $imageUrl = 'src="data:image;base64,' . base64_encode($imageData) . '"';
                    }

                    if ($imageData != "") {
                ?>
                
                <img class="viewer-product_image drop-zone__prompt editor-viewer" <?php echo $imageUrl; ?> alt="<?php echo $item['name_item']?>">
                <?php } ?>
            </div>

            <div class="viewer-text-container">
                <div class="viewer-section form-section">
                    <div class="viewer-text">
                        <label for="ci_item" class="title-text form-label">Código Tombamento</label>
                        <input type="text"  id="ci_item" name="ci_item" class="form-control" placeholder="Insira o código" value="<?php echo $item['ci_item']; ?>">
                    </div>
                    <div class="viewer-text">
                        <label for="name_item" class="title-text form-label">Nome *</label>
                        <input type="text"  id="name_item" name="name_item" class="form-control" placeholder="Insira o nome" value="<?php echo $item['name_item']; ?>" required>
                    </div>
                    <div class="viewer-text">
                        <label for="about_item" class="title-text form-label">Descrição</label>
                        <input type="text"  id="about_item" name="about_item" class="form-control" placeholder="Insira a descrição" value="<?php echo $item['about_item']; ?>">
                    </div>
                    <div class="viewer-text">
                        <label for="id_place" class="title-text form-label">Ambiente *</label>
                        <select name="id_place" id="id_place" class="form-control" required>
                            <?php
                            $place_query = "SELECT * FROM places";
                            $place_result = mysqli_query($db, $place_query);
    
                            $options = array();
                            $label_place = array(); 

                            function limitarString($texto, $maxCaracteres = 24) {
                                $texto = mb_convert_encoding($texto, 'UTF-8', mb_detect_encoding($texto));
                                return mb_strlen($texto, 'UTF-8') > $maxCaracteres ? mb_substr($texto, 0, $maxCaracteres, 'UTF-8') . "..." : $texto;
                            }
    
                            if ($place_result->num_rows > 0) {
                                while ($row = $place_result->fetch_assoc()) {
                                    $category = array(
                                        'id_place' => $row['id_place'],
                                        'name_place' => $row['name_place']
                                    );
    
                                    if ($row['id_place'] == $item['id_place']) {
                                        array_push($label_place, $category);
                                    } else {
                                        $options[] = $category;
                                    }
                                }
                                array_unshift($options, ...$label_place);
    
                                foreach ($options as $option) {
                                    echo '<option value="' . $option['id_place'] . '">'. limitarString($option['name_place']) . '</option>';
                                }
                            }
                            ?>
                        </select>
                    </div>
                </div>
                <div class="viewer-section form-section">
                    <div class="viewer-text">
                        <label for="id_category" class="title-text form-label">Categoria *</label>
                        <select name="id_category" id="id_category" class="form-control" required>
                        <?php
                            $cat_query = "SELECT * FROM categories";
                            $cat_result = mysqli_query($db, $cat_query);
    
                            $options = array();
                            $label_cat = array(); 
    
                            if ($cat_result->num_rows > 0) {
                                while ($row = $cat_result->fetch_assoc()) {
                                    $category = array(
                                        'id_category' => $row['id_category'],
                                        'name_category' => $row['name_category']
                                    );
    
                                    if ($row['id_category'] == $item['id_category']) {
                                        array_push($label_cat, $category);
                                    } else {
                                        $options[] = $category;
                                    }
                                }
                                array_unshift($options, ...$label_cat);
    
                                foreach ($options as $option) {
                                    echo '<option value="' . $option['id_category'] . '">'. $option['name_category'] . '</option>';
                                }
                            }
                            ?>
                        </select>
                    </div>
                    <div class="viewer-text">
                        <label for="id_status" class="title-text form-label">Status *</label>
                        <select name="id_status" id="id_status" class="form-control" required>
                            <?php
                            $status_query = "SELECT * FROM status";
                            $status_result = mysqli_query($db, $status_query);
    
                            $options = array();
                            $label_status = array(); 
    
                            if ($status_result->num_rows > 0) {
                                while ($row = $status_result->fetch_assoc()) {
                                    $category = array(
                                        'id_status' => $row['id_status'],
                                        'name_status' => $row['name_status']
                                    );
    
                                    if ($row['id_status'] == $item['id_status']) {
                                        array_push($label_status, $category);
                                    } else {
                                        $options[] = $category;
                                    }
                                }
                                array_unshift($options, ...$label_status);
    
                                foreach ($options as $option) {
                                    echo '<option value="' . $option['id_status'] . '">'. $option['name_status'] . '</option>';
                                }
                            }
                            ?>
                        </select>
                    </div>
                    <div class="viewer-text">
                        <label for="got_item" class="title-text form-label">Ano de Compra</label>
                        <input type="number"  id="got_item" name="got_item" class="form-control" placeholder="Insira o ano" min="2000" max="<?php echo date('Y'); ?>" maxlength="4" value="<?php echo $item['got_item']; ?>">
                    </div>
                    <div class="viewer-text">
                        <label for="price_item" class="title-text form-label">Preço</label>
                        <input type="number"  id="price_item" name="price_item" class="form-control" placeholder="0,00" step="0.01" min="0" value="<?php echo $item['price_item']; ?>">
                    </div>
                </div>
            </div>
                    
        </div>

        <input type="hidden" name="id_user" value="<?php echo $id_user; ?>">
        <input type="hidden" name="action" value="item_edit">
        <input type="hidden" name="id" value="<?php echo $id; ?>">
        <div class="btn-section">
            <button type="submit" class="form-btn btn btn-success pEdit"><span class="material-symbols-rounded">check</span>Salvar</button>
            <div class="form-btn btn btn-secondary pCancel" id="type_tab_1">Cancelar</div>
        </div>
    </div>
</div>
</form>
</div>