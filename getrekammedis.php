<?php
  require_once('connection.php'); 
    
    $id = $_POST['siswaid'];
    $period = $_POST['periodeid'];
    $sql = "SELECT id,tinggi_badan, berat_badan, hasil, catatan,tanggal,is_confirm
    FROM laporanpemeriksaan
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
            $array[$i]['tinggi'] = addslashes(htmlentities($row['tinggi_badan']));
            $array[$i]['tanggal'] = addslashes(htmlentities($row['tanggal']));
            $array[$i]['berat'] = addslashes(htmlentities($row['berat_badan']));
            $array[$i]['hasil'] = addslashes(htmlentities($row['hasil']));
            $array[$i]['catatan'] = addslashes(htmlentities($row['catatan']));
            $array[$i]['confirm'] = addslashes(htmlentities($row['is_confirm']));

            $i++;
        }
        echo json_encode(array("status" => true, "pesan" => $array));
      } else {
        echo json_encode(array("status" => false, "pesan" => "Unable to process you request, please try again"));
        die();
      }
?>