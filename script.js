let menu = document.querySelector("#menu-btn");
let navbar = document.querySelector(".navbar");

menu.onclick = () => {
    navbar.classList.toggle("active");
};

window.onscroll = () => {
    navbar.classList.remove("active");
};

window.onscroll = () =>{
    navbar.classList.toogle('active');
};

document.querySelector('.btn').addEventListener('click', function(event) {
    event.preventDefault(); 
    const targetId = this.getAttribute('href'); 
    const targetSection = document.querySelector(targetId); // Find the target section using the ID
    targetSection.scrollIntoView({ behavior: 'smooth' }); 
});

const learnMoreBtn = document.getElementById('learn-more-btn');
const additionalInfo = document.getElementById('additional-info');
    
learnMoreBtn.addEventListener('click', function(event) {
    event.preventDefault(); // Prevent default behavior of anchor tag
    additionalInfo.classList.toggle('hidden'); // Toggle the 'hidden' class to reveal or hide the additional information
}); 


document.getElementById("reserveBtn").addEventListener("click", function(event) {
    // Prevent the default form submission behavior
    event.preventDefault();
    // Call the function to show the modal
    showPersonDetails();
});

// Add event listener to the button
document.getElementById("reserveBtn").addEventListener("click", showPersonDetails);

// Function to show the modal
function showPersonDetails(){
    document.getElementById("personModal").style.display = "block";
}

// Function to close the modal
function closePersonDetails(){
    document.getElementById("personModal").style.display = "none";
}


function closePersonDetails(){
    document.getElementById("personModal").style.display = "none";
};


function previewImage(event) {
    var input = event.target;
    var reader = new FileReader();

    reader.onload = function() {
        var imgElement = document.createElement('img');
        imgElement.src = reader.result;
        imgElement.style.maxWidth = '100%';
        document.getElementById('image-preview').innerHTML = '';
        document.getElementById('image-preview').appendChild(imgElement);
    }
    reader.readAsDataURL(input.files[0]);
};


// Get the modal element
var modal = document.getElementById("loginModal");

// Get the buttons for each login type
var adminLoginBtn = document.getElementById("adminLoginBtn");
var userLoginBtn = document.getElementById("userLoginBtn");
var userRegisterBtn = document.getElementById("userRegisterBtn");
var ownerLoginBtn = document.getElementById("ownerLoginBtn");
var userLoginBtn1 = document.getElementById("userLoginBtn1");

// Get the forms for each login type
var adminLoginForm = document.getElementById("adminLoginForm");
var userLoginForm = document.getElementById("userLoginForm");
var userLoginForm1 = document.getElementById("userLoginForm1");
var userRegisterForm = document.getElementById("userRegistrationForm");
var ownerLoginForm = document.getElementById("ownerLoginForm");

// Function to show the admin login form and hide others
function showAdminLoginForm() {
  adminLoginForm.style.display = "block";
  userLoginForm.style.display = "none";
  ownerLoginForm.style.display = "none";
}

// Function to show the user login form and hide others
function showUserLoginForm() {
  adminLoginForm.style.display = "none";
  userLoginForm.style.display = "block";
  ownerLoginForm.style.display = "none";
}

function showUserRegisterForm() {
    userLoginForm1.style.display = "none";
    userRegisterForm.style.display ="block";
}

function showUserLoginForm1() {
    userLoginForm1.style.display = "block";
    userRegisterForm.style.display ="none";
}

// Function to show the owner login form and hide others
function showOwnerLoginForm() {
  adminLoginForm.style.display = "none";
  userLoginForm.style.display = "none";
  ownerLoginForm.style.display = "block";
}

// Event listeners for each login button
adminLoginBtn.addEventListener("click", showAdminLoginForm);
userLoginBtn.addEventListener("click", showUserLoginForm);
userRegisterBtn.addEventListener("click", showUserRegisterForm);
ownerLoginBtn.addEventListener("click", showOwnerLoginForm);
userLoginBtn1.addEventListener("click", showUserLoginForm1);


var adminCredentials = [
    {username:"admin1", password:"password1"},
    {username:"admin2", password:"password2"}
];

function login(userType) {
    var username, password;
    var redirectPage;

    switch(userType) {
        case 'admin':
            username = document.getElementById("adminUsername").value;
            password = document.getElementById("adminPassword").value;
            redirectPage = "admin.php";
            break;
        default:
            return;
    }

    var validCredentials = false;
    switch(userType) {
        case 'admin':
            validCredentials = adminCredentials.some(function(admin) {
                return admin.username === username && admin.password === password;
            });
            break;
    }

    if (validCredentials) {
        window.location.href = redirectPage;
    } else {
        alert("Invalid Username or Password. Please try again.");
    }
}


function login(userType) {
    var username = document.getElementById("userUsername").value;
    var password = document.getElementById("userPassword").value;
    var redirectPage = "user.php"; // Assuming the default redirect page for users

    // Create a FormData object to send the username and password to the server
    var formData = new FormData();
    formData.append('username', username);
    formData.append('password', password);

    // Send the login data to the server using fetch or XMLHttpRequest
    fetch('login.inc.php', {
        method: 'POST',
        body: formData
    })
    .then(response => response.text())
    .then(data => {
        if (data.trim() === "Login successful") {
            // Redirect to the specified page after successful login
            window.location.href = redirectPage;
        } else {
            // Show an alert for invalid credentials
            alert("Invalid Username or Password. Please try again.");
        }
    })
    .catch(error => {
        console.error('Error:', error);
        // Handle any errors that occur during the fetch request
    });
}