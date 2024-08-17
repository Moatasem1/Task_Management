<?php
session_start();

if (!isset($_SESSION["isLoggedIn"]) || !$_SESSION["isLoggedIn"]) {
    header("Location: sign-in.html");
    exit();
}
?>

<!doctype html>
<html lang="en">

<head>
    <title>2FA</title>
    <!-- Required meta tags -->
    <meta charset="utf-8" />
    <meta
        name="viewport"
        content="width=device-width, initial-scale=1, shrink-to-fit=no" />

    <!-- Bootstrap CSS v5.2.1 -->
    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css"
        rel="stylesheet"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN"
        crossorigin="anonymous" />
    <link rel="stylesheet" href="../assets/styles/global.css">
</head>

<body>
    <main class="container py-5">
        <h1 class="fw-semibold text-center">Secure Your Account with Two-Factor Authentication</h1>
        <div class="mt-5">
            <div class="text-center">
                <img id="qrImg" width="250" class="img-fluid" src="" alt="qr code img not found">
            </div>
            <form id="2FAFrom" action="" class="my-4">
                <div class="input-group">
                    <input name="2fA_code" type="text" placeholder="enter the code shown on your mobile" class="form-control py-3" id="2FACode">
                    <input type="submit" value="verify" class="btn main-btn-orange px-4">
                </div>
                <small id="finalErrorMessage" class="error-msg"></small>
            </form>
            <h2 class="fs-4 fw-semibold"> Follow these simple steps:</h2>
            <ul>
                <li><span class="fw-semibold">Scan the QR Code:</span> Open the Google Authenticator app on your mobile device and use it to scan the QR code displayed here.</li>
                <li><span class="fw-semibold">Enter the Code:</span> Once the QR code is scanned, your app will generate a unique code. Enter this code in the input field below to complete the setup.</li>
            </ul>

        </div>
    </main>
    <script src="../assets/scripts/2FA.js"></script>
    <!-- Bootstrap JavaScript Libraries -->
    <script
        src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"
        integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r"
        crossorigin="anonymous"></script>

    <script
        src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js"
        integrity="sha384-BBtl+eGJRgqQAUMxJ7pMwbEyER4l1g+O15P+16Ep7Q9Q+zqX6gSbd85u4mG4QzX+"
        crossorigin="anonymous"></script>
</body>

</html>