<!DOCTYPE html>
<html lang="en">
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
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="contact.php">Help</a>
                    </li>
                        <ul id="suggestions-list" class="list-group position-absolute w-30" style="z-index: 1000; max-height: 200px; overflow-y: auto; top: 60px;"></ul>
                        <li class="nav-item" id="image-mine">
                            <a href="cart.php" class="fas cart-4">
                                <img src="assets/images/Cart.png" alt="Cart Shopping" style="width: 34px; height: 34px;">
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="account.php" class="fas profile-4">
                                <img src="assets/images/Profile.png" alt="Circle User" style="width: 34px; height: 34px;">
                            </a>
                        </li>
                </ul>

            </div>
        </div>
    </nav>


    <div class="container" style="margin-top: 100px;">
        <div class="alert alert-success" role="alert">
            Your order has been placed successfully!
        </div>
        <h2>Order Status: <span class="badge bg-warning">Unconfirmed</span></h2>
        <?php if (isset($_GET['order_id'])) : ?>
            <p>Order ID: <?= htmlspecialchars($_GET['order_id']) ?></p> <!-- Added for debugging -->
            <a href="confirm_order.php?order_id=<?= $_GET['order_id'] ?>" class="btn btn-success mt-3">Confirm Order</a>
        <?php else : ?>
            <p>No Order ID found.</p> <!-- Added for debugging -->
        <?php endif; ?>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ENjdO4Dr2bkBIFxQpeoA6gx04mxzN3ca2m/aLAPJYLGQF7PyMOf+763tKtcw4MCg" crossorigin="anonymous"></script>
</body>

</html>