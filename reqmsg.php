<?php
    header('Content-Type: application/json');
    $conn = mysqli_connect('localhost','root','','dbboard');
    $sms = gettext($_GET['sms']);
    $codmsg = "SELECT * FROM $sms";
    $r = mysqli_query($conn,$codmsg);
    $id1 = array();
    $msg1 = array();
    $user1 = array();
    $nn = 0;
    while($row = mysqli_fetch_array($r)){
        $id1[$nn] = $row['id'];
        $user1[$nn] = $row['user'];
        $msg1[$nn] = $row['msg'];
        $nn++;
    }
    $data = array($msg1,$user1,$id1);
    $sender = $user1;
    echo json_encode($data);
?>