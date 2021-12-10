<?php
require_once('connection.php'); 
$id = $_POST['kegiatanid'];
$periode=0;
$namakegiatan ='';
$tanggal = '';
$izin;
$all;
$sql = "SELECT id,tahunajaran from periodeajaran where status=1";
$result = $c->query($sql);

if ($result->num_rows > 0) {
  while($row = $result->fetch_assoc()) {
    $periode = $row['id'];

  }
}

$sql = "SELECT * from kegiatanuks where id='$id'";
$result = $c->query($sql);

if ($result->num_rows > 0) {
  while($row = $result->fetch_assoc()) {
    $namakegiatan = $row['nama'];
    $tanggal = $row['tanggal_acara'];
    $izin = $row['perizinan'];
    $all = $row['for_all'];
  }
}

if($izin == 1 && $all==1)
{
$sql = "SELECT s.*, ks.kelasajaran_id as kelasid, o.user_token as token, o.token_device as device 
FROM perizinan p inner join kegiatanuks k on p.kegiatanuks_id = k.id
INNER JOIN siswa s ON p.siswa_id = s.id
INNER JOIN kelassiswa ks ON ks.siswa_id = s.id
inner join orangtua o on o.id =s.orangtua_id
WHERE k.nama = '$namakegiatan' and k.tanggal_acara = '$tanggal'
AND p.periodeajaran_id = '$periode'
AND p.status = 'Tidak' and ks.status = 1
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
        $array[$i]['tokendevice'] = addslashes(htmlentities($row['device']));
        $array[$i]['ortuid'] = addslashes(htmlentities($row['Orangtua_id']));

        $i++;
    }
    echo json_encode(array("status" => true, "pesan" => $array));
  } else {
    echo json_encode(array("status" => false, "pesan" => "Tidak ada yang sudah Acc Kegiatan"));
    die();
  }
}
else if($izin==1 && $all==0)
{
  $sql = "SELECT s.*, ks.kelasajaran_id as kelasid, o.user_token as token, o.token_device as device 
FROM perizinan p inner join kegiatanuks k on p.kegiatanuks_id = k.id
INNER JOIN siswa s ON p.siswa_id = s.id
INNER JOIN kelassiswa ks ON ks.siswa_id = s.id
inner join orangtua o on o.id =s.orangtua_id
WHERE k.nama = '$namakegiatan' and k.tanggal_acara = '$tanggal' and ks.kelasajaran_id in (SELECT kelasajaran_id
FROM kegiatanuks
WHERE nama = '$namakegiatan' and tanggal_acara = '$tanggal')
AND p.periodeajaran_id = '$periode'
AND p.status = 'Tidak' and ks.status = 1 
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
        $array[$i]['tokendevice'] = addslashes(htmlentities($row['device']));
        $array[$i]['ortuid'] = addslashes(htmlentities($row['Orangtua_id']));

        $i++;
    }
    echo json_encode(array("status" => true, "pesan" => $array));
  } else {
    echo json_encode(array("status" => false, "pesan" => "Tidak ada yang sudah Acc Kegiatan"));
    die();
  }
}

?>