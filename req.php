<?php

use function PHPSTORM_META\type;

$conn = mysqli_connect('localhost','root','','dbboard');
    //$name = implode('name', $_POST);
    //print_r($_POST);
    //print_r($_GET);
    @$canvas = $_POST['board'];
    @$inpt = $_POST['inpt'];
    @$idp = $_POST['id'];
    @$suser = $_POST['user'];
    @$page = $_POST['page'];
    
    @$insert = "INSERT INTO $canvas VALUES ('$page','$suser','$inpt')";
    @$update = "UPDATE $canvas SET msg='$inpt',user='$suser' WHERE id='$page'";
    mysqli_query($conn,$insert);
    mysqli_query($conn,$update);

    @$dir = "upload/".$suser;
    @$upload_dir = $dir . '/';
    @mkdir($dir);
    $img = $inpt;
    $img = str_replace('data:image/png;base64,', '', $img);
    $img = str_replace(' ', '+', $img);
    $data = base64_decode($img);
    @$file = $upload_dir . $suser . $page . ".png";
    $success = file_put_contents($file, $data);