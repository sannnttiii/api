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

$sql = "SELECT count( * ) AS jumlah
FROM (
SELECT s. * , o.user_token AS token, o.token_device as device, ka.id AS kelasid
FROM siswa s
INNER JOIN orangtua o ON o.id = s.orangtua_id
INNER JOIN kelassiswa ks ON ks.siswa_id = s.id
INNER JOIN kelasajaran ka ON ka.id = ks.kelasajaran_id
RIGHT JOIN kegiatanuks ku ON ku.periodeajaran_id = ks.periodeajaran_id
WHERE ks.periodeajaran_id ='$periode'
AND ku.perizinan =1
AND NOT
EXISTS (
SELECT *
FROM perizinan p
WHERE p.siswa_id = s.id
AND ku.id = p.kegiatanuks_id
) group by ku.nama, s.id
) AS tab";
$stmt = $c->prepare($sql);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $array = array();
    $i = 0;
    while ($row = $result->fetch_assoc()) {
        $array[$i]['jumlah'] = addslashes(htmlentities($row['jumlah']));

        $i++;
    }
    echo json_encode(array("status" => true, "pesan" => $array));
  } else {
    echo json_encode(array("status" => false, "pesan" => "Tidak ada yang belum acc perizinan kegiatan UKS"));
    die();
  }


?>