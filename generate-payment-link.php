<?php
require 'init.php'; // Ensure your Stripe initialization is in this file

// Fetch all products from Stripe
$products = $stripe->products->all();

// When the form is submitted, process the selected products
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Initialize an array to store selected product line items
    $line_items = [];
    
    // Get selected products from form
    $selected_products = $_POST['products'];

    // Create line items for selected products
    foreach ($selected_products as $product_id) {
        $product = $stripe->products->retrieve($product_id);
        $price = $stripe->prices->retrieve($product->default_price);

        // Add product to line items
        $line_items[] = [
            'price' => $price->id, // Use price ID for line item
            'quantity' => 1 // Default quantity 1
        ];
    }

    // Create the payment link using selected line items
    try {
        $payment_link = $stripe->paymentLinks->create([
            'line_items' => $line_items,
        ]);

        // Get the payment link URL
        $payment_url = $payment_link->url;

        // Redirect to the generated payment URL
        header('Location: ' . $payment_url);
        exit();
    } catch (\Stripe\Exception\ApiErrorException $e) {
        // Handle error (e.g., failed API call)
        $error_message = 'Error creating payment link: ' . $e->getMessage();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Generate Payment Link</title>
    <style>
        body {
            font-family: 'Comic Sans MS', cursive, sans-serif;
            background-color: #ffec99;
            color: #333;
            margin: 0;
            padding: 0;
            background-image: url(); /* Adventure Time-style background image */
            background-size: cover;
            background-position: center;
        }

        .container {
            width: 60%;
            margin: 50px auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
            text-align: center;
        }

        h1 {
            color: #ff7f50;
            font-size: 3em;
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.5);
        }

        .product-list {
            margin-bottom: 20px;
            text-align: left;
            font-size: 1.2em;
            color: #333;
        }

        .product-list input {
            margin-right: 10px;
        }

        button {
            padding: 12px;
            background-color: #ff6347;
            color: white;
            font-size: 1.1em;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        button:hover {
            background-color: #ff4500;
        }

        .error-message, .success-message {
            font-size: 1.2em;
            padding: 10px;
            margin: 10px 0;
        }

        .error-message {
            color: #ff0000;
            background-color: #ffe4e1;
            border: 1px solid #ff0000;
        }

        .success-message {
            color: #008000;
            background-color: #e0ffe0;
            border: 1px solid #008000;
        }

        .adventure-image {
            width: 80px;
            height: auto;
            margin: 20px 0;
        }

        .success-message a {
            color: #008000;
            text-decoration: none;
            font-weight: bold;
        }

        .success-message a:hover {
            color: #005700;
        }
    </style>
</head>
<body>

<div class="container">
    <h1>Generate Payment Link</h1>
    <?php if (isset($error_message)): ?>
        <div class="error-message"><?= $error_message ?></div>
    <?php endif; ?>

    <?php if (isset($payment_url)): ?>
        <div class="success-message">
            <p>Payment link generated successfully!</p>
            <p><a href="<?= $payment_url ?>" target="_blank">Click here to complete the payment</a></p>
        </div>
    <?php else: ?>

        <!-- Payment Link Generation Form -->
        <form method="POST" action="generate-payment-link.php">
            <label for="products">Select Products</label>
            <div class="product-list">
                <?php foreach ($products as $product): ?>
                    <div>
                        <input type="checkbox" name="products[]" value="<?= $product->id ?>"> <?= $product->name ?>
                    </div>
                <?php endforeach; ?>
            </div>

            <button type="submit">Generate Payment Link</button>
        </form>

    <?php endif; ?>
</div>

</body>
</html>
