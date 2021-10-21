<?php
require_once('connection.php'); 

$poster = $_POST['image'];
$judul = $_POST['judul'];
$keterangan = $_POST['keterangan'];
$id = (int)$_POST['infoid'];
$judulawal ='';
$ketawal='';

$array = explode('.', $_FILES['image']['name']);
$tmp_name = $_FILES['image']['tmp_name'];
$ext = end($array);
$url=$_FILES['image']['name'];
$uploadPath = "./images/".$url;
move_uploaded_file($tmp_name, $uploadPath);

$sql = "SELECT judul,keterangan from informasi where id = '$id'";
$result = $c->query($sql);

if ($result->num_rows > 0) {
  while($row = $result->fetch_assoc()) {
    $judulawal = $row['judul'];
    $ketawal = $row['keterangan'];
  }
}

$sql = "UPDATE informasi set judul = '$judul', keterangan ='$keterangan', poster = '$url' where judul='$judulawal' and keterangan = '$ketawal'";
$stmt = $c->prepare ($sql);
$stmt->execute();

if ($stmt->affected_rows > 0) {
  $arr_hasil = array("status"=>true,
"pesan"=> 'Berhasil mengubah informasi');
} else {
   $arr_hasil = array("status"=>false, 
"pesan"=>'Gagal mengubah informasi');
}
echo json_encode($arr_hasil);
?>