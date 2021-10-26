<?php
  require_once('connection.php'); 

    $sql = "SELECT a . * , s.nama, o.user_token, o.token_device as device, b.jumlah
    FROM (
    SELECT c . *
    FROM chat c
    INNER JOIN petugasuks p ON c.petugasuks_id = p.id
    WHERE p.status =1
    GROUP BY orangtua_id, waktu
    ORDER BY waktu DESC
    ) AS a
    INNER JOIN siswa s ON a.orangtua_id = s.orangtua_id 
    INNER JOIN orangtua o on o.id =s.orangtua_id
    LEFT JOIN (
    SELECT orangtua_id, count( pesan ) AS jumlah
    FROM chat
    WHERE petugasuks_id =1
    AND pengirim =0
    AND is_read =0
    GROUP BY orangtua_id
    ) AS b 
    ON o.id = b.orangtua_id
    GROUP BY a.orangtua_id";
    $stmt = $c->prepare($sql);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $array = array();
        $i = 0;
        while ($row = $result->fetch_assoc()) {
            $array[$i]['ortuid'] = addslashes(htmlentities($row['Orangtua_id']));
            $array[$i]['petugasid'] = addslashes(htmlentities($row['PetugasUks_id']));
            $array[$i]['pesan'] = addslashes(htmlentities($row['pesan']));
            $array[$i]['waktu'] = addslashes(htmlentities($row['waktu']));
            $array[$i]['namasiswa'] = addslashes(htmlentities($row['nama']));
            $array[$i]['usertoken'] = addslashes(htmlentities($row['user_token']));
            $array[$i]['tokendevice'] = addslashes(htmlentities($row['device']));
            $array[$i]['jumlah'] = addslashes(htmlentities($row['jumlah']));
            $i++;
        }
        echo json_encode($array);
      } else {
      echo json_encode ("Unable to process you request, please try again");
        die();
      }
?>