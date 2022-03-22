<?php
require_once "common.php";

session_start();

$_SESSION = array();

session_destroy();

echo<<<EOT
<script>
alert("로그아웃 되었습니다.");
location.href="index.php";
</script>
EOT;
?>
