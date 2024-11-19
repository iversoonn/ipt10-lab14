<?php
require "init.php";

$products = $stripe->products->all();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Adventure Time - Our Products</title>
    <style>
        /* Vanilla CSS for Adventure Time-inspired styling */
        body {
            font-family: 'Comic Sans MS', sans-serif; /* Cartoonish font */
            background-color: #ffec99; /* Adventure Time's warm yellow background */
            color: #4B4B4B;
            margin: 0;
            padding: 0;
            background-image: url('https://example.com/adventure-time-background.png'); /* Optional whimsical background image */
            background-size: cover;
            background-position: center;
        }

        .container {
            width: 90%;
            max-width: 1200px;
            margin: 0 auto;
            padding: 20px;
        }

        h1 {
            text-align: center;
            color: #FF6347; /* Adventure Time red-orange color */
            font-size: 3em;
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.3);
            margin-bottom: 40px;
        }

        .products {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
            gap: 20px;
            margin-top: 20px;
        }

        .product-card {
            background-color: #FFFFFF;
            border-radius: 15px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
            padding: 20px;
            text-align: center;
            transition: transform 0.3s ease;
        }

        .product-card:hover {
            transform: scale(1.05); /* Slight zoom effect on hover */
        }

        .product-image {
            max-width: 100%;
            border-radius: 8px;
            object-fit: cover;
            height: 200px;
            margin-bottom: 15px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.2);
        }

        .product-name {
            font-size: 1.4em;
            font-weight: bold;
            color: #FF6F61; /* Pinkish red */
            margin-bottom: 10px;
        }

        .product-price {
            font-size: 1.2em;
            color: #FFD700; /* Bright yellow (Adventure Time yellow) */
            margin-bottom: 15px;
            font-weight: bold;
        }

        .product-card button {
            padding: 12px 20px;
            background-color: #32CD32; /* Bright green */
            color: #fff;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            font-size: 1.1em;
            transition: background-color 0.3s;
        }

        .product-card button:hover {
            background-color: #28a745; /* Darker green on hover */
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .products {
                grid-template-columns: 1fr 1fr;
            }
        }

        @media (max-width: 480px) {
            .products {
                grid-template-columns: 1fr;
            }
        }

        /* Additional Styling for Fun Adventure Time Effects */
        .product-name, .product-price {
            font-family: 'Comic Sans MS', sans-serif;
            text-shadow: 1px 1px 2px rgba(0, 0, 0, 0.5);
        }

    </style>
</head>
<body>

    <div class="container">
        <h1>Our Adventure Time Products</h1>
        <div class="products">
            <?php foreach ($products as $product): ?>
                <div class="product-card">
                    <img class="product-image" src="<?php echo array_pop($product->images); ?>" alt="<?php echo $product->name; ?>">
                    <div class="product-name"><?php echo $product->name; ?></div>
                    <?php 
                        $price = $stripe->prices->retrieve($product->default_price);
                        $formattedPrice = number_format($price->unit_amount / 100, 2);
                    ?>
                    <div class="product-price"><?php echo strtoupper($price->currency) . ' ' . $formattedPrice; ?></div>
                    <button>Buy Now</button>
                </div>
            <?php endforeach; ?>
        </div>
    </div>

</body>
</html>
