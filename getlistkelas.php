<?php
  require_once('connection.php'); 

    $sql = "SELECT ka.kelas, ka.id
    FROM kelassiswa ks
    INNER JOIN kelasajaran ka ON ks.kelasAjaran_id = ka.id WHERE ks.status = 1 GROUP BY ka.kelas";
    $stmt = $c->prepare($sql);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $array = array();
        $i = 0;
        while ($row = $result->fetch_assoc()) {
            $array[$i]['kelas'] = addslashes(htmlentities($row['kelas']));
            $array[$i]['id'] = addslashes(htmlentities($row['id']));

            $i++;
        }
        echo json_encode($array);
      } else {
      echo json_encode ("Unable to process you request, please try again");
        die();
      }
?>