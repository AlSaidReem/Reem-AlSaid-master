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