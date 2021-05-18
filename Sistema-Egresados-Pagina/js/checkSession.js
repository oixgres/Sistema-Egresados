function checkSession(userType){
  $.ajax({
      url: '../php/checkSession.php',
      async: false,
      type: 'POST',
      data: {userType},
      success: function (response) {
          if(userType != 'new')
          {
            console.log(response)
            try{
                let json = JSON.parse(response)
                if(json.location){
                    alert("Por favor verifique sus datos")
                    window.location = json.location;
                }
            }catch (e){

            }
            else
              try {
                let json = JSON.parse(response)
                window.location = json.location;
              } catch (e) {

              }

        }
    })
}

