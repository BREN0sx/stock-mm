<?php
if (isset($_GET['by'])) require '../../src/includes/_db.php';
else require '../../src/includes/_db.php';

    $place_id = $_GET['room'];
    $id = $_GET['item'];

    if ($_GET['tab'] != 3) return;

    $product_query = "SELECT * FROM item WHERE id_item = '$id'";
    $product_result = mysqli_query($db, $product_query);
    $products = mysqli_fetch_assoc($product_result);
?>

<?php if (!isset($_GET['by'])) { ?><div class="add-modal" id="modal_delete" style="display: <?php echo $id == "" ? "none": "flex";?>;"><?php } ?>

<form action="../../src/includes/_functions.php" method="POST"  enctype="multipart/form-data">

<div class="add-section">
    <div class="add-container">
        <div class="add-label">
            <h1>Confirmar ação - <?php echo $products['name_item']?></h1>
            <span class="material-symbols-rounded _modal_delete_close">close</span>
        </div>
        <input type="hidden" name="action" value="item_remove">
        <input type="hidden" name="id" value="<?php echo $id;?>">
        <input type="hidden" name="place_id" value="<?php echo $place_id;?>">
        <button class="form-btn trash pDel" type="submit" class="btn btn-success"><span class="material-symbols-rounded">check</span>Deletar</button>
    </div>
</div>
</form>
</div>