<?php
  require_once('connection.php'); 
    
    $sql = "SELECT k.id, k.nama, k.pelaksana, k.tanggal_acara, j.nama AS jenis, k.perizinan
    FROM kegiatanuks k
    INNER JOIN jeniskegiatan j ON j.id = k.jeniskegiatan_id
    GROUP BY nama, tanggal_acara
    ORDER BY ABS( DATEDIFF( tanggal_acara, CURDATE( ) ) )";
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
            $array[$i]['perizinan'] = addslashes(htmlentities($row['perizinan']));
            $i++;
        }
        echo json_encode(array("status" => true, "pesan" => $array));
      } else {
        echo json_encode(array("status" => false, "pesan" => "Tidak ada data kegiatan"));
        die();
      }
?>