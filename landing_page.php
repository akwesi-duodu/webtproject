<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>DEVS | Movie Sharing Website Homepage</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="my_style.css">
</head>

<body class="bg-gray-100 text-gray-900">

    <!-- Header Section -->
    <header class="bg-[#722f37] text-white py-4">
        <div class="container mx-auto flex justify-between items-center py-4 px-6">
            <div class="flex items-center">
                <i class="fas fa-film text-3xl text-blue-500"></i>
                <h1 class="text-2xl font-bold ml-2">DEVSMovieShare</h1>
            </div>
            <nav class="flex space-x-6 items-center">
                <ul class="flex space-x-6">
                    <li><a class="text-white hover:underline" href="#">Home</a></li>
                    <li><a class="text-white hover:underline" href="#movies">Movies</a></li>
                    <li><a class="text-white hover:underline" href="#about">About</a></li>
                    <li><a class="text-white hover:underline" href="#contact">Contact</a></li>
                    <li><a class="text-white hover:underline" href="#faqs">FAQs</a></li>
                    <li><a class="text-white hover:underline" href="latest.html"> latest movies</a></li>
                    <li><a class="text-white hover:underline" href="upcoming_movie.php">Upcoming</a></li>
                    <li><a class="text-white hover:underline" href="industry_copy.html">Industries</a></li>
                    <li><a class="text-white hover:underline" href="kids.html">kids</a></li>
                </ul>
                <!-- Search Bar -->
                <div class="flex items-center space-x-2 ml-4">
                    <input id="search-input" class="p-2 rounded bg-white text-black" type="text" placeholder="Search for movies" />
                    <button id="search-button" class="p-2 bg-red-600 text-white rounded">
                        <i class="fas fa-search"></i>
                    </button>
                </div>
            </nav>
        </div>
    </header>

  <!-- Main Content Section -->
<main class="container mx-auto py-10 px-6">
    <section class="text-center mb-10">
        <h1 class="text-4xl font-bold mb-4">Your Gateway to Unforgettable Cinema – Dive In, Explore, and Share the Magic!</h1>
        <p class="text-lg mb-6">Discover a world of movies and shows tailored just for you. Whether you're in the mood for timeless classics, the latest blockbusters, or hidden gems, we've got it all. Connect with friends, share your favorite scenes, and let every watch be an experience to remember!</p>
        <a href="subscription_page.php" class="inline-block bg-blue-500 text-white py-2 px-4 rounded hover:bg-red-600">Subscribe?</a>
    </section>

    <!-- Video Player Section -->
    <section id="video-player" class="mb-10 hidden">
        <h2 class="text-3xl font-bold mb-4">Now Playing</h2>
        <div id="video-container" class="flex justify-center">
            <!-- Video will be injected here -->
        </div>
    </section>

    <!-- Popular Movies Section -->
    <section class="p-8">
        <h2 class="text-4xl font-bold mb-8">Movies</h2>
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-8">
            <!-- Movies will be dynamically inserted here -->
        </div>
    </section>

    <!-- About Section -->
    <section id="about" class="mb-10">
        <h2 class="text-3xl font-bold mb-4">About Us</h2>
        <p class="text-lg">DEVSMovieShare is a platform for movie lovers to explore, discover, and share their favorite movies. We are passionate about cinema and committed to creating a community where users can connect and share their love for films.</p>
    </section>

    <!-- Contact Section -->
    <section id="contact" class="mb-10">
        <h2 class="text-3xl font-bold mb-4">Contact the Authors</h2>
        <p class="text-lg">If you have questions, feedback, or suggestions, feel free to reach out to us at <a href="mailto:contact@devsmovieshare.com" class="text-blue-500 hover:underline">contact@devsmovieshare.com</a>.</p>
    </section>

    <!-- FAQs Section -->
    <section id="faqs">
        <h2 class="text-3xl font-bold mb-4">Frequently Asked Questions (FAQs)</h2>
        <ul class="list-disc list-inside text-lg">
            <li><strong>How do I join the community?</strong> Click the "Join Us" button above to register.</li>
            <li><strong>Is there a fee for membership?</strong> No, membership is completely free unless you are an adult.</li>
            <li><strong>Can I share movies with friends?</strong> Yes, our platform allows you to share movies and your reviews with friends.</li>
        </ul>
    </section>
</main>
    <!-- <script src="config.js"></script> -->
    <script src="index.js"></script>

</body>
</html>
