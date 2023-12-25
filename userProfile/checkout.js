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


// Checkout validation:
function validateForm() {
    var ownerName = document.getElementById("ownerName").value;
    var cvv = document.getElementById("cvv").value;
    var cardNumber = document.getElementById("cardNumber").value;

    // Validate owner name
    if (ownerName.trim() === "") {
        markFieldAsInvalid("ownerName");
        return;
    }

    // Validate CVV
    if (!/^\d{3,4}$/.test(cvv)) {
        markFieldAsInvalid("cvv");
        return;
    }

    // Validate card number using Luhn's algorithm
    if (!luhnCheck(cardNumber.replace(/\s/g, ""))) {
        markFieldAsInvalid("cardNumber");
        return;
    }

    // Validate expiration date
    var selectedMonth = document.getElementById("months").value;
    var selectedYear = document.getElementById("years").value;
    var currentDate = new Date();
    var expirationDate = new Date(selectedYear, selectedMonth);

    if (expirationDate < currentDate) {
        alert("Invalid expiration date");
        return;
    }

    // If the form is valid, you can proceed with the payment or further actions
    alert("Payment confirmed!");
}

function markFieldAsInvalid(fieldId) {
    document.getElementById(fieldId).classList.add("error");
    alert("Invalid input. Please check the highlighted fields.");
}

function luhnCheck(value) {
    var sum = 0;
    var shouldDouble = false;

    // Loop through each digit in reverse order
    for (var i = value.length - 1; i >= 0; i--) {
        var digit = parseInt(value.charAt(i), 10);

        // If the digit is doubled, subtract 9 if it's greater than 9
        if (shouldDouble) {
            digit *= 2;
            if (digit > 9) {
                digit -= 9;
            }
        }

        // Add the digit to the sum
        sum += digit;

        // Alternate doubling for the next iteration
        shouldDouble = !shouldDouble;
    }

    // The number is valid if the sum is a multiple of 10
    return (sum % 10 === 0);
}