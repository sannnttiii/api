<?php
  require_once('connection.php'); 
    
    $id = $_POST['ortuid'];
    // $id = $_POST['siswaid'];
    // $sql = "SELECT count( * ) as jumlah
    // FROM siswa s
    // INNER JOIN kelassiswa ks ON ks.siswa_id = s.id
    // RIGHT JOIN (
    // SELECT k. *
    // FROM Kegiatanuks k
    // WHERE NOT
    // EXISTS (
    // SELECT *
    // FROM perizinan p
    // WHERE p.kegiatanuks_id = k.id
    // ))d 
    // ON ks.kelasajaran_id = d.kelasajaran_id
    // WHERE ks.status =1 AND d.perizinan =1 
    // AND ks.kelasAjaran_id
    //     IN ( SELECT ks.kelasAjaran_id
    //     FROM siswa s
    //     INNER JOIN orangtua o ON o.id = s.orangtua_id
    //     INNER JOIN kelassiswa ks ON s.id = ks.siswa_id
    //     WHERE o.id =?
    //     AND ks.status =1) ";

    $sql = "SELECT count(*) as jumlah
    FROM kegiatanuks k
    INNER JOIN periodeajaran pa ON pa.id = k.periodeajaran_id
    WHERE k.tanggal_acara >= now()  AND k.perizinan =1
    AND k.kelasajaran_id in (select ks.kelasajaran_id from siswa s 
    inner join kelassiswa ks on ks.siswa_id = s.id 
    where ks.status = 1 and s.id in (select s.id from siswa s inner join orangtua o on o.id = s.orangtua_id where o.id = ?))  
    AND pa.status =1
    AND NOT
    EXISTS (
    SELECT *
    FROM perizinan p
    INNER JOIN siswa s ON s.id = p.siswa_id
    WHERE k.id = p.kegiatanuks_id
    AND s.id in (select s.id from siswa s inner join orangtua o on o.id = s.orangtua_id where o.id = ?)
    GROUP BY s.id
    )";

    $stmt = $c->prepare($sql);
    $stmt->bind_param("ii", $id, $id);
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