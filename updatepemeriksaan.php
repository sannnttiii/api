<?php
require_once('connection.php'); 

$tinggi= $_POST['tinggi'];
$berat = $_POST['berat'];
$pemeriksaanid = (int)$_POST['id'];
$kegiatanid = (int)$_POST['kegiatanid'];
$hasil=NULL;
$catatan = NULL;
if(isset ($_POST['hasil']) ){
  $hasil = $_POST['hasil'];
}
if(isset ($_POST['catatan']))
{
  $catatan = $_POST['catatan'];
}
$periodeid =0;
$kelasajaranid= 0;

$sql = "UPDATE laporanpemeriksaan set tinggi_badan='$tinggi', berat_badan='$berat', hasil='$hasil', catatan='$catatan', kegiatanuks_id='$kegiatanid' WHERE id = '$pemeriksaanid'";
$stmt = $c->prepare($sql);
$stmt->execute();


if ($stmt->affected_rows > 0) {
  $arr_hasil = array("status"=>true,
"pesan"=> 'Berhasil mengubah Laporan Pemeriksaan');
} else {
   $arr_hasil = array("status"=>false, 
"pesan"=>'Gagal mengubah Laporan Pemeriksaan');
}
echo json_encode($arr_hasil);
?>