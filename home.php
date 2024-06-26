<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <link rel="stylesheet" href="css/home.css" />
    <link rel="shortcut icon" type="x-icon" href="images/tab.png" />
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" />
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>JobOnCampus</title>
</head>

<body>
    <header>
        <a href="home.php">
            <img class="logo" src="images/jobOnCampusBlack.png" alt="logo" /></a>
        <nav>
            <ul class="nav_links">
                <li><a href="careers.php">Careers</a></li>
                <?php if (isset($_SESSION['userID'])): ?>
                    <li><a href="applications.php">Applications</a></li>
                <?php endif; ?>
                <li><a href="request.php">Job Requests</a></li>
            </ul>
        </nav>
        <?php if (isset($_SESSION['userID'])): ?>
            <a class="cta" href="scripts/logout.php"><button>Log Out</button></a>
        <?php else: ?>
            <a class="cta" href="index.php"><button>Log In</button></a>
        <?php endif; ?>
    </header>
    <div class="header__title">
        <section class="header-content">
            <h1>
                Work, <span class="highlight">learn,</span> thrive. <br />
            </h1>
            <h4>Discover Your Potential with Campus Jobs</h4>
        </section>
    </div>
</body>

</html>