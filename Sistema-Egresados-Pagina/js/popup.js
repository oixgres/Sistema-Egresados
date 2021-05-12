
$(document).ready(function(){
  console.log("Algo1");
  $("form").on("submit", function(event){
    event.preventDefault();

    var formData = $(this).serialize();
    console.log(formData.name)

    $.post("../php/submitLink.php", formData, function(data){
    });
  });
});



var linksJSON = {items: []};
var inputLinkName = document.getElementsByClassName('form-control modified-middle-input ml-3 input-link-name');
var inputLinkURL = document.getElementsByClassName('form-control modified-middle-input ml-3 input-link-url');

function linkPopup(){
  document.getElementById("popup-link").classList.toggle("active");
}

function skillPopup(){
  document.getElementById("popup-skill").classList.toggle("active");
}

function incrementLinks(){
  var nameValues = [];
  var urlValues = [];

  /* Almacenamos los valores de los divs */
  for(var i = 0; i < inputLinkName.length; i++)
  {
    nameValues[i] = inputLinkName[i].value;
    urlValues[i] = inputLinkURL[i].value;
  }
  
  /* El contenido de los divs se pierde al ejecutar estas lineas, por lo que lo volvemos a vaciar */
  let preHTML = document.getElementById('all-links').innerHTML;
  let newHTML = '<div><div class="row mb-3"><div class="col-8"><input type="text" class="form-control modified-middle-input ml-3 input-link-name" placeholder="Nombre"></div><div class="col-4"><button type="button"name="button"class="btn btn-primary modified-middle-button save-link">Guardar</button></div></div><div class="row mb-5"><div class="col-8"><input type="text" class="form-control modified-middle-input ml-3 input-link-url" placeholder="Enlace"></div><div class="col-4"><button type="button"name="button"class="btn btn-danger modified-middle-button delete-links">Eliminar</button></div></div></div>';
  document.getElementById('all-links').innerHTML = preHTML+newHTML;

  /* Regresamos los valores */
  for(var i = 0; i < nameValues.length; i++){
    inputLinkName[i].value = nameValues[i];
    inputLinkURL[i].value = urlValues[i];
  }

  /* Borramos elementos al presionar el boton */ 
  let deleteLinkButton = document.getElementsByClassName('btn btn-danger modified-middle-button delete-links');

  for(var i = 0; i < deleteLinkButton.length; i++)
    deleteLinkButton[i].addEventListener('click', function(e){
      this.parentNode.parentNode.parentNode.remove();
    }, false);

  /*
  let saveLinkButton = document.getElementsByClassName('save-link');
  for(var i = 0; i < inputLinkName.length; i++){
    saveLinkButton[i].addEventListener('click', function (e){
      
      /* Corregir */
      /*
      console.log(i);
      linksJSON.items.push({
        id: inputLinkName[i].id,
        name: inputLinkName[i].value,
        link: inputLinkURL[i].value
      });
    })
  }
  */
}

function incrementSkills(){

  var inputSkill = document.getElementsByClassName('form-control modified-middle-input ml-3 input-skill');
  var inputValues = [];

  /* Almacenamos valores */
  for(var i = 0; i < inputSkill.length; i++)
    inputValues[i] = inputSkill[i].value;


  let preHTML = document.getElementById('all-skills').innerHTML;
  let newHTML = '<div class=""><div class="row mb-2"><div class="col-8"><input type="text" class="form-control modified-middle-input ml-3 input-skill" placeholder="Habilidad"></div><div class="col-4"><button type="button"name="button"class="btn btn-primary modified-middle-button">Guardar</button></div></div><div class="row mb-4"><div class="col-8"></div><div class="col-4"><button type="button"name="button"class="btn btn-danger modified-middle-button delete-skills">Eliminar</button></div></div></div>';
  document.getElementById('all-skills').innerHTML = preHTML+newHTML;

  /* Recuperamos valores */
  for(var i = 0; i < inputValues.length; i ++)
    inputSkill[i].value = inputValues[i];

  let deleteLinkButton = document.getElementsByClassName('btn btn-danger modified-middle-button delete-skills');

  /* Borramos elementos al presionar el boton */ 
  for(var i = 0; i < deleteLinkButton.length; i++){
    deleteLinkButton[i].addEventListener('click', function(e){
      this.parentNode.parentNode.parentNode.remove();
    }, false);
  }
}




