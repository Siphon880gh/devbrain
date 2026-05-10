This is a boilerplate of internal tool links. We use cards so each link has more contextual information for the user. You could probably work to improve the design, but this is just a quick code I wrote:

![[Pasted image 20250513040519.png]]

## Internal Tool Portal
### LAYOUT index.html
```
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Internal Tool Portal</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"/>
    <link rel="stylesheet" href="assets/styles.css">
</head>
<body class="min-h-screen flex items-center justify-center p-4">
    <!-- Hint Icon Top Right -->
    <button id="hint-icon" class="absolute top-4 right-4 text-gray-600 hover:text-gray-800 text-lg focus:outline-none z-30 bg-white bg-opacity-90 rounded-full p-3 shadow-lg hover:shadow-xl transition-all duration-300">
        <i class="fa fa-key"></i>
    </button>
    <div class="container mx-auto px-4 py-8 relative max-w-5xl">
        <h1 class="text-4xl font-bold text-center text-gray-800 tracking-tight">Internal Tool Portal</h1>

        <div class="relative">
            <!-- Modern Arrow Buttons -->
            <button class="carousel-arrow left" id="prev-button">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" />
                </svg>
            </button>
            <button class="carousel-arrow right" id="next-button">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7" />
                </svg>
            </button>

            <!-- Carousel Container -->
            <div id="carousel-container" class="overflow-x-auto whitespace-nowrap pb-4 rounded-2xl p-8">
                <div id="carousel" class="inline-flex space-x-8 px-2 items-center">
                    <!-- Cards will be injected here by JS -->
                </div>
            </div>
        </div>
    </div>

    <script src="assets/script.js"></script>
</body>
</html>
```

### LAYOUT: assets/styles.css
```
body {
    background: linear-gradient(135deg, #f6f8fc 0%, #f1f4f9 100%);
}

/* Basic scrollbar hiding */
#carousel-container::-webkit-scrollbar {
    display: none;
}

#carousel-container {
    -ms-overflow-style: none;
    scrollbar-width: none;
    scroll-behavior: smooth;
    position: relative;
}

/* Modern arrow styling - only show on desktop */
.carousel-arrow {
    display: none;
}

@media (min-width: 947px) {
    .carousel-arrow {
        display: flex;
        position: absolute;
        top: 50%;
        transform: translateY(-50%);
        width: 48px;
        height: 48px;
        background: transparent;
        border-radius: 50%;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        transition: all 0.3s ease;
        z-index: 20;
        opacity: 0.3;
    }
    .carousel-arrow:hover {
        transform: translateY(-50%) scale(1.1);
        opacity: 1;
    }
    .carousel-arrow.left {
        left: -24px;
    }
    .carousel-arrow.right {
        right: -24px;
    }
    .carousel-arrow svg {
        width: 24px;
        height: 24px;
        stroke: #4B5563;
        stroke-width: 2;
    }
}

/* Center focus effect - only on desktop */
@media (min-width: 947px) {
    #carousel {
        display: flex;
        align-items: center;
        justify-content: center;
        transition: transform 0.5s ease;
    }
    .carousel-item {
        transition: all 0.3s ease;
        opacity: 0.5;
        transform: scale(0.9);
    }
    .carousel-item.active {
        opacity: 1;
        transform: scale(1);
    }
}

/* Mobile layout */
@media (max-width: 767px) {
    #carousel {
        display: flex;
        flex-direction: column;
        margin-top: 1rem;
        gap: 2rem;
        padding: 1rem;
        width: 100%;
    }
    .carousel-item {
        width: 100%;
        opacity: 1;
        transform: none;
        margin: 0;
        padding: 0;
    }
    #carousel-container {
        overflow-y: auto;
        overflow-x: hidden;
        padding: 0;
        width: 100%;
    }
    #carousel > * {
        margin-left: 0 !important;
        margin-right: 0 !important;
    }
}

/* Modern card styling */
.card {
    background: transparent;
    border-radius: 16px;
    transition: all 0.3s ease;
}

.card:hover {
    transform: translateY(-4px);
} 
```

### LAYOUT: assets/script.js
```
const appsData = [
    { sectionTitle: "Knowledge Management", tool: "Trilium", link: "km/", alt: "KM", image: "" },
    { sectionTitle: "Project Management", tool: "Focalboard", link: "https://SUBDOMAIN.DOMAIN.com/", alt: "PM", image: "" },
    { title: "Storage", tool: "Google Drive", link: "http://drive.google.com/SOME_PART", alt: "GD", image: " }
    // Add more apps here if needed
];

const carousel = document.getElementById('carousel');
const carouselContainer = document.getElementById('carousel-container');
const hoverLeft = document.getElementById('prev-button');
const hoverRight = document.getElementById('next-button');

let scrollInterval = null;
const scrollAmount = 5; // Pixels to scroll per interval

// Function to generate card HTML
function createCard(app) {
    const hasImage = app.image && app.image.trim() !== "";
    const iconElement = hasImage
        ? `<img src="${app.image}" alt="${app.tool} logo" class="w-full h-32 object-contain p-4 bg-gray-50">`
        : `<div class="w-full h-32 flex items-center justify-center bg-gradient-to-br from-pink-400 to-orange-300 text-white text-3xl font-bold">${app?.alt || app?.tool[0]}</div>`;

    return `
    <a href="${app.link}" target="_blank" rel="noopener noreferrer">
        <div class="flex-shrink-0 w-64 bg-white rounded-lg shadow-md overflow-hidden transform hover:scale-105 transition-transform duration-200 ease-in-out">
            <div class="block">
                ${iconElement}
            </div>
            <div class="p-4">
                <h3 class="text-lg ${app.sectionTitle ? 'font-bold' : 'font-semibold'} text-gray-800">${app.sectionTitle || app.title}</h3>
                <p class="text-gray-600 mt-1">${app.tool}</p>
                 <a target="_blank" rel="noopener noreferrer" class="inline-block mt-3 text-blue-500 hover:text-blue-700 text-sm">
                    Go to ${app.tool} &rarr;
                 </a>
            </div>
        </div>
    </a>
    `;
}


// Populate carousel
appsData.forEach(app => {
    carousel.innerHTML += createCard(app);
});

// --- Carousel Scroll Logic ---

function startScrolling(direction) {
    stopScrolling(); // Clear any existing interval
    scrollInterval = setInterval(() => {
        carouselContainer.scrollLeft += direction * scrollAmount;
    }, 16); // approx 60fps
}

function stopScrolling() {
    clearInterval(scrollInterval);
    scrollInterval = null;
}

hoverLeft.addEventListener('mouseenter', () => startScrolling(-1));
hoverLeft.addEventListener('mouseleave', stopScrolling);

hoverRight.addEventListener('mouseenter', () => startScrolling(1));
hoverRight.addEventListener('mouseleave', stopScrolling);

// Optional: Stop scrolling if mouse leaves the entire container area
// carouselContainer.parentElement.addEventListener('mouseleave', stopScrolling);

console.log("Portal script loaded.");

document.addEventListener('DOMContentLoaded', () => {
    const carousel = document.getElementById('carousel');
    const items = carousel.getElementsByClassName('carousel-item');
    let currentIndex = 0;
    let isMobile = window.innerWidth < 768;

    function updateCarousel() {
        if (!isMobile) {
            Array.from(items).forEach((item, index) => {
                item.classList.remove('active');
                if (index === currentIndex) {
                    item.classList.add('active');
                }
            });
        }
    }

    function nextSlide() {
        if (!isMobile) {
            currentIndex = (currentIndex + 1) % items.length;
            updateCarousel();
        }
    }

    function prevSlide() {
        if (!isMobile) {
            currentIndex = (currentIndex - 1 + items.length) % items.length;
            updateCarousel();
        }
    }

    // Auto cycle every 5 seconds only on desktop
    let intervalId = null;
    function startAutoCycle() {
        if (!isMobile) {
            intervalId = setInterval(nextSlide, 5000);
        }
    }
    function stopAutoCycle() {
        if (intervalId) {
            clearInterval(intervalId);
        }
    }

    // Handle window resize
    window.addEventListener('resize', () => {
        const wasMobile = isMobile;
        isMobile = window.innerWidth < 768;
        
        if (wasMobile !== isMobile) {
            if (isMobile) {
                stopAutoCycle();
                Array.from(items).forEach(item => {
                    item.classList.remove('active');
                    item.style.opacity = '1';
                    item.style.transform = 'none';
                });
            } else {
                startAutoCycle();
                updateCarousel();
            }
        }
    });

    // Initial setup
    startAutoCycle();

    // Add click handlers for arrows
    document.getElementById('prev-button').addEventListener('click', prevSlide);
    document.getElementById('next-button').addEventListener('click', nextSlide);

    // Hint icon click handler
    document.getElementById('hint-icon').addEventListener('click', function() {
        const password = prompt('Enter master password for the password hints');
        if (password) {
            fetch('hints/index.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                },
                body: 'password=' + encodeURIComponent(password)
            })
            .then(response => response.text())
            .then(filename => {
                if (filename) {
                    window.open('hints/' + filename, '_blank');
                } else {
                    alert('Invalid password');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('An error occurred while fetching the hint');
            });
        }
    });
});
```

## Password Hint System
At the top right is a key, when pressed, user can enter master password which gives them a password hint for each internal tool login.
![[Pasted image 20250513041605.png]]

For example: 
At {APP}, the username is in the format: firstname.lastname. The password has been emailed to you subject heading {SUBJECT_HEADING}. Please change password as soon as possible inside the app. Instructions was provided in the email.

### hints/index.php
Receives the password entered by the user then tries to open a file with that password as the filename. Secured against some vulnerabilities.
```
<?php
header('Content-Type: text/plain');

// Only allow POST requests
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    exit('Access Denied');
}

// Get and sanitize the password
$password = isset($_POST['password']) ? $_POST['password'] : '';
$password = urldecode($password);

// Recursively decode URL encoding
while (urldecode($password) !== $password) {
    $password = urldecode($password);
}

// Get only the basename to prevent directory traversal
$password = basename($password);

// Construct the filename
$filename = $password . '.html';

// Check if file exists in the hints directory
$filepath = __DIR__ . '/' . $filename;
if (file_exists($filepath)) {
    echo $filename;
} else {
    http_response_code(404);
    echo '';
}
?> 
```

### hints/{PASSWORD}.html
This is the file that opens if there's a match on the entered password and the filename. The password user enters does not include ".html". A HTML file makes sense to easily format the password hint guide. You can have as many password files as needed.

## Recommendations - Reverse Proxy.md
You should create a Readme file recommending reverse proxies URLs for future migrations. This file is NOT accessible on the web browser, but the future IT team that receives the codebase will have access to it.

Example: 
For our apps, they're Trelium, Focalboard. Trelium can take site url, but Focalboard works better at root, so we reverse proxy from a subdomain for Focalboard. Trelium is at port 8081 and Focalport at port 8000.
