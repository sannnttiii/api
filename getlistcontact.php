<?php
  require_once('connection.php'); 

    $sql = "SELECT o.user_token, o.id,s.id as idsiswa, s.nama, ka.kelas, p.tahunAjaran, o.token_device as device
    FROM kelassiswa ks
    INNER JOIN siswa s ON s.id = ks.siswa_id
    INNER JOIN orangtua o ON s.orangtua_id = o.id
    INNER JOIN periodeAjaran p ON ks.periodeAjaran_id = p.id
    INNER JOIN kelasAjaran ka ON ks.kelasAjaran_id = ka.id
    WHERE p.status =1
    GROUP BY ks.kelasAjaran_id, s.nama
    ORDER BY ka.kelas, s.nama";
    $stmt = $c->prepare($sql);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $array = array();
        $i = 0;
        while ($row = $result->fetch_assoc()) {
            $array[$i]['ortutoken'] = addslashes(htmlentities($row['user_token']));
            $array[$i]['tokendevice'] = addslashes(htmlentities($row['device']));
            $array[$i]['ortuid'] = addslashes(htmlentities($row['id']));
            $array[$i]['namasiswa'] = addslashes(htmlentities($row['nama']));
            $array[$i]['idsiswa'] = addslashes(htmlentities($row['idsiswa']));
            $array[$i]['kelas'] = addslashes(htmlentities($row['kelas']));
            $array[$i]['periode'] = addslashes(htmlentities($row['tahunAjaran']));
            $i++;
        }
        echo json_encode($array);
      } else {
      echo json_encode ("Unable to process you request, please try again");
        die();
      }
?>