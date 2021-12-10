<?php
require_once('connection.php'); 

$periode=0;
$sql = "SELECT id,tahunajaran from periodeajaran where status=1";
$result = $c->query($sql);

if ($result->num_rows > 0) {
  while($row = $result->fetch_assoc()) {
    $periode = $row['id'];

  }
}

$sql = "SELECT s.*,k.kelasajaran_id as kelasid, o.user_token as token, o.token_device as device from laporankejadian l inner join siswa s on l.siswa_id = s.id inner join kelassiswa k on k.siswa_id = s.id inner join orangtua o on o.id =s.orangtua_id where l.is_confirm = 0 and k.status = 1 and l.periodeajaran_id = '$periode' group by s.id";
$stmt = $c->prepare($sql);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $array = array();
    $arraydevice=array();
    $i = 0;
    while ($row = $result->fetch_assoc()) {
        $array[$i]['id'] = addslashes(htmlentities($row['id']));
        $array[$i]['nama'] = addslashes(htmlentities($row['nama']));
        $array[$i]['kelasid'] = addslashes(htmlentities($row['kelasid']));
        $array[$i]['ortutoken'] = addslashes(htmlentities($row['token']));
        $array[$i]['tokendevice'] = addslashes(htmlentities($row['device']));
        $arraydevice[$i]['tokendevice'] = addslashes(htmlentities($row['device']));
        $array[$i]['ortuid'] = addslashes(htmlentities($row['Orangtua_id']));

        $i++;
    }
    echo json_encode(array("status" => true, "pesan" => $array,"device"=>$arraydevice));
  } else {
    echo json_encode(array("status" => false, "pesan" => "Tidak ada yang Belum Acc Laporan Kejadian"));
    die();
  }


?>