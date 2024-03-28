<?php
require_once ("_db.php");

if(isset($_POST['action'])){ 
    switch($_POST['action']){
        case 'item_remove':
            item_remove();
        break;        
        case 'item_edit':
            item_edit();
        break;
        case 'item_add':
            item_add();
        break;  
        case 'change_active_resp':
            change_active_resp();
        break;   
    }
}

function item_add(){
    global $db;
    extract($_POST);

    if (empty($_FILES['image_item']['name'])) {
        $image_product = null;
    } else {

    $file_size = $_FILES['image_item']['size'];
    
    $file_up = fopen($_FILES['image_item']['tmp_name'], 'r');
    $image_bin = fread($file_up,$file_size);   

    $image_product = mysqli_escape_string($db,$image_bin);
    }
    
    $date_item = date('Y-m-d');

    $ci_item = isset($_POST['ci_item']) ? $_POST['ci_item'] : null;
    $about_item = isset($_POST['about_item']) ? $_POST['about_item'] : null;
    $price_item = isset($_POST['price_item']) ? $_POST['price_item'] : null;
    $got_item = isset($_POST['got_item']) ? $_POST['got_item'] : null;
    $user_item = $_POST['id_user'];

    $consulta="INSERT INTO item (name_item, ci_item, about_item, price_item, image_item, got_item, date_item, id_status, id_place, id_category, id_user)
    VALUES ('$name_item', '$ci_item', '$about_item', '$price_item', '$image_product', '$got_item', '$date_item', '$id_status', '$id_place', '$id_category', '$user_item');" ;

    mysqli_query($db, $consulta);

    if (mysqli_errno($db) == 0) {
        $last_insert_id = mysqli_insert_id($db);

        mysqli_query($db, "
            UPDATE item SET 
                name_item = NULLIF(name_item, ''),
                ci_item = NULLIF(ci_item, ''),
                about_item = NULLIF(about_item, ''),
                price_item = NULLIF(price_item, ''),
                got_item = NULLIF(got_item, '')
            WHERE id_item = $last_insert_id
        ");
    }
    
    header("Location: ../../views/stock?room=$id_place");
}

function item_edit(){
    global $db;
    extract($_POST);

    $item_query = "SELECT * FROM item WHERE id_item = '$id'";
    $item_result = mysqli_query($db, $item_query);
    $item_row = mysqli_fetch_assoc($item_result);

    if (empty($_FILES['image_item']['name'])) {
        $image_item = $item_row['image_item'];
    } else {
        $file_size = $_FILES['image_item']['size'];
        $file_up = fopen($_FILES['image_item']['tmp_name'], 'r');
        $image_bin = fread($file_up,$file_size); 
        $image_item = mysqli_escape_string($db,$image_bin);  

        $image_send_query="UPDATE item SET image_item = '$image_item' WHERE id_item = $id";
        mysqli_query($db, $image_send_query);
    }

    $date_item = date('Y-m-d');
    $user_item = $_POST['id_user'];

    $consulta="UPDATE item SET name_item = '$name_item', about_item = '$about_item', ci_item = '$ci_item', price_item = '$price_item', got_item = '$got_item', date_item = '$date_item', id_status = '$id_status', id_place = '$id_place', id_category = '$id_category', id_user = '$user_item' WHERE id_item = $id";
    mysqli_query($db, $consulta);

    if (mysqli_errno($db) == 0) {
        mysqli_query($db, "
            UPDATE item SET 
                name_item = NULLIF(name_item, ''),
                ci_item = NULLIF(ci_item, ''),
                about_item = NULLIF(about_item, ''),
                price_item = NULLIF(price_item, ''),
                got_item = NULLIF(got_item, '')
            WHERE id_item = $id
        ");
    }

    header("Location: ../../views/stock?room=$id_place&item=$id");
}
function item_remove(){
    global $db;
    extract($_POST);

    $id_item = $_POST['id'];
    $id_place = $_POST['place_id'];
    $item_query = "DELETE FROM item WHERE id_item = $id_item";
    mysqli_query($db, $item_query);
    header("Location: ../../views/stock?room=$id_place");
}
?>