// YouTube Tutorial: https://www.youtube.com/watch?v=37vxWr0WgQk 


// DOM elements
const searchInput = document.getElementById('search-input');
const searchButton = document.getElementById('search-button');
const movieContainer = document.querySelector('.grid');

// Dailymotion API configuration
const API_BASE_URL = "https://api.dailymotion.com/videos";
const ITEMS_PER_PAGE = 8;

// Fetch videos based on the movie title
async function fetchVideos(query) {
    try {
        const response = await fetch(
            `${API_BASE_URL}?search=${encodeURIComponent(query)}&limit=${ITEMS_PER_PAGE}&fields=id,title,description,thumbnail_720_url`
        );
        
        if (!response.ok) {
            throw new Error(`HTTP error! status: ${response.status}`);
        }
        
        const data = await response.json();
        return data.list || [];
    } catch (error) {
        console.error("Error fetching videos:", error);
        return [];
    }
}

// Update watch buttons with video links
async function updateWatchButtons() {
    const movieCards = document.querySelectorAll('.grid > div');
    
    for (const card of movieCards) {
        const titleElement = card.querySelector('.title');
        if (titleElement) {
            const movieTitle = titleElement.textContent.trim();
            const videos = await fetchVideos(movieTitle);
            
            const watchButton = card.querySelector('a');
            if (videos.length > 0) {
                watchButton.href = `https://www.dailymotion.com/video/${videos[0].id}`;
            } else {
                watchButton.href = '#';
                watchButton.classList.add('cursor-not-allowed', 'opacity-50');
                watchButton.title = 'No video available';
            }
        }
    }
}

// Initial page load
document.addEventListener('DOMContentLoaded', updateWatchButtons);

// Search button functionality
searchButton.addEventListener("click", async () => {
    const query = searchInput.value.trim();
    if (query === "") {
        alert("Please enter a search term");
        return;
    }
    const videos = await fetchVideos(query);
    displayVideos(videos);
});

// Display fetched videos with direct watch functionality
function displayVideos(videos) {
    movieContainer.innerHTML = "";
    
    if (videos.length === 0) {
        movieContainer.innerHTML = "<p class='col-span-full text-center'>No videos found. Try another search.</p>";
        return;
    }

    videos.forEach(video => {
        const card = document.createElement("div");
        card.className = "p-4 rounded";
        card.style.backgroundColor = "#722f37";
        
        card.innerHTML = `
            <img src="${video.thumbnail_720_url || 'https://via.placeholder.com/320x180'}" 
                alt="${video.title}" 
                class="w-full h-64 object-cover rounded mb-4" />
            <h3 class="title text-xl font-bold text-white mb-2">${video.title}</h3>
            <p class="text-white mb-4">${'  '}</p>
            <a href="https://www.dailymotion.com/video/${video.id}" 
               target="_blank" 
               class="inline-block bg-blue-500 text-white py-2 px-4 rounded hover:bg-blue-600">
               Watch Now
            </a>
        `;
        
        movieContainer.appendChild(card);
    });
}

// Add enter key support for search
searchInput.addEventListener("keypress", async (event) => {
    if (event.key === "Enter") {
        event.preventDefault();
        searchButton.click();
    }
});

