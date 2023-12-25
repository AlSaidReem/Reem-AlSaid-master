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

// User Name validation:
function validationName() {
    let nameInput = document.getElementById("username").value;
    let nameError = document.getElementById("name_error");
    if (nameInput.trim() === '') {
        nameError.textContent = 'Username is required!';
        return false;
    } else {
        nameError.textContent = '';
        return true;
    }
}

// Email Validation:
function validationEmail() {
    let emailInput = document.getElementById("email").value;
    let emailError = document.getElementById("email_error");
    if (!/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/.test(emailInput)) {
        emailError.textContent = 'Please Enter a valid email address!';
        return false;
    } else {
        emailError.textContent = '';
        return true;
    }
}

// Phone number validation:
function validattionPhone(){
    let phoneInput = document.getElementById('phone').value;
    let phoneError = document.getElementById('phone_error');
    let phonePattern = /^077\d{7}$/;

      if (phoneInput.trim() === '') {
        phoneError.textContent = 'Phone number is required!';
        return false;
    } else if (!phonePattern.test(phoneInput)) {
        phoneError.textContent = 'Please Enter Phone number with 10 numbers start with 077!';
        return false;
    } else {
        phoneError.textContent = '';
        return true;
    }
}

// Password validation:
function validationCreate() {
    let passwordInput = document.getElementById("password").value;
    let createError = document.getElementById("create_error");
    if (!/(?=.*[a-z])(?=.*[A-Z])(?=.*[?!@#$%^&*])[A-Za-z\d@$!%*?&#]{8,}/.test(passwordInput)) {
        createError.textContent = "Please enter at least 8 characters with a number, symbol, lowercase, and uppercase letters!";
        return false;
    } else {
        createError.textContent = "";
        return true;
    }
}

// Confirm Password:
function checkPassword() {
    let password = document.getElementById("password").value;
    let confirmPassword = document.getElementById("confirm-password").value;
    let errorCheck = document.getElementById("confirm_error");

    if (password.trim() === '') {
        errorCheck.textContent = "Password is required!";
        return false;
    } else if (password !== confirmPassword) {
        errorCheck.textContent = "Passwords don't match!";
        return false;
    } else {
        errorCheck.textContent = "";
        return true;
    }
}


// Passwords show and hide:
let showPass = document.getElementById("show_password");
let passwordField = document.getElementById("password");
showPass.addEventListener('click', function () {
    if (passwordField.type === "password") {
        showPass.classList.replace("fa-eye-slash", "fa-eye");
        return (passwordField.type = "text");
    }
    else {
        showPass.classList.replace("fa-eye", "fa-eye-slash")
        passwordField.type = "password"
    }
})

let showCon = document.getElementById("confirm_password");
let confirmField = document.getElementById("confirm-password")
showCon.addEventListener('click', function () {
    if (confirmField.type === "password") {
        showCon.classList.replace("fa-eye-slash", "fa-eye");
        return (confirmField.type = "text")
    }
    else {
        showCon.classList.replace("fa-eye", "fa-eye-slash");
        confirmField.type = "password"
    }
})



// Form Submission and Fetch API:
var signBottom = document.getElementById("button");
signBottom.addEventListener("click", function (event) {
    event.preventDefault();

    let isValidName = validationName();
    let isValidEmail = validationEmail();
    let isValidPassword = validationCreate();
    let isMatchingPassword = checkPassword();
    let isMatchPhone = validattionPhone();

    if (isValidName && isValidEmail && isValidPassword && isMatchingPassword && isMatchPhone) {
        const username = document.getElementById("username").value;
        const email = document.getElementById("email").value;
        const password = document.getElementById("password").value;
        const phone_number =document.getElementById("phone").value;

        const user = {
            username: username,
            email: email,
            password: password,
            phone_number :phone_number

        };

        fetch('http://localhost/tourism/t_api/signupapi.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify(user)
        })
            .then(response => {
                if (response.ok) {
                    window.location.href = "/login/login.html"; // Redirect upon successful submission
                } else {
                    throw new Error('Network response was not ok.');
                }
            })
            .catch(error => {
                console.error('There was a problem with the fetch operation:', error);
            });
    }
});