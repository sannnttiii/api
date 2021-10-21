<?php
  require_once('connection.php'); 
    
    $id = $_POST['ortuid'];
    $sql = "SELECT i . * , ka.kelas AS untuk
    FROM kelasajaran ka
    INNER JOIN kelassiswa ks ON ka.id = ks.kelasajaran_id
    RIGHT JOIN informasi i ON i.kelasAjaran_id = ks.kelasAjaran_id
    WHERE for_all =1
    OR ks.kelasAjaran_id
    IN ( SELECT ks.kelasAjaran_id
    FROM siswa s
    INNER JOIN orangtua o ON o.id = s.orangtua_id
    INNER JOIN kelassiswa ks ON s.id = ks.siswa_id
    WHERE o.id =? 
    AND ks.status =1) 
    AND ks.status =1 ";
    $stmt = $c->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $array = array();
        $i = 0;
        while ($row = $result->fetch_assoc()) {
            $array[$i]['id'] = addslashes(htmlentities($row['id']));
            $array[$i]['poster'] = addslashes(htmlentities($row['poster']));
            $array[$i]['judul'] = addslashes(htmlentities($row['judul']));
            $array[$i]['keterangan'] = addslashes(htmlentities($row['keterangan']));
            $array[$i]['untuk'] = addslashes(htmlentities($row['untuk']));

            $i++;
        }
        echo json_encode(array("status" => true, "pesan" => $array));
      } else {
        echo json_encode(array("status" => false, "pesan" => "Tidak ada data laporan pemeriksaan"));
        die();
      }
?>