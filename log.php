<?php
        session_start();
        if (isset($_POST['login'])) 
        {
            function validate($data){
                $data = trim($data);
                $data = stripslashes($data);
                $data = htmlspecialchars($data);
                return $data;
            }
            $id = validate($_POST['id']);
            $user = validate($_POST['user']);
            $con = mysqli_connect('localhost','root','','dbboard');
            $mysql = "select * from users where boardid='$id'";
            $result = mysqli_query($con,$mysql);
             if(mysqli_num_rows($result) === 1){
                $row = mysqli_fetch_assoc($result);
                if($row['boardid'] === $id){
                    $_SESSION['id']= $id;
                    $_SESSION['user']= $user;
                    if($row['teacher'] === $user){
                        header('location:home.php');
                    }
                    else{
                        header('location:class.php');
                    }
                }
                else{
                    header('location:index.php?error=name or pass is required');
                }
            }
            else{
                header('location:index.php?error=id is required');
            }
        }
?>
<h1>name or password is required<h1>