<?php
/*** default ***/
// Encoding
header("Content-Type: text/html; charset=utf-8");

// Display errors
error_reporting(E_ALL);
ini_set("display_errors", 1);

/*** lib ***/
function sanitize($text)
{
    return htmlspecialchars(addslashes($text ?? ''));
}
function unsanitize($text)
{
    return stripslashes(htmlspecialchars_decode($text));
}

function filter($text)
{
    // <https://stackoverflow.com/questions/4144837/auto-link-urls-in-a-string>
    $text = preg_replace('/((http|https):\/\/[\w-]+(\.[\w-]+)+([\w.,@?^=%&amp;:\/~+#-]*[\w@?^=%&amp;\/~+#-])?)/', '<a href="\1">\1</a>', $text);

    return nl2br($text);
}

function get_day($date, $locale)
{
    $days_en = ['SUN', 'MON', 'TUE', 'WED', 'THU', 'FRI', 'SAT'];
    $days_ko = ['일', '월', '화', '수', '목', '금', '토'];

    if($locale == "en")
    {
        return $days_en[date('w', strtotime($date))];
    }
    elseif($locale == "ko")
    {
        return $days_ko[date('w', strtotime($date))];
    }
}

function encrypt_cookie($value)
{
    $key = bin2hex(openssl_random_pseudo_bytes(4));

    $method = "aes-256-cbc";
    $ivlen = openssl_cipher_iv_length($method);
    $iv = openssl_random_pseudo_bytes($ivlen);

    $ciphertext = openssl_encrypt($value, $method, $key, $options=0, $iv);

    return base64_encode($ciphertext."::".$iv."::".$key);
}

function decrypt_cookie($ciphertext)
{
    $cipher = "aes-256-cbc";

    list($encrypted_data, $iv, $key) = explode("::", base64_decode($ciphertext));

    return openssl_decrypt($encrypted_data, $cipher, $key, 0, $iv);
}

$expiry_period = 30;

/*** database ***/
require_once "config/dbinfo.php";
$db_prefix = DB_PREFIX;

$conn = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);
mysqli_query($conn, "SET NAMES utf8mb4");
?>
