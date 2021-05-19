const form =  document.getElementById('loginForm');
const inputs = document.getElementsByClassName('login-input');


form.addEventListener('submit', function(e){
  for(var i = 0; i < inputs.length; i++){

    if(inputs[i].value === '' || inputs[i].value == null || (!inputs[2].checked && !inputs[3].checked))
      if(inputs[i].type != 'radio')
        inputs[i].classList += ' alert alert-danger is-invalid';
      else{
        inputs[i].classList += ' alert alert-danger is-invalid';
        inputs[i+1].classList += ' alert alert-danger is-invalid';
        break;
      }
  }  
  e.preventDefault();
  /*
  $.ajax({
    type:'post',
    url: 'php/login.php',
    data: $this.serialize(),
    success: function(response){

    }
  })
  */

})