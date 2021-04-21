let profileTab = document.querySelector('#profile-tab');
let profile = document.querySelector('#profile');

let surveyTab = document.querySelector('#survey-tab');
let survey = document.querySelector('#survey');

let historyTab = document.querySelector('#history-tab');
let history = document.querySelector('#history');

survey.style.display = 'none';
history.style.display = 'none';


/* No me juzquen, luego la mejoro :'v '*/
profileTab.addEventListener('click', () =>{
    if(profile.style.display === 'none')
    {
      /* Activo */
      profile.style.display = 'block';
      profileTab.className = "nav-link active";

      /* Bloqueo */
      survey.style.display = 'none';
      surveyTab.className = "nav-link";

      history.style.display = 'none';
      historyTab.className = "nav-link";

    }
})

surveyTab.addEventListener('click', () =>{
    if(survey.style.display === 'none')
    {
      survey.style.display = 'block';
      surveyTab.className = "nav-link active";

      profile.style.display = 'none';
      profileTab.className = "nav-link";

      history.style.display = 'none';
      historyTab.className = "nav-link";

    }
})

historyTab.addEventListener('click', () =>{
    if(history.style.display === 'none')
    {
      history.style.display = 'block';
      historyTab.className = "nav-link active";

      profile.style.display = 'none';
      profileTab.className = "nav-link";
      survey.style.display = 'none';
      surveyTab.className = "nav-link";
    }
})
