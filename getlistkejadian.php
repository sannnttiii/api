<?php
  require_once('connection.php'); 
    
    $id = $_POST['siswaid'];
    $period = $_POST['periodeid'];
    $sql = "SELECT id,kejadian, tanggal,is_confirm
    FROM laporankejadian
    WHERE siswa_id = ? and periodeAjaran_id =?";
    $stmt = $c->prepare($sql);
    $stmt->bind_param("ii", $id, $period);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $array = array();
        $i = 0;
        while ($row = $result->fetch_assoc()) {
          $array[$i]['id'] = addslashes(htmlentities($row['id']));
            $array[$i]['kejadian'] = addslashes(htmlentities($row['kejadian']));
            $array[$i]['tanggal'] = addslashes(htmlentities($row['tanggal']));
            // $array[$i]['penanganan'] = addslashes(htmlentities($row['jenis_penanganan']));
            // $array[$i]['ditangani'] = addslashes(htmlentities($row['ditangani_oleh']));
            // $array[$i]['jam'] = addslashes(htmlentities($row['jam_penanganan']));
            // $array[$i]['catatan'] = addslashes(htmlentities($row['catatan']));
            $array[$i]['confirm'] = addslashes(htmlentities($row['is_confirm']));

            $i++;
        }
        echo json_encode(array("status" => true, "pesan" => $array));
      } else {
        echo json_encode(array("status" => false, "pesan" => "Tidak ada data Kejadian"));
        die();
      }
?>