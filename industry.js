const API_KEY = "AIzaSyDDq0hiFG2wrduyLQ9gtscOxggao3v7M1M"; 
const API_BASE_URL = "https://www.googleapis.com/youtube/v3/search";

// DOM elements
const movieContainer = document.getElementById("movieContainer");
const industryDropdown = document.getElementById("industryDropdown");
const commentModal = document.getElementById("commentModal");
const commentInput = document.getElementById("commentInput");
const saveCommentButton = document.getElementById("saveCommentButton");
const closeModalButton = document.getElementById("closeModalButton");

// Map industry to TMDB query 
const industryKeywords = {
    Nollywood: "Nigeria movies",
    Hollywood: "Hollywood movies",
    "Korean Cinema": "Korean movies",
    "Chinese Cinema": "Chinese movies",
    Bollywood: "Bollywood movies"
};

// Current state
let currentPage = 1;
let currentIndustry = "";
let isLoading = false;
let currentNextPageToken = null;
let currentMovieId = null;
let comments = {};

// Fetch movies based on industry
async function fetchMovieByIndustry(industry, pageToken = "") {
    const keywords = industryKeywords[industry] || "";
    const url = `${API_BASE_URL}?part=snippet&type=video&q=${encodeURIComponent(keywords)}&key=${API_KEY}&maxResults=20${pageToken ? `&pageToken=${pageToken}` : ''}`;

    try {
        const response = await fetch(url);
        if (!response.ok) throw new Error(`HTTP Error: ${response.status}`);
        const data = await response.json();

        const filteredMovies = data.items.filter(item => {
            const videoDate = new Date(item.snippet.publishedAt);
            const releaseYear = videoDate.getFullYear();
            return releaseYear >= 2009;
        });

        return {
            movies: filteredMovies,
            nextPageToken: data.nextPageToken
        };
    } catch (error) {
        console.error("Error fetching movies:", error);
        return { movies: [], nextPageToken: null };
    }
}

// Shorten description
function shortenDescription(description) {
    return description && description.length > 50
        ? description.slice(0, 50) + "..."
        : description || "";
}

// Render movies in the movie container
function displayMovies(movies) {
    if (currentPage === 1) {
        movieContainer.innerHTML = "";
    }

    if (movies.length === 0 && currentPage === 1) {
        movieContainer.innerHTML = `<p class="col-span-full text-center">No Movies found. Try a different selection.</p>`;
        return;
    }

    movies.forEach((movie) => {
        const movieCard = document.createElement("div");
        movieCard.className = "relative p-4 bg-white rounded shadow-md";

        const thumbnail = movie.snippet.thumbnails.high?.url || "https://via.placeholder.com/320x180";
        const videoId = movie.id.videoId;

        movieCard.innerHTML = `
            <div class="relative">
                <img src="${thumbnail}" alt="${movie.snippet.title}" class="w-full h-64 object-cover rounded mb-4" />
                <div class="absolute inset-0 flex items-center justify-center bg-black bg-opacity-50 rounded opacity-0 hover:opacity-100 transition-opacity">
                    <button data-video-id="${videoId}" class="play-icon text-white text-4xl">
                        ▶
                    </button>
                </div>
            </div>
            <h3 class="text-lg font-bold mb-2">${movie.snippet.title}</h3>
            <p class="text-gray-700 text-sm">${shortenDescription(movie.snippet.description)}</p>
            <div class="flex justify-between items-center mt-4">
                <div class="flex items-center gap-4">
                    <button class="like-button text-gray-600" data-video-id="${videoId}">
                        👍
                    </button>
                    <button class="dislike-button text-gray-600" data-video-id="${videoId}">
                        👎
                    </button>
                </div>
                <button class="comment-button bg-blue-600 text-white py-1 px-3 rounded" data-video-id="${videoId}">
                    💬 Comment
                </button>
            </div>
        `;

        movieContainer.appendChild(movieCard);
    });
}

// Fetch and display next page of movies
async function loadMoreMovies() {
    if (isLoading || !currentNextPageToken) return;

    try {
        isLoading = true;
        currentPage++;
        const { movies, nextPageToken } = await fetchMovieByIndustry(currentIndustry, currentNextPageToken);
        displayMovies(movies);
        currentNextPageToken = nextPageToken;
    } finally {
        isLoading = false;
    }
}

// Event listener for dropdown
industryDropdown.addEventListener("change", async () => {
    currentIndustry = industryDropdown.value;
    currentPage = 1;
    currentNextPageToken = null;

    if (currentIndustry === "") {
        movieContainer.innerHTML = `<p class="col-span-full text-center">Please select an industry.</p>`;
        return;
    }

    const { movies, nextPageToken } = await fetchMovieByIndustry(currentIndustry);
    currentNextPageToken = nextPageToken;
    displayMovies(movies);
});

// Event listeners for buttons
document.addEventListener("click", (event) => {
    // Play icon
    if (event.target.classList.contains("play-icon")) {
        const videoId = event.target.getAttribute("data-video-id");
        const videoUrl = `https://www.youtube.com/watch?v=${videoId}`;
        window.open(videoUrl, "_blank");
    }

    // Like button
    if (event.target.classList.contains("like-button")) {
        alert("You liked this movie!");
    }

    // Dislike button
    if (event.target.classList.contains("dislike-button")) {
        alert("You disliked this movie!");
    }

    // Comment button
    if (event.target.classList.contains("comment-button")) {
        currentMovieId = event.target.getAttribute("data-video-id");
        commentInput.value = comments[currentMovieId] || ""; 
        commentModal.classList.remove("hidden");
    }
});

// Comment modal
closeModalButton.addEventListener("click", () => {
    commentModal.classList.add("hidden");
});

saveCommentButton.addEventListener("click", () => {
    if (currentMovieId) {
        comments[currentMovieId] = commentInput.value.trim();
        alert("Comment saved!");
        commentModal.classList.add("hidden");
    }
});

// Infinite scroll implementation
const handleScroll = async () => {
    if (
        window.innerHeight + window.scrollY >= document.body.offsetHeight - 500 &&
        currentIndustry
    ) {
        await loadMoreMovies();
    }
};

window.addEventListener("scroll", handleScroll);

