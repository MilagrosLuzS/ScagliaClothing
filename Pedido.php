<?php 
session_start();
?>
<html>  
    <head>
        <meta charset="UTF-8"/>
        <meta name="keywords" content="buzos,indumentaria,negro,minimalismo,basicos">
        <meta name="description" content="Apasionados del diseño. Elevamos básicos al siguiente nivel, vistiendo distinto.">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">

        <title>PEDIDO</title>

        <link rel="stylesheet" type="text/css" href="css/styles.css">
        <link rel="stylesheet" type="text/css" href="css/styles-producto.css">
        <link rel="stylesheet" type="text/css" href="css/responsive.css">
        <link rel="stylesheet" type="text/css" href="css/styles-pedido.css">
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
                            <?php if (!empty($_SESSION['user'])) { ?>
                                <a href="Mi_cuenta.php"><li><img src = "Multimedia/iconos/user-24.png"></li></a>
                                <a href="carrito.php"><li><img src = "Multimedia/iconos/cart-79-24.png"></li></a>
                                <a href="mailto:scagliaclothing@gmail.com?Subject=Consulta%20-%20web"><li><img src = "Multimedia/iconos/chat-4-24.png"></li></a>
                                <a href="logout.php"><li></li><img src = "Multimedia/iconos/logout-24.png"></a>
                                
                            <?php } else { ?>
                                <a href="login.php"><li><img src = "Multimedia/iconos/user-24.png"></li></li></a>
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
            // obtengo el pedido 
            $id_pedido = $_GET['id'];
            $query = "SELECT orders.*, status.description as estado_actual FROM orders JOIN status ON status.id = orders.id_status 
                      WHERE orders.id = $id_pedido";
            $result = consultaSQL($conn,$query);
            $pedido = $result->fetch_assoc();
            $query = "SELECT adress.* FROM orders JOIN adress ON adress.id = orders.id_adress WHERE orders.id = $id_pedido";
            $result = consultaSQL($conn,$query);
            $direccion = $result->fetch_assoc();
            if($pedido && $pedido["id_user"] == $_SESSION["id"]){
                $eleccion = $pedido["id_shipping"] == 1 ?  "Retiro en Sucursales" : "Envio a domicilio";
                // traigo los productos del pedido
                $query = "SELECT order_items.*,product.product_name as nombre_producto, product.size as talle,
                        (SELECT image FROM product_images WHERE product_images.product_id = order_items.product_id LIMIT 1) as producto_imagen
                        FROM order_items JOIN product ON product.product_id = order_items.product_id AND product.size = order_items.talle WHERE id_order = $id_pedido";
                $result = consultaSQL($conn,$query);
                $pedidos_producto = [];
                while($p = $result->fetch_assoc()){
                    $pedidos_producto[]=$p;
                }
            }
            else{
                header("Location: index.php");
            }
        ?>
        <div class="pedidos">
            <div class="titulo">
                <h2 class="header">RESUMEN DEL PEDIDO #<?php echo $_GET["id"]; ?></h2>
                <h2 class="header" id="gracias">GRACIAS POR COMPRAR EN NUESTRA TIENDA</h2>
            </div>
            <div class="resumen_section_header">
                <div class="info-pedido">
                    <p style="color:black">Tu numero de pedido es: <?php echo $_GET["id"]; ?></p>
                    <p class="small" style="color:black">Durante las proximas horas te estaremos contactando via mail para actualizarte el estado del pedido junto con la sucursal mas cercana si corresponde.</p>
                    <p class="small" style="color:black">Estado del pedido: <?php echo $pedido["estado_actual"] ?></p>
                </div>
            </div>
            <h2 class="header">Productos</h2></br>
            <div class="productos">
                <?php
                foreach ($pedidos_producto as $p) {
                    echo('
                        <div class="producto">
                            <div class="imagen">
                            <img src="'.$p["producto_imagen"].'" alt="">
                            </div>
                            <div class="content">
                                <div class="descripcion">
                                    <h3>'.$p["nombre_producto"].'</h3>
                                    <p style="color:black" class="tags">Talle = '.$p["talle"].'</p>
                                </div>
                                <div class="cantidad">
                                    <p style="color:black">Precio unit.: $'.number_format($p["unit_price"], 2).'</p>
                                    <p style="color:black">Cantidad: '.strval($p["quantity"]).'</p>
                                    <div class="precio_item">
                                    $'.number_format($p["unit_price"] * $p["quantity"], 2).'
                                    </div>
                                </div>
                            </div>
                        </div>
                    '); 
                }
                ?>
            </div>
            <section class="details">
                <div class="section envio">
                    <h2 class="header">Datos de <?php echo $pedido["id_shipping"] == 1 ? "retiro" : "envio" ?></h2>
                    <p class="seleccionaste" style="color:black">Seleccionaste: <b><?php echo $eleccion?></b></p>
                    <div class="info-envio">
                        <h3>Datos:</h3>
                        <div class="row">
                            <b>Direccion:</b>
                            <?php echo('
                                <p style="color:black"> Calle '.$direccion["street"].', '.$direccion["st_number"].'</p>
                                <p style="color:black"> '.$direccion["city"].', '.$direccion["province"].'</p>
                            ')
                            ?>
                        </div>
                        <div class="row">
                            <b>DNI:</b>
                            <p style="color:black"><?php echo $direccion["DNI"] ?></p>
                        </div>
                        <div class="row">
                            <b>Telefono:</b>
                            <p style="color:black"><?php echo $direccion["phone"] ?></p>
                        </div>
                    </div>
                </div>
                <div class="section pago">
                    <h2 class="header">Datos de pago</h2>
                    <div class="info-pago">
                        <div class="row">
                            <p style="color:black">Total: <b>$<?php echo number_format($pedido["total_price"], 2); ?></b> </p>
                        </div>
                        <div class="row">
                            <p style="color:black">Abonado con la tarjeta terminada en <?php echo substr($pedido["card"], -4) ?> </p>
                        </div>
                        <div class="row">
                            <p style="color:black">Titular: <?php echo $pedido["cardholder"] ?></p>
                        </div>
                    </div>
                </div>
                </section>
            </section>   
            
        </div>
        
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