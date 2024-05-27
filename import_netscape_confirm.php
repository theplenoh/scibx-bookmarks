<?php
require_once "common.php";
require_once "netscape-bookmark-parser/NetscapeBookmarkParser.php";

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
            <h1>Netscape .html Import Preview</h1>
            <form method="post" action="import_netscape_run.php">
                <p>
<?php
set_time_limit(0);

$filename = $_POST['backup-file'];
?>
<?php
$parser = new NetscapeBookmarkParser();

$bookmarks = $parser->parseFile("backups/{$filename}") or die("Parser Error");
echo "Backup filename: backups/{$filename}";
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
}
mysqli_close($conn);
?>
            </pre>
            <p>
                <input type="hidden" name="backup-file" value="<?php echo $filename; ?>">
                <input type="submit" value="Confirm" class="btn btn-danger">
            </p>
        </div>
    </div>
</div>
<script crossorigin="anonymous" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script crossorigin="anonymous" integrity="sha384-Piv4xVNRyMGpqkS2by6br4gNJ7DXjqk09RmUpJ8jgGtD7zP9yug3goQfGII0yAns" src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
