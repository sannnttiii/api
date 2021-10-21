<?php
  require_once('connection.php'); 
    
    $id = $_POST['kegiatanid'];
    $nama ='';
    $tanggal = '';
    $sql = "SELECT nama,tanggal_acara from kegiatanuks where id = '$id'";
    $result = $c->query($sql);

    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            $nama = $row['nama'];
            $tanggal = $row['tanggal_acara'];
        }
    }

    $sql = "delete from kegiatanuks where nama = '$nama' and tanggal_acara ='$tanggal' ";
    $result = $c->query($sql);

    if ($c->query($sql)==TRUE) {
        echo json_encode(array("status" => true, "pesan" => "Berhasil menghapus kegiatan UKS"));
      } else {
        echo json_encode(array("status" => false, "pesan" => "Gagal menghapus kegiatan UKS"));
        die();
      }
?>