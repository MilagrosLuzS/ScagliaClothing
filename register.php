<?php
include_once('guest.php');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <link rel="stylesheet" type="text/css" href="css/styles_register.css">
    <link rel="stylesheet" type="text/css" href="css/styles.css">
    <script src="../js/Validacion_Register.js" async></script>
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
    <section class="register">
        <form id="formulario" method="POST" action="">
            <h1>CREAR CUENTA</h1>
            <div class="contenedor">
                <div class="input_contenedor">
                    <input id="usuario"  name="name" type="text" placeholder="Nombre Completo">
                    <p></p>
                </div>
                <div class="input_contenedor">
                    <input id="email" name="email" type="text" placeholder="E-Mail">
                    <p></p>
                </div>
                <div class="input_contenedor">
                    <input id="password" name="password" type="password" placeholder="Contraseña">
                    <p></p>
                </div>
                <div class="input_contenedor">
                    <input id="passwordConfirm" name="passwordConfirm" type="password" placeholder="Repetir contraseña">
                    <p></p>
                </div>
                <?php
                include_once('bd.php');
                if($_POST){
                    $conn = conectarBD();
                    $query = 'SELECT * from user where email = "' . $_POST["email"] .'";';
                    $respuesta = consultaSQL($conn, $query);

                    if($respuesta->num_rows > 0){
                        print("Este email ya esta registrado.");
                        desconectarBD($conn);
                    }
                    else{
                        $query = 'INSERT INTO user (email,password,user_name,id_user_role) VALUES ("' . $_POST["email"] . '","' . $_POST["password"] . '","' . $_POST["name"] . '",2)';
                        consultaSQL($conn, $query);
                        $_SESSION['user'] = $_POST['user'];
                        $_SESSION['id'] = $conn->insert_id;
                        desconectarBD($conn);
                        header('Location: Login.php');
                    }
                }
                ?>
                <div class="submit">
                    <input type="submit" onclick="validarCampos()"value="Registrate" name="enviar" class="button">
                </div>
                <p class="switch">
                    Al registrarte, aceptas nuestras condiciones de uso y politica de privacidad.
                </p>
                <p class="switch">¿ya te registraste anteriormente? <a href="Login.php">Iniciar sesion</a></p>
                
            </div>
        </form>
    </section>
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
    <script src="js/Validacion_Register.js" async></script>
</body>
</html>