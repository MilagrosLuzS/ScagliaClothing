function validarCampos(){
    event.preventDefault();
    const form = document.getElementById('formulario');
    const ciudad = document.getElementById('Ciudad');
    const provincia = document.getElementById('Provincia');
    const calle = document.getElementById('Calle');
    const numero = document.getElementById('Numero');
    const codigo_postal = document.getElementById('Codigo_Postal');
    const telefono = document.getElementById('Telefono');
    const documento = document.getElementById('DNI');
    let contador = 0;
    // Primero guardo los datos ingresados por el usuario
    const ciudadValor = ciudad.value.trim();
    const provinciaValor = provincia.value.trim();
    const calleValor = calle.value.trim();
    const numeroValor = numero.value.trim();
    const codigo_postalValor = codigo_postal.value.trim();
    const telefonoValor = telefono.value.trim();
    const documentoValor = documento.value.trim();


    //validacion Ciudad

    if(ciudadValor === ''){
        validacionFallida(ciudad,'Campo vacio')
    }
    else{
        ValidacionCorrecta(ciudad)
        contador += 1;
    }

    //validacion Provincia
    
    if(provinciaValor === ''){
        validacionFallida(provincia,'Campo vacio')
    }
    // else if(!validarProvincia(provinciaValor)){
    //     validacionFallida(provincia,'Provincia invalida')
    // }
    else{
        ValidacionCorrecta(provincia)
        contador += 1;
    }

    //validacion Calle

       if(calleValor === ''){
        validacionFallida(calle,'Campo vacio')
    }
    else{
        ValidacionCorrecta(calle)
        contador += 1;
    }
    
    //validacion Numero

    if(numeroValor === ''){
        validacionFallida(numero,'Campo vacio')
    }
    else{
        ValidacionCorrecta(numero)
        contador += 1;
    }

    //validacion Codigo Postal

       if(codigo_postalValor === ''){
        validacionFallida(codigo_postal,'Campo vacio')
    }
    else{
        ValidacionCorrecta(codigo_postal)
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

    if(contador == 7){
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

function validarProvincia(provincia){
    let p = eliminarDiacriticos(provincia)
    const Provincias=["Buenos Aires","Ciudad Autónoma de Buenos Aires","CABA","Catamarca","Chaco","Chubut","Córdoba","Corrientes","Entre Ríos","Formosa",
    "Jujuy","La Pampa","La Rioja","Mendoza","Misiones","Neuquén","Río Negro","Salta","San Juan","San Luis","Santa Cruz","Santa Fe","Santiago del Estero",
    "Tierra del Fuego","Tucumán"]
    Provincias.forEach(function(prov){
        if(eliminarDiacriticos(prov)===p){
            return true;
        }
    })
    return false;
}


// Elimina los diacríticos de un texto (ES6)
//
function eliminarDiacriticos(texto) {
    return texto.normalize('NFD').replace(/[\u0300-\u036f]/g,"");
}

