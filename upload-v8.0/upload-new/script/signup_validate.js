document.addEventListener("DOMContentLoaded", function() {
    let usernameInput = document.getElementById('username');
    let passwordInput = document.getElementById('password');
    let confirmPasswordInput = document.getElementById('password2');

    let usernameErrorMessage = document.getElementById("usernameErrorMessage");
    let passwordErrorMessage = document.getElementById('passwordErrorMessage');
    let confirmPasswordErrorMessage = document.getElementById('confirmPasswordErrorMessage');

    let usernameValid = false;
    let passwordValid = false;
    let confirmPasswordValid = false;

    usernameInput.addEventListener("input", validateUsername);
    passwordInput.addEventListener("input", validatePassword);
    confirmPasswordInput.addEventListener("input", validateConfirmPassword);

    function validate() {
        validateUsername(); 
        validatePassword(); 
        validateConfirmPassword();
        return false;
    }

    function validateUsername() {
        let usernameValue = usernameInput.value;

        if (usernameValue.length === 0 || usernameValue.length > 30) {
            usernameErrorMessage.textContent = 'Username should be non-empty and less than 30 characters long';
            usernameErrorMessage.style.color = "red";
            usernameValid = false;
        } else {
            usernameErrorMessage.textContent = "";
            usernameErrorMessage.style.color = "";
            usernameValid = true;
        }
    }

    function validatePassword() {
        let passwordValue = passwordInput.value;

        if (passwordValue.length < 8) {
            passwordErrorMessage.textContent = "Password must be at least 8 characters";
            passwordErrorMessage.style.color = "red";
            passwordValid = false;
        } else {
            passwordErrorMessage.textContent = "";
            passwordErrorMessage.style.color = "";
            passwordValid = true;
        }
    }

    function validateConfirmPassword() {
        let confirmPasswordValue = confirmPasswordInput.value;
        let passwordValue = passwordInput.value;

        if (confirmPasswordValue !== passwordValue || confirmPasswordValue.length === 0) {
            confirmPasswordErrorMessage.textContent = "Passwords do not match";
            confirmPasswordErrorMessage.style.color = "red";
            confirmPasswordValid = false;
        } else {
            confirmPasswordErrorMessage.textContent = "";
            confirmPasswordErrorMessage.style.color = "";
            confirmPasswordValid = true;
        }
    }
});
