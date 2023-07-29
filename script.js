function validateForm() {
    const nameInput = document.getElementById("name");
    const emailInput = document.getElementById("email");
    const passwordInput = document.getElementById("password");
    const passwordConfirmationInput = document.getElementById("password-confirmation");
    const passwordPattern = /^(?=.*[A-Za-z])(?=.*\d)[A-Za-z\d]{6,}$/;

    const nameError = document.getElementById("nameError");
    const emailError = document.getElementById("emailError");
    const passwordError = document.getElementById("passwordError");
    const passwordConfirmationError = document.getElementById("passwordConfirmationError");

    // Clear previous error messages
    nameError.textContent = "";
    emailError.textContent = "";
    passwordError.textContent = "";
    passwordConfirmationError.textContent = "";

    if (nameInput.value.trim() === "") {
        nameError.textContent = "Please enter your name.";
        return false;
    }

    if (emailInput.value.trim() === "") {
        emailError.textContent = "Please enter your email.";
        return false;
    }

    const emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    if (!emailPattern.test(emailInput.value)) {
        emailError.textContent = "Please enter a valid email address.";
        return false;
    }

    if (passwordInput.value.length < 6 || !passwordPattern.test(passwordInput.value)) {
        passwordError.textContent = "Password must be at least 6 characters long and contain at least one letter and one number.";
        return false;
    }

    if (passwordInput.value !== passwordConfirmationInput.value) {
        passwordConfirmationError.textContent = "Passwords do not match.";
        return false;
    }

    // Check email availability via fetch request
    const emailAvailabilityUrl = "validate-email.php?email=" + encodeURIComponent(emailInput.value);

    return fetch(emailAvailabilityUrl)
        .then(response => response.json())
        .then(data => {
            if (!data.available) {
                emailError.textContent = "This email is already taken. Please choose a different one.";
                return false;
            } else {
                // If the email is available, proceed with form submission
                return true;
            }
        })
        .catch(error => {
            console.error("Error checking email availability:", error);
            return false;
        });
}
