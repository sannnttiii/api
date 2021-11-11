<?php
require_once('connection.php'); 

$tinggi= $_POST['tinggi'];
$berat = $_POST['berat'];
$siswaid = (int)$_POST['siswaid'];
$kegiatanid = (int)$_POST['kegiatanid'];
$hasil = $_POST['hasil'];
$catatan = $_POST['catatan'];
$periodeid =0;
$kelasajaranid= 0;

$sql = "SELECT kelasajaran_id, periodeajaran_id from kelassiswa where siswa_id = '$siswaid' and status=1";
$result = $c->query($sql);

if ($result->num_rows > 0) {
  while($row = $result->fetch_assoc()) {
    $periodeid = $row['periodeajaran_id'];
    $kelasajaranid = $row['kelasajaran_id'];
  }
}

$sql = "INSERT INTO laporanpemeriksaan (tinggi_badan, berat_badan, hasil, catatan, kegiatanuks_id, siswa_id, kelasajaran_id, periodeajaran_id) values (?,?,?,?,?,?,?,?)";
$stmt = $c->prepare($sql);
$stmt->bind_param("ssssiiii",$tinggi,$berat,$hasil,$catatan,$kegiatanid,$siswaid,$kelasajaranid, $periodeid);
$stmt->execute();


if ($stmt->affected_rows > 0) {
  $arr_hasil = array("status"=>true,
"pesan"=> 'Berhasil menambah Laporan Pemeriksaan');
} else {
   $arr_hasil = array("status"=>false, 
"pesan"=>'Gagal menambah Laporan Pemeriksaan');
}
echo json_encode($arr_hasil);
?>