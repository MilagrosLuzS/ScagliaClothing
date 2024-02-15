function validarCampos(){
    event.preventDefault();
    const Nombre = document.getElementById('Nombre');
    const Precio = document.getElementById('Precio');
    const Talles = document.getElementById('Talle');
    const Colores = document.getElementById('Colores');
    const Stock = document.getElementById('Stock');
    const Imagen = document.getElementById('imagen')
    const Descripcion = document.getElementById('freeform')
    // Primero guardo los datos ingresados por el usuario
    const talleValor = Talles.value.trim();
    const nombreValor = Nombre.value.trim();
    const precioValor = Precio.value.trim();
    const stockValor = Stock.value.trim();
    const ImagenValor = Imagen.files[0];
    const DescripcionValor = Descripcion.value.trim();
    contador = 0;

    //validacion nombre
    if(nombreValor===''){
        validacionFallida(Nombre,'Campo Vacio.')
    }else if(validacionGeneral(nombreValor)){
        validacionFallida(Nombre,'Ingrese un Nombre valido.')
    }
    else{
        ValidacionCorrecta(Nombre)
        contador+=1
    }

    //validacion Precio
    if(precioValor===''){
        validacionFallida(Precio,'Campo Vacio.')
    }
    else{
        ValidacionCorrecta(Precio);
        contador+=1
    }

    //validar checkbox


    //validacion Stock

    if(stockValor===''){
        validacionFallida(Stock,'Campo Vacio.');
    }
    else{
        ValidacionCorrecta(Stock);
        contador+=1
    }

    //validacion talle
    
    if(talleValor===''){
        validacionFallida(Talles,'Campo Vacio')
    }else{
        ValidacionCorrecta(Talles)
        contador+=1
    }

    //validacion color

    if(validarColor()){
        contador+=1
    }

    //validacion descripcion

    if(DescripcionValor===''){
        validacionFallida(Descripcion,'Campo Vacio')
    }else{
        ValidacionCorrecta(Descripcion)
        contador+=1
    }

    if(contador == 6){
        document.getElementById('formulario').submit();
    }

}

function validacionFallida(input,mensaje){
    const formControl = input.parentElement
    const aviso = formControl.querySelector('p')
    aviso.innerText = mensaje

    formControl.className = 'input_contenedor fallida'
}

function ValidacionCorrecta(input,mensaje){
    const formControl = input.parentElement
    formControl.className = 'input_contenedor correcta'
}

function validacionGeneral(general){
    // return /^([^0-9\s_.]+)+[a-zA-Z]*((\s?)*[a-zA-Z](\s?)*)*$/g.test(general);
    return /^[a-zA-ZàáâäãåąčćęèéêëėįìíîïłńòóôöõøùúûüųūÿýżźñçčšžÀÁÂÄÃÅĄĆČĖĘÈÉÊËÌÍÎÏĮŁŃÒÓÔÖÕØÙÚÛÜŲŪŸÝŻŹÑßÇŒÆČŠŽ∂ð ,.'-]+$/u.test(general);
}

function validarColor() {
    if(document.getElementById("Color1").checked ||
       document.getElementById("Color2").checked ||
       document.getElementById("Color3").checked) {
        return true; // Al menos una opción de color está marcada
    } else {
        alert("Seleccionar colores.");
        return false; // Ninguna opción de color está marcada
    }
}