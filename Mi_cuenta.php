<?php 

include_once('bd.php');
include('only_client.php');
?>
<!DOCTYPE php>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MI CUENTA</title>
    <link rel="stylesheet" type="text/css" href="css/styles.css">
    <link rel="stylesheet" type="text/css" href="css/styles_gdt.css">
    <link rel="stylesheet" type="text/css" href="css/styles-cuenta-direc.css">
            <link rel="stylesheet" type="text/css" href="css/styles-cuenta.css">
            <link rel="stylesheet" type="text/css" href="css/styles-wishlist.css">
            <link rel="stylesheet" type="text/css" href="css/responsive.css">
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
                                <li><a href="Guia de talles.php">GUÍA DE TALLES</a></li>
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

   
    
    <div class="titulo">
        <h1><strong>MI CUENTA</strong></h1>
            <?php
            $conn = conectarBD();
            // Verificar si el nombre de usuario está almacenado en la sesión
            if(isset($_SESSION['user'])) {
                

                // Consulta para obtener el nombre correspondiente al correo electrónico
                $query = "SELECT user_name FROM user WHERE email = '{$_SESSION['user']}'";
                // Ejecutar la consulta
                $resultado = mysqli_query($conn, $query);

                // Verificar si se obtuvieron resultados
                if (mysqli_num_rows($resultado) > 0) {
                    // Obtener el nombre de usuario de la primera fila del resultado
                    $row = mysqli_fetch_assoc($resultado);
                    $nombreUsuario = $row['user_name'];
            ?>

            
                            <h2>ESCRITORIO</h2>
                        </div>

                        <div class="about-flex">

                            <div class="imagen">
                                <ul>
                                    <li><a href="Mi_Cuenta.php">Escritorio</a></li>
                                    <li><a href="Pedidos.php">Pedidos</a></li>
                                    <li><a href="Details.php">Detalles de la cuenta</a></li>
                                    <li><a href="logout.php">Salir</a></li>
                                </ul>
                            </div>
                        <div class="content">

                <p>Hola, <?= $nombreUsuario?> <br>
                (¿no eres <?= $nombreUsuario?>? <span><a href="logout.php">Cerrar sesión</a></span>)<br>
                Desde el escritorio de tu cuenta puedes ver tus <span><a href="Pedidos.php">pedidos recientes</a></span>.</p>

            <?php
            } else {
                // Si no está almacenado, mostrar un mensaje de error o redirigir al usuario
                echo "<a href='login.php'><p>Inicia sesión para ingresar a tu cuenta</p></a>";
            }
        }
            ?>
    
            
            </div>

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