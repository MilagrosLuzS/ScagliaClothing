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
                <script src="js/Carrousel.js"></script>
                <script> var contenido = '.$imagenes_json.'; </script>
                <div class="flex-prenda">
                <div class="imagenes">
                    <div class="boton" onclick="cambiarImagen(-1)" id="atras">
                        &#60
                    </div>
                    <img id="imagen" src="'.$imagenes[0].'">
                    <div class="boton" onclick="cambiarImagen(1)" id="adelante">
                        &#62
                    </div>
                </div>
                
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
                                    <a href="https://www.instagram.com/scagliaclothing"><li><img src="Multimedia\Iconos\instagram.png"></li></a>
                                    <a href="https://www.facebook.com/scagliaclothing"><li><img src="Multimedia\Iconos\facebook.png"></li></a>
                                    <a href="mailto:scagliaclothing@gmail.com?Subject=Consulta%20-%20web"><li><img src="Multimedia\Iconos\email.png"></li></a>
                                </ul>
                        </nav>
                    </section>

                    <section class="flex-categ">
			<?php if(!empty($_SESSION['user'])){
                if($_SESSION["id_user_role"] == 2) {?>
				<p>MY SCAGLIA</p>
                            <nav>
                            <ul>
                                <a href="Mi_cuenta.php"><li>MI CUENTA</li></a>
                            </ul>
                            </nav>
                        </section>
				<?php }else if($_SESSION["id_user_role"] == 1){?>
				<p>MY SCAGLIA</p>
                            <nav>
                            <ul>
                                <a href="Admin_inicio.php"><li>ADMINISTRADOR</li></a>
                            </ul>
                            </nav>
                        </section>
			<?php }else{ ?>
                <p>MY SCAGLIA</p>
                <nav>
                <ul>
                    <a href="Login.php"><li>INICIAR SESION</li></a>
                    <a href="Register.php"><li>REGISTRARME</li></a>
                </ul>
                </nav>
            </section>
            <?php }
            }
			?>

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