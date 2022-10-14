window.addEventListener('load',()=>{
    const form = document.getElementById('formulario');
    const Nombre = document.getElementById('Nombre');
    const Precio = document.getElementById('Precio');
    const Talles = document.getElementById('Talles');
    const Colores = document.getElementById('Colores');
    const Stock = document.getElementById('Stock');

    form.addEventListener('submit',(e)=>{
        e.preventDefault();
        validarCampos();
    })

    function validarCampos(){
        // Primero guardo los datos ingresados por el usuario
        const nombreValor = Nombre.value.trim();
        const precioValor = Precio.value.trim();
        const stockValor = Stock.value.trim();

        //validacion nombre
        if(nombreValor===''){
            validacionFallida(Nombre,'Campo Vacio.')
        }else if(validacionGeneral(nombreValor)){
            validacionFallida(Nombre,'Ingrese un Nombre valido.')
        }
        else{
            ValidacionCorrecta(Nombre)
        }

        //validacion Precio
        if(precioValor===''){
            validacionFallida(Precio,'Campo Vacio.')
        }
        else{
            ValidacionCorrecta(Precio);
        }

        //validar checkbox


        //validacion Stock

        if(stockValor===''){
            validacionFallida(Stock,'Campo Vacio.');
        }
        else{
            ValidacionCorrecta(Stock);
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
        return /^([^0-9\s_.]+)+[a-zA-Z]*((\s?)*[a-zA-Z](\s?)*)*$/g.test(general);
    }

})