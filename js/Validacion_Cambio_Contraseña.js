

function validarCampos(event,contraseña_actual){
    event.preventDefault();
    const PasActual = document.getElementById('PasActual');
    const PasNueva = document.getElementById('PasNueva');
    const PasConfirm = document.getElementById('PasConfirm');
    // Primero guardo los datos ingresados por el usuario
    contador = 0;
    const pasActualValor = PasActual.value.trim();
    const PasNuevaValor = PasNueva.value.trim();
    const PasConfirmValor = PasConfirm.value.trim();

    const er = /^(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{6,18}$/;   

    //validacion PasActual

    if(pasActualValor===''){
        validacionFallida(PasActual,'Campo Vacio')
    }
    else if(pasActualValor!=contraseña_actual){
        validacionFallida(PasActual,'Contraseña actual erronea.')
    }
    else{
        ValidacionCorrecta(PasActual);
        contador+=1;
    }

    //validacion PasNueva
    
    if(PasNuevaValor===''){
        validacionFallida(PasNueva,'Campo vacio')
    }
    else if(PasNuevaValor.length < 8){
        validacionFallida(PasNueva,'La contraseña debe tener al menos 8 caracteres.')
    }
    else if(!PasNuevaValor.match(er)){
        validacionFallida(PasNueva,'La contraseña debe tener una mayuscula una minuscula y un numero.'); 
    }
    else{
        ValidacionCorrecta(PasNueva);
        contador+=1;
    }


    //validacion passwordconfirm

    if(PasConfirmValor===''){
        validacionFallida(PasConfirm,'Confirme su contraseña')
    }
    else if(PasConfirmValor!==PasNuevaValor){
        validacionFallida(PasConfirm,'la contraseña no coincide.')
    }
    else{
        ValidacionCorrecta(PasConfirm)
        contador+=1;
    }

    if(contador==3){
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

