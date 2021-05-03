function togglePopup(){
  document.getElementById("popup-link").classList.toggle("active");
}

function incrementInputs(){
  let preHTML = document.getElementById('all-links').innerHTML;
  let newHTML = '<div class="row mb-4"><div class="col-8"><input type="text" class="form-control modified-middle-input ml-3"></div><div class="col-4"><button type="button" name="button" class="btn btn-primary modified-middle-button">Modificar</button></div></div>';
  document.getElementById('all-links').innerHTML = preHTML+newHTML;
}
