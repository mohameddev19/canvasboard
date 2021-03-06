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
    include("req.php");
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
            var id = 0;
            var page_num = 0;
            var pn = 0;
            var pnl = [];
            var user = "<?php echo ($user); ?>";
            var user1 = "";
            function ajaxpost(){
                // (A) GET FORM DATA
                id++;
                var board = "<?php echo ($board); ?>";
                var data = new FormData();
                data.append("inpt", document.getElementById("inpt").value);
                data.append("id", id);
                data.append("board", board);
                data.append("user", user);
                data.append("page", page_num);

                // (B) AJAX
                var xhr = new XMLHttpRequest();
                xhr.open("POST", "req.php");
                // What to do when server responds
                xhr.onload = function(){ 
                    //console.log(this.response); 
                };
                xhr.send(data);

                // (C) PREVENT HTML FORM SUBMIT
                return false;
            }
            var c = "";
            function codec(){
                console.log(c);
            }
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
    <div id="btm" onclick="draw_shape = false;">
        <div id=""><img onclick="lock();" id="cwrite" draggable="false" src="img/padlock.png"></div>
        <div id=""><img onclick="word = '';add_word();" id="write" draggable="false" src="img/pen.png"></div>
        <div id=""><img onclick="draw_color = 'black';is_write = false;" id="prash" draggable="false" src="img/paintbrush.png"></div>
        <div id=""><img onclick="range(this);" id="size" draggable="false" src="img/reduce.png"></div>
        <div id=""><img onclick="shape_btn(this);is_write = false;" id="shaps" draggable="false" src="img/shape.png"></div>
        <div id=""><img onclick="clear_fun(this);is_write = false;" id="crouser" draggable="false" src="img/eraser.png"></div>
        <div id=""><img onclick="is_write = false;" id="img" draggable="false" src="img/image.png"></div>
        <div id=""><img onclick="is_write = false;" id="box" draggable="false" src="img/writing.png"></div>
        <div id=""><img onclick="is_write = false;" id="time" draggable="false" src="img/temporary-offer.png"></div>
        <div id=""><img onclick="add_page();is_write = false;" id="zoomi" draggable="false" src="img/plus.png"></div>
        <div id=""><input onclick="colors();is_write = false;" id="color" type="color" oninput="draw_color = this.value;"></div>
        <div id=""><img onclick="undo_next();is_write = false;" id="forword" draggable="false" src="img/redo.png"></div>
        <div id=""><img onclick="undo_last();is_write = false;" id="backword" draggable="false" src="img/undo.png"></div>
    </div>
    <input id="clear_btn" type="button" value="clear" onclick="clear_canvas();remove();">
    <input id="range" type="range" min="1" max="100" value="3" oninput="draw_width = this.value;">
    <select id="pages" SIZE="1" onclick="save_page(this.value);" onchange="to_page(this.value);">
        <option value="0" onclick=""> 0 </option>
    </select>
    <select id="shape" SIZE="3" onclick="shape = shapes_btn.value;remove();add_shape();">
        <option value="1" onclick=""> circle </option>
        <option value="2" onclick=""> square </option>
        <option value="3" onclick=""> line </option>
    </select>
    <div id="shape_bound">
        <label>width</label>
        <input id="shape_width" type="number">
        <label id="shape_radius">height</label>
        <input id="shape_height" type="number">
        <button id="bound_hidde">ok</button>
    </div>
    <input type="hidden" id="inpt">

    <script>
        /*--------- div const ---------*/
        const dtop = document.getElementById("top");
        const board = document.getElementById("board");
        const canvas = document.getElementById("canvas");
        const btm = document.getElementById("btm");
        /*--------- btm const ---------*/
        const cwrite = document.getElementById("cwrite");
        const write = document.getElementById("write");
        const prash = document.getElementById("prash");
        const size = document.getElementById("size");
        const shaps = document.getElementById("shaps");
        const crouser = document.getElementById("crouser");
        const img = document.getElementById("img");
        const box = document.getElementById("box");
        const time = document.getElementById("time");
        const zoomi = document.getElementById("zoomi");
        const zoomo = document.getElementById("zoomo");
        const forword = document.getElementById("forword" );
        const backword = document.getElementById("backword");
        const color_picker = document.getElementById("color");
        const clear_btn = document.getElementById("clear_btn");
        const range_btn = document.getElementById("range");
        const pages = document.getElementById("pages");
        const shapes_btn = document.getElementById("shape");
        const inpt = document.getElementById("inpt");

        
        canvas.width = window.innerWidth;
        canvas.height = window.innerHeight - 160;
        
        let image  = new Image();
        let context = canvas.getContext("2d");
        let start_background_color = "white";
        context.fillStyle = start_background_color;
        context.fillRect(0, 0, canvas.width, canvas.height);
        /*image.onload = function(){
            context.drawImage(image, 0, 0);
        }*/
        var canvas_img;
		var dataURL;

        
        let canvas_top = canvas.offsetTop;
        let canvas_left = canvas.offsetLeft;
        let draw_color = "black";
        let celar_color = "white";
        let draw_width = range_btn.value;
        let is_drawing = false;
        let is_clear = false;
        let prashing = false;
        let writting = false;
        let restore_array = [];
        let index = restore_array.length - 1;
        let canvas_num = 0;
        let page = [];
        let shape;
        let shape_radius = false;
        let draw_shape = false;
        let xpoint = 200;
        let ypoint = 200;
        let radius = 100;
        let color = draw_color;
        let shape_height = 100;
        let shape_width = 100;
        let line_width = 100;
        let line_height = 200;
        let is_write = false;
        let word = "";

        canvas.addEventListener("touchstart", start, false);
        canvas.addEventListener("touchmove", draw, false);
        canvas.addEventListener("mousedown", start, false);
        canvas.addEventListener("mousemove", draw, false);

        canvas.addEventListener("touchend", stop, false);
        canvas.addEventListener("mouseup", stop, false);
        canvas.addEventListener("mouseout", stop, false);

        function lock(){
            draw_color = "rgba(0,0,0,0)";
        }
        
        function colors(){
            draw_color = "black";
            is_clear = false;
            draw_color = color_picker.value;
        }
        
        function clear_fun(cbtn){
            draw_color = celar_color;
            clear_btn.style.display = "inline-block";
            clear_btn.style.left = cbtn.offsetLeft;
            clear_btn.style.top = cbtn.offsetTop - 48;
        }
        
        function range(rbtn){
            range_btn.style.display = "inline-block";
            range_btn.style.left = rbtn.offsetLeft - 9;
            range_btn.style.top = rbtn.offsetTop - 48;
        }
        
        function remove(){
            clear_btn.style.display = "none";
            range_btn.style.display = "none";
            shapes_btn.style.display = "none";
        }
        
        
        function start(event){
            if(!draw_shape){
                is_drawing = true;
                context.beginPath();
                context.moveTo(event.clientX - canvas_left,event.clientY - canvas_top);
                event.preventDefault();
            }
        }
        function draw(event){
            if(is_drawing){
                context.lineTo(event.clientX - canvas_left,event.clientY - canvas_top);
                context.strokeStyle = draw_color;
                context.lineWidth = draw_width;
                context.lineCap = "round";
                context.lineJoin = "round";
                context.stroke();
            }
            event.preventDefault();
        }

        function stop(event){
            if(is_drawing){
                context.stroke();
                context.closePath();
                is_drawing = false;
            }
            event.preventDefault();
            if(event.type != 'mouseout'){
                restore_array.push(context.getImageData(0, 0, canvas.width, canvas.height));
                index = restore_array.length - 1;
            }
        }
    
        function clear_canvas(){
            context.fillStyle = start_background_color;
            context.clearRect(0, 0, canvas.width, canvas.height);
            context.fillRect(0, 0, canvas.width, canvas.height);
            //restore_array = [];
            //index = -1;
        }
    
        function undo_last(){
            if(index == 0){
                clear_canvas();
            }
            else{
                index -= 1;
                context.putImageData(restore_array[index], 0, 0);
            }
        }
        function undo_next(){
            if(index + 1 <= restore_array.length){
                context.putImageData(restore_array[index], 0, 0);
                index += 1;
            }
        }
        
        function to_page(l){
            page_num = l;
            context.putImageData(page[l], 0, 0);
        }
        function save_page(i){
            page[i] = context.getImageData(0, 0, canvas.width, canvas.height);
        }
        
        function add_page(){
            canvas_num += 1;
            pn += 1;
            pnl.push(pn);
            page_num = pnl.length;
            page.push(context.getImageData(0, 0, canvas.width, canvas.height));
            pindex = page.length;
            clear_canvas();
            restore_array = [];
            index = restore_array.length;
            pages.innerHTML += '<option value="'+canvas_num+'" onclick="to_page('+canvas_num+');" selected> '+canvas_num+'';
        }
        

        function shape_btn(sbtn){
            draw_color = color_picker.value;
            shapes_btn.style.display = "inline-block";
            shapes_btn.style.left = sbtn.offsetLeft - 24;
            shapes_btn.style.top = sbtn.offsetTop - 96;
        }
        
        
        canvas.onclick = function(event){
            if(draw_shape){
                xpoint = event.clientX;
                ypoint = event.clientY - 80;
                add_shape();
            }
            else if(is_write){
                xpoint = event.clientX;
                ypoint = event.clientY - 80;
                add_word();
            }
            
            var canvas_img = document.getElementById("canvas");
            var dataURL = canvas_img.toDataURL("image/png");
            inpt.value = dataURL;
        }
        
        /*
        class Circle{
            constructor(ypoint,radius,color){
                this.xpoint = xpoint;
                this.ypoint = ypoint;
                this.radius = radius;
                this.color = color;
            }
            draw(context){
                context.beginPath();
                context.arc(this.xpoint, this.ypoint, this.radius, 0, Math.PI * 2, false);
                context.strokeStyle = color;
                context.lineWidth = draw_width;
                context.stroke();
                context.closePath();
            }
            changColor(left,top){
                xpoint = 400;
                selected_shap = new Circle(top - canvas_top,50,color_picker.value);
                iff();
            }
            clickCircle(xmouse,ymouse){
                const distance = 
                Math.sqrt(
                    ((xmouse - this.xpoint) * (xmouse - this.xpoint))
                    +
                    ((ymouse - this.ypoint) * (ymouse - this.ypoint))
                );
                if(distance < this.radius){
                    this.changColor(event.clientX,event.clientY);
                }
            }   
        }
        */
        
        function add_shape(){
            if(shapes_btn.value == 1){
                draw_shape = true;
                xpoint = xpoint;
                ypoint = ypoint;
                radius = shape_height;
                color = draw_color;
                context.beginPath();
                context.arc(xpoint, ypoint, radius, 0, Math.PI * 2, false);
                context.strokeStyle = color;
                context.lineWidth = draw_width;
                context.stroke();
                context.closePath();
                restore_array.push(context.getImageData(0, 0, canvas.width, canvas.height));
                index = restore_array.length - 1;
            }
            else if(shapes_btn.value == 2){
                draw_shape = true;
                xpoint = event.clientX - (shape_width / 2);
                ypoint = event.clientY - 80 - (shape_height / 2);
                shape_height = shape_height;
                shape_width = shape_width;
                color = draw_color;
                context.lineWidth = draw_width;
                context.strokeStyle = draw_color;
                context.strokeRect(xpoint, ypoint, shape_height, shape_width);
                restore_array.push(context.getImageData(0, 0, canvas.width, canvas.height));
                index = restore_array.length - 1;
            }
            else if(shapes_btn.value == 3){
                draw_shape = true;
                xpoint = xpoint;
                ypoint = ypoint;
                shape_height = shape_height;
                shape_width = shape_width;
                color = draw_color;
                context.lineWidth = draw_width;
                context.strokeStyle = draw_color;
                context.beginPath();
                context.moveTo(xpoint,ypoint);
                context.lineTo(line_width,line_height);
                context.closePath();
                context.stroke();
                restore_array.push(context.getImageData(0, 0, canvas.width, canvas.height));
                index = restore_array.length - 1;
            }
        }
        
        function clickCircle(xmouse,ymouse){
            console.log("smoe thing wrong!");
            undo_last();
        }
        
        canvas.addEventListener("mousedown", (event) =>{
            const rect = canvas.getBoundingClientRect();
            const x = event.clientX - rect.left;
            const y = event.clientY - rect.top;
            if(event.button == 0 && draw_shape || is_write){
                is_drawing = false;
                clickCircle(x, y);
            }
        });
        canvas.addEventListener("wheel", (event) =>{
            if(shapes_btn.value == 1){
                let last = restore_array.length - 1;
                if(event.deltaY > 0 && draw_shape){
                    context.putImageData(restore_array[last], 0, 0);
                    shape_height += 3;
                    xpoint = event.clientX;
                    ypoint = event.clientY - 80;
                    radius = shape_height;
                    color = draw_color;
                    context.beginPath();
                    context.arc(xpoint, ypoint, radius, 0, Math.PI * 2, false);
                    context.strokeStyle = color;
                    context.lineWidth = draw_width;
                    context.stroke();
                    context.closePath();
                }
                else if(event.deltaY < 0 && draw_shape){
                    context.putImageData(restore_array[last], 0, 0);
                    shape_height -= 3;
                    xpoint = event.clientX;
                    ypoint = event.clientY - 80;
                    radius = shape_height;
                    color = draw_color;
                    context.beginPath();
                    context.arc(xpoint, ypoint, radius, 0, Math.PI * 2, false);
                    context.strokeStyle = color;
                    context.lineWidth = draw_width;
                    context.stroke();
                    context.closePath();
                }
            }
            if(shapes_btn.value == 2){
                let last = restore_array.length - 1;
                if(event.deltaY > 0 && draw_shape){
                    context.putImageData(restore_array[last], 0, 0);
                    shape_height += 3;
                    shape_width += 3;
                    xpoint = event.clientX - (shape_width / 2);
                    ypoint = event.clientY - 80 - (shape_height / 2);
                    shape_height = shape_height;
                    shape_width = shape_width;
                    color = draw_color;
                    context.lineWidth = draw_width;
                    context.strokeStyle = draw_color;
                    context.strokeRect(xpoint, ypoint, shape_height, shape_width);
                }
                else if(event.deltaY < 0 && draw_shape){
                    context.putImageData(restore_array[last], 0, 0);
                    shape_height -= 3;
                    shape_width -= 3;
                    xpoint = event.clientX - (shape_width / 2);
                    ypoint = event.clientY - 80 - (shape_height / 2);
                    shape_height = shape_height;
                    shape_width = shape_width;
                    color = draw_color;
                    context.lineWidth = draw_width;
                    context.strokeStyle = draw_color;
                    context.strokeRect(xpoint, ypoint, shape_height, shape_width);
                }
            }
            if(shapes_btn.value == 3){
                let last = restore_array.length - 1;
                if(event.deltaY > 0 && draw_shape){
                    context.putImageData(restore_array[last], 0, 0);
                    color = draw_color;
                    context.lineWidth = draw_width;
                    context.strokeStyle = draw_color;
                    context.beginPath();
                    context.moveTo(xpoint,ypoint);
                    context.lineTo(event.clientX,event.clientY - 80);
                    context.closePath();
                    context.stroke();
                    line_width = xpoint;
                    line_height = ypoint;
                }
                else if(event.deltaY < 0 && draw_shape){
                    context.putImageData(restore_array[last], 0, 0);
                    color = draw_color;
                    context.lineWidth = draw_width;
                    context.strokeStyle = draw_color;
                    context.beginPath();
                    context.moveTo(xpoint,ypoint);
                    context.lineTo(event.clientX,event.clientY - 80);
                    context.closePath();
                    context.stroke();
                    line_width = xpoint;
                    line_height = ypoint;
                }
            }
        });

        function add_word(){
            is_drawing = false;
            is_write = true;
            context.font = ""+ draw_width +"px Arial" ;
            context.lineWidth = draw_width;
            context.fillStyle = color_picker.value;
            context.fillText(word, xpoint, ypoint);
            restore_array.push(context.getImageData(0, 0, canvas.width, canvas.height));
            index = restore_array.length - 1;
        }
        
        window.addEventListener("keydown", (z) =>{
            if(is_write){
                is_drawing = false;
                let last = restore_array.length - 1;
                context.putImageData(restore_array[last], 0, 0);
                if(z.key == "Backspace"){
                    let l = word.length - 1;
                    let back_word = '';
                    for(let i = 0; i < l; i++){
                        back_word +=  word[i];
                    }
                    word = back_word;
                }
                else if(z.key != "Alt" && z.key != "Tab" && z.key != "CapsLock" && z.key != "Shift" && z.key != "Control"){
                    word += z.key;
                }
                context.font = ""+ draw_width +"px Arial" ;
                context.lineWidth = draw_width;
                context.fillStyle = draw_color;
                context.fillText(word, xpoint, ypoint);
            }
        });

        /*
            let constraints = {
            video: {
                mediaSource: "screen"
            }
            };

            navigator.mediaDevices.getUserMedia(constraints)
            .then(mediaStream => {
                // do something with mediaStream now
            });
        */

        setInterval(() => {
            canvas_img = document.getElementById("canvas");
			dataURL = canvas_img.toDataURL("image/png");
            inpt.value = dataURL;
            ajaxpost();
        }, 1000 / 30);



        window.oncontextmenu = (e) => {
            e.preventDefault();
        }

    </script>
    <script src="js/popper.min.js"></script>
    <script src="js/jquery-3.6.0.min.js"></script>
    <script src="js/bootstrap.js"></script>
</body>
</html>