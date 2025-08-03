//Adrianno Fallone
//Final Project Submission -> exercise.js(API Call number 2)

//DOM element references
const btnSearch = document.getElementById('search-btn');
const inputSearch = document.getElementById('search-input');
const sectionResults = document.getElementById('results');


const RAPIDAPI_HOST = 'exercisedb.p.rapidapi.com';
const RAPIDAPI_KEY = 'insert API Key here';  //my unique API key from rapidapi site

//event listener for search feature
btnSearch.addEventListener('click', () => {
  const query = inputSearch.value.trim(); //get search input
  if (!query) {
    //displays message in the event of no input
    sectionResults.innerHTML = '<p>Enter a valid exercise name.</p>';
    return;
  }
  fetchExercise(query); //API call with user input
});

//get exercise data
function fetchExercise(name) {
  sectionResults.innerHTML = '<p>Loading</p>'; //loading message

  fetch(`https://${RAPIDAPI_HOST}/exercises/name/${encodeURIComponent(name)}`, {
    method: 'GET',
    headers: {
      'X-RapidAPI-Host': RAPIDAPI_HOST,
      'X-RapidAPI-Key': RAPIDAPI_KEY,
    },
  })
    .then(res => res.json()) //for parsing response
    .then(data => {
      if (data.length === 0) {
        //show this message if no results are found
        sectionResults.innerHTML = `<p>No results have been found for "${name}".</p>`;
        return;
      }
      displayExercises(data); //show exercises
    })
    .catch(err => {
      //error handling for fetch request and api call
      console.error(err);
      sectionResults.innerHTML = '<p>Error fetching data. Try again later.</p>';
    });
}

//show the exercises that are fetched in the results section for the user
function displayExercises(exercises) {
  sectionResults.innerHTML = ''; // Clear results of prev

  exercises.forEach(ex => {
    // generate div container for each
    const exDiv = document.createElement('div');
    exDiv.classList.add('exercise-card'); //styling class

    //populate div
    exDiv.innerHTML = `
      <h3>${ex.name}</h3>
      <p><strong>Body Part:</strong> ${ex.bodyPart}</p>
      <p><strong>Target Muscle:</strong> ${ex.target}</p>
      <p><strong>Equipment:</strong> ${ex.equipment}</p>
    `;

    //  exercise card to be added to the results section
    sectionResults.appendChild(exDiv);
  });
}
