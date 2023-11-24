var contenido = ['Multimedia/Fotos_Producto/Fotos_C/HP_1.jpg','Multimedia/Fotos_Producto/Fotos_C/HP_2.jpg','Multimedia/Fotos_Producto/Fotos_C/HP_3.jpg','Multimedia/Fotos_Producto/Fotos_C/HP_4.jpg','Multimedia/Fotos_Producto/Fotos_C/HP_5.jpg']
    cont = 0;

const back = document.getElementById('atras');
const img = document.getElementById('imagen');
const foward = document.getElementById('adelante');

function carrousel(contenedor){
    contenedor.addEventListener('click',e =>{
        let tgt = e.target;
        if(tgt == back){
            if(cont>0){
                img.src = contenido[cont-1];
                cont--;
            }
            else{
                img.src = contenido[contenido.length - 1];
                cont = contenido.length - 1;
            }
        }
        else if(tgt == foward){
            if(cont < contenido.length - 1){
                img.src = contenido[cont + 1];
                cont++;
            }
            else{
                img.src = contenido[0];
                cont = 0;
            }
        }
    });
}

document.addEventListener("DOMContentLoaded",() =>{
    let contenedor = document.querySelector('.imagenes');
    carrousel(contenedor);
});