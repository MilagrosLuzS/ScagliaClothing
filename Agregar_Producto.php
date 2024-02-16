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

            <title>Agregar producto</title>

            <link rel="stylesheet" type="text/css" href="css/styles.css">
            <link rel="stylesheet" type="text/css" href="css/styles-cuenta.css">
            <link rel="stylesheet" type="text/css" href="css/styles-admin-agregar-prod.css">
            <link rel="stylesheet" type="text/css" href="css/responsive.css">
            <script src="js/Validacion_Agregar_Producto.js"></script>
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
                <h2>AGREGAR PRODUCTO</h2>
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
                <h2>AGREGAR NUEVO PRODUCTO</h2>
                </section>    

                <section> 
    <form id="formulario" action="#" method="post" enctype="multipart/form-data">
        <section class="input_contenedor">
            <h2>Nombre</h2>
            <input id="Nombre" type="text" name="Nombre">
            <p></p>
        </section>

        <section id="checks">
            <h2>Tipo de producto</h2>
            <select id="opcion" name="Tipo">
                <option value="Remera">Remera</option>
                <option value="Buzo">Buzo</option>
                <option value="Otro">Otro</option>
            </select>
            <p></p>
        </section>

        <section class="input_contenedor">
            <h2>Precio</h2>
            <input id="Precio" type="number" name="Precio">
            <p></p>
        </section>

        <section class="input_contenedor">
            <h2>Talle</h2>
            <input id="Talle" type="text" name="Talles[]">
            <p></p>
        </section>

        <section class="input_contenedor">
            <h2>Colores</h2>
            <label><input id="Color1" type="checkbox" value="Negro" name="Color1">Negro</label>
            <label><input id="Color2" type="checkbox" value="Gris" name="Color2">Gris</label>
            <label><input id="Color3" type="checkbox" value="Blanco" name="Color3">Blanco</label>
            <p></p>
        </section>

        <section class="input_contenedor">
            <h2>Stock</h2>
            <input id="Stock" type="number" name="Stock">
            <p></p>
        </section>

        <section class="input_contenedor">
            <h2>Descripción</h2>
            <input id="freeform" name="Descripcion" rows="4" cols="50"></input>
            <p></p>
        </section>

        <section class="input_contenedor">
            <h2>Imagen</h2>
            <input type="file" id="imagen" name="Imagen">
            <p></p>
        </section>

        <br>

        <section class="submit">
            <input value="Guardar producto" onclick="validarCampos()" class="button" type="submit" name="Guardar">
        </section>
    </form>
</section>

<?php
    include_once('bd.php');

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Verifica si se han recibido todos los campos necesarios del formulario
        if (isset($_POST['Nombre'], $_POST['Tipo'], $_POST['Precio'], $_POST['Talles'], $_POST['Colores'], $_POST['Descripcion'], $_FILES['Imagen'])) {
            $conn = conectarBD();

            $nombre = $_POST['Nombre'];
            $tipo = $_POST['Tipo'];
            $precio = $_POST['Precio'];
            $talles = $_POST['Talles']; 
            $colores = !empty($_POST['Colores']) ? implode(",", $_POST['Colores']) : "";
            $stock = isset($_POST['Stock']) ? $_POST['Stock'] : 0;
            $descripcion = $_POST['Descripcion'];

            // Procesar la imagen
            $imagen_nombre = $_FILES['Imagen']['name'];
            $imagen_destino = "Multimedia/Fotos_Producto/Fotos_C/" . $imagen_nombre; 
            move_uploaded_file($_FILES['Imagen']['tmp_name'], $imagen_destino); //mueve la imagen y la guarda en mi carpeta

            // Busco el product id
            $product_id = null;

            // Buscar si existe un producto con el mismo nombre
            $query_search = "SELECT product_id FROM product WHERE product_name = '[$nombre]'";
            $result_search = mysqli_query($conn, $query_search);

            if (mysqli_num_rows($result_search) > 0) {
                // Si existe un producto con el mismo nombre, obtener su product_id
                $row = mysqli_fetch_assoc($result_search);
                $product_id = $row['product_id'];
            } else {
                // Si no existe un producto con el mismo nombre, encontrar el máximo product_id y sumarle uno
                $query_max = "SELECT MAX(product_id) AS max_id FROM product";
                $result_max = mysqli_query($conn, $query_max);
                $row_max = mysqli_fetch_assoc($result_max);
                $product_id = $row_max['max_id'] + 1;
            }

            $query = "INSERT INTO product (product_name, type, color, size, stock, description, img, price, product_id) 
                    VALUES ('[$nombre]', '$tipo', '[$colores]', '$talles', '$stock', '$descripcion', '$imagen_destino', '$precio', '$product_id')";
            
            $query2 = "INSERT INTO product_images (product_id,image) VALUES ('$product_id','$imagen_destino')";

        
            if (mysqli_query($conn, $query) && mysqli_query($conn, $query2)) {
                echo "<script>alert('Producto agregado correctamente.'); window.location = 'Agregar_Producto.php';</script>";
            } else {
                echo "<script>alert('Error al agregar el producto: ".mysqli_error($conn)."'); window.location = 'Agregar_Producto.php';</script>";
            }
            
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
    
                
                
            </footer>
        </body>
</html>