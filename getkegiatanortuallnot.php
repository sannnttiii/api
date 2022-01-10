<?php
require_once('connection.php'); 

//for_all belum diacc
$periode=0;
$sql = "SELECT id,tahunajaran from periodeajaran where status=1";
$result = $c->query($sql);

if ($result->num_rows > 0) {
  while($row = $result->fetch_assoc()) {
    $periode = $row['id'];

  }
}

// $ortuid = $_POST['ortuid'];

// $sql = "SELECT k. * , j.nama AS jenis
// FROM kegiatanuks k
// INNER JOIN jeniskegiatan j ON j.id = k.jeniskegiatan_id
// INNER JOIN periodeajaran pa ON pa.id = k.periodeajaran_id
// WHERE k.tanggal_acara >= now( )
// AND k.perizinan =1
// AND for_all =1
// AND pa.status =1
// AND NOT
// EXISTS (

// SELECT *
// FROM perizinan p
// INNER JOIN siswa s ON s.id = p.siswa_id
// WHERE k.id = p.kegiatanuks_id
// AND s.id
// IN ( SELECT s.id
// FROM siswa s
// INNER JOIN orangtua o ON o.id = s.orangtua_id
// WHERE o.id ='$ortuid' ) GROUP BY s.id )";
// $stmt = $c->prepare($sql);
// $stmt->execute();
// $result = $stmt->get_result();

$siswaid = $_POST['siswaid'];
$sql = "SELECT k. * , j.nama AS jenis
FROM kegiatanuks k
INNER JOIN jeniskegiatan j ON j.id = k.jeniskegiatan_id
INNER JOIN periodeajaran pa ON pa.id = k.periodeajaran_id
WHERE k.tanggal_acara>= CURDATE( )
AND k.perizinan =1
AND for_all =1
AND pa.status =1
AND NOT
EXISTS (

SELECT *
FROM perizinan p
INNER JOIN siswa s ON s.id = p.siswa_id
WHERE k.id = p.kegiatanuks_id
AND s.id ='$siswaid' )";
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
    echo json_encode(array("status" => false, "pesan" => "Tidak ada data kegiatan uks untuk semua siswa blm acc"));
    die();
}


?>