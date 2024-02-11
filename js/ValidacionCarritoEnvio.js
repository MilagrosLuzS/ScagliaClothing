function validarCampos(){
    event.preventDefault();
    const form = document.getElementById('formulario');
    const nombre = document.getElementById('Nombre');
    const direccion = document.getElementById('Direccion');
    const telefono = document.getElementById('Telefono');
    const documento = document.getElementById('DNI');
    let contador = 0;
    // Primero guardo los datos ingresados por el usuario
    const nombreValor = nombre.value.trim();
    const direccionValor = direccion.value.trim();
    const telefonoValor = telefono.value.trim();
    const documentoValor = documento.value.trim();

    //validacion nombre

    if(nombreValor === ''){
        validacionFallida(usuario,'Campo vacio')
    }else if(!validacionGeneral(nombreValor)){
        validacionFallida(nombre,'nombre y/o apellido no valido.')
    }
    else{
        ValidacionCorrecta(nombre)
        contador += 1;
    }

    //validacion direccion

    if(direccionValor === ''){
        validacionFallida(direccion,'Campo vacio')
    }
    else{
        ValidacionCorrecta(direccion)
        contador += 1;
    }
    
    //validacion telefono argentino   

    if(telefonoValor===''){
        validacionFallida(telefono,'Campo vacio')
    }
    else if(!tel_argentino_valido(telefonoValor)){
        validacionFallida(telefono,'El telefono no es valido.')
    }
    else{
        ValidacionCorrecta(telefono);
        contador += 1;
    }

    //validacion dni

    if(documentoValor===''){
        validacionFallida(documento,'Campo vacio')
    }
    else if(!dni_valido(documentoValor)){
        validacionFallida(documento,'Documento no valido.')
    }
    else{
        ValidacionCorrecta(documento)
        contador += 1;
    }

    if(contador == 4){
        document.getElementById('formulario').submit();
    }

}

function dni_valido(dni){
    return /^[\d]{1,3}\.?[\d]{3,3}\.?[\d]{3,3}$/.test(dni);
}

function tel_argentino_valido(tel) {
    // Eliminamos todo lo que no es dígito
    var num = tel.replace(/\D+/g, '');

    // Devolver si coincidió con el regex
    return /^(?:(?:00)?549?)?0?(?:11|[2368]\d)(?:(?=\d{0,2}15)\d{2})??\d{8}$/.test(num);
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
