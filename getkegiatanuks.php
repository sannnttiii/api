<?php
  require_once('connection.php'); 
    
    $sql = "SELECT k.*, j.nama as jenis from kegiatanuks k inner join jeniskegiatan j on k.jeniskegiatan_id = j.id  GROUP BY k.nama, k.tanggal_acara order by k.tanggal_acara";
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