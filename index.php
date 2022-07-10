<?php
    $con = mysqli_connect('localhost','root','','dbboard');
?>
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
                background-color: #ffffff;
                background-image: url(img/login.jpg)
            }
            div{
                width: 300px;
                height: 350px;
                background-color: rgba(255, 255, 255, 0.8);
                animation-name: animate;
                animation-delay: 0;
                animation-duration: 1.5s;
                border-radius: 15px;
                box-shadow: 0px 0px 25px rgba(0, 0, 0, 0.5);
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
            font,input,a,button,select,.error{
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
            option{
                background-color: #c3c3c3;
                color: #000;
            }
            option:hover{
                background-color: #4665b8;
            }
            div input{
                margin-top: 10%;
            }
            div button,div select{
                transition-delay: .1s;
                transition-duration: .3s;
                width: 35%;
                background-color: #4d76e5;
                cursor: pointer;
                border: none;
                outline: none;
                color: #ffffff;
                text-align: center;
                border-radius: 15px;
                box-shadow: 0px 0px 15px rgba(0, 0, 0, 0.6);
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
                margin-top: 10%;
                width: 75%;
                height: 15%;
                border: none;
                outline: none;
                border-bottom: solid 1px #4665b8;
            }
            div input:last-child{
                width: 40%;
            }
            #msg{
                display: none;
            }
            .error{
                margin-top: 2%;
                width: 74%;
                height: 15%;
                margin-left: 13%;
                border: none;
                outline: none;
                color: #b84646;
                text-align: center;
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
                    height: 350px;
                }
                100%{
                    width: 300px;
                    height: 350px;
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
            <form action="log.php" method="post">
                <h3 id="msg"></h3>
                <?php if(isset($_GET['error'])){ ?>
                <p class="error"><?php echo $_GET['error']; ?></p>
                <?php } ?>
                <input id="name" type="text" name="id" placeholder="board id">
                <input id="pass" type="text" name="user" placeholder="your name"><br>
                <button id="btn" name="login">ok</button><br>
                <a href="admin.php">creat chat id!</a>
            </form>
        </div>
    </body>
    <script src="script.js"></script>
</html>