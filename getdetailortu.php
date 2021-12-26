<?php
  require_once('connection.php'); 
    
    $id = $_POST['ortuid'];
    $sql = "SELECT * from orangtua where id = ? ";
    $stmt = $c->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $array = array();
        $i = 0;
        while ($row = $result->fetch_assoc()) {
            $array[$i]['idortu'] = addslashes(htmlentities($row['id']));
            $array[$i]['namaayah'] = addslashes(htmlentities($row['nama_ayah']));
            $array[$i]['namaibu'] = addslashes(htmlentities($row['nama_ibu']));
            $array[$i]['alamatayah'] = addslashes(htmlentities($row['alamat']));
            // $array[$i]['alamatibu'] = addslashes(htmlentities($row['alamat_ibu']));
            $array[$i]['noayah'] = addslashes(htmlentities($row['nohp_ayah']));
            $array[$i]['noibu'] = addslashes(htmlentities($row['nohp_ibu']));
            $array[$i]['token'] = addslashes(htmlentities($row['user_token']));
            $i++;
        }
        echo json_encode(array("status" => true, "pesan" => $array));
      } else {
        echo json_encode(array("status" => false, "pesan" => "Tidak ada detail orang tua"));
        die();
      }
?>