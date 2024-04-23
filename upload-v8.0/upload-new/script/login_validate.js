document.addEventListener("DOMContentLoaded", function() {
    let usernameInput = document.getElementById('username');
    let passwordInput = document.getElementById('password');

    let usernameErrorMessage = document.getElementById("usernameErrorMessage");
    let passwordErrorMessage = document.getElementById('passwordErrorMessage');

    let usernameValid = false;
    let passwordValid = false;

    usernameInput.addEventListener("input", validateUsername);
    passwordInput.addEventListener("input", validatePassword);

    function validate() {
        validateUsername(); 
        validatePassword(); 
        return false;
    }
    
    function validateUsername() {
        let usernameValue = usernameInput.value;
        if (usernameValue.length === 0 || usernameValue.length > 10) {
            usernameErrorMessage.textContent = 'Username should be non-empty and less than 10 characters long';
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
});
