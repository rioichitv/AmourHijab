<?php
function base_url()
{
    if ($_SERVER['HTTP_HOST'] === 'localhost') {
        $base_url = "http://localhost/Amour2025/";
    } else {
        $base_url = ((isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == "on") ? "https" : "http");
        $base_url .= "://" . $_SERVER['HTTP_HOST'];
        $base_url .= "/";
    }

    return $base_url;
}

function base_url_admin()
{
    return base_url() . 'admin/';
}

function cek_login()
{
    if (!isset($_SESSION['id_admin'])) {
        $admin = base_url_admin();
        header("location:" . $admin . "login.php");
    }
}

function generateUniqueCode()
{
    $characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
    $code       = 'AMOUR-';

    // Add current timestamp (UNIX timestamp) to the code
    $timestamp = time();
    $code .= strtoupper(base_convert($timestamp, 10, 36)); // Convert timestamp to base36

    // Generate the remaining characters
    $remainingLength = 16 - strlen($code);
    for ($i = 0; $i < $remainingLength; $i++) {
        $code .= $characters[rand(0, strlen($characters) - 1)];
    }

    return $code;
}
?>