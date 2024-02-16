function eliminarProductoCarrito(cart_id_product){
    var data = new FormData();
    data.append("id_eliminar",cart_id_product);

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
            //XMLHttpRequest.DONE = 4 = peticion aceptada
            if(xhr.readyState === XMLHttpRequest.DONE && xhr.status === 200){
                let productos = document.getElementById("productos");
                let productoEliminado = document.getElementById("carrito_producto_"+cart_id_product);
                productos.removeChild(productoEliminado);
                if(productos.children.length == 0){
                    window.location.href = "Carrito.php";
                }
                else{
                    let precioTotal = document.getElementById("precioTotal");
                    let precioProducto = parseInt(productoEliminado.attributes.precio.value);
                    var nuevoPrecio = precioTotal.attributes.precio.value - precioProducto; 
                    precioTotal.innerText = nuevoPrecio;
                }
            }
        });
        xhr.send(data);
    }
}