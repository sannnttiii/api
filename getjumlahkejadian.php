 <?php
  require_once('connection.php'); 
    
    // $id = $_POST['ortuid'];
    // $sql = "SELECT count(*) as jumlah FROM laporankejadian WHERE siswa_id in 
    // // (select s.id from orangtua o inner join siswa s on o.id = s.orangtua_id where o.id =? ) 
    // and is_confirm = 0";
    $id = $_POST['siswaid'];
    $sql = "SELECT count(*) as jumlah FROM laporankejadian WHERE siswa_id =?  
    and is_confirm = 0";
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
        echo json_encode(array("status" => false, "pesan" => "Tidak ada data laporan pemeriksaan"));
        die();
      }

?>