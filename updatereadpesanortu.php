<?php
require_once('connection.php'); 

$id = $_POST['ortuid'];
$sql = "UPDATE chat set is_read = 1 WHERE orangtua_id='$id' and pengirim = 1 ";
$stmt = $c->prepare ($sql);
$stmt->execute();
if($stmt->affected_rows) {
    $arr_hasil = array("status"=>true,
    "pesan"=> 'Pesan terbaca semua');
} else {
    $arr_hasil = array("status"=>false, 
    "pesan"=>'Gagal update pesan terbaca semua');
}
echo json_encode($arr_hasil);

?>