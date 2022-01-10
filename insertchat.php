<?php
require_once('connection.php'); 

$ortuid = $_POST['ortuid'];
$petugasid = $_POST['petugasid'];
$msg = $_POST['msg'];
//kalau 1 petugasUKS, 0 ortu
$pengirim = $_POST['pengirim'];

$sql = "INSERT INTO chat ( petugasuks_id, orangtua_id, pesan,pengirim)  VALUES (?,?,?,?) ";
$stmt = $c->prepare ($sql);
$stmt->bind_param("iisi",$petugasid, $ortuid, $msg, $pengirim);
$stmt->execute();

if ($stmt->affected_rows > 0) {
  $arr_hasil = array("status"=>true,
"pesan"=> 'Berhasil');
} else {
   $arr_hasil = array("status"=>false, 
"pesan"=>'Gagal');
}
echo json_encode($arr_hasil);
?>