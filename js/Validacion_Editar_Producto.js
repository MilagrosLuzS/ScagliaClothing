window.addEventListener('load',()=>{
    const form = document.getElementById('formulario');
    const Nombre = document.getElementById('Nombre');
    const Precio = document.getElementById('Precio');
    const Talle = document.getElementById('Talle');
    const Stock = document.getElementById('Stock');

    form.addEventListener('submit',(e)=>{
        e.preventDefault();
        validarCampos();
    })

    function validarCampos(){
        // Primero guardo los datos ingresados por el usuario
        const nombreValor = Nombre.value.trim();
        const precioValor = Precio.value.trim();
        const talleValor = Talle.value.trim();
        const stockValor = Stock.value.trim();

        //validacion nombre
        if(nombreValor===''){
            validacionFallida(Nombre,'Campo Vacio.')
        }else{
            ValidacionCorrecta(Nombre)
        }

        //validacion Precio
        if(precioValor===''){
            validacionFallida(Precio,'Campo Vacio.')
        }else if(!validacionNumeros(precioValor)){
            validacionFallida(Precio,'Ingrese solo numeros.')
        }
        else{
            ValidacionCorrecta(Precio);
        }


        //validacion Stock

        if(stockValor===''){
            validacionFallida(Stock,'Campo Vacio.');
        }else if(!validacionNumeros(stockValor)){
            validacionFallida(Stock,'Ingrese solo numeros.');
        }else{
            ValidacionCorrecta(Stock);
        }

        //validacion Talle
        if(talleValor===''){
            validacionFallida(Talle,'Campo Vacio.');
        }else if(!validacionNumeros(talleValor)){
            validacionFallida(Talle,'Ingrese solo numeros.');
        }else{
            ValidacionCorrecta(Talle);
        }

        //validacion color
        validarColor();

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

    function validacionNumeros(gen){
        return /^[0-9]+$/.test(gen);
    }

    function validarColor(){
        var valid = false;
        if(document.getElementById("Color1").checked){
            valid = true;
        }
        else if(document.getElementById("Color2").checked){
            valid = true;
        }
        else if(document.getElementById("Color3").checked){
            valid = true;
        }
        if(!valid){
            alert("Seleccionar colores.");
            return false;
        }
    }

})