<?php 
session_start();
?>
<html>  
    <head>
        <meta charset="UTF-8"/>
        <meta name="keywords" content="buzos,indumentaria,negro,minimalismo,basicos">
        <meta name="description" content="Apasionados del diseño. Elevamos básicos al siguiente nivel, vistiendo distinto.">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">

        <title>PRODUCTOS</title>

        <link rel="stylesheet" type="text/css" href="css/styles.css">
        <link rel="stylesheet" type="text/css" href="css/styles-producto.css">
        <link rel="stylesheet" type="text/css" href="css/responsive.css">
        <script src="js/Producto.js"></script>
    </head>

    <body>

        <header>
        <div class="hdr-flex">
            <div class="general">
                    <section class="logo">
                        <a href="index.php"><img src="Multimedia\Recursos\Version negativo\recurso13.png" alt="loading.."></a>
                    </section>

                    <section>
                        <nav class="menu">
                            <ul>
                                <li>
                                    <a href="Buzos.php">BUZOS</a>
                                </li>
                                <li>
                                    <a href="Remeras.php">REMERAS</a>
                                </li>
                                <li><a href="Guia_de_talles.php">GUÍA DE TALLES</a></li>
                                <li><a href="About.php">ABOUT</a></li>
                            </ul>
                        </nav>
                    
                    </section>
            </div>       
            <section class="icons">
                <nav>
                <ul>
                    <?php if (!empty($_SESSION['user'])) { 
                        if($_SESSION["id_user_role"] == 2) { ?>
                            <a href="Mi_cuenta.php"><li><img src="Multimedia/iconos/user-24.png"></li></a>
                            <a href="carrito.php"><li><img src="Multimedia/iconos/cart-79-24.png"></li></a>
                            <a href="mailto:scagliaclothing@gmail.com?Subject=Consulta%20-%20web"><li><img src="Multimedia/iconos/chat-4-24.png"></li></a>
                            <a href="logout.php"><li><img src="Multimedia/iconos/logout-24.png"></li></a>
                    <?php } else if ($_SESSION["id_user_role"] == 1) { ?>
                            <a href="Admin_inicio.php"><li><img src="Multimedia/iconos/user-24.png"></li></a>
                            <a href="logout.php"><li><img src="Multimedia/iconos/logout-24.png"></li></a>
                    <?php }
                    } else { ?>
                        <a href="login.php"><li><img src="Multimedia/iconos/user-24.png"></li></a>
                    <?php } ?>
                </ul>
                </nav>
            </section>
        </div>
        
        </header>

        <?php
            if(!$_GET || !$_GET['id']){
                header("location: index.php");
            }
            include('bd.php');
            $conn = conectarBD();
            $id_producto = $_GET['id'];
            echo ('<script>id_producto='.$id_producto.' </script>');
            $query = "SELECT * FROM product WHERE product.product_id = $id_producto";
            $result = consultaSQL($conn,$query);
            $arr = array();
            $colores = array();
            $producto = $result->fetch_assoc();
            $arr[]=$producto["size"];
            $colores[]=$producto["color"];

            //imagenes
            $query_img = "SELECT image FROM product_images WHERE product_images.product_id = $id_producto";
            $result_img = consultaSQL($conn,$query_img);
            $imagenes = array();
            while($imagen = $result_img->fetch_assoc()){
                $imagenes[] = $imagen["image"];
            }
            //convierto el array en un objeto de js para poder usarlo en js
            $imagenes_json = json_encode($imagenes);
            echo('
                <div class="flex-prenda">
                <div class="imagenes">
                    <div class="boton" id="atras">
                        &#60
                    </div>
                    <img id="imagen" src="'.$imagenes[0].'">
                    <div class="boton" id="adelante">
                        &#62
                    </div>
                </div>
                <script> var contenido = '.$imagenes_json.'; </script>
                <script src="js/Carrousel.js"></script>
                <div class="info">
                <section class="titulo">
                    <h1><strong>'.$producto["product_name"].'</strong></h1>
                </section>
                <section class="descrip">
                    <h2>'.$producto["description"].'<br><br>
                        '.$producto["price"].'
                    </h2>
                </section>
            ');
            while($producto = mysqli_fetch_assoc($result)){
                $arr[]=$producto["size"];
                if(!in_array($producto["color"],$colores)){
                    $colores[]=$producto["color"];
                }
            };
            //armo un array que permite al administrador agregar mas talles 
            echo('    
                <section>
                    <form class="descrip">
                        <h3>COLOR</h3>
                        <section class="color">
                ');
            foreach($colores as $color){
                echo('<input class="color-input" name="color" value="'.$color.'" type="radio" id="'.$color.'"/>
                <label class="color-label" for="'.$color.'">'.$color.'</label>');
            }
                        
            echo('
                        </section>
                        <h3>TALLE</h3>
                        <section class="radio">
                ');
            foreach($arr as $talle){
                echo('<input class="radio-input" name="talle" value="'.$talle.'" type="radio" id="radio'.$talle.'"/>
                <label class="radio-label" for="radio'.$talle.'">'.$talle.'</label>');
            }
            echo('
                        </section>
                        <p class="guia"><a href="guia_de_talles.php">GUÍA DE TALLES</a></p>
            ');
            if(!(empty($_SESSION['user'])) && $_SESSION["id_user_role"]==2){
                
                echo('
                                <section class="flex-botones">
                                    <a onclick="agregarProducto()" class= "button" >AÑADIR AL CARRITO [<span id="cantidad"></span>]</a>
                                    <a onclick="mas()" class="button"> + </a>
                                    <a onclick="menos()" class="button"> - </a>
                                </section>
                            </form>
                        </section>
                        <div id="alerta" class="alerta-AC" >
                                    Agregado correctamente al carrito
                        </div>
                    </div>
                ');
            }
            else{
                echo('
                    <section class="flex-botones">
                            <input href="login.php" class= "button" type="submit" value="INICIE SESION PARA COMPRAR">
                            </section>
                        </form>
                    </section>
                    </div>
                ');
            };
        ?>
        <script>actualizarCantidad()</script>
        <footer>
            <div class = "flex-footer">

                    <section class="flex-iso">
                        <a href="index.php"><img src="Multimedia\Recursos\Version negativo\Recurso 14.png" alt="loading..."></a>
                    </section>

                    <section class="flex-categ">
                        <p>CATEGORÍAS</p>
                        <nav>
                        <ul>
                            <a href="buzos.php"><li>BUZOS</li></a>
                            <a href="remeras.php"><li>REMERAS</li></a>
                            <a href="guiadetalles.php"><li>GUÍA DE TALLES</li></a>
                            <a href="about.php"><li>ABOUT</li></a>
                        </ul>
                        </nav>
                    </section>

                    <section class="flex-conect">
                        <p>SIGAMOS CONECTADOS</p>
                        <nav>
                            <ul>
                                <a href="https://www.instagram.com/scagliaclothing"><li><svg class="icons2" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512"><!--! Font Awesome Pro 6.2.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2022 Fonticons, Inc. --><path d="M224.1 141c-63.6 0-114.9 51.3-114.9 114.9s51.3 114.9 114.9 114.9S339 319.5 339 255.9 287.7 141 224.1 141zm0 189.6c-41.1 0-74.7-33.5-74.7-74.7s33.5-74.7 74.7-74.7 74.7 33.5 74.7 74.7-33.6 74.7-74.7 74.7zm146.4-194.3c0 14.9-12 26.8-26.8 26.8-14.9 0-26.8-12-26.8-26.8s12-26.8 26.8-26.8 26.8 12 26.8 26.8zm76.1 27.2c-1.7-35.9-9.9-67.7-36.2-93.9-26.2-26.2-58-34.4-93.9-36.2-37-2.1-147.9-2.1-184.9 0-35.8 1.7-67.6 9.9-93.9 36.1s-34.4 58-36.2 93.9c-2.1 37-2.1 147.9 0 184.9 1.7 35.9 9.9 67.7 36.2 93.9s58 34.4 93.9 36.2c37 2.1 147.9 2.1 184.9 0 35.9-1.7 67.7-9.9 93.9-36.2 26.2-26.2 34.4-58 36.2-93.9 2.1-37 2.1-147.8 0-184.8zM398.8 388c-7.8 19.6-22.9 34.7-42.6 42.6-29.5 11.7-99.5 9-132.1 9s-102.7 2.6-132.1-9c-19.6-7.8-34.7-22.9-42.6-42.6-11.7-29.5-9-99.5-9-132.1s-2.6-102.7 9-132.1c7.8-19.6 22.9-34.7 42.6-42.6 29.5-11.7 99.5-9 132.1-9s102.7-2.6 132.1 9c19.6 7.8 34.7 22.9 42.6 42.6 11.7 29.5 9 99.5 9 132.1s2.7 102.7-9 132.1z"/></svg></li></a>
                                <a href="https://www.facebook.com/scagliaclothing"><li><svg class="icons2" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 320 512"><!--! Font Awesome Pro 6.2.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2022 Fonticons, Inc. --><path d="M279.14 288l14.22-92.66h-88.91v-60.13c0-25.35 12.42-50.06 52.24-50.06h40.42V6.26S260.43 0 225.36 0c-73.22 0-121.08 44.38-121.08 124.72v70.62H22.89V288h81.39v224h100.17V288z"/></svg></li></a>
                                <a href="mailto:scagliaclothing@gmail.com?Subject=Consulta%20-%20web"><li><svg class="icons2" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><!--! Font Awesome Pro 6.2.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2022 Fonticons, Inc. --><path d="M0 128C0 92.65 28.65 64 64 64H448C483.3 64 512 92.65 512 128V384C512 419.3 483.3 448 448 448H64C28.65 448 0 419.3 0 384V128zM48 128V150.1L220.5 291.7C241.1 308.7 270.9 308.7 291.5 291.7L464 150.1V127.1C464 119.2 456.8 111.1 448 111.1H64C55.16 111.1 48 119.2 48 127.1L48 128zM48 212.2V384C48 392.8 55.16 400 64 400H448C456.8 400 464 392.8 464 384V212.2L322 328.8C283.6 360.3 228.4 360.3 189.1 328.8L48 212.2z"/></svg></li></a>
                            </ul>
                        </nav>
                    </section>

                    <section class="flex-categ">
                        <p>MY SCAGLIA</p>
                        <nav>
                        <ul>
                            <a href="Login.php"><li>INICIAR SESIÓN</li></a>
                            <a href="Register.php"><li>REGISTRARME</li></a>
                        </ul>
                        </nav>
                    </section>

                    <section class="flex-pagos">
                        <hr style="width:100%" color="white" >
                        <p>MÉTODOS DE PAGO</p>
                            <img src="Multimedia\Tarjetas\americam.png" alt="loading...">
                            <img src="Multimedia\Tarjetas\banconaranjax.png" alt="loading...">
                            <img src="Multimedia\Tarjetas\cabalcredito.png" alt="loading..."> 
                            <img src="Multimedia\Tarjetas\maestro.png" alt="loading...">
                            <img src="Multimedia\Tarjetas\mercadopago.png" alt="loading...">
                            <img src="Multimedia\Tarjetas\visa.png" alt="loading...">
                            <img src="Multimedia\Tarjetas\master.png" alt="loading...">

                    </section>

            </div>

            <div class="copyright">
                <hr style="width:100%" color="white">
                <p>Copyright Scaglia - 2022. Todos los derechos reservados</p>
            </div>


            
        </footer>
    </body>
</html>