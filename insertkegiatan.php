<?php
require_once('connection.php'); 

$nama= $_POST['nama'];
$petugasid = (int)$_POST['petugasid'];
$jenisid = $_POST['jenisid'];
$pelaksana = $_POST['pelaksana'];
$tanggal = $_POST['tanggal'];
$perizinan = $_POST['perizinan'];
$forall = (int)$_POST['forall'];
$periode =0;
$cbkelas = explode(",",$_POST['cbkelas']);

$sql = "SELECT id,tahunajaran from periodeajaran where status=1";
$result = $c->query($sql);

if ($result->num_rows > 0) {
  while($row = $result->fetch_assoc()) {
    $periode = $row['id'];

  }
}

if($forall == 1)
{
    $sql = "INSERT INTO kegiatanuks (perizinan, nama, jeniskegiatan_id, pelaksana, tanggal_acara, petugasuks_id, for_all, periodeajaran_id) values (?,?,?,?,?,?,?,?)";
    $stmt = $c->prepare($sql);
    $stmt->bind_param("isissiii",$perizinan,$nama,$jenisid,$pelaksana,$tanggal,$petugasid,$forall, $periode);
    $stmt->execute();
}
else if($forall==0){
    foreach($cbkelas as $kelas){
        $sql = "INSERT INTO kegiatanuks (perizinan,nama, jeniskegiatan_id, pelaksana,tanggal_acara, petugasuks_id, for_all, kelasajaran_id, periodeajaran_id) values (?,?,?,?,?,?,?,?,?)";
      $stmt = $c->prepare($sql);
      $stmt->bind_param("isissiiii",$perizinan,$nama,$jenisid,$pelaksana,$tanggal,$petugasid, $forall,$kelas,$periode);
      $stmt->execute();
    }
}


if ($stmt->affected_rows > 0) {
  $arr_hasil = array("status"=>true,
"pesan"=> 'Berhasil menambah kegiatan UKS');
} else {
   $arr_hasil = array("status"=>false, 
"pesan"=>'Gagal menambah kegiatan UKS');
}
echo json_encode($arr_hasil);
?>