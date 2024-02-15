window.addEventListener('load',()=>{
    const form = document.getElementById('formulario');
    const nombre = document.getElementById('Nombre');

    form.addEventListener('submit',(e)=>{
        e.preventDefault();
        validarCampos();
    })

    function validarCampos(){
        // Primero guardo los datos ingresados por el usuario
        const nombreValor = nombre.value.trim();
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

})