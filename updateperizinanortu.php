<?php
require_once('connection.php'); 
    
$ortuid = (int)$_POST['ortuid'];
$siswaid = (int)$_POST['siswaid'];
$kegiatanid = (int)$_POST['kegiatanid'];
$kelasajaranid = (int)$_POST['kelasajaranid'];
$periodeajaranid = (int)$_POST['periodeajaranid'];
$tidakacc='Tidak';


if(isset($_POST['image']))
{
    $image = $_POST['image'];
}
$alasan = $_POST['alasan'];

$array = explode('.', $_FILES['image']['name']);
$tmp_name = $_FILES['image']['tmp_name'];
$ext = end($array);

$sql = "INSERT INTO perizinan (status, alasan, orangtua_id, kegiatanuks_id, siswa_id, kelasajaran_id, periodeajaran_id)  VALUES (?,?,?,?,?,?,?)";
$stmt = $c->prepare ($sql);
$stmt->bind_param("ssiiiii", $tidakacc, $alasan, $ortuid, $kegiatanid, $siswaid, $kelasajaranid, $periodeajaranid);
$stmt->execute();
$lastid = $stmt->insert_id;

if(isset($_POST['image']))
{
$url=$lastid.'.'.$ext;
$uploadPath = "./images/".$url;
move_uploaded_file($tmp_name, $uploadPath);
$sql1 = "UPDATE perizinan set foto_bukti ='$url' WHERE id='$lastid' ";
$stmt = $c->prepare ($sql1);
$stmt->execute();
}
if($stmt->affected_rows>0) {
    $arr_hasil = array("status"=>true,
    "pesan"=> "Berhasil Konfirmasi Perizinan");
} else {
    $arr_hasil = array("status"=>false, 
    "pesan"=>'Gagal konfirmasi perizinan');
}
echo json_encode($arr_hasil);

?>