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
        $envio = $carrito["envio"];
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
        VALUES($usuario,CURRENT_TIMESTAMP,1,$importe,$id_direccion,$envio,'$titular','$tarjeta','$expiracion',$cvc)";
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