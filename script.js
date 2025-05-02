// Navigation scroll functionality - Article links


// @ Media toogle Button functionality
const navToggle = document.getElementById("nav-toggle");
const navClose = document.getElementById("nav-close");
const navLinks = document.getElementById("nav-links");

navToggle.addEventListener("click", () => {
    navLinks.style.display = "flex";
    navToggle.style.display = "none";
    navClose.style.display = "block";
});

 // Trigger calls functionality
document.getElementById("call-us").addEventListener("click", function() {
        window.location.href = "tel:+254 787 167 874";
    });
    
navClose.addEventListener("click", () => {
    navLinks.style.display = "none";
    navClose.style.display = "none";
    navToggle.style.display = "block";
});

// @ Destination details toggle functionality
const readMoreButtons = document.querySelectorAll('.read-more');

function toggleDetails(button) {
    const container = button.closest('.destination');
    const details = container.querySelector('.destination-details');
    const readMore = container.querySelector('.read-more');

    if (details.style.display === 'block') {
        details.style.display = 'none';
        readMore.style.display = 'inline-block';
    } else {
        details.style.display = 'block';
        readMore.style.display = 'none';
    }
}


function prevDestination() {
    const destinations = document.querySelectorAll('.destination');
    const activeIndex = Array.from(destinations).findIndex(dest => dest.classList.contains('active'));
    if (activeIndex > 0) {
        destinations[activeIndex].classList.remove('active');
        destinations[activeIndex - 1].classList.add('active');
    }
}

function nextDestination() {
    const destinations = document.querySelectorAll('.destination');
    const activeIndex = Array.from(destinations).findIndex(dest => dest.classList.contains('active'));
    if (activeIndex < destinations.length - 1) {
        destinations[activeIndex].classList.remove('active');
        destinations[activeIndex + 1].classList.add('active');
    }
}