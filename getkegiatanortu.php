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

$siswaid = $_POST['siswaid'];
$sql ="SELECT k.*, j.nama as jenis
FROM kegiatanuks k inner join jeniskegiatan j on j.id = k.jeniskegiatan_id
WHERE k.for_all =1
AND k.tanggal_acara >= now( )
AND periodeajaran_id ='$periode'
OR k.kelasajaran_id = (
SELECT ks.kelasajaran_id
FROM siswa s
INNER JOIN kelassiswa ks ON s.id = ks.siswa_id
WHERE ks.status =1
AND s.id ='$siswaid' )
AND k.tanggal_acara >= now( )
AND periodeajaran_id ='$periode'";
$stmt = $c->prepare($sql);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $array = array();
    $i = 0;
    while ($row = $result->fetch_assoc()) {
        $array[$i]['id'] = addslashes(htmlentities($row['id']));
        $array[$i]['nama'] = addslashes(htmlentities($row['nama']));
        $array[$i]['tanggal'] = addslashes(htmlentities($row['tanggal_acara']));
        $array[$i]['pelaksana'] = addslashes(htmlentities($row['pelaksana']));
        $array[$i]['jenis'] = addslashes(htmlentities($row['jenis']));

        $i++;
    }
    echo json_encode(array("status" => true, "pesan" => $array));
  } else {
    echo json_encode(array("status" => false, "pesan" => "Tidak ada data kegiatan uks"));
    die();
  }

?>