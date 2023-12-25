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

/// video slider:
const btns = document.querySelectorAll(".nav-btn");
const slides =document.querySelectorAll(".video-slide")

var sliderNav = function (manual){
    btns.forEach((btn) =>{
       btn.classList.remove("active") 
    })
    slides.forEach((slide) =>{
        slide.classList.remove("active") 
     })
    btns[manual].classList.add("active");
    slides[manual].classList.add("active");

}

// add eventlistener to the clicked btn to apply the sliderNav function
btns.forEach((btn,i) => {
    btn.addEventListener("click", () =>{
        sliderNav(i);
    })
})

// go to sign up page :
function signPage(){
    window.location.href = '/signup/signup.html'
}

// weather :
const container = document.querySelector('.container-weather');
const search = document.querySelector('.search-box button');
const weatherBox = document.querySelector('.weather-box');
const weatherDetails = document.querySelector('.weather-details');
const error404 = document.querySelector('.not-found')

search.addEventListener('click', ()=> {

    const APIkey ='bbe8752170357702641ecca0a5c322f9';
    const city = document.querySelector('.search-box input').value;
    
    if ( city == '')
        return;

        fetch(`https://api.openweathermap.org/data/2.5/forecast?q=${city}&appid=${APIkey}`)
        .then(response => response.json())
            .then(json => {
            console.log(json); 

            
            if (json.cod === '404') {
                // City not found, show the not-found section
                error404.style.visibility = 'visible';
                weatherBox.style.display = 'none'; 
                return;
            } else {
                // City found, hide the not-found section
                error404.style.visibility = 'hidden';
                weatherBox.style.display = 'block'; 
            }



            const image = document.querySelector('.weather-box img');
            const temperature = document.querySelector('.weather-box .temperature');
            const description = document.querySelector('.weather-box .description');
            const humidity = document.querySelector('.info-humidity span');
            const wind = document.querySelector('.info-wind span');


            switch(json.list[0].weather[0].description){
                case 'clear sky':
                  image.src = '/images/clear.png';
                  break;

                case 'overcast clouds':
                    image.src = '/images/overcast.png';
                    break;
                
                case 'Snow':
                    image.src = '/images/snow.png';
                    break;

                case 'Clouds':
                    image.src = '/images/cloud.png';
                    break;

                case 'Mist':
                    image.src = '/images/Mist.png';
                     break;

                case 'Haze':
                    image.src = '/images/Haze.png';
                    break;
                case 'scattered clouds':
                    image.src = '/images/scattered_clouds.png';
                    break;
                case 'few clouds':
                    image.src = '/images/few_clouds.png';
                    break;
                case 'light rain':
                    image.src = '/images/light_rain.png';
                    break;

                default:
                    image.src = '/images/cloud.png';

            }
            // Convert temperature from Kelvin to Celsius
            const celsiusTemperature = parseInt(json.list[0].main.temp) - 273.15;

            temperature.innerHTML =`${celsiusTemperature.toFixed(2)} <span>°C</span>`
            description.innerHTML =`${json.list[0].weather[0].description}`;
            humidity.innerHTML =`${json.list[0].main.humidity}%`;
            wind.innerHTML =`${parseInt(json.list[0].wind.speed)} km/h`;
         })   .catch(error => {
            console.error('Error fetching data:', error);
        });

})



// reveal (To show) 
function reveal() {
    var reveals = document.querySelectorAll(".reveal");
  
    for (var i = 0; i < reveals.length; i++) {
      var windowHeight = window.innerHeight;
      var elementTop = reveals[i].getBoundingClientRect().top;
      var elementVisible = 150;
  
      if (elementTop < windowHeight - elementVisible) {
        reveals[i].classList.add("active");
      } else {
        reveals[i].classList.remove("active");
      }
    }
  }
  
  window.addEventListener("scroll", reveal);




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
    window.location.href = '/userProfile/profile.html';
  
  });
  loginButtonNav.textContent = 'Log Out';
  loginButtonNav.addEventListener('click', (e) => {
    window.location.href = '/login/login.html';
    sessionStorage.clear();
  });
} else {
    signupButtonNav.addEventListener('click', (e) => {
        window.location.href = "/signup/signup.html";
    });

    loginButtonNav.addEventListener('click', (e) => {
        window.location.href = "/login/login.html";
    }); 
}


// Read comment:
async function reviewUsers() {
    const response = await fetch('http://localhost/tourism/t_api/show_last_review.php', {
        method: 'GET',
    });
    const data = await response.json();
    console.log(data);

    const reviewsList = document.querySelector('.container-review');
    reviewsList.innerHTML = "";

    data.forEach(reviewData => {
        let reviewCard = document.createElement('div');
        reviewCard.className = "review-card";
        
        let ratingHTML = "";
        for (let i = 1; i <= reviewData.rating ; i++) {
            ratingHTML += `<input type="radio" value="${i}"><label>&#9733;</label>`;
        }
        reviewCard.innerHTML = `
            
                <div class="client_info">
                    <div class="client_name">
                        <h5>${reviewData.username}</h5>
                    </div>
                </div>
                <div class="rating">
                    ${ratingHTML}
                </div>
                <p>" ${reviewData.comments} "</p>`;

        reviewsList.appendChild(reviewCard);
    });

    return data;
}

  
  reviewUsers();

//   ratingHTML += `<input type="radio" id="star${i}" name="rating${reviewData.user_id}" value="${i}"><label for="star${i}">&#9733;</label>`;