<?php
    include('bd.php');
    include('only_client.php');
?>
<!DOCTYPE html>
    <html>  
        <head>
            <meta charset="UTF-8"/>
            <meta name="keywords" content="buzos,indumentaria,negro,minimalismo,basicos">
            <meta name="description" content="Apasionados del diseño. Elevamos básicos al siguiente nivel, vistiendo distinto.">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">

            <title>Detalles de la cuenta</title>

            <link rel="stylesheet" type="text/css" href="css/styles.css">
            <link rel="stylesheet" type="text/css" href="css/styles-cuenta-direc-a.css">
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

            <div class="titulo">
                <h1><strong>MI CUENTA</strong></h1>
                <h2>DETALLES DE LA CUENTA</h2>
            </div>

            <div class="about-flex">

                <div class="imagen">
                    <ul>
                    <li><a href="Mi_Cuenta.php">Escritorio</a></li>
                    <li><a href="Pedidos.php">Pedidos</a></li>
                    <li><a href="Direcciones.php">Dirección</a></li>
                    <li><a href="Details.php">Detalles de la cuenta</a></li>
                    <li><a>Salir</a></li>
                    </ul>
                </div>
            <div class="content"> 
                    <section class="flex-dir">
                        <h2>Cambio de contraseña</h2>
                    </section>

                    <?php

                if(isset($_SESSION['user'])) {
                    // Obtener el ID del producto de la URL
                    $conn = conectarBD();

                    // Consulta para obtener el nombre correspondiente al correo electrónico
                $query = "SELECT * FROM user WHERE email = '{$_SESSION['user']}'";
                // Ejecutar la consulta
                $resultado = mysqli_query($conn, $query);

                // Verificar si se obtuvieron resultados
                if (mysqli_num_rows($resultado) > 0) {
                    // Obtener el nombre de usuario de la primera fila del resultado
                    $row = mysqli_fetch_assoc($resultado);
                    $id_usuario = $row['id'];
                    $password_usuario = $row['password'];
                    
                    ?>

                    <form  id="formulario" action="#" method="post" enctype="multipart/form-data">
                        <div class="input_contenedor">
                            <h2>Actual contraseña</h2>
                            <input id="PasActual" type="password" name="PasActual">
                            <p></p>
                        </div>
                        <div class="input_contenedor">
                            <h2>Nueva <br> contraseña</h2>
                            <input id="PasNueva" type="password" name="PasNueva">
                            <p></p>
                        </div>
                        <div class="input_contenedor">
                            <h2>Confirmar <br> nueva contraseña</h2>
                            <input id="PasConfirm" type="password" name="PasConfirm">
                            <p></p>
                        </div>
    
                        <section class="submit">
                            <input value="Guardar" onclick="validarCampos(event,'<?php echo $password_usuario; ?>')" class="button" type="submit" name="Guardar">
                        </section>
                    
                        <?php 
                    if ($_SERVER["REQUEST_METHOD"] == "POST") {
                        // Verifica si se han recibido todos los campos necesarios del formulario
                        if (isset($_POST['PasActual'], $_POST['PasNueva'],$_POST['PasConfirm'])) {
                            $conn = conectarBD();

                            $password_actual = $_POST['PasActual']; // ID del usuario a actualizar
                            $password_nueva = $_POST['PasNueva'];
                            $password_confirm = $_POST['PasConfirm'];
                            $update_query = "UPDATE user SET password = '$password_nueva' WHERE id = $id_usuario";
                            consultaSQL($conn,$update_query);

                            
                            }
                        } 
                    }
                }
                    desconectarBD($conn);
                    ?>

               </form>        
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
            <script src="js/Validacion_Cambio_Contraseña.js"></script>
        </body>
    </html>