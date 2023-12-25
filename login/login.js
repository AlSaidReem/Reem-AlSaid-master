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

// Email Validation
function validationEmail() {
    let email = document.getElementById("email_input");
    let emailError = document.getElementById("email_error");

    if (!email.value.match(/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/)) {
        emailError.textContent = 'Please Enter a valid email address!';
        return false;
    } else {
        emailError.textContent = '';
        return true;
    }
}

// Password validation
function validationPass() {
    let createField = document.getElementById("password").value;
    let createError = document.getElementById("error_pass");
    if (!createField.match(/^(?=.*[a-z])(?=.*[A-Z])(?=.*[?!@#$%^&*])[A-Za-z\d@$!%*?&#]{8,}$/)) {
        createError.textContent = "Password is not valid!";
        return false;
    } else {
        createError.textContent = "";
        return true;
    }
}

// Password show and hide
let showPass = document.getElementById("show_password");
let passwordField = document.getElementById("password");
showPass.addEventListener('click', function () {
    if (passwordField.type === "password") {
        showPass.classList.replace("fa-eye-slash", "fa-eye");
        passwordField.type = "text";
    } else {
        showPass.classList.replace("fa-eye", "fa-eye-slash");
        passwordField.type = "password";
    }
});

  
// Submit and fetch:
var loginButton = document.getElementById("Login");
loginButton.addEventListener('click', function (event) {
    event.preventDefault();
    let isEmailValid = validationEmail();
    let isPassValid = validationPass();

    if (isEmailValid && isPassValid) {
        let email = document.getElementById("email_input").value;
        let password = document.getElementById("password").value;

        var user = {
            email: email,
            password: password
        };

        fetch('http://localhost/tourism/t_api/login_api.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify(user)
        })
            .then(response => {
                if (!response.ok) {
                    throw new Error('Network response was not ok');
                }
                return response.json(); 
            })
            .then(data => {
               console.log(data);
               let user_id = data.user_id;
               let role = data.role;

               if (role === 'users') {
                    sessionStorage.setItem("isLoggedIn", "true");
                    sessionStorage.setItem("id", user_id);
                    window.location.href = '/index/index.html';
                }
                else if (role === 'admin') {
                sessionStorage.setItem("isLoggedIn", "true");
                sessionStorage.setItem("id", user_id);
                window.location.href = '/dashboard/home.html';
                }
                else if (role === 'tour guide') {
                sessionStorage.setItem("isLoggedIn", "true");
                sessionStorage.setItem("id", user_id);
                window.location.href = '/dashboard/Guide_Dashboard/guideHome.html';
                } 
                else {
                alert('Error: Invalid user role');
                }
            })
            .catch(error => {
                console.error('There was a problem with the fetch operation:', error);
               
            });
    }
});