var click = false;

const alertMessage = document.getElementById('alert');
var alertButton;
const form = document.getElementById('verification-form');
const code = document.getElementById('input-code');
const button = document.getElementById('submit-button');

$(document).ready(function (e) {
  checkSession('new');

  if(alertMessage != null){
    alertMessage.style.display="none";

    if(sessionStorage.getItem('code-error')){
      alertMessage.innerHTML = sessionStorage.getItem('code-error');
      alertMessage.style.display = "block";

      alertButton = document.getElementById('alert-button')

      alertButton.addEventListener('click', (e)=>{
        alertMessage.style.display = "none";
      })

      sessionStorage.clear();
    }
  }
  
})

button.addEventListener('click', (e)=>{
  click = true;
})

form.addEventListener('submit', (e)=>{
  if(click)
  {
    click = false;
    if(code.value === '' || code.value == null){
      code.classList.add('is-invalid');
    
      e.preventDefault()
    }
    else{
    sessionStorage.setItem('code-error', '<strong> Codigo Invalido </strong> Favor de ingresar el codigo nuevamente o solicitar uno nuevo.<button id="alert-button" type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>');
    }
  }
})
