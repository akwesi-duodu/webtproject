const API_KEY = "015c2e8241493d7f9ea5412d43c24983"; // Replace with your TMDB API key
const API_BASE_URL = "https://api.themoviedb.org/3";
const IMAGE_BASE_URL = "https://image.tmdb.org/t/p/w500";
const YOUTUBE_BASE_URL = "https://www.youtube.com/watch?v=";

const movieContainer = document.getElementById("movieContainer");



// Fetch upcoming movies


async function fetchUpcomingMovies() {
    try {
        const response = await fetch(
            `${API_BASE_URL}/movie/upcoming?api_key=${API_KEY}&language=en-US&page=1`
        );

        if (!response.ok) {
            throw new Error(`HTTP error! Status: ${response.status}`);
        }

        const data = await response.json();
        let movies = data.results || [];

        // Filter out movies that are already released
        const today = new Date();
        movies = movies.filter(movie => {
            const releaseDate = new Date(movie.release_date);
            return releaseDate > today;  // Only keep movies with a release date in the future
        });

        // Fetch trailers for each movie
        const moviesWithTrailers = await Promise.all(
            movies.map(async (movie) => {
                try {
                    const trailerResponse = await fetch(
                        `${API_BASE_URL}/movie/${movie.id}/videos?api_key=${API_KEY}&language=en-US`
                    );
                    const trailerData = await trailerResponse.json();
                    const trailers = trailerData.results.filter(video =>
                        video.site === "YouTube" && video.type === "Trailer"
                    );

                    return {
                        ...movie,
                        trailer: trailers[0] ? trailers[0].key : null // Add trailer key if available
                    };
                } catch (error) {
                    console.error(`Error fetching trailer for movie ${movie.id}:`, error);
                    return movie; // return movie without trailer
                }
            })
        );

        return moviesWithTrailers;
    } catch (error) {
        console.error("Error fetching upcoming movies:", error);
        return [];
    }
}

// Format release date
function formatDate(dateString) {
    const releaseDate = new Date(dateString);
    const today = new Date();
    const diffTime = releaseDate - today;
    const diffDays = Math.ceil(diffTime / (1000 * 60 * 60 * 24));

    const formattedDate = releaseDate.toLocaleDateString("en-US", {
        year: "numeric",
        month: "long",
        day: "numeric"
    });

    return {
        date: formattedDate,
        countdown: diffDays > 0 ? `${diffDays} days to go` : "Released"
    };
}

// Display movies
function displayMovies(movies) {
    movieContainer.innerHTML = "";

    if (movies.length === 0) {
        movieContainer.innerHTML = "<p class='col-12 text-white'>No upcoming movies available.</p>";
        return;
    }

    movies.forEach(movie => {
        const releaseDate = formatDate(movie.release_date);
        const card = document.createElement("div");
        card.className = "col-md-3 movie-card";

        // Check if trailer is available and add the button
        const trailerButton = movie.trailer
            ? `<a href="${YOUTUBE_BASE_URL}${movie.trailer}" target="_blank" class="btn btn-warning w-100">Watch Trailer</a>`
            : `<button class="btn btn-secondary w-100" disabled>No Trailer Available</button>`;

        card.innerHTML = `
            <div class="card bg-dark text-white h-100">
                <img src="${movie.poster_path ? IMAGE_BASE_URL + movie.poster_path : 'https://via.placeholder.com/320x480'}" 
                     class="card-img-top" alt="${movie.title}">
                <div class="card-body d-flex flex-column">
                    <h5 class="card-title">${movie.title}</h5>
                    <p class="card-text">
                        <small class="text-muted">Release: ${releaseDate.date}</small><br>
                        <small class="text-warning">${releaseDate.countdown}</small>
                    </p>
                    ${trailerButton}
                </div>
            </div>
        `;
        movieContainer.appendChild(card);
    });
}

// Initialize the page
document.addEventListener("DOMContentLoaded", async () => {
    movieContainer.innerHTML = `
        <div class="col-12 text-center text-white">
            <div class="spinner-border text-light mb-3" role="status">
                <span class="visually-hidden">Loading...</span>
            </div>
            <p>Loading upcoming movies...</p>
        </div>
    `;

    const movies = await fetchUpcomingMovies();
    displayMovies(movies);
});
