    <nav class="navbar navbar-expand-sm bg-dark navbar-dark">
        <a class="navbar-brand mr-auto" href="index.php"><img src="images/bookmark-256.png" alt="Bookmarks" class="logo"></a>
<?php
if(isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true)
{
?>
        <form class="mx-2" action="search.php">
            <input class="form-control" type="text" name="keyword" placeholder="Search">
        </form>
<?php
}
?>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#collapsibleNavbar">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse flex-grow-0" id="collapsibleNavbar">
            <ul class="navbar-nav">
<?php
if(!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true)
{
?>
                <li class="nav-item"><a class="nav-link" href="login.php">Login</a></li>
<?php
}
else
{
?>
                <li class="nav-item"><a class="nav-link" href="logout.php">Logout</a></li>
<?php
}
?>
            </ul>
        </div>
    </nav>
