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

$keyword = $_GET['keyword'];

if(!isset($_GET['page_num']))
    $page_num = 1;
else
    $page_num = $_GET['page_num'];

$page_size = 20;
$page_scale = 5;

$result = mysqli_query($conn, "SELECT COUNT(*) FROM bookmarks_entries WHERE title LIKE '%{$keyword}%' or note LIKE '%{$keyword}%' ORDER BY time DESC;");
$total = mysqli_fetch_array($result)[0];

$page_max = ceil($total / $page_size);
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
<?php
?>
<div class="container">
    <div class="row">
        <div class="col-xs-12 w-100 p-3">
            <h1>Search Result</h1>
<?php
{
    $offset = ($page_num - 1) * $page_size;

    $block = floor(($page_num - 1) / $page_scale);;

    $query = "SELECT * FROM bookmarks_entries WHERE title LIKE '%{$keyword}%' or note LIKE '%{$keyword}%' ORDER BY time DESC LIMIT {$offset}, {$page_size};";
    $result = mysqli_query($conn, $query);
?>
<p>You have found <?=$total?> entries using the keyword <code><?=$keyword?></code>.</p>
<?php
    while($entry = mysqli_fetch_array($result))
    {
        $entryID = $entry['entryID'];
        $title = $entry['title'];
        $URL = $entry['URL'];
        $datetime = $entry['time'];
        $tag_string = $entry['tags'];
        $tags = explode(",", $tag_string);
        $note = $entry['note'];
        $publicity = $entry['publicity'];
?>
            <section class="card my-2">
                <div class="card-body p-2">
                    <p class="card-title mb-0"><a href="<?php echo $URL; ?>"><?php echo $title; ?></a> <small>(<?=($publicity=='public')? "public":"private"?>)</small></p>
                    <p class="small mb-1"><?php echo $URL; ?></p>
                    <p class="small my-0"><?php echo $note; ?></p>
                    <p class="my-0">
<?php
        foreach($tags as $tag)
        {
?>
                        <span class="badge badge-info"><?php echo $tag; ?></span>
<?php
        }
?>
                    </p>
                    <div class="btn-group btn-group-sm">
                        <a class="btn btn-sm m-0 p-1 px-1" href="edit_entry.php?entryID=<?=$entryID?>">Edit</a>
                        <a class="btn btn-sm m-0 p-1 px-1" href="del_entry.php?entryID=<?=$entryID?>">Delete</a>
                    </div>
                </div>
                <div class="card-footer p-1 px-2 small"><?php echo $datetime; ?></div>
            </section>
<?php
    }
}
?>
<?php
if($total > 0)
{
?>
            <section>
                <ul class="pagination pagination-sm justify-content-center">
                    <li class="page-item">
<?php $prev_block = ($block - 1) * $page_scale + 1; ?>
                        <a class="page-link" href="<?php if($block > 0) { echo "?page_num={$prev_block}&keyword={$keyword}"; } else { echo "javascript:;"; } ?>">&laquo;</a>
                    </li>
                    <li class="page-item">
<?php $prev_page = $page_num - 1; ?>
                        <a class="page-link" href="<?php if($page_max > 1 && $offset != 0 && $page_num && $page_num > 1) { echo "?page_num={$prev_page}&keyword={$keyword}"; } else { echo "javascript:;"; } ?>">&lsaquo;</a>
                    </li>
<?php
    $start_page = $block * $page_scale + 1;
    for($i=1; $i<=$page_scale && $start_page<=$page_max; $i++, $start_page++)
    {
?>
                    <li class="page-item<?php if($start_page == $page_num) { echo " active"; } ?>">
                        <a class="page-link" href="<?php if($start_page == $page_num) { echo "javascript:;"; } else { echo "?page_num={$start_page}&keyword={$keyword}"; }; ?>"><?php echo "{$start_page}"; ?></a>
                    </li>
<?php
    }
?>
                    <li class="page-item">
<?php $next_page = $page_num + 1; ?>
                        <a class="page-link" href="<?php if($page_max > $page_num) { echo "?page_num={$next_page}&keyword={$keyword}"; } else { echo "javascript:;"; } ?>">&rsaquo;</a>
                    </li>
                    <li class="page-item">
<?php $next_block = ($block + 1)*$page_scale + 1; ?>
                        <a class="page-link" href="<?php if($page_max > ($block + 1)*$page_scale) { echo "?page_num={$next_block}&keyword={$keyword}"; } else { echo "javascript:;"; } ?>">&raquo;</a>
                    </li>
                </ul>
            </section>
<?php
}
?>
        </div>
    </div>
</div>
<script crossorigin="anonymous" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script crossorigin="anonymous" integrity="sha384-Piv4xVNRyMGpqkS2by6br4gNJ7DXjqk09RmUpJ8jgGtD7zP9yug3goQfGII0yAns" src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
