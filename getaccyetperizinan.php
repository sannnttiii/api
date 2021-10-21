<?php
require_once('connection.php'); 
$periode=0;
$namakegiatan ='';
$tanggal = '';

$id = $_POST['kegiatanid'];
$sql = "SELECT id,tahunajaran from periodeajaran where status=1";
$result = $c->query($sql);

if ($result->num_rows > 0) {
  while($row = $result->fetch_assoc()) {
    $periode = $row['id'];

  }
}
$sql = "SELECT nama,tanggal_acara from kegiatanuks where id='$id'";
$result = $c->query($sql);

if ($result->num_rows > 0) {
  while($row = $result->fetch_assoc()) {
    $namakegiatan = $row['nama'];
    $tanggal = $row['tanggal_acara'];
  }
}

$sql = "SELECT s. * , o.user_token as token, o.token_device as device, ka.id as kelasid
FROM siswa s
INNER JOIN orangtua o ON o.id = s.orangtua_id
INNER JOIN kelassiswa ks ON ks.siswa_id = s.id
INNER JOIN kelasajaran ka ON ka.id = ks.kelasajaran_id
RIGHT JOIN kegiatanuks ku ON ku.periodeajaran_id = ks.periodeajaran_id
WHERE ks.periodeajaran_id ='$periode'
AND ku.perizinan =1 and ku.nama = '$namakegiatan' and ku.tanggal_acara = '$tanggal'
AND NOT
EXISTS (
SELECT *
FROM perizinan p
WHERE p.siswa_id = s.id
AND ku.id = p.kegiatanuks_id
)
GROUP BY s.id";

$stmt = $c->prepare($sql);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $array = array();
    $arrdevice = array();
    $i = 0;
    while ($row = $result->fetch_assoc()) {
        $array[$i]['id'] = addslashes(htmlentities($row['id']));
        $array[$i]['nama'] = addslashes(htmlentities($row['nama']));
        $array[$i]['kelasid'] = addslashes(htmlentities($row['kelasid']));
        $array[$i]['ortutoken'] = addslashes(htmlentities($row['token']));
        $arrdevice[$i]['tokendevice'] = addslashes(htmlentities($row['device']));
        $array[$i]['ortuid'] = addslashes(htmlentities($row['Orangtua_id']));

        $i++;
    }
    echo json_encode(array("status" => true, "pesan" => $array,"device"=>$arrdevice));
  } else {
    echo json_encode(array("status" => false, "pesan" => "Tidak ada yang Belum Acc Laporan Pemeriksaan"));
    die();
  }
?>