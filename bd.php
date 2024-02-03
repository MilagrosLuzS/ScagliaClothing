<?php
    function conectarBD(){
    
        $servername = "localhost";   // direccion del servidor
        $username = "root";          // usuario
        $password = "";              // contraseña
        $dbname = "scagliaclothingbd";       // nombre de la base de datos

        // Crear conexión
        $conn = new mysqli($servername, $username, $password, $dbname);

        // Checkeo conexion
        if($conn->connect_error){
            die("Conexion fallida: ".$conn->connect_error);
        }
        return $conn;
  
    }   
    function consultaSQL($conn, $sql)
    {
        $result = $conn->query($sql);
        return $result;
    }

    function desconectarBD($conn)
    {
        // cerrar conexión
        $conn->close();
    }
    
?>