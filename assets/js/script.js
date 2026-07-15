document.addEventListener("DOMContentLoaded", function() {
    
    const registerForm = document.getElementById("registerForm");

    if (registerForm) {
        registerForm.addEventListener("submit", function(event) {
            let isValid = true;

            // Get field values
            const email = document.getElementById("email").value;
            const password = document.getElementById("password").value;
            
            // Get error text elements
            const emailError = document.getElementById("emailError");
            const passwordError = document.getElementById("passwordError");

            // Simple Email Regex
            const emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;

            // Validate Email
            if (!emailPattern.test(email)) {
                emailError.style.display = "block";
                isValid = false;
            } else {
                emailError.style.display = "none";
            }

            // Validate Password
            if (password.length < 6) {
                passwordError.style.display = "block";
                isValid = false;
            } else {
                passwordError.style.display = "none";
            }

            // Prevent form submission if validation fails
            if (!isValid) {
                event.preventDefault();
            }
        });
    }
});