<!DOCTYPE html>
<html lang="en">

<head>
  <title>Shopping Cart Page</title>
  <meta charset="UTF-8">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css"
    integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">
  <link rel="stylesheet" href="/css/cartstyle.css">
  <link rel="stylesheet" href="/css/sharedstyle.css">
</head>

<body>
  <!--Navigation bar-->
  <div class="container-fluid header-container">
    <nav class="navbar navbar-expand-md navbar-light">
      <div class="brand">
        <h1>Spreads</h1>
        <img class="icon" src="/img/logo.png" alt="jar icon">
      </div>
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#main-navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="main-navigation">
        <ul class="navbar-nav ml-auto">
          <li class="nav-item"><a class="nav-link" href="index.html">Home</a></li>
          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="show_product.php" id="navbarDropdown" role="button"
              aria-haspopup="true" aria-expanded="false">
              Products
            </a>
            <div class="dropdown-menu" aria-labelledby="navbarDropdown">
              <a class="dropdown-item" href="show_product.php">Peanut Butter</a>
              <a class="dropdown-item" href="show_product.php">Almond Butter</a>
              <a class="dropdown-item" href="show_product.php">Pistachio Butter</a>
              <a class="dropdown-item" href="show_product.php">Cashew Butter</a>
              <a class="dropdown-item" href="show_product.php">Gift Set</a>
            </div>
          </li>
          <li class="nav-item"><a class="nav-link" href="faq.html">FAQs</a></li>
          <li class="nav-item"><a class="nav-link" href="#contact-us">Contact Us</a></li>
          <li class="nav-item"><a class="cart" href="cart.php"><img src="/img/cart.png" class="avatar"></a></li>
          <li class="nav-item"><a class="user" href="login.html"><img src="/img/user.png" class="avatar"></a></li>
        </ul>
      </div>
    </nav>
  </div>

  <div class="quick-nav">
    <a href="index.html">Home</a>
    <p>&gt</p>
    <p>Shopping Cart</p>
  </div>

  <?php
$servername = "localhost:3306";
$username = "root";
$password = "";
$dbname = "sse3308";

// Create connection
$conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

session_start();

// Initialize the cart session as an array if it's not already set
if (!isset($_SESSION['cart']) || !is_array($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

// Handle removal of a cart item
if (isset($_GET['remove']) && is_numeric($_GET['remove']) && isset($_SESSION['cart'][$_GET['remove']])) {
    // Remove the product from the shopping cart
    unset($_SESSION['cart'][$_GET['remove']]);
}

// Check if the form data is received correctly
if (isset($_POST['product_id'], $_POST['quantity'])) {
    $product_id = (int)$_POST['product_id'];
    $quantity = (int)$_POST['quantity'];

    // Fetch product information from the database
    $sql = "SELECT name, price, image FROM product_info WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->execute([$product_id]);

    if ($stmt->rowCount() > 0) {
        $product = $stmt->fetch(PDO::FETCH_ASSOC);

        // Add the product to the cart session
        if ($quantity > 0) {
            // Check if the product already exists in the cart
            if (array_key_exists($product_id, $_SESSION['cart'])) {
                $_SESSION['cart'][$product_id] += $quantity;
            } else {
                $_SESSION['cart'][$product_id] = $quantity;
            }
        }

        // Redirect back to the cart page to display the updated cart
        header("Location: cart.php");
        exit();
    } else {
        echo "<p>Product not found</p>";
    }
}

// Display cart items
$subtotal = 0;
$products = [];
if (!empty($_SESSION['cart'])) {
    foreach ($_SESSION['cart'] as $id => $qty) {
        $stmt = $conn->prepare("SELECT * FROM product_info WHERE id = ?");
        $stmt->execute([$id]);
        $product = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($product) {
            $product['quantity'] = $qty;
            $products[] = $product;

            $price = floatval(str_replace('RM', '', $product['price']));
            if (is_numeric($price)) {
                $subtotal += $price * $qty;
            } else {
                echo "<p>Error: Product price is not set or not a number.</p>";
            }
        }
    }
} else {
    echo "<p>Your cart is empty</p>";
}
$_SESSION['subtotal'] = $subtotal;
?>


<!-- Shopping Cart -->
<section>
    <div class="container">
        <h1 class="title">Shopping Cart</h1>
        <div class="row">
        <table id="shoppingCart" class="table">
    <thead>
        <tr>
            <th class="small-column"></th>
            <th class="product-column">Product</th>
            <th class="small-column">Price</th>
            <th class="small-column">Quantity</th>
            <th class="small-column"></th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($products as $product): ?>
        <tr>
            <td class="small-column">
                <img src="<?= $product['image'] ?>" alt="Product Image">
            </td>
            <td class="product-column">
                <p class="productname"><?= $product['name'] ?></p>
            </td>
            <td class="small-column price">
                <?= $product['price'] ?>
            </td>
            <td class="small-column quantity">
                <input type="number" name="quantity-<?= $product['id'] ?>" 
                       value="<?= $_SESSION['cart'][$product['id']] ?>" min="1" required>
            </td>
            <td class="small-column action text-center">
                <a href="cart.php?remove=<?= $product['id'] ?>" class="btn btn-sm remove">
                    <img src="/img/remove.png" alt="Remove">
                </a>
            </td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>

        </div>
        <a href="checkout.php"><button class="btn-lg btn-block checkout">Checkout</button></a>
    </div>
</section>


  <!--Contact form & Footer-->
  <footer class="bg-body-tertiary text-lg-start" style="background-color: #f1e2c5">
    <div class="row">
      <div class="col-8">
        <form class="contact-form" method="post" action="post_message.php" id="contact">
          <div class="form-title">
            <h5 id="contact-us">CONTACT</h5>
            <h6>US</h6>
          </div>
          <div class="form-body-item">
            <div class="form-group">
              <input type="text" id="name" class="input" placeholder="NAME" name="username" required>
              <input type="email" id="email" class="input" placeholder="EMAIL" name="email" required>
              <input type="text" id="message" class="input" placeholder="MESSAGE" name="message" required>
              <button type="submit" form="contact" value="Submit">Send</button>
            </div>
          </div>
        </form>
        <div class="copyright text-center">
          © 2024 Copyright:
          <a class="text-body" href="index.html">Spreads.com</a>
        </div>

      </div>
      <div class="col-4">
        <img src="/img/form-image.png" alt="spreads image">
      </div>
    </div>
  </footer>

  <script src="main.js"></script>
</body>

</html>