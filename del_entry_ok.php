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

$entryID = $_GET['entryID'];

mysqli_query($conn, "DELETE FROM bookmarks_entries WHERE entryID='{$entryID}'");
echo<<<EOT
<script>
alert("삭제되었습니다.");
location.href="index.php";
</script>
EOT;
?>
