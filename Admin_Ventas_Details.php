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
    <link rel="stylesheet" type="text/css" href="css/styles-pedidos.css">
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

        <div class="content">

            <ul>
            <?php
        include_once('bd.php');
        $conn = conectarBD();
        $query = "SELECT o.id AS order_id, o.date_time, u.id,u.user_name,u.email, o.total_price, i.product_id,a.street,a.st_number,a.city,a.zip
        FROM orders o
        JOIN user u ON o.id_user = u.id
        JOIN order_items i ON i.id_order = o.id
        JOIN adress a ON o.id_adress = a.id
        GROUP BY o.id";
        $respuesta = consultaSQL($conn, $query);
        $result = mysqli_query($conn, $query);  

        if (mysqli_num_rows($result) > 0) {
            // Iterar sobre los resultados y generar un <li> para cada registro
            while ($row = mysqli_fetch_assoc($result)) {
    ?>
                <li>
                    <h2>ORDEN #<?= $row['order_id'] ?></h2>
              
                    <div class="about-flex">

                        <div class="tablas">
                            <section class="Remeras">
                                <table>
                                    <thead>
                                        <tr>
                                            <th>Fecha</th>
                                            <th>Comprador</th>
                                            <th>Artículos</th>
                                            <th>Total</th>
                                            <th>Estado</th>
                                            <th>Envío</th>
                                            <th>Contacto</th>
                                        </tr>
                                    </thead>
                                    <tr>
                                        <td><?= $row['date_time'] ?></td>
                                        <td><?= $row['user_name'] ?><br><?= $row['email'] ?><br><?= $row['street'] ?><?=' '. $row['st_number'] ?><br> <?= $row['city'] ?><br><?= $row['zip'] ?></td>
                                        
                                        <?php
                            // Consulta para obtener los productos asociados a esta orden
                            $order_id = $row['order_id'];

                            $query_products = "SELECT p.product_name, oi.quantity, p.size
                            FROM order_items oi
                            JOIN product p ON oi.product_id = p.product_id
                            WHERE oi.id_order = $order_id AND p.size = oi.talle";
                            $result_products = mysqli_query($conn, $query_products);
                            
                            
                            // Iterar sobre los productos y mostrar cada uno como un elemento de lista
                            echo('<td>');
                            while ($product_row = mysqli_fetch_assoc($result_products)) {
                                echo ''. $product_row['product_name'] . ' x ' . $product_row['quantity'] .  ' (' . $product_row['size'].')'.'<br>';
                            }

                            echo('</td>');
                            ?>
                                        
                                        
                            <td>$<?= $row['total_price'] ?></td>
                            

                            <?php
                            $order_id = $row['order_id'];

                            $query_envio = "SELECT s.description AS shipd, st.description
                                            FROM orders o
                                            JOIN shipping s ON o.id_shipping = s.id
                                            JOIN status st ON o.id_status = st.id";
                            $result_envio = mysqli_query($conn, $query_envio);

                            if ($result_envio && mysqli_num_rows($result_envio) > 0) {
                                $envio_row = mysqli_fetch_assoc($result_envio);
                                
                                echo '<td>
                                <form id="formulario" action="#" method="post" enctype="multipart/form-data">
                                <input type="hidden" name="id_orden" value="'.$order_id.'">
                                <select name="status" id="opciones">';

                                $query_form = "SELECT description FROM status";
                                $result_form = mysqli_query($conn, $query_form);

                                if ($result_form && mysqli_num_rows($result_form) > 0) {
                                    // Iterar sobre los resultados y generar un <option> para cada registro
                                    while ($row = mysqli_fetch_assoc($result_form)) {
                                        // Verificar si la opción actual es la que debe estar seleccionada
                                        $selected = ($row['description'] == $envio_row['description']) ? 'selected' : '';
                                        echo '<option value="'.$row['description'].'" '.$selected.'>'.$row['description'].'</option>';
                                    }
                                    echo '
                                    <section class="submit">
                                    <input value="Cambiar" class="button" type="submit" name="Guardar">
                                    </section></select>
                                    </form>
                                    </td>';


                                    if ($_SERVER["REQUEST_METHOD"] == "POST") {
                                        // Verifica si se han recibido todos los campos necesarios del formulario
                                        if (isset($_POST['id_orden'], $_POST['status'])) {
                                    
                                            $orden = $_POST['id_orden']; // Asegúrate de recibir el ID del producto a actualizar
                                            $status = $_POST['status'];
                                            
                                            $query_boton = "SELECT id,description FROM status WHERE description = '$status'";
                                            $result_boton = mysqli_query($conn, $query_boton);

                                            if ($result_boton && mysqli_num_rows($result_boton) > 0) {
                                                $envio_row = mysqli_fetch_assoc($result_boton);
                                            
                                                $status_id = $envio_row['id'];

                                            }


                                            $queryup = "UPDATE orders SET 
                                                      id_status = '$status_id' 
                                                      WHERE id = $orden";
                                    
                                            if (mysqli_query($conn, $queryup)) {
                                                echo "<script>alert('Status actualizado correctamente.'); window.location = 'Admin_Ventas_Details.php';</script>";
                                            } else {
                                                echo "<script>alert('Error al actualizar el status: ')".mysqli_error($conn)."; window.location = 'Admin_Ventas_Details.php';</script>";
                                            }
                                            
                                        } else {
                                            echo "No se han recibido todos los campos necesarios del formulario";
                                        }
                                    }

                                    echo '<td>' . $envio_row['shipd'] . '</td>';    
                                 
                                } else {
                                    echo '<td>Error al obtener información de envío</td>';
                                    echo '<td>Error al obtener información de estado</td>';
                                }
                            }
                            ?>
                            <td><a href="mailto:<?= $row['email'] ?>?Subject=Scaglia%20Clothing"><p>Contactar</p></a></td>
                                    </tr>
    
                                </table>
                            </section>
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