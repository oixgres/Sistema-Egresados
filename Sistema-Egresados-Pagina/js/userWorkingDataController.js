$(document).ready(function (e) {
    let questionContainerForIsWorking = $('#questionContainerForIsWorking');

    let stepper = mainSteper.stepper;

    function validateFields() {

        let flag = true;

        $('*').removeClass('alert alert-danger is-invalid alert-success is-valid')

        if($('#initWorkDate').val() === ""){
            flag = false;
            $('#initWorkDate').addClass('alert alert-danger is-invalid');
        }
        else{
            $('#initWorkDate').addClass('alert alert-success is-valid');
        }

        if($('#Empleo').val() === ""){
            flag = false;
            $('#Empleo').addClass('alert alert-danger is-invalid');
        }
        else{
            $('#Empleo').addClass('alert alert-success is-valid');
        }

        if($('#Empresa').val() === ""){
            flag = false;
            $('#Empresa').addClass('alert alert-danger is-invalid');
        }
        else{
            $('#Empresa').addClass('alert alert-success is-valid');
        }

        if($('#Puesto').val() === ""){
            flag = false;
            $('#Puesto').addClass('alert alert-danger is-invalid');
        }
        else{
            $('#Puesto').addClass('alert alert-success is-valid');
        }

        if($('#Categoria').val() === ""){
            flag = false;
            $('#Categoria').addClass('alert alert-danger is-invalid');
        }
        else{
            $('#Categoria').addClass('alert alert-success is-valid');
        }

        if($('#CorreoEmpresa').val() === ""){
            flag = false;
            $('#CorreoEmpresa').addClass('alert alert-danger is-invalid');
        }
        else{
            $('#CorreoEmpresa').addClass('alert alert-success is-valid');
        }

        if($('#Departamento').val() === ""){
            flag = false;
            $('#Departamento').addClass('alert alert-danger is-invalid');
        }
        else{
            $('#Departamento').addClass('alert alert-success is-valid');
        }

        if($('#Actividades').val() === ""){
            flag = false;
            $('#Actividades').addClass('alert alert-danger is-invalid');
        }
        else{
            $('#Actividades').addClass('alert alert-success is-valid');
        }

        if($('#Tecnologias').val() === ""){
            flag = false;
            $('#Tecnologias').addClass('alert alert-danger is-invalid');
        }
        else{
            $('#Tecnologias').addClass('alert alert-success is-valid');
        }





        return flag;

    }
    function getCookie(cname) {
        const name = cname + "=";
        const decodedCookie = decodeURIComponent(document.cookie);
        const ca = decodedCookie.split(';');
        for(let i = 0; i <ca.length; i++) {
            let c = ca[i];
            while (c.charAt(0) === ' ') {
                c = c.substring(1);
            }
            if (c.indexOf(name) === 0) {
                return c.substring(name.length, c.length);
            }
        }
        return "";
    } //funcion para obtener un cookie

    $("#isWorkingYes,#isWorkingNo").on('click', function (e) { //
        e.stopPropagation()
        if($(this).attr('id') === "isWorkingYes"){
            questionContainerForIsWorking.hide();
            questionContainerForIsWorking.removeClass('d-none');
            questionContainerForIsWorking.show(600);
        }
        else{
            questionContainerForIsWorking.hide(600);
        }
    })
    $('#sendWorkingDataBtn').on('click', function (e) {
        e.stopPropagation();
        let idUsuario = getCookie("verification");
        let laborando = $("#isWorkingYes").prop('checked') ? 1:0;
        let empleo = $('#Empleo').val();
        let empresa = $('#Empresa').val();
        let puesto = $('#Puesto').val();
        let categoria = $('#Categoria').val();
        let correo = $('#CorreoEmpresa').val();
        let departamento = $('#Departamento').val();
        let tecnologias = $('#Tecnologias').val();
        let actividades = $('#Actividades').val();
        let inicio = $('#initWorkDate').val()//initWorkDate

        if(laborando === 1){ //si se clickeo "trabajando"

            if(validateFields()){
                $.ajax({
                    url: '../php/registerEmploymentData.php',
                    data: {idUsuario, inicio, laborando,empleo, empresa, puesto, categoria, correo, departamento, tecnologias, actividades},
                    type: 'POST',
                    success: function (response) {
                        console.log('RESPUESTA == ' + response)
                        if(parseInt(response, 10) === 0){
                            //header
                            alert("Datos Registrados con exito")
                            window.location = '../html/verificationPage.html'
                        }
                    },
                    error: function () {
                      alert("error al registrar los datos")
                    }
                })


            }else{
                alert("Revisa los campos")
            }

        }else{
            $.ajax({
                url: '../php/registerEmploymentData.php',
                data: {idUsuario, laborando,empleo, empresa, puesto, categoria, correo, departamento, tecnologias, actividades},
                type: 'POST',
                success: function (response) {
                    console.log('RESPUESTA == ' + response)
                    if(parseInt(response, 10) === 0){
                        //header
                        alert("Datos Registrados con exito")
                        window.location = '../html/verificationPage.html'
                    }
                },
                error: function () {
                    alert("error al registrar los datos")
                }
            })
        }

    })


    if($("#isWorkingYes").prop('checked')){ //validacion por la caché del navegador
        questionContainerForIsWorking.hide();
        questionContainerForIsWorking.removeClass('d-none');
        questionContainerForIsWorking.show(600);
    }
})