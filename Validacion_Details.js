window.addEventListener('load',()=>{
    const form = document.getElementById('formulario');
    const nombre = document.getElementById('Nombre');
    const apellido = document.getElementById('Apellidos');
    const email = document.getElementById('Email');
    const user = document.getElementById('NombreAMostrar');

    form.addEventListener('submit',(e)=>{
        e.preventDefault();
        validarCampos();
    })

    function validarCampos(){
        // Primero guardo los datos ingresados por el usuario
        const nombreValor = nombre.value.trim();
        const emailValor = email.value.trim();
        const apellidoValor = apellido.value.trim();
        const userValor = user.value.trim();
        //validacion nombre

        if(nombreValor === ''){
            validacionFallida(nombre,'Campo vacio')
        }
        else if(!validacionGeneral(nombreValor)){
            validacionFallida(nombre,'Ingrese un nombre valido')
        }
        else{
            ValidacionCorrecta(nombre)
        }
        
        //validacion User

        if(userValor===''){
            validacionFallida(user,'Campo vacio');
        }
        else{
            ValidacionCorrecta(user)
        }

        //validacion Apellido

        if(apellidoValor === ''){
            validacionFallida(apellido,'Campo vacio')
        }
        else if(!validacionGeneral(apellidoValor)){
            validacionFallida(apellido,'Ingrese un apellido valido')
        }
        else{
            ValidacionCorrecta(apellido)
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

    function validacionGeneral(general){
        return /^([^0-9\s_.]+)+[a-zA-Z]*((\s?)*[a-zA-Z](\s?)*)*$/g.test(general);
    }

    function validacionNumeros(gen){
        return /^[0-9]+$/.test(gen);
    }

})