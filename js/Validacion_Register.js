function validarCampos(){
    event.preventDefault();
    const form = document.getElementById('formulario');
    const usuario = document.getElementById('usuario');
    const email = document.getElementById('email');
    const password = document.getElementById('password');
    const passwordConfirm = document.getElementById('passwordConfirm');
    let contador = 0;
    // Primero guardo los datos ingresados por el usuario
    const usuarioValor = usuario.value.trim();
    const emailValor = email.value.trim();
    const passwordValor = password.value.trim();
    const passwordConfirmValor = passwordConfirm.value.trim();

    //validacion usuario

    if(usuarioValor === ''){
        validacionFallida(usuario,'Campo vacio')
    }else if(!validacionGeneral(usuarioValor)){
        validacionFallida(usuario,'nombre y/o apellido no valido.')
    }
    else{
        ValidacionCorrecta(usuario)
        contador += 1;
    }

    //validacion email

    if(emailValor===''){
        validacionFallida(email,'Campo Vacio');
    }
    else if(!validaEmail(emailValor)){
        validacionFallida(email,'El email no es valido');
    }
    else{
        ValidacionCorrecta(email);
        contador += 1;
    }
    
    //validacion password

    const er = /^(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{6,18}$/;     

    if(passwordValor===''){
        validacionFallida(password,'Campo vacio')
    }
    else if(passwordValor.length < 8){
        validacionFallida(password,'La contraseña debe tener al menos 8 caracteres.')
    }
    else if(!passwordValor.match(er)){
        validacionFallida(password,'La contraseña debe tener al menos una mayuscula una minuscula y un numero.'); 
    }
    else{
        ValidacionCorrecta(password);
        contador += 1;
    }

    //validacion passwordconfirm

    if(!passwordConfirmValor){
        validacionFallida(passwordConfirm,'Confirme su contraseña')
    }
    else if(passwordConfirmValor!==passwordValor){
        validacionFallida(passwordConfirm,'la contraseña no coincide.')
    }
    else{
        ValidacionCorrecta(passwordConfirm)
        contador += 1;
    }

    if(contador == 4){
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

function validaEmail(email){
    //patron (expresiones regulares) para evaluar la validez del email
    return /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/.test(email);
}

