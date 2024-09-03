const formulario = document.getElementById('FormIngresarCorreo');

const inputs = document.querySelectorAll('#FormIngresarCorreo input')

const expresiones = {
    correo: /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,4})+$/,
}

const campos = {
    correo: false,
}

const validarformulario = (e) => {
    switch (e.target.name) {
        case "correo":
            validarcampo(expresiones.correo, e.target, 'correo');
            break;
    }
}

const validarcampo = (expresion, input, campo) => {
    if (expresion.test(input.value)) {
        document.getElementById(`grupo-${campo}`).classList.remove('formulario__grupo-incorrecto');
        document.getElementById(`grupo-${campo}`).classList.add('formulario__grupo-correcto');
        document.querySelector(`#grupo-${campo} .error`).classList.remove('error-activo');
        campos[campo] = true;
        console.log(campos[campo]);
    } else {
        document.getElementById(`grupo-${campo}`).classList.remove('formulario__grupo-correcto');
        document.getElementById(`grupo-${campo}`).classList.add('formulario__grupo-incorrecto');
        document.querySelector(`#grupo-${campo} .error`).classList.add('error-activo');
        campos[campo] = false;
        console.log(campos[campo]);
    }
}

inputs.forEach((input) => {
    input.addEventListener('keyup', validarformulario);
    input.addEventListener('blur', validarformulario);
});

const boton_ingresar = document.getElementById('ingresar_correo').disabled = true;

formulario.addEventListener('keyup', (e) => {
    if (campos.correo) {
        const boton_ingresar = document.getElementById('ingresar_correo').disabled = false;
    } else {
        const boton_ingresar = document.getElementById('ingresar_correo').disabled = true;
    }

});