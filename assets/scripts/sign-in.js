document.addEventListener("DOMContentLoaded", () => {

    let signUpForm = document.getElementById("signUpForm");
    signUpForm.addEventListener("submit", (event) => {
        event.preventDefault();

        const signUpFormDataRaw = new FormData(signUpForm);
        const signUpFormData = {};

        signUpFormDataRaw.forEach((value, key) => {
            signUpFormData[key] = value;
        });

        Object.keys(signUpFormData).forEach(key => {
            signUpFormData[key] = cleanInput(signUpFormData[key]);
        });

        document.getElementById("finalErrorMessage").innerText = null;

        if (validateSignUpInputs(signUpFormData)) {
            grecaptcha.ready(function () {
                grecaptcha.execute('6LeMuigqAAAAADlvlCYys5m3xgcswPKjc5JZiuMj', { action: 'submit' }).then(function (token) {
                    // Add the reCAPTCHA token to the form data
                    signUpFormData['recaptcha_response'] = token;

                    fetch("http://localhost/GitHub/toDoListApp/controllers/SigninController.php", {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                        },
                        body: JSON.stringify(signUpFormData),
                    })
                        .then(response => response.json())
                        .then(data => {
                            if (data.success) {
                                storeData(data);
                                window.location.href = '2FA.php';
                            }
                            else {
                                document.getElementById("finalErrorMessage").innerText = data.message;
                            }
                        })
                        .catch(error => console.error('Error:', error));
                });
            });
        };
    });
});


function storeData(data) {
    localStorage.setItem("username", data.username);
    localStorage.setItem("userId", data.userId);
}

function validateSignUpInputs(signUpFormData) {
    let signUpErrorMessages = document.querySelectorAll("#signUpForm .error-message");

    let isValid = true;

    signUpErrorMessages.forEach(errorMessage => {
        if (errorMessage.classList.contains("has-error"))
            errorMessage.classList.remove("has-error");
    });

    result = validateUserName(signUpFormData['username']);

    if (result !== null) {
        signUpErrorMessages[0].classList.add("has-error");
        isValid = false;
    }
    signUpErrorMessages[0].innerText = result;

    result = validatePassword(signUpFormData['password']);
    if (result !== null) {
        signUpErrorMessages[0].classList.add("has_error");
        isValid = false;
    }
    signUpErrorMessages[1].innerText = result;


    return isValid;
}

function cleanInput(input) {
    return input.trim();
}

function validateUserName(username) {
    //username length should be between 3 and 20 just underscore is allowed
    const usernameCharactersRegex = /^[a-zA-Z0-9_]+$/;
    const usernameLengthRegex = /^[a-zA-Z0-9_]{3,20}$/;
    if (!username) {
        return "username can't be empty";
    }
    else if (!usernameCharactersRegex.test(username))
        return "username consiste of letters, numbers and underscores";
    else if (!usernameLengthRegex.test(username))
        return "username length between 3 and 20 characters";
    else
        return null;
}

function validatePassword(password) {
    //password length should be between 5 and 12
    const passwordRegex = /^[a-zA-Z0-9!@#$%^&*()_+={}\[\]|\\:;'",.<>?/-]{5,12}$/;

    if (!password) {
        return "password can't be empty";
    }
    else if (!passwordRegex.test(password))
        return "password length between 5 and 12";
    else {
        return null;
    }
}