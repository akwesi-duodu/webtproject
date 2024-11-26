<?php
session_start();

// Database connection
require "configuration.php";

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get form data
    $email = $_POST['email'] ?? '';
    $password = $_POST['password'] ?? '';
    $age = $_POST['age'] ?? 0; // Capture age input from the form
    $is_adult = $age >= 15 ? true : false; // Set is_adult based on the age entered. SET TO 15

    // Validate password (must be at least 8 characters, contain a number, and a special character)
    if (!preg_match('/^(?=.*[A-Za-z])(?=.*\d)(?=.*[!@#$%^&*])[A-Za-z\d!@#$%^&*]{8,}$/', $password)) {
        echo "<p class='text-red-500 text-center'>Password must be at least 8 characters long, contain a number, and a special character.</p>";
    } else {
        // Hash the password
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        // Validate input
        if (empty($email) || empty($password) || empty($age)) {
            echo "<p class='text-red-500 text-center'>Please fill out all fields.</p>";
        }

        // Check if the user is under 15 and redirect them to kids.html
        if (!$is_adult) {
            header("Location: kids.html");
            exit;
        }

        // Prepare SQL statement to insert data into the customer table
        $stmt = $conn->prepare("INSERT INTO customers (email, password, account_created_date, is_adult) VALUES (?, ?, NOW(), ?)");

        if (!$stmt) {
            die("Prepare failed: " . $conn->error);
        }

        // Bind parameters
        $stmt->bind_param("ssi", $email, $hashed_password, $is_adult);

        // Execute the query
        if ($stmt->execute()) {
            echo "<p class='text-green-500 text-center'>Account created successfully. You can now log in.</p>";
            // Optionally, redirect to the login page
            // header('Location: login_page.php');
            // exit;
        } else {
            echo "<p class='text-red-500 text-center'>Error: " . $stmt->error . "</p>";
        }

        // Close the statement
        $stmt->close();
    }
}

// Close the database connection
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>DEVS | Sign Up</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="my_style.css">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">
</head>

<body class="bg-gray-100">
    <!-- Header Section -->
    <header class="bg-[#722f37] text-white py-4">
        <div class="container mx-auto flex justify-between items-center px-6">
            <div class="flex items-center">
                <i class="fas fa-film text-3xl text-blue-500"></i>
                <a href="index.php" class="text-2xl font-bold ml-2">DEVSMovieShare</a>
            </div>
            <nav>
                <ul class="flex space-x-6">
                    <li><a href="landing_page.php" class="hover:underline">Home</a></li>
                    <li><a href="#" class="hover:underline">About</a></li>
                </ul>
            </nav>
        </div>
    </header>

    <!-- Sign Up Section -->
    <main class="min-h-screen flex items-center justify-center login-container">
        <div class="bg-white p-8 rounded-lg shadow-lg w-full max-w-md">
            <div class="text-center mb-8">
                <h1 class="text-3xl font-bold text-gray-800">Welcome!</h1>
                <p class="text-gray-600 mt-2">Sign up to continue your movie journey</p>
            </div>

            <form action="" method="POST" class="space-y-6">
                <!-- Email Input -->
                <div>
                    <label for="email" class="block text-gray-700 font-medium mb-2">Email Address</label>
                    <div class="relative">
                        <span class="absolute left-3 top-3 text-gray-400">
                            <i class="fas fa-envelope"></i>
                        </span>
                        <input 
                            type="email" 
                            id="email" 
                            name="email" 
                            class="w-full pl-10 pr-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-[#722f37]"
                            placeholder="Enter your email"
                            required
                        >
                    </div>
                </div>

                <!-- Password Input -->
                <div>
                    <label for="password" class="block text-gray-700 font-medium mb-2">Password</label>
                    <div class="relative">
                        <span class="absolute left-3 top-3 text-gray-400">
                            <i class="fas fa-lock"></i>
                        </span>
                        <input 
                            type="password" 
                            id="password" 
                            name="password" 
                            class="w-full pl-10 pr-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-[#722f37]"
                            placeholder="Enter your password"
                            required
                        >
                    </div>
                </div>

                <!-- Age Input -->
                <div>
                    <label for="age" class="block text-gray-700 font-medium mb-2">Age</label>
                    <input 
                        type="number" 
                        id="age" 
                        name="age" 
                        class="w-full py-2 px-4 border border-gray-300 rounded-lg focus:outline-none focus:border-[#722f37]"
                        placeholder="Enter your age"
                        required
                    >
                </div>

                <div class="flex justify-between items-center">
                    <button type="submit" name="register" class="w-1/2 bg-[#722f37] text-white py-2 px-4 rounded-lg hover:bg-[#8b373f] transition duration-300">Register</button>
                </div> 

                <!-- Sign In Link -->
                <p class="text-center text-sm text-gray-600">
                    Already have an account?
                    <a href="login_page.php" class="text-[#722f37] hover:underline font-medium">Log in</a>
                </p>
            </form>
        </div>
    </main>
</body>
</html>
