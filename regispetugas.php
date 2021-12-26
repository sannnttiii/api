<?php
require_once('connection.php'); 

$nama = $_POST['petugas'];
$email = $_POST['email2'];
$pass = $_POST['pass2'];
$hp = $_POST['hp'];
$alamat= $_POST['alamat2'];
$usertoken = $_POST['usertoken'];

$sql = "INSERT INTO petugasuks ( email, password, user_token, nama, alamat, no_hp)  VALUES (?,?,?,?,?,?) ";
$stmt = $c->prepare ($sql);
$stmt->bind_param("ssssss",$email, $pass, $usertoken, $nama,$alamat, $hp);
$stmt->execute();

if ($stmt->affected_rows > 0) {
  $arr_hasil = array("status"=>true,
"pesan"=> 'Berhasil Regis Petugas');
} else {
   $arr_hasil = array("status"=>false, 
"pesan"=>'Gagal Regis Petugas');
}
echo json_encode($arr_hasil);
?>