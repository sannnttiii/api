<?php
  require_once('connection.php'); 
    
    $id = $_POST['kejadianid'];
    $sql = "SELECT d.*,l.kejadian, l.tanggal from detailkejadian d inner join laporankejadian l on l.id = d.kejadian_id where d.kejadian_id = ? 
    ORDER BY jam_penanganan DESC";
    $stmt = $c->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $array = array();
        $i = 0;
        while ($row = $result->fetch_assoc()) {
            $array[$i]['idkejadian'] = addslashes(htmlentities($row['kejadian_id']));
            $array[$i]['penanganan'] = addslashes(htmlentities($row['jenis_penanganan']));
            $array[$i]['jam'] = addslashes(htmlentities($row['jam_penanganan']));
            $array[$i]['ditangani'] = addslashes(htmlentities($row['ditangani_oleh']));
            $array[$i]['catatan'] = addslashes(htmlentities($row['catatan']));
            $array[$i]['kejadian'] = addslashes(htmlentities($row['kejadian']));
            $array[$i]['tanggal'] = addslashes(htmlentities($row['tanggal']));
            $array[$i]['gambar'] = addslashes(htmlentities($row['gambar']));

            $i++;
        }
        echo json_encode(array("status" => true, "pesan" => $array));
      } else {
        echo json_encode(array("status" => false, "pesan" => "Tidak ada detail kejadian"));
        die();
      }
?>