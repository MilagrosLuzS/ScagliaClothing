window.addEventListener('load',()=>{
    const form = document.getElementById('formulario');
    const PasActual = document.getElementById('PasActual');
    const PasNueva = document.getElementById('PasNueva');
    const PasConfirm = document.getElementById('PasConfirm');

    form.addEventListener('submit',(e)=>{
        e.preventDefault();
        validarCampos();
    })

    function validarCampos(){
        // Primero guardo los datos ingresados por el usuario
        const pasActualValor = PasActual.value.trim();
        const PasNuevaValor = PasNueva.value.trim();
        const PasConfirmValor = PasConfirm.value.trim();

        const er = /^(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{6,18}$/;   

        //validacion PasActual

        if(pasActualValor===''){
            validacionFallida(PasActual,'Campo Vacio')
        }
        else{
            ValidacionCorrecta(PasActual);
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

})