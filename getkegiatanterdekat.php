<?php
  require_once('connection.php'); 
    $id = $_POST['ortuid'];
    
    $sql = "SELECT k.id, k.pelaksana, k.tanggal_acara, k.nama, j.nama AS jenis, ka.kelas, DATEDIFF( k.tanggal_acara, CURDATE( ) ) AS jarak
    FROM kegiatanuks k
    INNER JOIN jeniskegiatan j ON j.id = k.jeniskegiatan_id
    LEFT join kelasajaran ka on ka.id = k.kelasajaran_id
    WHERE CURDATE( ) <= k.tanggal_acara
    AND DATEDIFF( k.tanggal_acara, CURDATE( ) ) <= 7 
    and for_all =1 
    OR 
    CURDATE( ) <= k.tanggal_acara
    AND DATEDIFF( k.tanggal_acara, CURDATE( ) ) <= 7
   and for_all = 0 and k.kelasajaran_id in(SELECT ks.kelasajaran_id
FROM siswa s
INNER JOIN kelassiswa ks ON ks.siswa_id = s.id
WHERE ks.status =1
AND s.id
IN (

SELECT s.id
FROM siswa s
INNER JOIN orangtua o ON o.id = s.orangtua_id
WHERE o.id ='$id'
))
    GROUP BY k.nama, k.tanggal_acara
    ORDER BY jarak";
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
            $array[$i]['jarak'] = addslashes(htmlentities($row['jarak']));
            $array[$i]['kelas'] = addslashes(htmlentities($row['kelas']));


            $i++;
        }
        echo json_encode(array("status" => true, "pesan" => $array));
      } else {
        echo json_encode(array("status" => false, "pesan" => "Tidak ada data kegiatan uks terdekat"));
        die();
      }
?>