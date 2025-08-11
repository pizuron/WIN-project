<?php
session_start();

$menu = [
    1 => ['name' => 'Margherita Pizza', 'price' => 8.50],
    2 => ['name' => 'Spaghetti Bolognese', 'price' => 10.00],
    3 => ['name' => 'Caesar Salad', 'price' => 7.00],
    4 => ['name' => 'Grilled Chicken', 'price' => 12.00],
];

if (!isset($_SESSION['cart']) || empty($_SESSION['cart']) || !isset($_SESSION['customer'])) {
    header('Location: index.php');
    exit;
}

$customer = $_SESSION['customer'];
$cart = $_SESSION['cart'];

// Calculate total
$total = 0;
$orderItems = [];
foreach ($cart as $id => $qty) {
    if (isset($menu[$id])) {
        $item = $menu[$id];
        $item['qty'] = $qty;
        $item['subtotal'] = $item['price'] * $qty;
        $total += $item['subtotal'];
        $orderItems[] = $item;
    }
}

// Clear session (simulate order saved)
session_destroy();
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8" />
<title>Order Confirmation</title>
<style>
  body { font-family: Arial, sans-serif; max-width: 600px; margin: 30px auto; }
  h1 { text-align: center; color: green; }
  table { width: 100%; border-collapse: collapse; margin-top: 20px; }
  th, td { border: 1px solid #ddd; padding: 8px; text-align: center; }
  th { background-color: #f4a261; color: white; }
  nav a { margin: 0 10px; }
</style>
</head>
<body>

<nav>
  <a href="index.php">Menu</a> |
  <a href="about.php">About</a>
</nav>

<h1>Thank you for your order!</h1>

<h2>Customer Details</h2>
<ul>
  <li><strong>Name:</strong> <?= htmlspecialchars($customer['name']) ?></li>
  <li><strong>Email:</strong> <?= htmlspecialchars($customer['email']) ?></li>
  <li><strong>Phone:</strong> <?= htmlspecialchars($customer['phone']) ?></li>
</ul>

<h2>Order Summary</h2>
<table>
  <thead>
    <tr><th>Dish</th><th>Quantity</th><th>Price</th><th>Subtotal</th></tr>
  </thead>
  <tbody>
    <?php foreach ($orderItems as $item): ?>
    <tr>
      <td><?= htmlspecialchars($item['name']) ?></td>
      <td><?= $item['qty'] ?></td>
      <td>$<?= number_format($item['price'], 2) ?></td>
      <td>$<?= number_format($item['subtotal'], 2) ?></td>
    </tr>
    <?php endforeach; ?>
  </tbody>
</table>
<p><strong>Total Paid: $<?= number_format($total, 2) ?></strong></p>

<p><a href="index.php">Back to Menu</a></p>

</body>
</html>
