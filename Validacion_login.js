window.addEventListener('load',()=>{
    const form = document.getElementById("formulario");
    const email = document.getElementById("email");
    const password = document.getElementById("password");
    form.addEventListener('submit',(e)=>{
        e.preventDefault();
        validarCampos()
    })
    function validarCampos(){
        // Primero guardo los datos ingresados por el usuario
        const emailValor = email.value.trim();
        const passwordValor = password.value.trim();

        //validacion email
        if(emailValor===''){
            validacionFallida(email,'Campo vacio');
        }
        else if(!validaEmail(emailValor)){
            validacionFallida(email,'El email no es valido');
        }
        else{
            ValidacionCorrect(email);
        }
        
        //validacion password

        const er = /^(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{6,18}$/;     

        if(passwordValor===''){
            validacionFallida(password,'Campo vacio')
        }
        else{
            ValidacionCorrect(password);
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

})