<?php
session_start()
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Latest Movies</title>
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="latest.css">
</head>
<body>
    <!-- Navigation Bar -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <a class="navbar-brand text-warning" href="#">DEV</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav">
                <li class="nav-item active">
                    <a class="nav-link" href="#">Latest Movies</a>
                </li>
            </ul>
        </div>
    </nav>

    <!-- Search Section -->
    <div class="search-container">
        <form method="GET" action="">
            <input type="text" name="search" class="form-control" placeholder="Search movies..." value="">
            <button type="submit" class="btn">Search</button>
        </form>
    </div>

    <!-- Latest Movies Section -->
    <div class="container my-5">
        <h2 class="text-center text-warning mb-4">Latest Movies</h2>
        <div class="row grid text-center" id="movieContainer">
            <p class="col-12">Loading latest movies...</p>
        </div>
    </div>

    <!-- Bootstrap JS and Popper.js -->
    <!-- <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script> -->

    <!-- JavaScript for Latest Movies -->
    <script src="latest.js"></script>
</body>
</html>
