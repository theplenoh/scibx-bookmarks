<?php
require_once 'common.php';
require_once 'netscape-bookmark-parser/NetscapeBookmarkParser.php';

$parser = new NetscapeBookmarkParser();
//$bookmarks = $parser->parseFile('./tests/input/netscape_basic.htm');
//$bookmarks = $parser->parseFile('/home/plenoh/Bookmarks-firefox.html');
//$bookmarks = $parser->parseFile('/home/plenoh/Bookmarks-margarin.html');
//$bookmarks = $parser->parseFile('/home/plenoh/Bookmarks.html');
//$bookmarks = $parser->parseFile('./tests/input/firefox_nested.htm');
?>
<pre>
<?php
$total = count($bookmarks);
$idx = $total - 1;
for($idx; $idx >= 0; $idx--)
{
    //var_dump($bookmarks[$total - $idx]);
    $URL = $bookmarks[$idx]['uri'];
    $title = $bookmarks[$idx]['title'];
    $note = $bookmarks[$idx]['note'];
    $tags = str_replace(' ',',',$bookmarks[$idx]['tags']);
    $time = date('Y-m-d H:i:s', $bookmarks[$idx]['time']);
    $publicity = ($bookmarks[$idx]['pub'])? "public":"private";

    $query = "INSERT INTO bookmarks_entries (URL, title, note, tags, time, publicity) VALUES('{$URL}', '{$title}', '{$note}', '{$tags}', '{$time}', '{$publicity}')";

    echo "[$idx]".$query."\n";
    mysqli_query($conn, $query);
}
mysqli_close($conn);
?>
</pre>
