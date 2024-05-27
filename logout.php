<?php
require_once "common.php";

session_start();

$_SESSION = array();

session_destroy();

setcookie("rememberme", "", time()-($expiry_period*24*60*60));

echo<<<EOT
<script>
alert("You are logged out.");
location.href="index.php";
</script>
EOT;
?>
