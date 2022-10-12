window.addEventListener('load',()=>{
    const form = document.getElementById('formulario');
    const usuario = document.getElementById('usuario');
    const email = document.getElementById('email');
    const password = document.getElementById('password');
    const passwordConfirm = document.getElementById('passwordConfirm');
    form.addEventListener('submit',(e)=>{
        e.preventDefault();
        validarCampos()
    })


    function validarCampos(){
        // Primero guardo los datos ingresados por el usuario
        const usuarioValor = usuario.value.trim();
        const emailValor = email.value.trim();
        const passwordValor = password.value.trim();
        const passwordConfirmValor = passwordConfirm.value.trim();

        //validacion usuario

        if(usuarioValor === ''){
            validacionFallida(usuario,'Campo vacio')
        }
        else{
            ValidacionCorrecta(usuario)
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

    function validaEmail(email){
        //patron (expresiones regulares) para evaluar la validez del email
        return /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/.test(email);
    }

})