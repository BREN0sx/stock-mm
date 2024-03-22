<?php
if (isset($_GET['by'])) require '../includes/_db.php';
else require '../src/includes/_db.php';

    $place_id = $_GET['room'];
    $id = $_GET['item'];

    if ($_GET['tab'] != 2) return;

    $product_query = "SELECT * FROM item WHERE id_item = '$id'";
    $product_result = mysqli_query($db, $product_query);
    $item = mysqli_fetch_assoc($product_result);
?>


<?php if (!isset($_GET['by'])) { ?><div class="add-modal" id="modal_edit" style="display: <?php echo $id == "" ? "none": "flex";?>;"><?php } ?>

<form action="../src/includes/_functions.php" method="POST"  enctype="multipart/form-data">


<div class="add-section">
    <div class="add-container">
        <div class="add-label">
            <h1>Editar</h1>
            <span class="material-symbols-rounded _modal_edit_close" >close</span>
        </div>

<div class="viewer-container ">
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

        <input type="hidden" name="id_place" value="<?php echo $place_id; ?>">
        <input type="hidden" name="action" value="item_edit">
        <input type="hidden" name="id" value="<?php echo $id; ?>">
        <button type="submit" class="form-btn btn btn-success pEdit"><span class="material-symbols-rounded">check</span>Salvar</button>
    </div>
</div>
</form>
</div>
                    