<?php
require_once('connection.php'); 
$keterangan = $_POST['keterangan'];
if($keterangan=='petugas')
{
    $id = $_POST['petugasid'];    
    $sql = "UPDATE petugasuks set token_device = 'undefined' WHERE id='$id' ";
    $stmt = $c->prepare ($sql);
    $stmt->execute();
    if($stmt->affected_rows) {
        $arr_hasil = array("status"=>true,
        "pesan"=> 'Berhasil update token device logout');
    } else {
        $arr_hasil = array("status"=>false, 
        "pesan"=>'Gagal Update token device logout ');
    }
    echo json_encode($arr_hasil);
}
else{
    $id = $_POST['ortuid'];    
    $sql = "UPDATE orangtua set token_device ='undefined' WHERE id='$id'";
    $stmt = $c->prepare ($sql);
    $stmt->execute();
    if($stmt->affected_rows) {
        $arr_hasil = array("status"=>true,
        "pesan"=> 'Berhasil update token device ');
    } else {
        $arr_hasil = array("status"=>false, 
        "pesan"=>'Gagal Update token device ');
    }
    echo json_encode($arr_hasil);
}


?>