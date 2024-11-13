const API_KEY = 'AIzaSyAtxIWxgPzHiUAs9l0qRr-r-7884Rk39f4';
const BASE_URL = 'https://www.googleapis.com/youtube/v3';



function fetchTrendingKidsVideos() {
    fetch(
        `${BASE_URL}/search?part=snippet&maxResults=25&q=kids+cartoons&type=video&key=${API_KEY}`
    )
        .then((response) => response.json())
        .then((data) => {
            displayFeaturedVideo(data.items[0]);
            displayVideoGrid(data.items.slice(1));
        })
        .catch((error) => console.error('Error fetching videos: ', error));

}

window.onload = fetchTrendingKidsVideos;

function searchVideos() {
    const query = document.getElementById('search-input').value;
    const featuredSection = document.getElementById('featured-video');

    fetch(
        `${BASE_URL}/search?part=snippet&q=${query} kids cartoons&type=video&key=${API_KEY}&maxResults=1`
    )
        .then((response) => response.json())
        .then((data) => {
            const video = data.items[0];
            featuredSection.innerHTML = `
                <iframe width="600" height="315" src="https://www.youtube.com/embed/${video.id}?autoplay=1" frameborder="0" allow="autoplay; encrypted-media" allowfullscreen></iframe>
                <h2 class="mt-3">${video.snippet.title}</h2>
                <p>${video.snippet.description}</p>
            `;
        })
        .catch((error) => console.error('Error fetching search video: ', error));
}


function displayFeaturedVideo(video) {
    const featuredSection = document.getElementById('featured-video');
    featuredSection.innerHTML = `
      <iframe width="600" height="315" src="https://www.youtube.com/embed/${video.id.videoId}?autoplay=1" frameborder="0" allow="autoplay; encrypted-media" allowfullscreen></iframe>
      <h2 class="mt-3">${video.snippet.title}</h2>
      <p>${video.snippet.description || "No description available."}</p>
    `;
  }
  



//displaying grids of video
function displayVideoGrid(videos) {
    const videoGrid = document.getElementById('video-grid');
    videoGrid.innerHTML = videos
        .map(
            (video) => `
            <div class="col-md-3 col-sm-6 mb-4">
                <div class="video-card card h-100" onclick="playSelectedVideo('${video.id.videoId}', '${video.snippet.title}', '${video.snippet.description}')">
                    <img src="${video.snippet.thumbnails.medium.url}" alt="${video.snippet.title}" class="card-img-top">
                    <div class="card-body">
                        <h5 class="card-title">${video.snippet.title}</h5>
                    </div>
                </div>
            </div>
            `
        )
        .join('');
}

function playSelectedVideo(videoId, title, description) {
    const featuredSection= document.getElementById('featured-video');
    featuredSection.innerHTML = `
        <iframe width="600" height="315" src="https://www.youtube.com/embed/${videoId}?autoplay=1" frameborder="0" allow="autoplay; encrypted-media" allowfullscreen></iframe>
        <h2 class="mt-3">${title}</h2>
        <p>${description || "No description available"}</p>
    `;
}

        