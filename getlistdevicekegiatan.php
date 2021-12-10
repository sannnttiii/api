<?php
require_once('connection.php'); 

$forall = $_POST['forall'];

if($forall == 1)
{
    $sql = "select token_device from orangtua o inner join siswa s on o.id = s.orangtua_id inner join kelassiswa k on k.siswa_id = s.id where k.status = 1";
    $stmt = $c->prepare($sql);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $array = array();
        $i = 0;
        while ($row = $result->fetch_assoc()) {
            $array[$i]['tokendevice'] = addslashes(htmlentities($row['token_device']));
            $i++;
        }
        echo json_encode(array("status" => true, "pesan" => $array));
     } else {
        echo json_encode(array("status" => false, "pesan" => "Tidak ada list device"));
        die();
  }
}
else{
$cbkelas = explode(",",$_POST['cbkelas']);
    $array = array();
    foreach($cbkelas as $kelas){
        $sql = "select token_device from orangtua o inner join siswa s on o.id = s.orangtua_id inner join kelassiswa k on k.siswa_id = s.id where kelasajaran_id = '$kelas' and status = 1";
   
        $stmt = $c->prepare($sql);
        $stmt->execute();
        $result = $stmt->get_result();
    
        if ($result->num_rows > 0) {
            $i = 0;
            while ($row = $result->fetch_assoc()) {
                $array[$i]['tokendevice'] = addslashes(htmlentities($row['token_device']));
        
                $i++;
            }
            echo json_encode(array("status" => true, "pesan" => $array));
        } else {
            echo json_encode(array("status" => false, "pesan" => "Tidak ada list device"));
            die();
        }
    }
    
}


?>