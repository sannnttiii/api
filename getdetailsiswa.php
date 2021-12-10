<?php
  require_once('connection.php'); 
    
    $id = $_POST['siswaid'];
    $sql = "SELECT s.id, s.nama, k.kelas, p.tahunajaran, ks.kelasajaran_id, p.id as pid, o.token_device
    FROM kelassiswa ks inner join siswa s on ks.siswa_id = s.id
    INNER JOIN kelasajaran k ON k.id = ks.kelasajaran_id
    INNER JOIN periodeajaran p ON p.id = ks.periodeajaran_id
    inner join orangtua o on o.id = s.orangtua_id
    WHERE s.id = ? and p.status=1";
    $stmt = $c->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $array = array();
        $i = 0;
        while ($row = $result->fetch_assoc()) {
            $array[$i]['idsiswa'] = addslashes(htmlentities($row['id']));
            $array[$i]['nama'] = addslashes(htmlentities($row['nama']));
            $array[$i]['kelas'] = addslashes(htmlentities($row['kelas']));
            $array[$i]['periode'] = addslashes(htmlentities($row['tahunajaran']));
            $array[$i]['kelasid'] = addslashes(htmlentities($row['kelasajaran_id']));
            $array[$i]['periodeid'] = addslashes(htmlentities($row['pid']));
            $array[$i]['tokendevice'] = addslashes(htmlentities($row['token_device']));

            $i++;
        }
        echo json_encode(array("status" => true, "pesan" => $array));
      } else {
        echo json_encode(array("status" => false, "pesan" => "Gagal mengambil detail siswa"));
        die();
      }
?>