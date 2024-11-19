<?php
// create-customer.php

require 'init.php';  // Assumed that Stripe is already initialized here.

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Sanitize and validate form inputs
    $name = filter_var($_POST['name'], FILTER_SANITIZE_STRING);
    $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
    $phone = filter_var($_POST['phone'], FILTER_SANITIZE_STRING);
    $address = filter_var($_POST['address'], FILTER_SANITIZE_STRING);

    try {
        // Create a customer on Stripe
        $customer = $stripe->customers->create([
            'name' => $name,
            'email' => $email,
            'phone' => $phone,
            'address' => [
                'line1' => $address, // Assuming no line2, state, or country is required
                'city' => 'City', // Defaulting to 'City', change as necessary
                'country' => 'US' // Default country, change as needed
            ]
        ]);

        // Display the customer details upon successful creation
        echo '<div class="container">';
        echo '<div class="success-message">';
        echo '<h1>Customer Registered Successfully!</h1>';
        echo '<p><strong>Name:</strong> ' . htmlspecialchars($name) . '</p>';
        echo '<p><strong>Email:</strong> ' . htmlspecialchars($email) . '</p>';
        echo '<p><strong>Phone:</strong> ' . htmlspecialchars($phone) . '</p>';
        // echo '<p><strong>Address:</strong> ' . htmlspecialchars($address) . '</p>';
        echo '<p><strong>Stripe Customer ID:</strong> ' . htmlspecialchars($customer->id) . '</p>';
        echo '</div>';
        echo '</div>';

    } catch (\Stripe\Exception\ApiErrorException $e) {
        // If an error occurs, handle it here (e.g., invalid data, network issues, etc.)
        echo '<div class="container">';
        echo '<div class="error-message">';
        echo 'Error creating customer: ' . $e->getMessage();
        echo '</div>';
        echo '</div>';
    }
}
?>

<style>
    /* Adventure Time-inspired theme */
    body {
        font-family: 'Comic Sans MS', sans-serif; /* Cartoonish font */
        background-color: #ffec99; /* Adventure Time's warm yellow */
        color: #4B4B4B; /* Text color to resemble the dark tones of Adventure Time */
        margin: 0;
        padding: 0;
        background-image: url('https://example.com/your-adventure-time-background.png'); /* Optional fun background image */
        background-size: cover;
        background-position: center;
    }

    .container {
        width: 70%;
        margin: 50px auto;
        padding: 20px;
        background-color: #FF6F61; /* Coral color - vibrant */
        border-radius: 15px;
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.3);
        text-align: center;
    }

    h1 {
        color: #FFFFFF;
        font-size: 2em;
        text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.5);
    }

    p {
        font-size: 1.3em;
        margin: 10px 0;
        color: #FFFFFF;
    }

    .success-message {
        background-color: #4CAF50; /* Green background for success */
        color: white;
        padding: 25px;
        border-radius: 12px;
        font-family: 'Comic Sans MS', sans-serif;
        text-align: left;
        box-shadow: 0 5px 10px rgba(0, 0, 0, 0.2);
    }

    .error-message {
        background-color: #FF6347; /* Red-orange for errors */
        color: white;
        padding: 25px;
        border-radius: 12px;
        font-family: 'Comic Sans MS', sans-serif;
        text-align: center;
        box-shadow: 0 5px 10px rgba(0, 0, 0, 0.2);
    }

    .success-message p,
    .error-message p {
        font-size: 1.2em;
    }

    .success-message strong,
    .error-message strong {
        font-weight: bold;
        font-size: 1.4em;
        color: #FFEE58; /* Bright yellow for contrast */
    }

    .container p {
        font-size: 1.5em;
        color: #fff;
        font-weight: bold;
    }

    .button {
        padding: 12px 20px;
        font-size: 1.1em;
        background-color: #FFD700; /* Adventure Time yellow */
        color: black;
        border-radius: 8px;
        border: none;
        cursor: pointer;
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
    }

    .button:hover {
        background-color: #FFB800;
    }
</style>
