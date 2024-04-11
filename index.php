<?php
require_once "common.php";

session_start();

$flag_loggedin = false;
if(isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true)
    $flag_loggedin = true;

if(!$flag_loggedin)
    header("Location: list_public.php");
else
    header("Location: list.php");

exit;
?>
