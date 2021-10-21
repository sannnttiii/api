<?php
  require_once('connection.php'); 
    
    $id = $_POST['infoid'];
    $judul ='';
    $ket = '';
    $sql = "SELECT judul,keterangan from informasi where id = '$id'";
    $result = $c->query($sql);

    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            $judul = $row['judul'];
            $ket = $row['keterangan'];
        }
    }

    $sql = "delete from informasi where judul = '$judul' and keterangan ='$ket' ";
    $result = $c->query($sql);

    if ($c->query($sql)==TRUE) {
        echo json_encode(array("status" => true, "pesan" => "Berhasil menghapus informasi"));
      } else {
        echo json_encode(array("status" => false, "pesan" => "Gagal menghapus informasi"));
        die();
      }
?>