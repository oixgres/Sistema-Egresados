
var inputLinkName = document.getElementsByClassName('form-control modified-middle-input ml-3 input-link-name');
var inputLinkURL = document.getElementsByClassName('form-control modified-middle-input ml-3 input-link-url');
var profileLinks = document.getElementsByClassName('link-name-profile');



/* Preparativos */
function setLinkForms(){
  $('.form-links').on('submit', function (e) {
    let a = this;
    $.ajax({
        type: 'post',
        url: '../php/submitLink.php',
        data: $(this).serialize()+'&id='+a.id,
        success: function (response) {
          let res = JSON.parse(response);

          if(res['type'] == "new")
          {
            a.id = res['id'];
          }
          else{
            for(var i = 0; i < profileLinks.length; i++){
              if(profileLinks[i].name==a.id){
                profileLinks[i].innerHTML = res['name'];
                profileLinks[i].href =  res['link'];

                break;
              }
            }
          }
        }
    });
    
    e.preventDefault();
});
}

/* Preparamos los botones de borrado ya existentes */
function setDeleteButtons(){
  let deleteLinkButton = document.getElementsByClassName('btn btn-danger modified-middle-button delete-links');

  for(var i = 0; i < deleteLinkButton.length; i++){
    deleteLinkButton[i].addEventListener('click', function(e){
      
      let id = this.parentNode.parentNode.parentNode.id;

      $.ajax({
        url: '../php/deleteLink.php',
        type: 'post',
        data: {id},

        success: function(response){
          console.log(response)
        }

      });
      
      this.parentNode.parentNode.parentNode.remove();

    }, false);
  }
}

/* Documento Listo */
$(document).ready(function (e){
  setLinkForms();
  setDeleteButtons();  
})

function linkPopup(){
  document.getElementById("popup-link").classList.toggle("active");
}

function skillPopup(){
  document.getElementById("popup-skill").classList.toggle("active");
}

function newLinks(){
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
  let newHTML = '<form class="form-links"><div class="row mb-3"><div class="col-8"><input type="text" class="form-control modified-middle-input ml-3 input-link-name"placeholder="Nombre" name="name"value = ""></div><div class="col-4"><button type="submit" value="submit" name="button"class="btn btn-primary modified-middle-button save-link">Guardar</button></div></div><div class="row mb-5"><div class="col-8"><input type="text" class="form-control modified-middle-input ml-3 input-link-url" placeholder="Enlace" name="link" value=""></input></div><div class="col-4"><button type="button" name="button" class="btn btn-danger modified-middle-button delete-links">Eliminar</button></div></div></form>';
  document.getElementById('all-links').innerHTML = preHTML+newHTML;

  /* Regresamos los valores */
  for(var i = 0; i < nameValues.length; i++){
    inputLinkName[i].value = nameValues[i];
    inputLinkURL[i].value = urlValues[i];
    /*
    if(profileLinks[i]){
      console.log(profileLinks[i].html)
      profileLinks[i].innerHTML = nameValues[i];
    }

    if(linkURLProfile[i]){
      linkURLProfile[i].innerHTML = urlValues[i];
    }
    */
  }

  setDeleteButtons();
  setLinkForms();
}

function incrementSkills(){

  var inputSkill = document.getElementsByClassName('form-control modified-middle-input ml-3 input-skill');
  var inputValues = [];

  /* Almacenamos valores */
  for(var i = 0; i < inputSkill.length; i++)
    inputValues[i] = inputSkill[i].value;


  let preHTML = document.getElementById('all-skills').innerHTML;
  let newHTML = '<form class="form-skills"><div class="row mb-2"><div class="col-8"><input type="text" class="form-control modified-middle-input ml-3 input-skill" placeholder="Habilidad" value=""></div><div class="col-4"><button type="submit"name="button"class="btn btn-primary modified-middle-button">Guardar</button></div></div><div class="row mb-4"><div class="col-8"></div><div class="col-4"><button type="button"name="button"class="btn btn-danger modified-middle-button delete-skills">Eliminar</button></div></div></form>';

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




