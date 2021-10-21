<?php
  require_once('connection.php'); 

  $id = $_POST['siswaid'];
    $sql = "SELECT p.tahunAjaran, p.id
    FROM kelassiswa ks
    INNER JOIN periodeajaran p ON ks.periodeAjaran_id = p.id
    WHERE ks.siswa_id = ?";
    $stmt = $c->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $array = array();
        $i = 0;
        while ($row = $result->fetch_assoc()) {
          $array[$i]['id'] = addslashes(htmlentities($row['id']));
            $array[$i]['periode'] = addslashes(htmlentities($row['tahunAjaran']));
            $i++;
        }
        echo json_encode($array);
      } else {
      echo json_encode ("Unable to process you request, please try again");
        die();
      }
?>