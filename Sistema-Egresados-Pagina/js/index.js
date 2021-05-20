const form =  document.getElementById('loginForm');
const inputs = document.getElementsByClassName('login-input');
const radio = document.getElementsByClassName('login-radio');

for(let i = 0; i< radio.length; i++){
  radio[i].addEventListener('change', function(e){
    if(radio[0].checked == true || radio[1].checked == true){
      radio[0].classList.remove('is-invalid');
      radio[1].classList.remove('is-invalid');
    }
  })
}

for(let i = 0; i < inputs.length; i++){
  inputs[i].addEventListener('input', function(e){
    inputs[i].classList.remove('is-invalid');
  })
}

form.addEventListener('submit', function(e){
  let errorCount = 0; 
  /* Si los inputs estan vacios */
  for(var i = 0; i < inputs.length; i++){
    if(inputs[i].value === '' || inputs[i].value == null){
      inputs[i].classList.add('is-invalid');
      errorCount++;
    }
  }
  
  if(radio[0].checked == false && radio[1].checked == false)
  {
    radio[0].classList.add('is-invalid');
    radio[1].classList.add('is-invalid');
    errorCount++;
  }

  if(errorCount == 0){
    $.ajax({
      type:'post',
      url: 'php/login.php',
      data: $(this).serialize(),
      success: function(response){
        let json = JSON.parse(response)

        if(json.location)
          window.location = json.location;
        else
          alert(json.errorMessage);
      },
      error: function(xhr, status, error){
          var errorMessage = xhr.status + ': ' + xhr.statusText
          alert('Error - ' + errorMessage);
      }
    })
  }

  e.preventDefault()
});