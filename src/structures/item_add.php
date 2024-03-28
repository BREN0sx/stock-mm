<?php
    $place_id = $_GET['room'];
    $role = true;

    if (isset($_COOKIE['token'])) {
        $user_decoder = json_decode(base64_decode(explode('.', $_COOKIE['token'])[1]));
        $id_user = $user_decoder->data->id_user;
        $admin_user = $user_decoder->data->admin_user;
        
        if ($admin_user != 1) $role = false;
    } else {
        $role = false;
    }
    
    $place_query = "SELECT name_place FROM places WHERE id_place = $place_id";
    $place_result = mysqli_query($db, $place_query);
    $place_name = mysqli_fetch_assoc($place_result)['name_place'];

?>

<div class="add-modal" id="modal_add" style="display: none;">
    <?php
        if ($role == true) {
    ?>
    <form id="form-add" action="../../src/includes/_functions.php" method="POST"  enctype="multipart/form-data">

<div class="add-section">
    <div class="add-container">
        <div class="add-label">
            <h1>Adicionar - <?php echo ucfirst(strtolower($place_name))?></h1>
            <span class="material-symbols-rounded _modal_add_close" >close</span>
        </div>
        <div class="viewer-container ">

            <div class="viewer-image drop-zone">
                <span class="drop-zone__prompt">Arraste uma imagem ou faça upload</span>
                <span class="drop-zone__prompt support">JPEG, JPG, PNG, WEBP</span>
                <input type="file" name="image_item" class="drop-zone__input" accept=".png, .jpg, .jpeg, .webp">
            </div>

            <div class="viewer-text-container">
                <div class="viewer-section form-section">
                    <div class="viewer-text">
                        <label for="ci_item" class="title-text form-label">Código Tombamento</label>
                        <input type="text"  id="ci_item" name="ci_item" class="form-control" placeholder="Insira o código">
                    </div>
                    <div class="viewer-text">
                        <label for="name_item" class="title-text form-label">Nome *</label>
                        <input type="text"  id="name_item" name="name_item" class="form-control" placeholder="Insira o nome" required>
                    </div>
                    <div class="viewer-text">
                        <label for="about_item" class="title-text form-label">Descrição</label>
                        <input type="text"  id="about_item" name="about_item" class="form-control" placeholder="Insira a descrição">
                    </div>
                </div>
                <div class="viewer-section form-section">
                    <div class="viewer-text">
                        <label for="id_category" class="title-text form-label">Categoria *</label>
                        <select name="id_category" id="id_category" class="form-control" required>
                            <?php
                            $sql = "SELECT * FROM categories";
                            $result = mysqli_query($db, $sql);

                            if ($result->num_rows > 0) {
                                while ($row = $result->fetch_assoc()) {
                                    echo '<option value="' . $row['id_category'] . '">'. $row['name_category'] . '</option>';
                                }
                            }
                            ?>
                        </select>
                    </div>
                    <div class="viewer-text">
                        <label for="id_status" class="title-text form-label">Status *</label>
                        <select name="id_status" id="id_status" class="form-control" required>
                            <?php
                            $sql = "SELECT * FROM status";
                            $result = mysqli_query($db, $sql);

                            if ($result->num_rows > 0) {
                                while ($row = $result->fetch_assoc()) {
                                    echo '<option value="' . $row['id_status'] . '">'. $row['name_status'] . '</option>';
                                }
                            }
                            ?>
                        </select>
                    </div>
                    <div class="viewer-text">
                        <label for="got_item" class="title-text form-label">Ano de Compra</label>
                        <input type="number"  id="got_item" name="got_item" class="form-control" placeholder="Insira o ano" min="2000" max="<?php echo date('Y'); ?>" maxlength="4" value="<?php echo date('Y'); ?>">
                    </div>
                    <div class="viewer-text">
                        <label for="price_item" class="title-text form-label">Preço</label>
                        <input type="number"  id="price_item" name="price_item" class="form-control" placeholder="0,00" step="0.01" min="0">
                    </div>
                </div>
            </div>
                    
        </div>

        <input type="hidden" name="id_place" value="<?php echo $place_id; ?>">
        <input type="hidden" name="id_user" value="<?php echo $id_user; ?>">

        <input type="hidden" name="action" value="item_add">
        <button class="form-btn pAdd" type="submit" class="btn btn-success"><span class="material-symbols-rounded">check</span>Adicionar</button>
    </div>
</div>
</form>
<?php } ?>
</div>