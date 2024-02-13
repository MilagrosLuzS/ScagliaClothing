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
                <section id="checks">
                    <h2>Nombre</h2>
                    <input id="Nombre" value="<?= $row['product_name'] ?>" type="text" name="Nombre">
                </section>

                <section id="checks">
                    <h2>Tipo de producto</h2>
                    <select id="opcion" name="Tipo" value="<?= $row['type'] ?>">
                    <option value="Remera" <?php if ($row['type'] == 'Remera') echo 'selected'; ?>>Remera</option>
                    <option value="Buzo" <?php if ($row['type'] == 'Buzo') echo 'selected'; ?>>Buzo</option>
                    <option value="Otro" <?php if ($row['type'] == 'Otro') echo 'selected'; ?>>Otro</option>
                </select>
                    </select>
                </section>

                <section id="checks">
                    <h2>Precio</h2>
                    <input id="Precio" value="<?= $row['price'] ?>" type="number" name="Precio">
                </section>

                <section id="input_contenedor">
                    <h2>Talle</h2>
                    <input id="Talle" value="<?= $row['size'] ?>" type="text" name="Talles[]">
                </section>

                <section id="input_contenedor">
                    <h2>Colores</h2>
                    <label><input type="checkbox" value="Negro" name="Colores[]" <?php if (in_array('[Negro]', $colores_bd)) echo 'checked'; ?>>Negro</label>
                    <label><input type="checkbox" value="Gris" name="Colores[]" <?php if (in_array('[Gris]', $colores_bd)) echo 'checked'; ?>>Gris</label>
                    <label><input type="checkbox" value="Blanco" name="Colores[]" <?php if (in_array('[Blanco]', $colores_bd)) echo 'checked'; ?>>Blanco</label>
                
                </section>

                <section id="input_contenedor">
                    <h2>Stock</h2>
                    <input id="Stock" value="<?= $row['stock'] ?>" type="number" name="Stock">
                </section>

                <section id="input_contenedor">
                    <h2>Descripción</h2>
                    <textarea id="freeform" placeholder="<?= $row['description'] ?>" name="Descripcion" rows="4" cols="50"></textarea>
                </section>

                <section id="input_contenedor">
                    <h2>Imagen</h2>
                    <input type="file" id="imagen" name="Imagen">
                    
                </section>

                <br>

                <section class="submit">
                    <input value="Actualizar producto" class="button" type="submit" name="Guardar">
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
        echo "No se han recibido todos los campos necesarios del formulario";
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
    
                <script src="Validacion_Agregar_Producto.js"></script>
                
            </footer>
        </body>
</html>