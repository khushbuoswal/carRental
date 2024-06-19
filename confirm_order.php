<?php
session_start();
ob_start(); // Start output buffering

// Database connection
$host = '127.0.0.1';
$dbname = 'car_site';
$username = 'root';
$password = '';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo "Database connection failed: " . $e->getMessage();
    exit();
}

// Load the cars JSON file
$carsJson = file_get_contents('cars.json');
$cars = json_decode($carsJson, true);


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get user details from the session
    $name = $_POST['name'];
    $mobile = $_POST['mobile'];
    $email = $_POST['email'];
    $license = isset($_POST['license']) ? $_POST['license'] : '';

    // Get cart details from the session
    $cart = $_SESSION['cart'];
    $startDate = $_SESSION['start_date'];
    $endDate = $_SESSION['end_date'];

    // Prepare an SQL statement to insert the order into the database
    $sql = "INSERT INTO orders (name, email, phone, driver_license, start_date, end_date, status) 
            VALUES (:name, :email, :phone, :driver_license, :start_date, :end_date, 'unconfirmed')";

    $stmt = $pdo->prepare($sql);
    $stmt->execute([
        ':name' => $name,
        ':email' => $email,
        ':phone' => $mobile,
        ':driver_license' => $license,
        ':start_date' => $startDate,
        ':end_date' => $endDate,
    ]);

    // Get the last inserted order ID
    $orderId = $pdo->lastInsertId();

    // Insert each cart item into the order_items table
    foreach ($cart as $item) {
        $sql = "INSERT INTO order_items (order_id, product_name, product_price, quantity) 
                VALUES (:order_id,:product_name, :product_price, :quantity)";

        $stmt = $pdo->prepare($sql);
        $stmt->execute([
            ':order_id' => $orderId,
            ':product_name' => $item['product_name'],
            ':product_price' => $item['product_price'],
            ':quantity' => $item['quantity']
        ]);

                
    }


    // Clear the session data after saving to the database
    unset($_SESSION['cart']);
    unset($_SESSION['user_details']);
    unset($_SESSION['start_date']);
    unset($_SESSION['end_date']);

    // Redirect to a confirmation page or display a success message
header("Location: order_confirmation.php?order_id=$orderId&status=unconfirmed");

    exit();
}


elseif (isset($_GET['order_id'])) {
    // Handle order confirmation

    $orderId = $_GET['order_id'];

    // Update the order status to 'confirmed'
    $sql = "UPDATE orders SET status = 'confirmed' WHERE order_id = :order_id";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([':order_id' => $orderId]);



    // Load the order items to update car quantity in the JSON data
    $sql = "SELECT product_name, quantity FROM order_items WHERE order_id = :order_id";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([':order_id' => $orderId]);
    $orderItems = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Update car quantity in the JSON data
    foreach ($orderItems as $item) {
        $productName = $item['product_name'];
        $quantity = $item['quantity'];
        foreach ($cars as &$car) {
            if ($car['model'] == $productName) {
                $car['quantity'] -= $quantity;
                break;
            }
        }
    }
                 
        // Save the updated JSON data
        file_put_contents('cars.json', json_encode($cars, JSON_PRETTY_PRINT));

    // Display confirmation message
    echo "<!DOCTYPE html>
    <html lang='en'>
    <head>
        <meta charset='UTF-8'>
        <meta name='viewport' content='width=device-width, initial-scale=1.0'>
        <title>Order Confirmation</title>
        <link href='https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css' rel='stylesheet' integrity='sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH' crossorigin='anonymous'>
    </head>
    <body style='background-color: rgb(243, 243, 228);'>
        <div class='container mt-5'>
            <div class='alert alert-success' role='alert'>
                Your order has been confirmed!
            </div>
            <a href='index.php' class='btn btn-success mt-3'>Go back to Home</a>
        </div>
        <script src='https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js' integrity='sha384-ENjdO4Dr2bkBIFxQpeoA6gx04mxzN3ca2m/aLAPJYLGQF7PyMOf+763tKtcw4MCg' crossorigin='anonymous'></script>
    </body>
    </html>";
} else {
    echo "<div class='container mt-5'>
            <div class='alert alert-danger' role='alert'>
                Invalid request!
            </div>
            <a href='index.php' class='btn btn-success mt-3'>Go back to Home</a>
          </div>";
}
ob_end_flush(); // End output buffering and flush the output
?>

