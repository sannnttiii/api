<?php
require_once('connection.php'); 
$email = $_POST['email'];
$password = $_POST['password'];
$sql = "select * from petugasuks where email=? and password=?";
$stmt = $c->prepare($sql);
$stmt->bind_param("ss", $email,$password);
$stmt->execute();
$result = $stmt->get_result();


$array = array();

if ($result->num_rows > 0) {		
        while ($row = $result -> fetch_assoc()) 
        {
            $array[$i]['id'] = addslashes(htmlentities($row['id']));
            $array[$i]['email'] = addslashes(htmlentities($row['email']));
            $array[$i]['password'] = addslashes(htmlentities($row['password']));
            $array[$i]['nama'] = addslashes(htmlentities($row['nama']));
            $array[$i]['usertoken'] = addslashes(htmlentities($row['user_token']));
            $array[$i]['tokendevice'] = addslashes(htmlentities($row['token_device']));
            $array[$i]['status'] = addslashes(htmlentities($row['status']));
        }
        if($array[$i]['status']==1)
        {
            echo json_encode(array('result' => 'OK', 'data' => $array[$i]['id'], 'role'=>'petugas', 'email'=>$array[$i]['email'], 'pass'=>$array[$i]['password']));

        }
        else
        {
            echo json_encode(array('result'=> 'ERROR', 'message' => 'Akun anda tidak aktif'));
        }
       
        // echo json_encode($array);
} 
else 
{
    $sql = "select * from orangtua where email=? and password=?";
    $stmt = $c->prepare($sql);
    $stmt->bind_param("ss", $email,$password);
    $stmt->execute();
    $result = $stmt->get_result();

    $array = array();
    if ($result->num_rows > 0) {		
        while ( $row = $result -> fetch_assoc()) 
        {
            $array[$i]['id'] = addslashes(htmlentities($row['id']));
            $array[$i]['email'] = addslashes(htmlentities($row['email']));
            $array[$i]['password'] = addslashes(htmlentities($row['password']));
            $array[$i]['nama'] = addslashes(htmlentities($row['nama_ayah']));
            $array[$i]['usertoken'] = addslashes(htmlentities($row['user_token']));
            $array[$i]['tokendevice'] = addslashes(htmlentities($row['token_device']));
        }
        echo json_encode(array('result' => 'OK', 'data' => $array[$i]['id'], 'role'=>'ortu', 'email'=>$array[$i]['email'], 'pass'=>$array[$i]['password']));
        // echo json_encode($array);
    } 
    else 
    {
        echo json_encode(array('result'=> 'ERROR', 'message' => 'Gagal!Email dan password tidak sesuai.'));
    die();
    }
}

   


?>