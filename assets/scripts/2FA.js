document.addEventListener("DOMContentLoaded", () => {

    getQAUrl();

    let twoFactorForm = document.getElementById("2FAFrom");

    twoFactorForm.addEventListener("submit", event => {
        event.preventDefault();

        const signUpFormDataRaw = new FormData(twoFactorForm);
        const signUpFormData = {};

        signUpFormDataRaw.forEach((value, key) => {
            signUpFormData[key] = value;
        });

        Object.keys(signUpFormData).forEach(key => {
            signUpFormData[key] = cleanInput(signUpFormData[key]);
        });

        if (signUpFormData["2fA_code"]) {
            fetch(`http://localhost/GitHub/toDoListApp/controllers/authenticateTwoFactorCode.php?twoFactorSecretCode=${signUpFormData["2fA_code"]}&userId=${localStorage.getItem("userId")}`, {
                method: 'GET',
                headers: {
                    'Content-Type': 'application/json',
                },
            })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        window.location.href = '../index.php';
                    }
                    else {
                        document.getElementById("finalErrorMessage").innerText = data.message;
                    }
                })
                .catch(error => console.error('Error:', error));
        }

    });


});

async function getQAUrl() {
    fetch(`http://localhost/GitHub/toDoListApp/controllers/generate_secret_2FA.php?userId=${localStorage.getItem("userId")}`, {
        method: 'GET',
        headers: {
            'Content-Type': 'application/json',
        },
    })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                document.getElementById("qrImg").src = data.qrImgUrl;
            }
        })
        .catch(error => console.error('Error:', error));
}

function cleanInput(input) {
    return input.trim();
}