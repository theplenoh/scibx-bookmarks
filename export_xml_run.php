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
$xml = "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";
$xml .= "<bookmarks>\n";

while($record = mysqli_fetch_array($result, MYSQLI_NUM))
{
    $entry['URL'] = $record[0];
    $entry['title'] = $record[1];
    $entry['note'] = $record[2];
    $entry['tags'] = $record[3];
    $tag_string = $entry['tags'];
    $tags = explode(",", $tag_string);
    $entry['time'] = $record[4];
    $entry['publicity'] = ($record[5] == "public")? "public":"private";

    $xml .= "<entry>\n";

    foreach($entry as $attrib => $content)
    {
        $xml .= "  <{$attrib}>";
        if($attrib == "tags")
        {
            $xml .= "\n  ";
            foreach($tags as $tagname => $tag_content)
            {
                if(trim($content) != "")
                {
                    $xml .= "  <tag>";
                    $xml .= sanitize($tag_content);
                    $xml .= "</tag>\n  ";
                }
            }
        }
        else
        {
            $xml .= sanitize($content);
        }
        $xml .= "</{$attrib}>\n";
    }

    $xml .= "</entry>\n";
}

$xml .= "</bookmarks>";

echo(htmlentities($xml));
?>
            </pre>
            <p>
<?php
$datetime = date("Ymd-His", time());

$filename = "backups/backup-bookmarks-{$datetime}.xml";

$filepath = $filename;

$fp = fopen($filepath, "w");

if($fp == false)
{
    echo "Error in opening a file";
    exit;
}
fwrite($fp, $xml);
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
