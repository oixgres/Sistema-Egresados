function checkSession(userType){
    $.ajax({
        url: '../php/checkSession.php',
        async: false,
        type: 'POST',
        data: {userType},
        success: function (response) {
            console.log(response)
            try{
                let json = JSON.parse(response)
                if(json.location){
                    $('body').hide();
                    window.location = json.location;
                }
            }catch (e){

            }

        }
    })
}


