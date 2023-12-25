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


// send comment to database :
document.getElementById('formComment').addEventListener('submit', function (event){
  event.preventDefault();

  const review = document.getElementById('comment').value;
  const rateInput = document.querySelector('input[type="radio"]:checked').value;
  const userId = sessionStorage.getItem('id');

  if (userId && review && rateInput) {
    console.log(userId);
    console.log(rateInput)
    console.log(review);
     
    const data = {
      user_id: userId,
      comments: review,
      rating: rateInput
    };

    fetch('http://localhost/tourism/t_api/insert_review.php', {
      method: 'POST',
      body: JSON.stringify(data),
      headers: {
        'Content-Type': 'application/json'
      },
    })
    .then(response => {
      if (response.ok) {
        alert('Comment submitted successfully');
        window.location.reload();
      } else {
        console.error('Failed to submit comment');
      }
    })
    .catch(error => console.error('Error during fetch:', error));
  } else {

    alert('Please fill the comment section');
  }
})
