<?php
if (!$_SESSION['loggedin']) {
 header('location: /phpmotors/');
 exit;
}
?><!DOCTYPE html>
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
    <title>Account Management | PHP Motors</title>
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
            <h1>Manage Account</h1>
            <h2>Update Account</h2>
            <?php
            if (isset($message)) {
                echo $message;
            }
            ?>
            <form action="/phpmotors/accounts/index.php" method="POST">
                <div>
                    <label for="clientFirstname">First Name</label>
                    <input type="text" id="clientFirstname" name="clientFirstname" required <?php if(isset($clientFirstname)){ echo "value='$clientFirstname'"; } elseif(isset($invInfo['clientFirstname'])) {echo "value='$invInfo[clientFirstname]'"; }?>>
                </div>

                <div>
                    <label for="clientLastname">Last Name</label>
                    <input type="text" id="clientLastname" name="clientLastname" required <?php if(isset($clientLastname)){ echo "value='$clientLastname'"; } elseif(isset($invInfo['clientLastname'])) {echo "value='$invInfo[clientLastname]'"; }?>>
                </div>
                <div>
                    <label for="clientEmail">Email</label>
                    <input type="email" id="clientEmail" name="clientEmail" required <?php if(isset($clientEmail)){ echo "value='$clientEmail'"; } elseif(isset($invInfo['clientEmail'])) {echo "value='$invInfo[clientEmail]'"; }?>>
                </div>
                <input type="hidden" name="action" value="updateClient">
                <button class= "primary" type="submit">Update Info</button>
            </form>
            <h2>Update Password</h2>
            <span>Passwords must be at least 8 characters and contain at least 1 number, 1 capital letter and 1 special character</span> <br>
            <span>*note your original password will be changed</span>
            <br>
            <br>
            <form action="/phpmotors/accounts/index.php" method="POST">
                <div>
                    <label for="clientPassword">Password</label>
                    <input type="password"  name="clientPassword" id="clientPassword" required pattern="(?=^.{8,}$)(?=.*\d)(?=.*\W+)(?![.\n])(?=.*[A-Z])(?=.*[a-z]).*$">
                </div>
                <input type="hidden" name="action" value="updatePassword">
                <button class= "primary" type="submit">Update Password</button>
            </form>

        </main>
        <footer>
            <?php require $_SERVER['DOCUMENT_ROOT'] . '/phpmotors/common/footer.php'; ?>
        </footer>
    </div>
</body>

</html>