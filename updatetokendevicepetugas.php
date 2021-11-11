<?php
require_once('connection.php'); 
    
$id = $_POST['petugasid'];
$tokendevice = $_POST['tokendevice'];

$sql = "UPDATE petugasuks set token_device = '$tokendevice' WHERE id='$id' ";
$stmt = $c->prepare ($sql);
// $stmt->bind_param("si", $tokendevice,$id);
$stmt->execute();
if($stmt->affected_rows) {
    $arr_hasil = array("status"=>true,
    "pesan"=> 'Berhasil update token device ');
} else {
    $arr_hasil = array("status"=>false, 
    "pesan"=>'Gagal Update token device ');
}
echo json_encode($arr_hasil);

?>