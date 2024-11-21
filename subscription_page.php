<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MovieShare Subscription Plans</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">
</head>
<body class="bg-gray-100 text-gray-800">
    <?php
    // Database connection
    $servername = "localhost";
    $username = "root";
    $password = ""; 
    $dbname = "DEVS_Movie_Share"; 

    // Create connection
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Handle subscription form submission
    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['plan'])) {
        $plan = $_POST['plan'];
        $type = '';
        $start_date = date('Y-m-d');
        $end_date = date('Y-m-d', strtotime('+1 month'));
        $payment_status = 'Pending';

        // Determine subscription type based on plan
        if ($plan === "Basic") $type = "Monthly";
        elseif ($plan === "Standard") $type = "Monthly";
        elseif ($plan === "Premium") $type = "Monthly";

        // Insert data into subscriptions table
        $sql = "INSERT INTO subscriptions (subscription_type, subscription_start_date, subscription_end_date, payment_status) 
                VALUES ('$type', '$start_date', '$end_date', '$payment_status')";

        if ($conn->query($sql) === TRUE) {
            echo "<div class='bg-green-100 text-green-800 p-4 mb-4 text-center'>Subscription for $plan plan added successfully!</div>";
        } else {
            echo "<div class='bg-red-100 text-red-800 p-4 mb-4 text-center'>Error: " . $sql . "<br>" . $conn->error . "</div>";
        }
    }

    $conn->close();
    ?>

    <header class="bg-[#722f37] text-white py-4">
        <div class="container mx-auto flex justify-between items-center">
            <h1 class="text-3xl font-bold">MovieShare</h1>
            <nav>
                <ul class="flex space-x-4">
                    <li><a href="landing_page.html" class="hover:underline">Home</a></li>
                    <li><a href="subscription_page.html" class="hover:underline">Plans</a></li>
                    <li><a href="#" class="hover:underline">FAQ</a></li>
                    <li><a href="#" class="hover:underline">Contact</a></li>
                </ul>
            </nav>
        </div>
    </header>

    <main class="container mx-auto py-8">
        <section class="text-center mb-12">
            <h2 class="text-4xl font-bold mb-4">Join the MovieShare Community!</h2>
            <p class="text-lg">Unlock a world of cinematic experiences! Choose the plan that fits you best!</p>
        </section>

        <section class="grid grid-cols-1 md:grid-cols-3 gap-8">
            <!-- Subscription Plan Cards -->
            <?php
            $plans = [
                ["Basic Plan", "9.99", "Access to a library of over 1,000 movies, Standard definition, Watch on 1 device at a time", "Basic"],
                ["Standard Plan", "14.99", "Access to 2,500+ movies, HD streaming, Watch on up to 2 devices", "Standard"],
                ["Premium Plan", "19.99", "Entire library, 4K Ultra HD, Watch on up to 4 devices", "Premium"]
            ];
            foreach ($plans as $plan) {
                echo "
                <div class='bg-white p-6 rounded-lg shadow-lg'>
                    <h3 class='text-2xl font-bold mb-4'>{$plan[0]}</h3>
                    <p class='text-xl font-semibold mb-4'>\${$plan[1]}/month</p>
                    <p class='mb-4'>{$plan[2]}</p>
                    <form method='POST'>
                        <input type='hidden' name='plan' value='{$plan[3]}'>
                        <button type='submit' class='bg-[#722f37] text-white py-2 px-4 rounded'>Subscribe Now</button>
                    </form>
                </div>";
            }
            ?>
        </section>
    </main>

    <footer class="bg-[#722f37] text-white py-8">
        <div class="container mx-auto text-center">
            <p class="mb-4">Contact us at <a href="mailto:support@moviesshare.com" class="underline">support@moviesshare.com</a></p>
            <p>© 2023 MovieShare. All Rights Reserved.</p>
        </div>
    </footer>
</body>
</html>
