function checkSession(userType){
    $.ajax({
        url: '../php/checkSession.php',
        async: false,
        type: 'POST',
        data: {userType},
        success: function (response) {
            try{
                json = JSON.parse(response)
                if(json.location){
                    alert("Por favor verifique sus datos")
                    window.location = json.location;
                }
            }catch (e){

            }

        }
    })
}


