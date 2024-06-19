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
      <a class="nav-bar" href="#" style="color: rgb(3, 87, 3); font-size: 34px; font-weight: bold;">Car</a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse nav-twenty" id="navbarSupportedContent">
        <ul class="navbar-nav me-auto mb-2 mb-lg-0">

          <li class="nav-item">
            <a class="nav-link active" aria-current="page" href="index.php">Home</a>
          </li>
          <li class="nav-item">
            <a class="nav-link active" aria-current="page" href="contact.php">Help</a>
          </li>


          <li class="nav-item" id="image-mine">
            <a href="cart.php" class="fas cart-4">
              <img src="assets/images/Cart.png" alt="Cart Shopping" style="width: 34px; height: 34px;">
            </a>
          </li>
          <li class="nav-item">
            <a href="#" class="fas profile-4">
              <img src="assets/images/Profile.png" alt="Circle User" style="width: 34px; height: 34px;">
            </a>
          </li>
        </ul>

      </div>
    </div>
  </nav>

  <section class="my-5 py-5">
    <div class="row container mx-auto">
      <div class="text-center mt-3 pt-5 col-lg col-md-12 col-sm-12">
        <h3 class="font-weight-bold">Account Info</h3>
        <hr class="mx-auto">
        <div class="account-info">
          <p>Name: Khushbu Oswal<span><?php if (isset($_SESSION['user_name'])) {
                            echo $_SESSION['user_name'];
                          } ?></span></p>
          <p>Email: khushbuoswal13@gmail.com<span><?php if (isset($_SESSION['user_email'])) {
                            echo $_SESSION['user_email'];
                          } ?></span></p>
        </div>
      </div>
    </div>
  </section>



  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>

</html>
