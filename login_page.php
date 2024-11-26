<?php
session_start();

// Database connection
require "configuration.php";

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Handle form submission (assuming you have email and password submitted)
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'] ?? '';
    $password = $_POST['password'] ?? '';

    // Check if email exists and fetch user data
    $stmt = $conn->prepare("SELECT password FROM customers WHERE email = ?");
    if (!$stmt) {
        // Display error if prepare() fails
        die("Error preparing statement: " . $conn->error);
    }

    $stmt->bind_param('s', $email);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        // User exists, fetch the hashed password
        $stmt->bind_result($hashed_password);
        $stmt->fetch();

        // Check if the provided password matches the hashed password
        if (password_verify($password, $hashed_password)) {
            // Set session variables for the user (for example, email)
            $_SESSION['email'] = $email;

            // Redirect to landing page
            header("Location: landing_page.php");
            exit;  // Ensure no further code is executed after the redirect
        } else {
            echo "Invalid password!";
        }
    } else {
        echo "No user found with that email!";
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
    <title>DEVS | Login</title>
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

    <!-- Login Section -->
    <main class="min-h-screen flex items-center justify-center login-container">
        <div class="bg-white p-8 rounded-lg shadow-lg w-full max-w-md">
            <div class="text-center mb-8">
                <h1 class="text-3xl font-bold text-gray-800">Welcome Back!</h1>
                <p class="text-gray-600 mt-2">Log in to continue your movie journey</p>
            </div>

            <form method="POST" class="space-y-6">
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

                <!-- Remember Me & Forgot Password -->
                <div class="flex items-center justify-between">
                    <div class="flex items-center">
                        <input type="checkbox" id="remember" class="w-4 h-4 text-[#722f37] border-gray-300 rounded">
                        <label for="remember" class="ml-2 text-sm text-gray-600">Remember me</label>
                    </div>
                    <a href="#" class="text-sm text-[#722f37] hover:underline">Forgot Password?</a>
                </div>

                <!-- Login Button -->
                <button 
                    type="submit" 
                    class="w-full bg-[#722f37] text-white py-2 px-4 rounded-lg hover:bg-[#8b373f] transition duration-300"
                >
                    LOG In
                </button>

                <!-- Sign Up Link -->
                <p class="text-center text-sm text-gray-600">
                    Don't have an account? 
                    <a href="sign_up.php" class="text-[#722f37] hover:underline font-medium">Sign up</a>
                </p>
            </form>
        </div>
    </main>
</body>
</html>
