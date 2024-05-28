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
?>
<!DOCTYPE html>
<html>
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
            <h1>XML Import Execution</h1>
            <p>
                Please do not leave the web page or take any actions before the import is complete.
            </p>
<?php
set_time_limit(0);

require_once "netscape-bookmark-parser/NetscapeBookmarkParser.php";
$parser = new NetscapeBookmarkParser();

$filename = $_POST['backup-file'];
$bookmarks = $parser->parseFile("backups/{$filename}") or die("Parser Error");
?>
            <pre class="result">
<?php
$entry_cnt = count($bookmarks);
$idx = 0;

for($idx; $idx < $entry_cnt; $idx++)
{
    $URL = $bookmarks[$idx]['uri'];
    $title = sanitize($bookmarks[$idx]['title']);
    $note = sanitize($bookmarks[$idx]['note']);
    $tags = str_replace(' ',',',$bookmarks[$idx]['tags']);
    $time = date('Y-m-d H:i:s', $bookmarks[$idx]['time']);
    $publicity = ($bookmarks[$idx]['pub'])? "public":"private";

    $query = "INSERT INTO bookmarks_entries (URL, title, note, tags, time, publicity) VALUES('{$URL}', '{$title}', '{$note}', '{$tags}', '{$time}', '{$publicity}')";

    echo "[$idx]".$query."\n";

    if(!mysqli_query($conn, $query))
    {
        echo "Error [$idx]: ".mysqli_error($conn)."\n";
    }

}
mysqli_close($conn);
?>
            </pre>
            <p>
                Import complete!
            </p>
        </div>
    </div>
</div>
<script crossorigin="anonymous" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script crossorigin="anonymous" integrity="sha384-Piv4xVNRyMGpqkS2by6br4gNJ7DXjqk09RmUpJ8jgGtD7zP9yug3goQfGII0yAns" src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
