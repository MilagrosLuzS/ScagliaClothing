window.addEventListener('load',()=>{
    const form = document.getElementById('formulario');
    const nombre = document.getElementById('Nombre');
    const apellido = document.getElementById('Apellidos');
    const email = document.getElementById('Email');
    const telefono = document.getElementById('Telefono');
    const calle = document.getElementById('Calle');
    const altura = document.getElementById('Altura');
    const piso = document.getElementById('Piso');
    const localidad = document.getElementById('Localidad');
    const codPostal = document.getElementById('CodPostal');

    form.addEventListener('submit',(e)=>{
        e.preventDefault();
        validarCampos();
    })


    function validarCampos(){
        // Primero guardo los datos ingresados por el usuario
        const nombreValor = nombre.value.trim();
        const emailValor = email.value.trim();
        const apellidoValor = apellido.value.trim();
        const telefonoValor = telefono.value.trim();
        const calleValor = calle.value.trim();
        const alturaValor = altura.value.trim();
        const pisoValor = piso.value.trim();
        const localidadValor = localidad.value.trim();
        const codPostalValor = codPostal.value.trim();

        //validacion nombre

        if(nombreValor === ''){
            validacionFallida(nombre,'Campo vacio')
        }
        else{
            ValidacionCorrecta(nombre)
        }

        //validacion Apellido

        if(apellidoValor === ''){
            validacionFallida(apellido,'Campo vacio')
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

        //validacion telefono

        if(telefonoValor === ''){
            validacionFallida(telefono,'Campo vacio')
        }
        else{
            ValidacionCorrecta(telefono)
        }

        //validacion calle

        if(calleValor === ''){
            validacionFallida(calle,'Campo vacio')
        }
        else{
            ValidacionCorrecta(calle)
        }

        //validacion altura

        if(alturaValor === ''){
            validacionFallida(altura,'Campo vacio')
        }
        else{
            ValidacionCorrecta(altura)
        }

        //validacion piso

        if(pisoValor === ''){
            validacionFallida(piso,'Campo vacio')
        }
        else{
            ValidacionCorrecta(piso)
        }

        //validacion localidad

        if(localidadValor === ''){
            validacionFallida(localidad,'Campo vacio')
        }
        else{
            ValidacionCorrecta(localidad)
        }

        //validacion codigo postal

        if(codPostalValor === ''){
            validacionFallida(codPostal,'Campo vacio')
        }
        else{
            ValidacionCorrecta(codPostal)
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

    // function validaTelefono(telefono){
    //     return /^\(?\d{2}\)?[\s\.-]?\d{4}[\s\.-]?\d{4}$/;
    // }

        // function validaCodPostal(codPostal){
        //     return /(?i)(?P<provincia>[a-hj-np-z])(?P<numero>[\d]{1,4})(?P<calle>[a-z]{3})/g;
        // }

})