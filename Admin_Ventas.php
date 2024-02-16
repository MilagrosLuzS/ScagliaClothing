<?php

    
    include('only_admin.php');
    
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Administrador - Ventas</title>
    <link rel="stylesheet" type="text/css" href="css/styles.css">
    <link rel="stylesheet" type="text/css" href="css/styles-administrador-ventas.css">

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
                    <a href="Admin_inicio.php"><li><img src = "Multimedia/iconos/user-24.png"></li></a>        
                    <a href="logout.php"><li><img src = "Multimedia/iconos/logout-24.png"></li></a>
                    </ul> 
                </nav>
            </section>
        </div>
        
        </header>

        <div class="titulo">
            <h1><strong>ADMINISTRADOR</strong></h1>
            <h2>VENTAS</h2>
        </div>

        <div class="about-flex">

            <div class="imagen">
                <ul>
                    <li><a href="Admin_Inicio.php">Inicio</a></li>
                    <li><a href="Admin_Productos.php">Productos</a></li>
                    <li><a href="Admin_Ventas.php">Ventas</a></li>
            </div>
        <div class="content">

        <ul>
    <?php
        include_once('bd.php');
        $conn = conectarBD();
        $query = "SELECT o.id AS order_id, o.date_time, u.id,u.user_name, o.total_price, i.product_id 
        FROM orders o
        JOIN user u ON o.id_user = u.id
        JOIN order_items i ON i.id_order = o.id 
        GROUP BY o.id";
        
        $result = mysqli_query($conn, $query);  

        if (mysqli_num_rows($result) > 0) {
            // Iterar sobre los resultados y generar un <li> para cada registro
            while ($row = mysqli_fetch_assoc($result)) {
    ?>
                <li>
                    <h2>ORDEN # <?= $row['order_id'] ?></h2>
                    <div class="flex-prod">

                        <div class="data">
                            <section class="flex-data">
                            <h3>Fecha y hora: </h3>
                                <p><?= $row['date_time'] ?></p>
                            </section>
                            <section class="flex-data">
                                <h3>Compra por:</h3>
                                <p><?= $row['user_name'] ?></p>
                            </section>

                            <?php
                            // Consulta para obtener los productos asociados a esta orden
                            $order_id = $row['order_id'];

                            $query_products = "SELECT p.product_name, oi.quantity, p.size
                            FROM order_items oi
                            JOIN product p ON oi.product_id = p.product_id
                            WHERE oi.id_order = $order_id AND p.size = oi.talle";
                            $result_products = mysqli_query($conn, $query_products);
                            echo '<section class="flex-data">';
                            echo '<h3>Items: </h3>';
                            echo '</section>';

                            // Iterar sobre los productos y mostrar cada uno como un elemento de lista
                            while ($product_row = mysqli_fetch_assoc($result_products)) {
                                echo '<section class="flex-data">';
                                echo '<p>' . $product_row['product_name'] . ' x ' . $product_row['quantity'] .  ' (' . $product_row['size'].')'. '</p>';
                                echo '</section>';
                                }
                            ?>

                        </div>

                        <div class="flex-btn">
                            <a href="Admin_Ventas_Details.php"><button class="button">Ver<br>detalle</button></a>
                        </div>
                    </div>
                </li>
    <?php
            }
        } else {
            // Si no hay registros en la tabla
            echo "No se encontraron registros en la tabla.";
        }

        // Cerrar la conexión a la base de datos
        desconectarBD($conn);
    ?>
</ul>
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