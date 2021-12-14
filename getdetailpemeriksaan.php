<?php
  require_once('connection.php'); 
    
    $id = $_POST['id'];
    $sql = "SELECT l.*, k.id as idkegiatan, k.nama as nama from laporanpemeriksaan l inner join kegiatanuks k on l.kegiatanuks_id = k.id where l.id = ? ";
    $stmt = $c->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $array = array();
        $i = 0;
        while ($row = $result->fetch_assoc()) {
            $array[$i]['id'] = addslashes(htmlentities($row['id']));
            $array[$i]['tinggi'] = addslashes(htmlentities($row['tinggi_badan']));
            $array[$i]['berat'] = addslashes(htmlentities($row['berat_badan']));
            $array[$i]['hasil'] = addslashes(htmlentities($row['hasil']));
            $array[$i]['catatan'] = addslashes(htmlentities($row['catatan']));
            $array[$i]['kegiatan'] = addslashes(htmlentities($row['nama']));
            $array[$i]['idkegiatan'] = addslashes(htmlentities($row['idkegiatan']));

            $i++;
        }
        echo json_encode(array("status" => true, "pesan" => $array));
      } else {
        echo json_encode(array("status" => false, "pesan" => "Tidak ada detail info"));
        die();
      }
?>