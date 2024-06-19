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

function validateName($name)
{
    return !empty($name) && preg_match("/^[a-zA-Z ]*$/", $name);
}

function validateMobile($mobile)
{
    return !empty($mobile) && preg_match("/^\d{10}$/", $mobile);
}

function validateEmail($email)
{
    return !empty($email) && filter_var($email, FILTER_VALIDATE_EMAIL);
}

function validateLicense($license)
{
    return !empty($license) && in_array($license, ['yes', 'no']);
}

// Process form submissions
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Handle Rent
    if (isset($_POST['Rent'])) {
        unset($_SESSION['user_details']);
        unset($_SESSION['cart']);
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
            unset($_SESSION['start_date']);
            unset($_SESSION['end_date']);
            $_SESSION['cart'] = array($product_id => $product_array); // This line replaces the entire cart
            storeCartInCookie($_SESSION['cart']);
        }
    }

    // Handle quantity update
    if (isset($_POST['update_quantity'])) {
        $product_id = $_POST['product_id'];
        $quantity = (int)$_POST['quantity'];
        $cars = getCarsData();
        $car = array_filter($cars, function ($c) use ($product_id) {
            return $c['model'] == $product_id;
        });
        if (!empty($car)) {
            $car = array_shift($car);
            $availableQuantity = $car['quantity'];
            if ($quantity > $availableQuantity) {
                echo json_encode(['success' => false, 'message' => 'Quantity is invalid']);
            } else {
                if (isset($_SESSION['cart'][$product_id])) {
                    $_SESSION['cart'][$product_id]['quantity'] = $quantity;
                    storeCartInCookie($_SESSION['cart']);
                    echo json_encode(['success' => true]);
                } else {
                    echo json_encode(['success' => false, 'message' => 'Product not found in cart']);
                }
            }
        } else {
            echo json_encode(['success' => false, 'message' => 'Product not found']);
        }
        exit();
    }

    // Handle date update
    if (isset($_POST['update_dates'])) {
        $startDate = $_POST['start_date'];
        $endDate = $_POST['end_date'];
        $_SESSION['start_date'] = $startDate;
        $_SESSION['end_date'] = $endDate;
        echo json_encode(['success' => true]);
        exit();
    }

    // Handle order submission
    if (isset($_POST['submit_order'])) {
        $name = $_POST['name'];
        $mobile = $_POST['mobile'];
        $email = $_POST['email'];
        $license = isset($_POST['license']) ? $_POST['license'] : '';
        if (!validateName($name) || !validateMobile($mobile) || !validateEmail($email) || !validateLicense($license) || $license == 'no') {
            echo json_encode(['success' => false, 'message' => 'Invalid input']);
            exit();
        }
        $_SESSION['user_details'] = [
            'name' => $name,
            'mobile' => $mobile,
            'email' => $email,
            'driver_license' => $license,
        ];
        // Redirect to confirmation page
        header("Location: order_confirmation.php");
        exit();
    }

    // Handle cart clearing
    if (isset($_POST['action']) && $_POST['action'] == 'clear_cart') {
        $_SESSION['cart'] = array();
        unset($_SESSION['user_details']);
        unset($_SESSION['start_date']);
        unset($_SESSION['end_date']);
        setcookie('cart', '', time() - 3600, "/"); // Clear the cart cookie
        header("Location: index.php");
        exit();
    }
}

// Remove product from cart
if (isset($_POST['remove_product'])) {
    $product_id = $_POST['product_id'];
    unset($_SESSION['cart'][$product_id]);
    storeCartInCookie($_SESSION['cart']);
    header("Location: cart.php");
    exit();
}

// Clear all cart data
if (isset($_GET['action']) && $_GET['action'] === 'clear') {
    unset($_SESSION['user_details']);
    unset($_SESSION['cart']);
    header('Location: index.php');
    exit();
}

$cartItems = isset($_SESSION['cart']) ? $_SESSION['cart'] : getCartFromCookie();
$startDate = isset($_SESSION['start_date']) ? $_SESSION['start_date'] : '';
$endDate = isset($_SESSION['end_date']) ? $_SESSION['end_date'] : '';

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


    <style>
        /* Set minimum width for date input fields */
        input[type="date"] {
            min-width: 200px;
            /* Adjust this value as needed */
        }
    </style>

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
                    <li class="nav-item"><a class="nav-link active" aria-current="page" href="contact.php">Help</a></li>
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

    <!--Cart-->

    <section class="cart container mt-5 py-5">
        <div class="container mt-5">
            <h2 class="font-weight-bold">Cart Details</h2>
            <hr>
        </div>
        <form method="post" action="confirm_order.php">
            <table class="mt-5 pt-5">
                <tr>
                    <th>Product</th>
                    <th>Quantity</th>
                    <th>Start Date</th>
                    <th>End Date</th>
                    <th>Subtotal</th> <!-- New column for Subtotal -->

                </tr>

                <?php if (!isCartEmpty()) { ?>
                    <?php foreach ($cartItems as $item) { 

                                                // Get car details from JSON data based on product ID
                                                $cars = getCarsData();
                                                $car = array_filter($cars, function ($c) use ($item) {
                                                    return $c['model'] == $item['product_id'];
                                                });
                                                $car = !empty($car) ? array_shift($car) : null; // Get the first match or null if not found
                                            
                        ?>
                        <tr>
                            <td>
                                <div class="product-info">
                                    <img src="<?php echo $item['product_image']; ?>" />
                                    <div>
                                        <p><?php echo $item['product_name']; ?></p>
                                        <small><span>$</span><span class="product-price-per-day"><?php echo $item['product_price']; ?></span> per day</small>
                                        <p class="card-text">Quantity: <?php echo isset($car['quantity']) ? $car['quantity'] : 'N/A'; ?></p>
                                       
                                    </div>
                                </div>
                            </td>
                            <td>
                                <input type="number" name="quantity" value="<?php echo $item['quantity']; ?>" min="1" class="quantity-input" data-product-id="<?php echo $item['product_id']; ?>" required />
                            </td>
                            <td>
                                <input type="date" id="start_date" name="start_date" placeholder="Select Start Date" value="<?php echo $startDate; ?>" required>
                            </td>
                            <td>
                                <input type="date" id="end_date" name="end_date" placeholder="Select End Date" value="<?php echo $endDate; ?>" required>
                            </td>
                            <td>
                                <!-- Display the subtotal for each item -->
                                <span class="subtotal"></span>
                            </td>
                            <!-- <td>
                                <form method="POST" action="cart.php">
                                    <input type="hidden" name="product_id" value="<?php echo $item['product_id']; ?>" />
                                    <input type="submit" name="remove_product" class="remove-btn" value="remove" />
                                </form>
                            </td> -->
                        </tr>
                    <?php } ?>
                    <tr>
                        <td colspan="3">
                            <!-- <a href="cart.php?action=clear" class="btn btn-danger">Clear Details</a> -->
                            <!-- <form method="POST" action="cart.php">
                                <input type="hidden" name="action" value="clear_cart" />
                                <button type="submit" class="btn btn-danger" id="cancel-btn">Clear Details</button>
                            </form> -->
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
            <div class="container mt-5">
                <h2 class="font-weight-bold">User Details</h2>
                <hr>
                <div class="mb-3">
                    <label for="name" class="form-label">Name</label>
                    <input type="text" class="form-control" id="name" name="name" required>
                    <div class="invalid-feedback">Please enter your name.</div>
                </div>
                <div class="mb-3">
                    <label for="mobile" class="form-label">Mobile Number</label>
                    <input type="tel" class="form-control" id="mobile" name="mobile" required>
                    <div class="invalid-feedback">Please enter a valid 10-digit mobile number.</div>
                </div>
                <div class="mb-3">
                    <label for="email" class="form-label">Email address</label>
                    <input type="email" class="form-control" id="email" name="email" required>
                    <div class="invalid-feedback">Please enter a valid email address.</div>
                </div>
                <div class="mb-3">
                    <label class="form-label">Valid License</label><br>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="license" id="valid_license_yes" value="yes" required>
                        <label class="form-check-label" for="valid_license_yes">Yes</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="license" id="valid_license_no" value="no" required>
                        <label class="form-check-label" for="valid_license_no">No</label>
                    </div>
                    <div id="license_error" class="invalid-feedback" style="display:none;">Please select whether you have a valid license or not.</div>
                    <div id="license_no_error" class="invalid-feedback" style="display:none;">You cannot proceed without a valid license.</div>
                </div>
            </div>
            <button type="submit" class="btn btn-primary" name="submit_order">Submit Order</button>
            <button type="button" id="clear-details" class="btn btn-secondary">Clear Details</button>

        </form>

        </form>
    </section>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://code.jquery.com/ui/1.13.3/jquery-ui.js"></script>


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
                                if (response.message === "Quantity is invalid") {
                                    alert("Quantity is invalid. Out of Stock");
                                    location.reload();
                                }
                            }
                        }
                    };
                    xhr.send(`update_quantity=true&product_id=${productId}&quantity=${quantity}`);
                });
            });
        });
    </script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const startDateInput = document.querySelector('#start_date');
            const endDateInput = document.querySelector('#end_date');

            startDateInput.addEventListener('change', updateDates);
            endDateInput.addEventListener('change', updateDates);

            function updateDates() {
                const startDate = startDateInput.value;
                const endDate = endDateInput.value;

                const xhr = new XMLHttpRequest();
                xhr.open('POST', 'cart.php', true);
                xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
                xhr.onreadystatechange = function() {
                    if (xhr.readyState === 4 && xhr.status === 200) {
                        const response = JSON.parse(xhr.responseText);
                        if (response.success) {
                            console.log('Dates updated successfully');
                        } else {
                            console.log('Failed to update dates');
                        }
                    }
                };
                xhr.send(`update_dates=true&start_date=${startDate}&end_date=${endDate}`);
            }
        });
    </script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const startDateInput = document.querySelector('#start_date');
            const endDateInput = document.querySelector('#end_date');
            const pricePerDay = <?php echo $item['product_price']; ?>; // Get the product price per day

            // Function to calculate the difference between two dates in days
            function dateDiffInDays(startDate, endDate) {
                const start = new Date(startDate);
                const end = new Date(endDate);
                const diffTime = Math.abs(end - start);
                const diffDays = Math.ceil(diffTime / (1000 * 60 * 60 * 24));
                return diffDays;
            }

            function updateSubtotal() {
                const startDate = startDateInput.value;
                const endDate = endDateInput.value;
                const quantity = document.querySelector('.quantity-input').value;
                const diffDays = dateDiffInDays(startDate, endDate);
                const subtotal = diffDays * pricePerDay * quantity;

                // Update the subtotal display
                document.querySelector('.subtotal').textContent = `$${subtotal.toFixed(2)}`;
            }

            startDateInput.addEventListener('change', updateSubtotal);
            endDateInput.addEventListener('change', updateSubtotal);
            document.querySelector('.quantity-input').addEventListener('change', updateSubtotal);

            // Initial update of the subtotal
            updateSubtotal();
        });
    </script>


    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const nameInput = document.getElementById('name');
            const mobileInput = document.getElementById('mobile');
            const emailInput = document.getElementById('email');
            const licenseInputs = document.querySelectorAll('input[name="license"]');
            const submitButton = document.querySelector('button[type="submit"]');



            // Retrieve user details from localStorage if available
            const savedName = localStorage.getItem('user_name');
            const savedMobile = localStorage.getItem('user_mobile');
            const savedEmail = localStorage.getItem('user_email');
            const savedLicense = localStorage.getItem('user_license');

            if (savedName) nameInput.value = savedName;
            if (savedMobile) mobileInput.value = savedMobile;
            if (savedEmail) emailInput.value = savedEmail;
            if (savedLicense) {
                licenseInputs.forEach(input => {
                    if (input.value === savedLicense) {
                        input.checked = true;
                    }
                });
            }


            nameInput.addEventListener('input', function() {
                validateName();
                saveUserDetails();
            });

            mobileInput.addEventListener('input', function() {
                validateMobile();
                saveUserDetails();
            });

            emailInput.addEventListener('input', function() {
                validateEmail();
                saveUserDetails();
            });

            licenseInputs.forEach(input => {
                input.addEventListener('change', function() {
                    validateLicense();
                    saveUserDetails();
                });
            });


            function saveUserDetails() {
                localStorage.setItem('user_name', nameInput.value);
                localStorage.setItem('user_mobile', mobileInput.value);
                localStorage.setItem('user_email', emailInput.value);
                const selectedLicense = document.querySelector('input[name="license"]:checked');
                if (selectedLicense) {
                    localStorage.setItem('user_license', selectedLicense.value);
                }
            }

            function validateName() {
                if (nameInput.value.trim() === '') {
                    nameInput.classList.add('is-invalid');
                } else {
                    nameInput.classList.remove('is-invalid');
                }
            }

            function validateMobile() {
                const mobileRegex = /^\d{10}$/;
                if (!mobileRegex.test(mobileInput.value.trim())) {
                    mobileInput.classList.add('is-invalid');
                } else {
                    mobileInput.classList.remove('is-invalid');
                }
            }

            function validateEmail() {
                const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
                if (!emailRegex.test(emailInput.value.trim())) {
                    emailInput.classList.add('is-invalid');
                } else {
                    emailInput.classList.remove('is-invalid');
                }
            }

            function validateLicense() {
                const selectedLicense = document.querySelector('input[name="license"]:checked');
                const licenseError = document.getElementById('license_error');
                const licenseNoError = document.getElementById('license_no_error');

                if (!selectedLicense) {
                    licenseError.style.display = 'block';
                    licenseNoError.style.display = 'none';
                } else if (selectedLicense.value === 'no') {
                    licenseError.style.display = 'none';
                    licenseNoError.style.display = 'block';
                } else {
                    licenseError.style.display = 'none';
                    licenseNoError.style.display = 'none';
                }
            }


            submitButton.addEventListener('click', function(event) {
                validateName();
                validateMobile();
                validateEmail();
                validateLicense();

                const selectedLicense = document.querySelector('input[name="license"]:checked');

                // Prevent form submission if any input is invalid
                if (document.querySelectorAll('.is-invalid').length > 0 || (selectedLicense && selectedLicense.value === 'no')) {
                    event.preventDefault();
                    event.stopPropagation();
                } else {
                    // Clear user details from localStorage upon successful submission
                    localStorage.removeItem('user_name');
                    localStorage.removeItem('user_mobile');
                    localStorage.removeItem('user_email');
                    localStorage.removeItem('user_license');
                }
            });
        });
    </script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const clearDetailsButton = document.getElementById('clear-details');

            clearDetailsButton.addEventListener('click', function(event) {
                event.preventDefault(); // Prevent default button behavior

                // Clear form fields
                const nameField = document.getElementById('name');
                const mobileField = document.getElementById('mobile');
                const emailField = document.getElementById('email');
                const licenseOptions = document.querySelectorAll('input[name="license"]');

                nameField.value = '';
                mobileField.value = '';
                emailField.value = '';
                licenseOptions.forEach(option => {
                    option.checked = false;
                });

                // Clear user details from localStorage
                if (localStorage.getItem('user_name')) localStorage.removeItem('user_name');
                if (localStorage.getItem('user_mobile')) localStorage.removeItem('user_mobile');
                if (localStorage.getItem('user_email')) localStorage.removeItem('user_email');
                if (localStorage.getItem('user_license')) localStorage.removeItem('user_license');

                // Send request to clear cart details
                const xhr = new XMLHttpRequest();
                xhr.open('POST', 'cart.php', true);
                xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
                xhr.send('action=clear_cart');

                // Optionally, you can redirect to clear URL to refresh the page
                window.location.href = 'index.php';
            });
        });
    </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ENjdO4Dr2bkBIFxQpeoA6gx04mxzN3ca2m/aLAPJYLGQF7PyMOf+763tKtcw4MCg" crossorigin="anonymous"></script>



</body>

</html>