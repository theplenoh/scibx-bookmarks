<?php
require_once "common.php";

session_start();

if(!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true)
{
$message = "Please log in.";
echo<<<EOT
<script>
alert("{$message}");
location.href="login.php";
</script>
EOT;
exit;
}

$entryID = $_GET['entryID'];

$query = "UPDATE bookmarks_entries SET pinned = 1 where entryID = {$entryID}";

mysqli_query($conn, $query);

header("Location: index.php");
?>
