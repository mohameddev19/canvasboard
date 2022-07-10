<html>
    <head>
        <title></title>
        <meta charset="utf-8">
        <meta name="viewport" content="width=dvice-width" initial-scale=1;>
        <link rel="icon" href=""/>
        <style>
            body{
                display: flex;
                align-content: center;
                align-items: center;
                align-self: center;
                text-align: center;
                box-sizing: border-box;
                justify-content: center;
                justify-items: center;
                justify-self: center;
                margin: 0;
                background-color: #d1d1d1;
            }
            div{
                position: relative;
                width: 500px;
                height: 300px;
                background-color: #c3c3c3;
                animation-name: animate;
                animation-delay: 0;
                animation-duration: 1.5s;
                border-radius: 5px;
                box-shadow: 0px 0px 5px rgba(70, 101, 184, 0.4);
            }
            div font{
                position: relative;
                top: -15px;
                background-color: #d1d1d1;
                width: 35%;
                height: 25%;
                padding-left: 2.5%;
                padding-right: 2.5%;
                padding-top: 2.5%;
                padding-bottom: 2.5%;
                color: #4665b8;
            }
            font,input,a,button{
                margin-top: 5%;
                animation-name: animate2;
                animation-delay: 0;
                animation-duration: 1.5s;
                background-color: rgba(0,0,0,0);
                text-align: center;
                font-size: 25px;
                font-family: sans-serif;
            }
            a,a:active,a:visited{
                color: #111a2b;
            }
            div input{
                margin-top: 30%;
            }
            div button{
                transition-delay: .1s;
                transition-duration: .3s;
                width: 35%;
                background-color: #4665b8;
                cursor: pointer;
                border: none;
                outline: none;
            }
            div button:hover{
                transition-delay: .1s;
                transition-duration: .3s;
                width: 33%;
            }
            div button:active{
                transition-delay: .1s;
                transition-duration: .3s;
                width: 33%;
                color: #c3c3c3;
                border: solid 1px #000;
            }
            div input{
                margin-top: 5%;
                width: 75%;
                height: 15%;
                border: none;
                outline: none;
                border: solid 1px #4665b8;
            }
            div input:last-child{
                width: 40%;
            }
            #btn2{
                display: none;
                margin-left: 32.5%;
            }
            #btn3{
                display: none;
                margin-left: 32.5%;
            }
            #don{
                position: absolute;
                width: 100%;
                text-align: center;
                font-family: sans-serif;
                color: #4665b8;
                display: none;
            }
            #a{
                display: none;
                width: 50%;
                text-align: center;
                margin-left: 25%;
            }
            @keyframes animate{
                0%{
                    width: 60px;
                    height: 60px;
                }
                40%{
                    width: 60px;
                    height: 60px;
                }
                70%{
                    width: 60px;
                    height: 300px;
                }
                100%{
                    width: 500px;
                    height: 300px;
                }
            }
            @keyframes animate2{
                0%{
                    opacity: 0;
                }
                80%{
                    opacity: 0;
                }
                100%{
                    opacity: 1;
                }
            }
        </style>
    </head>
    <body>
        <div>
            <form action="" method="post">
                <h3 id="don">done</h3><br><br>
                <a id="a" href="index.php">go to chat</a>
                <input id="inp1" type="text" name="id" placeholder="id"><br>
                <input id="inp2" type="text" name="teacher" placeholder="name"><br>
                <button id="btn1" name="next">next</button>
                <button id="btn2" name="nextt">next</button>
                <button id="btn3" name="ok">ok</button>
            </form>
        </div>
    </body>
    <script src="script.js"></script>
    <?php
        if(isset($_POST['next'])) {
            $connect = mysqli_connect('localhost','root','','dbboard');
            $id = $_POST['id'];
            $teacher = $_POST['teacher'];
            $create = "CREATE TABLE users (id INT PRIMARY KEY,teacher TEXT,boardid TEXT);";
            $mysql = mysqli_query($connect,$create);
            echo "<script>window.btn2.style.display = 'block';window.btn1.style.display = 'none';</script>";
        }
        if(isset($_POST['nextt'])) {
            $con = mysqli_connect('localhost','root','','dbboard');
            $id = $_POST['id'];
            $teacher = $_POST['teacher'];
            $board = 'board'.$id;
            $create2 = "CREATE TABLE $board (id INT PRIMARY KEY,user TEXT,msg TEXT);";
            $createve = "CREATE EVENT `$board` ON SCHEDULE EVERY 1 SECOND STARTS '2021-06-03 16:08:07.000000' ENDS '2022-06-03 16:08:07.000000' ON COMPLETION NOT PRESERVE ENABLE DO DELETE FROM $board WHERE id!=0 AND msg=''";
            $mysql2 = mysqli_query($con,$create2);
            $mysqlve = mysqli_query($con,$createve);
            echo "<script>window.btn3.style.display = 'block';window.btn2.style.display = 'none';window.btn1.style.display = 'none';</script>";
        }
        if(isset($_POST['ok'])) {
            $conn = mysqli_connect('localhost','root','','dbboard');
            @$id = $_POST['id'];
            @$teacher = $_POST['teacher'];
            $board = 'board'.$id;
            $codmsg = "SELECT * FROM users";
            $r = mysqli_query($conn,$codmsg);
            $id1 = 0;
            while($row = mysqli_fetch_array($r)){
                $id1 = 1 + $row['id'];
            }
            $add = "INSERT INTO users VALUES ('$id1','$teacher','$id')";
            mysqli_query($conn,$add);
            $add2 = "INSERT INTO $board VALUES ('0','','')";
            mysqli_query($conn,$add2);
            echo "<script>window.a.style.display = 'block';window.don.style.display = 'block';window.inp1.style.display = 'none';window.inp2.style.display = 'none';window.btn3.style.display = 'none';window.btn2.style.display = 'none';window.btn1.style.display = 'none';</script>";
        }
    ?>
</html>