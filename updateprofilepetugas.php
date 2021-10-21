<?php
require_once('connection.php'); 

$id = $_POST['petugasid'];
$nama = $_POST['nama'];
$alamat = $_POST['alamat'];
$telp = $_POST['telp'];
$sql = "UPDATE petugasuks set nama = '$nama', alamat='$alamat', no_hp = '$telp' WHERE id='$id' ";
$stmt = $c->prepare ($sql);
$stmt->execute();
if($stmt->affected_rows) {
    $arr_hasil = array("status"=>true,
    "pesan"=> 'Berhasil Update Profil Petugas UKS');
} else {
    $arr_hasil = array("status"=>false, 
    "pesan"=>'Gagal Update profil petugas UKS');
}
echo json_encode($arr_hasil);

?>