<?php
require_once "common.php";

session_start();

if(!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true)
{
    echo<<<EOT
<script>
alert("로그인이 안된 상태입니다.\\n로그인 페이지로 이동합니다.");
location.href="login.php";
</script>
EOT;
exit;
}

$flag_loggedin = false;
if(isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true)
    $flag_loggedin = true;

$URL = $_POST['URL'];
$title = sanitize($_POST['title']);
$note = $_POST['note'];
$time = date("Y-m-d H:i:s", time());
$publicity = "private";

$query = "INSERT INTO bookmarks_entries (URL, title, note, time, publicity) VALUES('{$URL}', '{$title}', '{$note}', '{$time}', '{$publicity}')";

mysqli_query($conn, $query);
mysqli_close($conn);

header("Location: list.php");
?>
