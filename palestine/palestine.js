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


/// get data
fetch(`http://localhost/tourism/t_api/tourread.php?destination_id=2`)

   .then(response => {
				if (!response.ok) {
					throw new Error(`HTTP error! Status: ${response.status}`);
				}
				return response.json();
			})
			.then(data => {
			console.log(data);
            displayData(data);

			})
			.catch(error => {
				console.error('Fetch error:', error);
			});

// read tour:
function displayData(data) {
  const dataContainer = document.getElementById('container');
  dataContainer.innerHTML = '';
 for (let i = 0; i < data.length; i++) {
 const cards = document.createElement('div');
 const firstImage = data[i]['image'].split(', ')[0];

     cards.className = "card";
     cards.innerHTML = `
           <div class="imgBx">
           <img src="http://localhost/tourism/images/${firstImage}">
           </div>
           <div class="content">
                    <h3>${data[i].name}</h3>
                    <p>${data[i].description.slice(0, 150)+"...etc"}</p>
                    <a href="/tours/tours.html#${data[i].id}"> Read more</a>
            </div>`;

       dataContainer.appendChild(cards);}
   }

// search by name:
async function searchTours() {
  const input = document.getElementById('nameInput');
  const name = input.value.trim().toLowerCase();
  try {
      const response = await fetch(`http://localhost/tourism/t_api/search_name_pal.php?search=${name}`);
      const data = await response.json();
      console.log(data);
      displayData(data);
  } catch (error) {
      console.error('Error fetching data:', error);
  }
}

/// filter date
    const dateFrom = document.getElementById('from');
    const dateTo = document.getElementById('to');
    async function searchToursByDate() {
        const startDate = dateFrom.value;
        const endDate = dateTo.value;

        if (startDate && endDate) {
            try {
                const response = await fetch(`http://localhost/tourism/t_api/search_date_pal.php?from=${startDate}&to=${endDate}`);
                const data = await response.json();
                console.log(data);
                displayData(data); 

            } catch (error) {
                console.error('Error fetching data:', error);
            }
        } else {
            console.log('Please select both start and end dates.');
        }
    }