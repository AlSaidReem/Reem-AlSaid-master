/// Burger Menu
const menuBtn = document.querySelector(".menu-btn");
const navigation = document.querySelector(".navigation");
menuBtn.addEventListener("click", () =>{
    menuBtn.classList.toggle("active");
    navigation.classList.toggle("active");

})

/// nav bar on scroll :
 window.addEventListener("scroll", function(){
    const header = document.querySelector('header');
    if(this.window.scrollY > 0 ){
        header.classList.add('scrolled')
    } else {
        header.classList.remove('scrolled')
    }
})

// save in session storage is login :
let loginButtonNav = document.getElementById('loginn');
let signupButtonNav = document.getElementById('sigupp');
const isloggedin = sessionStorage.getItem("isLoggedIn");

loginButtonNav.addEventListener('click', function () {
    window.location.href = '/login/login.html';
  })
if (isloggedin == 'true') {
  signupButtonNav.textContent = 'Profile';
  signupButtonNav.addEventListener('click', (e) => {
    window.location.href = '/userprofile/profile.html';
  });
  loginButtonNav.textContent = 'Log Out';
  loginButtonNav.addEventListener('click', (e) => {
    window.location.href = '/login/login.html';
    sessionStorage.clear();
  });
}

// image slider:
const slider = document.querySelector('.image-slider');
const arrLeft = document.querySelector('.arrow-left');
const arrRight = document.querySelector('.arrow-right');

let images = [];

const tourId = window.location.hash.substring(1);

// data for image
async function fetchImages() {
    try {
        const response = await fetch(`http://localhost/tourism/t_api/tourread.php?id=${tourId}`);
        if (!response.ok) {
            throw new Error(`HTTP error! Status: ${response.status}`);
        }
        const data = await response.json();

        // split(divide) the image string into an array of URLs
        // trim is used to removw the white sapace between the array of images
        images = data.image.split(',').map(url => url.trim());
        console.log('Image URLs:', images);

        // Start the slider with the first image
        slide(0);

        // set up automatic sliding every 4000 milliseconds (4 seconds)
        setInterval(() => {
            id++;
            if (id > images.length - 1) {
                id = 0;
            }
            slide(id);
        }, 4000);
    } catch (error) {
        console.error('Error fetching images:', error);
    }
}

// slider ID 
let id = 0;

function slide(id) {
    // seting the background image
    slider.style.backgroundImage = `url(http://localhost/tourism/images/${images[id]})`;
    // add image fade animation
    slider.classList.add('image-transition');

    // remove animation after it's done, so it can be used again
    setTimeout(() => {
        slider.classList.remove('image-fade');
    }, 550);
}

arrLeft.addEventListener('click', () => {
    id--;
    if (id < 0) {
        id = images.length - 1;
    }
    slide(id);
});

arrRight.addEventListener('click', () => {
    id++;
    if (id > images.length - 1) {
        id = 0;
    }
    slide(id);
});

// fetch images when the script loads
fetchImages();

// 10/12/2023
// read tour data
// get the tour ID from the URL hash in line 47
// fetch data using the tour ID

fetch(`http://localhost/tourism/t_api/tourread.php?id=${tourId}`)
  .then(response => {
    if (!response.ok) {
      throw new Error(`HTTP error! Status: ${response.status}`);
    }
    return response.json();
  })
  .then(data => {
    console.log(data);
    displayData(data)
  })
  .catch(error => {
    console.error('Fetch error:', error);
  });


function displayData(data) {
  const dataContainer = document.getElementById('div-map');
  dataContainer.innerHTML = `
<h2> ${data.name} Tour </h2>
<div class="google">
  <div class="map">
    <div  id="location">
      <iframe onload="createMap()"></iframe>
    </div>

    <div class="des-info">
      <div class="information">
      <div class="card">
     
          <h3>Number of Seats : </h3>
          <p style="color: ${data.seats <= 10 ? 'red' : 'black'}">${data.seats} </p>

          <h3 style="text-align:left ; padding-left:55px" > Date : <span> </span></h3>
          <p >${data.date}</p>
      </div>
      <div class="card">
          <h3>Price (Per person) :</h3>
          <p>${data.price} JD </p>

          <h3>Tour guide Name :</h3>
          <p> ${data.tour_guide_username}</p>
      </div>
     </div>
      <h3> Description :</h3>
        <p>${data.description}</p>

        <div class="btn"> 
          <button onclick="bookNow()" id="bookBtn"> Book Now</button>
        </div>

      </div>
    </div>

  </div>
</div>`      

}

function bookNow() {
    const user_id = sessionStorage.getItem('id');

    // check if the user is logged in
    if (!user_id) {

      // user is not logged in so go to the login page
      window.location.href = '/login/login.html';
      return;
    }

  const data = {
      user_id: user_id,
      tour_id: tourId
  };

  fetch('http://localhost/tourism/t_api/insert_booking.php', {
      method: 'POST',
      body: JSON.stringify(data),
      headers: {
          'Content-Type': 'application/json'
      },
  })
      .then(response => response.json())
      .then(result => {
          if (result.message) {
              alert(`Awesome ! You booked a seat on the Tour !`);
              window.location.reload(); 
          } else if (result.error) {
              console.error(result.error); 
          }
      })
      .catch(error => console.log(error));
}

/// location map API 
// Leaflet map
// L. is the leaflat library
//  leaflet is an open-source js library used for creating interactive maps

function createMap() {
  var locationDiv = document.getElementById('location');

  if (locationDiv) {
    var map = L.map(locationDiv).setView([31.302, 37.092], 7);

    L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
      maxZoom: 25,
      attribution: '&copy; <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a>'
    }).addTo(map);

    var coords1 = [31.8357,36.0626];
    var coords2 = [31.7771, 35.2064];

    var icon1 = L.icon({ iconUrl: '/images/location/jordan.png', iconSize: [50, 50] });
    var icon2 = L.icon({ iconUrl: '/images/location/palestine.png', iconSize: [50, 50] });

    L.marker(coords1, { icon: icon1 }).addTo(map);
    L.marker(coords2, { icon: icon2 }).addTo(map);
  }
}











// var coords1 = [31.8357,36.0626];
// var coords2 = [31.7771, 35.2064];

// var icon1 = L.icon({ iconUrl: '/images/location/jordan.png', iconSize: [50, 50] });
// var icon2 = L.icon({ iconUrl: '/images/location/palestine.png', iconSize: [50, 50] });

// L.marker(coords1, { icon: icon1 }).addTo(map);
// L.marker(coords2, { icon: icon2 }).addTo(map);





// <div class="map-info">  
//       <div class="card">
//             <h3> Date :</h3>
//             <p>${data.date}</p>
//       </div>
//       <div class="card">
//           <h3>Number of Seats :</h3>
//           <p style="color: ${data.seats <= 10 ? 'red' : 'black'}">${data.seats}</p>
//       </div>
//       <div class="card">
//           <h3>Tour guide Name :</h3>
//           <p>${data.tour_guide_id}</p>
//       </div>
//       <div class="card">
//           <h3>Price (Per person) :</h3>
//           <p>${data.price}</p>
//       </div>

// .map-info{
//   /* height: 60vh; */
//   width: 50%;
//   display: flex;
//   flex-direction: column;
//   padding: 20px;
//   justify-content:baseline;
 
//   align-items:start;
 
//   margin-top: 0px;
// }
// /* .map-info .card{
//   border: 1px solid #000;
//   padding: 15px;
//   margin-bottom: 20px;
//   height: 100px;
// } */
// .card{
//   /* width: 50%; */
 
//   /* box-shadow: 0 10px 5px  #074310a4; */
//   /* box-shadow: 0 10px 5px #074310a4; */
// }
// .card p{
//   font-size: larger;
//   font-weight: bolder;
// }



// Named function to create the map
// function createMap() {
//   var locationDiv = document.getElementById('location');

//   if (locationDiv) {
//     // Fetch tour data using the tourId
//     fetch(`http://localhost/tourism/t_api/tourread.php?id=${tourId}`)
//       .then(response => {
//         if (!response.ok) {
//           throw new Error(`HTTP error! Status: ${response.status}`);
//         }
//         return response.json();
//       })
//       .then(data => {
//         // Use fetched latitude, longitude, and destination_id
//         var map = L.map(locationDiv).setView([data.latitude, data.longitude], 7);

//         L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
//           maxZoom: 19,
//           attribution: '&copy; <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a>'
//         }).addTo(map);

//         var icon1 = L.icon({ iconUrl: '/images/location/jordan.png', iconSize: [50, 50] });
//         var icon2 = L.icon({ iconUrl: '/images/location/palestine.png', iconSize: [50, 50] });

//         // Add marker based on destination_id
//         if (data.destination_id === 1) {
//           L.marker([data.latitude, data.longitude], { icon: icon1 }).addTo(map);
//         } else {
//           L.marker([data.latitude, data.longitude], { icon: icon2 }).addTo(map);
//         }
//       })
//       .catch(error => {
//         console.error('Fetch error:', error);
//       });
//   }
// }
