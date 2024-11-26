<?php
session_start();
// Database connection
require "configuration.php";

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Handle subscription choice
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $subscription_type = $_POST['subscription_type']; // Get selected plan
    $subscription_start_date = date('Y-m-d'); // Current date as start date
    $subscription_end_date = '';

    // Set subscription duration based on the plan
    if ($subscription_type == 'basic') {
        $subscription_end_date = date('Y-m-d', strtotime('+1 month')); // 1 month for basic plan
        $payment_amount = 9.99;
    } elseif ($subscription_type == 'standard') {
        $subscription_end_date = date('Y-m-d', strtotime('+1 month')); // 1 month for standard plan
        $payment_amount = 14.99;
    } elseif ($subscription_type == 'premium') {
        $subscription_end_date = date('Y-m-d', strtotime('+1 month')); // 1 month for premium plan
        $payment_amount = 19.99;
    }

    // Prepare the SQL query to insert the subscription information
    $stmt = $conn->prepare("INSERT INTO subscriptions (subscription_type, subscription_start_date, subscription_end_date, payment_status) 
                            VALUES (?, ?, ?, 'Pending')");

    // Check if the statement was prepared successfully
    if ($stmt === false) {
        die('Error preparing statement: ' . $conn->error);
    }

    // Bind parameters and execute the query
    $stmt->bind_param('sss', $subscription_type, $subscription_start_date, $subscription_end_date);

    if ($stmt->execute()) {
        echo "<p class='text-green-500 text-center'>Subscription updated successfully. Payment status is pending.</p>";

        // Redirect to PayPal payment page with the appropriate subscription plan amount
        $paypal_url = 'https://www.paypal.com/'; 
        $business_email = 'https://www.paypal.com/';
        $return_url = 'https://www.paypal.com/';
        $cancel_url = 'https://www.paypal.com/';

        // Redirect to PayPal with the correct parameters
        header("Location: $paypal_url?cmd=_xclick&business=$business_email&item_name={$subscription_type} Plan&amount=$payment_amount&currency_code=USD&return=$return_url&cancel_return=$cancel_url");
        exit();

    } else {
        echo "<p class='text-red-500 text-center'>Error: " . $stmt->error . "</p>";
    }

    // Close the statement
    $stmt->close();
}

// Close the database connection
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MovieShare Subscription Plans</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css"></link>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="my_style.css">
</head>

<body class="bg-gray-100 text-gray-800">
    <header class="bg-[#722f37] text-white py-4">
        <div class="container mx-auto flex justify-between items-center">
            <h1 class="text-3xl font-bold">MovieShare</h1>
            <nav>
                <ul class="flex space-x-4">
                    <li><a href="landing_page.php" class="hover:underline">Home</a></li>
                    <li><a href="subscription_page.php" class="hover:underline">Plans</a></li>
                    <li><a href="#" class="hover:underline">FAQ</a></li>
                    <li><a href="#" class="hover:underline">Contact</a></li>
                </ul>
            </nav>
        </div>
    </header>

    <main class="container mx-auto py-8">
        <section class="text-center mb-12">
            <h2 class="text-4xl font-bold mb-4">Join the MovieShare Community!</h2>
            <p class="text-lg">Unlock a world of cinematic experiences! With our subscription plans, you can enjoy unlimited access to a vast library of movies, exclusive content, and more. Choose the plan that fits you best!</p>
        </section>

        <section class="grid grid-cols-1 md:grid-cols-3 gap-8">
            <form method="POST" action="subscription_page.php">
                <!-- Basic Plan -->
                <div class="bg-white p-6 rounded-lg shadow-lg">
                    <h3 class="text-2xl font-bold mb-4">Basic Plan</h3>
                    <p class="text-xl font-semibold mb-4">$9.99/month</p>
                    <ul class="mb-4">
                        <li>Access to a library of over 1,000 movies</li>
                        <li>Standard definition streaming</li>
                        <li>Watch on 1 device at a time</li>
                        <li>New releases added monthly</li>
                    </ul>
                    <p class="font-semibold mb-4">Best for: Casual viewers who want to enjoy a variety of films.</p>
                    <input type="hidden" name="subscription_type" value="basic">
                    <button type="submit" class="bg-[#722f37] text-white py-2 px-4 rounded">Subscribe Now</button>
                </div>
            </form>

            <form method="POST" action="subscription_page.php">
                <!-- Standard Plan -->
                <div class="bg-white p-6 rounded-lg shadow-lg">
                    <h3 class="text-2xl font-bold mb-4">Standard Plan</h3>
                    <p class="text-xl font-semibold mb-4">$14.99/month</p>
                    <ul class="mb-4">
                        <li>Access to a library of over 2,500 movies</li>
                        <li>HD streaming available</li>
                        <li>Watch on up to 2 devices simultaneously</li>
                        <li>Exclusive behind-the-scenes content</li>
                    </ul>
                    <p class="font-semibold mb-4">Best for: Movie lovers who want a better viewing experience.</p>
                    <input type="hidden" name="subscription_type" value="standard">
                    <button type="submit" class="bg-[#722f37] text-white py-2 px-4 rounded">Subscribe Now</button>
                </div>
            </form>

            <form method="POST" action="subscription_page.php">
                <!-- Premium Plan -->
                <div class="bg-white p-6 rounded-lg shadow-lg">
                    <h3 class="text-2xl font-bold mb-4">Premium Plan</h3>
                    <p class="text-xl font-semibold mb-4">$19.99/month</p>
                    <ul class="mb-4">
                        <li>Access to our entire library of 5,000+ movies</li>
                        <li>4K Ultra HD streaming</li>
                        <li>Watch on up to 4 devices simultaneously</li>
                        <li>Early access to new releases</li>
                        <li>Special member-only events and screenings</li>
                    </ul>
                    <p class="font-semibold mb-4">Best for: Avid cinephiles who want the ultimate movie experience.</p>
                    <input type="hidden" name="subscription_type" value="premium">
                    <button type="submit" class="bg-[#722f37] text-white py-2 px-4 rounded">Subscribe Now</button>
                </div>
            </form>
        </section>

        <section class="mt-12">
            <h2 class="text-3xl font-bold mb-4">Why Choose MovieShare?</h2>
            <ul class="list-disc list-inside space-y-2">
                <li>Vast Library: Enjoy a diverse collection of classic films, indie gems, and blockbuster hits.</li>
                <li>User-Friendly Interface: Easy navigation and personalized recommendations tailored just for you.</li>
                <li>Offline Viewing: Download your favorite movies to watch anytime, anywhere.</li>
                <li>No Ads: Enjoy uninterrupted viewing with no ads during your movies.</li>
            </ul>
        </section>
    </main>
</body>
</html>
