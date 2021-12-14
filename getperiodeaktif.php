<?php
  require_once('connection.php'); 

    $sql = "SELECT p.tahunAjaran, p.id
    FROM  periodeajaran p
    WHERE p.status = 1";
    $stmt = $c->prepare($sql);
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
        echo json_encode(array("status" => true, "pesan" => $array));
      } else {
        echo json_encode(array("status" => false, "pesan" => "Unable to process"));

        die();
      }
?>