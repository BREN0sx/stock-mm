<?php
$db = mysqli_connect("localhost", "eeepma26_stock", "stock8xYfSX%", "eeepma26_stock");
mysqli_set_charset($db, 'utf8');

if(!$db){
echo "[DB-ERR] :: ".
mysqli_connect_error() ;
}
?>