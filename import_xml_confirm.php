<?php
require_once "common.php";

session_start();

if(!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true)
{
$message = "로그인을 해주세요.";
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
            <h1>XML Import Preview</h1>
            <form method="post" action="import_xml_run.php">
                <p>
<?php
set_time_limit(0);

$filename = $_POST['backup-file'];
?>
<?php
$xml = simplexml_load_file("backups/{$filename}") or die("Error: cannot create object");
echo "Backup filename: backups/{$filename}";
?>
                </p>
                <pre class="result">
<?php
$entry_cnt = count($xml->entry);
$idx = 0;
for($idx; $idx < $entry_cnt; $idx++)
{
    $URL = ($xml->entry[$idx]->URL);
    $title = ($xml->entry[$idx]->title);
    $note = ($xml->entry[$idx]->note);
    $tags = implode(",", (array)$xml->entry[$idx]->tags->tag);
    $time = $xml->entry[$idx]->time;
    $publicity = ($xml->entry[$idx]->publicity)=="public"? "public":"private";

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
            </form>
        </div>
    </div>
</div>
<script crossorigin="anonymous" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script crossorigin="anonymous" integrity="sha384-Piv4xVNRyMGpqkS2by6br4gNJ7DXjqk09RmUpJ8jgGtD7zP9yug3goQfGII0yAns" src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
