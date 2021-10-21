<?php
  require_once('connection.php'); 

    $sql = "SELECT *
        FROM petugasuks 
        where status=1";
    $stmt = $c->prepare($sql);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $array = array();
        $i = 0;
        while ($row = $result->fetch_assoc()) {
            $array[$i]['id'] = addslashes(htmlentities($row['id']));
            $array[$i]['nama'] = addslashes(htmlentities($row['nama']));
            $array[$i]['email'] = addslashes(htmlentities($row['email']));
            $array[$i]['telp'] = addslashes(htmlentities($row['no_hp']));
            $array[$i]['usertoken'] = addslashes(htmlentities($row['user_token']));
            $array[$i]['tokendevice'] = addslashes(htmlentities($row['token_device']));
            $i++;
        }
        echo json_encode($array);
      } else {
      echo json_encode ("Unable to process you request, please try again");
        die();
      }
?>