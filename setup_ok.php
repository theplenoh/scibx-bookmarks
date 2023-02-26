<?php
$success_cnt = 0;
?>
<?php
/*** default ***/
// Encoding
header("Content-Type: text/html; charset=utf-8");

// Display errors
error_reporting(E_ALL);
ini_set("display_errors", 1);
?>
<h1>Scibx Bookmarks Installation Result</h1>
<?php
// if file(dbinfo.php) exists
if (file_exists("config/dbinfo.php"))
{
    echo "<p><code>config/dbinfo.php</code> file already exists.</p>";
    exit;
}

// if the permission info of directories(`config/`, `backups/`) don't match
if (substr(sprintf('%o', fileperms('config/')), -4) != "0707")
{
    echo "<p>Adjust the directory permission of <code>config/</code> to <code>0707</code>.</p>";
    exit;
}
if (substr(sprintf('%o', fileperms('backups/')), -4) != "0707")
{
    echo "<p>Adjust the directory permission of <code>backups/</code> to <code>0707</code>.</p>";
    exit;
}
?>
<?php
/*** lib ***/
function sanitize($text)
{
    return htmlentities(addslashes($text));
}
?>
<?php
$db_server = sanitize(trim($_POST['db_server']));
$db_username = sanitize(trim($_POST['db_username']));
$db_password = sanitize(trim($_POST['db_password']));
$db_database = sanitize(trim($_POST['db_database']));
$db_prefix = sanitize(trim($_POST['db_prefix']));

$account_username = sanitize(trim($_POST['account_username']));
$account_password = sanitize(trim($_POST['account_password']));
$account_screenname = sanitize(trim($_POST['account_screenname']));
?>
<?php
if (empty($db_server) || empty($db_username) || empty($db_password) || empty($db_database) || empty($db_prefix))
{
    echo "<p>Please go back and enter all values concerning database info.</p>";
    exit;
}

if (empty($account_username) || empty($account_password) || empty($account_screenname))
{
    echo "<p>Please go back and enter all values concerning user account info.</p>";
    exit;
}
?>
<?php
$tablename_auth = $db_prefix."auth";
$tablename_entries = $db_prefix."entries";

$conn = mysqli_connect($db_server, $db_username, $db_password, $db_database);
mysqli_query($conn, "SET NAMES utf8");

// if DB tables exist
if (mysqli_query($conn, "SELECT 1 FROM {$tablename_auth} LIMIT 1") !== FALSE)
{
    echo "<p>The table <code>{$tablename_auth}</code> already exists.</p>";
    exit;
}
if (mysqli_query($conn, "SELECT 1 FROM {$tablename_entries} LIMIT 1") !== FALSE)
{
    echo "<p>The table <code>{$tablename_entries}</code> already exists.</p>";
    exit;
}
?>
<?php
// Create `dbinfo.php` file
$dbinfo = <<<EOT
<?php
define('DB_SERVER', '{$db_server}');
define('DB_USERNAME', '{$db_username}');
define('DB_PASSWORD', '{$db_password}');
define('DB_NAME', '{$db_database}');
define('DB_PREFIX', '{$db_prefix}');
?>
EOT;

$filename = "config/dbinfo.php";
$fp = fopen($filename, "w");

if($fp == false)
{
    echo "Error in opening a new file.";
    exit;
}
fwrite($fp, $dbinfo);
fclose($fp);

echo "<code>$filename</code> file generated.";
$success_cnt++;
?>
<?php

// Create DB Tables `_auth`, `_entries`
$query = <<<SQL
CREATE TABLE {$tablename_auth} (
    userID int(11) NOT NULL AUTO_INCREMENT,
    username varchar(15) NOT NULL UNIQUE,
    password varchar(255) NOT NULL,
    screenname varchar(45) NOT NULL,
    PRIMARY KEY(userID)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
SQL;
if (mysqli_query($conn, $query))
{
    echo "<p>The table <code>{$tablename_auth}</code> created.</p>";
}
$success_cnt++;
$query = <<<SQL
CREATE TABLE {$tablename_entries} (
    entryID int(11) NOT NULL AUTO_INCREMENT,
    URL text NOT NULL,
    title text NOT NULL,
    note text,
    tags varchar(255),
    category varchar(45),
    subcategory varchar(45),
    time varchar(19),
    publicity varchar(15) NOT NULL,
    PRIMARY KEY(entryID)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
SQL;
if (mysqli_query($conn, $query))
{
    echo "<p>The table <code>{$tablename_entries}</code> created.</p>";
}
$success_cnt++;

$query = "INSERT INTO {$tablename_auth} (username, password, screenname) VALUES (?, ?, ?)";

$stmt = mysqli_prepare($conn, $query);

mysqli_stmt_bind_param($stmt, "sss", $param_username, $param_password, $param_screenname);

$param_username = $account_username;
$param_password = password_hash($account_password, PASSWORD_DEFAULT);
$param_screenname = $account_screenname;

mysqli_stmt_execute($stmt);

mysqli_stmt_close($stmt);

echo "<p>User <strong>{$account_screenname}</strong> record inserted!</p>";
$success_cnt++;
mysqli_close($conn);

if ($success_cnt == 4)
    echo "<p>Installation Successful!</p>";
?>
