<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Upcoming Movies</title>
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="upcoming_movie.css">
</head>
<body>
    <!-- Navigation Bar -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <a class="navbar-brand text-warning" href="#">DEV</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <!-- <nav></nav>
        <ul>
            <li><a href="latest.php">Latest Movies</a></li>
            <li><a href="upcoming_movie.php">Upcoming Movies</a></li>
        </ul>
    </nav> -->

        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" href="#">Latest Movies</a>
                </li>
                <li class="nav-item active">
                    <a class="nav-link" href="#">Upcoming Movies</a>
                </li>
            </ul>
        </div>
    </nav>

    <!-- Upcoming Movies Section -->
    <div class="container my-5">
        <h2 class="text-center text-warning mb-4">Upcoming Movies</h2>
        <div class="row grid text-center" id="movieContainer">
            <p class="col-12">Loading upcoming movies...</p>
        </div>
    </div>

    <!-- Bootstrap JS and Popper.js -->
    <!-- <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script> -->

    <!-- JavaScript for Upcoming Movies -->
    <script src="upcoming_movie.js"></script>
</body>
</html>
