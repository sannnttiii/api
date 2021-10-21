<?php
require_once('connection.php'); 

$id = $_POST['id'];
$sql = "UPDATE laporankejadian set is_confirm = 1 WHERE id='$id' ";
$stmt = $c->prepare ($sql);
$stmt->execute();
if($stmt->affected_rows) {
    $arr_hasil = array("status"=>true,
    "pesan"=> 'Berhasil konfirmasi Laporan Kejadian');
} else {
    $arr_hasil = array("status"=>false, 
    "pesan"=>'Gagal konfirmasi laporan kejadian');
}
echo json_encode($arr_hasil);

?>