<?php
require_once('connection.php'); 
$email = $_POST['email'];
$uid = $_POST['uid'];
$role = $_POST['role'];
if($role=='petugas')
{
    $sql = "UPDATE petugasuks set user_token ='$uid' where email='$email'";
    $stmt = $c->prepare($sql);
    $stmt->execute();
}
else if($role=='ortu')
{
    $sql = "UPDATE orangtua set user_token ='$uid' where email='$email'";
    $stmt = $c->prepare($sql);
    $stmt->execute();
}
else{
    $arr_hasil = array("status"=>false,
"pesan"=> 'NO role');
}


if ($c->query($sql) === TRUE) {
    $arr_hasil = array("status"=>true,
"pesan"=> 'Berhasil Update UID');
  } else {
    $arr_hasil = array("status"=>false, 
"pesan"=>'Gagal Update UID');
  }
  
echo json_encode($arr_hasil);
// $stmt->close();  
// $c->close();  


?>