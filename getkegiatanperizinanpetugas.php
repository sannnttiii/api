<?php
  require_once('connection.php'); 
    
    $sql = "SELECT k.id, k.nama, k.pelaksana, k.tanggal_acara, j.nama AS jenis
    FROM kegiatanuks k
    INNER JOIN jeniskegiatan j ON j.id = k.jeniskegiatan_id
    WHERE perizinan =1
    GROUP BY nama, tanggal_acara
    ORDER BY tanggal_acara DESC";
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
        echo json_encode(array("status" => false, "pesan" => "Tidak ada data kegiatan yang perlu perizinan"));
        die();
      }
?>