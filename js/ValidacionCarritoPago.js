function validarCampos(){
    event.preventDefault();
    const form = document.getElementById('formulario');
    const titular = document.getElementById('titular');
    const numero_tarjeta = document.getElementById('Numero');
    const Expiracion = document.getElementById('Expiracion');
    const cvc = document.getElementById('CVC');
    let contador = 0;
    // Primero guardo los datos ingresados por el usuario
    const titularValor = titular.value.trim();
    const numero_tarjetaValor = numero_tarjeta.value.trim();
    const ExpiracionValor = Expiracion.value.trim();
    const cvcValor = cvc.value.trim();

    //validacion titular

    if(titularValor === ''){
        validacionFallida(titular,'Campo vacio')
    }else if(!validacionGeneral(titularValor)){
        validacionFallida(titular,'nombre y/o apellido no valido.')
    }
    else{
        ValidacionCorrecta(titular)
        contador += 1;
    }

    //validacion numero de tarjeta

    if(numero_tarjetaValor === ''){
        validacionFallida(numero_tarjeta,'Campo vacio')
    }
    else if (!validarTarjetaCredito(numero_tarjetaValor)){
        validacionFallida(numero_tarjeta,'Tarjeta invalida')
    }
    else{
        ValidacionCorrecta(numero_tarjeta)
        contador += 1;
    }
    
    //validacion expiracion   

    if(ExpiracionValor===''){
        validacionFallida(Expiracion,'Campo vacio')
    }
    // else if(!validarFechaExpiracion(ExpiracionValor)){
    //     validacionFallida(Expiracion,'Fecha de expiracion no valida.')
    // }
    else{
        ValidacionCorrecta(Expiracion);
        contador += 1;
    }

    //validacion cvc

    if(cvcValor===''){
        validacionFallida(cvc,'Campo vacio')
    }
    else if(!validarCVC(cvcValor)){
        validacionFallida(cvc,'CVC no valido.')
    }
    else{
        ValidacionCorrecta(cvc)
        contador += 1;
    }

    if(contador == 4){
        document.getElementById('formulario').submit();
    }

}

function sonNumeros(str){
    // acepta tambien el  / de fecha de expiracion y el - del numero de la tarjeta
    for (let i of str){
        if (!((i.charCodeAt(0)>=48 && i.charCodeAt(0)<=57) || i=="-" || i=="/")){
            return false
        }
    }
    return true
}

function validarCVC(cvc) {
    // Expresión regular para validar el CVC (código de seguridad de la tarjeta)
    var regexCVC = /^[0-9]{3,4}$/;
    return regexCVC.test(cvc);
}

function validarTarjetaCredito(numeroTarjeta) {
    // Expresión regular para validar el formato de la tarjeta de crédito
    var regexTarjeta = /^[0-9]{4}-[0-9]{4}-[0-9]{4}-[0-9]{4}$/;
    return regexTarjeta.test(numeroTarjeta);
}

// function validarFechaExpiracion(fechaExpiracion) {
//     // Expresión regular para validar el formato de la fecha de expiración (MM/YY)
//     var regexFecha = /^(0[1-9]|1[0-2])\/([0-9]{2})$/;
//     // Obtener el año actual
//     var añoActual = new Date().getFullYear().toString().substr(-2);
//     // Obtener el mes actual
//     var mesActual = new Date().getMonth() + 1;
//     // Si el mes actual tiene un solo dígito, agregar un cero al principio
//     if (mesActual < 10) {
//         mesActual = '0' + mesActual;
//     }
//     // Unir el mes y el año actual en el mismo formato que la fecha de expiración
//     var fechaActual = mesActual + '/' + añoActual;
//     // Si la fecha de expiración es igual o mayor a la fecha actual, devuelve true
//     return regexFecha.test(fechaExpiracion) && fechaExpiracion >= fechaActual;
// }

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
