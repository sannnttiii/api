<?php
require_once('connection.php'); 

$id = $_POST['id'];
$namaayah = $_POST['namaayah'];
$namaibu = $_POST['namaibu'];
$alamatayah = $_POST['alamatayah'];
$alamatibu = $_POST['alamatibu'];
$nohpayah = $_POST['nohpayah'];
$nohpibu = $_POST['nohpibu'];
$sql = "UPDATE orangtua set nama_ayah = '$namaayah', nama_ibu ='$namaibu', alamat_ayah = '$alamatayah', alamat_ibu='$alamatibu', nohp_ayah = '$nohpayah', nohp_ibu = '$nohpibu' WHERE id='$id' ";
$stmt = $c->prepare ($sql);
$stmt->execute();
if($stmt->affected_rows) {
    $arr_hasil = array("status"=>true,
    "pesan"=> 'Berhasil Update Profil Orang tua');
} else {
    $arr_hasil = array("status"=>false, 
    "pesan"=>'Gagal Update profil orang tua');
}
echo json_encode($arr_hasil);

?>