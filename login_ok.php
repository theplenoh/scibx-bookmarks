<?php
require_once "common.php";

$username = @trim($_POST['username']);
$password = @trim($_POST['password']);
$rememberme = (isset($_POST['rememberme']) && $_POST['rememberme'] == 1)? true:false;

session_start();

if(isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true)
{
$message = "You are already logged in.";
echo<<<EOT
<script>
alert("{$message}");
location.href="index.php";
</script>
EOT;
exit;
}

if(empty($username) || empty($password))
{
$message = "Please enter your username and the password.";
echo<<<EOT
<script>
alert("{$message}");
location.href="login.php";
</script>
EOT;
exit;
}

$username = sanitize($username);
$password = sanitize($password);

$query = "SELECT userID, username, password FROM bookmarks_auth WHERE username=?";
$stmt = mysqli_prepare($conn, $query);
mysqli_stmt_bind_param($stmt, "s", $param_username);
$param_username = $username;

mysqli_stmt_execute($stmt);
mysqli_stmt_store_result($stmt);

mysqli_stmt_bind_result($stmt, $userID, $username, $hashed_password);
mysqli_stmt_fetch($stmt);

if(mysqli_stmt_num_rows($stmt) == 1 && password_verify($password, $hashed_password))
{
    if($rememberme)
    {
        $value = encrypt_cookie($userID);
        setcookie("rememberme", $value, time()+($expiry_period*24*60*60));
    }

    $_SESSION['loggedin'] = true;

    $message = "Successfully logged in!";
    echo<<<EOT
    <script>
    //alert("{$message}");
    location.href="list.php";
    </script>
    EOT;
    exit;
}
else
{
    $message = "Invalid username or password!";
    echo<<<EOT
    <script>
    alert("{$message}");
    location.href="login.php";
    </script>
    EOT;
    exit;
}
?>
