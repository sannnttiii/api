<?php
  require_once('connection.php'); 
    
    $id = $_POST['ortuid'];
    $sql = "SELECT k. *
    FROM kegiatanuks k
    INNER JOIN jeniskegiatan j ON j.id = k.jeniskegiatan_id
    WHERE k.tanggal_acara >= now( )
    AND k.perizinan =0
    AND k.for_all =1
    OR k.perizinan =0
    AND k.kelasajaran_id = (
    SELECT k.kelasajaran_id
    FROM kelassiswa ks
    INNER JOIN siswa s ON s.id = ks.siswa_id
    INNER JOIN orangtua o ON o.id = s.orangtua_id
    WHERE o.id =?
    AND ks.status =1 )";

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