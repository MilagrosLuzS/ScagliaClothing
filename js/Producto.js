var id_producto,cantidad = 1, cantidad_max,talle;

function obtenerTalle() {
    var talleSeleccionado = document.querySelector('input[name="talle"]:checked');
    
    // Verificar si se ha seleccionado algún talle
    if (talleSeleccionado) {
        return talleSeleccionado.value;
    } else {
        // En caso de que no se haya seleccionado ningún talle
        return null; // O puedes devolver un valor predeterminado según tus necesidades
    }
}

function agregarProducto(){
    var data = new FormData();
    data.append("id_producto",id_producto);
    data.append("cantidad",cantidad);
    talle = obtenerTalle();
    while(talle==null){
        mostrarAlertaTalle();
        talle = obtenerTalle();
    }
    data.append("talle",talle);

    var xhr = new XMLHttpRequest();
    xhr.withCredentials = true;

    xhr.addEventListener("readystatechange",function(){
        if(xhr.readyState === XMLHttpRequest.DONE && xhr.status === 200){
            mostrarAlerta()
        }
    });

    xhr.open("POST","carrito.php");

    xhr.send(data);

}   

function mas(){
    cantidad+=1;
    if(cantidad>cantidad_max){
        cantidad = cantidad_max;
    }
    actualizarCantidad();
}

function menos(){
    cantidad-=1;
    if(cantidad<1){
        cantidad = 1;
    }
    actualizarCantidad();
}

function mostrarAlerta(){
    let alerta = document.getElementById("alerta");
    console.log("alerta")
    alerta.classList.remove("alerta-AC");
    setTimeout(()=>{alerta.classList.add("alerta-AC")},6000)
}

function actualizarCantidad(){
    let spanCantidad = document.getElementById("cantidad");
    spanCantidad.innerText = cantidad;
}