<?php
require_once('connection.php'); 

$periode=0;
$jumlahpemeriksaan = 0;
$jumlahkejadian=0;
$sql = "SELECT id,tahunajaran from periodeajaran where status=1";
$result = $c->query($sql);

if ($result->num_rows > 0) {
  while($row = $result->fetch_assoc()) {
    $periode = $row['id'];

  }
}

$sql = "SELECT count(*) as jumlah from laporanpemeriksaan l inner join siswa s on l.siswa_id = s.id inner join kelassiswa k on k.siswa_id = s.id inner join orangtua o on o.id =s.orangtua_id where l.is_confirm = 0 and k.status = 1 and l.periodeajaran_id = '$periode'";
$stmt = $c->prepare($sql);
$stmt->execute();
$result = $stmt->get_result();
if ($result->num_rows > 0) {
  while($row = $result->fetch_assoc()) {
    $jumlahpemeriksaan = $row['jumlah'];

  }
}

$sql = "SELECT count(*) as jumlah from laporankejadian l inner join siswa s on l.siswa_id = s.id inner join kelassiswa k on k.siswa_id = s.id inner join orangtua o on o.id =s.orangtua_id where l.is_confirm = 0 and k.status = 1 and l.periodeajaran_id = '$periode'";
$stmt = $c->prepare($sql);
$stmt->execute();
$result = $stmt->get_result();
if ($result->num_rows > 0) {
  while($row = $result->fetch_assoc()) {
    $jumlahkejadian = $row['jumlah'];

  }
}

$jumlahAll = $jumlahkejadian + $jumlahpemeriksaan;
echo json_encode(array("status" => true, "pesan" => $jumlahAll));


?>