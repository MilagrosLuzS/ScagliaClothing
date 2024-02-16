cont = 0;
function cambiarImagen(direccion) {
    var img = document.getElementById('imagen');
    if(direccion == -1){
        if(cont>0){
            img.src = contenido[cont-1];
            cont--;
        }
        else{
            img.src = contenido[cont.length-1];
            cont = contenido.length -1;
        }
    }
    else{
        if(cont < contenido.length - 1){
            img.src = contenido[cont + 1];
            cont++;
        }
        else{
            img.src = contenido[0];
            cont = 0;
        }
    }
    
}