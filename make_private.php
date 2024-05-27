<?php
require "common.php";

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

mysqli_query($conn, "UPDATE bookmarks_entries SET publicity = 'private' WHERE entryID={$entryID}");

header("Location: list_public.php");
?>
