//Adrianno Fallone
//Final Project Submission - nutrition.js (API call 1)

//event listener for clicking on macro-calculator button
document.getElementById("check-nutrition").addEventListener("click", () => {
  
  //get user input value
  const query = document.getElementById("food-input").value.trim();

  //send alert to user if input field is empty
  if (!query) return alert("Enter food/supplement name.");

  //GET request to the Ninjas Nutrition API
  fetch(`https://api.api-ninjas.com/v1/nutrition?query=${encodeURIComponent(query)}`, {
    headers: { 'X-Api-Key': 'BQGUxYUVAEaNdil2DBPOmg==RlXZffZO1X2Y4gWf' } // my unique API key from signing up on site
  })
    .then(res => {
      //error throwing for response
      if (!res.ok) throw new Error(res.statusText);
      return res.json(); // Parse response body as JSON
    })
    .then(data => {
      const container = document.getElementById("nutrition-results"); //locate container in order to store and display the results

      //messahe to display if no data is returned
      if (!data || data.length === 0) {
        container.innerHTML = "<p>Nutrition data not found.</p>";
        return;
      }

      //get first element generated from response
      const info = data[0];

      //HTML format of nutrition info
      container.innerHTML = `
        <h3>${info.name}</h3>
        <p>Calories: ${info.calories} kcal</p>
        <p>Protein: ${info.protein_g} g</p>
        <p>Carbs: ${info.carbohydrates_total_g} g</p>
        <p>Fat: ${info.fat_total_g} g</p>
      `;
    })
    .catch(err => {
      // error catching and handling
      console.error(err);
      document.getElementById("nutrition-results").innerHTML = "<p>Error retrieving nutrition data.</p>";
    });
});
