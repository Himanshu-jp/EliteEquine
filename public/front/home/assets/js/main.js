var swiper = new Swiper(".mySwiper", {
  slidesPerView: 1,
  spaceBetween: 10,
  navigation: {
    nextEl: "#slider-next",
    prevEl: "#slider-prev",
  },
  pagination: {
    el: ".swiper-pagination",
    clickable: true,
  },
  breakpoints: {
    640: {
      slidesPerView: 2,
      spaceBetween: 20,
    },
    768: {
      slidesPerView: 3,
      spaceBetween: 40,
    },
    1250: {
      slidesPerView: 4,
      spaceBetween: 50,
    },
  },
});



var swiper = new Swiper(".mySwiper1", {
  loop: true,
  spaceBetween: 10,
  slidesPerView: 3,
  freeMode: true,
  watchSlidesProgress: true,
  navigation: {
    nextEl: "#slider-next1",
    prevEl: "#slider-prev1",
  },
  breakpoints: {
    300: {
      slidesPerView: 1,
    },
    640: {
      slidesPerView: 1,
    },
    768: {
      slidesPerView: 2,
    },
    1250: {
      slidesPerView: 3,
    },
  },
});


var swiper2 = new swiper2(".mySwiper2", {
  loop: true,
  spaceBetween: 10,
  slidesPerView: 5,
  thumbs: {
    swiper: swiper,
  },

});




// var swiper = new swiper(".mySwiper1", {
//     loop: true,
//     spaceBetween: 10, 
//     slidesPerView: 3,
//     freeMode: true,
//     watchSlidesProgress: true, 
//     navigation: {
//         nextEl: "#slider-next1",
//         prevEl: "#slider-prev1",
//     },
//     breakpoints: {
//         300: {
//             slidesPerView: 1, 
//         },
//         640: {
//             slidesPerView: 1, 
//         },
//         768: {
//             slidesPerView: 2, 
//         },
//         1250: {
//             slidesPerView: 3, 
//         },
//     },
//   });
//   var swiper2 = new swiper2(".mySwiper2", {
//     loop: true,
//     spaceBetween: 10, 
//     slidesPerView: 5,
//     thumbs: {
//       swiper: swiper,
//     },

//   });




/*
const map = L.map('map').setView([39.8283, -98.5795], 5);

// Add tiles
L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
  attribution: '&copy; OpenStreetMap contributors'
}).addTo(map);

// Different icons for each horse
const icons = [
  L.icon({ iconUrl: 'assets/images/horse-marker-blue.svg', iconSize: [40, 40], iconAnchor: [20, 40] }),
  L.icon({ iconUrl: 'assets/images/horse-marker-red.svg', iconSize: [40, 40], iconAnchor: [20, 40] }),
  L.icon({ iconUrl: 'assets/images/horse-marker-red.svg', iconSize: [40, 40], iconAnchor: [20, 40] }),
  L.icon({ iconUrl: 'assets/images/horse-marker-blue.svg', iconSize: [40, 40], iconAnchor: [20, 40] }),
  L.icon({ iconUrl: 'assets/images/horse-marker-blue.svg', iconSize: [40, 40], iconAnchor: [20, 40] }),
  // Add more icons if needed
];

// Horse data
const horses = [
  {
    lat: 37.7749,
    lng: -122.4194,
    iconIndex: 0,
    title: 'Synergy | 2019 | 16.2h Westphalian | Gelding',
    breed: 'Westphalian | Gelding',
    price: 'Sale: $100,000 - $150,000',
    location: 'Dressage, Eventing, Hunter, Jumper',
    trial: 'World Equestrian Center<br>1/22/25 – 3/15/25',
    image: 'assets/images/featured_hource1.png'
  },
  {
    lat: 34.0522,
    lng: -118.2437,
    iconIndex: 1,
    title: 'Starfire | 2020 | 15.3h',
    breed: 'Thoroughbred | Mare',
    price: '$80,000 – $100,000',
    location: 'Los Angeles, CA',
    trial: 'Sunset Arena<br>2/01/25 – 3/01/25',
    image: 'assets/images/featured_hource2.png'
  },
  {
    lat: 40.7128,
    lng: -74.0060,
    iconIndex: 2,
    title: 'Blaze | 2018 | 16.1h',
    breed: 'Dutch Warmblood | Gelding',
    price: '$90,000 – $120,000',
    location: 'New York, NY',
    trial: 'Liberty Equine Center<br>3/10/25 – 4/20/25',
    image: 'assets/images/featured_hource3.png'
  },
  {
    lat: 41.8781,
    lng: -87.6298,
    iconIndex: 3,
    title: 'Shadow | 2017 | 16.3h',
    breed: 'Hanoverian | Stallion',
    price: '$150,000 – $180,000',
    location: 'Chicago, IL',
    trial: 'Windy City Stable<br>4/01/25 – 5/10/25',
    image: 'assets/images/featured_hource4.png'
  },
  {
    lat: 29.7604,
    lng: -95.3698,
    iconIndex: 4,
    title: 'Rocket | 2016 | 15.9h',
    breed: 'Andalusian | Gelding',
    price: '$70,000 – $90,000',
    location: 'Houston, TX',
    trial: 'Southwest Equine Center<br>4/15/25 – 6/01/25',
    image: 'assets/images/featured_hource5.png'
  }
];

const popupCard = document.getElementById('popupCard');
const popupInfo = document.getElementById('popupInfo');
const popupImage = document.getElementById('popupImage');

let currentLatLng = null;

// Show popup near marker inside map
function showPopup(horse, latLng) {
  currentLatLng = latLng;

  // Fill content
  popupInfo.innerHTML = `
      <h3>${horse.title}</h3>
      <span class="breed">${horse.breed}</span>
      <div class="horse-price"><strong>Sale:</strong> ${horse.price}</div>
        <div class="horse-location">${horse.location}</div>
         <div class="horse-trial"><img src="assets/images/loca-icon.svg"  /> ${horse.trial}</div>
    `;
  popupImage.src = horse.image;

  // Convert latLng to container point
  const point = map.latLngToContainerPoint(latLng);

  // Position inside map
  popupCard.style.left = `${point.x + 20}px`;
  popupCard.style.top = `${point.y - 100}px`;
  popupCard.style.display = 'block';
}

// Keep popup in position during move
map.on('move', () => {
  if (currentLatLng) {
    const point = map.latLngToContainerPoint(currentLatLng);
    popupCard.style.left = `${point.x + 20}px`;
    popupCard.style.top = `${point.y - 100}px`;
  }
});

function closePopup() {
  popupCard.style.display = 'none';
  currentLatLng = null;
}

// Add markers with unique icons
horses.forEach(horse => {
  const marker = L.marker([horse.lat, horse.lng], { icon: icons[horse.iconIndex] }).addTo(map);
  marker.on('click', () => {
    showPopup(horse, marker.getLatLng());
  });
});

const dateInput = document.getElementById('dateInput');
const calendar = document.getElementById('calendar');

const months = [
  "January", "February", "March", "April", "May", "June",
  "July", "August", "September", "October", "November", "December"
];

let currentDate = new Date();

function renderCalendar(date) {
  calendar.innerHTML = "";

  const year = date.getFullYear();
  const month = date.getMonth();

  // Header
  const header = document.createElement("div");
  header.className = "header";
  header.innerHTML = `
    <button id="prevBtn">&lt;</button>
    <div>${months[month]} ${year}</div>
    <button id="nextBtn">asset('</button>
  `;
  calendar.appendChild(header);

  // Arrow buttons with re-render
  header.querySelector('#prevBtn').onclick = (e) => {
    e.stopPropagation();
    currentDate.setMonth(currentDate.getMonth() - 1);
    renderCalendar(currentDate);
  };
  header.querySelector('#nextBtn').onclick = (e) => {
    e.stopPropagation();
    currentDate.setMonth(currentDate.getMonth() + 1);
    renderCalendar(currentDate);
  };

  // Days
  const daysContainer = document.createElement("div");
  daysContainer.className = "days";

  // Weekday labels
  const weekdayLabels = ["Sun", "Mon", "Tue", "Wed", "Thu", "Fri", "Sat"];
  weekdayLabels.forEach(day => {
    const label = document.createElement("div");
    label.className = "day";
    label.style.fontWeight = "bold";
    label.textContent = day;
    daysContainer.appendChild(label);
  });

  // Dates
  const firstDay = new Date(year, month, 1).getDay();
  const daysInMonth = new Date(year, month + 1, 0).getDate();

  for (let i = 0; i < firstDay; i++) {
    const empty = document.createElement("div");
    daysContainer.appendChild(empty);
  }

  for (let d = 1; d <= daysInMonth; d++) {
    const day = document.createElement("div");
    day.className = "day";
    day.textContent = d;
    day.onclick = (e) => {
      e.stopPropagation();
      const formatted = `${year}-${String(month + 1).padStart(2, '0')}-${String(d).padStart(2, '0')}`;
      dateInput.value = formatted;
      calendar.classList.add("hidden");
    };
    daysContainer.appendChild(day);
  }

  calendar.appendChild(daysContainer);
}

// Show calendar on input click
dateInput.addEventListener("click", (e) => {
  e.stopPropagation(); // Prevent document click
  const rect = dateInput.getBoundingClientRect();
  calendar.style.top = `${rect.bottom + window.scrollY}px`;
  calendar.style.left = `${rect.left + window.scrollX}px`;
  calendar.classList.remove("hidden");
  renderCalendar(currentDate);
});

// Prevent closing when clicking inside calendar
calendar.addEventListener("click", (e) => {
  e.stopPropagation();
});

// Hide on outside click
document.addEventListener("click", () => {
  calendar.classList.add("hidden");
});


function updateRange() {
  const min = parseInt(document.getElementById("minRange").value);
  const max = parseInt(document.getElementById("maxRange").value);
  const minPriceEl = document.getElementById("minPrice");
  const maxPriceEl = document.getElementById("maxPrice");
  const track = document.getElementById("sliderTrack");

  const minPercent = (min / 100) * 100;
  const maxPercent = (max / 100) * 100;

  if (min > max) {
    minPriceEl.textContent = max;
    maxPriceEl.textContent = min;
    track.style.left = `${maxPercent}%`;
    track.style.width = `${minPercent - maxPercent}%`;
  } else {
    minPriceEl.textContent = min;
    maxPriceEl.textContent = max;
    track.style.left = `${minPercent}%`;
    track.style.width = `${maxPercent - minPercent}%`;
  }
}

window.addEventListener('DOMContentLoaded', () => {
  updateRange(); // Default track fill
});


// nav link active
document.addEventListener("DOMContentLoaded", function () {
  const links = document.querySelectorAll(".nav-link");
  const currentPath = window.location.pathname.split("/").pop();

  links.forEach(link => {
    const href = link.getAttribute("href");

    if (href === currentPath || (currentPath === "" && href === "index.php")) {
      link.classList.add("active");
    } else {
      link.classList.remove("active");
    }
  });
});

const icon = document.getElementById('fav');
icon.addEventListener('click', () => {
  icon.classList.toggle('fa-regular');
  icon.classList.toggle('fa-solid');
});
*/



function toggleFilter() {
  document.getElementById("filterSidebar").classList.toggle("show");
}