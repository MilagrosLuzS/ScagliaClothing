var id_producto,cantidad = 1,cantidad_max,talle;

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
    data.append("id_product",id_producto);
    data.append("quantity",cantidad);
    talle = obtenerTalle();
    if(talle==null){
        window.alert("INGRESE UN TALLE");
        return;
    }
    data.append("talle",talle);

    //creo el objeto ajax
    if(window.XMLHttpRequest){
        var xhr = new XMLHttpRequest();
    }
    else if(window.ActiveXObject){
        var xhr = new ActiveXObject("Microsoft.XMLHTTP");
    }
    //xhr.withCredentials = true;
    if(xhr){
        xhr.open("POST","Carrito.php",true);
        xhr.addEventListener("readystatechange",function(){
            if(xhr.readyState === XMLHttpRequest.DONE && xhr.status === 200){
                mostrarAlerta()
            }
        });
        xhr.send(data);
    }
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
    alerta.classList.remove("alerta-AC");
    setTimeout(()=>{alerta.classList.add("alerta-AC")}, 4000)
}

function actualizarCantidad(){
    let spanCantidad = document.getElementById("cantidad");
    spanCantidad.innerText = cantidad;
}