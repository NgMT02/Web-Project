<!DOCTYPE html>
<html lang="en">

<head>
    <title>Check Out Page</title>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css"
        integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link rel="stylesheet" href="/css/checkoutstyle.css">
    <link rel="stylesheet" href="/css/sharedstyle.css">

    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" rel="stylesheet" />
    
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
                        <a class="nav-link dropdown-toggle" href="show_product.php" id="navbarDropdown" role="button" aria-haspopup="true" aria-expanded="false">
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
        <a href="cart.php">Shopping Cart</a>
        <p>&gt</p>
        <p>Checkout</p>
    </div>

    <!-- Check Out -->
    <?php
    session_start();

    $subtotal = isset($_SESSION['subtotal']) ? $_SESSION['subtotal'] : 0;

    $shipping_fee = 5.60;

    $total = $subtotal + $shipping_fee;
    ?>

    <div class="checkout_form" id="content">
       
        <h1>Checkout</h1>
        <form class="form">
            <div class="shipping_form">
                <h2>Shipping Information</h2>
                <label for="name" class="form_label">Full Name</label>
                <input type="text" name="name" class="form-control" placeholder="Enter Full Name" required>
                <label for="phoneNo" class="form_label">Phone Number</label>
                <input type="tel" name="phoneNo" class="form-control"
                    pattern="[0-9]{3}-[0-9]{3}[0-9]{4}|[0-9]{3}[0-9]{3}[0-9]{4}" placeholder="Enter Phone Number"
                    required>
                <label for="address" class="form_label">Address</label>
                <input type="text" name="address" class="form-control" placeholder="Enter Address" required>
                <label for="city" class="form_label">City</label>
                <input type="text" name="city" class="form-control" placeholder="Enter City" required>
                <div class="add_row">


                    <div class="row_input">
                        <label for="state" class="form_label">State</label>
                        <input type="text" id="stateInput" name="state" class="form-control" placeholder="Enter State" required>
                    </div>
                    
                    <div class="row_input">
                        <label for="postcode" class="form_label">Postcode</label>
                        <input type="text" name="postcode" class="form-control" placeholder="Enter Postcode" required>
                    </div>
                </div>
            </div>

            <div class="payment_form">
                <h2>Payment Method</h2>
                <div class="form__radios">
                    <div class="form__radio">
                        <label for="card">
                            <input id="card" name="payment-method" type="radio"
                                onclick="togglePaymentForm('card-form')">
                            <img class="icon" src="/img/atm-card.png" alt="Credit/Debit Card Icon">Credit/Debit Card
                        </label>

                        <div id="card-form" class="hidden">
                            <label for="card-number" class="form_label">Card Number</label>
                            <input type="text" name="card-number" class="form-control" placeholder="Enter Card Number"
                                required>
                            <label for="expiry-date" class="form_label">Expiry Date</label>
                            <input type="text" name="expiry-date" class="form-control" placeholder="MM/YY" required>
                            <label for="cvv" class="form_label">CVV</label>
                            <input type="text" name="cvv" class="form-control" placeholder="CVV" required>
                        </div>
                    </div>
                    <div class="form__radio">
                        <label for="ewallet">
                            <input id="ewallet" name="payment-method" type="radio"
                                onclick="togglePaymentForm('ewallet-form')">
                            <img class="icon" src="/img/ewallet.png" alt="E-Wallet Icon">E-Wallet
                        </label>
                        <div id="ewallet-form" class="hidden">
                            <label for="ewallet-selection" class="form_label">Select Your E-Wallet</label><br>
                            <input type="radio" name="ewallet" id="ewallet" value="tng"><img src="/img/tng.png">Touch 'N
                            Go<br>
                            <input type="radio" name="ewallet" id="ewallet" value="boost"><img
                                src="/img/boost.png">Boost

                        </div>
                    </div>
                </div>
            </div>
            <div class="bill_form">
                <h2>Shopping Bill</h2>
                <table>
                    <tbody>
                        <tr>
                            <td class="subtotal">Merchandise Subtotal</td>
                            <td class="subtotal" id="subtotal">RM<?=$subtotal?></td>
                        </tr>
                        <tr>
                            <td class="shipping_fee">Shipping Fee</td>
                            <td class="shipping_fee" id="shipping_fee">RM<?=$shipping_fee?></td>
                        </tr>
                        <tr>
                            <td class="total">Order Total</td>
                            <td class="total" id="total">RM<?=$total?></td>
                        </tr>
                    </tbody>
                </table>
                <div>
                    <button class="btn-lg btn-block" type="submit"><img class="icon" src="/img/checkout.png"
                            alt="Checkout Icon">Place Order</button>
                </div>
            </div>
            <!-- button to print -->
            <button id="print"><i class="fas fa-print"></i></button>  
        </form>
    </div>

    <!-- Contact form & Footer -->
    <footer class="bg-body-tertiary text-lg-start" style="background-color: #f1e2c5">
        <div class="row">
            <div class="col-8">
                <form class="contact-form" method="post" id="contact" action="post_message.php">
                    <div class="form-title">
                        <h5 id="contact-us">CONTACT</h5>
                        <h6>US</h6>
                    </div>
                    <div class="form-body-item">
                        <div class="form-group">
                            <input type = "text" id = "name" class="input" placeholder="NAME" name="username" required>
                            <input type = "email" id = "email" class="input" placeholder="EMAIL" name="email" required>
                            <input type = "text" id = "message" class="input" placeholder="MESSAGE" name="message" required>
                            <button type="submit" value="Submit">Send</button>
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

    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>
    <script src="main.js"></script>
</body>

</html>
