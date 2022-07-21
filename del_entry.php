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
?>
<!DOCTYPE html>
<html lang="ko">
<head>
    <?php require_once "head.inc.php"; ?>
</head>

<body>
<header>
<?php require_once "nav.inc.php"; ?>
</header>
<div class="container">
    <div class="row">
        <div class="col-xs-12 w-100 p-3">
            <h1>Delete an Entry</h1>
            <p>Do you really wish to delete the entry?</p>
            <div>
                <a class="btn btn-danger" href="del_entry_ok.php?entryID=<?=$entryID?>">Delete</a>
                <a class="btn btn-secondary" href="list.php">Cancel</a>
            </div>
        </div>
    </div>
</div>
</body>
</html>
