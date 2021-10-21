<?php
require_once('connection.php'); 
$id = $_POST['kegiatanid'];
$periode=0;
$namakegiatan ='';
$tanggal = '';
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

$sql = "SELECT s.*, ks.kelasajaran_id as kelasid, o.user_token as token, o.token_device as device
FROM perizinan p inner join kegiatanuks k on p.kegiatanuks_id = k.id
INNER JOIN siswa s ON p.siswa_id = s.id
INNER JOIN kelassiswa ks ON ks.siswa_id = s.id
inner join orangtua o on o.id =s.orangtua_id
WHERE k.nama = '$namakegiatan' and k.tanggal_acara = '$tanggal'
AND p.periodeajaran_id = '$periode'
AND p.status = 'Ya' and ks.status = 1
GROUP BY s.id";
$stmt = $c->prepare($sql);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $array = array();
    $i = 0;
    while ($row = $result->fetch_assoc()) {
        $array[$i]['id'] = addslashes(htmlentities($row['id']));
        $array[$i]['nama'] = addslashes(htmlentities($row['nama']));
        $array[$i]['kelasid'] = addslashes(htmlentities($row['kelasid']));
        $array[$i]['ortutoken'] = addslashes(htmlentities($row['token']));
        $array[$i]['ortuid'] = addslashes(htmlentities($row['Orangtua_id']));
        $array[$i]['tokendevice'] = addslashes(htmlentities($row['device']));

        $i++;
    }
    echo json_encode(array("status" => true, "pesan" => $array));
  } else {
    echo json_encode(array("status" => false, "pesan" => "Tidak ada yang sudah Acc Kegiatan"));
    die();
  }


?>