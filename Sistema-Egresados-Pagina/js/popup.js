var deleteSkillsButton;
var listSkills;

function linkPopup(){
  document.getElementById("popup-link").classList.toggle("active");
}

function skillPopup(){
  document.getElementById("popup-skill").classList.toggle("active");
}

function incrementLinks(){
  let inputLinkName = document.getElementsByClassName('form-control modified-middle-input ml-3 input-link-name');
  let inputLinkURL = document.getElementsByClassName('input-link-url');

  nameValues = [];
  urlValues = [];

  let preHTML = document.getElementById('all-links').innerHTML;
  let newHTML = '<div class="row mb-3"><div class="col-8"><input type="text" class="form-control modified-middle-input ml-3 input-link-name" placeholder="Nombre"></div><div class="col-4"><button type="button"name="button"class="btn btn-primary modified-middle-button">Guardar</button></div></div><div class="row mb-5"><div class="col-8"><input type="text" class="form-control modified-middle-input ml-3" placeholder="Enlace"></div><div class="col-4"><button type="button"name="button"class="btn btn-danger modified-middle-button">Eliminar</button></div></div>';
  document.getElementById('all-links').innerHTML = preHTML+newHTML;
}

function incrementSkills(){

  let preHTML = document.getElementById('all-skills').innerHTML;
  let newHTML = '<div class=""><div class="row mb-2"><div class="col-8"><input type="text" class="form-control modified-middle-input ml-3" placeholder="Habilidad"></div><div class="col-4"><button type="button"name="button"class="btn btn-primary modified-middle-button">Guardar</button></div></div><div class="row mb-4"><div class="col-8"></div><div class="col-4"><button type="button"name="button"class="btn btn-danger modified-middle-button">Eliminar</button></div></div></div>';
  document.getElementById('all-skills').innerHTML = preHTML+newHTML;

  deleteLinkButton = document.getElementsByClassName('btn btn-danger modified-middle-button');

  for(var i = 0; i < deleteLinkButton.length; i++){
    deleteLinkButton[i].addEventListener('click', function(e){
      this.parentNode.parentNode.parentNode.remove();
    }, false);
  }
}
