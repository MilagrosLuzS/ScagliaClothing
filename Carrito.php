<?php
    include('only_client.php');

    function traerCarrito($email,$conn){
        $query = "SELECT cart.*,user.email FROM cart JOIN user ON cart.user_id = user.id WHERE user.email = '$email'";
        $res = consultaSQL($conn,$query);
        if($res->num_rows < 1){
            $res = null;
        }
        return $res;
    }

    function traerProductosCarrito($id_carrito,$conn){
        $query = "SELECT cart_products.*,product.product_name as title, product.price as precio, 
        (SELECT image FROM product_images WHERE product_images.product_id = cart_products.product_id LIMIT 1) as src 
        FROM cart_products JOIN product ON cart_products.product_id = product.product_id AND cart_products.talle = product.size WHERE cart_id = $id_carrito;";
        $res = consultaSQL($conn,$query);
        if($res->num_rows < 1){
            $res = NULL;
        }
        return $res;
    }
    
    if($_SERVER['REQUEST_METHOD']==='POST'){
        include_once('bd.php');
        $conn = conectarBD();
        //me fijo si hay que eliminar un producto del carrito
        if(isset($_POST["id_eliminar"])){
            $id_eliminar = $_POST["id_eliminar"];
            $query = "DELETE FROM cart_products WHERE id = $id_eliminar";
            consultaSQL($conn,$query);
        }
        else{
            $id_producto = $_POST["id_product"];
            $cantidad = $_POST["quantity"];
            $talle = $_POST["talle"];
            $email = $_SESSION["user"];
            $result = traerCarrito($email,$conn);
            $carrito = NULL;
            // Si no existe el carrito, lo creo
            if($result->num_rows==0){
                $query = "INSERT INTO cart(user_id,fecha) VALUES ((SELECT id FROM user WHERE email = '$email'),CURRENT_TIMESTAMP)";
                $result2 = consultaSQL($conn,$query);
                // una vez creado, lo traigo
                $result3 = traerCarrito($email,$conn);
                $carrito = $result3->fetch_assoc();
            }
            else{
                $carrito = $result->fetch_assoc();
            }
            if($carrito){
                $id_carrito = $carrito["id"];
                //una vez que tengo el carrito me fijo si ya existe el mismo producto con mismo talle
                $query = "SELECT id FROM cart_products WHERE cart_id = $id_carrito AND product_id = $id_producto AND talle = $talle";
                $result = consultaSQL($conn,$query);
                if($result->num_rows == 0){
                    //si no existe agrego la cantidad dada por el cliente
                    $query = "INSERT INTO cart_products(cart_id,product_id,talle,quantity) VALUES ($id_carrito,$id_producto,$talle,$cantidad)";
                    consultaSQL($conn,$query);
                }
                else{
                    //si existe cambio la cantidad a lo que me dieron en el post
                    $query = "UPDATE cart_products SET quantity = $cantidad WHERE cart_id = $id_carrito AND product_id = $id_producto AND talle = $talle";
                    consultaSQL($conn,$query);
                }
            }
        }
    }
?>
<!DOCTYPE html>
    <html>  
        <head>
            <meta charset="UTF-8"/>
            <meta name="keywords" content="buzos,indumentaria,negro,minimalismo,basicos">
            <meta name="description" content="Apasionados del diseño. Elevamos básicos al siguiente nivel, vistiendo distinto.">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">

            <title>CARRITO</title>

            <link rel="stylesheet" type="text/css" href="css/styles.css">
            <link rel="stylesheet" type="text/css" href="css/styles-carrito.css">
            <link rel="stylesheet" type="text/css" href="css/responsive.css">
            <script src="js/carrito.js"></script>
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
                <h1><strong>TU CARRITO</strong></h1>
            </div>
            
                    <?php
                        include_once("bd.php");
                        $conn = conectarBD();
                        $carrito = traerCarrito($_SESSION["user"],$conn);
                        if(!empty($carrito)){
                            $carrito = $carrito->fetch_assoc();
                            $carrito_productos = traerProductosCarrito($carrito["id"],$conn);
                        }
                        else{
                            $carrito_productos = null;
                        }
                        if(!empty($carrito) && !empty($carrito_productos)){
                            $subtotal = 0;
                            echo('
                                <div class="gral">
                                <div class="contenedor" id="productos">
                            ');
                            while($carrito_producto = $carrito_productos->fetch_assoc()){
                                echo('
                                <section class="pedido" id="carrito_producto_'.$carrito_producto["id"].'" precio="'.$carrito_producto["precio"]*$carrito_producto["quantity"].'">
                                    <div class="producto_user">
                                        <img src="'.$carrito_producto["src"].'"/>
                                        <div class="data_product">
                                            <h3>'.$carrito_producto["title"].'</h3>
                                            <h4>$'.$carrito_producto["precio"].'</h4>
                                            <h3>Cantidad = '. $carrito_producto["quantity"].'</h3>
                                        </div>
                                    </div>
                                    <div class="subtotal">
                                        <div class = "precio-unitario" >
                                            <h3>Subtotal</h3>
                                            <h4>$'.$carrito_producto["precio"]*$carrito_producto["quantity"].'</h4>
                                        </div>
                                        <div class="bot-elim">
                                            <button class="eliminar" onclick="eliminarProductoCarrito('.$carrito_producto["id"].')">Eliminar</button>
                                        </div>
                                    </div>
                                </section>');
                                $subtotal+=$carrito_producto["precio"]*$carrito_producto["quantity"];
                            }
                            echo('</div>
                            </div>');
                            echo('<div class="fijo">
                                <div class="total" >
                                    <h3>Total</h3>
                                    <h4 id="precioTotal" precio="'.$subtotal.'">$'.$subtotal.'</h4>
                                </div>
                                <div class="submit">
                                    <a href="CarritoEnvio.php"><input type="submit" value="Finalizar Compra" class="button"></a>
                                </div>
                            </div>');
                        }
                        else{
                            echo("<div class='no-prod'>
                                    <h3>No hay productos en tu carrito.</h3>
                                </div>");
                        }
                        echo('</div>
                        </div>');
                    ?>
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