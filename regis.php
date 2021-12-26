<?php
require_once('connection.php'); 

$ibu = $_POST['ibu'];
$ayah = $_POST['ayah'];
$email = $_POST['email'];
$pass = $_POST['pass'];
$hpa= $_POST['hpayah'];
$hpi = $_POST['hpibu'];
$alamat= $_POST['alamat'];
$usertoken = $_POST['usertoken'];

$sql = "INSERT INTO orangtua ( email, password, user_token, nama_ayah, alamat, nohp_ayah, nama_ibu, nohp_ibu)  VALUES (?,?,?,?,?,?,?,?) ";
$stmt = $c->prepare ($sql);
$stmt->bind_param("ssssssss",$email, $pass, $usertoken, $ayah,$alamat, $hpa, $ibu, $hpi);
$stmt->execute();

if ($stmt->affected_rows > 0) {
  $arr_hasil = array("status"=>true,
"pesan"=> 'Berhasil Regis Ortu');
} else {
   $arr_hasil = array("status"=>false, 
"pesan"=>'Gagal Regis Ortu');
}
echo json_encode($arr_hasil);
?>