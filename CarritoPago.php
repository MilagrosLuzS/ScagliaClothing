<?php
    include('only_client.php');
    function traer_Productos_Carrito($id_carrito,$conn){
        $query = "SELECT product.price as precio,quantity as cantidad FROM cart_products JOIN product ON cart_products.product_id = product.product_id WHERE cart_id = $id_carrito GROUP BY product_name";
        $res = consultaSQL($conn,$query);
        if($res->num_rows < 1){
            $res = NULL;
        }
        return $res;
    }

    if($_SERVER['REQUEST_METHOD'] == 'POST'){
        include_once("bd.php");
        $conn = conectarBD();
        $usuario = $_SESSION["id"];
        // datos de pago
        $titular = $_POST["titular"];
        $tarjeta = $_POST["Numero_Tarjeta"];
        $expiracion = $_POST["Expiracion"];
        $cvc = $_POST["CVC"];
        //consigo el carrito
        $query = "SELECT * FROM cart WHERE user_id = $usuario";
        $result = consultaSQL($conn,$query);
        $carrito = $result->fetch_assoc();
        $id_carrito = $carrito["id"];
        //consigo la direccion
        $query = "SELECT id_adress FROM user_adress WHERE id_user = $usuario";
        $result = consultaSQL($conn,$query);
        $id_direccion = ($result->fetch_assoc())["id_adress"];
        //consigo el importe
        $importe = 0;
        $carrito_productos = traer_Productos_Carrito($id_carrito,$conn);
        while($carrito_producto = $carrito_productos->fetch_assoc()){
            $importe += $carrito_producto["precio"]*$carrito_producto["cantidad"];
        }
        //hago el pedido
        $query = "INSERT INTO orders(id_user,date_time,id_status,total_price,id_adress,id_shipping,cardholder,card,expiration,cvc) 
        VALUES($usuario,CURRENT_TIMESTAMP,1,$importe,$id_direccion,2,'$titular','$tarjeta','$expiracion',$cvc)";
        consultaSQL($conn,$query);
        $id_pedido = $conn->insert_id;
        //hago los pedidos de los productos
        $query = "INSERT INTO order_items(product_id, quantity, id_order, unit_price, total_price, talle) 
        SELECT cart_products.product_id, cart_products.quantity, $id_pedido as id_order, product.price as unit_price, (product.price * cart_products.quantity) as total_price, cart_products.talle
        FROM cart_products 
        JOIN product ON product.product_id = cart_products.product_id
        WHERE cart_products.cart_id = $id_carrito LIMIT 1;";
        consultaSQL($conn,$query);
        //bajo el stock
        $query = "SELECT * FROM cart_products WHERE cart_id = $id_carrito";
        $result = consultaSQL($conn,$query);
        while($row = $result->fetch_assoc()){
            $id_producto = $row["product_id"];
            $cantidad = $row["cantidad"];
            $talle = $row["talle"];
            $conn2 = conectarBD();
            $query2 = "UPDATE product SET stock = (product.stock - ".intval($cantidad).") WHERE product.product_id = $id_producto AND product.size = $talle";
            consultaSQL($conn2,$query2);
            desconectarBD($conn2); 
        }

        // elimino el carrito y los productos del carrito
        $query = "DELETE FROM cart_products WHERE cart_id = $id_carrito";
        consultaSQL($conn,$query);
        $query = "DELETE FROM cart WHERE id = $id_carrito";
        consultaSQL($conn,$query);

        desconectarBD($conn);
        header("Location: Pedido.php?id=$id_pedido");
    }
?>

<!DOCTYPE html>
    <html>  
        <head>
            <meta charset="UTF-8"/>
            <meta name="keywords" content="buzos,indumentaria,negro,minimalismo,basicos">
            <meta name="description" content="Apasionados del diseño. Elevamos básicos al siguiente nivel, vistiendo distinto.">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">

            <title>PAGO_CARRITO</title>

            <link rel="stylesheet" type="text/css" href="css/styles.css">
            <link rel="stylesheet" type="text/css" href="css/styles_carritoPago.css">
            <link rel="stylesheet" type="text/css" href="css/responsive.css">
            <script src="js/ValidacionCarritoPago.js"></script>
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
            <div class="general_Envio">
                <section class="register">
                    <form id="formulario" method="POST" action="">
                        <h1>Datos de pago</h1>
                        <div class="contenedor">
                            <p class="titulo_contenedor" style="color:black;text-align:start">Titular de la tarjeta</p>
                            <div class="input_contenedor">
                                <input id="titular"  name="titular" type="text" placeholder="Nombre del titular">
                                <p></p>
                            </div>
                            <P class="titulo_contenedor" style="color:black;text-align:start">Numero de la tarjeta</P>
                            <div class="input_contenedor">
                                <input id="Numero" name="Numero_Tarjeta" type="text" placeholder="1234-5678-9101-1121" maxlength="19">
                                <p></p>
                            </div>
                            <div class="importante">
                                <p class="titulo_contenedor" style="color:black;text-align:start">Fecha de expiracion</p>
                                <div class="input_contenedor">
                                    <input id="Expiracion" name="Expiracion" type="text" placeholder="MM/AA" maxlength="5">
                                    <p></p>
                                </div>
                                <P class="titulo_contenedor" style="color:black;text-align:start">CVC</P>
                                <div class="input_contenedor">
                                    
                                    <input id="CVC" name="CVC" type="number" placeholder="123" maxlength="3">
                                    <p></p>
                                </div>
                            </div>
                            
                            <div class="submit">
                                <input type="submit" onclick="validarCampos()" value="Confirmar Compra" name="enviar" class="button">
                            </div>
                        </div>
                    </form>
                </section>
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