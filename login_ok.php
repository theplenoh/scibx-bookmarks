<?php
require_once "common.php";

$username = @trim($_POST['username']);
$password = @trim($_POST['password']);

session_start();

if(isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true)
{
$message = "이미 로그인 된 상태입니다.";
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
$message = "아이디와 패스워드를 입력해주세요.";
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

$query = "SELECT username, password FROM monologue_auth WHERE username=?";
$stmt = mysqli_prepare($conn, $query);
mysqli_stmt_bind_param($stmt, "s", $param_username);
$param_username = $username;

mysqli_stmt_execute($stmt);
mysqli_stmt_store_result($stmt);

mysqli_stmt_bind_result($stmt, $username, $hashed_password);
mysqli_stmt_fetch($stmt);

if(mysqli_stmt_num_rows($stmt) == 1 && password_verify($password, $hashed_password))
{
    @session_start();

    $_SESSION['loggedin'] = true;

    $message = "로그인에 성공하였습니다.";
    echo<<<EOT
    <script>
    //alert("{$message}");
    location.href="index.php";
    </script>
    EOT;
    exit;
}
else
{
    $message = "유효한 아이디나 패스워드가 아닙니다.";
    echo<<<EOT
    <script>
    alert("{$message}");
    location.href="login.php";
    </script>
    EOT;
    exit;
}
?>
