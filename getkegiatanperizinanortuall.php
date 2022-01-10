<?php
  require_once('connection.php'); 
    
    $id = $_POST['ortuid'];
    $sql = "SELECT k. *, j.nama as jenis
    FROM kegiatanuks k inner join jeniskegiatan j on j.id = k.jeniskegiatan_id 
    INNER JOIN periodeajaran pa ON pa.id = k.periodeajaran_id
    WHERE k.tanggal_acara >= CURDATE( )
    and k.perizinan =1
    AND for_all =1
    AND pa.status =1
    AND NOT
    EXISTS (
    
    SELECT *
    FROM perizinan p
    INNER JOIN siswa s ON s.id = p.siswa_id
    WHERE k.id = p.kegiatanuks_id
    AND s.id
    IN (
    
    SELECT s.id
    FROM siswa s
    INNER JOIN orangtua o ON o.id = s.orangtua_id
    WHERE o.id =?
    )
    GROUP BY s.id )";

    $stmt = $c->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $array = array();
        $i = 0;
        while ($row = $result->fetch_assoc()) {
            $array[$i]['id'] = addslashes(htmlentities($row['id']));
            $array[$i]['nama'] = addslashes(htmlentities($row['nama']));
            $array[$i]['tanggal'] = addslashes(htmlentities($row['tanggal_acara']));
            $array[$i]['jenis'] = addslashes(htmlentities($row['jenis']));
            $array[$i]['pelaksana'] = addslashes(htmlentities($row['pelaksana']));

            $i++;
        }
        echo json_encode(array("status" => true, "pesan" => $array));
      } else {
        echo json_encode(array("status" => false, "pesan" => "Tidak ada data kegiatan untuk semua yang perlu perizinan"));
        die();
      }
?>