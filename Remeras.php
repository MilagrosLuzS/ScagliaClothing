<?php
    include('bd.php');
    session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Remeras</title>
    <link rel="stylesheet" type="text/css" href="css/styles_remeras.css">
    
    <link rel="stylesheet" type="text/css" href="css/styles.css">
    <link rel="preconnect" href="https://fonts.gstatic.com">
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
                                <li><a href="Guia_de_Talles.php">GUÍA DE TALLES</a></li>
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
    <section class="presentacion">
        <a href="index.php"><img src="Multimedia\Fotos\remera-banner.jpg" /></a>
    </section>
    <section class="remeras_general">
        <div class="titulo">
            <h1><strong>REMERAS</strong></h1>
        </div>
        <div class="contenido_grillas">
        <?php 
                $conn = conectarBD();
                $query = 'SELECT * FROM product WHERE (type = "Remera" AND stock>0) GROUP BY product_name;';
                $result = consultaSQL($conn,$query);
                while($remeras = mysqli_fetch_assoc($result)){
                    $nombre = $remeras["product_name"];
                    $img = $remeras["img"];
                    $precio = $remeras["price"];
                    $id_producto = $remeras["product_id"];
                    echo(
                        '<section class="remeras">
                            <a href="Producto.php?id='.$id_producto.'"><img src="'.$img.'" /></a>
                            <div class="nombre_precio">
                                <h2><a>'.$nombre.'</a></h2>
                                <h3>$'.$precio.'</h3>
                            </div>
                            <div class="boton">
                                <a href="Producto.php?id='.$id_producto.'" style="">VER PRODUCTO</a>
                            </div>
                        </section>'
                    );
                }
            ?>
        </div>
    </section>
    <<footer>
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
                        <a href="Guia_de_Talles.php"><li>GUÍA DE TALLES</li></a>
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