<?php
session_start();

$menu = [
    1 => ['name' => 'Margherita Pizza', 'price' => 8.50],
    2 => ['name' => 'Spaghetti Bolognese', 'price' => 10.00],
    3 => ['name' => 'Caesar Salad', 'price' => 7.00],
    4 => ['name' => 'Grilled Chicken', 'price' => 12.00],
];

if (!isset($_SESSION['cart']) || empty($_SESSION['cart'])) {
    header('Location: index.php');
    exit;
}

$errors = [];
$customer = ['name' => '', 'email' => '', 'phone' => ''];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $customer['name'] = trim($_POST['name'] ?? '');
    $customer['email'] = trim($_POST['email'] ?? '');
    $customer['phone'] = trim($_POST['phone'] ?? '');

    if ($customer['name'] === '') {
        $errors[] = 'Name is required.';
    }
    if (!filter_var($customer['email'], FILTER_VALIDATE_EMAIL)) {
        $errors[] = 'Valid email is required.';
    }
    if ($customer['phone'] === '') {
        $errors[] = 'Phone is required.';
    }

    if (empty($errors)) {
        $_SESSION['customer'] = $customer;
        header('Location: order_confirmation.php');
        exit;
    }
}

// Calculate total price
$total = 0;
foreach ($_SESSION['cart'] as $id => $qty) {
    if (isset($menu[$id])) {
        $total += $menu[$id]['price'] * $qty;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8" />
<title>Checkout</title>
<style>
  body { font-family: Arial, sans-serif; max-width: 600px; margin: 30px auto; }
  h1 { text-align: center; }
  form { margin-top: 20px; }
  label { display: block; margin-top: 10px; }
  input[type=text], input[type=email], input[type=tel] { width: 100%; padding: 8px; margin-top: 5px; box-sizing: border-box; }
  button { margin-top: 20px; background-color: #2a9d8f; color: white; border: none; padding: 10px 20px; cursor: pointer; }
  button:hover { background-color: #21867a; }
  .error { color: red; }
  nav a { margin: 0 10px; }
</style>
</head>
<body>

<nav>
  <a href="index.php">Menu</a> |
  <a href="cart.php">Cart (<?= isset($_SESSION['cart']) ? array_sum($_SESSION['cart']) : 0 ?>)</a> |
  <a href="about.php">About</a>
</nav>

<h1>Checkout</h1>

<?php if ($errors): ?>
    <div class="error">
        <ul>
            <?php foreach ($errors as $e): ?>
            <li><?= htmlspecialchars($e) ?></li>
            <?php endforeach; ?>
        </ul>
    </div>
<?php endif; ?>

<p><strong>Total Amount: $<?= number_format($total, 2) ?></strong></p>

<form method="post" action="checkout.php">
    <label for="name">Name:</label>
    <input type="text" id="name" name="name" value="<?= htmlspecialchars($customer['name']) ?>" required />

    <label for="email">Email:</label>
    <input type="email" id="email" name="email" value="<?= htmlspecialchars($customer['email']) ?>" required />

    <label for="phone">Phone:</label>
    <input type="tel" id="phone" name="phone" value="<?= htmlspecialchars($customer['phone']) ?>" required />

    <button type="submit">Confirm Order</button>
</form>

</body>
</html>
