<?php
  require_once('connection.php'); 
  $id = $_POST['ortuid'];
 $siswaid=0;

  $sql = "SELECT id from siswa where orangtua_id = '$id'";
  $result = $c->query($sql);
  
  if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
      $siswaid = $row['id'];
    }
  }
    $sql = "SELECT *
    FROM laporankejadian
    WHERE siswa_id IN ($siswaid)
    ORDER BY tanggal DESC
    LIMIT 1";
    $stmt = $c->prepare($sql);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $array = array();
        $i = 0;
        while ($row = $result->fetch_assoc()) {
            $array[$i]['id'] = addslashes(htmlentities($row['id']));
            $array[$i]['kejadian'] = addslashes(htmlentities($row['kejadian']));
            $array[$i]['tanggal'] = addslashes(htmlentities($row['tanggal']));

            $i++;
        }
        echo json_encode(array("status" => true, "pesan" => $array));
      } else {
        echo json_encode(array("status" => false, "pesan" => "Tidak ada last kejadian"));
        die();
    }
?>