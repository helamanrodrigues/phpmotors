<?php
if ($_SESSION['loggedin'] != TRUE) {
    header('Location: /phpmotors/');
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <link href="/phpmotors/css/normalize.css" rel="stylesheet">
    <link href="/phpmotors/css/small.css" rel="stylesheet">
    <link href="/phpmotors/css/medium.css" rel="stylesheet">
    <link href="/phpmotors/css/large.css" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Exo&display=swap" rel="stylesheet">
    <title>PHP Motors | Admin</title>
</head>

<body>
    <div id="container">
        <header>
            <?php require $_SERVER['DOCUMENT_ROOT'] . '/phpmotors/common/header.php'; ?>
        </header>
        <nav>
            <?php echo $navList;?>
        </nav>
        <main>
            <h1><?php echo $_SESSION['clientData']['clientFirstname'] . ' ' . $_SESSION['clientData']['clientLastname']; ?></h1>
            <?php
            if (isset($_SESSION['message'])) {
                echo $_SESSION['message'];
            }
            ?>
            <p>You are logged in.</p>
            <ul>
                <li>First Name: <?php echo $_SESSION['clientData']['clientFirstname'] ?> </li>
                <li>Last Name: <?php echo $_SESSION['clientData']['clientLastname'] ?> </li>
                <li>Email Address: <?php echo $_SESSION['clientData']['clientEmail'] ?> </li>
            </ul>
            <h3>Account Manager</h3>
            <p>Use this link to update account information</p>
            <a href="/phpmotors/accounts?action=client">Update Account Information</a>
            <br>
            <?php 
                if($_SESSION['clientData']['clientLevel']>1){
                    echo '<h3>Inventory Manager</h3>
                    <p>Use this link to manage the inventory</p>
                    <a href="/phpmotors/vehicles">Vehicle Managment</a>';   
                }
            ?>
            <h3>Manage Your Products Review</h3>
            <ul>
            <?php echo $reviewsDisplay; ?>
            </ul>
        </main>
        <footer>
            <?php require $_SERVER['DOCUMENT_ROOT'] . '/phpmotors/common/footer.php'; ?>
        </footer>
    </div>
</body>

</html>