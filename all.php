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
          <li class="nav-item" id="image-mine">
            <a href="cart.php" class="fas cart-1">
              <img src="assets/images/Cart.png" alt="Cart Shopping" style="width: 34px; height: 34px;">
            </a>
          </li>
          <li class="nav-item">
            <a href="account.php" class="fas profile-1">
              <img src="assets/images/Profile.png" alt="Circle User" style="width: 34px; height: 34px;">
            </a>
          </li>
        </ul>

      </div>
    </div>
  </nav>

  <div class="container" style="margin-top: 100px;">
    <h1 id="all-products" class="text-center">All Cars</h1>

    <section id="category">
      <div class="container">
        <div class="row">
          <?php
          $json_data = file_get_contents('cars.json');
          $cars = json_decode($json_data, true);

          foreach ($cars as $car) {
            $button_class = $car['quantity'] > 0 ? 'btn-outline-success' : 'btn-outline-secondary disabled';
            $button_text = $car['quantity'] > 0 ? 'Rent' : 'Out of Stock';
            $quantity_disabled = $car['quantity'] > 0 ? '' : 'disabled';
          ?>
            <div class="col-md-4">
              <div class="card mb-5">
                <img src="<?php echo $car['image']; ?>" class="card-img-top" alt="<?php echo $car['model']; ?>">
                <div class="card-body">
                  <form method="POST" action="cart.php">
                    <input type="hidden" name="product_id" value="<?php echo $car['model']; ?>" />
                    <input type="hidden" name="product_image" value="<?php echo $car['image']; ?>" />
                    <input type="hidden" name="product_name" value="<?php echo $car['model']; ?>" />
                    <input type="hidden" name="product_price" value="<?php echo $car['price_per_day']; ?>" />
                    <h5 class="card-title"><?php echo $car['model']; ?></h5>
                    <p class="card-text">Price/day: $<?php echo $car['price_per_day']; ?></p>
                    <p class="card-text">Mileage: <?php echo $car['mileage']; ?></p>
                    <p class="card-text">Quantity: <?php echo $car['quantity']; ?></p>
                    <p class="card-text">Fuel type: <?php echo $car['fuel_type']; ?></p>
                    <p class="card-text">Details: <?php echo $car['description']; ?></p>
                    <p class="card-text">Seats: <?php echo $car['seats']; ?></p>
                    <button class="btn btn-success" type="submit" name="Rent" <?php echo $quantity_disabled; ?>>
                      <?php echo $button_text; ?>
                    </button>
                  </form>
                </div>
              </div>
            </div>
          <?php } ?>
        </div>
    </section>
  </div>


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