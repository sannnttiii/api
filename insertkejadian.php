<?php
require_once('connection.php'); 

$kejadian= $_POST['kejadian'];
$siswaid = (int)$_POST['siswaid'];
$tanggal = $_POST['tanggal'];
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

$sql = "INSERT INTO laporankejadian (kejadian, tanggal, siswa_id, kelasajaran_id, periodeajaran_id) values (?,?,?,?,?)";
$stmt = $c->prepare($sql);
$stmt->bind_param("ssiii",$kejadian,$tanggal,$siswaid,$kelasajaranid, $periodeid);
$stmt->execute();


if ($stmt->affected_rows > 0) {
  $arr_hasil = array("status"=>true,
"pesan"=> 'Berhasil menambah Laporan Kejadian');
} else {
   $arr_hasil = array("status"=>false, 
"pesan"=>'Gagal menambah Laporan Kejadian');
}
echo json_encode($arr_hasil);
?>