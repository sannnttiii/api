<?php
require_once('connection.php'); 

$id = (int)$_POST['kegiatanid'];
$namaawal ='';
$tanggalawal='';
$nama= $_POST['nama'];
$jenisid = $_POST['jenisid'];
$pelaksana = $_POST['pelaksana'];
$tanggal = $_POST['tanggal'];
$periode =0;

$sql = "SELECT nama,tanggal_acara from kegiatanuks where id = '$id'";
$result = $c->query($sql);

if ($result->num_rows > 0) {
  while($row = $result->fetch_assoc()) {
    $namaawal = $row['nama'];
    $tanggalawal = $row['tanggal_acara'];
  }
}

$sql = "UPDATE kegiatanuks set nama = '$nama', jeniskegiatan_id ='$jenisid', pelaksana = '$pelaksana', tanggal_acara = '$tanggal' where nama='$namaawal' and tanggal_acara = '$tanggalawal'";
$stmt = $c->prepare ($sql);
$stmt->execute();

if ($stmt->affected_rows > 0) {
  $arr_hasil = array("status"=>true,
"pesan"=> 'Berhasil mengubah Kegiatan UKS');
} else {
   $arr_hasil = array("status"=>false, 
"pesan"=>'Gagal mengubah kegiatan UKS');
}
echo json_encode($arr_hasil);
?>