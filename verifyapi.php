<?php
header('Content-type:application/json');
header('Access-Control-Allow-Origin:*');

$secretKey = '6LcCewMrAAAAAH3kfOBaC8DvNgyGeY28UXV682at';

$recaptchaResponse = $_POST['g-recaptcha-response'] ?? null;


if (empty($recaptchaResponse)) {
    echo json_encode(array('message' => 'API key or reCAPTCHA response is missing', 'status' => false));
    exit();
}

$verifyUrl = 'https://www.google.com/recaptcha/api/siteverify';
$response = file_get_contents($verifyUrl . '?secret=' . $secretKey . '&response=' . $recaptchaResponse);
$responseKeys = json_decode($response, true);


if ($responseKeys["success"]) {
    echo json_encode(array('message' => 'You are human!', 'status' => true));
} else {
    echo json_encode(array('message' => 'Invalid reCAPTCHA, please try again.', 'status' => false));
}
?>
