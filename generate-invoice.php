<?php
require 'init.php';

// Fetch customers and products from Stripe
$customers = $stripe->customers->all();
$products = $stripe->products->all();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get selected customer ID and selected products
    $customer_id = $_POST['customer_id'];
    $selected_product_ids = $_POST['products'];

    try {
        // Create an invoice for the selected customer
        $invoice = $stripe->invoices->create([
            'customer' => $customer_id,
        ]);

        // Add selected products to the invoice as line items
        foreach ($selected_product_ids as $product_id) {
            $product = $stripe->products->retrieve($product_id);
            $price = $stripe->prices->retrieve($product->default_price);

            $stripe->invoiceItems->create([
                'customer' => $customer_id,
                'price' => $price->id, // Add product price
                'invoice' => $invoice->id
            ]);
        }

        // Finalize the invoice
        $stripe->invoices->finalizeInvoice($invoice->id);

        // Retrieve the finalized invoice
        $invoice = $stripe->invoices->retrieve($invoice->id);

        // Display the invoice information and generate download links
        $invoice_url = $invoice->hosted_invoice_url;
        $invoice_pdf = $invoice->invoice_pdf;
        $total_amount = number_format($invoice->amount_due / 100, 2);
        $currency = strtoupper($invoice->currency);

    } catch (\Stripe\Exception\ApiErrorException $e) {
        $error_message = 'Error: ' . $e->getMessage();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Generate Invoice</title>
    <style>
        /* Adventure Time Theme */
        body {
            font-family: 'Comic Sans MS', cursive, sans-serif;
            background-color: #ffec99;
            margin: 0;
            padding: 0;
            background-image: url();
            background-size: cover;
            background-position: center;
            color: #333;
        }

        .container {
            width: 60%;
            margin: 50px auto;
            padding: 20px;
            background-color: rgba(255, 255, 255, 0.9);
            border-radius: 8px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
            text-align: center;
        }

        h1 {
            font-size: 2.5em;
            color: #ff6347;  /* Tomato color */
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.6);
        }

        label {
            font-size: 1.3em;
            margin: 10px 0;
            font-weight: bold;
            color: #008080;  /* Teal color */
        }

        select, button {
            width: 100%;
            padding: 12px;
            font-size: 1.1em;
            margin-bottom: 20px;
            border-radius: 5px;
            border: 2px solid #008080;
            background-color: #f1f1f1;
            color: #333;
        }

        select:focus, button:focus {
            outline: none;
            border-color: #ff6347;
        }

        .product-list {
            margin-bottom: 20px;
            text-align: left;
        }

        .product-list input {
            margin-right: 10px;
        }

        button {
            background-color: #ff6347;
            color: white;
            cursor: pointer;
            transition: background-color 0.3s;
            border: none;
        }

        button:hover {
            background-color: #ff4500;  /* OrangeRed color */
        }

        .invoice-buttons a {
            color: white;
            text-decoration: none;
            padding: 12px;
            display: inline-block;
            border-radius: 5px;
            margin: 10px;
        }

        .invoice-buttons a.download {
            background-color: #4682b4;  /* SteelBlue color */
        }

        .invoice-buttons a.payment {
            background-color: #32cd32;  /* LimeGreen color */
        }

        .invoice-buttons a:hover {
            opacity: 0.8;
        }

        .error-message {
            color: red;
            font-size: 1.2em;
            font-weight: bold;
        }
    </style>
</head>
<body>

<div class="container">
    <h1>Generate Invoice</h1>

    <?php if (isset($error_message)): ?>
        <div class="error-message"><?= $error_message ?></div>
    <?php endif; ?>

    <?php if (isset($invoice_url)): ?>
        <h3>Invoice Created Successfully!</h3>
        <p><strong>Invoice Total:</strong> <?= $currency ?> <?= $total_amount ?></p>

        <div class="invoice-buttons">
            <a href="<?= $invoice_pdf ?>" target="_blank" class="download">Download Invoice PDF</a>
            <a href="<?= $invoice_url ?>" target="_blank" class="payment">Go to Payment</a>
        </div>
    <?php else: ?>

        <!-- Invoice Generation Form -->
        <form method="POST" action="generate-invoice.php">
            <label for="customer">Select Customer</label>
            <select id="customer" name="customer_id" required>
                <option value="">Select a customer</option>
                <?php foreach ($customers as $customer): ?>
                    <option value="<?= $customer->id ?>"><?= $customer->name ?></option>
                <?php endforeach; ?>
            </select>

            <label>Select Products</label>
            <div class="product-list">
                <?php foreach ($products as $product): ?>
                    <div>
                        <input type="checkbox" name="products[]" value="<?= $product->id ?>"> <?= $product->name ?>
                    </div>
                <?php endforeach; ?>
            </div>

            <button type="submit">Generate Invoice</button>
        </form>

    <?php endif; ?>
</div>

</body>
</html>
