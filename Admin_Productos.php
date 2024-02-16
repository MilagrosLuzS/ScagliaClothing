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