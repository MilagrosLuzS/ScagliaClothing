function eliminarProductoCarrito(cart_id_product){
    var data = new FormData();
    data.append("id_eliminar",cart_id_product);
    var xhr = new XMLHttpRequest();
    xhr.withCredentials = true;

    xhr.open("POST","Carrito.php");
    xhr.addEventListener("readystatechange",function(){
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