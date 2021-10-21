<?php
  require_once('connection.php'); 
    
    $id = $_POST['petugasid'];
    $sql = "SELECT * from petugasuks where id = ? ";
    $stmt = $c->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $array = array();
        $i = 0;
        while ($row = $result->fetch_assoc()) {
            $array[$i]['petugasid'] = addslashes(htmlentities($row['id']));
            $array[$i]['nama'] = addslashes(htmlentities($row['nama']));
            $array[$i]['alamat'] = addslashes(htmlentities($row['alamat']));
            $array[$i]['telp'] = addslashes(htmlentities($row['no_hp']));
            $i++;
        }
        echo json_encode(array("status" => true, "pesan" => $array));
      } else {
        echo json_encode(array("status" => false, "pesan" => "Tidak ada detail petugas"));
        die();
      }
?>