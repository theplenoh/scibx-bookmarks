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
<html lang="ko">
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
<?php
$query = "SELECT URL, title, note, tags, time, publicity FROM bookmarks_entries ORDER BY time";
$result = mysqli_query($conn, $query);
?>
            <h1>Export Result</h1>
            <pre class="result">
<?php
$curr_time = time();

$netscape_html = "<!DOCTYPE NETSCAPE-Bookmark-file-1>\n";
$netscape_html .= "<!-- This is an automatically generated file.
     It will be read and overwritten.
     DO NOT EDIT! -->\n";
$netscape_html .= "<META HTTP-EQUIV=\"Content-Type\" CONTENT=\"text/html; charset=UTF-8\">\n";
$netscape_html .= "<TITLE>Bookmarks</TITLE>\n";
$netscape_html .= "<H1>List of Bookmarks</H1>\n";
$netscape_html .= "\n";
$netscape_html .= "<DL><p>\n";
$netscape_html .= "    <DT><H3 ADD_DATE=\"{$curr_time}\" LAST_MODIFIED=\"{$curr_time}\">Scibx Bookmarks</H3>\n";
$netscape_html .= "    <DL><p>\n";

while($record = mysqli_fetch_array($result, MYSQLI_NUM))
{
    $entry['URL'] = $record[0];
    $entry['title'] = $record[1];
    $entry['note'] = $record[2];
    $entry['tags'] = $record[3];
    $entry['timestamp'] = strtotime($record[4]);
    $entry['publicity'] = ($record[5] == "public")? "PUBLIC":"PRIVATE";

    $netscape_html .= "        <DT><A HREF=\"{$entry['URL']}\" ADD_DATE=\"{$entry['timestamp']}\" LAST_MODIFIED=\"{$entry['timestamp']}\" SHORTCUTURL=\"{$entry['tags']}\" TAGS=\"{$entry['tags']}\" PUBLICITY=\"{$entry['publicity']}\">{$entry['title']}</A>\n";
    $netscape_html .= "        <DD>{$entry['note']}\n";
}

$netscape_html .= "</DL><p>\n";
$netscape_html .= "</DL>";

echo(htmlentities($netscape_html));
?>
            </pre>
            <p>
<?php
$datetime = date("Ymd-His", time());

$filename = "backups/backup-Bookmarks-{$datetime}.html";

$filepath = $filename;

$fp = fopen($filepath, "w");

if($fp == false)
{
    echo "Error in opening a file";
    exit;
}
fwrite($fp, $netscape_html);
fclose($fp);

echo "<code>{$filepath}</code> generated.";
?>
            </p>
        </div>
    </div>
</div>
<script crossorigin="anonymous" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script crossorigin="anonymous" integrity="sha384-Piv4xVNRyMGpqkS2by6br4gNJ7DXjqk09RmUpJ8jgGtD7zP9yug3goQfGII0yAns" src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
