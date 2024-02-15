<?php
    include('bd.php');
    session_start();
    include('only_client.php');
?>
<!DOCTYPE html>
    <html>  
        <head>
            <meta charset="UTF-8"/>
            <meta name="keywords" content="buzos,indumentaria,negro,minimalismo,basicos">
            <meta name="description" content="Apasionados del diseño. Elevamos básicos al siguiente nivel, vistiendo distinto.">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">

            <title>Detalles de la cuenta</title>

            <link rel="stylesheet" type="text/css" href="css/styles.css">
            <link rel="stylesheet" type="text/css" href="css/styles-cuenta-direc-a.css">
            <link rel="stylesheet" type="text/css" href="css/styles-cuenta">
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
                <h1><strong>MI CUENTA</strong></h1>
                <h2>DETALLES DE LA CUENTA</h2>
            </div>

            <div class="about-flex">

                <div class="imagen">
                    <ul>
                    <li><a href="Mi_Cuenta.php">Escritorio</a></li>
                    <li><a href="Pedidos.php">Pedidos</a></li>
                    <li><a href="Direcciones.php">Dirección</a></li>
                    <li><a href="Details.php">Detalles de la cuenta</a></li>
                    <li><a href="Wishlist.php">Lista de deseos</a></li>
                    <li><a>Salir</a></li>
                    </ul>
                </div>
            <div class="content"> 
                    <section class="flex-dir">
                        <h2>Cambio de contraseña</h2>
                    </section>
                    <form  id="formulario" action="#" method="post" enctype="application/x-www-form-urlencoded">
                        <div class="input_contenedor">
                            <h2>Actual contraseña</h2>
                            <input id="PasActual" type="password" name="PasActual">
                            <p></p>
                        </div>
                        <div class="input_contenedor">
                            <h2>Nueva <br> contraseña</h2>
                            <input id="PasNueva" type="password" name="PasNueva">
                            <p></p>
                        </div>
                        <div class="input_contenedor">
                            <h2>Confirmar <br> nueva contraseña</h2>
                            <input id="PasConfirm" type="password" name="PasConfirm">
                            <p></p>
                        </div>
    
                        <section class="submit">
                            <input value="Guardar" class="button" type="submit" name="Guardar">
                        </section>
                    </form>
                       
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
            <script src="js/Validacion_Cambio_Contraseña.js"></script>
        </body>
    </html>