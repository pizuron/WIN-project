<?php
session_start();

$menu = [
    1 => ['name' => 'Margherita Pizza', 'price' => 8.50],
    2 => ['name' => 'Spaghetti Bolognese', 'price' => 10.00],
    3 => ['name' => 'Caesar Salad', 'price' => 7.00],
    4 => ['name' => 'Grilled Chicken', 'price' => 12.00],
];

// Update cart quantities
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['quantities'])) {
    foreach ($_POST['quantities'] as $id => $qty) {
        $qty = max(0, (int)$qty);
        if ($qty === 0) {
            unset($_SESSION['cart'][$id]);
        } else {
            $_SESSION['cart'][$id] = $qty;
        }
    }
    header('Location: cart.php');
    exit;
}

// Calculate total
$total = 0;
$cartItems = [];
if (isset($_SESSION['cart']) && !empty($_SESSION['cart'])) {
    foreach ($_SESSION['cart'] as $id => $qty) {
        if (isset($menu[$id])) {
            $item = $menu[$id];
            $item['qty'] = $qty;
            $item['subtotal'] = $qty * $item['price'];
            $total += $item['subtotal'];
            $cartItems[$id] = $item;
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8" />
<title>Your Cart</title>
<style>
  body { font-family: Arial, sans-serif; max-width: 600px; margin: 30px auto; }
  h1 { text-align: center; }
  table { width: 100%; border-collapse: collapse; }
  th, td { border: 1px solid #ddd; padding: 8px; text-align: center; }
  th { background-color: #f4a261; color: white; }
  input[type=number] { width: 50px; }
  button { background-color: #2a9d8f; color: white; border: none; padding: 6px 12px; cursor: pointer; }
  button:hover { background-color: #21867a; }
  nav a { margin: 0 10px; }
</style>
</head>
<body>

<nav>
  <a href="index.php">Menu</a> |
  <a href="cart.php">Cart (<?= isset($_SESSION['cart']) ? array_sum($_SESSION['cart']) : 0 ?>)</a> |
  <a href="about.php">About</a>
</nav>

<h1>Your Cart</h1>

<?php if (empty($cartItems)): ?>
    <p>Your cart is empty. <a href="index.php">Go back to menu</a>.</p>
<?php else: ?>
<form method="post" action="cart.php">
<table>
  <thead>
    <tr><th>Dish</th><th>Unit Price</th><th>Quantity</th><th>Subtotal</th></tr>
  </thead>
  <tbody>
    <?php foreach ($cartItems as $id => $item): ?>
    <tr>
      <td><?= htmlspecialchars($item['name']) ?></td>
      <td>$<?= number_format($item['price'], 2) ?></td>
      <td><input type="number" name="quantities[<?= $id ?>]" value="<?= $item['qty'] ?>" min="0" /></td>
      <td>$<?= number_format($item['subtotal'], 2) ?></td>
    </tr>
    <?php endforeach; ?>
  </tbody>
</table>

<p><strong>Total: $<?= number_format($total, 2) ?></strong></p>
<button type="submit">Update Cart</button>
</form>

<p><a href="checkout.php">Proceed to Checkout</a></p>
<?php endif; ?>

</body>
</html>
