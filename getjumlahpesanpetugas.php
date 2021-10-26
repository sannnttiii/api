<?php
  require_once('connection.php'); 
    
    $id = $_POST['petugasid'];

    $sql = "SELECT count(*) as jumlah
    FROM chat where petugasuks_id = ? and pengirim = 0 and is_read = 0";

    $stmt = $c->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $array = array();
        $i = 0;
        while ($row = $result->fetch_assoc()) {
            $array[$i]['jumlah'] = addslashes(htmlentities($row['jumlah']));
            $i++;
        }
        echo json_encode(array("status" => true, "pesan" => $array));
      } else {
        echo json_encode(array("status" => false, "pesan" => "Gagal"));
        die();
      }
?>