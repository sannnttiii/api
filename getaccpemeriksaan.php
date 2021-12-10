<?php
require_once('connection.php'); 

$periode=0;
$sql = "SELECT id,tahunajaran from periodeajaran where status=1";
$result = $c->query($sql);

if ($result->num_rows > 0) {
  while($row = $result->fetch_assoc()) {
    $periode = $row['id'];

  }
}

$sql = "SELECT s . * , k.kelasajaran_id AS kelasid, o.user_token AS token, o.token_device AS device
FROM siswa s
INNER JOIN kelassiswa k ON k.siswa_id = s.id
INNER JOIN orangtua o ON o.id = s.orangtua_id
WHERE s.id
IN (
SELECT b.siswa_id
FROM (

SELECT a.siswa_id, (
SELECT COUNT( * )
FROM laporanpemeriksaan
WHERE is_confirm =1
AND periodeajaran_id ='$periode'
AND siswa_id = a.siswa_id
) AS acc, 
(
SELECT COUNT( * )
FROM laporanpemeriksaan
WHERE is_confirm =0
AND periodeajaran_id =4
AND siswa_id = a.siswa_id
) AS undone
FROM (
SELECT DISTINCT Siswa_id
FROM laporanpemeriksaan
)a
)b
WHERE undone =0
)";
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
    echo json_encode(array("status" => false, "pesan" => "Tidak ada yang sudah Acc Laporan Pemeriksaan"));
    die();
  }


?>