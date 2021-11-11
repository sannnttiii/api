<?php
require_once('connection.php'); 

$kejadianid = (int)$_POST['kejadianid'];
$catatan = $_POST['catatan'];

if(!isset($_POST['tanggal']))
{
  $sql = "INSERT INTO detailkejadian (kejadian_id, catatan) values (?,?)";
$stmt = $c->prepare($sql);
$stmt->bind_param("is",$kejadianid,$catatan);
$stmt->execute();

if ($stmt->affected_rows > 0) {
  $arr_hasil = array("status"=>true,
"pesan"=> 'Berhasil menambah Detail Kejadian');
} else {
   $arr_hasil = array("status"=>false, 
"pesan"=>'Gagal menambah Detail Kejadian');
}
echo json_encode($arr_hasil);
}
else{
  $gambar = $_POST['image'];
  $jenispenanganan = $_POST['penanganan'];
$ditangani = $_POST['ditangani'];
$jam = $_POST['tanggal'];

$array = explode('.', $_FILES['image']['name']);
$tmp_name = $_FILES['image']['tmp_name'];
$ext = end($array);
$url=$_FILES['image']['name'];
$uploadPath = "./images/".$url;
move_uploaded_file($tmp_name, $uploadPath);

$sql = "INSERT INTO detailkejadian (kejadian_id, jenis_penanganan, jam_penanganan, ditangani_oleh, catatan, gambar) values (?,?,?,?,?,?)";
$stmt = $c->prepare($sql);
$stmt->bind_param("isssss",$kejadianid,$jenispenanganan,$jam,$ditangani,$catatan,$url);
$stmt->execute();

if ($stmt->affected_rows > 0) {
  $arr_hasil = array("status"=>true,
"pesan"=> 'Berhasil menambah Detail Kejadian');
} else {
   $arr_hasil = array("status"=>false, 
"pesan"=>'Gagal menambah Detail Kejadian');
}
echo json_encode($arr_hasil);
}

?>