<?php
function main(){
    // las variables con los datos de la conexión
    $servername = "localhost";   // direccion del servidor
    $username = "root";          // usuario
    $password = "";              // contraseña
    $dbname = "ubicacion";       // nombre de la base de datos

    // Crear conexión
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Checkear conexión
    if ($conn->connect_error) {
        die("Conexion fallida: " . $conn->connect_error);
    } 
    echo "Conexion EXISTOSA";

    // sql crear la consulta
    $sql = "select * from pais";
    //$sql = "select * from departamento where idprovincia=1";
    $result = $conn->query($sql);
    
    // Armar una tabla html con los datos del resultado de la consulta
    $tabla="";
    if ($result->num_rows > 0) {     // Si cantidad de filas es mayor a cero
        //$tabla = $tabla .  "<table><tr><th>ID</th><th>Nombre</th></tr>";  // Si se descomenta, entonces imprime los titulos
    	$tabla = $tabla .  "<table>";		
        while($row = $result->fetch_assoc()) {    	
            $tabla = $tabla . "<tr><td>".$row["id"]."</td><td>".$row["nombre"]."</td></tr>";
        }
    } 
    else {  
        $tabla = "0 results";
    }
    // imprimir la tabla html con el contenido de la consulta
    echo $tabla;

    // cerrar conexión
    $conn->close();    
}   
main();

?>



<!--
    // COMENTARIOS ...
    die();
    echo("<br/>");
    echo($result->num_rows);           // cantidad de filas que trae la consulta
    echo("<br/>");

    echo("<br/>");
    var_dump ($result);                // imprime el objeto "Como cuando hacemos un print e un Dict en python"
    echo("<br/>");

    var_dump ($result->fetch_assoc());
    echo("<br/>");
    var_dump ($result->fetch_assoc());
    

-->