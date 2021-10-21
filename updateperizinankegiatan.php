<?php
require_once('connection.php'); 
    
$ortuid = $_POST['ortuid'];
$siswaid = $_POST['siswaid'];
$kegiatanid = $_POST['kegiatanid'];
$kelasajaranid = $_POST['kelasajaranid'];
$periodeajaranid = $_POST['periodeajaranid'];
$acc = 'Ya';

$sql = "INSERT INTO perizinan ( status, Orangtua_id, kegiatanuks_id, siswa_id, kelasAjaran_id, periodeajaran_id)  VALUES (?,?,?,?,?,?) ";
$stmt = $c->prepare ($sql);
$stmt->bind_param("siiiii",$acc, $ortuid, $kegiatanid, $siswaid, $kelasajaranid, $periodeajaranid);
$stmt->execute();

if($stmt->affected_rows>0) {
    $arr_hasil = array("status"=>true,
    "pesan"=> "Berhasil Konfirmasi Perizinan");
} else {
    $arr_hasil = array("status"=>false, 
    "pesan"=>'Gagal konfirmasi perizinan');
}
echo json_encode($arr_hasil);

?>