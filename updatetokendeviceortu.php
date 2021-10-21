<?php
require_once('connection.php'); 
    
$id = $_POST['ortuid'];
$tokendevice = $_POST['tokendevice'];

$sql = "UPDATE orangtua set token_device = '$tokendevice' WHERE id='$id'";
$stmt = $c->prepare ($sql);
$stmt->execute();
if($stmt->affected_rows) {
    $arr_hasil = array("status"=>true,
    "pesan"=> 'Berhasil update token device '+ $tokendevice);
} else {
    $arr_hasil = array("status"=>false, 
    "pesan"=>'Gagal Update token device '+$tokendevice);
}
echo json_encode($arr_hasil);

?>