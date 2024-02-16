<?php 
include('only_client.php');
?>
<!DOCTYPE html>
    <html>  
        <head>
            <meta charset="UTF-8"/>
            <meta name="keywords" content="buzos,indumentaria,negro,minimalismo,basicos">
            <meta name="description" content="Apasionados del diseño. Elevamos básicos al siguiente nivel, vistiendo distinto.">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">

            <title>ENVIO_CARRITO</title>

            <link rel="stylesheet" type="text/css" href="css/styles.css">
            <link rel="stylesheet" type="text/css" href="css/styles_carritoEnvio.css">
            <link rel="stylesheet" type="text/css" href="css/responsive.css">
            <script src="js/ValidacionCarritoEnvio.js"></script>
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
                include_once("bd.php");
                $conn = conectarBD();
                $usuario = $_SESSION["id"];

                // Verificar si el usuario tiene una dirección existente
                $query = "SELECT id, street, st_number, city, province, zip, phone, DNI FROM adress WHERE id IN (SELECT id_adress FROM user_adress WHERE id_user = $usuario)";
                $result = consultaSQL($conn, $query);

                if ($result->num_rows > 0) {
                    // Si existe, mostrar un mensaje y opción para usar la dirección existente
                    $row = $result->fetch_assoc();
                    $direccion_existente = $row['street'] . ' ' . $row['st_number'] . ', ' . $row['city'] . ', ' . $row['province'] . ', ' . $row['zip'];
                ?>

                        <!-- Agregar un campo oculto para indicar que hay una dirección existente -->
                        <input type="hidden" id="direccion_existente" value="<?= $direccion_existente ?>">

                <?php
                } else if($_SERVER['REQUEST_METHOD']=="POST"){
                    //agrego otra direccion
                    $ciudad = $_POST["Ciudad"];
                    $provincia = $_POST["Provincia"];
                    $calle = $_POST["Calle"];
                    $numero = $_POST["Numero"];
                    $codigo_postal = $_POST["Codigo_Postal"];
                    $telefono = $_POST["Telefono"];
                    $dni = $_POST["DNI"];
                    $envio = $_POST["Envio"];
                    $usuario = $_SESSION["id"];
                    $query = "INSERT INTO adress(street,st_number,city,province,zip,phone,DNI) VALUES('$calle','$numero','$ciudad','$provincia','$codigo_postal','$telefono','$dni')";
                    $result = consultaSQL($conn,$query);
                    $id = $conn->insert_id;
                    $query = "INSERT INTO user_adress(id_adress,id_user) VALUES($id,$usuario)";
                    consultaSQL($conn,$query);
                    $query = "UPDATE cart SET envio = $envio WHERE cart.user_id = $usuario";
                    consultaSQL($conn,$query);
                    desconectarBD($conn);
                    header('Location: CarritoPago.php');
                }
                ?>

                <!-- Aquí comienza el formulario -->
                <div class="general_Envio">
                    <section class="register">
                        <form id="formulario" method="POST" action="">
                                <div class="titulo">
                                    <h1><strong>¿Como entregamos tu compra?</strong></h1>
                                </div>
                                <div id="radio" class="Entregas">
                                    <input class="radio-input" name="Envio" value="1" type="radio" id="radio1"/>
                                    <label class="radio-label" for="radio1">Retiro en puntos de entrega</label>
                                    <input class="radio-input" name="Envio" value="2" type="radio" id="radio2"/>
                                    <label class="radio-label" for="radio2">Envio a domicilio</label>
                                </div> 
                                <h1>Datos de envio</h1>
                                <div class="contenedor">
                                    <div class="input_contenedor">
                                        <input id="Ciudad" name="Ciudad" type="text" placeholder="Ciudad">
                                        <p></p>
                                    </div>
                                    <div class="input_contenedor">
                                        <input id="Provincia" name="Provincia" type="text" placeholder="Provincia">
                                        <p></p>
                                    </div>
                                    <div class="input_contenedor">
                                        <input id="Calle" name="Calle" type="number" placeholder="Calle">
                                        <p></p>
                                    </div>
                                    <div class="input_contenedor">
                                        <input id="Numero" name="Numero" type="number" placeholder="Numero">
                                        <p></p>
                                    </div>
                                    
                                    <div class="input_contenedor">
                                        <input id="Codigo_Postal" name="Codigo_Postal" type="number" placeholder="Codigo_Postal">
                                        <p></p>
                                    </div>
                                    <div class="input_contenedor">
                                        <input id="Telefono" name="Telefono" type="text" placeholder="Telefono">
                                        <p></p>
                                    </div>
                                    <div class="input_contenedor">
                                        <input id="DNI" name="DNI" type="text" placeholder="Documento">
                                        <p></p>
                                    </div>
                                    <div class="submit">
                                        <input type="submit" onclick="validarCampos()" value="Proceder al pago" name="enviar" class="button">
                                    </div>
                                </div>
                            </form>
                    </section>
            </div>
            <script src="js/ValidacionCarritoEnvio.js"></script>
                <script>
                    function getDireccionExistente() {
                        return document.getElementById('direccion_existente').value;
                    }

                    window.onload = function() {
                        var direccionExistente = getDireccionExistente();
                        if (direccionExistente) {
                            if (confirm("Ya tienes una dirección guardada:\n" + direccionExistente + "\n\n¿Deseas usar esta dirección?")) {
                                window.location.href = 'CarritoPago.php';
                            }
                        }
                    };
                </script>
            
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
            <script src="js/Validacion_CheckOut.js"></script>
        </body>
    </html>