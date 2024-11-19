<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Customer Registration - Adventure Time</title>
    <style>
        /* Vanilla CSS Styling for the Adventure Time-themed form */
        body {
            font-family: 'Comic Sans MS', sans-serif; /* Cartoonish, playful font */
            background-color: #ffec99; /* Bright yellow background */
            margin: 0;
            padding: 0;
            background-image: url('https://example.com/adventure-time-background.png'); /* Optional: Add a fun background */
            background-size: cover;
            background-position: center;
        }

        .container {
            width: 60%;
            margin: 50px auto;
            padding: 30px;
            background-color: #fff;
            border-radius: 15px;
            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.1);
            text-align: center;
        }

        h1 {
            color: #FF6347; /* Adventure Time red-orange color */
            font-size: 3em;
            text-shadow: 2px 2px 5px rgba(0, 0, 0, 0.3);
            margin-bottom: 40px;
        }

        form {
            display: flex;
            flex-direction: column;
            justify-content: center;
        }

        .form-group {
            margin-bottom: 25px;
        }

        label {
            margin-bottom: 8px;
            font-weight: bold;
            color: #008080; /* Playful, warm color */
            font-size: 1.1em;
        }

        input, textarea {
            padding: 12px;
            margin-bottom: 15px;
            border-radius: 8px;
            border: 1px solid #008080; /* Red-orange border */
            font-size: 1.1em;
            width: 100%;
            transition: border-color 0.3s;
        }

        input:focus, textarea:focus {
            border-color: #32CD32; /* Bright green border on focus */
            outline: none;
        }

        button {
            padding: 15px 25px;
            background-color: #32CD32; /* Bright green button */
            color: #fff;
            font-size: 1.3em;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        button:hover {
            background-color: #28a745; /* Darker green on hover */
        }

        .alert {
            color: red;
            font-size: 1em;
            text-align: center;
            display: none;
        }

        .form-group input::placeholder,
        .form-group textarea::placeholder {
            color: #FF6347; /* Adventure Time red-orange color */
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .container {
                width: 80%;
            }
        }

        @media (max-width: 480px) {
            .container {
                width: 90%;
            }
        }

    </style>
</head>
<body>

    <div class="container">
        <h1>Customer Registration</h1>

        <!-- Success or error message -->
        <div class="alert" id="error-message">An error occurred. Please try again.</div>

        <!-- Customer registration form -->
        <form id="customer-form" method="POST" action="create-customer.php">
            <div class="form-group">
                <label for="name">Full Name</label>
                <input type="text" id="name" name="name" required placeholder="Enter your full name" value="Nene De Leon">
            </div>
            <div class="form-group">
                <label for="email">Email Address</label>
                <input type="email" id="email" name="email" required placeholder="Enter your email address" value="Nene@DeLeon.ph">
            </div>
            <div class="form-group">
                <label for="phone">Phone Number</label>
                <input type="text" id="phone" name="phone" required placeholder="Enter your phone number" value="+639123456789">
            </div>

            <div class="form-group">
                <label for="address-line1">Address Line 1</label>
                <input type="text" id="address-line1" name="address[line1]" required placeholder="Enter your address line 1" value="Mabuhay St.">
            </div>
            <div class="form-group">
                <label for="address-line2">Address Line 2</label>
                <input type="text" id="address-line2" name="address[line2]" placeholder="Enter your address line 2" value="Masaya Village">
            </div>
            <div class="form-group">
                <label for="address-state">State</label>
                <input type="text" id="address-state" name="address[state]" placeholder="Enter your state" value="">
            </div>
            <div class="form-group">
                <label for="address-city">City</label>
                <input type="text" id="address-city" name="address[city]" required placeholder="Enter your city" value="Angeles City">
            </div>
            <div class="form-group">
                <label for="address-country">Country</label>
                <input type="text" id="address-country" name="address[country]" required placeholder="Enter your country" value="Philippines">
            </div>
            <div class="form-group">
                <label for="address-postal_code">Postal Code</label>
                <input type="text" id="address-postal_code" name="address[postal_code]" required placeholder="Enter your postal code" value="2019">
            </div>

            <button type="submit">Register</button>
        </form>
    </div>

    <script>
    document.getElementById('customer-form').addEventListener('submit', function(event) {
        let email = document.getElementById('email').value;
        let phone = document.getElementById('phone').value;

        // Basic validation
        if (!email || !phone) {
            event.preventDefault();
            alert('Please fill in all required fields.');
        }
    });
    </script>

</body>
</html>
