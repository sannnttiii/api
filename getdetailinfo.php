<?php
  require_once('connection.php'); 
    
    $id = $_POST['infoid'];
    $sql = "SELECT * from informasi where id = ? ";
    $stmt = $c->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $array = array();
        $i = 0;
        while ($row = $result->fetch_assoc()) {
            $array[$i]['id'] = addslashes(htmlentities($row['id']));
            $array[$i]['judul'] = addslashes(htmlentities($row['judul']));
            $array[$i]['keterangan'] = addslashes(htmlentities($row['keterangan']));
            $i++;
        }
        echo json_encode(array("status" => true, "pesan" => $array));
      } else {
        echo json_encode(array("status" => false, "pesan" => "Tidak ada detail info"));
        die();
      }
?>