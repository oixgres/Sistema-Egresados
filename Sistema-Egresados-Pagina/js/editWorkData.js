$(document).ready(function (e) {
  let questionContainerForIsWorking = $('#questionContainerForIsWorking');


  function validateFields() {

      let flag = true;

      $('*').removeClass('alert alert-danger is-invalid alert-success is-valid')

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
      console.log('a')
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


  if($("#isWorkingYes").prop('checked')){ //validacion por la caché del navegador
      questionContainerForIsWorking.hide();
      questionContainerForIsWorking.removeClass('d-none');
      questionContainerForIsWorking.show(600);
  }
})