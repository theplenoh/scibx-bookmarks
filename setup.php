<!DOCTYPE html>
<html lang="ko">
<head>
    <meta charset="utf-8">
    <title>Scibx Bookmarks Installation</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>
<body>
    <h1>Scibx Bookmarks Installation</h1>
    <section>
        <h2>1. MySQL Database Info.</h2>
        <form method="post" action="setup_ok.php">
        <dl>
            <dt>DB server</dt>
            <dd><input type="text" name="db_server"></dd>
            <dt>Username</dt>
            <dd><input type="text" name="db_username"></dd>
            <dt>Password</dt>
            <dd><input type="password" name="db_password"></dd>
            <dt>DB name</dt>
            <dd><input type="text" name="db_database"></dd>
            <dt>Table prefix</dt>
            <dd><input type="text" name="db_prefix" value="bookmarks_"></dd>
        </dl>
        <h2>2. User account Info.</h2>
        <dl>
            <dt>Username</dt>
            <dd><input type="text" name="account_username"></dd>
            <dt>Password</dt>
            <dd><input type="password" name="account_password"></dd>
            <dt>Screen name</dt>
            <dd><input type="text" name="account_screenname"></dd>
        </dl>
        <p>
            <input type="submit" value="Submit">
        </p>
        </form>
    </section>
</body>
</html>
