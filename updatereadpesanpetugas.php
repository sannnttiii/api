<?php
require_once('connection.php'); 

$oid = $_POST['ortuid'];
$pid = $_POST['petugasid'];
$sql = "UPDATE chat set is_read = 1 WHERE orangtua_id='$oid' and petugasuks_id='$pid' and pengirim = 0 ";
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