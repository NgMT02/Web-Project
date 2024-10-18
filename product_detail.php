<!DOCTYPE html>
<html lang="en">
<head>
    <title>Product Page</title>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css"
        integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">
    <link rel="stylesheet" href="/css/sharedstyle.css">
    <link rel="stylesheet" href="/css/detailstyle.css">
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.3/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.min.js"></script>
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
</head>
<input>
    <!-- Navigation bar -->
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
                        <a class="nav-link dropdown-toggle" href="show_product.php" id="navbarDropdown" role="button" aria-haspopup="true" aria-expanded="false">Products</a>
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
    <!-- Product Detail -->
    <div class="container product_detail">
        <?php
        $servername = "localhost:3306";
        $username = "root";
        $password = "";
        $dbname = "sse3308";

        $conn = new mysqli($servername, $username, $password, $dbname);

        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }
        session_start();
        // Get the product ID from the URL
        $productId = isset($_GET['id']) ? intval($_GET['id']) : 0;

        if ($productId > 0) {
            // Fetch product details from the database
            $sql = "SELECT * FROM product_info WHERE id = $productId";
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                $product = $result->fetch_assoc();
            } else {
                echo "<p>Product not found</p>";
            }
        } else {
            echo "<p>Invalid product ID</p>";
        }

        if (isset($product)):
            ?>
        <div class="card">
                <div class="imgBx">
                    <img src="<?=$product['image']?>" alt="Product Image">
                </div>
                <div class="details">
                    <div class="content">
                        <div class="description">
                            <h2><?=$product['name']?></h2>
                            <p><?=$product['description']?></p>
                            <?php if(isset($product['ingredients'])):?>
                            <!-- Nutrition facts table -->
                            <table>
                                <tr><th colspan="2">Nutrition Facts</th></tr>
                                <tr><td>Ingredients</td><td><?=$product['ingredients']?></td></tr>
                                <tr><td>Serving size</td><td><?=$product['serving_size']?></td></tr>
                                <tr><td>Calories</td><td><?=$product['calories']?></td></tr>
                                <tr><td>Total Fat</td><td><?=$product['total_fat_value']?>g (<?=$product['total_fat_percent']?>% )</td></tr>
                                <tr><td>Cholesterol</td><td><?=$product['cholesterol_value']?>mg (<?=$product['cholesterol_percent']?>%)</td></tr>
                                <tr><td>Sodium</td><td><?=$product['sodium_value']?>mg (<?=$product['sodium_percent']?>%)</td></tr>
                                <tr><td>Total Carbohydrate</td><td><?=$product['total_carbohydrate_value']?>g (<?=$product['total_carbohydrate_percent']?>%)</td></tr>
                                <tr><td>Sugars</td><td><?=$product['sugars_value']?>g</td></tr>
                                <tr><td>Protein</td><td><?=$product['protein_value']?>g</td></tr>
                            </table>
                            <?php endif;?>
                            <h3><?=$product['price']?></h3>
                        </div>
                            <div class="purchase">                     
                                <form id="cartForm" action="cart.php" method="post">
                                    <label>Quantity</label>
                                    <input type="number" name="quantity" value="1" min="1" placeholder="Quantity" required><br>
                                    <input type="hidden" name="product_id" value="<?=$product['id']?>"><br>
                                    <input type="submit" id = "addToCartButton" value = "Add To Cart">
                                </form> 
                            </div>
                        
                    </div>
                </div>
            </div>

            <?php else: ?>
            <p>Product not found</p>
            <?php endif; ?>
    </div>       

        
    <!-- Contact form & Footer -->
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
