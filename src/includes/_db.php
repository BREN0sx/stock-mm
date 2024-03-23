<?php
$db = mysqli_connect("localhost", "root", "", "storage");
mysqli_set_charset($db, 'utf8');

if(!$db){
echo "[DB-ERR] :: ".
mysqli_connect_error() ;
}
?>