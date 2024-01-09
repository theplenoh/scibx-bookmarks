<?php
require_once "common.php";
include_once "simple-html-dom-parser/simple_html_dom.php";

function get_page_title($url)
{
    $html = file_get_html($url);

    $title = $html->find('title', 0)->innertext;

    if (mb_detect_encoding($title, "UTF-8, EUC-KR") == "EUC-KR")
        $title = iconv("EUC-KR", "UTF-8", $title);

    return $title;
}

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
$title = sanitize(get_page_title($URL));
$time = date("Y-m-d H:i:s", time());
$publicity = "private";

$query = "INSERT INTO bookmarks_entries (URL, title, time, publicity) VALUES('{$URL}', '{$title}', '{$time}', '{$publicity}')";

mysqli_query($conn, $query);
mysqli_close($conn);

header("Location: list.php");
?>
