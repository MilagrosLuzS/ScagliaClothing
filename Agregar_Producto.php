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