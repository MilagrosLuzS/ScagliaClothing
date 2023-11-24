function validarCampos(){
    event.preventDefault();
    // Primero guardo los datos ingresados por el usuario
    const form = document.getElementById("formulario");
    const email = document.getElementById("email");
    const password = document.getElementById("password");
    const emailValor = email.value.trim();
    const passwordValor = password.value.trim();
    contador = 0;

    //validacion email
    if(emailValor===''){
        validacionFallida(email,'Campo vacio');
    }
    else if(!validaEmail(emailValor)){
        validacionFallida(email,'El email no es valido');
    }
    else{
        ValidacionCorrect(email);
        contador+=1;
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
        ValidacionCorrect(password);
        contador+=1;
    }
    if(contador==2){
        document.getElementById('formulario').submit();
    }
}

function validacionFallida(input,mensaje){
    const formControl = input.parentElement
    const aviso = formControl.querySelector('p')
    aviso.innerText = mensaje

    formControl.className = 'input_contenedor fallida'
}

function ValidacionCorrect(input){
    const formControl = input.parentElement
    formControl.className = 'input_contenedor correcta'
}

function validaEmail(email){
    //patron (expresiones regulares) para evaluar la validez del email
    return /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/.test(email);
}
