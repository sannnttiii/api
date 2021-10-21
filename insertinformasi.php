<?php
require_once('connection.php'); 

$poster = $_POST['image'];
$petugasid = (int)$_POST['petugasid'];
$judul = $_POST['judul'];
$keterangan = $_POST['keterangan'];
$forall = (int)$_POST['forall'];
$periode =0;
$cbkelas = explode(",",$_POST['cbkelas']);

$array = explode('.', $_FILES['image']['name']);
$tmp_name = $_FILES['image']['tmp_name'];
$ext = end($array);
$url=$_FILES['image']['name'];
$uploadPath = "./images/".$url;
move_uploaded_file($tmp_name, $uploadPath);

$sql = "SELECT id,tahunajaran from periodeajaran where status=1";
$result = $c->query($sql);

if ($result->num_rows > 0) {
  while($row = $result->fetch_assoc()) {
    $periode = $row['id'];

  }
}

if($forall == 1)
{
    $sql = "INSERT INTO informasi (poster, judul, keterangan, petugasuks_id, for_all, periodeajaran_id) values (?,?,?,?,?,?)";
    $stmt = $c->prepare($sql);
    $stmt->bind_param("sssiii",$url,$judul,$keterangan,$petugasid,$forall, $periode);
    $stmt->execute();
}
else if($forall==0){
    foreach($cbkelas as $kelas){
        $sql = "INSERT INTO informasi (poster, judul, keterangan, petugasuks_id, for_all, kelasajaran_id, periodeajaran_id) values (?,?,?,?,?,?,?)";
      $stmt = $c->prepare($sql);
      $stmt->bind_param("sssiiii",$url,$judul,$keterangan,$petugasid,$forall,$kelas,$periode);
      $stmt->execute();
    }
}


if ($stmt->affected_rows > 0) {
  $arr_hasil = array("status"=>true,
"pesan"=> 'Berhasil menambah informasi');
} else {
   $arr_hasil = array("status"=>false, 
"pesan"=>'Gagal menambah informasi');
}
echo json_encode($arr_hasil);
?>