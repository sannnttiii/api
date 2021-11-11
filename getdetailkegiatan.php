<?php
  require_once('connection.php'); 
    $datenow =  date("Y-m-d H:i:s");
    $id = $_POST['id'];
    $sql = "SELECT k.*, j.id as jenisid, IF( tanggal_acara <= now( ) , 'done', 'undone' ) AS selesai from kegiatanuks k inner join jeniskegiatan  j on k.jeniskegiatan_id = j.id where k.id = ? ";
    $stmt = $c->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $array = array();
        $i = 0;
        while ($row = $result->fetch_assoc()) {
            $array[$i]['nama'] = addslashes(htmlentities($row['nama']));
            $array[$i]['tanggal'] = addslashes(htmlentities($row['tanggal_acara']));
            $array[$i]['pelaksana'] = addslashes(htmlentities($row['pelaksana']));
            $array[$i]['jenisid'] = addslashes(htmlentities($row['jenisid']));
            $array[$i]['selesai'] = addslashes(htmlentities($row['selesai']));
            $i++;
        }
        echo json_encode(array("status" => true, "pesan" => $array));
      } else {
        echo json_encode(array("status" => false, "pesan" => "Tidak ada detail kegiatan"));
        die();
      }
?>