<?php
// Convert JSON string to PHP array
$jsonData = file_get_contents('cars.json');
$cars = json_decode($jsonData, true);

// Check if the search query is provided
if (isset($_GET['query']) && !empty($_GET['query'])) {
  // Filter cars based on search query
  $searchQuery = strtolower($_GET['query']);
  $searchResults = array_filter($cars, function ($car) use ($searchQuery) {
    // Check if the search query matches the model or type of the car
    return strpos(strtolower($car['model']), $searchQuery) !== false || strpos(strtolower($car['type']), $searchQuery) !== false;
  });
} else {
  // If no search query provided, show all cars
  $searchResults = $cars;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Car Catalog</title>


  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
  <script src="https://kit.fontawesome.com/3ef8ae306d.js" crossorigin="anonymous"></script>
  <link rel="stylesheet" href="assets/css/style.css" />
</head>

<body style="background-color: rgb(243, 243, 228);">


  <!--Navbar-->
  <nav class="navbar navbar-expand-lg bg-body-tertiary py-3 fixed-top">
    <div class="container-fluid">
      <i class="fa-solid fa-car-alt" style="color: rgb(3, 87, 3); font-size: 34px;"></i>
      <a class="nav-bar" href="#" style="color: rgb(3, 87, 3); font-size: 34px; font-weight: bold;">CAR</a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse nav-twenty" id="navbarSupportedContent">
        <ul class="navbar-nav me-auto mb-2 mb-lg-0">

          <li class="nav-item">
            <a class="nav-link active" aria-current="page" href="index.php">Home</a>
          </li>
          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
              Category
            </a>
            <ul class="dropdown-menu">
              <li><a class="dropdown-item" href="category.php?type=SUV">SUV</a></li>
              <li><a class="dropdown-item" href="category.php?type=Sedan">Sedan</a></li>
              <li><a class="dropdown-item" href="category.php?type=Hatchback">Hatchback</a></li>
            </ul>
          </li>
          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
              Brand
            </a>
            <ul class="dropdown-menu">
              <li><a class="dropdown-item" href="brand.php?brand=Toyota">Toyota</a></li>
              <li><a class="dropdown-item" href="brand.php?brand=Honda">Honda</a></li>
              <li><a class="dropdown-item" href="brand.php?brand=Ford">Ford</a></li>
              <li><a class="dropdown-item" href="brand.php?brand=Volkswagen">Volkswagen</a></li>
              <li><a class="dropdown-item" href="brand.php?brand=Jeep">Jeep</a></li>
              <li><a class="dropdown-item" href="brand.php?brand=Nissan">Nissan</a></li>
              <li><a class="dropdown-item" href="brand.php?brand=Hyundai">Hyundai</a></li>
              <li><a class="dropdown-item" href="brand.php?brand=Chevrolet">Chevrolet</a></li>
              <li><a class="dropdown-item" href="brand.php?brand=Subaru">Subaru</a></li>
              <li><a class="dropdown-item" href="brand.php?brand=Kia">Kia</a></li>
              <li><a class="dropdown-item" href="brand.php?brand=Mazda">Mazda</a></li>

            </ul>
          </li>
          <li class="nav-item">
            <a class="nav-link active" aria-current="page" href="contact.php">Help</a>
          </li>

          <form class="d-flex" role="search" action="search.php" method="GET" style="padding-right: 10px;">
            <input class="form-control me-2" type="search" name="query" placeholder="Search Items" aria-label="Search">
            <button class="btn btn-outline-success" type="submit">
              <i class="fa-solid fa-magnifying-glass"></i>
            </button>
            <ul id="suggestions-list" class="list-group position-absolute w-30" style="z-index: 1000; max-height: 200px; overflow-y: auto; top: 60px;"></ul>
          </form>


          <li class="nav-item">
            <a href="cart.php" class="cart-1">
              <img src="assets/images/Cart.png" alt="Cart Shopping" style="width: 34px; height: 34px;">
            </a>
          </li>
          <li class="nav-item">
            <a href="account.php" class="profile-1">
              <img src="assets/images/Profile.png" alt="Circle User" style="width: 34px; height: 34px;">
            </a>
          </li>
        </ul>

      </div>
    </div>
  </nav>

  <!--Contact-->
  <section id="contact" class="container my-5 py-5">
    <div class="" container text-center mat-5>
      <h3>Help</h3>
      <hr class="mx-auto">
      <p class="w-50 mx-auto">
        Phone number: 890 486 585
      </p>
      <p class="w-50 mx-auto">
        Email: katherine13@gmail.com
      </p>
      <p class="w-50 mx-auto">
        Ask Questions
      </p>
    </div>
  </section>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>


  <script>
    // Function to fetch and display live search suggestions
    function showSuggestions(input) {
      if (input.length < 1) {
        // If the input is empty, show recent search keywords from local storage
        const recentSearches = JSON.parse(localStorage.getItem('recentSearches')) || [];
        updateSuggestions(recentSearches);
        return;
      }
      fetch('suggestions.php?input=' + input)
        .then(response => response.json())
        .then(data => {
          // Update the UI with the fetched suggestions
          updateSuggestions(data);
        })
        .catch(error => {
          console.error('Error fetching suggestions:', error);
        });
    }

    // Function to update the suggestions UI
    // Function to update the suggestions UI
    // Function to update the suggestions UI
    function updateSuggestions(suggestions) {
      const suggestionsList = document.getElementById('suggestions-list');
      suggestionsList.innerHTML = ''; // Clear previous suggestions

      // If there are no suggestions or recent searches, display a message instead
      if (suggestions.length === 0) {
        const listItem = document.createElement('li');
        listItem.textContent = 'No suggestions';
        listItem.classList.add('list-group-item');
        suggestionsList.appendChild(listItem);
        return; // Exit the function early
      }

      // If the first item in suggestions is an object, assume it's the format {model: 'suggestion'}
      // and extract the suggestion text from it
      if (typeof suggestions[0] === 'object' && suggestions[0].hasOwnProperty('model')) {
        suggestions.forEach(suggestion => {
          const listItem = document.createElement('li');
          listItem.textContent = suggestion.model;
          listItem.classList.add('list-group-item');
          suggestionsList.appendChild(listItem);
        });
      } else {
        // Otherwise, assume suggestions is an array of strings (recent searches)
        suggestions.forEach(suggestion => {
          const listItem = document.createElement('li');
          listItem.textContent = suggestion;
          listItem.classList.add('list-group-item');
          suggestionsList.appendChild(listItem);
        });
      }
    }



    // Event listener for input in the search box
    document.querySelector('.form-control').addEventListener('input', function() {
      // Show real-time suggestions as the user types
      showSuggestions(this.value);
    });



    // Event listener for click on a suggestion
    document.getElementById('suggestions-list').addEventListener('click', function(event) {
      // When a suggestion is clicked, fill the search box with the suggestion text and hide the suggestions
      if (event.target && event.target.nodeName === 'LI') {
        const clickedSuggestion = event.target.textContent;
        document.querySelector('.form-control').value = clickedSuggestion;
        this.innerHTML = ''; // Clear suggestions
      }
    });

    // Event listener for submitting the search form
    document.querySelector('form').addEventListener('submit', function(event) {
      // When the form is submitted, add the search keyword to recent searches in local storage
      const searchKeyword = document.querySelector('.form-control').value.trim();
      if (searchKeyword !== '') {
        let recentSearches = JSON.parse(localStorage.getItem('recentSearches')) || [];
        // Add the search keyword to the beginning of the recent searches array
        recentSearches.unshift(searchKeyword);
        // Keep only the latest 5 search keywords
        recentSearches = recentSearches.slice(0, 5);
        localStorage.setItem('recentSearches', JSON.stringify(recentSearches));
      }
    });

    // Event listener for focus on the search box
    // Event listener for focus on the search box
    document.querySelector('.form-control').addEventListener('focus', function() {
      // If the search box is focused and empty, show recent search keywords from local storage
      if (this.value === '') {
        const recentSearches = JSON.parse(localStorage.getItem('recentSearches')) || [];
        updateSuggestions(recentSearches);
      }
    });

    // Event listener for clicks outside the search box and suggestions list
    document.addEventListener('click', function(event) {
      const isClickInside = document.querySelector('.form-control').contains(event.target) ||
        document.getElementById('suggestions-list').contains(event.target);
      if (!isClickInside) {
        // If the click is outside the search box and suggestions list, hide the suggestions
        document.getElementById('suggestions-list').innerHTML = '';
      }
    });
  </script>

</body>

</html>