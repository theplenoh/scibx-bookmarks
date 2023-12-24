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
            <h1>Migration</h1>
            <section>
                <h2>XML Export</h2>
                <p>
                    <a class="btn btn-primary" href="export_xml_run.php">Run!</a>
                </p>
            </section>
            <section>
                <h2>XML Import</h2>
                <form method="post" action="import_xml_confirm.php">
<?php
$path = __DIR__.'/backups';
$files = scandir($path);
$files = array_diff(scandir($path), array('.', '..'));
?>
                    <select name="backup-file" class="custom-select mb-2">
                        <option selected>Choose your backup file</option>
<?php
foreach($files as $idx => $filename)
{
    if(pathinfo($filename, PATHINFO_EXTENSION) === "xml")
    {
?>
                        <option value="<?php echo $filename; ?>"><?php echo $filename; ?></option>
<?php
    }
}
?>
                    </select>
                    <p>
                        <input type="submit" value="Select" class="btn btn-primary">
                    </p>
                </form>
            </section>
            <section>
                <h2>Netscape .html Export</h2>
                <p>
                    <a class="btn btn-primary" href="export_netscape_run.php">Run!</a>
                </p>
            </section>
            <section>
                <h2>Netscape .html Import</h2>
                <form method="post" action="import_netscape_confirm.php">
<?php
$path = __DIR__.'/backups';
$files = scandir($path);
$files = array_diff(scandir($path), array('.', '..'));
?>
                    <select name="backup-file" class="custom-select mb-2">
                        <option selected>Choose your backup file</option>
<?php
foreach($files as $idx => $filename)
{
    if(pathinfo($filename, PATHINFO_EXTENSION) === "html")
    {
?>
                        <option value="<?php echo $filename; ?>"><?php echo $filename; ?></option>
<?php
    }
}
?>
                    </select>
                    <p>
                        <input type="submit" value="Select" class="btn btn-primary">
                    </p>
                </form>
            </section>
        </div>
    </div>
</div>
<script crossorigin="anonymous" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script crossorigin="anonymous" integrity="sha384-Piv4xVNRyMGpqkS2by6br4gNJ7DXjqk09RmUpJ8jgGtD7zP9yug3goQfGII0yAns" src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
