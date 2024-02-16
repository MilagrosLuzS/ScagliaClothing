<?php 
include_once('bd.php');
include('only_client.php');
?>
<!DOCTYPE html>
    <html>  
        <head>
            <meta charset="UTF-8"/>
            <meta name="keywords" content="buzos,indumentaria,negro,minimalismo,basicos">
            <meta name="description" content="Apasionados del diseño. Elevamos básicos al siguiente nivel, vistiendo distinto.">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">

            <title>Pedidos</title>

            <link rel="stylesheet" type="text/css" href="css/styles.css">
            <link rel="stylesheet" type="text/css" href="css/styles-cuenta.css">
            <link rel="stylesheet" type="text/css" href="css/styles-cuenta-direc.css">
            <link rel="stylesheet" type="text/css" href="css/styles-pedidos.css">
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
                <?php
                    $conn = conectarBD();
                    // Verificar si el nombre de usuario está almacenado en la sesión
                    if(isset($_SESSION['user'])) {
                        // Consulta para obtener el ID del usuario
                        $query = "SELECT id FROM user WHERE email = '{$_SESSION['user']}'";
                        // Ejecutar la consulta
                        $resultado = mysqli_query($conn, $query);

                        // Verificar si se obtuvieron resultados
                        if (mysqli_num_rows($resultado) > 0) {
                            // Obtener el ID de usuario de la primera fila del resultado
                            $row = mysqli_fetch_assoc($resultado);
                            $idUsuario = $row['id'];
                        
                            // Consulta para obtener las órdenes del usuario
                            $query_orders = "SELECT * FROM orders WHERE id_user = $idUsuario";
                            // Ejecutar la consulta
                            $resultado_orders = mysqli_query($conn, $query_orders);

                            if (!$resultado_orders) {
                                die("Error al ejecutar la consulta: " . mysqli_error($conn));
                            }

                            // Verificar si se obtuvieron órdenes
                            if (mysqli_num_rows($resultado_orders) > 0) {
                    ?>
                                <h2>MIS PEDIDOS</h2>
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
                                    <div class="tablas">
                                        <section class="Remeras">
                                            <table>
                                                <thead>
                                                    <tr>
                                                        <th>Orden</th>
                                                        <th>Fecha</th>
                                                        <th>Articulos</th>
                                                        <th>Total</th>
                                                        <th>Estado</th>
                                                        <th class="botondis"></th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                    <?php
                                // Iterar sobre cada orden y mostrarla en una fila de la tabla
                                while ($row_order = mysqli_fetch_assoc($resultado_orders)) {
                    ?>

                            <tr>
                                <td>#<?= $row_order['id'] ?></td>
                                <td><?= $row_order['date_time'] ?></td>
                                <?php
                            // Consulta para obtener los productos asociados a esta orden
                            $order_id = $row_order['id'];

                            $query_products = "SELECT p.product_name, oi.quantity, p.size
                            FROM order_items oi
                            JOIN product p ON oi.product_id = p.product_id
                            WHERE oi.id_order = $order_id AND p.size = oi.talle";
                            $result_products = mysqli_query($conn, $query_products);
                            
                            // Iterar sobre los productos y mostrar cada uno como un elemento de lista
                            echo('<td>');
                            while ($product_row = mysqli_fetch_assoc($result_products)) {
                                echo ''. $product_row['product_name'] . ' X ' . $product_row['quantity'] .  ' (' . $product_row['size'].')'.'<br>';
                            }

                            echo('</td>');
                            ?>
                                <td>$<?= $row_order['total_price'] ?></td>

                                <?php
                            $order_id = $row_order['id'];

                            $query_envio = "SELECT o.id_status, st.description
                            FROM orders o
                            JOIN status st ON o.id_status = st.id";
                            $result_envio = mysqli_query($conn, $query_envio);

                            if ($result_envio && mysqli_num_rows($result_envio) > 0) {
                                $envio_row = mysqli_fetch_assoc($result_envio);
                                echo '<td>' . $envio_row['description'] . '</td>';
                                echo '<td><button class="button" onclick="window.location.href=\'Pedido.php?id=' . $row_order['id'] . '\';">Detalle</button></td>';
                            } else {
                                echo '<td>Error al obtener información de estado</td>';
                            }
                            
                            ?>
                                
                                <!-- <td class="agregar"><button>Cancelar</button></td> -->
                            </tr>
                            
                    <?php
                                }
                    ?>
                                                </tbody>
                                            </table>
                                            
                                        </section>
                                        
                                    </div>
                                    
                                </div>
                                
                    <?php
                            } else {
                                // Si el usuario no tiene órdenes, mostrar un mensaje
                                // echo "<a href='login.php'><p>Inicia sesión para ingresar a tu cuenta</p></a>";
                                echo "NO TENES NINGUN PEDIDO REGISTRADO HASTA EL MOMENTO.";
                            }
                        }
                    }
                    ?>
                


            <footer>
                <div class = "flex-footer">
 
                        <section class="flex-iso">
                            <a href="index.html"><img src="Multimedia\Recursos\Version negativo\Recurso 14.png" alt="loading..."></a>
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