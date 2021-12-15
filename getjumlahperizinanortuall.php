<?php
  require_once('connection.php'); 
    
    // $id = $_POST['ortuid'];

    // $sql = "SELECT count(*) as jumlah
    // FROM kegiatanuks k
    // INNER JOIN periodeajaran pa ON pa.id = k.periodeajaran_id
    // WHERE k.tanggal_acara >= now()
    // and k.perizinan =1
    // AND for_all =1
    // AND pa.status =1
    // AND NOT
    // EXISTS (
    
    // SELECT *
    // FROM perizinan p
    // INNER JOIN siswa s ON s.id = p.siswa_id
    // WHERE k.id = p.kegiatanuks_id
    // AND s.id in (select s.id from siswa s inner join orangtua o on o.id = s.orangtua_id where o.id = ?)
    // GROUP BY s.id
    // )";
    $id = $_POST['siswaid'];

    $sql = "SELECT count(*) as jumlah
    FROM kegiatanuks k
    INNER JOIN periodeajaran pa ON pa.id = k.periodeajaran_id
    WHERE k.tanggal_acara >= now()
    and k.perizinan =1
    AND for_all =1
    AND pa.status =1
    AND NOT
    EXISTS (
    
    SELECT *
    FROM perizinan p
    INNER JOIN siswa s ON s.id = p.siswa_id
    WHERE k.id = p.kegiatanuks_id
    AND s.id = ? 
    )";

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