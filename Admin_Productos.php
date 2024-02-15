<?php

    
    include('only_admin.php');
    
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Administrador - Productos</title>
    <link rel="stylesheet" type="text/css" href="css/styles.css">
    <link rel="stylesheet" type="text/css" href="css/styles-administrador-productos.css">
    <script>
        function confirmarEliminacion() {
            // Mostrar un cuadro de diálogo de confirmación al usuario
            var confirmacion = confirm("¿Estás seguro de que quieres eliminar este producto?");       
            return confirmacion;
            
        }
    </script>

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
            <h2>PRODUCTOS</h2>
            <div>
                <a href="Agregar_Producto.php"><button class="button">Agregar nuevo producto</button></a>
                
        </div>
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
        $query = "SELECT id,product_name,color,size,stock,price,img
        FROM product
        ";
        $result = mysqli_query($conn, $query);  

        if (mysqli_num_rows($result) > 0) {
            // Iterar sobre los resultados y generar un <li> para cada registro
            while ($row = mysqli_fetch_assoc($result)) {
    ?>
                <li>
                    <h2><?= $row['product_name'] ?></h2>
                    <div class="flex-prod">
                            <img class="img-prod" src="<?= $row['img'] ?>">
                            
                            <div class="data">
                            <section class="flex-data">
                                <h3>Talle:</h3>
                                <p><?= $row['size'] ?></p>
                            </section>
                            <section class="flex-data">
                                <h3>Stock:</h3>
                                <p><?= $row['stock'] ?></p>
                            </section>
                            <section class="flex-data">
                                <h3>Precio:</h3>
                                <p>$<?= $row['price'] ?></p>
                            </section>
                            </div>

                            <div class="flex-btn">
                            <a href="editar_producto.php?id=<?= $row['id'] ?>"><button class="button">Editar</button></a>
                            </div>
                            <div class="flex-btn">
                            <form id="form_eliminar_producto" action="#" method="post" onsubmit="return confirmarEliminacion()">

                                <!-- Campo oculto para almacenar el ID del producto -->
                                <input type="hidden" id="id_producto" name="id" value="<?= $row['id'] ?>">
                                
                                <!-- Botón para eliminar el producto -->
                                <button class ="button" type="submit" name="eliminar_producto"">Eliminar producto</button>
                                
                            </form>
                            <div>
                            <?php
                            // Verificar si se ha enviado el formulario para eliminar el producto
                            if (isset($_POST['eliminar_producto'])) {
                                
                                // Obtener el ID del producto a eliminar desde el formulario
                                $id_producto = $_POST['id'];

                                // Construir la consulta SQL para eliminar el producto con el ID proporcionado
                                $query = "DELETE FROM product WHERE id = '$id_producto'";

                                // Ejecutar la consulta
                                if (mysqli_query($conn, $query)) {
                                    // La eliminación fue exitosa
                                    echo "<script>alert('Producto eliminado correctamente.');; window.location = 'Admin_Productos.php';</script>";
                                    exit(); // Detener la ejecución del script para evitar cualquier otro contenido que pueda causar problemas
                                } else {
                                    // Ocurrió un error durante la eliminación
                                    echo "<script>alert('Error al eliminar el producto':".mysqli_error($conn).");; window.location = 'Admin_Productos.php';</script>";
                                    exit(); // Detener la ejecución del script para evitar cualquier otro contenido que pueda causar problemas
                                }

                            } 
                            ?>

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