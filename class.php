<?php
    session_start();
    if(!isset($_SESSION['id'])){
      header('location:index.php');
    }
    $conn = mysqli_connect('localhost','root','','dbboard');
    $id = $_SESSION['id'];
    $user = $_SESSION['user'];
    $board = 'board'.$id;
    $codmsg = "SELECT * FROM $board";
    $r = mysqli_query($conn,$codmsg);
    $id1;
    $user1;
    $msg1;
    while($row = mysqli_fetch_array($r)){
        $id1 = $row['id'];
        $user1 = $row['user'];
        $msg1 = $row['msg'];
    }
?>
<!DOCTYPE >
<html>
    <head>
        <meta charset='utf-8'>
        <title>home</title>
        <link rel="stylesheet" type="text/css" href="style.css" />
        <link rel="stylesheet" type="text/css" href="css/bootstrap.css" />
        <link rel='icon' href=''>
        <script>
            
        </script>
    </head>
    <body>
    <div id="top">
        <div id=""><img id="" src="img/wh.png"></div>
        <div id=""><img id="" src="img/user.png"></div>
        <div id=""><img id="" src="img/q.png"></div>
    </div>
    <div id="board" onmousedown="remove();">
        <canvas id="canvas"></canvas>
    </div>
    <select id="pages" SIZE="1" on onclick="save_page(this.value);" onchange="to_page(this.value);">
    </select>

    <script>
        /*--------- div const ---------*/
        const dtop = document.getElementById("top");
        const board = document.getElementById("board");
        const canvas = document.getElementById("canvas");
        const pages = document.getElementById("pages");
        if("<?php echo $user ?>"){

        }

        
        canvas.width = window.innerWidth;
        canvas.height = window.innerHeight - 160;
        
        let image  = new Image();
        let context = canvas.getContext("2d");
        let start_background_color = "white";

        let page = [];
        let page_num = [];

        let nn3 = 0;
        let n = 0;

        context.fillStyle = start_background_color;
        context.fillRect(0, 0, canvas.width, canvas.height);
        image.onload = function(){
            context.drawImage(image, 0, 0);
        }
        image.src = page_num[0];

        function to_page(l){
            n = l;
        }
        
        image.src = page_num[n];
        context.drawImage(image, 0, 0);

        function save_page(i){
            //page[i] = context.getImageData(0, 0, canvas.width, canvas.height);
        }

        function startliveupdate(){
                setInterval(function(){
                    fetch('reqmsg.php?sms=<?php echo($board) ?>').then(function (response){
                        return response.json();
                    }).then(function (data){
                        //console.log(data);
                        n2 = data[0].length;
                        let nn2 = 0;
                        id = data[2][nn2];
                        image.src = page_num[n];
                        context.drawImage(image, 0, 0);
                        //console.log(id);
                        user1 = data[1][nn2];
                        for(nn2; nn2 < n2; nn2++){
                            page_num[nn2] = data[0][nn2];
                        }
                        for(nn3; nn3 < n2; nn3++){
                            pages.innerHTML += "<option value="+nn3+" onclick=''> "+nn3+" </option>";
                        }
                        //lint.innerHTML = data;
                    }).catch(function (error){
                        console.log(error);
                    });
                }, 1000 / 30);
            }
            document.addEventListener('DOMContentLoaded',function (){
                startliveupdate();
            });
    </script>
    <script src="js/popper.min.js"></script>
    <script src="js/jquery-3.6.0.min.js"></script>
    <script src="js/bootstrap.js"></script>
</body>
</html>