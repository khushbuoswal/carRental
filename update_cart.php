<?php
session_start();
ob_start(); // Start output buffering

function isCartEmpty()
{
    return empty($_SESSION['cart']);
}

function getCarsData()
{
    $json_data = file_get_contents('cars.json');
    return json_decode($json_data, true);
}

if (isset($_POST['Rent'])) {
    $cars = getCarsData();
    $carModel = $_POST['product_id'];
    $car = array_filter($cars, function ($c) use ($carModel) {
        return $c['model'] == $carModel;
    });

    if (!empty($car)) {
        $car = array_shift($car); // Get the first match
        $product_id = $car['model'];
        $product_name = $car['model'];
        $product_price = $car['price_per_day'];
        $product_image = $car['image'];

        $product_array = array(
            'product_id' => $product_id,
            'product_name' => $product_name,
            'product_price' => $product_price,
            'product_image' => $product_image,
            'quantity' => 1, // Always set quantity to 1 when adding a new car
        );

        // Check if the item already exists in the cart
        if (isset($_SESSION['cart'][$product_id])) {
            $_SESSION['cart'][$product_id] = $product_array; // Replace the existing entry with the new one
        } else {
            $_SESSION['cart'][$product_id] = $product_array; // Add new item to cart
        }

        storeCartInCookie($_SESSION['cart']);
    }
}

// Check if the request is for updating quantity
if (isset($_POST['update_quantity'])) {
    $product_id = $_POST['product_id'];
    $quantity = (int)$_POST['quantity'];

    if (isset($_SESSION['cart'][$product_id])) {
        $_SESSION['cart'][$product_id]['quantity'] = $quantity;
        storeCartInCookie($_SESSION['cart']);
    }

    echo json_encode(['success' => true]);
    exit();
}

function storeCartInCookie($cartData)
{
    $cartJson = json_encode($cartData);
    setcookie('cart', $cartJson, time() + (86400 * 30), "/"); // Cookie expires in 30 days
}

function getCartFromCookie()
{
    if (isset($_COOKIE['cart'])) {
        return json_decode($_COOKIE['cart'], true);
    } else {
        return array(); // Return an empty array if cart cookie doesn't exist
    }
}

$cartItems = isset($_SESSION['cart']) ? $_SESSION['cart'] : getCartFromCookie();

if (isset($_POST['remove_product'])) {
    $product_id = $_POST['product_id'];
    unset($_SESSION['cart'][$product_id]);
    storeCartInCookie($_SESSION['cart']);
    header("Location: cart.php");
    exit();
}

if (isset($_POST['action']) && $_POST['action'] == 'clear_cart') {
    $_SESSION['cart'] = array();
    setcookie('cart', '', time() - 3600, "/"); // Clear the cart cookie
    header("Location: cart.php");
    exit();
}

ob_end_flush(); // End output buffering and flush the output
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
                    <li class="nav-item"><a class="nav-link active" aria-current="page" href="index.php">Home</a></li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">Category</a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="category.php?type=SUV">SUV</a></li>
                            <li><a class="dropdown-item" href="category.php?type=Sedan">Sedan</a></li>
                            <li><a class="dropdown-item" href="category.php?type=Hatchback">Hatchback</a></li>
                        </ul>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">Brand</a>
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
                    <li class="nav-item"><a class="nav-link active" aria-current="page" href="contact.php">Help</a></li>
                    <li class="nav-item" id="image-mine">
                        <a href="cart.php" class="fas cart-2">
                            <img src="assets/images/Cart.png" alt="Cart Shopping" style="width: 34px; height: 34px;">
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="account.php" class="fas profile-2">
                            <img src="assets/images/Profile.png" alt="Circle User" style="width: 34px; height: 34px;">
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!--Cart-->
    <section class="cart container mt-5 py-5">
        <div class="container mt-5">
            <h2 class="font-weight-bold">Your Cart</h2>
            <hr>
        </div>

        <table class="mt-5 pt-5">
            <tr>
                <th>Product</th>
                <th>Quantity</th>
                <th>Action</th>
            </tr>

            <?php if (!isCartEmpty()) { ?>
                <?php foreach ($cartItems as $item) { ?>
                    <tr>
                        <td>
                            <div class="product-info">
                                <img src="<?php echo $item['product_image']; ?>" />
                                <div>
                                    <p><?php echo $item['product_name']; ?></p>
                                    <small><span>$</span><span class="product-price-per-day"><?php echo $item['product_price']; ?></span> per day</small>
                                </div>
                            </div>
                        </td>
                        <td>
                            <input type="number" name="quantity" value="<?php echo $item['quantity']; ?>" min="1" class="quantity-input" data-product-id="<?php echo $item['product_id']; ?>" />
                        </td>
                        <td>
                            <form method="POST" action="cart.php">
                                <input type="hidden" name="product_id" value="<?php echo $item['product_id']; ?>" />
                                <input type="submit" name="remove_product" class="remove-btn" value="remove" />
                            </form>
                        </td>
                    </tr>
                <?php } ?>
                <tr>
                    <td colspan="3">
                        <form method="POST" action="cart.php">
                            <input type="hidden" name="action" value="clear_cart" />
                            <button type="submit" class="btn btn-danger">Clear Cart</button>
                        </form>
                    </td>
                </tr>
            <?php } else { ?>
                <tr>
                    <td colspan="3">
                        <p>Your cart is empty.</p>
                    </td>
                </tr>
            <?php } ?>
        </table>

    </section>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ENjdO4Dr2bkBIFxQpeoA6gx04mxzN3ca2m/aLAPJYLGQF7PyMOf+763tKtcw4MCg" crossorigin="anonymous"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const quantityInputs = document.querySelectorAll('.quantity-input');

            quantityInputs.forEach(input => {
                input.addEventListener('change', function() {
                    const productId = this.dataset.productId;
                    const quantity = this.value;

                    const xhr = new XMLHttpRequest();
                    xhr.open('POST', 'cart.php', true);
                    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
                    xhr.onreadystatechange = function() {
                        if (xhr.readyState === 4 && xhr.status === 200) {
                            const response = JSON.parse(xhr.responseText);
                            if (response.success) {
                                console.log('Quantity updated successfully');
                            } else {
                                console.log('Failed to update quantity');
                            }
                        }
                    };
                    xhr.send(`update_quantity=true&product_id=${productId}&quantity=${quantity}`);
                });
            });
        });
    </script>



</body>

</html>
