<?php
require_once "common.php";

session_start();

$flag_loggedin = false;
if(isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true)
{
    $flag_loggedin = true;
}
else if(isset($_COOKIE['rememberme']))
{
    $userID = decryptCookie($_COOKIE['rememberme']);

    $query = "SELECT * from bookmarks_auth WHERE userID='{$userID}'";
    $result = mysqli_query($conn, $query);
    $row = mysqli_fetch_array($result);

    $count = mysqli_num_rows($result);

    if($count == 1)
    {
        $_SESSION['loggedin'] = true;
        $flag_loggedin = true;
    }
}

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

$get_URL = htmlspecialchars_decode($_GET['get_URL']);
$get_title = htmlspecialchars_decode($_GET['get_title']);
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
            <h1>Add by Bookmarklet</h1>
            <form action="insert_bookmarklet.php" method="post">
                <div class="form-group">
                    <label for="URL">URL: </label>
                    <input type="text" class="form-control" id="URL" name="URL" value="<?=$get_URL?>">
                </div>
                <div class="form-group">
                    <label for="title">Title: </label>
                    <input type="text" class="form-control" id="title" name="title" value="<?=$get_title?>">
                </div>
                <div class="form-group">
                    <label for="note">Note: </label>
                    <textarea class="form-control" id="note" name="note"></textarea>
                </div>
                <button type="submit" class="btn btn-primary">Add</button>
            </form>
        </div>
    </div>
</div>
<script crossorigin="anonymous" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script crossorigin="anonymous" integrity="sha384-Piv4xVNRyMGpqkS2by6br4gNJ7DXjqk09RmUpJ8jgGtD7zP9yug3goQfGII0yAns" src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
