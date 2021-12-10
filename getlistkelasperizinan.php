<?php
  require_once('connection.php'); 
  $id = $_POST['kegiatanid'];
  $namakegiatan ='';
  $tanggal = '';
  $izin;
  $all;

  $sql = "SELECT * from kegiatanuks where id='$id'";
  $result = $c->query($sql);
  
  if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
      $namakegiatan = $row['nama'];
      $tanggal = $row['tanggal_acara'];
      $izin = $row['perizinan'];
      $all = $row['for_all'];
    }
  }

  if($izin == 1 && $all ==1)
  {
    $sql = "SELECT ka.kelas, ka.id
    FROM kelassiswa ks
    INNER JOIN kelasajaran ka ON ks.kelasAjaran_id = ka.id WHERE ks.status = 1 GROUP BY ka.kelas";
    $stmt = $c->prepare($sql);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $array = array();
        $i = 0;
        while ($row = $result->fetch_assoc()) {
            $array[$i]['kelas'] = addslashes(htmlentities($row['kelas']));
            $array[$i]['id'] = addslashes(htmlentities($row['id']));

            $i++;
        }
        echo json_encode($array);
      } else {
      echo json_encode ("Unable to process you request, please try again");
        die();
      }
  }
  else  if($izin == 1 && $all ==0)
  {
    $sql = "SELECT ka.kelas, ka.id
    FROM kelassiswa ks
    INNER JOIN kelasajaran ka ON ks.kelasAjaran_id = ka.id WHERE ks.status = 1 and ka.id IN (SELECT kelasajaran_id
    FROM kegiatanuks
    WHERE nama = '$namakegiatan'
    AND tanggal_acara = '$tanggal') GROUP BY ka.kelas";
    $stmt = $c->prepare($sql);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $array = array();
        $i = 0;
        while ($row = $result->fetch_assoc()) {
            $array[$i]['kelas'] = addslashes(htmlentities($row['kelas']));
            $array[$i]['id'] = addslashes(htmlentities($row['id']));

            $i++;
        }
        echo json_encode($array);
      } else {
      echo json_encode ("Unable to process you request, please try again");
        die();
      }
  }
    
?>