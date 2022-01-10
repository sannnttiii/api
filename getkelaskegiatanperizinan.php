<?php
  require_once('connection.php'); 

  $id = $_POST['kegiatanid'];
  $nama='';
  $tanggal='';
  $sql = "SELECT nama, tanggal_acara from kegiatanuks where id = '$id'";
  $result = $c->query($sql);

  if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
      $nama = $row['nama'];
      $tanggal = $row['tanggal_acara'];
    }
  }


    $sql = "SELECT k.id, k.nama, k.pelaksana, k.for_all, ka.kelas as kelas, p.tahunajaran,CASE WHEN k.tanggal_acara <= CURDATE( )
    THEN 1
    ELSE 0
    END AS selesai
    FROM kegiatanuks k inner join periodeajaran p on k.periodeajaran_id = p.id
    LEFT JOIN kelasajaran ka 
    ON k.kelasajaran_id = ka.id where k.nama = '$nama' and k.tanggal_acara = '$tanggal'";
    $stmt = $c->prepare($sql);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $array = array();
        $i = 0;
        while ($row = $result->fetch_assoc()) {
            $array[$i]['nama'] = addslashes(htmlentities($row['nama']));
            $array[$i]['kelas'] = addslashes(htmlentities($row['kelas']));
            $array[$i]['forall'] = addslashes(htmlentities($row['for_all']));
            $array[$i]['periode'] = addslashes(htmlentities($row['tahunajaran']));
            $array[$i]['selesai'] = addslashes(htmlentities($row['selesai']));

            $i++;
        }
        echo json_encode(array("status" => true, "pesan" => $array));
      } else {
        echo json_encode(array("status" => false, "pesan" => "Tidak ada data kegiatan yang perlu perizinan"));
        die();
      }
?>