<?php
require_once('connection.php'); 

$kejadianid = (int)$_POST['kejadianid'];
$catatan = $_POST['catatan'];

//untuk panggilan
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
//untuk add berita
else{
  $gambar = $_POST['image'];
  $foto = $_POST['foto'];
  $jenispenanganan = $_POST['penanganan'];
$ditangani = $_POST['ditangani'];
$jam = $_POST['tanggal'];

if(isset($foto))
{
  $sql = "INSERT INTO detailkejadian (kejadian_id, jenis_penanganan, jam_penanganan, ditangani_oleh, catatan) values (?,?,?,?,?)";
  $stmt = $c->prepare($sql);
  $stmt->bind_param("issss",$kejadianid,$jenispenanganan,$jam,$ditangani,$catatan);
  $stmt->execute();

  $lastid = $stmt->insert_id;
  $format = $lastid.'.jpg';
  if($stmt->affected_rows) {
    $url=$lastid.".jpg";
    $img = str_replace('data:image/jpeg;base64,', '',$foto);
    $img = str_replace(' ', '+', $img);
    $data = base64_decode($img);
    file_put_contents('images/'.$lastid.'.jpg', $data);

    $sql = "UPDATE detailkejadian set gambar=? where id = ?";
  $stmt = $c->prepare($sql);
  $stmt->bind_param("si",$format,$lastid);
  $stmt->execute();
  } 
}
else{
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
}


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