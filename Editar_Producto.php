<?php

    include('only_admin.php');
    
?>
<!DOCTYPE html>
    <html>  
        <head></head>
            <meta charset="UTF-8"/>
            <meta name="keywords" content="buzos,indumentaria,negro,minimalismo,basicos">
            <meta name="description" content="Apasionados del diseño. Elevamos básicos al siguiente nivel, vistiendo distinto.">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">

            <title>Editar producto</title>

            <link rel="stylesheet" type="text/css" href="css/styles.css">
            <link rel="stylesheet" type="text/css" href="css/styles-cuenta.css">
            <link rel="stylesheet" type="text/css" href="css/styles-admin-agregar-prod.css">
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
                    <a href="Admin_inicio.php"><li><img src = "Multimedia/iconos/user-24.png"></li></a>        
                    <a href="logout.php"><li><img src = "Multimedia/iconos/logout-24.png"></li></a>
                    </ul> 
                    </nav>
                </section>
            </div>
            
            </header>

            <div class="titulo">
                <h1><strong>ADMINISTRADOR</strong></h1>
                <h2>EDITAR PRODUCTO</h2>
            </div>

            <div class="about-flex">

                <div class="imagen">
                    <ul>
                        <li><a href="Admin_Inicio.php">Inicio</a></li>
                        <li><a href="Admin_Productos.php">Productos</a></li>
                        <li><a href="Admin_Ventas.php">Ventas</a></li>
                    </ul>
                </div>
            <div class="content">
                <section class="flex-dir">
                <h2>EDITAR PRODUCTO</h2>
                </section>    

                <section> 
    
</section>  

<?php
include_once('bd.php');

if (isset($_GET['id'])) {
    // Obtener el ID del producto de la URL
    $id_producto = $_GET['id'];
    $conn = conectarBD();
    

     $query = "SELECT id,product_name,type,price,color,size,stock,description,img FROM product WHERE id = $id_producto";
     $resultado = mysqli_query($conn, $query);

     if($resultado){
        // Obtener la fila del resultado como un array asociativo
        $row = mysqli_fetch_assoc($resultado);
        $colores_bd = explode(',', $row['color']);


    ?>
                <form id="formulario" action="#" method="post" enctype="multipart/form-data">
                <input type="hidden" name="id" value="<?= $id_producto ?>">
                <section class="input_contenedor">
                    <h2>Nombre</h2>
                    <input id="Nombre" value="<?= $row['product_name'] ?>" type="text" name="Nombre">
                    <p></p>
                </section>

                <section class="input_contenedor">
                    <h2>Tipo de producto</h2>
                    <select id="opcion" name="Tipo" value="<?= $row['type'] ?>">
                    <option value="Remera" <?php if ($row['type'] == 'Remera') echo 'selected'; ?>>Remera</option>
                    <option value="Buzo" <?php if ($row['type'] == 'Buzo') echo 'selected'; ?>>Buzo</option>
                    <option value="Otro" <?php if ($row['type'] == 'Otro') echo 'selected'; ?>>Otro</option>
                    <p></p>
                </select>
                    </select>
                </section>

                <section class="input_contenedor">
                    <h2>Precio</h2>
                    <input id="Precio" value="<?= $row['price'] ?>" type="number" name="Precio">
                    <p></p>
                </section>

                <section class="input_contenedor">
                    <h2>Talle</h2>
                    <input id="Talle" value="<?= $row['size'] ?>" type="text" name="Talles[]">
                    <p></p>
                </section>

                <section class="input_contenedor">
                    <h2>Colores</h2>
                    <label><input id="Color1" type="checkbox" value="Negro" name="Colores[]" <?php if (in_array('[Negro]', $colores_bd)) echo 'checked'; ?>>Negro</label>
                    <label><input id="Color2" type="checkbox" value="Gris" name="Colores[]" <?php if (in_array('[Gris]', $colores_bd)) echo 'checked'; ?>>Gris</label>
                    <label><input id="Color3" type="checkbox" value="Blanco" name="Colores[]" <?php if (in_array('[Blanco]', $colores_bd)) echo 'checked'; ?>>Blanco</label>
                    <p></p>
                </section>

                <section class="input_contenedor">
                    <h2>Stock</h2>
                    <input id="Stock" value="<?= $row['stock'] ?>" type="number" name="Stock">
                    <p></p>
                </section>

                <section class="input_contenedor">
                    <h2>Descripción</h2>
                    <input id="freeform" value="<?= $row['description'] ?>" name="Descripcion" rows="4" cols="50"></input>
                    <p></p>
                </section>
                <section class="input_contenedor">
                    <h2>Imagen</h2>
                    <input type="file" id="imagen" name="Imagen">
                    <p></p>
                </section>

                <br>

                <section class="submit">
                    <input value="Actualizar producto" onclick=validarCampos() class="button" type="submit" name="Guardar">
                </section>
            </form>

    
<?php 
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Verifica si se han recibido todos los campos necesarios del formulario
    if (isset($_POST['id'], $_POST['Nombre'], $_POST['Tipo'], $_POST['Precio'], $_POST['Talles'], $_POST['Colores'], $_POST['Descripcion'], $_FILES['Imagen'])) {
        $conn = conectarBD();

        $id_producto = $_POST['id']; // Asegúrate de recibir el ID del producto a actualizar
        $nombre = $_POST['Nombre'];
        $tipo = $_POST['Tipo'];
        $precio = $_POST['Precio'];
        $talles = !empty($_POST['Talles']) ? implode(",", $_POST['Talles']) : "";
        $colores = !empty($_POST['Colores']) ? implode(",", $_POST['Colores']) : "";
        $stock = isset($_POST['Stock']) ? $_POST['Stock'] : 0;
        $descripcion = $_POST['Descripcion'];

        // Procesar la imagen

        if ($_FILES['Imagen']['size'] > 0) {
            // Procesar y guardar la nueva imagen
            $imagen_nombre = $_FILES['Imagen']['name'];
            $imagen_destino = "Multimedia/Fotos_Producto/Fotos_C/" . $imagen_nombre;
            move_uploaded_file($_FILES['Imagen']['tmp_name'], $imagen_destino);
        } else {
            // Si no se ha subido una nueva imagen, mantener la imagen existente en la base de datos
            $imagen_destino = $row['img']; // $row['img'] es la ruta de la imagen actual en la base de datos
        }

        $query = "UPDATE product SET 
                  product_name = '$nombre', 
                  type = '$tipo', 
                  color = '[$colores]', 
                  size = '$talles', 
                  stock = '$stock', 
                  description = '$descripcion', 
                  img = '$imagen_destino', 
                  price = '$precio' 
                  WHERE id = $id_producto";

        if (mysqli_query($conn, $query)) {
            echo "<script>alert('Producto actualizado correctamente.'); window.location = 'Editar_Producto.php?id=$id_producto';</script>";
        } else {
            echo "<script>alert('Error al actualizar el producto: ')".mysqli_error($conn)."; window.location = 'Editar_Producto.php?id=$id_producto';</script>";
        }
        
    } else {
        echo "<p style=\"color: red;\"> No se han recibido todos los campos necesarios del formulario</p>";
    }
}
    } else {
        echo "ID del producto no proporcionado.";
        desconectarBD($conn);
    }
}


?>
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
    
                <script src="js/Validacion_Editar_Producto.js"></script>
                
            </footer>
        </body>
</html>