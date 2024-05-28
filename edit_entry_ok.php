<?php
require_once "common.php";

session_start();

if(!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true)
{
    echo<<<EOT
<script>
alert("You are not logged in.\\nRedirected to the login page.");
location.href="login.php";
</script>
EOT;
exit;
}

$flag_loggedin = false;
if(isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true)
    $flag_loggedin = true;

$entryID = $_GET['entryID'];
$URL = $_POST['URL'];
$title = $_POST['title'];
$note = $_POST['note'];

mysqli_query($conn, "UPDATE bookmarks_entries SET URL='{$URL}', title='{$title}', note='{$note}' WHERE entryID = {$entryID}");
echo<<<EOT
<script>
alert("Successfully Edited!");
location.href="list.php";
</script>
EOT;
?>
